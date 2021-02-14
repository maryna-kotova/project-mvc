<?php
namespace Core\Controllers;

use Core\Models\Article;
use Core\Views\View;
use Core\Models\User;
use Core\Libs\Exceptions\NotFoundExeption;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ArticleController extends Controller{
    
    public function show($id)
    {
        // echo $id;
        $article = Article::getById($id);
        if(!$article){
            throw new NotFoundExeption();
        }      
        View::render( 'articles/show', compact('article') );
    }

    public function pdf(){
        $articles = Article::findAll();
        $html = '<h1>Все статьи</h1>';
        foreach($articles as $article){
            $html .= "<h2>{$article->name}</h2>";
            $html .= "<p>{$article->text}</p>";
        }  

// -------нумерация страниц--------------
        $mpdf = new \Mpdf\Mpdf();        
        $mpdf->setFooter('Страница {PAGENO} из {nbpg}');
        $mpdf->WriteHTML($html);        
        // $mpdf->Output();
// ------скачать файл pdf
        $mpdf->Output('articles.pdf', \Mpdf\Output\Destination::DOWNLOAD);
    }

    public function excel()
    {
        // определение формата файла для скачивания xlsx
        header('Content-Type: application/vnd.ms-excel');        
        header('Content-Disposition: attachment;filename="articles.xlsx"');

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $articles = Article::findAll();
        
        //устанавливаем в необходимые ячейки данные из базы данных
        for ($i=1; $i <= count($articles); $i++) { 
            $sheet->setCellValue('A'.$i, $articles[$i-1]->name);
            $sheet->setCellValue('B'.$i, $articles[$i-1]->text);
            $sheet->setCellValue('C'.$i, $articles[$i-1]->getAuthor()->name);
            $sheet->setCellValue('D'.$i, $articles[$i-1]->created_at);
        }
        //записываем в файл эксель
        $writer = new Xlsx($spreadsheet);
        // сохраняем данный файл в указанную папку
        $writer->save('php://output');
    }

    public function edit($id)
    {      
        $article = Article::getById($id);
        if(!$article){
            throw new NotFoundExeption();
        }
        $article->name = $_POST['name']; 
        $article->text = $_POST['text'];
        $article->user_id = $_POST['user_id'];    
          
        $article->save();
        $this->redirect('/');
    }

    function editForm($id)
    {
        $article = Article::getById($id);
        if(!$article){
            throw new NotFoundExeption();
        }
       $users = User::findAll();
       View::render('articles/edit', compact('article', 'users'));
    }

    public function add(){
        $article = new Article();
        $article->name = $_POST['name']; 
        $article->text = $_POST['text'];
        $article->user_id = $_POST['user_id'];

        $article->save();
        $this->redirect('/');
    }

    public function addForm()
    {       
       $users = User::findAll();
       View::render('articles/add', compact('users'));
    }

    public function delete($id)
    {        
        $article = Article::getById($id);       
        $article->delete();
        $this->redirect('/');
    }

}
// ORM - Object Relation Mapping
//Singleton - будет создан только один экземпляр класса 