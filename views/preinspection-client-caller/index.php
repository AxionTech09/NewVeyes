<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Preinspection Clients';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="preinspection-client-caller-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Client', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'callerName',
            [
                'label' => 'Branch',
                 'value' => function ($model) {
                                if(isset($model->callerBranch->branchName))
                                {
                                       return  $model->callerBranch->branchName;
                                }
                                else { return '';}
                         },
            ],
            [
                'label' => 'Division',
                 'value' => function ($model) {
                                if(isset($model->callerDivision->divisionName))
                                {
                                       return  $model->callerDivision->divisionName;
                                }
                                else { return '';}
                         },
            ],
            [
                'label' => 'Company',
                 'value' => function ($model) {
                                if(isset($model->callerCompany->companyName))
                                {
                                       return  $model->callerCompany->companyName;
                                }
                                else { return '';}
                         },
            ],
            
            // 'callerDesignation',
            // 'callerMobileNo',
            // 'callerEmailId:email',
            // 'callerAdditionInfo',
            // 'created_on',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
