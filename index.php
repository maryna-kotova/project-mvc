<?php
use core\libs\Route;
use IFile\Files;
use Core\Libs\Exceptions\DbException;
use Core\Libs\Exceptions\NotFoundExeption;
use Core\Views\View;

spl_autoload_register(function($className){    
    $arrPath = explode('\\', $className);
    $newPath = '';
    for ($i=0; $i < count($arrPath); $i++) { 
        if($i == (count($arrPath)-1)){
            $newPath.= $arrPath[$i].'.php';  
        }
        else{
            $lower = strtolower($arrPath[$i]);
            $newPath.= $lower.'/';   
        }                  
    } 
    require_once $newPath;
});
try{
    Route::start();
}
catch(DbException $e){
    echo $e->getMessage();
}
catch(NotFoundExeption $e){
    View::render('errors/404', [], 404);

}


// $a = Route::getPath();
// echo $a;
// $newFile = new Files('images/big/a.b.c.d.jpg');
// $newFile->getPath();
// $newFile->getDir();
// $newFile->getName();
// $newFile->getEXT();
// $newFile->getSize();

// $newTextFile = new Files('text/out.txt');
// $newTextFile->getText();
// $newTextFile->setText('Black Yellow and White');
// $newTextFile->appendText(' Red');

// $funcFile = new Files('text/red.txt');
// $funcFile->copy('text/red.txt');
// $funcFile->delete();
// $funcFile->rename('text/red.txt');
// $funcFile->replace('images/red.txt');








