<?php

use yii\helpers\ArrayHelper;
use mdm\admin\components\Helper;
use yii\helpers\Url;
use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use app\models\PreinspectionClientCompany;
use kartik\date\DatePicker;
use kartik\daterange\DateRangePicker;
use yii\bootstrap\ActiveForm;
use kartik\datecontrol\DateControl;
use app\models\MasterState;
use app\models\PreinspectionClientBranch;
use kartik\depdrop\DepDrop;
use app\models\PreinspectionClientDivision;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AxionSpotsurveySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$company = PreinspectionClientCompany::find()->all();
$companyList =ArrayHelper::map($company,'id','companyName');
$typeArr = [ 
    ['id' =>'division', 'name' => 'Diviion Wise'],
    ['id' => 'branch', 'name' => 'Branch Wise']
];
$billingTypes =ArrayHelper::map($typeArr,'id','name');

//$dateVar = date('d-M-Y',strtotime('First day of month')). ' to '.date('d-M-Y',strtotime('Last day of month'));
//$dateVar = date('01-M-Y'). ' to '.date('t-M-Y');

$billPeriod = (isset($_GET['AxionPreinspectionBilling']) && isset($_GET['AxionPreinspectionBilling']['billPeriod'])) ? $_GET['AxionPreinspectionBilling']['billPeriod'] : '';
if ($role == 'Superadmin' || $role == 'admin')
    $model->billPeriod = ($billPeriod) ? date('F Y',strtotime($billPeriod)) : date('F Y');
else
    $model->billPeriod = ($billPeriod) ? date('F Y',strtotime($billPeriod)) : date('F Y', strtotime('last month'));

$stateId = (isset($_GET['AxionPreinspectionBilling']) && isset($_GET['AxionPreinspectionBilling']['stateId'])) ? $_GET['AxionPreinspectionBilling']['stateId'] : '';
$model->stateId = $stateId;
 

$branchId = (isset($_GET['AxionPreinspectionBilling']) && isset($_GET['AxionPreinspectionBilling']['branchId'])) ? $_GET['AxionPreinspectionBilling']['branchId'] : '';

$companyId = (isset($_GET['AxionPreinspectionBilling']) && isset($_GET['AxionPreinspectionBilling']['companyId'])) ? $_GET['AxionPreinspectionBilling']['companyId'] : (isset($_GET['companyId']) ? $_GET['companyId'] : '');

$branchQuery = PreinspectionClientBranch::find();
if($companyId){
    $branchQuery->where(['companyId'=>$model->companyId]);
}
$branch = $branchQuery->all();
$branchArr= ($branch) ? ArrayHelper::map($branch,'id','branchName') : []; 

$model->branchId = $branchId;
$verifyUrl = ($role == 'Superadmin' && !$billId) ? 'mis-verification-admin' : 'mis-verification';

if($role == 'Superadmin' && !$billId){ 
    $state = PreinspectionClientDivision::find()->all();  
    $stateArr= ($state) ? ArrayHelper::map($state,'id','divisionName') : '';
}else{ 
    $state = MasterState::find()->all();  
    $stateArr= ($state) ? ArrayHelper::map($state,'id','state') : '';
}

?>

    <?php $form = ActiveForm::begin([
        'action' => [$verifyUrl],
        'method' => 'get',
        'options' => ['class' => 'searchForm','layout' => 'horizontal','enableAjaxValidation' => true,],
        
    ]); 

    if(!$billId) { ?>

        <div class="col-sm-4 col-md-3 text-error">
            <?php
                if ($role == 'Superadmin' || $role == 'admin') {
                    echo $form->field($model, 'billPeriod')->widget(DatePicker::classname(), [
                        'type'=>DatePicker::TYPE_INPUT, //    DateControl::FORMAT_DATETIME, 
                        'pluginOptions' => [
                            'autoclose' => true,
                            'format' => 'MM yyyy',
                            'minViewMode'=>'months',
                        ],
                        'options' => ['allowClear' => false,],
                        
                    ])->label('Bill Period *');
                } 
                else {
                    echo $form->field($model, 'billPeriod')->widget(DatePicker::classname(), [
                        'type'=>DatePicker::TYPE_INPUT, //    DateControl::FORMAT_DATETIME, 
                        'pluginOptions' => [
                            'autoclose' => true,
                            'format' => 'MM yyyy',
                            'minViewMode'=>'months',
                            'endDate' => "-1m"
                        ],
                        'options' => ['allowClear' => false,],
                            
                    ])->label('Bill Period *');
                }
            ?>            
        </div>

        <div class="col-sm-4 col-md-3 text-error">  
            <?= $form->field($model, 'companyId')->dropDownList($companyList,['id'=>'companyId','class'=>'form-control','data-actions-box'=>"true", 'data-live-search'=>"true",'prompt'=>'Choose Client','allowClear'=>true])->label('Client(s) *'); ?>
        </div>

    <?php } else { 
        echo '<div class="col-sm-4 col-md-3 text-error">';
        echo $form->field($model,'companyId')->hiddenInput(['name'=>'companyId','value'=>$companyId,'id'=>'companyId'])->label(false);
        echo '</div>';
    }?>

    <div class="col-sm-4 col-md-3"  id="stateSection" style="display: none;">
        <?= $form->field($model, 'stateId')->dropDownList($stateArr,['id'=>'stateId','class'=>'form-control','data-actions-box'=>"true", 'data-live-search'=>"true",'prompt'=>'Choose State','allowClear'=>true])->label('State(s)'); ?>
    </div>

    <div class="col-sm-4 col-md-3"  id="branchSection" style="display:none;">
        <?= $form->field($model, 'branchId')->dropDownList($branchArr,['id'=>'branchId','class'=>'form-control','data-actions-box'=>"true", 'data-live-search'=>"true",'prompt'=>'Choose Branch','allowClear'=>true])->label('Branch(es)'); ?>

        <input type="hidden" name="role" id="role" value="<?= $role ?>">
        <input type="hidden" name="selectedBranch" id="selectedBranch" value="<?= $model->branchId ?>">
        <input type="hidden" name="selectedDivision" id="selectedDivision" value="<?= $model->stateId ?>">
        <input type="hidden" name="selectedState" id="selectedState" value="<?= $model->stateId ?>">
        <input type="hidden" name="billId" id="billId" value="<?= $billId ?>">
    </div>

    <div class="col-sm-4 col-md-3">
        <div class="form-group mt-30">  
            <?= Html::submitButton('<i class="fa fa-search"></i> Search', ['class' => 'btn btn-primary','submit'=>'submit']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>


<style>
.generateBtns {
    background-color: brown;
    border: none;
    color: white;
    padding: 6px 15px;
    font-size: 16px;
    cursor: pointer;
    height: 36px;
    width: 150px;
}
</style>

<?php 
$getCompanyDetails = Yii::$app->request->baseUrl."/billing/get-company-details";
$getDivisions = Yii::$app->request->baseUrl."/billing/get-divisions";
$getStates = Yii::$app->request->baseUrl."/billing/get-states";
$getBranches = Yii::$app->request->baseUrl."/billing/get-branches";

$this->registerJs(
    "
    $('body').on('change', '#companyId', function() {
            var companyId = $(this).val();
            //if(companyId){
                showState(companyId);
            //}
        });

        showState();
''    ");

?>
<script type="text/javascript">

    function showState(companyId=false){
        var companyId = companyId ? companyId : $('#companyId').val();
        if(companyId){
        $.ajax({
            url: '<?php echo $getCompanyDetails; ?>',
            method: 'post',
            data: {companyId:companyId}
            }).done(function(data){
                var result = JSON.parse(data);
                //console.log()''
                if(result && result.result=='success'){
                    if(result.billType == 'State Bill'){
                        $('#stateSection').show();
                        var role = $("#role").val();
                        var selectedState = $("#selectedState").val()
                        var billId = $("#billId").val()
                        if(role=="Superadmin" && billId==""){
                            $("#stateId").html("");
                            $.ajax({
                                url: '<?php echo $getStates ?>',
                                method: 'post',
                                data: {companyId:companyId,stateId:selectedState}
                                }).done(function(data){
                                    var result = JSON.parse(data);
                                    if(result.result=='success'){
                                        $('#stateId').append(result.data);
                                    }
                            });
                        }
                        $('#branchSection').hide();           
                    }else if(result.billType == 'Branch Bill'){
                        $('#stateSection').hide();
                        $("#stateId").val("");
                        showBranch(companyId);                        
                    }else{
                        $('#stateSection').hide();
                        $('#branchSection').hide();
                        $('#stateId').val("");
                        $('#branchId').val("");
                        //$("#stateId").selectpicker("refresh");
                        //$("#branchId").selectpicker("refresh");
                    }
                }else{
                    $('#stateSection').hide();
                    $('#branchSection').hide();
                    $('#branchId').val("");
                    $('#stateId').val("");
                    ///$("#stateId").selectpicker("refresh");
                    //$("#branchId").selectpicker("refresh");
                }
            });
        }else{
             $('#stateSection').hide();
             $('#branchSection').hide();
             $('#branchId').val("");
             $('#stateId').val("");

             //$("#stateId").selectpicker("refresh");
             //$("#branchId").selectpicker("refresh");

        }
    }

    function showBranch(companyId){
        var selectedBranch = $("#selectedBranch").val();
        console.log(selectedBranch);
        $('#branchSection').show();
        $('#stateSection').hide();
        $('#branchId').html("");
        //$('#branchId').append('<option value="">Choose Branch</option>');
        //$("#branchId").selectpicker("refresh");
        $.ajax({
            url: '<?php echo $getBranches; ?>',
            method: 'post',
            data: {companyId:companyId,branchId:selectedBranch}
            }).done(function(data){
                var result = JSON.parse(data);
                if(result.result=='success'){
                    $('#branchId').append(result.data);
                    //$("#branchId").selectpicker("refresh");
                }
            });
    }
</script>