<h1><?= $article->name ?></h1>
<div>Автор: <?= $article->getAuthor()->name ?></div>
<div><?= $article->text ?></div>

<form action="article/1/edit" method="POST">
    
</form>