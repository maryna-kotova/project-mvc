<?php
namespace Core\Controllers;

use Core\Views\View;
use Core\Models\Article;

class MainController extends Controller{
    
    public function index()
    {
        $title = 'Home Page';
        $articles = Article::findAll();
        // $this->dump($articles);
        View::render( 'main/index', compact('title', 'articles') );
    }    

    public function contacts()
    {
        View::render('main/contacts');
    }

}

