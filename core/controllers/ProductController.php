<?php
namespace Core\Controllers;

use Core\Models\Category;
use Core\Views\View;
// use Core\Models\Article;

class ProductController extends Controller{ 

    public function import()
    {
        View::render('main/import');
    }

    public static function uploadFile(){     
        $dir = 'uploads';
        $uploadFile = $_FILES['fileProd'];
        $nameUploadFile = $uploadFile['name'];

        if( !file_exists($dir) ){
            mkdir($dir);
        }        
        $saveFileName = time() . '_' . $nameUploadFile; 
        move_uploaded_file($uploadFile['tmp_name'], $dir.'/' . $saveFileName);        

        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($dir.'/' .$saveFileName);
        $worksheets = $spreadsheet->getActiveSheet();        
        // $gets = $worksheets->getCell('A1')->getValue();
        $len = $worksheets->getHighestRow();
        // $titles=[];
        $names=[];
        $description=[];
        $price =[];        
        $sku =[];
        $categories =[];

        for($i=2; $i < $len; $i++ ){
            array_push($names, $worksheets->getCell("A{$i}")->getValue());
            array_push($description, $worksheets->getCell("B{$i}")->getValue());
            array_push($price, $worksheets->getCell("C{$i}")->getValue());
            array_push($sku, $worksheets->getCell("D{$i}")->getValue());
            $val = $worksheets->getCell("E{$i}")->getValue();
            if( in_array($val, $categories) ){
                continue;
            }
            else{
                array_push($categories, $worksheets->getCell("E{$i}")->getValue());
            }
        }
        $table = [
                    'name'       =>$names, 
                    'description'=>$description, 
                    'price'      =>$price, 
                    'sku'        =>$sku, 
                    'categories' =>$categories
                 ];
        // $categories = array_unique($categories);         
        // echo '<pre>';    
        // var_dump($table);  
        // print_r($table);   
        // echo $table['name'][2]; 
        // echo '</pre>';  
        return $table;        
    }
    public function addProducts()
    {
        $category = new Category();
        $categoryList = $category->getCategoriesFromExel();
        foreach($categoryList as $key => $value){
            $category->name = $value;
            $category->name = $value;
            $category->save();
        }
        $this->redirect('/');
    }

}