<?php
namespace Core\Libs;

use Core\Views\View;

class Route{
    private static $page;
    public static function start()
    {
        self::$page = $_GET['page'] ?? '/';
        $routes = require __DIR__.'/../web.php';

        $isRouteFound = false; // $routes нет совпадений по url
        foreach ($routes as $pattern => $controllerAndMethod){
            preg_match('~^'.$pattern.'$~', self::$page, $matches);
            if(!empty($matches)){
                $isRouteFound = true;
                break;
            }
            // var_dump($matches);
        }

        if(  $isRouteFound ){
            list($nameConroller, $nameMothod) = explode('@', $controllerAndMethod);// $controllerAndMethod = последнему значению так как в foreach был break
            if( file_exists('core/controllers/'. $nameConroller .'.php') ){              
                $pathController = 'Core\\Controllers\\'.$nameConroller;
                $controller = new $pathController();
                if( method_exists($controller, $nameMothod) ){
                    unset($matches[0]);
                    
                    $controller->$nameMothod(...$matches);
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