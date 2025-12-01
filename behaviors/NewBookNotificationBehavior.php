<?php

namespace app\behaviors;

use Yii;
use yii\base\Behavior;
use yii\db\ActiveRecord;
use app\models\SubscribeToAutors;
use app\components\SmsService;

class NewBookNotificationBehavior extends Behavior
{
    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_INSERT => 'notifySubscribers',
        ];
    }

    public function notifySubscribers($event)
    {
        $book = $this->owner;
        
        $autorIds = $book->autorIds;
        
        if (empty($autorIds)) {
            return;
        }

        $subscriptions = SubscribeToAutors::find()
            ->where(['autor_id' => $autorIds])
            ->all();

        foreach ($subscriptions as $subscription) {
            $this->sendNotification($subscription, $book);
        }
    }

    private function sendNotification($subscription, $book)
    {
        $autor = $subscription->autor;
        $bookTitle = $book->title;
        $autorName = $autor->fio;
        
        // Email уведомление
        if ($subscription->email) {
            Yii::$app->mailer->compose()
                ->setTo($subscription->email)
                ->setSubject('Вышла новая книга!')
                ->setTextBody("Вышла новая книга автора {$autorName}: {$bookTitle}")
                ->send();
        }
        
        // SMS уведомление (если указан телефон)
        if ($subscription->phone) {
            $smsService = Yii::$app->get('smsService');
            $message = "Новая книга {$autorName}: {$bookTitle}";
            $smsService->send($subscription->phone, $message);
        }
    }
}