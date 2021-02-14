<?php

use Core\Controllers\ProductController;
?>

<h2 class="text-center bg-success text-white">Файл загружен!</h2>

<div class="loadFile">
   <p><?=  ProductController::$countAdd ?></p>
   <p><?=  ProductController::$countCh ?></p>
</div>