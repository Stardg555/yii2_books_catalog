<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Report */
/* @var $topAutors app\models\Autors[] */

$this->title = 'Топ 10 авторов';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="report-top-authors">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'year')->input('number', [
        'min' => 1000,
        'max' => date('Y'),
        'value' => date('Y')
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton('Показать отчет', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <?php if (!empty($topAutors)): ?>
        <h3>Топ 10 авторов за <?= $model->year ?> год:</h3>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Автор</th>
                    <th>Количество книг</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($topAutors as $index => $autor): ?>
                    <tr>
                        <td><?= $index + 1 ?></td>
                        <td><?= Html::encode($autor->fio) ?></td>
                        <td><?= $autor->getBookCount() ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

</div>