<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Locations';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="master-location-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Location', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'label' => 'City/District',
                 'value' => function ($model) {
                                if(isset($model->locationCity->city))
                                {
                                       return  $model->locationCity->city;
                                }
                                else { return '';}
                         },
            ],
            [
                'label' => 'Town/Survey Location',
                 'value' => function ($model) {
                                if(isset($model->locationTown->town))
                                {
                                       return  $model->locationTown->town;
                                }
                                else { return '';}
                         },
            ],
            'conveyance',
            'extraKms',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
