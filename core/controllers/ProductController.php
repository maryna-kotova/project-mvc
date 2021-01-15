<?php
namespace Core\Controllers;

use Core\Models\Category;
use Core\Models\Product;
use Core\Views\View;
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
 
        return $table;        
    }

    public function addProducts()
    {
        $category = new Category();
        $categoryList = $category->getCategoriesFromExel();
        $categoryFromDB = Category::findAll();        
        $categoriesInDb = [];

        foreach ($categoryFromDB as $key => $value) {
            array_push($categoriesInDb, $value->name);
        }

        $diffCategories = array_diff($categoryList, $categoriesInDb);

        if ( count($diffCategories) > 0  ){
            foreach($diffCategories as $key => $value){
                $category->id = 'NULL';
                $category->name = $value;
                $category->save();
            }
            $this->redirect('/');
        }
        $products = new Product();
       
        $namesProducts        = $products->getNameFromExel();
        $descriptionsProducts = $products->getDescriptionFromExel();
        $pricesProducts       = $products->getPriceFromExel();
        $skuProducts          = $products->getSkuFromExel();       

        $productsDb = Product::findAll();
        if( count($productsDb) > 0 ){
           echo 'Добавьте продукты';
            // $cat = $products->getCategory();

        }else{
  
            for ($i=0; $i < count($namesProducts); $i++) { 
               for ($i=0; $i < count($descriptionsProducts); $i++) { 
                   for ($i=0; $i < count($pricesProducts) ; $i++) { 
                       for ($i=0; $i < count($skuProducts); $i++) { 
                            $products->id          = 'NULL';
                            $products->name        = $namesProducts[$i];
                            $products->description = $descriptionsProducts[$i];
                            $products->price       = $pricesProducts[$i];
                            $products->sku         = $skuProducts[$i];

                            $products->save();
                       }
                   }
               }
            }
            // $this->redirect('/');
        }

        // echo '<pre>';     
        // echo print_r($cat);
        // echo '</pre>';

    }
 

}