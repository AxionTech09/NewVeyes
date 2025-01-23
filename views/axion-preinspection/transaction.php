<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\datecontrol\DateControl;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\Retaildata */

//$this->title = $model->id;
//$this->params['breadcrumbs'][] = ['label' => 'Retaildatas', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;

$gridColumns = [
 
// the name column configuration
    [
        'attribute'=>'created_on',
         'format' => ['date', 'php:d-m-Y h:i a'],
    ],
    
    [
        'attribute'=>'referenceNo',
    ],
    
    [
        'attribute'=>'insurerName',
    ],
    
    [
        'attribute'=>'registrationNo',
    ],
    
    [
        'attribute'=>'surveyLocation',
    ],
    
    [
        'attribute'=>'status',
        'value'=>function ($model) {
            $status = $model->status;
            if($status == 0)
            {
                return  'Fresh Case';
            }
            else if($status == 12)
            {
                return  'Schedule';
            }
            else if($status == 1)
            {
                return  'Intimation Re-Schedule';
            }
            else if($status == 8)
            {
                return  'Survey Done';
            }
            else if($status == 9)
            {
                return  'Cancelled';
            }
            else if($status == 100)
            {
                return  'Change RO';
            }
            else if($status == 101)
            {
                return  'PI-Recommended';
            }
            else if($status == 102)
            {
                return  'PI-Not Recommended';
            }
            else if($status == 103)
            {
                return  'PI-Inprogress';
            }
            else if($status == 104)
            {
                return  'PI-Refer to Under Writer';
            }
            else { return '';}
         },
    ],
    
    [
        'attribute'=>'surveyorName',
        'value'=>function ($model) {
            $valuatorUser = $model->valuatorUser;
            if(isset($valuatorUser->piUserId))
            {
                   return  $valuatorUser->piUserId;
            }
            else { return '';}
         },
    ],
    
    [
        'attribute'=>'customerAppointDateTime',
        'format' => ['date', 'php:d-m-Y h:i a'],
    ],

    [
        'attribute'=>'paymentMode',
        'value'=>function ($model) {
            $payment = $model->paymentMode;
            if($payment == 1)
            {
                return  'Company Billing';
            }
            else if($payment == 2)
            {
                return  'Fee and Conv. From Client';
            }
            else if($payment == 3)
            {
                return  'Company Billing and Conv. From Client';
            }
            else {
                return '';
            }
         },
    ],

    [
        'attribute'=>'remarks',
    ],

    [
        'attribute'=>'smsText',
    ],
    
    [
        'attribute'=>'smsSendStatus',
    ],
    
                  
];
   

?>
<div class="retaildata-view">
    

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Close', 'javascript:window.close();', ['class' => 'btn btn-primary']) ?>
    </p> 

    <?= GridView::widget([
    'dataProvider' => $model,
        
    'columns' => $gridColumns,
]) ?>
    
    
    

</div>
