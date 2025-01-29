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

/*
if($role == 'Admin' || $role == 'Superadmin')
{
?>
<div id="followup-data">
    <h4> Follow Up Remainders </h4>
    <div id="followup-output" style="border:2px solid #337ab7;width:400px;height:150px;margin:5px 5px 5px 0;padding:5px;overflow-y:scroll; ">

    </div>
</div>
<?php
}

*/


$uploadArray = $searchModel->uploadValue;
$paymentArray = $searchModel->paymentValue;
$arr = [
           'add' => [
               'id' => '0',
               'firstName'=>'Customer'
           ],
       ];
$valuator = ArrayHelper::merge($arr, $valuator);
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
        'template' => Helper::filterActionColumn('{update}{transaction}{vehicleqc}{completed}{changerolist}'),
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
	    'update' => function ($url, $model, $key) {
	        
                
                return Html::a('<span class="glyphicon glyphicon-pencil msize"></span>','#', [
                    'class' => 'activity-update-link',
                    'title' => Yii::t('yii', 'Update'),
                    'data-toggle' => 'modal',
                    'data-target' => '#update-modal',
                    'data-id' => $key,
                    'data-pjax' => '0',

                ]);
               
            },
                    
            'vehicleqc' => function ($url, $model, $key) {

                $role = array_keys(Yii::$app->authManager->getRolesByUser(Yii::$app->user->getId()))[0] ;
              if($role == 'BO User'|| $role=='Surveyor')
              {
                

                if($model->status == 101 || $model->status == 102 || $model->status == 104)
                {
                    $display='display:none';
                }
                else
                {
                    $display='display:block';
                }
              }
              else {
                    $display='display:block';
                   # code...
               } 

                  if($model->status !=  101)
                {
                
                if(strtolower(preg_replace('/[^\w]/', '', $model->vehicleType)) == 'allvehicle')
                {
                return Html::a('<span class="glyphicon glyphicon-check msize"></span>',Yii::$app->request->baseUrl.'/axion-preinspection/vehicleqc?id='.$key.'&page=index', [
                    'class' => 'activity-transaction-link',
                    'title' => Yii::t('yii', 'QC'),
                    'data-id' => $key,
                    'data-pjax' => '0',
                    'target'=>'_blank',
                    'style'=>$display,

                ]);
                }
                else if(strtolower(preg_replace('/[^\w]/', '', $model->vehicleType)) == '4wheeler')
                {
                   return Html::a('<span class="glyphicon glyphicon-check msize"></span>',Yii::$app->request->baseUrl.'/axion-preinspection/vehicleqc?id='.$key, [
                    'class' => 'activity-transaction-link',
                    'title'  => Yii::t('yii', 'QC'),
                    'data-id' => $key,
                    'data-pjax' => '0',
                    'target'=>'_blank',
                    'style'=>$display,

                ]); 
                }
                }
            },        
           /*
            'delete' => function ($url, $model, $key) {
                if(Yii::$app->user->identity->type == 'Admin')
                {
                     return Html::a('<span class="glyphicon glyphicon-trash"></span>','#', [
                    'class' => 'activity-delete-link',
                    'title' => Yii::t('yii', 'Delete'),
                    'data-id' => $key,
                    'data-pjax' => '0',

                     ]);
                }
            },
            *
            */
            'transaction' => function ($url, $model, $key) {
                return Html::a('<span class="glyphicon glyphicon-file msize"></span>',Yii::$app->request->baseUrl.'/axion-preinspection/transaction?id='.$key, [
                    'class' => 'activity-transaction-link',
                    'title' => Yii::t('yii', 'Transaction'),
                    'data-id' => $key,
                    'data-pjax' => '0',
                    'target'=>'_blank',

                ]);
            },

            // rochange in index page

            'changerolist' => function ($url, $model, $key) {
            
                    $role = array_keys(Yii::$app->authManager->getRolesByUser(Yii::$app->user->getId()))[0] ;
                    if($role=="Admin" || $role=="Superadmin" || $role=="BO User")
                    {
                          return Html::a('<span class="glyphicon glyphicon-transfer msize"></span>','#', [
                        'class' => 'activity-changero-link',
                        'title' => Yii::t('yii', 'Change RO'),
                        'data-toggle' => 'modal',
                        'data-target' => '#changero-modal',
                        'data-id' => $key,
                        'data-pjax' => '0',

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
        'attribute'=>'callerName',
        'vAlign'=>'middle',
        'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#337ab7;'],
        'value'=>function ($model) {
            $callerName = $model->callerFirstName;
            if(isset($callerName->firstName))
            {
                   return  $callerName->firstName;
            }
            else { return '';}
         },
    ],
    [
        'attribute'=>'contactPersonMobileNo',
        'label'=>'Unique Lead Number',
        'vAlign'=>'middle',
        'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#337ab7;'],
    ],            

    [
        'attribute'=>'callerMobileNo',
        'vAlign'=>'middle',
        'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#337ab7;'],
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
        'attribute'=>'insuredName',
        'vAlign'=>'middle',
        'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#337ab7;'],
    ],

    [
        'attribute'=>'insuredMobile',
        'vAlign'=>'middle',
        'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#337ab7;'],
    ],



    [
        'attribute'=>'registrationNo',
        'vAlign'=>'middle',
        'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#337ab7;'],
    ],

     [
        'attribute'=>'vTypeName',
        'vAlign'=>'middle',
        'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#337ab7;color:white;'],
        'value' => 'vType.vType',
     ],



    [
        'attribute'=>'surveyLocation',
        'vAlign'=>'middle',
        'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#337ab7;'],
    ],
    [
        'attribute'=>'surveyLocation2',
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
        'attribute'=>'paymentMode',
        'vAlign'=>'middle',
        'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#337ab7;'],
        'value'=>function ($model) {
            $payment = $model->paymentValue;
                  if($model->paymentMode != 0)
                  {
                    return  $payment[$model->paymentMode];
                  }
                  else {
                    return '';
                  }
         },
        'filterType'=>GridView::FILTER_SELECT2,
                'filter'=>$paymentArray,
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
        'attribute'=>'uploadSource',
        'vAlign'=>'middle',
        'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#337ab7;'],
        'value'=>function ($model) {
            $upload = $model->uploadValue;
                  if($model->uploadSource != 0)
                  {
                    return  $upload[$model->uploadSource];
                  }
                  else {
                    return '';
                  }
         },
        'filterType'=>GridView::FILTER_SELECT2,
                'filter'=>$uploadArray,
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
            if($status == 0)
            {
                return  'Fresh Case';
            }
            else if($status == 12)
            {
                return  'Schedule';
            }
            else if($status == 1)
            {
                return  'Intimation Re-Schedule';
            }
            else if($status == 8)
            {
                return  'Survey Done';
            }
            else if($status == 9)
            {
                return  'Cancelled';
            }
            else if($status == 100)
            {
                return  'Change RO';
            }
            else if($status == 101)
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
                'filter'=>['0'=>'Fresh Case','12'=>'Schedule','1'=>'Intimation Re-Schedule','8'=>'Survey Done','9'=>'Cancelled','100'=>'Change RO','101'=>'PI-Recommended','102'=>'PI-Not Recommended','103'=>'PI-Inprogress','104'=>'PI-Refer to Under Writer'],
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
        'attribute'=>'extraKM',
        'vAlign'=>'middle',
        'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#337ab7;padding-right:10px;'],
    ],
    
    [
        'attribute'=>'cashCollection',
        'vAlign'=>'middle',
        'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#337ab7;padding-right:10px;'],
    ],
                 
    [
        'attribute'=>'intimationRemarks',
        'vAlign'=>'middle',
        'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#337ab7;padding-right:10px;'],
    ], 
                 
     [
        'attribute'=>'contactPersonMobileNo',
        'label' => (strpos( Yii::$app->request->absoluteUrl, 'test') !== false || strpos( Yii::$app->request->absoluteUrl, 'saptechservices.in') !== false)?'Unique Lead No':'',
        'vAlign'=>'middle',
        'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#337ab7;padding-right:10px;'],
        'visible'=> (strpos( Yii::$app->request->absoluteUrl, 'test') !== false || strpos( Yii::$app->request->absoluteUrl, 'saptechservices.in') !== false)?true:false,
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
     if(Helper::checkRoute('axion-preinspection/create')){    
         $create = Html::a('<span class="glyphicon glyphicon-plus"></span>','#', [
                        'id' => 'activity-create-link',
                        'class'=>'btn btn-success',
                        'title' => Yii::t('yii', 'Create'),
                        'data-toggle' => 'modal',
                        'data-target' => '#create-modal',
                        //'data-id' => $key,
                        'data-pjax' => '0',

                    ]);
     }
     else{
        $create = ''; 
     }

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

                 $create.' '.
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
            'header'=>'<li role="presentation" class="dropdown-header">Axion Preinspection</li>',
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
            'heading'=>'My Cases'
        ],
        'resizableColumns'=>false,
        'persistResize'=>false,
        'exportConfig'=>  [
        ]
    ]);


?>

<?php $this->registerJs(
    "$('body').on('click', '.activity-view-link', function() {
    $.get(
         '".Yii::$app->request->baseUrl."/axion-preinspection/view',
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
    "$('body').on('click', '.activity-update-link', function() {
    $.get(
        '".Yii::$app->request->baseUrl."/axion-preinspection/update',
        {
            //id: $(this).closest('tr').data('key')
            id: $(this).data('id')

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
    "$('body').on('click', '.activity-changero-link', function() {

    $.get(
        '".Yii::$app->request->baseUrl."/axion-preinspection/changerolist',
        {
            //id: $(this).closest('tr').data('key')
            id: $(this).data('id')

        },
        function (data) {
            //alert(data);
            $('#changero-modal').find('.modal-body').html(data);
            $('#changero-modal').modal();
        }
    );
});
$('#changero-modal').on('hidden.bs.modal', function (e) {
    $(this).find('.modal-body').html('');
})
    "
); ?>

<?php $this->registerJs(
    "$('body').on('click', '#activity-create-link', function() {
    $.get(
        '".Yii::$app->request->baseUrl."/axion-preinspection/create',
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


<?php $this->registerJs(
"$('body').on('click', '#activity-mul-delete-link', function() {
    //alert('test');
    var sel = $('#w0').yiiGridView('getSelectedRows');
    if(sel == '')
    {
        alert('No row selected');
    }
    else
    {
        var r = confirm('Are you want to delete?');
        if(r==true)
        {
            var s = confirm('Are you sure to delete?');
            if(s==true)
            {
                $.post(
                    '".Yii::$app->request->baseUrl."/axion-preinspection/delete-multiple',
                    {
                        id : sel
                    },
                    function () {
                        $('#w0').yiiGridView('applyFilter');
                    }
                );
            }
        }
    }
});
    "
); ?>

<?php $this->registerJs(
"$('body').on('click', '.activity-delete-link', function() {
    //alert('test');
        var r = confirm('Are you want to delete?');
        if(r==true)
        {
            var s = confirm('Are you sure to delete?');
            if(s==true)
            {
                $.post(
                    '".Yii::$app->request->baseUrl."/axion-preinspection/delete',
                    {
                       id: $(this).closest('tr').data('key')
                    },
                    function () {
                        $('#w0').yiiGridView('applyFilter');
                    }
                );
            }
        }

});
    "
); ?>


<?php $this->registerJs(
"

 var followup_call = function() {
  //your jQuery ajax code
//   alert('test');
    $.get(
        '".Yii::$app->request->baseUrl."/axion-preinspection/followup',
        {
            ro: 'Chennai'
        },
        function (data) {
	    //alert(data);
            $('#followup-output').html(data);
           //$('#update-modal').modal();
        }
    );
};

//var interval = 1000 * 60 * 1; // where X is your every X minutes
var interval = 3000; // where X is your every X minutes //30seconds

setInterval(followup_call, interval);
$( document ).ready( followup_call );
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
    'clientOptions' => [
        'backdrop' => 'static',
        'keyboard' => false,
    ],
    'size' => Modal::SIZE_LARGE,
    'header' => '<h4 class="modal-title">Update Record</h4>',
    'footer' => '<a href="#" class="btn btn-primary" data-dismiss="modal">Close</a>',

]); ?>
<?php Modal::end(); ?>

<?php Modal::begin([
    'id' => 'changero-modal',
    'size' => Modal::SIZE_LARGE,
    'header' => '<h4 class="modal-title">Change RO</h4>',
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
