<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\CompanyBillingAddress;
//use yii\grid\GridView;
use kartik\grid\GridView;
use rmrevin\yii\fontawesome\FA;
use rmrevin\yii\fontawesome\FAS;
use rmrevin\yii\fontawesome\FAR;

/* @var $this yii\web\View */
/* @var $model app\models\PreinspectionClientCompany */

$this->title = $model->companyName;
$this->params['breadcrumbs'][] = ['label' => 'Preinspection Client Companies', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="preinspection-client-company-view data-view-table">

    <div id="company_details" class="panel panel-primary">
        <div class="panel-heading light-panel-heading pb-15">
            <h4 class="panel-title"><?= $model->companyName?></h4>
        </div>
        
        <div class="panel-body">

            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'companyName',
                    'billType',
                    'rate2Wheeler',
                    'rate3Wheeler',
                    'rate4Wheeler',
                    'rateCommercial',
                    'rateConveyance',
                    'gstNo',
                    'igst',
                    'sgst',
                    'cgst',
                    'billingAddress'
                ],
                'options' => [
                    'class' => 'table table-bordered table-striped table-hover',
                    'style' => 'font-size: 13px; color: #000000;'
                ],
            ]) ?>
            <?php
                if($dataProvider && $dataProvider->getTotalCount()>0){
                    echo GridView::widget([
                        'dataProvider' => $dataProvider,     
                        'rowOptions'=>['style'=>'border: 2px #000 solid'],
                        'headerRowOptions'=>['class'=>'kartik-sheet-style','style'=>'border: 2px #000 solid; background-color:#480155;color:#fff !important ;'],       
                        'options' => [
                            'style' => 'font-size: 13px; color: #000000;',
                        ],
                        'columns' => [
                            ['class' => 'kartik\grid\SerialColumn', 'noWrap' => 1],
                            [ 
                                'attribute' => 'state.state',
                                'label'=>'State',
                                'headerOptions'=>['class'=>'kartik-sheet-style','style'=>'border: 2px #000 solid; background-color:#480155;color:#fff;']    
                            ],
                            [ 
                                'attribute' => 'rate2Wheeler',
                                'headerOptions'=>['class'=>'kartik-sheet-style','style'=>'border: 2px #000 solid; background-color:#480155;color:#fff !important;'],
                                'noWrap' => 1,
                            ],
                            [ 
                                'attribute' => 'rate3Wheeler',
                                'headerOptions'=>['class'=>'kartik-sheet-style','style'=>'border: 2px #000 solid; background-color:#480155;color:#fff;'],    
                                'noWrap' => 1,
                            ],
                            [ 
                                'attribute' => 'rate4Wheeler',
                                'headerOptions'=>['class'=>'kartik-sheet-style','style'=>'border: 2px #000 solid; background-color:#480155;color:#fff;'],    
                                'noWrap' => 1,
                            ],
                            [ 
                                'attribute' => 'rateCommercial',
                                'headerOptions'=>['class'=>'kartik-sheet-style','style'=>'border: 2px #000 solid; background-color:#480155;color:#fff;'],    
                            ],
                            [ 
                                'attribute' => 'rateConveyance',
                                'headerOptions'=>['class'=>'kartik-sheet-style','style'=>'border: 2px #000 solid; background-color:#480155;color:#fff;']    
                            ],
                            [ 
                                'attribute' => 'gstNo',
                                'headerOptions'=>['class'=>'kartik-sheet-style','style'=>'border: 2px #000 solid; background-color:#480155;color:#fff;']    
                            ],
                            [ 
                                'attribute' => 'igst',
                                'headerOptions'=>['class'=>'kartik-sheet-style','style'=>'border: 2px #000 solid; background-color:#480155;color:#fff;']    
                            ],
                            [ 
                                'attribute' => 'sgst',
                                'headerOptions'=>['class'=>'kartik-sheet-style','style'=>'border: 2px #000 solid; background-color:#480155;color:#fff;']    
                            ],
                            [ 
                                'attribute' => 'cgst',
                                'headerOptions'=>['class'=>'kartik-sheet-style','style'=>'border: 2px #000 solid; background-color:#480155;color:#fff;']    
                            ],
                            [ 
                                'attribute' => 'address',
                                'headerOptions'=>['class'=>'kartik-sheet-style','style'=>'border: 2px #000 solid; background-color:#480155;color:#fff;']    
                            ],
                        ],
                        'responsive'=>true,
                        'bordered'=>false,
                        'striped'=>false,
                        'condensed'=>false,
                        'responsive'=>true,
                        'responsiveWrap'=>false,
                        'layout'=> "{items}"

                    ]);
                }
            ?>

            <p class="text-center">
                <?= Html::a(FA::icon('edit', ['class' => 'mr-3 mt-5 text-white']).' Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary btn-sm']) ?>
                <?php /* Html::a('Delete', ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => 'Are you sure you want to delete this item?',
                        'method' => 'post',
                    ],
                ])*/ ?>
            </p>
        </div>
    </div>

</div>