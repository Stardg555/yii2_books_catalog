<?php

namespace app\controllers;

use Yii;
use app\models\SubscribeToAutors;
use yii\web\Controller;
use yii\filters\VerbFilter;



class SubscribeToAutorsController extends Controller
{
    
        public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'create' => ['POST'],
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionCreate()
    {
        
        Yii::info('Subscription create action called', 'app');
    Yii::info('POST data: ' . print_r(Yii::$app->request->post(), true), 'app');
    
        $model = new SubscribeToAutors();
        $model->load(Yii::$app->request->post());

        if ($model->save()) {
            Yii::$app->session->setFlash('success', 
                'Вы успешно подписались на уведомления о новых книгах автора. ' .
                'Письмо с подтверждением отправлено на ваш email.'
            );
            
        } else {
            Yii::$app->session->setFlash('error', 
                'Ошибка при создании подписки: ' . 
                implode(', ', $model->getFirstErrors())
            );
        }

        return $this->redirect(Yii::$app->request->referrer ?: ['site/index']);
    }

}