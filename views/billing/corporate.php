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

/* @var $this yii\web\View */
/* @var $searchModel app\models\AxionSpotsurveySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */



if (Yii::$app->request->isPjax) {
    $insurer = (isset($_GET['AxionPreinspectionSearch']) && isset($_GET['AxionPreinspectionSearch']['insurerName'])) ? $_GET['AxionPreinspectionSearch']['insurerName'] : $model->insurerName;
}else{
    $insurer = (isset($_GET['AxionPreinspectionSearch']) && isset($_GET['AxionPreinspectionSearch']['insurerArr'])) ? $_GET['AxionPreinspectionSearch']['insurerArr'] : $model->insurerArr;

}
if($insurer){

//$company = PreinspectionClientCompany::find()->where(['in', 'id', $insurer])->all();
    $company = PreinspectionClientCompany::find()->all();
    $companyData=ArrayHelper::map($company,'id','companyName');


    $branch = PreinspectionClientBranch::find()->where(['in','companyId', $insurer])->groupBy('branchName')->all();  

    $branchData= ($branch) ? ArrayHelper::map($branch,'id','branchName') : ''; 

    $divisions = PreinspectionClientDivision::find()->where(['in','companyId', $insurer])->groupBy('divisionName')->all();  

    $divisionData= ($divisions) ? ArrayHelper::map($divisions,'id','divisionName') : ''; 
}

$billType = (isset($_GET['AxionPreinspectionSearch']) && isset($_GET['AxionPreinspectionSearch']['billType'])) ? $_GET['AxionPreinspectionSearch']['billType'] : 'division';

$billPeriod = (isset($_GET['AxionPreinspectionSearch']) && isset($_GET['AxionPreinspectionSearch']['billPeriod'])) ? $_GET['AxionPreinspectionSearch']['billPeriod'] : $dateVar;

$gridColumns = [

   [
    //'class'=>'kartik\grid\ActionColumn',
    'class' => 'yii\grid\CheckboxColumn',
    'checkboxOptions' => ['onclick' => 'js:billGenerate(this.value, this.checked)','class'=>'otherCheckboxes'],
    /*'dropdown'=>true,
    'dropdownOptions'=>['class'=>'pull-right'],*/
    //'template' => '{view} {update} {delete}',
    //'template' => false,
       //'template' => Helper::filterActionColumn('{update}{transaction}{changerolist}'),
    'headerOptions'=>['class'=>'kartik-sheet-style','style'=>'border: 2px #000 solid; background-color:#480155;color:#fff;'],
      
],
[
    'attribute'=>'insurerName',
    'label' => 'Bill To',
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
    'attribute'=>'insurerDivision',
    'label' => 'Division',
    'vAlign'=>'middle',
    'headerOptions'=>['style'=>'border: 2px #000 solid; background-color:#480155;color:#fff;'],
    'contentOptions' => ['style' => 'border: 1px solid black;'],
    'visible' => ($billType =='division') ?  true:false,
    'value'=> 'callerDivision.divisionName',
    'filterType'=>GridView::FILTER_SELECT2,
    'filter'=>false, //$divisionData,
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
    'label' => 'Branch',
    'vAlign'=>'middle',
    'headerOptions'=>['style'=>'border: 2px #000 solid; background-color:#480155;color:#fff;'],
    'contentOptions' => ['style' => 'border: 1px solid black;'],
    'visible' => ($billType =='branch') ?  true:false,
    'value'=> 'callerBranch.branchName',
    'filterType'=>GridView::FILTER_SELECT2,
    'filter'=> false, //$divisionData,
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
    'attribute' => 'userId',
    'headerOptions'=>['style'=>'border: 2px #000 solid; background-color:#480155;color:#fff;'],
    'contentOptions' => ['style' => 'border: 1px solid black;'],
    'label' => 'Regional Office', 
    'filter' => false,
    'value'=>function ($model) {

        if($model->cityId){
            return $model->getStateByCity($model->cityId);
        }else{
            return $model->getStateByUser($model->userId);
        }
    },
],


[
    'attribute' => 'total2W',
    'label' => '2W(Cases)',
    'headerOptions'=>['style'=>'border: 2px #000 solid; background-color:#480155;color:#fff;'],
    'contentOptions' => ['style' => 'border: 1px solid black;'],
    'value' => function($model){
        return $model->total2W;
    }
],
[
    'attribute' => 'total3W',
    'label' => '3W(Cases)',
    'headerOptions'=>['style'=>'border: 2px #000 solid; background-color:#480155;color:#fff;'],
    'contentOptions' => ['style' => 'border: 1px solid black;'],
    'value' => function($model){
        return $model->total3W;
    }
],
[
    'attribute' => 'total4W',
    'label' => '4W(Cases)',
    'headerOptions'=>['style'=>'border: 2px #000 solid; background-color:#480155;color:#fff;'],
    'contentOptions' => ['style' => 'border: 1px solid black;'],
    'value' => function($model){
        return $model->total4W;
    }
],
[
    'attribute' => 'totalCW',
    'label' => 'CV(Cases)',
    'headerOptions'=>['style'=>'border: 2px #000 solid; background-color:#480155;color:#fff;'],
    'contentOptions' => ['style' => 'border: 1px solid black;'],
    'value' => function($model){
        return $model->totalCW;
    }
],
[
    'attribute' => 'extraKm',
    'label' => 'Extra KM(s)',
    'headerOptions'=>['style'=>'border: 2px #000 solid; background-color:#480155;color:#fff;'],
    'contentOptions' => ['style' => 'border: 1px solid black;'],
    'value' => function($model){
        return $model->totalKm;
    }
],
[
    'attribute' => 'extraKm',
    'label' => 'Bill Period',
    'headerOptions'=>['style'=>'border: 2px #000 solid; background-color:#480155;color:#fff;'],
    'contentOptions' => ['style' => 'border: 1px solid black;'],
    'value' => function($model) use ($billPeriod) {
        return $billPeriod;
    }
],


];
echo '<div class="col-md-12">';
echo $this->render('_search', ['model' => $searchModel]);
echo '</div>';

Pjax::begin();

echo GridView::widget([
    'dataProvider'=>$dataProvider,
    'filterModel'=>$searchModel,
    'columns'=>$gridColumns,
    'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => ''],
    'rowOptions'=>['style'=>'border: 2px #000 solid'],
    'rowOptions' => function ($model){
      if($model->status == '0' && $model->followupRemainder == '' ){
          return ['style'=>'background-color: #fb9393;'];
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

        /*['content'=>Html::a(FA::icon('redo'), [''], ['data-pjax'=>0, 'class'=>'btn btn-default', 'title'=>Yii::t('app', 'Refresh Grid')])
    ],*/
],
        // set export properties
'export'=>[
    'fontAwesome'=>true,
    'showConfirmAlert'=>false,
    'target'=>GridView::TARGET_BLANK,
    'label'=>'Export',
    'header'=>'<li role="presentation" class="dropdown-header">Axion Preinspection Fresh Records</li>',
],
        // parameters from the demo form
'bordered'=>false,
'striped'=>false,
'condensed'=>false,
'responsive'=>true,
'responsiveWrap'=>false,
'hover'=>true,
'showPageSummary'=>false,
'floatOverflowContainer' => false,
'floatHeader' => false,
'floatHeaderOptions' => ['top' => '50px'],
'panel'=>[
    'type'=>GridView::TYPE_PRIMARY,
    'headingOptions' => ['class'=>'panel-heading grid-panel-heading pt-10 pb-10 mb-15'],
    'footerOptions' => ['class'=>'panel-footer grid-panel-footer'],
            //'heading'=>'Corporate Blling'
],
'resizableColumns'=>false,
'persistResize'=>false,
'exportConfig'=>  [
]
]);

Pjax::end(); 
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
    function billGenerate(item_id, checked){
        //var pick_id = getUrlVars()["id"];
        console.log(item_id + checked);

        if(checked){
            /*$.ajax({
            url: 'index.php',
            method: 'get',
            dataType: 'text',
            data: {r:'picked-items/add', item:item_id, pick:pick_id}
            }).done(function(){alert('added')}).error(function(){alert('there was a problem...!')});*/
        }else{
            /*$.ajax({
            url: 'index.php',
            method: 'get',
            dataType: 'text',
            data: {r:'picked-items/deselect', item:item_id, pick:pick_id}
            }).done(function(){alert('deselected')}).error(function(){alert('there was a problem...!')});   */     
        }
        checkSelected();
    }
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