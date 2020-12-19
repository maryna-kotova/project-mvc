<h1 class="bg-primary"><?= $title?></h1>
<h2>Lorem, ipsum.</h2>

<?php foreach ($articles as $article):?>
    <h2> <a href="/article/<?= $article->id ?>"><?= $article->name ?></a></h2>
    <p><?= $article->text ?></p>
<?php endforeach ?>