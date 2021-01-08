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
        // $mpdf = new \Mpdf\Mpdf();
        // $mpdf->WriteHTML($html);
        // $mpdf->Output();
        

// -------нумерация страниц--------------
        $mpdf = new \Mpdf\Mpdf();        
        $mpdf->setFooter('Страница {PAGENO} из {nbpg}');
        $mpdf->WriteHTML($html);        
        // $mpdf->Output();
// ---------------------
        $mpdf->Output('articles.pdf', \Mpdf\Output\Destination::DOWNLOAD);
    }

    public function excel()
    {
        header('Content-Type: application/vnd.ms-excel');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="articles.xlsx"');
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $articles = Article::findAll();
        $count=1;
        
       foreach($articles as $article){
            $count++;
            $autor = $article->getAuthor()->name;
            $sheet->setCellValue('A'.$count, $article->name);            
            $sheet->setCellValue('B'.$count, $article->text);
            $sheet->setCellValue('C'.$count, $autor);
            $sheet->setCellValue('D'.$count, $article->created_at);
        }
        // $sheet->setCellValue('A1', 'Here must be my articles!');


        // for ($i=1; $i <=count($articles); $i++) {             
        //     $sheet->setCellValue('A'.$i, $articles[$i-1]->name);            
        //     $sheet->setCellValue('B'.$i, $articles[$i-1]->text);
        //     $sheet->setCellValue('C'.$i, $articles[$i-1]->getAuthor()->name);
        //     $sheet->setCellValue('D'.$i, $articles[$i-1]->created_at);
        // }

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
    }

    public function edit($id)
    {      
        $article = Article::getById($id);
        if(!$article){
            throw new NotFoundExeption();
        }
        $article->name = $_POST['name']; // $_POST[]
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
        //var_dump($article);
        $article->delete();
        $this->redirect('/');
    }

}
// ORM - Object Relation Mapping
//Singleton - будет создан только один экземпляр класса 