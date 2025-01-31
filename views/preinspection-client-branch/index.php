<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Preinspection Client Branches';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="preinspection-client-branch-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Client Branch', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'branchName',
            [
                'label' => 'Division',
                 'value' => function ($model) {
                                if(isset($model->branchDivision->divisionName))
                                {
                                       return  $model->branchDivision->divisionName;
                                }
                                else { return '';}
                         },
            ],
            [
                'label' => 'Company',
                 'value' => function ($model) {
                                if(isset($model->branchCompany->companyName))
                                {
                                       return  $model->branchCompany->companyName;
                                }
                                else { return '';}
                         },
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
