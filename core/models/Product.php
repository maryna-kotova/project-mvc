<?php
namespace Core\Models;
class Product extends Model{

    protected static function getTableName(){
        return 'products';
    }
    public function getCategory()
    {
        return Category::getById($this->category_id);
    }
}


