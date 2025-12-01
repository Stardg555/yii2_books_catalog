<?php

namespace app\controllers;

use Yii;
use app\models\ReportsHelper;
use yii\web\Controller;

class ReportController extends Controller
{
    public function actionIndex()
    {
        $model = new ReportsHelper();
        $topAutors = [];

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $topAutors = ReportsHelper::getTopTenAutors($model->year);
        }

        return $this->render('index', [
            'model' => $model,
            'topAutors' => $topAutors,
        ]);
    }
}
