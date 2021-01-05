<h1 class="bg-primary"><?= $title ?></h1>
<section class="allArticles">
    <?php foreach($articles as $article): ?>
        <div class="article">
            <div>        
                <h2><a href="/article/<?= $article->id ?>"><?= $article->name ?></a></h2>
                <a href="/article/<?= $article->id ?>/edit-form" class="editArticle"></a>        
                <form action="/article/<?= $article->id ?>/delete" 
                      method="POST"              
                      style="display: inline-block;">
                    <button class="deleteArticle" ></button>
                </form>
                <p><?= $article->text ?></p>
            </div>
        </div>
    <?php endforeach ?>
    <div class="article">
        <a href="/article/add-form" class="addArticle"></a>
    </div>
</section>
