<?php
namespace Core\Controllers;

use Core\Models\Article;
use Core\Views\View;
use Core\Models\User;

class ArticleController extends Controller{
    
    public function show($id)
    {
        // echo $id;
        $article = Article::getById($id);
        if(!$article){
            View::render('errors/404', [], 404);
            return;
        }
        // $author = User::getById($article->user_id);
        // $this->dump($author);
        // $this->dump($articles);
        View::render( 'articles/show', compact('article') );
    }
    public function edit($id)
    {
        $dataForm = $_POST[''] ;
        // echo $id;
        $article = Article::getById($id);
        if(!$article){
            View::render('errors/404', [], 404);
            return;
        }
        $article->name = 'Name article'; // $article->name = $dataForm;
        $article->text = 'Text for New article';
        $this->dump($article);

        $article->save();
    }

    public function save()
    {
       
    }

}
// ORM - Object Relation Mapping
//Singleton - будет создан только один экземпляр класса 