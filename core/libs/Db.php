<?php
namespace Core\Libs;

use Core\Libs\Exceptions\DbException;

class Db{
    protected $pdo;
    private static $instance;

    private function __construct()
    {
        $options = (require_once __DIR__. '/../config.php')['db'];
        try{
           $this->pdo = new \PDO( 'mysql:host=' . $options['host'] . ';dbname=' . $options['dbname'], $options['user'], $options['password'] ); 
        }
        catch(\PDOException $e){
            throw new DbException('Ошибка при подключении к БД'. $e->getMessage());
        }
    }

    public function query(string $sql, array $params = [], string $className='stdClass')
    {
        $pz = $this->pdo->prepare($sql);
        $result = $pz->execute($params);
        if(!$result){
            return null;
        }
        return $pz->fetchAll(\PDO::FETCH_CLASS, $className);
    }

    public static function getInstance()
    {
        if(self::$instance == null){
            self::$instance = new self();
        }
        return self::$instance;
    }
}
