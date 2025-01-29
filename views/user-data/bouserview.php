<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;
use rmrevin\yii\fontawesome\FA;
use rmrevin\yii\fontawesome\FAS;
use rmrevin\yii\fontawesome\FAR;

/* @var $this yii\web\View */
/* @var $model app\models\Userdata */

$this->title = $model->firstName;
$this->params['breadcrumbs'][] = ['label' => 'RO UserList', 'url' => ['bouser']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="userdata-view">

    <p class="clearfix">
        <?= Html::a(FA::icon('trash', ['class' => 'mr-3 mt-5 text-white']).' Delete', ['delete-bouser', 'id' => $model->id], [
                'class' => 'btn btn-danger pull-right',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]) 
        ?>
        <?= Html::a(FA::icon('edit', ['class' => 'mr-3 mt-5 text-white']).' Update', ['update-bouser', 'id' => $model->id], [
            'class' => 'btn btn-primary pull-right mr-10'
            ]) 
        ?>
    </p>

    <div id="RO_details" class="panel panel-primary">
        <div class="panel-heading light-panel-heading pb-15">
            <h4 class="panel-title"><?= $model->firstName?></h4>
        </div>
        
        <div class="panel-body">

            <?php
                echo DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        ['attribute'=>'firstName','label'=>'RO Name'],
                        
                        'ownerName',
                        'address',
                        'pan_number',
                        'gst_number',
                        'bank_name',
                        'account_number',
                        'ifsc_code',
                        'branch_name',
                        'gst_number',
                        'email',
                        'mobile',
                        'activeFromDate',
                        'royaltyOnFees',
                        'royaltyOnConveyance'
                    ],
                ]);

            ?>
        </div>
    </div>

    <div id="ROcase_details" class="panel panel-primary">
        <div class="panel-heading light-panel-heading pb-15">
            <h4 class="panel-title"><?= $model->firstName?> Case Count Lists</h4>
        </div>
        
        <div class="panel-body">

            <?php
                echo GridView::widget([
                    'dataProvider' => $dataProvider,     
                    'rowOptions'=>['style'=>'border: 2px #000 solid'],
                    'headerRowOptions'=>['class'=>'kartik-sheet-style','style'=>'border: 2px #000 solid; background-color:#480155;color:#fff !important ;'],       
                    'options' => [
                        'style' => 'font-size: 13px; color: #000000;',
                        'class' => 'p-15'
                    ],
                    'columns' => [
                        ['class' => 'kartik\grid\SerialColumn', 'noWrap' => 1],
                        [ 
                            'attribute' => 'companyId',
                            'value'=>function ($model) {
                                $insurerName = $model->company;
                                if(isset($insurerName->companyName))
                                {
                                       return  $insurerName->companyName;
                                }
                                else { return '';}
                            },
                            'headerOptions'=>['class'=>'kartik-sheet-style','style'=>'border: 2px #000 solid; background-color:#480155;color:#fff;']    
                        ],                    
                        [ 
                            'attribute' => 'caseCnt',
                            'headerOptions'=>['class'=>'kartik-sheet-style','style'=>'border: 2px #000 solid; background-color:#480155;color:#fff !important;'],
                            'noWrap' => 1,
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
            ?>
        </div>
    </div>

</div>
