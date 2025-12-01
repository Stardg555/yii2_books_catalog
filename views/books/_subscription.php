<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $subscription app\models\SubscribeToAutors */
/* @var $authorName string */

?>

<div class="subscription-form">
    <?php $form = ActiveForm::begin([
        'action' => ['/subscribe-to-autors/create'],
        'method' => 'post',
    ]); ?>

    <p>Подписаться на уведомления о новых книгах автора <strong><?= Html::encode($autorName) ?></strong></p>

    <?= $form->field($subscription, 'email')->textInput([
        'type' => 'email',
        'placeholder' => 'your@email.com',
        'required' => true
    ])->label('Email') ?>

    <?= $form->field($subscription, 'phone')->textInput([
        'placeholder' => '79161234567',
        'pattern' => '^[0-9]{11}$',
        'title' => 'Введите 11 цифр без пробелов и скобок'
    ])->label('Телефон (для SMS) <small class="text-muted">необязательно</small>') ?>

    <?= $form->field($subscription, 'autor_id')->hiddenInput()->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton('Подписаться', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    

</div>