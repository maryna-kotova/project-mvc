<?php

namespace Core\Controllers;

use Core\Models\Category;
use Core\Models\Product;
use Core\Views\View;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class ProductController extends Controller{

    public static $countAdd = 0;
    public static $countCh = 0;

    public function setCountAdd()
    {
        self::$countAdd++;
        $file = fopen('assets/txts/add.txt', 'w');
        fwrite($file, 'Добавлено товаров: ' . self::$countAdd);
        fclose($file);
    }

    public function setCountCh()
    {
        self::$countCh++;
        $file = fopen('assets/txts/change.txt', 'w');
        fwrite($file, 'Обновлено товаров: ' . self::$countCh);
        fclose($file);
    }

    public function import()
    {
        View::render('products/import');
    }

    public function load()
    {
        if( file_exists ('assets/txts/add.txt') ){
            $this->unlink('assets/txts/add.txt');
        }
        if( file_exists ('assets/txts/change.txt') ){
            $this->unlink('assets/txts/change.txt');
        }
        
        $file = $_FILES['file'];  
        $inputFileName = $file['tmp_name'];
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadsheet = $reader->load($inputFileName);
        $dataArray = $spreadsheet->getActiveSheet()->toArray();

        for ($i=1; $i < count($dataArray); $i++) { 
            
            if($dataArray[$i][4]){
                $obj = Category::findOneByColumn('name', $dataArray[$i][4]);
            
                if( !$obj ){
                    Category::insert(['name'=>$dataArray[$i][4]]);
                }
            }
        }

        for ($i=1; $i < count($dataArray); $i++) { 
            if($dataArray[$i][3]){
                $obj = Product::findOneByColumn('sku', $dataArray[$i][3]);
                if( $obj ){
                    Product::update(['id'=>$obj->id,
                                    'name'=>$dataArray[$i][0],
                                    'description'=>$dataArray[$i][1],
                                    'price'=>$dataArray[$i][2],
                                    'sku'=>$dataArray[$i][3],
                                    'category_id'=>Product::getCategory($dataArray[$i][4]),
                                    ]);
                    $this->setCountCh();       
                
                }
                else{
                    Product::insert(['name'=>$dataArray[$i][0],
                                    'description'=>$dataArray[$i][1],
                                    'price'=>$dataArray[$i][2],
                                    'sku'=>$dataArray[$i][3],
                                    'category_id'=>Product::getCategory($dataArray[$i][4]),
                                    ]);
                    $this->setCountAdd();   
                }
            }
        }
        $this->redirect('loadfile');
    }

    public function loadFile(){

        if( !file_exists ('assets/txts/add.txt') ){
            self::$countAdd = 'Добавлено товаров: 0';
        }
        else{
            $fAdd = fopen('assets/txts/add.txt', 'r');
            self::$countAdd = fread($fAdd, filesize('assets/txts/add.txt'));
            fclose($fAdd);
        }

        if( !file_exists ('assets/txts/change.txt') ){
            self::$countCh = 'Обновлено товаров: 0';
        }
        else{
            $fCh = fopen('assets/txts/change.txt', 'r');
            self::$countCh = fread($fCh, filesize('assets/txts/change.txt'));
            fclose($fCh);
        }

        View::render('products/loadfile');
    }

    public function unlink(string $path){
        unlink($path);
    }
}