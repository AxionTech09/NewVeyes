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
                return  'Spot Survey';
            }
            else if($status == 9)
            {
                return  'Cancelled';
            }
            // else if($status == 100)
            // {
            //     return  'Change RO';
            // }
            else if($status == 101)
            {
                return  'Final Survey';
            }
            else if($status == 102)
            {
                return  'Re-Inspection';
            }
            else if($status == 103)
            {
                return  'Inprogress';
            }
            else if($status == 104)
            {
                return  'Initial-Survey';
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
        'attribute'=>'remarks',
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
