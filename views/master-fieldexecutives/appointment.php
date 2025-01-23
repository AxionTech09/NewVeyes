<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Field Executives Appointments';
$this->params['breadcrumbs'][] = $this->title;
$tomoDate = date("d-m-Y", strtotime("tomorrow"));
?>
<div class="master-fieldexecutives-index">

    <h1><?= Html::encode($this->title) ?></h1>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'name',
            [
                'label' => $tomoDate.' 09:00:00 Appointment',
                'value' => function ($model) {       
                         return  $this->context->getAppointment($model->id,9);  
                         },
            ],
                                 [
                'label' => $tomoDate.' 10:00:00 Appointment',
                'value' => function ($model) {       
                         return  $this->context->getAppointment($model->id,10);  
                         },
            ],
        ],
    ]); ?>

</div>
