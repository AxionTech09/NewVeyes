<?php

use kartik\grid\GridView;
use yii\helpers\Html;
use kartik\editable\Editable;
use yii\bootstrap\Modal;
use kartik\export\ExportMenu;
use yii\helpers\ArrayHelper;
use mdm\admin\components\Helper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AxionSpotsurveySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>



<?php
$paymentArray = $searchModel->paymentValue;
$valuatorData=ArrayHelper::map($valuator,'id','firstName');
$companyData=ArrayHelper::map($company,'id','companyName');

if($branch != '')
{
   $branchData=ArrayHelper::map($branch,'id','branchName'); 
}
 else {
    $branchData='';
}

$gridColumns = [

     [
    'class'=>'kartik\grid\ActionColumn',
    /*'dropdown'=>true,
    'dropdownOptions'=>['class'=>'pull-right'],*/
	//'template' => '{view} {update} {delete}',
        'template' => Helper::filterActionColumn('{fourwheelerqc}{fourwheelerpdf}{downloadphotos}'),
        'headerOptions'=>['class'=>'kartik-sheet-style'],
        'headerOptions'=>['style'=>'border: 2px #000 solid; background-color:#337ab7;color:#fff;'],
	 'buttons' => [
            /*
            'view' => function ($url, $model, $key) {
                return Html::a('<span class="glyphicon glyphicon-eye-open"></span>','#', [
                    'class' => 'activity-view-link',
                    'title' => Yii::t('yii', 'View'),
                    'data-toggle' => 'modal',
                    'data-target' => '#view-modal',
                    'data-id' => $key,
                    'data-pjax' => '0',

                ]);
            },
             *
             */

            'fourwheelerqc' => function ($url, $model, $key) {
                if(strtolower(preg_replace('/[^\w]/', '', $model->vehicleType)) == '4wheeler')
                {
                return Html::a('<span class="glyphicon glyphicon-check msize"></span>',Yii::$app->request->baseUrl.'/axion-valuation/fourwheelerqc?id='.$key, [
                    'class' => 'activity-transaction-link',
                    'title' => Yii::t('yii', 'QC'),
                    'data-id' => $key,
                    'data-pjax' => '0',
                    'target'=>'_blank',

                ]);
                }
                else if(strtolower(preg_replace('/[^\w]/', '', $model->vehicleType)) == 'commercial')
                {
                   return Html::a('<span class="glyphicon glyphicon-check msize"></span>',Yii::$app->request->baseUrl.'/axion-valuation/commercialqc?id='.$key, [
                    'class' => 'activity-transaction-link',
                    'title' => Yii::t('yii', 'QC'),
                    'data-id' => $key,
                    'data-pjax' => '0',
                    'target'=>'_blank',

                ]); 
                }
            },
                    
            'fourwheelerpdf' => function ($url, $model, $key) {
                if($model->status == 101 || $model->status == 102 || $model->status == 104) 
                {
                    if(strtolower(preg_replace('/[^\w]/', '', $model->vehicleType)) == '4wheeler')
                {
                    return " ".Html::a('<span class="glyphicon glyphicon-download msize"></span>',Yii::$app->request->baseUrl.'/axion-valuation/fourwheelerpdf?id='.$model->id, [
                        'class' => 'activity-transaction-link',
                        'title' => Yii::t('yii', 'Download Report'),
                        'data-id' => $key,
                        'data-pjax' => '0',
                        'target'=>'_blank',

                    ]);
                }
                else if(strtolower(preg_replace('/[^\w]/', '', $model->vehicleType)) == 'commercial')
                {
                   return " ".Html::a('<span class="glyphicon glyphicon-download msize"></span>',Yii::$app->request->baseUrl.'/axion-valuation/commercialpdf?id='.$model->id, [
                    'class' => 'activity-transaction-link',
                    'title' => Yii::t('yii', 'Download Report'),
                    'data-id' => $key,
                    'data-pjax' => '0',
                    'target'=>'_blank',

                    ]);
                }
                    
                
                }
            },
            'downloadphotos' => function ($url, $model, $key) {
                if($model->status == 101 || $model->status == 102 || $model->status == 104) 
                {
                    return Html::a('<span class="glyphicon glyphicon-download-alt msize"></span>',Yii::$app->request->baseUrl.'/axion-valuation/downloadphotos?id='.$key, [
                        'class' => 'activity-transaction-link',
                        'title' => Yii::t('yii', 'Download Photos'),
                        'data-id' => $key,
                        'data-pjax' => '0',
                        'target'=>'_blank',

                    ]);
                }
            },         

        ],
    ],

     /*
    [
    'class'=>'kartik\grid\CheckboxColumn',
    'headerOptions'=>['class'=>'kartik-sheet-style'],
    'headerOptions'=>['style'=>'border: 2px #000 solid; background-color:#337ab7;color:#fff;'],
    ],
                     *
                     */

// the name column configuration
 [
        'attribute'=>'referenceNo',
        'vAlign'=>'middle',
        'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#337ab7;padding-right:10px;'],
    ],

    [
        'attribute'=>'insurerName',
        'vAlign'=>'middle',
        'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#337ab7;padding-right:10px;'],
        'value'=>function ($model) {
            $insurerName = $model->callerCompany;
            if(isset($insurerName->companyName))
            {
                   return  $insurerName->companyName;
            }
            else { return '';}
         },
         'filterType'=>GridView::FILTER_SELECT2,
                'filter'=>$companyData,
        'filterWidgetOptions'=>[
                'pluginOptions' => [
                    'allowClear'=>true,
                    'tags' => true,
                    'maximumInputLength' => 10
                ],
            'options' => ['placeholder' => 'Select'],
            ]        
    ],


    [
        'attribute'=>'insurerBranch',
        'vAlign'=>'middle',
        'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#337ab7;'],
        'value'=>function ($model) {
            $insurerBranch = $model->callerBranch;
            if(isset($insurerBranch->branchName))
            {
                   return  $insurerBranch->branchName;
            }
            else { return '';}
         },
           'filterType'=>GridView::FILTER_SELECT2,
           'filter'=>$branchData,
   'filterWidgetOptions'=>[
           'pluginOptions' => [
               'allowClear'=>true,
               'tags' => true,
               'maximumInputLength' => 10
           ],
       'options' => ['placeholder' => 'Select'],
       ]  
    ],




    [
        'attribute'=>'intimationDate',
        'vAlign'=>'middle',
        'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#337ab7;padding-right:10px;'],
        'format' => ['date', 'php:d-m-Y h:i a'],
        'filterType' => GridView::FILTER_DATE_RANGE,
                'filterWidgetOptions' =>([
                    'convertFormat'=>true,
                'pluginOptions'=>[
                     'timePicker'=>true,
                     'timePickerIncrement'=>15,
                     'locale'=>['format'=>'d-m-Y h:i A']
                ],
                    'presetDropdown'=>true,
            ])
    ],


    [
        'attribute'=>'customerName',
        'vAlign'=>'middle',
        'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#337ab7;'],
    ],


    [
        'attribute'=>'registrationNo',
        'vAlign'=>'middle',
        'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#337ab7;'],
    ],

    [
        'attribute'=>'vehicleType',
        'vAlign'=>'middle',
        'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#337ab7;'],
    ],


    [
        'attribute'=>'surveyorName',
        'vAlign'=>'middle',
        'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#337ab7;'],
        'value'=>function ($model) {
            $valuatorUser = $model->valuatorUser;
            if(isset($valuatorUser->firstName))
            {
                   return  $valuatorUser->firstName;
            }
            else { return '';}
         },

        'filterType'=>GridView::FILTER_SELECT2,
                'filter'=>$valuatorData,
        'filterWidgetOptions'=>[
                'pluginOptions' => [
                    'allowClear'=>true,
                    'tags' => true,
                    'maximumInputLength' => 10
                ],
            'options' => ['placeholder' => 'Select', 'multiple' => true],
            ]

    ],



    [
        'attribute'=>'status',
        'vAlign'=>'middle',
        'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#337ab7;padding-right:100px;'],
        'value'=>function ($model) {
            $status = $model->status;
            
            if($status == 101)
            {
                return  'PI-Recommended';
            }
            else if($status == 102)
            {
                return  'PI-Not Recommended';
            }
            else if($status == 103)
            {
                return  'PI-Inprogress';
            }
            else if($status == 104)
            {
                return  'PI-Refer to Under Writer';
            }
            else { return '';}
         },
        'filterType'=>GridView::FILTER_SELECT2,
                'filter'=>['101'=>'PI-Recommended','102'=>'PI-Not Recommended','103'=>'PI-Inprogress','104'=>'PI-Refer to Under Writer'],
        'filterWidgetOptions'=>[
                'pluginOptions' => [
                    'allowClear'=>true,
                    'tags' => true,
                    'maximumInputLength' => 10
                ],
            'options' => ['placeholder' => 'Select', 'multiple' => true],
            ]
    ],

    [
        'attribute'=>'callerDetails',
        'vAlign'=>'middle',
        'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#337ab7;padding-right:10px;'],

    ],

     [
        'attribute'=>'completedSurveyDateTime',
        'vAlign'=>'middle',
        'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#337ab7;padding-right:10px;'],
        'format' => ['date', 'php:d-m-Y h:i a'],
        'filterType' => GridView::FILTER_DATE_RANGE,
                'filterWidgetOptions' =>([
                    'convertFormat'=>true,
                'pluginOptions'=>[
                     'timePicker'=>true,
                     'timePickerIncrement'=>15,
                     'locale'=>['format'=>'d-m-Y h:i A']
                ],
                    'presetDropdown'=>true,
            ])
    ],

    [
        'attribute'=>'remarks',
        'vAlign'=>'middle',
        'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#337ab7;'],
    ],



];

    echo GridView::widget([
        'dataProvider'=>$dataProvider,
        'filterModel'=>$searchModel,
        'columns'=>$gridColumns,
        'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => ''],
        'rowOptions'=>['style'=>'border: 2px #000 solid'],
        'rowOptions' => function ($model){
          if($model->status == '0' && $model->followupRemainder == '' ){
              return ['style'=>'background-color: #FBDBDF;'];
          }else{
            return [];
          }
        },
        'containerOptions'=>['style'=>'overflow: auto; font-size:12px;'], // only set when $responsive = false
        'headerRowOptions'=>['class'=>'kartik-sheet-style'],
        'filterRowOptions'=>['class'=>'kartik-sheet-style'],
        'pjax'=>true, // pjax is set to always true for this demo
        // set your toolbar
        'toolbar'=> [

            ['content'=>

                Html::a('<i class="glyphicon glyphicon-repeat"></i>', [''], ['data-pjax'=>0, 'class'=>'btn btn-default', 'title'=>Yii::t('app', 'Reset Grid')])
            ],

            '{export}',
            '{toggleData}',
            /*
            ['content'=>(Yii::$app->user->identity->type != 'Admin')? false:
                Html::a('Delete','#', [
                        'id' => 'activity-mul-delete-link',
                        'class'=>'btn btn-success',
                        'title' => Yii::t('yii', 'Delete'),
                        'data-pjax' => '0',
                    ])
            ],
             *
             */
        ],
        // set export properties
        'export'=>[
            'fontAwesome'=>true,
            'showConfirmAlert'=>false,
            'target'=>GridView::TARGET_BLANK,
            'label'=>'Export',
            'header'=>'<li role="presentation" class="dropdown-header">Axion Valuation Completed Records</li>',
        ],
        // parameters from the demo form
        'bordered'=>false,
        'striped'=>false,
        'condensed'=>false,
        'responsive'=>true,
        'responsiveWrap'=>false,
        'hover'=>true,
        'showPageSummary'=>false,
        'panel'=>[
            'type'=>GridView::TYPE_PRIMARY,
            'heading'=>'Completed Case'
        ],
        'resizableColumns'=>false,
        'persistResize'=>false,
        'exportConfig'=>  [
        ]
    ]);


?>
