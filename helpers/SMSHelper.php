<?php

namespace app\helpers;

use Yii;

Class SMSHelper
{
    public static function checkSmsSendStatus($msgId)
    {
        $sendSmsUpdate = \Yii::$app->params['sendSmsUpdate'];
        $username = \Yii::$app->params['sendSmsUser'];
        $password = \Yii::$app->params['sendSmsPwd'];
        $sendername = \Yii::$app->params['sendSmsSender'];

        $url = "https://api.mylogin.co.in/api/v2/MessageStatus?ApiKey=$username&ClientId=$password&MessageId=$msgId";
        $useragent = 'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US) AppleWebKit/533.2 (KHTML, like Gecko) Chrome/5.0.342.3 Safari/533.2';

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // required as godaddy fails
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); // required as godaddy fails
        curl_setopt($ch, CURLOPT_USERAGENT, $useragent);

        $response = curl_exec($ch);
        $error = '';

        if(!$response){
            $error = curl_error($ch);
        }
        curl_close($ch);

        if ($response)
        {
            return ['status' => true, 'code' => 200, 'message' => 'Data Exists.', 'data' => $response];
        }
        else
        {
            return ['status' => false, 'code' => 404, 'message' => 'Data Not Found.', 'data' => $error];
        }
        
    }
}