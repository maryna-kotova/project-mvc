<?php
namespace Core\Controllers;

use Core\Models\Article;
use Core\Views\View;
use Core\Models\User;
use Core\Libs\Exceptions\NotFoundExeption;

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