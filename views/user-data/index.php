<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="userdata-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create User', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'name',
            'type',
            [
                'label' => 'Assigned to Staff',
                'value' => function ($model) {
                           if($model->type == 'Valuator')
                           {
                                $valuatorStaff = $model->valuatorStaff;
                                if(isset($valuatorStaff->name))
                                {
                                       return  $valuatorStaff->name;
                                }
                                else { return '';}
                           }
                            else { return '';}
                         },
            ],
            'mobile',                     

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
