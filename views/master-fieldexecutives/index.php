<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Field Executives';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="master-fieldexecutives-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Field Executive', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'name',
            'mobile',
            [
                'label' => 'Base Location',
                 'value' => function ($model) {
                                if(isset($model->locationCity->city))
                                {
                                       return  $model->locationCity->city;
                                }
                                else { return '';}
                         },
            ],
            //'address',
            //'dob',
            //'email:email',                     
            // 'nominee',
            // 'spouseName',
            // 'mobile2',
            // 'basicSalary',
            // 'caseRate',
            // 'loans',
            // 'repaymentInstalment',
            // 'bankName',
            // 'accNumber',
            // 'ifsc',
            // 'branchName',
            // 'created_on',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
