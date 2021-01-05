<h1><?= $article->name ?></h1>
<div>Author: <?= $article->getAuthor()->name ?></div>
<div><?= $article->text ?></div>