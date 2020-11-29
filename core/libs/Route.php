<?php
namespace Core\Libs;

use Core\Views\View;

class Route{
    private static $page;
    public static function start()
    {
        self::$page = $_GET['page'] ?? '/';
        $routes = require __DIR__.'/../web.php';

        if( isset($routes[self::$page]) ){
            list($nameConroller, $nameMothod) = explode('@', $routes[self::$page]);
            if( file_exists('core/controllers/'. $nameConroller .'.php') ){              
                $pathController = 'Core\\Controllers\\'.$nameConroller;
                $controller = new $pathController();
                if( method_exists($controller, $nameMothod) ){
                    $controller->$nameMothod();
                }
                else{
                    echo 'Method not found';
                }
            }
            else{
                echo 'File not found';
            }
        }
        else{
            View::render('errors/404', [], 404);
        }   

        // print_r($routes);
    }

    public static function getPage(){
        return self::$page;
    }
    // public static function getPath(){
    //     $path = get_called_class();
    //     $arrPath = explode('\\', $path);
    //     $newPath = '';
    //     for ($i=0; $i < count($arrPath); $i++) { 
    //         if($i == (count($arrPath)-1)){
    //             $newPath.= $arrPath[$i].'.php';  
    //         }
    //         else{
    //             $lower = strtolower($arrPath[$i]);
    //             $newPath.= $lower.'/';   
    //         }                  
    //     } 
    //    return $newPath;        
    // }
}