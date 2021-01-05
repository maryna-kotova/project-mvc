<?php
namespace Core\Controllers;
class Controller{
   
    public function dump($obj)
    {
        echo '<pre>'.print_r($obj, true).'</pre>'; 
    }
    
    public function redirect($path)
    {
        header('Location: '.$path);
        exit;
    }
}