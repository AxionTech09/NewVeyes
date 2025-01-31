<?php

use yii\helpers\Html;
use yii\grid\GridView;
use mdm\admin\components\Helper;
use rmrevin\yii\fontawesome\FA;
use rmrevin\yii\fontawesome\FAS;
use rmrevin\yii\fontawesome\FAR;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'State';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="master-state-index">

    <p class="clearfix">
        <?= Html::a(FA::icon('plus-circle', ['class' => 'mr-3 mt-5 text-white']).' Add State', ['create'], ['class' => 'btn btn-success pull-right']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'class' => 'yii\grid\SerialColumn',
                'headerOptions' => ['style'=>'border: 2px #000 solid;background-color:#480155;padding-right:10px;']
            ],
            [
                'attribute'=>'state',
                'headerOptions' => ['style'=>'border: 2px #000 solid;background-color:#480155;padding-right:10px;']
            ],
            [
                'attribute'=>'regCode',
                'headerOptions' => ['style'=>'border: 2px #000 solid;background-color:#480155;padding-right:10px;']
            ],
            [
                'attribute'=>'updatedBy',
                'value' => function ($model) {
                    return $model->updatedByName->firstName;
                },
                'headerOptions' => ['style'=>'border: 2px #000 solid;background-color:#480155;padding-right:10px;']
            ],
            [
                'attribute'=>'stateStatus',
                'format'=>'raw',
                'value' => function ($model) {
                    if ($model->stateStatus == 'Active')
                        return Html::tag('span', $model->stateStatus, ['class' => 'label label-success']);
                    else if ($model->stateStatus == 'Deactive')
                        return Html::tag('span', $model->stateStatus, ['class' => 'label label-danger']);
                },
                'headerOptions' => ['style'=>'border: 2px #000 solid;background-color:#480155;padding-right:10px;']
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => Helper::filterActionColumn('{view}{update}{changeStatus}'),
                'header' => 'Actions',
                'headerOptions' => ['style'=>'border: 2px #000 solid;background-color:#480155;padding-right:10px;'],
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        return Html::a(FA::icon('eye', ['class' => 'mr-5 mt-5 text-pink']), Yii::$app->request->baseUrl.'/master-state/view?id='.$key, [
                            'class' => 'activity-view-link',
                            'title' => Yii::t('yii', 'view'),
                            'data-toggle' => 'modal',
                            'data-id' => $key,
                            'data-pjax' => '0',
                        ]);                    
                    },
                    'update' => function ($url, $model, $key) {
                        return Html::a(FA::icon('edit', ['class' => 'mr-5 mt-5 text-info']), Yii::$app->request->baseUrl.'/master-state/update?id='.$key, [
                            'class' => 'activity-update-link',
                            'title' => Yii::t('yii', 'Update'),
                            'data-pjax' => '0',
                        ]);                    
                    },
                    'changeStatus' => function ($url, $model, $key) {
                        if ($model->stateStatus == 'Active') {                       
                            return Html::a(FA::icon('fa fa-toggle-on', ['class' => 'mr-5 mt-5 text-success']), ['master-state/change-status', 'id' => $key, 'stateStatus' => 'Deactive'], [
                                'class' => 'activity-update-link',
                                'title' => Yii::t('yii', 'Make Deactive'),
                                'data-confirm' => 'Are you sure you want to Deactivate this item?',
                                'data-method' => 'post',
                            ]);                    
                        }                  
                        else if ($model->stateStatus == 'Deactive') {
                            return Html::a(FA::icon('fa fa-toggle-off', ['class' => 'mr-5 mt-5 text-limered']), ['master-state/change-status', 'id' => $key, 'stateStatus' => 'Active'], [
                                'class' => 'activity-update-link',
                                'title' => Yii::t('yii', 'Make Active'),
                                'data-confirm' => 'Are you sure you want to Activate this item?',
                                'data-method' => 'post',    
                            ]);                                              
                        }
                    },
                    'delete' => function ($url, $model, $key) {
                        return Html::a(FA::icon('trash', ['class' => 'mr-5 mt-5 text-limered']), ['master-state/delete', 'id' => $key], [
                            'class' => 'activity-update-link',
                            'title' => Yii::t('yii', 'delete'),
                            'data-confirm' => 'Are you sure you want to delete this item?',
                            'data-method' => 'post',    
                        ]);                    
                    },
                ]
            ] 
        ],
        'layout' => "<div class='grid-panel-heading pb-10 pt-10 panel-heading clearfix'>
                    <div class='pull-left'>
                        <h3 class='panel-title'>States</h3>
                    </div>
                        {summary}
                    </div>\n
                    {items}\n
                    <div class='kv-panel-pager' style='border-top: 1px solid #adadad;'>
                        {pager}
                    </div>",
        'summaryOptions' => [
            'class' =>'pull-right',
        ],
        'options' => [
            'class' => 'table-grid border-with-radius bg-white',
        ],
        'tableOptions' => [
            'class' => 'table table-bordered table-striped table-hover',
            'style' => 'font-size: 13px; color: #000000;'
        ],
        'pager' => ['options' => ['class'=> 'pagination']],
    ]); ?>

</div>
