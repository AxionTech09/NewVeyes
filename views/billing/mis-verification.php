<?php

use kartik\grid\GridView;
use yii\helpers\Html;
use kartik\editable\Editable;
use yii\bootstrap\Modal;
use kartik\export\ExportMenu;
use yii\helpers\ArrayHelper;
use mdm\admin\components\Helper;
use yii\helpers\Url;
use rmrevin\yii\fontawesome\FA;
use rmrevin\yii\fontawesome\FAS;
use yii\widgets\Pjax;
use app\models\PreinspectionClientBranch;
use app\models\PreinspectionClientDivision;
use app\models\PreinspectionClientCompany;
use app\models\User;
use app\helpers\SbuHelper;
use app\models\AxionPreinspectionVehicle;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AxionSpotsurveySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$role = array_keys(Yii::$app->authManager->getRolesByUser(Yii::$app->user->getId()))[0] ;
$billId = isset($_GET['billId']) ? $_GET['billId'] : '';

if (Yii::$app->request->isPjax) {
    $insurer = (isset($_GET['AxionPreinspectionSearch']) && isset($_GET['AxionPreinspectionSearch']['companyId'])) ? $_GET['AxionPreinspectionSearch']['companyId'] : $model->insurerName;
}
else{
    $insurer = (isset($_GET['AxionPreinspectionSearch']) && isset($_GET['AxionPreinspectionSearch']['insurerArr'])) ? $_GET['AxionPreinspectionSearch']['insurerArr'] : $model->insurerArr;
}

if($insurer) {

    //$company = PreinspectionClientCompany::find()->where(['in', 'id', $insurer])->all();
    $company = PreinspectionClientCompany::find()->all();
    $companyData=ArrayHelper::map($company,'id','companyName');


    $branch = PreinspectionClientBranch::find()->where(['in','companyId', $insurer])->groupBy('branchName')->all();  
    $branchData= ($branch) ? ArrayHelper::map($branch,'id','branchName') : ''; 
    $divisions = PreinspectionClientDivision::find()->where(['in','companyId', $insurer])->groupBy('divisionName')->all();  
    $divisionData= ($divisions) ? ArrayHelper::map($divisions,'id','divisionName') : ''; 
}


//$billType = (isset($_GET['AxionPreinspectionSearch']) && isset($_GET['AxionPreinspectionSearch']['billType'])) ? $_GET['AxionPreinspectionSearch']['billType'] : 'division';
$billPeriod = (isset($_GET['AxionPreinspectionSearch']) && isset($_GET['AxionPreinspectionSearch']['billPeriod'])) ? $_GET['AxionPreinspectionSearch']['billPeriod'] : $dateVar;

$gridColumns = [
  
    [
        'attribute'=>'referenceNo',
        'vAlign'=>'middle',
        'headerOptions'=>['style'=>'border: 2px #000 solid; background-color:#480155;color:#fff;'],
        'contentOptions' => ['style' => 'border: 1px solid black;'],
        'contentOptions' => function ($model){
            if($model->billStatus == 'Verified' ) {
                return ['style'=>'background-color: #FBDBDF;'];
            }
            else {
                return [];
            }
        },
        'hiddenFromExport' => true,    
    ],
    [

        'attribute'=>'companyId',
        'label' => 'Company',
        'vAlign'=>'middle',
        'hiddenFromExport' => true,
        'headerOptions'=>['style'=>'border: 2px #000 solid; background-color:#480155;color:#fff;'],
        'contentOptions' => ['style' => 'border: 1px solid black;'],
        'contentOptions' => function ($model) {
            if($model->billStatus == 'Verified'){
                return ['style'=>'background-color: #FBDBDF;'];
            }
            else {
                return [];
            }
        },
        'value'=>function ($model) {
            $insurerName = $model->callerCompany;
            if(isset($insurerName->companyName)) {
                return  $insurerName->companyName;
            }
            else { return '';}
        },
        'filterType'=>GridView::FILTER_SELECT2,
        'filter'=>false,//$companyData,
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
        'attribute'=>'status',
        'label' => 'Status',
        'vAlign'=>'middle',
        'hiddenFromExport' => true,
        'headerOptions'=>['style'=>'border: 2px #000 solid; background-color:#480155;color:#fff;'],
        'contentOptions' => function ($model){
            if($model->billStatus == 'Verified' ){
                return ['style'=>'background-color: #FBDBDF;'];
            } 
            else {
                return [];
            }
        },
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
        'class' => 'kartik\grid\EditableColumn',
        'attribute'=>'surveyLocation',
        'vAlign'=>'middle',
        'hiddenFromExport' => true,
        'headerOptions'=>['style'=>'border: 2px #000 solid; background-color:#480155;color:#fff;'],
        'contentOptions' => ['style' => 'border: 1px solid black;'],
        'contentOptions' => function ($model){
            if($model->billStatus == 'Verified' ){
                return ['style'=>'background-color: #FBDBDF;'];
            }
            else {
                return [];
            }
        },
        'editableOptions' => function ($model, $key, $index) {
            $role = array_keys(Yii::$app->authManager->getRolesByUser(Yii::$app->user->getId()))[0];
            return [
                'header' => 'surveyLocation',
                'placement' => 'left',
                'inputType' => Editable::INPUT_TEXT,
                'submitOnEnter' => true,
                'asPopover'=>false, 
                'formOptions' => ['action' => ['/billing/edit-column']],
                //'editableValueOptions'=>['class'=>'text-danger']
                'editableValueOptions'=>['class'=>($role=='Superadmin' || $model->billStatus=="Initiated")?'form-control':'disableColumn','disabled'=>($role=='Superadmin' || $model->billStatus=="Initiated")?false:true], 
            
            ];
        },
        'refreshGrid' => true,
    ],
    [
        'class' => 'kartik\grid\EditableColumn',
        'attribute'=>'surveyLocation2',
        'vAlign'=>'middle',
        'hiddenFromExport' => true,
        'headerOptions'=>['style'=>'border: 2px #000 solid; background-color:#480155;color:#fff;'],
        'contentOptions' => ['style' => 'border: 1px solid black;'],
        'contentOptions' => function ($model){
            if($model->billStatus == 'Verified' ){
                return ['style'=>'background-color: #FBDBDF;'];
            }
            else {
                return [];
            }
        },
        'editableOptions' => function ($model, $key, $index) {
            $role = array_keys(Yii::$app->authManager->getRolesByUser(Yii::$app->user->getId()))[0];
            return [
            'header' => 'surveyLocation2',
            'placement' => 'left',
            'inputType' => Editable::INPUT_TEXT,
            'submitOnEnter' => true,
            'asPopover'=>false, 
            'formOptions' => ['action' => ['/billing/edit-column']],
                //'editableValueOptions'=>['class'=>'text-danger']
                'editableValueOptions'=>['class'=>($role=='Superadmin' || $model->billStatus=="Initiated")?'form-control':'disableColumn','disabled'=>($role=='Superadmin' || $model->billStatus=="Initiated")?false:true], 
            
            ];
        },
        'refreshGrid' => true,
    ],
    [
        'class' => 'kartik\grid\EditableColumn',
        'attribute' => 'paymentMode',
        'vAlign'=>'middle',
        'label' => 'Payment Mode',
        'hiddenFromExport' => true,
        'headerOptions'=>['style'=>'border: 2px #000 solid; background-color:#480155;color:#fff;'],
        'contentOptions' => ['style' => "border: 1px solid black;"],
        'contentOptions' => function ($model){
            if($model->billStatus == 'Verified' ){
              return ['style'=>'background-color: #FBDBDF;'];
            }
            else{
                return [];
            }
        },

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
        'editableOptions' => function ($model, $key, $index) {
            $role = array_keys(Yii::$app->authManager->getRolesByUser(Yii::$app->user->getId()))[0];
            return [
                'header' => 'cashCollection',
                'placement' => 'left',
                'inputType' => Editable::INPUT_DROPDOWN_LIST,
                'submitOnEnter' => true,
                'asPopover'=>false, 
                'data' => [1 => 'Company Billing', 2 => 'Fee and Conv. From Client', 3 => 'Company Billing and Conv. From Client'],
                'options' => ['class'=>'form-control', 'prompt'=>'Select Payment Mode'],
                'formOptions' => ['action' => ['/billing/edit-column']],
                //'editableValueOptions'=>['class'=>'text-danger']
                'editableValueOptions'=>['class'=>($role=='Superadmin' || $model->billStatus=="Initiated")?'form-control':'disableColumn','disabled'=>($role=='Superadmin' || $model->billStatus=="Initiated")?false:true],                 
            ];
        },
        'refreshGrid' => true,
    ],
   
    [
        'class' => 'kartik\grid\EditableColumn',
        'attribute'=>'cashCollection',
        'vAlign'=>'middle',
        'hiddenFromExport' => true,
        'headerOptions'=>['style'=>'border: 2px #000 solid; background-color:#480155;color:#fff;'],
        'contentOptions' => ['style' => 'border: 1px solid black;'],
        'contentOptions' => function ($model){
          if($model->billStatus == 'Verified' ){
              return ['style'=>'background-color: #FBDBDF;'];
          }else{
            return [];
          }
        },
        'editableOptions' => function ($model, $key, $index) {
            $role = array_keys(Yii::$app->authManager->getRolesByUser(Yii::$app->user->getId()))[0];
            return [
            'header' => 'cashCollection',
            'placement' => 'left',
            'inputType' => Editable::INPUT_TEXT,
            'submitOnEnter' => true,
            'asPopover'=>false, 
            'formOptions' => ['action' => ['/billing/edit-column']],
             //'editableValueOptions'=>['class'=>'text-danger']
             'editableValueOptions'=>['class'=>($role=='Superadmin' || $model->billStatus=="Initiated")?'form-control':'disableColumn','disabled'=>($role=='Superadmin' || $model->billStatus=="Initiated")?false:true], 
            
            ];
            },
        'refreshGrid' => true,
    ],
    [
        'class' => 'kartik\grid\EditableColumn',
        'attribute'=>'extraKM',
        'label' => 'Extra KM',
        'vAlign'=>'middle',
        'hiddenFromExport' => true,
        'headerOptions'=>['style'=>'border: 2px #000 solid; background-color:#480155;color:#fff;'],
        'contentOptions' => ['style' => 'border: 1px solid black;'],
        'contentOptions' => function ($model){
          if($model->billStatus == 'Verified' ){
              return ['style'=>'background-color: #FBDBDF;'];
          }else{
            return [];
          }
        },
        'editableOptions' => function ($model, $key, $index) {
            $role = array_keys(Yii::$app->authManager->getRolesByUser(Yii::$app->user->getId()))[0];
            return [
            'header' => 'extraKM',
            'placement' => 'left',
            'inputType' => Editable::INPUT_TEXT,
            'submitOnEnter' => true,
            'asPopover'=>false, 
            'formOptions' => ['action' => ['/billing/edit-column']],
             //'editableValueOptions'=>['class'=>'text-danger']
             'editableValueOptions'=>['class'=>($role=='Superadmin' || $model->billStatus=="Initiated")?'form-control':'disableColumn','disabled'=>($role=='Superadmin' || $model->billStatus=="Initiated")?false:true],            
            ];
            },
        'refreshGrid' => true,
    ],

    [
        'attribute' => 'referenceNo',
        'label' => 'Ref No',
        'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#337ab7;'],
        'hidden' => true
    ],
    [
        'attribute' => 'status',
        'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#337ab7;'],
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
        'hidden' => true
    ],
    [
        'attribute' => 'userId',
        'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#337ab7;'],
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
        'hidden' => true
    ],
    [
        'attribute' => 'callerCompany',
        'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#337ab7;'],
        'label' => 'Company Name', 
        'value'=>function ($model) {
            $insurerName = $model->callerCompany;
            if(isset($insurerName->companyName))
            {
                   return  $insurerName->companyName;
            }
            else { return '';}
        },        
        'hidden' => true
    ],
    [
        'attribute' => 'callerFirstName',
        'label' => 'Caller/ Executive Name', 
        'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#337ab7;'],
        'value'=>function ($model) {
            $user = $model->callerFirstName;
            if(isset($user->firstName))
            {
                   return  $user->firstName;
            }
            else { return '';}
        },     
        'hidden' => true
    ],
    [
        'attribute' => 'callerDetails',
        'label' => 'Caller/ Executive Email',
        'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#337ab7;'],
        'value'=>function ($model) {
            return $model->callerDetails ? $model->callerDetails : "";
         },       
        'hidden' => true
    ],
    [
        'attribute' => 'callerFirstName',
        'label' => 'Caller/ Executive Code',
        'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#337ab7;'],      
        'value'=>function ($model) {
            $user = $model->callerFirstName;
            if(isset($user->agent_code))
            {
                   return  $user->agent_code;
            }
            else { return '';}
        },   
        'hidden' => true
    ],
    [
        'attribute' => 'callerMobileNo',
        'label' => 'Caller/ Executive Contact No',
        'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#337ab7;'],  
        'hidden' => true      
    ],
    
    [
        'attribute' => 'callerFirstName',
        'label' => 'Zone',
        'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#337ab7;'],   
        'value'=>function ($model) {
            $user = $model->callerFirstName;
            if(isset($user->zone))
            {
                return  $user->zone;
            }
            else { return '';}
        },       
        'hidden' => true
    ],
    [
        'attribute' => 'insurerBranch',
        'label' => 'Branch',
        'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#337ab7;'],  
        'value' => 'callerBranch.branchName',
        'hidden' => true
    ],
    [
        'attribute' => 'insurerDivision',
        'label' => 'Division',
        'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#337ab7;'],        
        'value' => 'callerDivision.divisionName',
        'hidden' => true   
    ],
    [
        'attribute' => 'callerFirstName',
        'label' => 'Channel',
        'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#337ab7;'], 
        'value'=>function ($model) {
            $user = $model->callerFirstName;
            if(isset($user->channel))
            {
                return  $user->channel;
            }
            else { return '';}
        },      
        'hidden' => true
    ],
    [
        'attribute' => 'insuredName',
        'label' => 'Insured Name',
        'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#337ab7;'],
        'hidden' => true      
    ],
    [
        'attribute' => 'insuredAddress',
        'label' => 'Insured Address',
        'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#337ab7;'],
        'hidden' => true        
    ],
    [
        'attribute' => 'insuredMobile',
        'label' => 'Insured Mobile No',
        'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#337ab7;'],
        'hidden' => true       
    ],
    [
        'attribute' => 'registrationNo',
        'label' => 'Vehicle Number',
        'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#337ab7;'],
        'hidden' => true        
    ],
    [
        'attribute' => 'engineNo',
        'label' => 'Engine No',
        'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#337ab7;'],
        'hidden' => true       
    ],
    [
        'attribute' => 'chassisNo',
        'label' => 'Chassis No',
        'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#337ab7;'],
        'hidden' => true        
    ],
    [
        'attribute' => 'vehicleType',
        'label' => 'Odo Meter', 
        'value' => 'vType.odometerReading',
        'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#337ab7;'],
        'hidden' => true     
    ],
        
    [
        'attribute' => 'vehicleType',
        'label' => 'Vehicle Type',        
        'value' => function ($model) {
            $vmodel = AxionPreinspectionVehicle::findone(['preinspection_id' => $model->id]);
            return  $vmodel->vType;
        },
        'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#337ab7;'],
        'hidden' => true        
    ],
    [
        'attribute' => 'manufacturer',
        'label' => 'Manufacturer',
        'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#337ab7;'],
        'hidden' => true        
    ],
    [
        'attribute' => 'model',
        'label' => 'Model',
        'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#337ab7;'],
        'hidden' => true      
    ],
    [
        'attribute' => 'manufacturingYear',
        'label' => 'Manufacturer Year',
        'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#337ab7;'],
        'hidden' => true       
    ],
    [
        'attribute' => 'surveyLocation',
        'label' => 'Survey From Lcoation',
        'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#337ab7;'],
        'hidden' => true       
    ],
    [
        'attribute' => 'surveyLocation2',
        'label' => 'Survey To Location',
        'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#337ab7;'],
        'hidden' => true        
    ],
    
    [
        'attribute' => 'inspectionType',
        'label' => 'Inspect Type',
        'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#337ab7;'],
        'hidden' => true        
    ],
    [
        'attribute' => 'paymentMode',
        'label' => 'Payment Mode',
        'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#337ab7;'],
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
        'hidden' => true     
    ],
    [
        'attribute' => 'cashCollection',
        'value' => function($model){
            return (float) $model->cashCollection;            
        },
        'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#337ab7;'],
        'hidden' => true
    ],
    [
        'attribute' => 'extraKM',
        'label' => 'Conveyance Km',
        'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#337ab7;'],
        'hidden' => true        
    ],
    [
        'attribute' => 'intimationDate',
        'label' => 'Intimation Date Time',      
        'vAlign'=>'middle', 
        'format' => ['date', 'php:d-m-Y h:i a'],
        'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#337ab7;padding-right:10px;'],
        'hidden' => true 
    ],
    [
        'attribute' => 'surveyorName',
        'label' => 'Surveyor', 
        'value' => 'valuatorUser.firstName',
        'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#337ab7;'],
        'hidden' => true       
    ],
    [
        'attribute' => 'surveyorName',
        'label' => 'Surveyor Contact No',        
        'value' => 'valuatorUser.mobile',
        'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#337ab7;'],
        'hidden' => true
    ],
    [
        'attribute' => 'completedSurveyDateTime',
        'label' => 'Completed Date Time',   
        'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#337ab7;'],
        'value' => function($model){
            return ($model->completedSurveyDateTime) ? date('d-m-Y h:i',strtotime($model->completedSurveyDateTime)) : '';
        },
        'hidden' => true   
    ],
    [
        'attribute' => 'contactPersonMobileNo',
        'label' => 'Unique Lead Number',
        'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#337ab7;'],
        'hidden' => true     
    ],
    [
        'attribute' => 'billNumber',
        'label' => 'Bill Number',
        'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#337ab7;'],
        'value' => 'bill.billNumber',
        'hidden' => true     
    ],
    [
        'attribute' => 'sbuCode',
        'label' => 'SBU Code',
        'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#337ab7;'],
        'hidden' => true     
    ],
    [
        'attribute' => 'name',
        'label' => 'SBU Head Name',
        'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#337ab7;'],
        'value' => function($model) {
            $bill = $model->bill;

            if ($bill->sbuHeadId)
            {
                $sbuHead = SbuHelper::getSbuHeadDetails($bill->sbuHeadId);
                return $sbuHead->name;
            }
            else    
            {
                return '';
            }
        },
        'hidden' => true     
    ],
    [
        'attribute' => 'uploadSource',
        'label' => 'Upload Source',
        'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#337ab7;'],
        'hidden' => true    
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
        'hidden' => true 
    ],
    [
        'attribute' => 'updatedBy',
        'label' => 'Final Updation RO Name',
        'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#337ab7;'],
        'value'=>function ($model) {
            $res = $model->updatedByName;
            if(isset($res->firstName) && isset($res->firstName))
            {
                return  $res->firstName;
            }
            else { return '';}
        },
        'hidden' => true
    ],
    [
        'attribute'=>'remarks',
        'label' => 'Remarks',
        'vAlign'=>'middle',
        'hidden' => true,
        'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#337ab7;'],
    ],

    [
        //'class'=>'kartik\grid\ActionColumn',
        'class' => 'yii\grid\CheckboxColumn',
        //'checkboxOptions' => ['onclick' => 'js:billGenerate(this.value, this.checked)','class'=>'otherCheckboxes'],
        'checkboxOptions' => ['onclick' => 'js:checkSelected()','class'=>'otherCheckboxes'],
        'headerOptions'=>['class'=>'kartik-sheet-style','style'=>'border: 2px #000 solid; background-color:#480155;color:#fff;'],
        'contentOptions' => ['class' => 'kv-align-middle']
        //'hiddenFromExport' => true,
    ],
    [
        'class'=>'kartik\grid\ActionColumn',
        'template' => Helper::filterActionColumn('{verify}'),
        'headerOptions'=>['style'=>'border: 2px #fff solid; background-color:#480155;color:#fff;'],
        'buttons' => [
            'update' => function ($url, $model, $key) {       
                return Html::a(FA::icon('edit', ['class' => 'mr-5 mt-5 text-success']),'#', [
                    'class' => 'activity-update-link',
                    'title' => Yii::t('yii', 'Update'),
                    'data-toggle' => 'modal',
                    'data-target' => '#update-modal',
                    'data-id' => $key,
                    'data-pjax' => '0',

                ]);
            },
            'verify' => function ($url, $model, $key) {       
                if($model->billStatus=='Initiated'){
                    return Html::a(FA::icon('verify', ['class' => 'mr-5 mt-5 text-danger fa-check-circle']),['verify', 'id' => $model->id], [
                        //'class' => 'activity-update-link',
                        'title' => Yii::t('yii', 'Verify'),
                        'data' => [
                            'confirm' => 'Are you sure you want to verify this case?',
                            'method' => 'post',
                        ],

                    ]);
                }
                else {
                    return '<span class="label label-success" > '.$model->billStatus.'</span>';
                }
            },
        ],
    ],
];

if($role != 'Superadmin') {
    echo '<div class="col-md-12">';
    echo $this->render('_search', ['model' => $searchModel,'role'=>$role,'billId'=>$billId]);
    echo '</div>';
}

$models = $dataProvider->getModels();
$ids = [];
foreach ($models as $model) {
    $ids[] = $model->id;
}

$verifySelectedBtn = Html::a('Verify Selected','#', [
                        'id' => 'verify-select-btn',
                        'class'=>'btn btn-primary generateBtn',
                        'style' =>'display:none',
                        'title' => Yii::t('yii', 'Verify Selected'),
                        'data' => [
                            'confirm' => 'Are you sure you want to verify the selected cases?',
                            'method' => 'post',
                            'data-pjax'=>true
                        ],
                        'data-pjax' => true
                    ]);

if($ids){
    $verifyAllBtn = Html::a('Verify All',['verify-all', 'ids' => json_encode($ids)], [
                        'class' => 'btn btn-success',
                        'title' => Yii::t('yii', 'Verify All'),
                        'data' => [
                            'confirm' => 'Are you sure you want to verify all the cases?',
                            'method' => 'post',
                            'data-pjax'=>true
                        ],
                    ]); 
}
//Pjax::begin();

$perPage =  \nterms\pagesize\PageSize::widget(
[   
    'template' => '{list}',
    'defaultPageSize' => 50,
    'sizes' => [10=>10, 20=>20, 50=>50, 100=>100, 200=>200, 500=>500, 1000=>1000, 2000=>2000, 'All'=> 'All'],
    'options' => ['class'=>'perPage']
] 
);

$fullExportMenu = ExportMenu::widget([
    'dataProvider' => $dataProvider,
    'columns' => $gridColumns,
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
    //'filterModel'=>$searchModel,
    'filterSelector' => 'select[name="per-page"]',
    'columns'=>$gridColumns,
    'layout' => "\n{items}",
    'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => ''],
    'rowOptions'=>['style'=>'border: 2px #000 solid'],    
    'containerOptions'=>['style'=>'font-size:12px;'], // only set when $responsive = false
    'headerRowOptions'=>['class'=>'kartik-sheet-style'],
    'filterRowOptions'=>['class'=>'kartik-sheet-style'],
    'pjax'=>true, // pjax is set to always true for this demo
    // set your toolbar
    'toolbar'=> [

        [ 'content'=>   
            // Html::a(FA::icon('redo'), [''], ['data-pjax'=>0, 'class'=>'btn btn-default', 'title'=>Yii::t('app', 'Refresh Grid')])
            '{export} '.$perPage. '&nbsp;'. $verifySelectedBtn.' '.$verifyAllBtn
        ],
    ],
    // set export properties
    /*'export'=>[
        'fontAwesome'=>true,
        'showConfirmAlert'=>false,
        'target'=>GridView::TARGET_BLANK,
        'label'=>'Export',
        'header'=>'<li role="presentation" class="dropdown-header">Axion Preinspection Fresh Records</li>',
    ],*/
    'export' => [
        'label'=>'Export',
        'header'=>'<li role="presentation" class="dropdown-header">Axion Preinspection Billing Records</li>',
        'itemsAfter'=> [
            $fullExportMenu
        ],
    ],
    // parameters from the demo form
    'bordered'=>false,
    'striped'=>false,
    'condensed'=>false,
    'responsive'=>false,
    'responsiveWrap'=>false,
    'hover'=>true,
    'showPageSummary'=>false,
    'floatOverflowContainer' => false,
    'floatHeader' => false,
    'floatHeaderOptions' => ['top' => '50px'],
    'panel'=>[
        'type'=>GridView::TYPE_PRIMARY,
        'options' => ['class' => 'auto-scroll-panel'],
        'heading'=>'Billing MIS Verification',
        'headingOptions' => ['class'=>'panel-heading grid-panel-heading pt-10 pb-10 mb-15'],
        'footerOptions' => ['class'=>'panel-footer grid-panel-footer'],
    ],
    'resizableColumns'=>false,
    'persistResize'=>false,
    'exportConfig'=>  [
        ExportMenu::PDF => ['label' => false, 'icon' => false,'visible' => false,'hidden' => true]
    ]
]);

//Pjax::end(); 
?>


<?php
$script = <<< JS
$(function () {
       // var keys = $('#grid').yiiGridView('getSelectedRows');
    
    $('.select-on-check-all').click(function () {

        if($(this).prop('checked')){
            showButton();
        }else{
            hideButton();
        }
    });

       
});


JS;

$this->registerJS($script);
?>

<script type="text/javascript">
    /*function billGenerate(item_id, checked){        
        checkSelected();
    }*/
    function checkSelected() {
        var checkedNum = $('input[name="selection[]"]:checked').length;
        if (checkedNum) {
            showButton();
        }else{
            hideButton();
        }

    }
    function showButton(){
        $(".generateBtn").show();
    }
    function hideButton(){
        $(".generateBtn").hide();
    }
</script>
<?php 
$verifySelectedUrl = Yii::$app->request->baseUrl."/billing/verify-selected";
$updateUrl = Yii::$app->request->baseUrl."/billing/inspection-update";
$this->registerJs(
        "
    var role = $('#role').val();
    if(role=='Superadmin'){
        $('.searchForm').hide();
    }
    $('body').on('click', '.generateBtn', function() {
            var ids = '';
            $('.otherCheckboxes').each(function () {
                var sThisVal = (this.checked ? this.value : '');
                console.log(sThisVal);
                if(sThisVal){
                     ids += (ids=='' ? sThisVal : ',' + sThisVal);
                }
            });
            $.ajax({
                url: '".$verifySelectedUrl."',
                method: 'post',
                data: {ids:ids}
                }).done(function(data){});
        });

    $('body').on('click', '.activity-update-link', function() {
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
})
    "
); ?>

<?php Modal::begin([
    'id' => 'update-modal',
    'size' => Modal::SIZE_LARGE,
    'header' => '<h4 class="modal-title">Update Record</h4>',
    'footer' => '<a href="#" class="btn btn-primary" data-dismiss="modal">Close</a>',

]); ?>
<?php Modal::end(); ?>

<style type="text/css">
    .btn-toolbar .dropdown{
        width: auto !important;
    }
    .bootstrap-select.perPage button.dropdown-toggle{
        margin: -5px -13px;
        width: 86px;
    }
    .kv-editable{
        line-height:1;
    }
    .kv-editable-value{
        height: 30px;
        font-size: 12px;
    }
    .disableColumn{
        border: none;
        background: none;
    }
    .disableColumn:hover {
        font-weight: normal !important;
    }
     button.kv-editable-value{
        height: auto;
        min-width: 125px;
    }
    td.w2{
        vertical-align: middle !important;
    }
</style>