<?php
namespace Core\Models;
class Category extends Model{

    protected static function getTableName(){
        return 'categories';
    }

}



// INSERT INTO `catigories` (`id`, `name`) VALUES (NULL, 'Мебель'), (NULL, 'Транспорт'); 
// INSERT INTO `catigories` (`id`, `name`) VALUES (NULL, 'TV'), (NULL, 'Phone');

