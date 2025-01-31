<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Preinspection Client Region';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="preinspection-client-region-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Region', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'regionName',
            'regionCode',
            [
                'label' => 'Company',
                 'value' => function ($model) {
                                if(isset($model->divisionCompany->companyName))
                                {
                                       return  $model->divisionCompany->companyName;
                                }
                                else { return '';}
                         },
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
