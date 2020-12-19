<?php
namespace Core\Models;

use Core\Libs\Db;

abstract class Model{
  
    public static function findAll(){

        $pdo = Db::getInstance();
        return  $pdo->query('SELECT * FROM ' . static::getTableName(), [], static::class);// self::class - позднее статическое связывае
    }

    public static function getById($id){

        $pdo = Db::getInstance();
        $result = $pdo->query('SELECT * FROM ' . static::getTableName(). ' WHERE id=:id', ['id'=>$id], static::class);// self::class - позднее статическое связывае
        return $result ? $result[0] : null;
    }

    abstract protected static function getTableName();
}