<?php
namespace app\components;

use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;
use yii\helpers\Json;
use app\models\User;

use common\models\AuthorizationCodes;
use common\models\AccessTokens;

ini_set('display_errors',false);

/**
 * Class for common API functions
 */
class Api extends Component
{

    public function sendFailedResponse($message)
    {
        $this->setHeader(400);

        echo json_encode(array('status' => 0, 'error_code' => 400, 'errors' => $message), JSON_PRETTY_PRINT);

        Yii::$app->end();
    }

    public function sendSuccessResponse($data = false,$additional_info = false)
    {

        $this->setHeader(200);

        $response = [];
        $response['status'] = 1;

        if (is_array($data))
            $response['data'] = $data;

        if ($additional_info) {
            $response = array_merge($response, $additional_info);
        }

        $response = Json::encode($response, JSON_PRETTY_PRINT);


        if (isset($_GET['callback'])) {
            /* this is required for angularjs1.0 client factory API calls to work */
            $response = $_GET['callback'] . "(" . $response . ")";

            echo $response;
        } else {
            echo $response;
        }

       exit;
       //Yii::$app->end();

    }

     protected function setHeader($status)
    {

        $text = $this->_getStatusCodeMessage($status);

        Yii::$app->response->setStatusCode($status, $text);

        $status_header = 'HTTP/1.1 ' . $status . ' ' . $text;
        $content_type = "application/json; charset=utf-8";


        header($status_header);
        header('Content-type: ' . $content_type);
        header('X-Powered-By: ' . "Your Company <www.mywebsite.com>");
        header('Access-Control-Allow-Origin:*');


    }

    protected function _getStatusCodeMessage($status)
    {
        // these could be stored in a .ini file and loaded
        // via parse_ini_file()... however, this will suffice
        // for an example
        $codes = Array(
            200 => 'OK',
            400 => 'Bad Request',
            401 => 'Unauthorized',
            402 => 'Payment Required',
            403 => 'Forbidden',
            404 => 'Not Found',
            500 => 'Internal Server Error',
            501 => 'Not Implemented',
        );
        return (isset($codes[$status])) ? $codes[$status] : '';
    }

    public function createAuthorizationCode($user_id)
    {
        $model = new AuthorizationCodes;

        $model->code = md5(uniqid());

        $model->expires_at = time() + (60 * 5);

        $model->user_id = $user_id;

        if (isset($_SERVER['HTTP_X_HAIKUJAM_APPLICATION_ID']))
            $app_id = $_SERVER['HTTP_X_HAIKUJAM_APPLICATION_ID'];
        else
            $app_id = null;

        $model->app_id = $app_id;

        $model->created_at = time();

        $model->updated_at = time();

        $model->save(false);

        return ($model);

    }

    public function createAccesstoken($authorization_code)
    {

        $auth_code = AuthorizationCodes::findOne(['code' => $authorization_code]);

        $model = new AccessTokens();

        $model->token = md5(uniqid());

        $model->auth_code = $auth_code->code;

        $model->expires_at = time() + (60 * 60 * 24 * 60); // 60 days

        // $model->expires_at=time()+(60 * 2);// 2 minutes

        $model->user_id = $auth_code->user_id;

        $model->created_at = time();

        $model->updated_at = time();

        $model->save(false);

        return ($model);

    }

    public function refreshAccesstoken($token)
    {
        $access_token = AccessTokens::findOne(['token' => $token]);
        if ($access_token) {

            $access_token->delete();
            $new_access_token = $this->createAccesstoken($access_token->auth_code);
            return ($new_access_token);
        } else {

            Yii::$app->api->sendFailedResponse("Invalid Access token2");
        }
    }

    public function amountInWords(float $amount)
    {
       $amount_after_decimal = round($amount - ($num = floor($amount)), 2) * 100;
       // Check if there is any number after decimal
       $amt_hundred = null;
       $count_length = strlen($num);
       $x = 0;
       $string = array();
       $change_words = array(0 => '', 1 => 'One', 2 => 'Two',
         3 => 'Three', 4 => 'Four', 5 => 'Five', 6 => 'Six',
         7 => 'Seven', 8 => 'Eight', 9 => 'Nine',
         10 => 'Ten', 11 => 'Eleven', 12 => 'Twelve',
         13 => 'Thirteen', 14 => 'Fourteen', 15 => 'Fifteen',
         16 => 'Sixteen', 17 => 'Seventeen', 18 => 'Eighteen',
         19 => 'Nineteen', 20 => 'Twenty', 30 => 'Thirty',
         40 => 'Forty', 50 => 'Fifty', 60 => 'Sixty',
         70 => 'Seventy', 80 => 'Eighty', 90 => 'Ninety');
        $here_digits = array('', 'Hundred','Thousand','Lakh', 'Crore');
        while( $x < $count_length ) {
          $get_divider = ($x == 2) ? 10 : 100;
          $amount = floor($num % $get_divider);
          $num = floor($num / $get_divider);
          $x += $get_divider == 10 ? 1 : 2;
          if ($amount) {
           $add_plural = (($counter = count($string)) && $amount > 9) ? 's' : null;
           $amt_hundred = ($counter == 1 && $string[0]) ? ' and ' : null;
           $string [] = ($amount < 21) ? $change_words[$amount].' '. $here_digits[$counter]. $add_plural.' 
           '.$amt_hundred:$change_words[floor($amount / 10) * 10].' '.$change_words[$amount % 10]. ' 
           '.$here_digits[$counter].$add_plural.' '.$amt_hundred;
            }
       else $string[] = null;
       }
       $implode_to_Rupees = implode('', array_reverse($string));
       $get_paise = ($amount_after_decimal > 0) ? "And " . ($change_words[(floor($amount_after_decimal / 10) >= 1) ? floor($amount_after_decimal / 10) * 10 : $amount_after_decimal] . " 
       " . $change_words[$amount_after_decimal % 10]) . ' Paise' : '';

       return ($implode_to_Rupees ? $implode_to_Rupees . 'Rupees ' : '') . $get_paise;
    }

    public function showDecimal($number){
        return number_format((float)$number, 2, '.', '');
    }

}

?>