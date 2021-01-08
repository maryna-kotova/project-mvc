<?php
namespace Core\Controllers;


use Core\Views\View;
// use Core\Models\Article;

class ProductController extends Controller{ 

    public function import()
    {
        View::render('main/import');
    }

    public function uploadFile(){     
        $dir = 'uploads';
        $uploadFile = $_FILES['fileProd'];
        $nameUploadFile = $uploadFile['name'];

        if( !file_exists($dir) ){
            mkdir($dir);
        }        
        $saveFileName = time() . '_' . $nameUploadFile; 
        move_uploaded_file($uploadFile['tmp_name'], $dir.'/' . $saveFileName);         
        
        // print_r($nameDownloadFile);        
        // $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        // $reader->setReadDataOnly(true);
        // $spreadsheet = $reader->load($dir.'/' .$saveFileName);  

        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($dir.'/' .$saveFileName);
        $worksheet = $spreadsheet->getActiveSheet();        
        $gets = $worksheet->getCell('A1')->getValue();
        // [value:PhpOffice\PhpSpreadsheet\Cell\Cell:private] 
     
        echo '<pre>';    
        var_dump($gets);         

        echo '</pre>';  

        // $uploaddir = '/assets';
        // $uploadfile = $uploaddir . basename($_FILES['fileProd']['name']);
        
        // echo '<pre>';
        // if (move_uploaded_file($_FILES['fileProd']['tmp_name'], $uploadfile)) {
        //     echo "Файл корректен и был успешно загружен.\n";
        // } else {
        //     echo "Возможная атака с помощью файловой загрузки!\n";
        // }
        
        // echo 'Некоторая отладочная информация:';
        // print_r($_FILES);
        
        // print "</pre>";

       

        
        
        
    }

}