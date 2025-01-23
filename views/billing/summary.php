<?php

use kartik\grid\GridView;
use yii\helpers\Html;
use kartik\editable\Editable;
use yii\bootstrap\Modal;
use kartik\export\ExportMenu;
use yii\helpers\ArrayHelper;
use mdm\admin\components\Helper;
use app\models\User;
use rmrevin\yii\fontawesome\FA;
use rmrevin\yii\fontawesome\FAS;
use rmrevin\yii\fontawesome\FAR;
use app\models\PreinspectionClientBranch;
use app\models\PreinspectionClientDivision;
use app\models\PreinspectionClientCompany;
use app\models\AxionPreinspectionHoBilling;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AxionSpotsurveySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$role = array_keys(Yii::$app->authManager->getRolesByUser(Yii::$app->user->getId()))[0] ;

$companyData = ArrayHelper::map($company,'id','companyName');
$statesData = ArrayHelper::map($states,'id','state');
$sbuHeadData = ArrayHelper::map($sbuHead, 'id', 'name');

if ($branch)
    $branchData = ArrayHelper::map($branch,'id','branchName');

$gridColumns = [
    [
        'attribute'=>'orderNo',
        'label' => 'Bill ID',
        'vAlign'=>'middle',
        'headerOptions'=>['style'=>'border: 2px #000 solid; background-color:#480155;color:#fff;'],
        'contentOptions' => ['style' => 'border: 1px solid black;'], 
        /*'value' => function($model){
            $billNumber = explode("-",$model->billNumber);
            $id = end($billNumber);
            return (int) $id;
        },*/
        'filter' => true,
    ],
    [
        'attribute'=>'billNumber',
        'label' => 'Bill Number',
        'vAlign'=>'middle',
        'headerOptions'=>['style'=>'border: 2px #000 solid; background-color:#480155;color:#fff;'],
        'contentOptions' => ['style' => 'border: 1px solid black;']
    ],    
    [
        'attribute'=>'companyId',
        'label' => 'Company Name',
        'vAlign'=>'middle',
        'headerOptions'=>['style'=>'border: 2px #000 solid; background-color:#480155;color:#fff;'],
        'contentOptions' => ['style' => 'border: 1px solid black;'],
        'value'=>function ($model) {
            $insurerName = $model->callerCompany;
            if(isset($insurerName->companyName))
            {
                return  $insurerName->companyName;
            }
            else { return '';}
        },
        'filterType'=>GridView::FILTER_SELECT2,
        'filter' => $companyData,
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
        'label' => 'State',
        'attribute'=>'stateId',
        'vAlign'=>'middle',
        'headerOptions'=>['style'=>'border: 2px #000 solid; background-color:#480155;color:#fff;'],
        'contentOptions' => ['style' => 'border: 1px solid black;'],
        'value'=> function ($model){
        $state = $model->state->state;
        $stateName="";
        if($model->state){
            $stateName = $model->state->state;
        }else{
            if($model->billType !='State Bill' && $model->billType !='Branch Bill' && $model->parentId==""){
            $stateName="ALL";          
            }
        }
        return $stateName;
        },
        'filterType'=>GridView::FILTER_SELECT2,
        'filter' => $statesData,
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
        'attribute'=>'branchId',
        'vAlign'=>'middle',
        'headerOptions'=>['style'=>'border: 2px #000 solid; background-color:#480155;color:#fff;'],
        'contentOptions' => ['style' => 'border: 1px solid black;'],
        //'value'=> 'branch.branchName',
        'value'=> function ($model){
            $branchName="";
            if($model->branchId){
            $branchName = $model->branch->branchName;
            }else{
            if($model->billType !='State Bill' && $model->billType !='Branch Bill' && $model->parentId==""){
                $branchName="ALL";          
            }
            }
            return $branchName;
        },
        'filterType'=>GridView::FILTER_SELECT2,
        'filter' => $branchData,
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
        'attribute'=>'sbuHeadId',
        'vAlign'=>'middle',
        'headerOptions'=>['style'=>'border: 2px #000 solid; background-color:#480155;color:#fff;'],
        'contentOptions' => ['style' => 'border: 1px solid black;'],
        'filterType'=>GridView::FILTER_SELECT2,
        'filter' => $sbuHeadData,
        'filterWidgetOptions'=>[
            'pluginOptions' => [
                'allowClear'=>true,
                'tags' => true,
                'maximumInputLength' => 10
            ],
            'options' => ['placeholder' => 'Select'],
        ],
        'value' => function ($model) {
        $sbuHead = $model->sbuHead;
        if ($sbuHead)
        {
            return $sbuHead->name;
        }
        else
        {
            return '';
        }
        },
    ],

    [
        'attribute'=>'billAmount',
        'label' => 'Bill Amount',
        'vAlign'=>'middle',
        'headerOptions'=>['style'=>'border: 2px #000 solid; background-color:#480155;color:#fff;'],
        'contentOptions' => ['style' => 'border: 1px solid black;'],
        'filter' => true,
        'value' => function($model){
            return Yii::$app->api->showDecimal($model->billAmount);
        },
    ],  
    [
        'attribute'=>'totalGst',
        'label' => 'Total GST',
        'vAlign'=>'middle',
        'headerOptions'=>['style'=>'border: 2px #000 solid; background-color:#480155;color:#fff;'],
        'contentOptions' => ['style' => 'border: 1px solid black;'],
        'filter' => true,
        'value' => function($model){
            return Yii::$app->api->showDecimal($model->totalGst);
        },
    ],
    [
        'attribute'=>'totalAmount',
        'label' => 'Total Amount',
        'vAlign'=>'middle',
        'headerOptions'=>['style'=>'border: 2px #000 solid; background-color:#480155;color:#fff;'],
        'contentOptions' => ['style' => 'border: 1px solid black;'],
        'filter' => true,
        'value' => function($model){
            return Yii::$app->api->showDecimal($model->totalAmount);
        },
    ],
    [
        'attribute'=>'billPeriodFrom',
        'label' => 'Month/Year',
        'vAlign'=>'middle',
        'headerOptions'=>['style'=>'border: 2px #000 solid; background-color:#480155;color:#fff;'],
        'contentOptions' => ['style' => 'border: 1px solid black;'],
        'value' => function($model){
            $date = date('M-Y',strtotime($model->billPeriodFrom));

            return $date;
        },
        'format' => ['date', 'php:M-Y'],
        'filterType' => GridView::FILTER_DATE_RANGE,
        'filterWidgetOptions' =>([
            'convertFormat'=>true,
            'pluginOptions'=>[
                'timePicker'=>false,
                'locale'=>['format'=>'d-m-Y']
            ],
            'presetDropdown'=>true,
        ])
    ],
    [
        'attribute'=>'billStatus',
        'label' => 'Bill Status',
        'vAlign'=>'middle',
        'headerOptions'=>['style'=>'border: 2px #000 solid; background-color:#480155;color:#fff;'],
        'contentOptions' => ['style' => 'border: 1px solid black;'],
        'value' => function ($model){
            return $model->billStatus == 'Received'  ? 'Received' : 'Not Received';
            },
        'filterType'=>GridView::FILTER_SELECT2,
        'filter' => ['Received' => 'Received', 'Billed' => 'Not Received'],
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
        'attribute'=>'generatedBy',
        'label' => 'Generated By',
        'vAlign'=>'middle',
        'headerOptions'=>['style'=>'border: 2px #000 solid; background-color:#480155;color:#fff;'],
        'contentOptions' => ['style' => 'border: 1px solid black;'],
        'value' => 'user.firstName',
        'filter' => false,
    ],
    [
        'attribute'=>'manualUpdate',
        'vAlign'=>'middle',
        'headerOptions'=>['style'=>'border: 2px #000 solid; background-color:#480155;color:#fff;'],
        'contentOptions' => ['style' => 'border: 1px solid black;'],
        'filter' => false,
    ],
    [
        'attribute'=>'generatedDate',
        'label' => 'Generated Date',
        'vAlign'=>'middle',
        'headerOptions'=>['style'=>'border: 2px #000 solid; background-color:#480155;color:#fff;'],
        'contentOptions' => ['style' => 'border: 1px solid black;'],
        'value' => function($model){
            return date('d-m-Y',strtotime($model->generatedDate));
        },
        'format' => ['date', 'php:d-m-Y'],
        'filterType' => GridView::FILTER_DATE_RANGE,
        'filterWidgetOptions' =>([
            'convertFormat'=>true,
            'pluginOptions'=>[
                'timePicker'=>false,
                'locale'=>['format'=>'d-m-Y']
            ],
            'presetDropdown'=>true,
        ])
    ],
    [
    'class'=>'kartik\grid\ActionColumn',
        'template' => Helper::filterActionColumn('{update}{downloadPdf}{downloadMis}{SendReports}{remarks}{generateHo}{paymentUpdate}'),
        'headerOptions'=>['style'=>'border: 2px #fff solid; background-color:#480155;color:#fff;'],
        'buttons' => [    
        'update' => function ($url, $model, $key) {   
        $role = array_keys(Yii::$app->authManager->getRolesByUser(Yii::$app->user->getId()))[0] ;
        
                    if($role == 'Superadmin'){
                        return Html::a(FA::icon('edit', ['class' => 'mr-5 mt-5 text-success']),'#', [
                            'class' => 'update-link',
                            'title' => Yii::t('yii', 'Update'),
                            'data-toggle' => 'modal',
                            'data-target' => '#update-modal',
                            'data-id' => $key,
                            'data-pjax' => '0',

                        ]);
                    }                
            
            },     
            'downloadPdf' => function ($url, $model, $key) {
                return Html::a(FA::icon('file-pdf', ['class' => 'mr-5 mt-5 text-danger']),['summary'], [
                        'class' => 'downloadPdf',
                        'target' => '_blank',
                        'title' => Yii::t('yii', 'View/Download PDF'),  
                        'data-id'=>$model->id                         
                    ]);
            },
            'downloadMis' => function ($url, $model, $key) {
                return Html::a(FA::icon('file-excel', ['class' => 'mr-5 mt-5 text-success']),['summary'], [
                        'class' => 'downloadMis',
                        'target' => '_blank',
                        'title' => Yii::t('yii', 'Download MIS'),  
                        'data-id'=>$model->id                         
                    ]);
            },
            'SendReports' => function ($url, $model, $key) {
                // Only ITGI
                if ($model->companyId == 9)
                {
                    if ($model->mailSent == 0)
                    {
                        return Html::a(FA::icon('paper-plane', ['class' => 'mr-5 mt-5 text-limered']), ['billing/send-billing-report', 'id' => $model->id], [
                            'class' => 'send-reports-link',
                            'title' => Yii::t('yii', 'Send Reports'),
                            'data'=>[
                                'method' => 'post',
                                'confirm' => 'Are you sure to send the billing reports through email?',
                                'pjax' => '1',
                            ]
                        ]);
                    }
                    else
                    {
                        return Html::a(FA::icon('share-square', ['class' => 'mr-5 mt-5 text-limered']), ['billing/send-billing-report', 'id' => $model->id], [
                            'class' => 'send-reports-link',
                            'title' => Yii::t('yii', 'Resend Reports'),
                            'data'=>[
                                'method' => 'post',
                                'confirm' => 'Are you sure to resend the billing reports through email?',
                                'pjax' => '1',
                            ]
                        ]);
                    }
                }
            },
            'remarks' => function ($url, $model, $key) {
                return Html::a(FA::icon('comment', ['class' => 'mr-5 mt-5 text-primary']),'#', [
                            'class' => 'comment-link',
                            'title' => Yii::t('yii', 'Remarks'),
                            'data-toggle' => 'modal',
                            'data-target' => '#comment-modal',
                            'data-id' => $key,
                            'data-pjax' => '0',

                        ]);
            },
            'generateHo' => function ($url, $model, $key) { 
                $role = array_keys(Yii::$app->authManager->getRolesByUser(Yii::$app->user->getId()))[0];
                
                $res = false;
                if($model->billType!="State Bill"  && $model->billType!="Branch Bill"){
                        if($model->parentId){
                        $res = AxionPreinspectionHoBilling::find()->where(["OR",'billId'=>$model->id,"billId"=>$model->parentId])->andWhere(["stateId"=>$model->stateId])->one();
                    }
                }else{
                        $res = AxionPreinspectionHoBilling::find()->where(["OR",'billId'=>$model->id])->one();
                }

                $showBtn = $res ? false : true;
                
                if($showBtn && ($role == "BO User" || $role == 'Superadmin')){
                    return Html::a(FA::icon('generateHo', ['class' => 'mr-5 mt-5 text-success fa-money-bill']),['generate-ho', 'id' => $model->id], [
                            'title' => Yii::t('yii', 'Generate HO Bill'),
                            'id' => 'generateHoBill',
                            'data' => [
                                'confirm' => 'Are you sure you want to generate HO Bill?',
                                'method' => 'post',
                            ],
                        ]);
                }else{
                    return '';
                }
                
                
            },
            'paymentUpdate' => function ($url, $model, $key) {
                if($model->billStatus != 'Received' && $model->parentId == 0){
                    return Html::a(FA::icon('credit-card', ['class' => 'mr-5 mt-5 text-danger']),'#', [
                        'class' => 'paymentUpdate ml-5',
                        //'target' => '_blank',
                        'title' => Yii::t('yii', 'Payment Updation'),
                        'data-toggle' => 'modal',
                        'data-target' => '#ayment-update-modal',
                        'data-id' => $key,
                        'data-pjax' => '0',                      
                    ]);
                }
            } 
        ],
    ],
];

$selectedColums = [
    [
        'attribute'=>'orderNo',
        'label' => 'Bill ID',
        'vAlign'=>'middle',
        'headerOptions'=>['style'=>'border: 2px #000 solid; background-color:#480155;color:#fff;'],
        'contentOptions' => ['style' => 'border: 1px solid black;'], 
        /*'value' => function($model){
            $billNumber = explode("-",$model->billNumber);
            $id = end($billNumber);
            return (int) $id;
        },*/
        'filter' => true,
    ],
    [
        'attribute'=>'billNumber',
        'label' => 'Bill Number',
        'vAlign'=>'middle',
        'headerOptions'=>['style'=>'border: 2px #000 solid; background-color:#480155;color:#fff;'],
        'contentOptions' => ['style' => 'border: 1px solid black;']
    ],    
    [
        'attribute'=>'companyId',
        'label' => 'Company Name',
        'vAlign'=>'middle',
        'headerOptions'=>['style'=>'border: 2px #000 solid; background-color:#480155;color:#fff;'],
        'contentOptions' => ['style' => 'border: 1px solid black;'],
        'value'=>function ($model) {
            $insurerName = $model->callerCompany;
            if(isset($insurerName->companyName))
            {
                return  $insurerName->companyName;
            }
            else { return '';}
        },
        'filterType'=>GridView::FILTER_SELECT2,
        'filter' => $companyData,
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
        'label' => 'State',
        'attribute'=>'stateId',
        'vAlign'=>'middle',
        'headerOptions'=>['style'=>'border: 2px #000 solid; background-color:#480155;color:#fff;'],
        'contentOptions' => ['style' => 'border: 1px solid black;'],
        'value'=> function ($model){
        $state = $model->state->state;
        $stateName="";
        if($model->state){
            $stateName = $model->state->state;
        }else{
            if($model->billType !='State Bill' && $model->billType !='Branch Bill' && $model->parentId==""){
            $stateName="ALL";          
            }
        }
        return $stateName;
        },
        'filterType'=>GridView::FILTER_SELECT2,
        'filter' => $statesData,
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
        'attribute'=>'branchId',
        'vAlign'=>'middle',
        'headerOptions'=>['style'=>'border: 2px #000 solid; background-color:#480155;color:#fff;'],
        'contentOptions' => ['style' => 'border: 1px solid black;'],
        //'value'=> 'branch.branchName',
        'value'=> function ($model){
            $branchName="";
            if($model->branchId){
            $branchName = $model->branch->branchName;
            }else{
            if($model->billType !='State Bill' && $model->billType !='Branch Bill' && $model->parentId==""){
                $branchName="ALL";          
            }
            }
            return $branchName;
        },
        'filterType'=>GridView::FILTER_SELECT2,
        'filter' => $branchData,
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
        'attribute'=>'sbuHeadId',
        'vAlign'=>'middle',
        'headerOptions'=>['style'=>'border: 2px #000 solid; background-color:#480155;color:#fff;'],
        'contentOptions' => ['style' => 'border: 1px solid black;'],
        'filterType'=>GridView::FILTER_SELECT2,
        'filter' => $sbuHeadData,
        'filterWidgetOptions'=>[
            'pluginOptions' => [
                'allowClear'=>true,
                'tags' => true,
                'maximumInputLength' => 10
            ],
            'options' => ['placeholder' => 'Select'],
        ],
        'value' => function ($model) {
        $sbuHead = $model->sbuHead;
        if ($sbuHead)
        {
            return $sbuHead->name;
        }
        else
        {
            return '';
        }
        },
    ],

    [
        'attribute'=>'billAmount',
        'label' => 'Bill Amount',
        'vAlign'=>'middle',
        'headerOptions'=>['style'=>'border: 2px #000 solid; background-color:#480155;color:#fff;'],
        'contentOptions' => ['style' => 'border: 1px solid black;'],
        'filter' => true,
        'value' => function($model){
            return Yii::$app->api->showDecimal($model->billAmount);
        },
    ],  
    [
        'attribute'=>'totalIgst',
        'label' => 'Total IGST',
        'vAlign'=>'middle',
        'headerOptions'=>['style'=>'border: 2px #000 solid; background-color:#480155;color:#fff;'],
        'contentOptions' => ['style' => 'border: 1px solid black;'],
        'filter' => true,
        'value' => function($model){
            return Yii::$app->api->showDecimal($model->totalIgst);
        },
    ],
    [
        'attribute'=>'totalCgst',
        'label' => 'Total CGST',
        'vAlign'=>'middle',
        'headerOptions'=>['style'=>'border: 2px #000 solid; background-color:#480155;color:#fff;'],
        'contentOptions' => ['style' => 'border: 1px solid black;'],
        'filter' => true,
        'value' => function($model){
            return Yii::$app->api->showDecimal($model->totalCgst);
        },
    ],
    [
        'attribute'=>'totalSgst',
        'label' => 'Total SGST',
        'vAlign'=>'middle',
        'headerOptions'=>['style'=>'border: 2px #000 solid; background-color:#480155;color:#fff;'],
        'contentOptions' => ['style' => 'border: 1px solid black;'],
        'filter' => true,
        'value' => function($model){
            return Yii::$app->api->showDecimal($model->totalSgst);
        },
    ],
    [
        'attribute'=>'totalGst',
        'label' => 'Total GST',
        'vAlign'=>'middle',
        'headerOptions'=>['style'=>'border: 2px #000 solid; background-color:#480155;color:#fff;'],
        'contentOptions' => ['style' => 'border: 1px solid black;'],
        'filter' => true,
        'value' => function($model){
            return Yii::$app->api->showDecimal($model->totalGst);
        },
    ],
    [
        'attribute'=>'totalAmount',
        'label' => 'Total Amount',
        'vAlign'=>'middle',
        'headerOptions'=>['style'=>'border: 2px #000 solid; background-color:#480155;color:#fff;'],
        'contentOptions' => ['style' => 'border: 1px solid black;'],
        'filter' => true,
        'value' => function($model){
            return Yii::$app->api->showDecimal($model->totalAmount);
        },
    ],
    [
        'attribute'=>'billPeriodFrom',
        'label' => 'Month/Year',
        'vAlign'=>'middle',
        'headerOptions'=>['style'=>'border: 2px #000 solid; background-color:#480155;color:#fff;'],
        'contentOptions' => ['style' => 'border: 1px solid black;'],
        'value' => function($model){
            $date = date('M-Y',strtotime($model->billPeriodFrom));

            return $date;
        },
        'format' => ['date', 'php:M-Y'],
        'filterType' => GridView::FILTER_DATE_RANGE,
        'filterWidgetOptions' =>([
            'convertFormat'=>true,
            'pluginOptions'=>[
                'timePicker'=>false,
                'locale'=>['format'=>'d-m-Y']
            ],
            'presetDropdown'=>true,
        ])
    ],
    [
        'attribute'=>'billStatus',
        'label' => 'Bill Status',
        'vAlign'=>'middle',
        'headerOptions'=>['style'=>'border: 2px #000 solid; background-color:#480155;color:#fff;'],
        'contentOptions' => ['style' => 'border: 1px solid black;'],
        'value' => function ($model){
            return $model->billStatus == 'Received'  ? 'Received' : 'Not Received';
            },
        'filterType'=>GridView::FILTER_SELECT2,
        'filter' => ['Received' => 'Received', 'Billed' => 'Not Received'],
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
        'attribute'=>'generatedBy',
        'label' => 'Generated By',
        'vAlign'=>'middle',
        'headerOptions'=>['style'=>'border: 2px #000 solid; background-color:#480155;color:#fff;'],
        'contentOptions' => ['style' => 'border: 1px solid black;'],
        'value' => 'user.firstName',
        'filter' => false,
    ],
    [
        'attribute'=>'manualUpdate',
        'vAlign'=>'middle',
        'headerOptions'=>['style'=>'border: 2px #000 solid; background-color:#480155;color:#fff;'],
        'contentOptions' => ['style' => 'border: 1px solid black;'],
        'filter' => false,
    ],
    [
        'attribute'=>'generatedDate',
        'label' => 'Generated Date',
        'vAlign'=>'middle',
        'headerOptions'=>['style'=>'border: 2px #000 solid; background-color:#480155;color:#fff;'],
        'contentOptions' => ['style' => 'border: 1px solid black;'],
        'value' => function($model){
            return date('d-m-Y',strtotime($model->generatedDate));
        },
        'format' => ['date', 'php:d-m-Y'],
        'filterType' => GridView::FILTER_DATE_RANGE,
        'filterWidgetOptions' =>([
            'convertFormat'=>true,
            'pluginOptions'=>[
                'timePicker'=>false,
                'locale'=>['format'=>'d-m-Y']
            ],
            'presetDropdown'=>true,
        ])
    ],
];

$models = $dataProvider->getModels();
$ids = [];
foreach ($models as $model) {
    $ids[] = $model->id;
}

//Pjax::begin();

$perPage =  \nterms\pagesize\PageSize::widget(
[   
    'template' => '{list}',
    'defaultPageSize' => 50,
    'sizes' => [10=>10,20=>20,50=>50,100=>100,200=>200,500=>500],
    'options' => ['class'=>'perPage']
] 
);

$fullExportMenu = ExportMenu::widget([
    'dataProvider' => $dataProvider,
    'columns' => $selectedColums,
    'target' => ExportMenu::TARGET_BLANK,
    'showConfirmAlert'=>false,
    'asDropdown' => false, // this is important for this case so we just need to get a HTML list    
    'dropdownOptions' => [
        'label' => 'Download MIS'
    ],
    'exportConfig' => [ // set styling for your custom dropdown list items
       
    ],
]);

echo GridView::widget([
    'dataProvider'=>$dataProvider,
    'filterModel'=>$searchModel,
    'columns'=>$gridColumns,
    'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => ''],
    'rowOptions'=>['style'=>'border: 2px #000 solid'],
    'containerOptions'=>['style'=>'overflow: auto; font-size:12px;'], // only set when $responsive = false
    'headerRowOptions'=>['class'=>'kartik-sheet-style'],
    'filterRowOptions'=>['class'=>'kartik-sheet-style'],
    'pjax'=>true, // pjax is set to always true for this demo
    // set your toolbar
    'toolbar'=> [

        ['content'=>

            Html::a(FA::icon('redo'), [''], ['data-pjax'=>0, 'class'=>'btn btn-default', 'title'=>Yii::t('app', 'Reset Grid')])
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
    /*'export'=>[
        'fontAwesome'=>true,
        'showConfirmAlert'=>false,
        'target'=>GridView::TARGET_BLANK,
        'label'=>'Export',
        'header'=>'<li role="presentation" class="dropdown-header">Axion Preinspection Completed Records</li>',
    ],*/
    'export' => [
        'label'=>'Download Billing Summary',
        'header'=>'<li role="presentation" class="dropdown-header">Axion Preinspection Completed Records</li>',
        'itemsAfter'=> [
            $fullExportMenu
        ],
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
        'headingOptions' => ['class'=>'panel-heading grid-panel-heading pt-10 pb-10 mb-15'],
        'footerOptions' => ['class'=>'panel-footer grid-panel-footer'],
        'heading'=>'Completed Case'
    ],
    'resizableColumns'=>false,
    'persistResize'=>false,
    'exportConfig' => [ // set styling for your custom dropdown list items
      ExportMenu::PDF => ['label' => false, 'icon' => false,'visible' => false,'hidden' => true]
    ],
]);

//Pjax::end(); 
?>
<style type="text/css">
    .btn-toolbar .dropdown{
        width: auto !important;
    }
    .perPage{
        height: 33px;
        margin: 0px 3px 0px 1px;
        padding: 5px 15px;
    }
    
</style>

<?php
$pdfurl = Yii::$app->request->baseUrl."/billing/download-pdf";
$updateUrl = Yii::$app->request->baseUrl."/billing/bill-update";
$commentUrl = Yii::$app->request->baseUrl."/billing/remarks";
$misUrl = Yii::$app->request->baseUrl."/billing/download-mis";
$sendReport = Yii::$app->request->baseUrl."/billing/send-billing-report";
$paymentupdateUrl = Yii::$app->request->baseUrl."/billing/payment-update";
$this->registerJs(
        "
    $('body').on('click', '.downloadPdf', function() {
        var id = $(this).attr('data-id');
        console.log(id);
        var url = '$pdfurl'+'?billId='+id;
        window.open(
          url,
          '_blank'
        );
    });

     $('body').on('click', '.downloadMis', function() {
        var id = $(this).attr('data-id');
        var url = '$misUrl'+'?billId='+id;
        window.open(
          url,
          '_blank'
        );
    });

    $('body').on('click', '.update-link', function() {
        $.get(
            '".$updateUrl."',
            {
                id: $(this).data('id')
            },
            function (data) {
                $('#update-modal').find('.modal-body').html(data);
                $('#update-modal').modal();
            }
        );
    });

    $('#update-modal').on('hidden.bs.modal', function (e) {
        $(this).find('.modal-body').html('');
    });

    $('body').on('click', '.comment-link', function() {
        $.get(
            '".$commentUrl."',
            {
                id: $(this).data('id')
            },
            function (data) {
                $('#comment-modal').find('.modal-body').html(data);
                $('#comment-modal').modal();
                $('#remarks-form').trigger('reset');
            }
        );
    });

    $('#comment-modal').on('hidden.bs.modal', function (e) {
        $(this).find('.modal-body').html('');
    });
    $('body').on('click', '.paymentUpdate', function() {
        $.get(
            '".$paymentupdateUrl."',
            {
                id: $(this).data('id')
            },
            function (data) {
                $('#payment-update-modal').find('.modal-body').html(data);
                $('#payment-update-modal').modal();
            }
        );
    });
    $('#payment-update-modal').on('hidden.bs.modal', function (e) {
        $(this).find('.modal-body').html('');
    });
"
);
?>

<?php Modal::begin([
    'id' => 'update-modal',
    'size' => Modal::SIZE_LARGE,
    'header' => '<h4 class="modal-title">Update Record</h4>',
    'footer' => '<a href="#" class="btn btn-primary" data-dismiss="modal">Close</a>',

]); ?>
<?php Modal::end(); ?>

<?php Modal::begin([
    'id' => 'comment-modal',
    'size' => Modal::SIZE_LARGE,
    'header' => '<h4 class="modal-title">Remarks</h4>',
    'footer' => '<a href="#" class="btn btn-primary" data-dismiss="modal">Close</a>',

]); ?>
<?php Modal::end(); ?>

<?php Modal::begin([
    'id' => 'payment-update-modal',
    'size' => Modal::SIZE_LARGE,
    'header' => '<h4 class="modal-title">Payment Update</h4>',
    'footer' => '<a href="#" class="btn btn-primary" data-dismiss="modal">Close</a>',

]); ?>
<?php Modal::end(); ?>