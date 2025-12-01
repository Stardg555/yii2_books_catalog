<?php

namespace app\components;

use Yii;
use yii\base\Component;

class SmsService extends Component
{
    public $apiKey;
    public $sender = 'books';
    public $testMode = true;

    public function init()
    {
        parent::init();
        if (!$this->apiKey) {
            $this->apiKey = 'XXXXXXXXXXXXYYYYYYYYYYYYZZZZZZZZXXXXXXXXXXXXYYYYYYYYYYYYZZZZZZZZ';
        }
    }

    public function send($phone, $message)
    {
        if (!$phone) {
            Yii::error('Не указан номер телефона для отправки SMS');
            return false;
        }

        if ($this->testMode) {
            // В тестовом режиме логируем отправку
            Yii::info("SMS to {$phone}: {$message}");
            return true;
        }

        // Реальная отправка через SMSPilot
        $url = "http://smspilot.ru/api.php";
        
        $params = [
            'send' => $message,
            'to' => $phone,
            'from' => $this->sender,
            'apikey' => $this->apiKey,
            'format' => 'json',
        ];

        try {
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            
            $response = curl_exec($ch);
            curl_close($ch);

            $result = json_decode($response, true);
            
            if (isset($result['error'])) {
                Yii::error('Ошибка отправки SMS: ' . $result['error']['description']);
                return false;
            }

            Yii::info("SMS отправлено: {$phone}");
            return true;
            
        } catch (\Exception $e) {
            Yii::error('Ошибка при отправке SMS: ' . $e->getMessage());
            return false;
        }
    }
}