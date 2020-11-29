<h1 class="bg-primary"><?= $title?></h1>

<?php foreach ($articles as $article):?>
    <h2><?= $article['name'] ?></h2>
    <p><?= $article['content'] ?></p>
<?php endforeach ?>