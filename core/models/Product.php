<?php
namespace Core\Models;
use Core\Controllers\ProductController;

class Product extends Model{

    protected static function getTableName(){
        return 'products';
    }
    
    public function getCategory()
    {
        return Category::getById($this->category_id);
    }

    public static function getNameFromExel(){
        $table = ProductController::uploadFile();
        $products = $table['name'];
        return $products;
    }
    public static function getDescriptionFromExel(){
        $table = ProductController::uploadFile();
        $products = $table['description'];
        return $products;
    }
    public static function getPriceFromExel(){
        $table = ProductController::uploadFile();
        $products = $table['price'];
        return $products;
    }
    public static function getSkuFromExel(){
        $table = ProductController::uploadFile();
        $products = $table['sku'];
        return $products;
    }

}


