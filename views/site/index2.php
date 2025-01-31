<?php

/* @var $this yii\web\View */
use kartik\grid\GridView;
use yii\helpers\Html;
use kartik\editable\Editable;

$gridColumns = [
    
     [
    'class'=>'kartik\grid\ActionColumn',
    /*'dropdown'=>true,
    'dropdownOptions'=>['class'=>'pull-right'],
    'urlCreator'=>function($action, $model, $key, $index) { return '#'; },
    'viewOptions'=>['title'=>'', 'data-toggle'=>'tooltip'],
    'updateOptions'=>['title'=>'', 'data-toggle'=>'tooltip'],
    'deleteOptions'=>['title'=>'', 'data-toggle'=>'tooltip'], */
	'template' => '{view} {update} {delete}{my_button}',
    'headerOptions'=>['class'=>'kartik-sheet-style'],
    ],    
// the name column configuration
    [
        'class'=>'kartik\grid\EditableColumn',
        'attribute'=>'requestNo',
        'vAlign'=>'middle',
        'width'=>'210px',
        'readonly'=>function($model, $key, $index, $widget) {
            return (!$model->requestNo); // do not allow editing of inactive records
        }, 
        'editableOptions'=>[
            'header'=>'Request No', 
            'size'=>'md',
            'inputType'=>\kartik\editable\Editable::INPUT_TEXT,
        ],
    ],

    [
        'class'=>'kartik\grid\EditableColumn',
        'attribute'=>'clientName',
        'vAlign'=>'middle',
        'width'=>'210px',
        'readonly'=>function($model, $key, $index, $widget) {
            return (!$model->clientName); // do not allow editing of inactive records
        },
        'editableOptions'=>[
            'header'=>'Client Name', 
            'size'=>'md',
            'inputType'=>\kartik\editable\Editable::INPUT_TEXT,
        ],
    ],
    
    [
        'class'=>'kartik\grid\EditableColumn',
        'attribute'=>'clientCity',
        'vAlign'=>'middle',
        'width'=>'210px',
        'readonly'=>function($model, $key, $index, $widget) {
            return (!$model->clientCity); // do not allow editing of inactive records
        }, 
        'editableOptions'=>[
            'header'=>'Client City', 
            'size'=>'md',
            'inputType'=>\kartik\editable\Editable::INPUT_TEXT,
        ],
    ],
    
    [
        'class'=>'kartik\grid\EditableColumn',
        'attribute'=>'mailId',
        'vAlign'=>'middle',
        'width'=>'210px',
        'readonly'=>function($model, $key, $index, $widget) {
            return (!$model->mailId); // do not allow editing of inactive records
        },
        'editableOptions'=>[
            'header'=>'Mail ID', 
            'size'=>'md',
            'inputType'=>\kartik\editable\Editable::INPUT_TEXT,
        ],
    ],
    
    [
        'class'=>'kartik\grid\EditableColumn',
        'attribute'=>'customerName',
        'vAlign'=>'middle',
        'width'=>'210px',
        'readonly'=>function($model, $key, $index, $widget) {
            return (!$model->customerName); // do not allow editing of inactive records
        },
        'editableOptions'=>[
            'header'=>'Customer Name', 
            'size'=>'md',
            'inputType'=>\kartik\editable\Editable::INPUT_TEXT,
        ],
    ],
    
    [
        'class'=>'kartik\grid\EditableColumn',
        'attribute'=>'customerMobileNo',
        'vAlign'=>'middle',
        'width'=>'210px',
        'readonly'=>function($model, $key, $index, $widget) {
            return (!$model->customerMobileNo); // do not allow editing of inactive records
        },
        'editableOptions'=>[
            'header'=>'Customer Mobile No', 
            'size'=>'md',
            'inputType'=>\kartik\editable\Editable::INPUT_TEXT,
        ],
    ],
    
    [
        'class'=>'kartik\grid\EditableColumn',
        'attribute'=>'vehicleNumber',
        'vAlign'=>'middle',
        'width'=>'210px',
        'readonly'=>function($model, $key, $index, $widget) {
            return (!$model->vehicleNumber); // do not allow editing of inactive records
        },
        'editableOptions'=>[
            'header'=>'Vehicle Number', 
            'size'=>'md',
            'inputType'=>\kartik\editable\Editable::INPUT_TEXT,
        ],
    ],
    
    [
        'class'=>'kartik\grid\EditableColumn',
        'attribute'=>'vehicleLocation',
        'vAlign'=>'middle',
        'width'=>'210px',
        'readonly'=>function($model, $key, $index, $widget) {
            return (!$model->vehicleLocation); // do not allow editing of inactive records
        },
        'editableOptions'=>[
            'header'=>'Vehicle Location', 
            'size'=>'md',
            'inputType'=>\kartik\editable\Editable::INPUT_TEXT,
        ],
    ],
    
    [
        'class'=>'kartik\grid\EditableColumn',
        'attribute'=>'requestDateTime',
        'vAlign'=>'middle',
        'width'=>'210px',
        'readonly'=>function($model, $key, $index, $widget) {
            return (!$model->requestDateTime); // do not allow editing of inactive records
        },
        'editableOptions'=>[
            'header'=>'Request Date Time', 
            'size'=>'md',
            'inputType'=>\kartik\editable\Editable::INPUT_TEXT,
        ],
    ],
    
    [
        'class'=>'kartik\grid\EditableColumn',
        'attribute'=>'vehicleType',
        'vAlign'=>'middle',
        'width'=>'210px',
        'readonly'=>function($model, $key, $index, $widget) {
            return (!$model->vehicleType); // do not allow editing of inactive records
        },
        'editableOptions'=>[
            'header'=>'Vehicle Type', 
            'size'=>'md',
            'inputType'=>\kartik\editable\Editable::INPUT_TEXT,
        ],
    ],
    
    [
        'class'=>'kartik\grid\EditableColumn',
        'attribute'=>'valuatorName',
        'vAlign'=>'middle',
        'width'=>'210px',
        'readonly'=>function($model, $key, $index, $widget) {
            return (!$model->valuatorName); // do not allow editing of inactive records
        },
        'editableOptions'=>[
            'header'=>'Valuator Name', 
            'size'=>'md',
            'inputType'=>\kartik\editable\Editable::INPUT_TEXT,
        ],
    ],
    
    [
        'class'=>'kartik\grid\EditableColumn',
        'attribute'=>'status',
        'vAlign'=>'middle',
        'width'=>'210px',
        'readonly'=>function($model, $key, $index, $widget) {
            return (!$model->status); // do not allow editing of inactive records
        },
        'editableOptions'=>[
            'header'=>'Status', 
            'size'=>'md',
            'inputType'=>\kartik\editable\Editable::INPUT_TEXT,
        ],
    ],
    
    [
        'class'=>'kartik\grid\EditableColumn',
        'attribute'=>'extraKM',
        'vAlign'=>'middle',
        'width'=>'210px',
        'readonly'=>function($model, $key, $index, $widget) {
            return (!$model->extraKM); // do not allow editing of inactive records
        },
        'editableOptions'=>[
            'header'=>'Extra KM', 
            'size'=>'md',
            'inputType'=>\kartik\editable\Editable::INPUT_TEXT,
        ],
    ],
    
    [
        'class'=>'kartik\grid\EditableColumn',
        'attribute'=>'appointmentAssignedDateTime',
        'vAlign'=>'middle',
        'width'=>'210px',
        'readonly'=>function($model, $key, $index, $widget) {
            return (!$model->appointmentAssignedDateTime); // do not allow editing of inactive records
        },
        'editableOptions'=>[
            'header'=>'Appointment Assigned DateTime', 
            'size'=>'md',
            'inputType'=>\kartik\editable\Editable::INPUT_TEXT,
        ],
    ],
    
    [
        'class'=>'kartik\grid\EditableColumn',
        'attribute'=>'customerAppointmentDateTime',
        'vAlign'=>'middle',
        'width'=>'210px',
        'readonly'=>function($model, $key, $index, $widget) {
            return (!$model->customerAppointmentDateTime); // do not allow editing of inactive records
        },
        'editableOptions'=>[
            'header'=>'Customer Appointment DateTime', 
            'size'=>'md',
            'inputType'=>\kartik\editable\Editable::INPUT_TEXT,
        ],
    ],
    
    [
        'class'=>'kartik\grid\EditableColumn',
        'attribute'=>'completedDateTime',
        'vAlign'=>'middle',
        'width'=>'210px',
        'readonly'=>function($model, $key, $index, $widget) {
            return (!$model->completedDateTime); // do not allow editing of inactive records
        },
        'editableOptions'=>[
            'header'=>'Completed DateTime', 
            'size'=>'md',
            'inputType'=>\kartik\editable\Editable::INPUT_TEXT,
        ],
    ],
    
    [
        'class'=>'kartik\grid\EditableColumn',
        'attribute'=>'cashCollected',
        'vAlign'=>'middle',
        'width'=>'210px',
        'readonly'=>function($model, $key, $index, $widget) {
            return (!$model->cashCollected); // do not allow editing of inactive records
        },
        'editableOptions'=>[
            'header'=>'Cash Collected', 
            'size'=>'md',
            'inputType'=>\kartik\editable\Editable::INPUT_TEXT,
        ],
    ],
    
    [
        'class'=>'kartik\grid\EditableColumn',
        'attribute'=>'cashCollectedAmount',
        'vAlign'=>'middle',
        'width'=>'210px',
        'readonly'=>function($model, $key, $index, $widget) {
            return (!$model->cashCollectedAmount); // do not allow editing of inactive records
        },
        'editableOptions'=>[
            'header'=>'Cash Collected Amount', 
            'size'=>'md',
            'inputType'=>\kartik\editable\Editable::INPUT_TEXT,
        ],
    ],
    
    [
        'class'=>'kartik\grid\EditableColumn',
        'attribute'=>'reportSentDateTime',
        'vAlign'=>'middle',
        'width'=>'210px',
        'readonly'=>function($model, $key, $index, $widget) {
            return (!$model->reportSentDateTime); // do not allow editing of inactive records
        },
        'editableOptions'=>[
            'header'=>'Report Sent DateTime', 
            'size'=>'md',
            'inputType'=>\kartik\editable\Editable::INPUT_TEXT,
        ],
    ],
    
    [
        'class'=>'kartik\grid\EditableColumn',
        'attribute'=>'remarks',
        'vAlign'=>'middle',
        'width'=>'210px',
        'readonly'=>function($model, $key, $index, $widget) {
            return (!$model->remarks); // do not allow editing of inactive records
        },
        'editableOptions'=>[
            'header'=>'Remarks', 
            'size'=>'md',
            'inputType'=>\kartik\editable\Editable::INPUT_TEXT,
        ],
    ],
    
      
        
];

/*
// the GridView widget (you must use kartik\grid\GridView)
echo \kartik\grid\GridView::widget([
    'dataProvider'=>$dataProvider,
    'filterModel'=>$searchModel,
    'columns'=>$gridColumns,
    'export' => false,
    'pjax'=>true,
    'pjaxSettings'=>[
        'neverTimeout'=>true,
        'beforeGrid'=>'My fancy content before.',
        'afterGrid'=>'My fancy content after.',
    ]
]);
 * 
 */

echo GridView::widget([
    'dataProvider'=>$dataProvider,
    'filterModel'=>$searchModel,
    'columns'=>$gridColumns,
    'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => ''],
    'containerOptions'=>['style'=>'overflow: auto'], // only set when $responsive = false
    'headerRowOptions'=>['class'=>'kartik-sheet-style'],
    'filterRowOptions'=>['class'=>'kartik-sheet-style'],
    'pjax'=>true, // pjax is set to always true for this demo
    // set your toolbar
    'toolbar'=> [
        ['content'=>
            Html::button('<i class="glyphicon glyphicon-plus"></i>', ['type'=>'button', 'title'=>Yii::t('app', 'Add Book'), 'class'=>'btn btn-success', 'onclick'=>'']) . ' '.
            Html::a('<i class="glyphicon glyphicon-repeat"></i>', [''], ['data-pjax'=>0, 'class'=>'btn btn-default', 'title'=>Yii::t('app', 'Reset Grid')])
        ],
        '{export}',
        '{toggleData}',
    ],
    // set export properties
    'export'=>[
        'fontAwesome'=>true
    ],
    // parameters from the demo form
    'bordered'=>true,
    'striped'=>true,
    'condensed'=>true,
    'responsive'=>true,
    'hover'=>true,
    'showPageSummary'=>false,
    'panel'=>[
        'type'=>GridView::TYPE_PRIMARY,
        'heading'=>'Process Data'
    ],
    'persistResize'=>false,
    'exportConfig'=>false,
    'export' => false
]);
 

?>
<!--
<div class="site-index">

    <div class="jumbotron">
        <h1>Congratulations!</h1>

        <p class="lead">You have successfully created your Yii-powered application.</p>

        <p><a class="btn btn-lg btn-success" href="http://www.yiiframework.com">Get started with Yii</a></p>
    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-4">
                <h2>Heading</h2>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur.</p>

                <p><a class="btn btn-default" href="http://www.yiiframework.com/doc/">Yii Documentation &raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <h2>Heading</h2>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur.</p>

                <p><a class="btn btn-default" href="http://www.yiiframework.com/forum/">Yii Forum &raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <h2>Heading</h2>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur.</p>

                <p><a class="btn btn-default" href="http://www.yiiframework.com/extensions/">Yii Extensions &raquo;</a></p>
            </div>
        </div>

    </div>
</div>
-->