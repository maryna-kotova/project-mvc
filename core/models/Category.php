<?php
namespace Core\Models;
use Core\Controllers\ProductController;


class Category extends Model{

    protected static function getTableName(){
        return 'categories';
    }

    public static function getCategoriesFromExel(){
        $table = ProductController::uploadFile();
        $categories = $table['categories'];
        return $categories;
    }
}



// INSERT INTO `catigories` (`id`, `name`) VALUES (NULL, 'Мебель'), (NULL, 'Транспорт'); 
// INSERT INTO `catigories` (`id`, `name`) VALUES (NULL, 'TV'), (NULL, 'Phone');

