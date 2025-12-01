<?php

/** @var yii\web\View $this */

$this->title = Yii::$app->name;
?>
<div class="site-index">

    <div class="jumbotron text-center bg-transparent mt-5 mb-5">
        <h1 class="display-4"><?=Yii::$app->name?></h1>

        <p class="lead">Демонстрация.</p>

    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-4 mb-3">
                <h2>Авторы</h2>
                <p><a class="btn btn-outline-secondary" href="/basic/web/autors/index">Смотреть &raquo;</a></p>
            </div>
            <div class="col-lg-4 mb-3">
                <h2>Книги</h2>
                <p><a class="btn btn-outline-secondary" href="/basic/web/books/index">Смотреть &raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <h2>Топ 10 авторов</h2>

                <p><a class="btn btn-outline-secondary" href="/basic/web/report/index">Смотреть &raquo;</a></p>
            </div>
        </div>

    </div>
</div>
