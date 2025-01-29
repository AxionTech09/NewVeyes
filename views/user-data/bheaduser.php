<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Branch Head User List';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="userdata-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Branch Head User', ['create-bheaduser'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'firstName',
            'email',
            'mobile',                     

            ['class' => 'yii\grid\ActionColumn',
             'template' => '{view}{update}{delete}',  
               'buttons'  => [
                        'view'   => function ($url, $model) {
                            $url = Url::to(['user-data/view-bheaduser', 'id' => $model->id]);
                           return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                            'title' => Yii::t('app', 'View'),
                            ]);
                        },
                        'update' => function ($url, $model) {
                            $url = Url::to(['user-data/update-bheaduser', 'id' => $model->id]);
                            return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                            'title' => Yii::t('app', 'Update'),
                            ]);
                        },
                        'delete' => function ($url, $model) {
                            return  Html::a('<span class="glyphicon glyphicon-trash"></span>', ['user-data/delete-bheaduser', 'id' => $model->id], [
                            'data'=>[
                                'method' => 'post',
                                'confirm' => 'Are you sure you want to delete this item?',
                            ]
                            ]);
                        },
                    ] 
           ],
        ],
    ]); ?>

</div>
