<?php

/* @var $this yii\web\View */
use kartik\grid\GridView;
use yii\helpers\Html;
use kartik\editable\Editable;
use yii\bootstrap\Modal;
use kartik\export\ExportMenu;

$gridColumns = [
    
     [
    'class'=>'kartik\grid\ActionColumn',
    /*'dropdown'=>true,
    'dropdownOptions'=>['class'=>'pull-right'],*/
	'template' => '{view} {update} {delete} {transaction}',
        'headerOptions'=>['class'=>'kartik-sheet-style'],
        'headerOptions'=>['style'=>'border: 2px #000 solid; background-color:#337ab7;color:#fff;'],
	 'buttons' => [
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
	    'update' => function ($url, $model, $key) {
                return Html::a('<span class="glyphicon glyphicon-pencil"></span>','#', [
                    'class' => 'activity-update-link',
                    'title' => Yii::t('yii', 'Update'),
                    'data-toggle' => 'modal',
                    'data-target' => '#update-modal',
                    'data-id' => $key,
                    'data-pjax' => '0',

                ]);
            },
                    
            'delete' => function ($url, $model, $key) {
                return Html::a('<span class="glyphicon glyphicon-trash"></span>',$url, [
                    'class' => 'activity-delete-link',
                    'title' => Yii::t('yii', 'Delete'),
                    'data-confirm' => "Are you sure to delete this item?",
                    'data-method' => 'post',
                    'data-id' => $key,
                    'data-pjax' => '0',

                ]);
            },          
           'transaction' => function ($url, $model, $key) {
                return Html::a('<span class="glyphicon glyphicon-file"></span>',Yii::$app->request->baseUrl.'/process-data/transaction?id='.$key, [
                    'class' => 'activity-transaction-link',
                    'title' => Yii::t('yii', 'Transaction'),
                    'data-id' => $key,
                    'data-pjax' => '0',
                    'target'=>'_blank',

                ]);
            },         
        ],
    ],    
// the name column configuration
    [
        //'class'=>'kartik\grid\EditableColumn',
        'attribute'=>'requestNo',
        'vAlign'=>'middle',
        'width'=>'210px',
        'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#337ab7;'],
        /*
        'readonly'=>function($model, $key, $index, $widget) {
            return (!$model->requestNo); // do not allow editing of inactive records
        },
                
        'editableOptions'=>[
            'header'=>'Request No', 
            'size'=>'md',
            'inputType'=>\kartik\editable\Editable::INPUT_TEXT,
        ],
         * 
         */
    ],

    [
        //'class'=>'kartik\grid\EditableColumn',
        'attribute'=>'clientName',
        'vAlign'=>'middle',
        'width'=>'210px',
        'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#337ab7;'],
        /*
        'readonly'=>function($model, $key, $index, $widget) {
            return (!$model->clientName); // do not allow editing of inactive records
        },
        'editableOptions'=>[
            'header'=>'Client Name', 
            'size'=>'md',
            'inputType'=>\kartik\editable\Editable::INPUT_TEXT,
        ],
         * 
         */
    ],
    
    [
        //'class'=>'kartik\grid\EditableColumn',
        'attribute'=>'clientCity',
        'vAlign'=>'middle',
        'width'=>'210px',
        'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#337ab7;'],
        /*
        'readonly'=>function($model, $key, $index, $widget) {
            return (!$model->clientCity); // do not allow editing of inactive records
        }, 
        'editableOptions'=>[
            'header'=>'Client City', 
            'size'=>'md',
            'inputType'=>\kartik\editable\Editable::INPUT_TEXT,
        ],
         * 
         */
    ],
    
    [
        //'class'=>'kartik\grid\EditableColumn',
        'attribute'=>'mailId',
        'vAlign'=>'middle',
        'width'=>'210px',
        'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#337ab7;'],
        /*
        'readonly'=>function($model, $key, $index, $widget) {
            return (!$model->mailId); // do not allow editing of inactive records
        },
        'editableOptions'=>[
            'header'=>'Mail ID', 
            'size'=>'md',
            'inputType'=>\kartik\editable\Editable::INPUT_TEXT,
        ],
         * 
         */
    ],
    
    [
        //'class'=>'kartik\grid\EditableColumn',
        'attribute'=>'customerName',
        'vAlign'=>'middle',
        'width'=>'210px',
        'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#337ab7;'],
        /*
        'readonly'=>function($model, $key, $index, $widget) {
            return (!$model->customerName); // do not allow editing of inactive records
        },
        'editableOptions'=>[
            'header'=>'Customer Name', 
            'size'=>'md',
            'inputType'=>\kartik\editable\Editable::INPUT_TEXT,
        ],
         * 
         */
    ],
    
    [
        //'class'=>'kartik\grid\EditableColumn',
        'attribute'=>'customerMobileNo',
        'vAlign'=>'middle',
        'width'=>'210px',
        'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#337ab7;'],
        /*
        'readonly'=>function($model, $key, $index, $widget) {
            return (!$model->customerMobileNo); // do not allow editing of inactive records
        },
        'editableOptions'=>[
            'header'=>'Customer Mobile No', 
            'size'=>'md',
            'inputType'=>\kartik\editable\Editable::INPUT_TEXT,
        ],
         * 
         */
    ],
    
    [
        //'class'=>'kartik\grid\EditableColumn',
        'attribute'=>'vehicleNumber',
        'vAlign'=>'middle',
        'width'=>'210px',
        'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#337ab7;'],
        /*
        'readonly'=>function($model, $key, $index, $widget) {
            return (!$model->vehicleNumber); // do not allow editing of inactive records
        },
        'editableOptions'=>[
            'header'=>'Vehicle Number', 
            'size'=>'md',
            'inputType'=>\kartik\editable\Editable::INPUT_TEXT,
        ],
         * 
         */
    ],
    
    [
        //'class'=>'kartik\grid\EditableColumn',
        'attribute'=>'vehicleLocation',
        'vAlign'=>'middle',
        'width'=>'210px',
        'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#337ab7;'],
        /*
        'readonly'=>function($model, $key, $index, $widget) {
            return (!$model->vehicleLocation); // do not allow editing of inactive records
        },
        'editableOptions'=>[
            'header'=>'Vehicle Location', 
            'size'=>'md',
            'inputType'=>\kartik\editable\Editable::INPUT_TEXT,
        ],
         * 
         */
    ],
    
    [
        //'class'=>'kartik\grid\EditableColumn',
        'attribute'=>'requestDateTime',
        'vAlign'=>'middle',
        'width'=>'210px',
        'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#337ab7;'],
        'format' => ['date', 'php:d-m-Y h:i a'],
       /*
        'readonly'=>function($model, $key, $index, $widget) {
            return (!$model->requestDateTime); // do not allow editing of inactive records
        },
        'editableOptions'=>[
            'header'=>'Request Date Time', 
            'size'=>'md',
            'inputType'=>\kartik\editable\Editable::INPUT_TEXT,
        ],
         * 
         */
    ],
    
    [
        //'class'=>'kartik\grid\EditableColumn',
        'attribute'=>'vehicleType',
        'vAlign'=>'middle',
        'width'=>'210px',
        'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#5cb85c;'],
        /*
        'readonly'=>function($model, $key, $index, $widget) {
            return (!$model->vehicleType); // do not allow editing of inactive records
        },
        'editableOptions'=>[
            'header'=>'Vehicle Type', 
            'size'=>'md',
            'inputType'=>\kartik\editable\Editable::INPUT_TEXT,
        ],
         * 
         */
    ],
    
    [
        //'class'=>'kartik\grid\EditableColumn',
        'attribute'=>'valuatorName',
        'vAlign'=>'middle',
        'width'=>'210px',
        'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#5cb85c;'],
        'value'=>function ($model) {
            $valuatorUser = $model->valuatorUser;
            if(isset($valuatorUser->name))
            {
                   return  $valuatorUser->name;
            }
            else { return '';}
         },
        /*         
        'readonly'=>function($model, $key, $index, $widget) {
            return (!$model->valuatorName); // do not allow editing of inactive records
        },        
        'editableOptions'=>[
            'header'=>'Valuator Name', 
            'size'=>'md',
            'inputType'=>\kartik\editable\Editable::INPUT_TEXT,
        ],
         * 
         */
    ],
    
    [
        //'class'=>'kartik\grid\EditableColumn',
        'attribute'=>'status',
        'vAlign'=>'middle',
        'width'=>'210px',
        'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#5cb85c;'],
        /*
        'readonly'=>function($model, $key, $index, $widget) {
            return (!$model->status); // do not allow editing of inactive records
        },
        'editableOptions'=>[
            'header'=>'Status', 
            'size'=>'md',
            'inputType'=>\kartik\editable\Editable::INPUT_TEXT,
        ],
         * 
         */
    ],
    
    [
        //'class'=>'kartik\grid\EditableColumn',
        'attribute'=>'extraKM',
        'vAlign'=>'middle',
        'width'=>'210px',
        'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#5cb85c;'],
        /*
        'readonly'=>function($model, $key, $index, $widget) {
            return (!$model->extraKM); // do not allow editing of inactive records
        },
        'editableOptions'=>[
            'header'=>'Extra KM', 
            'size'=>'md',
            'inputType'=>\kartik\editable\Editable::INPUT_TEXT,
        ],
         * 
         */
    ],
    
    [
        //'class'=>'kartik\grid\EditableColumn',
        'attribute'=>'appointmentAssignedDateTime',
        'vAlign'=>'middle',
        'width'=>'210px',
        'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#5cb85c;'],
        'format' => ['date', 'php:d-m-Y h:i a'],
        /*
        'readonly'=>function($model, $key, $index, $widget) {
            return (!$model->appointmentAssignedDateTime); // do not allow editing of inactive records
        },
        'editableOptions'=>[
            'header'=>'Appointment Assigned DateTime', 
            'size'=>'md',
            'inputType'=>\kartik\editable\Editable::INPUT_TEXT,
        ],
         * 
         */
    ],
    
    [
        //'class'=>'kartik\grid\EditableColumn',
        'attribute'=>'customerAppointmentDateTime',
        'vAlign'=>'middle',
        'width'=>'210px',
        'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#5cb85c;'],
        'format' => ['date', 'php:d-m-Y h:i a'],
        /*
        'readonly'=>function($model, $key, $index, $widget) {
            return (!$model->customerAppointmentDateTime); // do not allow editing of inactive records
        },
        'editableOptions'=>[
            'header'=>'Customer Appointment DateTime', 
            'size'=>'md',
            'inputType'=>\kartik\editable\Editable::INPUT_TEXT,
        ],
         * 
         */
    ],
    
    [
        //'class'=>'kartik\grid\EditableColumn',
        'attribute'=>'completedDateTime',
        'vAlign'=>'middle',
        'width'=>'210px',
        'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#5cb85c;'],
        'format' => ['date', 'php:d-m-Y h:i a'],
        /*
        'readonly'=>function($model, $key, $index, $widget) {
            return (!$model->completedDateTime); // do not allow editing of inactive records
        },
        'editableOptions'=>[
            'header'=>'Completed DateTime', 
            'size'=>'md',
            'inputType'=>\kartik\editable\Editable::INPUT_TEXT,
        ],
         * 
         */
    ],
    
    [
        //'class'=>'kartik\grid\EditableColumn',
        'attribute'=>'cashCollected',
        'vAlign'=>'middle',
        'width'=>'210px',
        'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#5cb85c;'],
        /*
        'readonly'=>function($model, $key, $index, $widget) {
            return (!$model->cashCollected); // do not allow editing of inactive records
        },
        'editableOptions'=>[
            'header'=>'Cash Collected', 
            'size'=>'md',
            'inputType'=>\kartik\editable\Editable::INPUT_TEXT,
        ],
         * 
         */
    ],
    
    [
        //'class'=>'kartik\grid\EditableColumn',
        'attribute'=>'cashCollectedAmount',
        'vAlign'=>'middle',
        'width'=>'210px',
        'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#5cb85c;'],
        /*
        'readonly'=>function($model, $key, $index, $widget) {
            return (!$model->cashCollectedAmount); // do not allow editing of inactive records
        },
        'editableOptions'=>[
            'header'=>'Cash Collected Amount', 
            'size'=>'md',
            'inputType'=>\kartik\editable\Editable::INPUT_TEXT,
        ],
         * 
         */
    ],
    
    [
        //'class'=>'kartik\grid\EditableColumn',
        'attribute'=>'reportSentDateTime',
        'vAlign'=>'middle',
        'width'=>'210px',
        'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#5cb85c;'],
        'format' => ['date', 'php:d-m-Y h:i a'],
        /*
        'readonly'=>function($model, $key, $index, $widget) {
            return (!$model->reportSentDateTime); // do not allow editing of inactive records
        },
        'editableOptions'=>[
            'header'=>'Report Sent DateTime', 
            'size'=>'md',
            'inputType'=>\kartik\editable\Editable::INPUT_TEXT,
        ],
         * 
         */
    ],
    
    [
        //'class'=>'kartik\grid\EditableColumn',
        'attribute'=>'remarks',
        'vAlign'=>'middle',
        'width'=>'210px',
        'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#5cb85c;'],
        /*
        'readonly'=>function($model, $key, $index, $widget) {
            return (!$model->remarks); // do not allow editing of inactive records
        },
        'editableOptions'=>[
            'header'=>'Remarks', 
            'size'=>'md',
            'inputType'=>\kartik\editable\Editable::INPUT_TEXT,
        ],
         * 
         */
    ],
                
    [
        //'class'=>'kartik\grid\EditableColumn',
        'attribute'=>'staffName',
        'vAlign'=>'middle',
        'width'=>'210px',
        'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#5cb85c;'],
        'value'=>function ($model) {
            $staffUser = $model->staffUser;
            if(isset($staffUser->name))
            {
                   return  $staffUser->name;
            }
            else { return '';}
         },
        /*         
        'readonly'=>function($model, $key, $index, $widget) {
            return (!$model->staffName); // do not allow editing of inactive records
        },
        'editableOptions'=>[
            //'asPopover' => false,
            'header'=>'Staff Name', 
            'size'=>'md',
            'inputType'=>\kartik\editable\Editable::INPUT_TEXT,
        ],
         * 
         */
    ],            
    
      
        
];


echo GridView::widget([
    'dataProvider'=>$dataProvider,
    'filterModel'=>$searchModel,
    'columns'=>$gridColumns,
    'resizableColumns'=>true,
    'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => ''],
    'rowOptions'=>['style'=>'border: 2px #000 solid'],
    'rowOptions' => function ($model){
      if($model->valuatorName == ''){
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
            Html::a('<span class="glyphicon glyphicon-plus"></span>','#', [
                    'id' => 'activity-create-link',
                    'class'=>'btn btn-success',
                    'title' => Yii::t('yii', 'Create'),
                    'data-toggle' => 'modal',
                    'data-target' => '#create-modal',
                    //'data-id' => $key,
                    'data-pjax' => '0',

                ]).' '.
            Html::a('<i class="glyphicon glyphicon-repeat"></i>', [''], ['data-pjax'=>0, 'class'=>'btn btn-default', 'title'=>Yii::t('app', 'Reset Grid')])
        ],
        '{export}',
        '{toggleData}',
    ],
    // set export properties
    'export'=>[
        'fontAwesome'=>true,
        'showConfirmAlert'=>false,
        'target'=>GridView::TARGET_BLANK,
        'label'=>'Export',
        'header'=>'<li role="presentation" class="dropdown-header">Process data</li>',
    ],
    // parameters from the demo form
    'bordered'=>false,
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
    'exportConfig'=>  [   
    ]
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
<?php $this->registerJs(
    "$('.activity-view-link').click(function() {
    $.get(
         '".Yii::$app->request->baseUrl."/process-data/view',         
        {
            id: $(this).closest('tr').data('key')
        },
        function (data) {
        
            $('#view-modal').find('.modal-body').html(data);
            $('#view-modal').modal();
        }  
    );
});
$('#view-modal').on('hidden.bs.modal', function (e) {
    $(this).find('.modal-body').html('');
})
    "
); ?>

<?php $this->registerJs(
    "$('.activity-update-link').click(function() {
	
    $.get(
        '".Yii::$app->request->baseUrl."/process-data/update',         
        {
            id: $(this).closest('tr').data('key')
        },
        function (data) {
			//alert(data);
            $('#update-modal').find('.modal-body').html(data);
            $('#update-modal').modal();
        }  
    );
});
$('#update-modal').on('hidden.bs.modal', function (e) {
    $(this).find('.modal-body').html('');
})
    "
); ?>

<?php $this->registerJs(
    "$('#activity-create-link').click(function() {
	
    $.get(
        '".Yii::$app->request->baseUrl."/process-data/create',         
        {
            /*id: $(this).closest('tr').data('key')*/
        },
        function (data) {
			//alert(data);
            $('#create-modal').find('.modal-body').html(data);
            $('#create-modal').modal();
        }  
    );
});
$('#create-modal').on('hidden.bs.modal', function (e) {
    $(this).find('.modal-body').html('');
})
    "
); ?>


<?php Modal::begin([
    'id' => 'view-modal',
    'size' => Modal::SIZE_LARGE,
    'header' => '<h4 class="modal-title">View Record</h4>',
    'footer' => '<a href="#" class="btn btn-primary" data-dismiss="modal">Close</a>',

]); ?>
<?php Modal::end(); ?>

<?php Modal::begin([
    'id' => 'update-modal',
    'size' => Modal::SIZE_LARGE,
    'header' => '<h4 class="modal-title">Update Record</h4>',
    'footer' => '<a href="#" class="btn btn-primary" data-dismiss="modal">Close</a>',

]); ?>
<?php Modal::end(); ?>

<?php Modal::begin([
    'id' => 'create-modal',
    'size' => Modal::SIZE_LARGE,
    'header' => '<h4 class="modal-title">Create Record</h4>',
    'footer' => '<a href="#" class="btn btn-primary" data-dismiss="modal">Close</a>',

]); ?>
<?php Modal::end(); ?>