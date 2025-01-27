<?php

use kartik\grid\GridView;
use yii\helpers\Html;
use kartik\editable\Editable;
use yii\bootstrap\Modal;
use kartik\export\ExportMenu;
use yii\helpers\ArrayHelper;
use mdm\admin\components\Helper;
use rmrevin\yii\fontawesome\FA;
use rmrevin\yii\fontawesome\FAS;
use rmrevin\yii\fontawesome\FAR;
use app\models\MasterState;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AxionSpotsurveySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>



<?php
$uploadArray = $searchModel->uploadValue;
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
$states = MasterState::find()->all();
$stateArr = ArrayHelper::map($states,'id','state');

$gridColumns = [

    [
        'class'=>'kartik\grid\ActionColumn',
    /*'dropdown'=>true,
    'dropdownOptions'=>['class'=>'pull-right'],*/
    //'template' => '{view} {update} {delete}',
        'template' => Helper::filterActionColumn('{update}{transaction}{vehicleqc}{sms}{changerolist}'),
        'headerOptions'=>['class'=>'kartik-sheet-style'],
        'headerOptions'=>['style'=>'border: 2px #000 solid; background-color:#480155;color:#fff;'],
        'noWrap' => 1,
        'mergeHeader' => false,
        'buttons' => [
           'update' => function ($url, $model, $key) {           
                $role = array_keys(Yii::$app->authManager->getRolesByUser(Yii::$app->user->getId()))[0] ;
                if($role!='Surveyor' && $role != 'Branch Executive')
                {    
                    return '<div class="row">'.Html::a(FA::icon('edit', ['class' => 'mr-5 mt-5 text-success']),'#', [
                        'class' => 'activity-update-link',
                        'title' => Yii::t('yii', 'Update'),
                        'data-toggle' => 'modal',
                        'data-target' => '#update-modal',
                        'data-id' => $key,
                        'data-pjax' => '0',

                    ]);
                }
               
            },
            'transaction' => function ($url, $model, $key) {
                $role = array_keys(Yii::$app->authManager->getRolesByUser(Yii::$app->user->getId()))[0] ;
                if($role!='Surveyor')
                {    
                    return Html::a(FA::icon('history', ['class' => 'mr-5 mt-5 text-primary']), Yii::$app->request->baseUrl.'/axion-preinspection/transaction?id='.$key, [
                        'class' => 'activity-transaction-link',
                        'title' => Yii::t('yii', 'Transaction'),
                        'data-id' => $key,
                        'data-pjax' => '0',
                        'target'=>'_blank',

                    ]).'</div>';
                }
            },

            'vehicleqc' => function ($url, $model, $key) {
                $role = array_keys(Yii::$app->authManager->getRolesByUser(Yii::$app->user->getId()))[0] ;

                if ($role != 'Branch Executive')
                {
                    if( $model->status == 101 || $model->status == 102 || $model->status == 104 || $role == 'BO User' || (($role=='Admin' || $role=='Superadmin') && $model->insurerName != 9) )
                    {
                        $display='display:none';
                    }
                    else
                    {
                        $display='display:inline-block';
                    }
                }
                else {
                    $display='display:inline-block';
                    # code...
                } 
                
                if(strtolower(preg_replace('/[^\w]/', '', $model->vehicleType)) == 'allvehicle')
                {
                    return '<div class="row">'.Html::a(FA::icon('user-check text-darkYellow', ['class' => 'mr-5 mt-5']), Yii::$app->request->baseUrl.'/axion-preinspection/vehicleqc?id='.$key.'&page=scheduled', [
                        'class' => 'activity-vehicleqc-link',
                        'title' => Yii::t('yii', 'QC'),
                        'data-id' => $key,
                        'data-pjax' => '0',
                        'target'=>'_blank',
                        'style'=>$display,

                    ]);
                }
                else if(strtolower(preg_replace('/[^\w]/', '', $model->vehicleType)) == 'commercial')
                {
                   return '<div class="row">'.Html::a(FA::icon('user-check text-darkYellow', ['class' => 'mr-5 mt-5']), Yii::$app->request->baseUrl.'/axion-preinspection/commercialqc?id='.$key, [
                    'class' => 'activity-vehicleqc-link',
                    'title' => Yii::t('yii', 'QC'),
                    'data-id' => $key,
                    'data-pjax' => '0',
                    'target'=>'_blank',
                    'style'=>$display,

                    ]); 
                }
                // }
            //   }
            },

            'sms' => function ($url, $model, $key) {
                $smsText = '';
                $histories = $model->history;
                if (!empty($histories))
                {
                    foreach ($histories as $history)
                    { 
                        if ($history->smsType == 'SELF_INSPECTION')
                        {
                            $smsText = $history->smsText;
                            break;
                        }
                    }
                }
                $role = array_keys(Yii::$app->authManager->getRolesByUser(Yii::$app->user->getId()))[0] ;
                if(!empty($smsText))
                {   
                    return Html::a(FAS::icon('sms', ['class' => 'mr-5 mt-5 text-success']), '#', [
                        'class' => 'copy-sms-btn',
                        'title' => Yii::t('yii', $smsText),
                        'data-id' => $key,
                        'data-pjax' => '0'
                    ]);
                }
            },

            // rochange in index page

            'changerolist' => function ($url, $model, $key) {
                $role = array_keys(Yii::$app->authManager->getRolesByUser(Yii::$app->user->getId()))[0] ;
            
                if($role != 'Branch Executive' && $role!='Surveyor')
                {    
                    return Html::a(FA::icon('sync', ['class' => 'mr-5 mt-5 text-pink']), '#', [
                        'class' => 'activity-changero-link',
                        'title' => Yii::t('yii', 'Change RO'),
                        'data-toggle' => 'modal',
                        'data-target' => '#changero-modal',
                        'data-id' => $key,
                        'data-pjax' => '0',
                    ]).'</div>';  
                }
            },

        ],
    ],

     /*
    [
    'class'=>'kartik\grid\CheckboxColumn',
    'headerOptions'=>['class'=>'kartik-sheet-style'],
    'headerOptions'=>['style'=>'border: 2px #000 solid; background-color:#480155;color:#fff;'],
    ],
                     *
                     */

// the name column configuration
    [
        'attribute'=>'referenceNo',
        'vAlign'=>'middle',
        'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#480155;padding-right:10px;'],
    ],

    [
        'attribute' => 'WEB LINK',
        'vAlign' => 'middle',
        'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#480155 !important; color: white !important;padding-right:10px;'],
        'format' => 'raw',
        'value' => function ($model) {
            $url = Yii::$app->urlManager->createAbsoluteUrl(['/axion-preinspection-autoqc/vehicleqc', 'id' => $model->id, 'page' => 'completed']);
            $buttonId = 'copy-webbutton-' . $model->id;
            $messageId = 'copy-message-' . $model->id;
            return '<button id="' . $buttonId . '" class="btn btn-primary btn-sm" style="color: white; background-color: #17a2b8; border-color: #17a2b8;">Web</button>
                    <style>
                        #' . $buttonId . ':hover {
                            background-color: #007bff;
                            color: white;
                        }
                    </style>
                    <script>
                        document.getElementById("' . $buttonId . '").addEventListener("click", function() {
                            var urlInput = document.createElement("input");
                            urlInput.value = "' . $url . '";
                            document.body.appendChild(urlInput);
                            urlInput.select();
                            document.execCommand("copy");
                            document.body.removeChild(urlInput);
                            
                            var button = document.getElementById("' . $buttonId . '");
                            
                            button.textContent = "Copied";
                            
                            setTimeout(function() {
                                button.textContent = "Web";
                            }, 1000);
                        });
                    </script>';
        },
    ],

    [
        'attribute'=>'intimationDate',
        'vAlign'=>'middle',
        'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#480155;padding-right:10px;'],
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
        'attribute'=>'insurerName',
        'vAlign'=>'middle',
        'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#480155;padding-right:10px;'],
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
        'attribute'=>'contactPersonMobileNo',
        'label'=>'<abbr title="Unique Lead Number">ULN</abbr>',
        'encodeLabel' => false,
        'vAlign'=>'middle',
        'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#480155;'],
    ],

    [
        'attribute'=>'registrationNo',
        'label'=>'Reg. No',
        'vAlign'=>'middle',
        'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#480155;'],
    ],

    [
        'attribute'=>'surveyLocation2',
        'vAlign'=>'middle',
        'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#480155;'],
    ],

    [
        'attribute'=>'stateId',
        'label'=>'Current RO',
        'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#480155;'],
        'vAlign'=>'middle',
        'value'=>function($model){
            $res = $model->state;
            if(isset($res->state))
            {
                   return  $res->state;
            }
            else { return '';}
        },
        'filterType'=>GridView::FILTER_SELECT2,
        'filter'=>$stateArr,
        'filterWidgetOptions'=>[
                'pluginOptions' => [
                    'allowClear'=>true,
                    'tags' => true,
                    'maximumInputLength' => 10
                ],
            'options' => ['placeholder' => 'Select','readonly'=>true],
        ]  
    ],

    [
        'attribute'=>'status',
        'vAlign'=>'middle',
        'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#480155;padding-right:100px;'],
        'value'=>function ($model) {
            $status = $model->status;
            
            if($status == '12')
            {
                return  'Schedule';
            }else if($status == '1')
            {
                return  'Intimation Re-Schedule';
            }
            
            else { return '';}
         },
        'filterType'=>GridView::FILTER_SELECT2,
        'filter'=>['12'=>'Schedule','1'=>'Intimation Re-Schedule'],
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
        'attribute'=>'customerAppointDateTime',
        'vAlign'=>'middle',
        'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#480155;'],
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
        'attribute'=>'surveyorName',
        'vAlign'=>'middle',
        'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#480155;'],
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
        'attribute'=>'remarks',
        'vAlign'=>'middle',
        'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#480155;'],
    ],
    
    [
        'attribute'=>'followupReason',
        'label'=>'Followup Remarks',
        'vAlign'=>'middle',
        'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#480155;'],
        'value'=>function ($model) {
            $followupReason = $model->followupReason;
            if($followupReason == 1)
                return  'CALLER AND CUSTOMER NOT PICK THE CALL';

            else if($followupReason == 2)
                return  'CUSTOMER NOT PICK THE CALL';

            else if($followupReason == 3)
                return  'CUSTOMER DISCONNECT THE CALL';

            else if($followupReason == 4)
                return  'CUSTOMER NUMBER SWITCH OF / NOT REACHABLE';

            else if($followupReason == 5)
                return  'CUSTOMER OUT OF STATION';

            else if($followupReason == 6)
                return  'CUSTOMER NOT CO - OPERATE';

            else if($followupReason == 7)
                return  'CUSTOMER NOT INTERESTED';

            else if($followupReason == 8)
                return  'CUSTOMER NOT AVAILABLE';

            else if($followupReason == 9)
                return  'CUSTOMER NUMBER WRONG';

            else if($followupReason == 10)
                return  'CUSTOMER WILL CALL BACK';
            
            else if($followupReason == 11)
                return  'INSPECTION ALREADY DONE BY ANOTHER AGENCY';

            else if($followupReason == 12)
                return  'VEHICLE NOT AVAILABLE';

            else if($followupReason == 13)
                return  'NOT SERVICING AREA';

            else if($followupReason == 14)
                return  'CUSTOMER REFUSE FOR INSPECTION CHARGES';
            
            else {
                return '';
            }
         },
        'filterType'=>GridView::FILTER_SELECT2,
        'filter'=>$followupArray,
        'filterWidgetOptions'=>[
            'pluginOptions' => [
                'allowClear'=>true,
                'tags' => true,
                'maximumInputLength' => 10
            ],
            'options' => ['placeholder' => 'Select', 'multiple' => true],
        ]
    ],
    
/*

    [
        'attribute'=>'insurerBranch',
        'vAlign'=>'middle',
        'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#480155;'],
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
        'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#480155;'],
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
        'attribute'=>'insuredName',
        'vAlign'=>'middle',
        'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#480155;'],
    ],
    
    [
        'attribute'=>'surveyLocation',
        'vAlign'=>'middle',
        'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#480155;'],
    ],

    [
        'attribute'=>'extraKM',
        'vAlign'=>'middle',
        'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#480155;padding-right:10px;'],

    ],
    [
        'attribute'=>'paymentMode',
        'vAlign'=>'middle',
        'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#480155;'],
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

*/   

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
        'export'=>[
            'fontAwesome'=>true,
            'showConfirmAlert'=>false,
            'target'=>GridView::TARGET_BLANK,
            'label'=>'Download MIS',
            'header'=>'<li role="presentation" class="dropdown-header">Axion Preinspection Scheduled Records</li>',
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
            'heading'=>'Scheduled Cases'
        ],
        'resizableColumns'=>false,
        'persistResize'=>false,
        'exportConfig'=>  [
        ]
    ]);


?>


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
});
$(function() {
    $(document).on('click', '.copy-sms-btn', function(e) {
        e.preventDefault();
        var temp = $('<input>');
        $('body').append(temp);
        temp.val($(e.target).parent('a').attr('title')).select();
        document.execCommand('copy');
        temp.remove();
    });
});
    "
); ?>


<?php Modal::begin([
    'id' => 'changero-modal',
    'size' => Modal::SIZE_LARGE,
    'header' => '<h4 class="modal-title">Change RO</h4>',
    'footer' => '<a href="#" class="btn btn-primary" data-dismiss="modal">Close</a>',

]); ?>
<?php Modal::end(); ?>
<?php Modal::begin([
    'id' => 'update-modal',
    'size' => Modal::SIZE_LARGE,
    'header' => '<h4 class="modal-title">Update Record</h4>',
    'footer' => '',

]); ?>
<?php Modal::end(); ?>


<?php Modal::begin([
    'id' => 'create-modal',
    'size' => Modal::SIZE_LARGE,
    'header' => '<h4 class="modal-title">Create Record</h4>',
    'footer' => '<a href="#" class="btn btn-primary" data-dismiss="modal">Close</a>',

]); ?>
<?php Modal::end(); ?>