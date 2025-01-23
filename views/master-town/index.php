<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Towns/Survey Locations';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="master-town-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Town/Survey Location', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'town',
            [
                'label' => 'City/District',
                 'value' => function ($model) {
                                if(isset($model->townCity->city))
                                {
                                       return  $model->townCity->city;
                                }
                                else { return '';}
                         },
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
