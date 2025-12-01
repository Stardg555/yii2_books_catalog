<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Autors;


/* @var $this yii\web\View */
/* @var $model app\models\Book */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="book-form">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data'] 
    ]); ?>

    <div class="row">
        <div class="col-md-8">
            <?= $form->field($model, 'title')->textInput([
                'maxlength' => true,
                'placeholder' => 'Название книги'
            ]) ?>

            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'year')->textInput([
                        'type' => 'number',
                        'min' => 1000,
                        'max' => date('Y'),
                        'placeholder' => date('Y')
                    ]) ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'isbn')->textInput([
                        'maxlength' => true,
                        'placeholder' => '978-5-389-07464-1'
                    ]) ?>
                </div>
            </div>

            <?= $form->field($model, 'autorIds')->dropdownList(
                Autors::find()->select(['fio', 'id'])->indexBy('id')->column(),
                ['prompt'=>'Выберите автора']
            ); ?>
            
            <?= $form->field($model, 'description')->textarea([
                'rows' => 6,
                'placeholder' => 'Описание книги...'
            ]) ?>

        
        </div>
        
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Обложка книги</h3>
                </div>
                <div class="panel-body text-center">
                    <?php if ($model->cover_image): ?>
                        <div class="form-group">
                            <?= Html::img($model->cover_image, [
                                'class' => 'img-thumbnail',
                                'style' => 'max-width: 200px; max-height: 300px; margin-bottom: 15px;'
                            ]) ?>
                            <br>
                            <label>
                                <?= Html::checkbox('delete_cover', false) ?>
                                Удалить обложку
                            </label>
                        </div>
                    <?php else: ?>
                        <div class="text-muted" style="margin: 40px 0;">
                            <span class="glyphicon glyphicon-picture" style="font-size: 60px;"></span>
                            <p>Обложка не загружена</p>
                        </div>
                    <?php endif; ?>

                    <?= $form->field($model, 'imageFile')->fileInput([
                        'accept' => 'image/*'
                    ])->label(false) ?>
                    
                    <div class="help-block">
                        Допустимые форматы: JPG, PNG<br>
                        Максимальный размер: 5MB
                    </div>
                </div>
            </div>
            
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton(
            $model->isNewRecord ? 
                '<span class="glyphicon glyphicon-plus"></span> Создать книгу' : 
                '<span class="glyphicon glyphicon-ok"></span> Сохранить изменения',
            ['class' => $model->isNewRecord ? 'btn btn-success btn-lg' : 'btn btn-primary btn-lg']
        ) ?>
        
        <?= Html::a(
            '<span class="glyphicon glyphicon-remove"></span> Отмена', 
            $model->isNewRecord ? ['index'] : ['view', 'id' => $model->id], 
            ['class' => 'btn btn-default btn-lg']
        ) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>