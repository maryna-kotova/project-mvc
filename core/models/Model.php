<?php
namespace Core\Models;

use Core\Libs\Db;

abstract class Model{
    
    public static function findAll()
        {
            $pdo = Db::getInstance();
            return $pdo->query('SELECT * FROM '.static::getTableName(), [], static::class);//позднее статическое связывание

        }

    public static function getCategId(string $name)
    {
       $pdo = DB::getInstance();
       $result = $pdo->query('SELECT * FROM ' . static::getTableName() . ' WHERE name=:name', ['name'=>$name], static::class);
       return $result ? $result[0]->id : null;
    }

    public static function getById($id)
    {
       $pdo = DB::getInstance();
       $result = $pdo->query('SELECT * FROM ' . static::getTableName() . ' WHERE id=:id', ['id'=>$id], static::class);
       return $result ? $result[0] : null;
    }

    private function propertiesToDb()
    {
        $reflector = new \ReflectionObject($this);
        $properties = $reflector->getProperties();
        $props = [];
        foreach($properties as $property){
            $propertyName = $property->getName();
            $props[$propertyName] = $this->$propertyName;
        }
        return $props;
    }

    public function save()
    {
        $properties = $this->propertiesToDb();       
        if($this->id !== null){
            $this->update($properties);
        }
        else{
            $this->insert($properties);
        }
    }

    public static function update(array $properties)
    {
       $columns = [];
       foreach($properties as $column=>$value){
          $columns[] = $column . '=:' . $column;
       }
       
      $pdo = Db::getInstance();
      $sql = 'UPDATE '. static::getTableName() . ' SET ' . implode(', ', $columns) . ' WHERE id=:id';
      $pdo->query($sql, $properties, static::class);
    }

    public static function insert(array $properties)
    {
      $keys = [];
      $values = [];
      foreach($properties as $key=>$value){
         $keys[] = $key;
         $values[] = $value;

      }
      
     $pdo = Db::getInstance();
     $sql = 'INSERT INTO '. static::getTableName() . ' (' . implode(', ', $keys) . ')' . ' VALUES ' . "('" . implode("', '", $values) . "')";
     $pdo->query($sql, $properties, static::class);
    }
    
    public function delete()
    {
        $pdo = Db::getInstance();
        $sql = 'DELETE FROM '.static::getTableName().' WHERE id='.$this->id;
        $pdo->query($sql);  
    }
    
    public static function findOneByColumn(string $columnName, $value): ?self
    {
        $pdo = DB::getInstance();
        $result = $pdo->query(
            'SELECT * FROM ' . static::getTableName() . ' WHERE ' . $columnName . ' = :value LIMIT 1;',
            [':value' => $value],
            static::class
        );
        if ($result === []) {
            return null;
        }
        return $result[0];
    }

    abstract protected static function getTableName();    
}