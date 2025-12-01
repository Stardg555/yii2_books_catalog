<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Book */
/* @var $subscription app\models\SubscribeToAutors */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Книги', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="book-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (!Yii::$app->user->isGuest): ?>
        <p>
            <?= Html::a('<span class="glyphicon glyphicon-pencil"></span> Редактировать', 
                ['update', 'id' => $model->id], 
                ['class' => 'btn btn-primary']
            ) ?>
            <?= Html::a('<span class="glyphicon glyphicon-trash"></span> Удалить', 
                ['delete', 'id' => $model->id], 
                [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => 'Вы уверены, что хотите удалить эту книгу?',
                        'method' => 'post',
                    ],
                ]
            ) ?>
            <?= Html::a('<span class="glyphicon glyphicon-list"></span> Все книги', 
                ['index'], 
                ['class' => 'btn btn-default']
            ) ?>
        </p>
    <?php endif; ?>

    <div class="row">
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-body text-center">
                    <?php if ($model->cover_image): ?>
                        <?= Html::img($model->cover_image, [
                            'class' => 'img-responsive img-thumbnail',
                            'style' => 'max-height: 400px;',
                            'alt' => $model->title
                        ]) ?>
                    <?php else: ?>
                        <div class="text-muted" style="padding: 100px 0;">
                            <span class="glyphicon glyphicon-picture" style="font-size: 80px;"></span>
                            <p>Обложка отсутствует</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <div class="col-md-8">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    [
                        'attribute' => 'title',
                        'captionOptions' => ['class' => 'text-primary'],
                    ],
                    [
                        'attribute' => 'year',
                        'value' => function($model) {
                            return $model->year . ' год';
                        },
                    ],
                    [
                        'attribute' => 'isbn',
                        'value' => function($model) {
                            return $model->isbn ?: '<span class="text-muted">не указан</span>';
                        },
                        'format' => 'raw',
                    ],
                    [
                        'attribute' => 'autors',
                        'value' => function($model) {
                            $autors = [];
                            foreach ($model->autors as $autor) {
                                $autors[] = Html::encode($autor->fio);
                            }
                            return implode(', ', $autors) ?: '<span class="text-muted">автор не указан</span>';
                        },
                        'format' => 'raw',
                    ],
                    [
                        'attribute' => 'description',
                        'value' => function($model) {
                            return nl2br(Html::encode($model->description ?: 'Описание отсутствует'));
                        },
                        'format' => 'raw',
                        'contentOptions' => ['style' => 'max-height: 200px; overflow-y: auto;'],
                    ],
                ],
                'options' => ['class' => 'table table-striped table-bordered detail-view'],
            ]) ?>
        </div>
    </div>

    <?php if (Yii::$app->user->isGuest && $model->autors): ?>
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <span class="glyphicon glyphicon-bell"></span> 
                            Уведомления о новых книгах
                        </h3>
                    </div>
                    <div class="panel-body">
                        <?= $this->render('_subscription', [
                            'subscription' => $subscription,
                            'autorName' => $model->getAutors()->one()->fio ?? '',
                        ]) ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

</div>