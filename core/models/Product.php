<?php
namespace Core\Models;
use Core\Controllers\ProductController;

class Product extends Model{

    protected static function getTableName(){
        return 'products';
    }
    
    public static function getCategory(string $nameCateg)
    {
        return Category::getCategId($nameCateg);
    }
}


