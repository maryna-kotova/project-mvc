<?php
namespace Core\Controllers;

use Core\Models\Category;
use Core\Models\Product;
use Core\Views\View;
class ProductController extends Controller{ 

    public static $countAdd = 0;
    public static $countCh = 0;

    public function setCountAdd()
    {
        self::$countAdd++;
        $file = fopen('assets/dataProducts/add.txt', 'w');
        fwrite($file, 'Добавлено товаров: ' . self::$countAdd);
        fclose($file);
    }

    public function setCountCh()
    {
        self::$countCh++;
        $file = fopen('assets/dataProducts/change.txt', 'w');
        fwrite($file, 'Обновлено товаров: ' . self::$countCh);
        fclose($file);
    }

    public function import()
    {
        View::render('products/import');
    }

    public function load()
    {
        if( file_exists ('assets/dataProducts/add.txt') ){
            $this->unlink('assets/dataProducts/add.txt');
        }
        if( file_exists ('assets/dataProducts/change.txt') ){
            $this->unlink('assets/dataProducts/change.txt');
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

        if( !file_exists ('assets/dataProducts/add.txt') ){
            self::$countAdd = 'Добавлено : 0';
        }
        else{
            $fAdd = fopen('assets/dataProducts/add.txt', 'r');
            self::$countAdd = fread($fAdd, filesize('assets/dataProducts/add.txt'));
            fclose($fAdd);
        }

        if( !file_exists ('assets/dataProducts/change.txt') ){
            self::$countCh = 'Обновлено : 0';
        }
        else{
            $fCh = fopen('assets/dataProducts/change.txt', 'r');
            self::$countCh = fread($fCh, filesize('assets/dataProducts/change.txt'));
            fclose($fCh);
        }

        View::render('products/loadfile');
    }

    public function unlink(string $path){
        unlink($path);
    }
 

}