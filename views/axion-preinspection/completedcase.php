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
use app\models\AxionPreinspectionVehicle;

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



$selectedColums = [
    [
        'attribute' => 'referenceNo',
        'label' => 'Ref No'
    ],
    [
        'attribute' => 'status',
        'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#480155;'],
        'contentOptions' => ['style' => 'border: 1px solid black;'],
        'label' => 'Status',
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
            else if($status == '9')
            {
                return  'Cancelled';
            }
            else { return '';}
        },
    ],
    [
        'attribute' => 'userId',
        'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#480155;'],
        'contentOptions' => ['style' => 'border: 1px solid black;'],
        'label' => 'Regional Center', 
        'value'=>function ($model) {
            $res = $model->callerFirstName;
            $data = '';
            if(isset($res->roId) && $res->roId)
            {
                $user = User::find()->where(['id'=> $res->roId])->one();
                $data =  $user->stateData->state;
            }
            else { 

                $res = $model->state;
                if(isset($res->state))
                {
                    $data = $res->state;
                }
            
            }
            return $data;
        },
    ],
    [
        'attribute' => 'callerCompany',
        'label' => 'Company Name', 
        'value'=>function ($model) {
            $insurerName = $model->callerCompany;
            if(isset($insurerName->companyName))
            {
                return  $insurerName->companyName;
            }
            else { return '';}
        },        
    ],
     [
        'attribute' => 'callerFirstName',
        'label' => 'Caller/ Executive Name', 
        'value'=>function ($model) {
            $user = $model->callerFirstName;
            if(isset($user->firstName))
            {
                return  $user->firstName;
            }
            else { return '';}
        },     
    ],
    [
        'attribute' => 'callerDetails',
        'label' => 'Caller/ Executive Email', 
        'value'=>function ($model) {
            return $model->callerDetails ? $model->callerDetails : "";
        },       
    ],
    [
        'attribute' => 'callerFirstName',
        'label' => 'Caller/ Executive Code',       
        'value'=>function ($model) {
            $user = $model->callerFirstName;
            if(isset($user->agent_code))
            {
                return  $user->agent_code;
            }
            else { return '';}
        },   
    ],
    [
        'attribute' => 'callerMobileNo',
        'label' => 'Caller/ Executive Contact No',        
    ],
    
    [
        'attribute' => 'callerFirstName',
        'label' => 'Zone',   
         'value'=>function ($model) {
            $user = $model->callerFirstName;
            if(isset($user->zone))
            {
                return  $user->zone;
            }
            else { return '';}
        },       
    ],
    [
        'attribute' => 'insurerBranch',
        'label' => 'Branch',   
        'value' => 'callerBranch.branchName'     
    ],
    [
        'attribute' => 'insurerDivision',
        'label' => 'Division',        
        'value' => 'callerDivision.divisionName'     
    ],
    [
        'attribute' => 'callerFirstName',
        'label' => 'Channel', 
        'value'=>function ($model) {
            $user = $model->callerFirstName;
            if(isset($user->channel))
            {
                return  $user->channel;
            }
            else { return '';}
        },      
    ],
    [
        'attribute' => 'insuredName',
        'label' => 'Insured Name',        
    ],
    [
        'attribute' => 'insuredAddress',
        'label' => 'Insured Address',        
    ],
    [
        'attribute' => 'insuredMobile',
        'label' => 'Insured Mobile No',        
    ],
    [
        'attribute' => 'registrationNo',
        'label' => 'Vehicle Number',        
    ],
    [
        'attribute' => 'engineNo',
        'label' => 'Engine No',        
    ],
    [
        'attribute' => 'chassisNo',
        'label' => 'Chassis No',        
    ],
    [
        'attribute' => 'vehicleType',
        'label' => 'Odo Meter', 
        'value' => 'vType.odometerReading',       
    ],
        
    [
        'attribute' => 'vehicleType',
        'label' => 'Vehicle Type',        
        'value' => function ($model) {
            $vmodel = AxionPreinspectionVehicle::findone(['preinspection_id' => $model->id]);
            return  $vmodel->vType;
        },     
    ],
    [
        'attribute' => 'manufacturer',
        'label' => 'Manufacturer',        
    ],
    [
        'attribute' => 'model',
        'label' => 'Model',        
    ],
    [
        'attribute' => 'manufacturingYear',
        'label' => 'Manufacturer Year',        
    ],
    [
        'attribute' => 'surveyLocation',
        'label' => 'Survey From Lcoation',        
    ],
    [
        'attribute' => 'surveyLocation2',
        'label' => 'Survey To Location',        
    ],
    
    [
        'attribute' => 'inspectionType',
        'label' => 'Inspect Type',        
    ],
    [
        'attribute' => 'paymentMode',
        'label' => 'Payment Mode',
        'value'=>function ($model) {
            $paymentMode = $model->paymentMode;
            
            if($paymentMode == 1)
            {
                return  'Company Billing';
            }
            else if($paymentMode == 2)
            {
                return  'Fee and Conv. From Client';
            }
            else if($paymentMode == 3)
            {
                return  'Company Billing and Conv. From Client';
            }
            else { return '';}
        },     
    ],
    [
        'attribute' => 'cashCollection',
        'value' => function($model){
            return (float) $model->cashCollection;            
        }
    ],
    [
        'attribute' => 'extraKM',
        'label' => 'Conveyance Km',        
    ],
    [
        'attribute' => 'intimationDate',
        'label' => 'Intimation Date Time',        
    ],
    [
        'attribute' => 'surveyorName',
        'label' => 'Surveyor', 
        'value' => 'valuatorUser.firstName'       
    ],
    [
        'attribute' => 'surveyorName',
        'label' => 'Surveyor Contact No',        
        'value' => 'valuatorUser.mobile'
    ],
    [
        'attribute' => 'updated_on',
        'label' => 'Last Modified Date Time',        
    ],
    [
        'attribute' => 'completedSurveyDateTime',
        'label' => 'Completed Date Time',        
    ],
    [
        'attribute' => 'contactPersonMobileNo',
        'label' => 'Unique Lead Number',        
    ],
    [
        'attribute' => 'uploadSource',
        'label' => 'Upload Source'    
    ],
    [
        'attribute' => 'updatedBy',
        'label' => 'Final Updation Zone',
        'value'=>function ($model) {
            $res = $model->updatedByName;
            if(isset($res->zone))
            {
                return  $res->zone;
            }
            else { return '';}
        },  
    ],
    [
        'attribute' => 'updatedBy',
        'label' => 'Final Updation RO Name',
        'value'=>function ($model) {
            $res = $model->updatedByName;
            if(isset($res->firstName) && isset($res->firstName))
            {
                   return  $res->firstName;
            }
            else { return '';}
        },  
    ],
    [
        'attribute'=>'sbuCode',
        'label' => 'SBU Code',
    ],
    [
        'attribute'=>'billNumber',
        'value' => 'bill.billNumber'
    ],
    [
        'attribute' => 'remarks',
        'label' => 'Remarks',        
    ],
    [
        'attribute' => 'surveyDoneOn',
    ],

    [
        'attribute' => 'qcDoneOn',
    ],

    [
        'attribute' => 'cancelledOn',
    ],
];
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

$gridColumns = [

    [
    'class'=>'kartik\grid\ActionColumn',
    /*'dropdown'=>true,
    'dropdownOptions'=>['class'=>'pull-right'],*/
    //'template' => '{view} {update} {delete}',
    'template' => Helper::filterActionColumn('{update}{transaction}{changerolist}{vehicleqc}{vehicleqcpdf}{downloadphotos}'),
    'headerOptions'=>['class'=>'kartik-sheet-style'],
    'headerOptions'=>['style'=>'border: 2px #000 solid; background-color:#480155;color:#fff;'],
    'noWrap' => 1,
    'mergeHeader' => false,
    'buttons' => [
            'update' => function ($url, $model, $key) {       
                $role = array_keys(Yii::$app->authManager->getRolesByUser(Yii::$app->user->getId()))[0] ;
                if($role=="Admin" || $role=="Superadmin")
                {    
            
                    return '<div class="row">'.Html::a(FA::icon('edit', ['class' => 'mr-5 mt-5 text-success']), '#', [
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
                if($role!="Surveyor")
                {
                    return Html::a(FA::icon('history', ['class' => 'mr-5 mt-5 text-primary']), Yii::$app->request->baseUrl.'/axion-preinspection/transaction?id='.$key, [
                        'class' => 'activity-transaction-link',
                        'title' => Yii::t('yii', 'Transaction'),
                        'data-id' => $key,
                        'data-pjax' => '0',
                        'target'=>'_blank',

                    ]);
                }
            },
            'changerolist' => function ($url, $model, $key) {
            
                $role = array_keys(Yii::$app->authManager->getRolesByUser(Yii::$app->user->getId()))[0] ;
                if($role=="Admin" || $role=="Superadmin")
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
            'vehicleqc' => function ($url, $model, $key) {

                $role = array_keys(Yii::$app->authManager->getRolesByUser(Yii::$app->user->getId()))[0] ;
                if($role=="Admin" || $role=="Superadmin" || $role == 'Veyes UAT'  || $role == 'BO User')
                {
                    $display='display:inline-block';
                }
                else{
                    $display='display:none';
                }
                    
                if(strtolower(preg_replace('/[^\w]/', '', $model->vehicleType)) == 'allvehicle')
                {
                    return '<div class="row">'.Html::a(FA::icon('user-check text-darkYellow', ['class' => 'mr-5 mt-5']), Yii::$app->request->baseUrl.'/axion-preinspection/vehicleqc?id='.$key.'&page=completed', [
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
                    
            'vehicleqcpdf' => function ($url, $model, $key) {
                $role = array_keys(Yii::$app->authManager->getRolesByUser(Yii::$app->user->getId()))[0] ;
                if($model->status == 101 || $model->status == 102 || $model->status == 104) 
                {
                    if(strtolower(preg_replace('/[^\w]/', '', $model->vehicleType)) == 'allvehicle')
                    {
                        return " ".Html::a(FAS::icon('file-download', ['class' => 'mr-5 mt-5 text-limered']), Yii::$app->request->baseUrl.'/axion-preinspection/vehicleqcpdf?id='.$model->id, [
                            'class' => 'activity-vehicleqcpdf-link',
                            'title' => Yii::t('yii', 'Download Report'),
                            'data-id' => $key,
                            'data-pjax' => '0',
                            'target'=>'_blank',

                        ]);
                    }
                    else if(strtolower(preg_replace('/[^\w]/', '', $model->vehicleType)) == 'commercial')
                    {
                    return " ".Html::a(FAS::icon('file-download', ['class' => 'mr-5 mt-5 text-limered']), Yii::$app->request->baseUrl.'/axion-preinspection/commercialpdf?id='.$model->id, [
                        'class' => 'activity-vehicleqcpdf-link',
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
                    return Html::a(FAS::icon('images', ['class' => 'mr-5 mt-5 text-limegreen']), Yii::$app->request->baseUrl.'/axion-preinspection/downloadphotos?id='.$key, [
                        'class' => 'activity-transaction-link',
                        'title' => Yii::t('yii', 'Download Photos'),
                        'data-id' => $key,
                        'data-pjax' => '0',
                        'target'=>'_blank',

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
            $url = Yii::$app->urlManager->createAbsoluteUrl(['/axion-preinspection/vehicleqc', 'id' => $model->id, 'page' => 'completed']);
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
        'attribute'=>'registrationNo',
        'label'=>'Reg. No',
        'vAlign'=>'middle',
        'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#480155;'],
    ],

    [
        'attribute'=>'vTypeName',
        'vAlign'=>'middle',
        'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#480155;color:white;'],
        'value' => function ($model) {
            $vmodel = AxionPreinspectionVehicle::findone(['preinspection_id' => $model->id]);
            return  $vmodel->vType;
        },
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
        }
    ],

    [
        'attribute'=>'status',
        'vAlign'=>'middle',
        'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#480155;padding-right:100px;'],
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
            else if($status == '9')
            {
                return  'Cancelled';
            }
            else { return '';}
         },
        'filterType'=>GridView::FILTER_SELECT2,
        'filter'=>['101'=>'PI-Recommended','102'=>'PI-Not Recommended','103'=>'PI-Inprogress','104'=>'PI-Refer to Under Writer','9'=>'Cancelled'],
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
        'attribute'=>'completedSurveyDateTime',
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
        'attribute'=>'uploadSource',
        'vAlign'=>'middle',
        'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#480155;'],
        'value'=>function ($model) {
            $upload = $model->uploadValue;
                if($model->uploadSource)
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
        'attribute'=>'sbuCode',
        'vAlign'=>'middle',
        'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#480155;'],
    ],

    [
        'attribute'=>'ErrorDesc',
        'vAlign'=>'middle',
        'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#480155;'],
    ],

    [
        'attribute'=>'remarks',
        'vAlign'=>'middle',
        'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#480155;'],
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
        'attribute'=>'callerMobileNo',
        'vAlign'=>'middle',
        'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#480155;'],
    ],

    [
        'attribute'=>'insuredName',
        'vAlign'=>'middle',
        'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#480155;'],
    ],

    [
        'attribute'=>'insuredMobile',
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
        'attribute'=>'contactPersonMobileNo',
        'label' => (strpos( Yii::$app->request->absoluteUrl, 'test') !== false || strpos( Yii::$app->request->absoluteUrl, 'saptechservices.in') !== false)?'Unique Lead No':'',
        'vAlign'=>'middle',
        'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#480155;padding-right:10px;'],
        'visible'=> (strpos( Yii::$app->request->absoluteUrl, 'test') !== false || strpos( Yii::$app->request->absoluteUrl, 'saptechservices.in') !== false)?true:false,
    ],
    
*/


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
            'label'=>'Download MIS',
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
})
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