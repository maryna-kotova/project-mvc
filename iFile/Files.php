<?php
namespace IFile;
class Files{
    public function __construct(string $filePath)
    {
        $this->filePath = $filePath;
    }
    public function getPath(){
        $getPath = explode('/', $this->filePath);
        if(array_shift($getPath)){
            array_splice($getPath, 0,1);
        }        
        array_splice($getPath, -1);
        $newGetPath = '';
        foreach ($getPath as $value) {
            $newGetPath.= '/'.$value;                           
        }        
        // echo '<br> Путь к файлу: '. $newGetPath;
        return $newGetPath;
    }
    public function getDir(){
        $arr = explode('/', $this->filePath);
        $getDir = $arr[count($arr)-2];
        // echo '<br> Папка файла: '. $getDir;
        return $getDir;
    }
    public function getName(){
        $arr = explode('/', $this->filePath);
        $lastElem = $arr[count($arr)-1];
        $arrName = explode('.', $lastElem);
        $count = count($arrName);
        array_splice($arrName, -1);
        if($count>2){            
            $getName = '';
            for ($i=0; $i < count($arrName); $i++) { 
                if($i == (count($arrName)-1)){
                    $getName.= $arrName[$i];  
                }
                else{                   
                    $getName.= $arrName[$i].'.';   
                }                  
            }
        }
        elseif($count == 2){
            $getName = $arrName[0];
        }        
        // echo '<br> Имя файла: '. $getName;
        return $getName;
    }
    public function getEXT(){
        $arr = explode('/', $this->filePath);
        $lastElem = $arr[count($arr)-1];
        $arrName = explode('.', $lastElem);
        $getEXT = array_pop($arrName);
        // echo '<br> Расширение файла: '. $getEXT;
        return $getEXT;
    }
    public function getSize(){
        $getSize = filesize($this->filePath);
        // echo '<br> Размер файла: '. $getSize . ' байтов';
        return $getSize;
    }
    public function getText(){        
        $text = file_get_contents($this->filePath);
        // echo '<br> Полученный текст файла: '. $text;   
        return $text; 
    }
    public function setText($text){
        $file = fopen($this->filePath, 'w+');
        fwrite($file, $text);
        fclose($file);
        // echo '<br> Установленный текст файла: '. $text;
        return $text;
    }
    public function appendText($text){
        $file = fopen($this->filePath, 'a+');
        fwrite($file, $text);
        fclose($file);
        // echo '<br> Добавленный текст файла: '. $text;
        return $text;
    }
    public function copy($copyPath){        
        $copyFile = copy($this->filePath, $copyPath);
        // if($copyFile)
        //     echo '<br> Копирование файла: Файл скопирован ';  
        // else
        //     echo '<br> Копирование файла: Ошибка';
        
        return $copyFile;
    }
    public function delete(){
        $res = unlink($this->filePath);
        // if($res == 1){
        //     echo '<br> Удаление файла: Файл удален';
        // }
        // else{
        //     echo '<br> Удаление файла: Ошибка';
        // }
        return $res;
    }
    public function rename($newName){
        rename($this->filePath, $newName);         
        // echo '<br> Новое имя файла: '. $newName;
        return $newName;
    }
    public function replace($newPath){
        rename($this->filePath, $newPath);
        // echo '<br> Новый путь к файлу: '. $newPath;
        return $newPath;
    }
}