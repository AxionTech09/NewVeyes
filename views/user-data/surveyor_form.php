<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Userdata */
/* @var $form yii\widgets\ActiveForm */

$activeList= [
  ['id' => 'Y', 'name' => 'Y'],
  ['id' => 'N', 'name' => 'N'],
];
$activeArray = ArrayHelper::map($activeList, 'id', 'name');
$cityList =ArrayHelper::map($city,'id','city');
$stateList=ArrayHelper::map($state,'id','state');
$ro_name=ArrayHelper::map($ro_name,'id','firstName');

$salaryTypeArr = [
    "Fixed Salary" => "Fixed Salary",
    "Variable Salary" => "Variable Salary"
];
$conveyanceTypeArr = [
    "Fixed Conveyance" => "Fixed Conveyance",
    "Variable Conveyance" => "Variable Conveyance"
];
$model->joiningDate = ($model->joiningDate) ? date("d/m/Y",strtotime($model->joiningDate)) : '';

?>

<div class="userdata-form">
    
    <?php $form = ActiveForm::begin(['id'=>$model->formName(),'enableAjaxValidation'=>true,]); ?>

    <div class="row userform">
        <div id="surveyor_details" class="panel panel-primary pb-15">
        <div class="panel-heading light-panel-heading pb-15">
            <h4 class="panel-title">Surveyor Details</h4>
        </div>

        <div class="panel-body">

        <div class="col-lg-4">
           <?= $form->field($model, 'roId')->dropDownList($ro_name,['prompt'=>'Select RO Name'])->label('RO Name') ?> 
        </div>
        <div class="col-lg-4">
             <?= $form->field($model, 'firstName')->textInput(['maxlength' => true])->label('Surveyor Name') ?>
        </div>
        <div class="col-lg-4">
            <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="clearfix"></div>

        <?php if($model->isNewRecord){ ?>
        <div class="col-lg-4">
            <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>
        </div>
        <div class="col-lg-4">
           <?= $form->field($model, 'password_repeat')->passwordInput(['maxlength' => true]) ?> 
        </div>
        <?php } ?>
        <div class="col-lg-4">
            <?= $form->field($model, 'mobile')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="clearfix"></div>
        <div class="col-lg-4">
            <?= $form->field($model, 'stateId')->dropDownList($stateList,['prompt'=>'Select State']);?>
        </div>
        <div class="col-lg-4">
            <?= $form->field($model, 'cityId')->dropDownList($cityList,['prompt'=>'Select City'])->label('Surveyor City');?>
        </div>
        <div class="col-lg-4">
            <?= $form->field($model, 'active')->dropDownList($activeArray);?>
        </div>
        <div class="col-lg-4">
            <?= $form->field($model, 'joiningDate')->widget(DatePicker::classname(), [            
            'pluginOptions' => [
                'format' => 'dd/mm/yyyy',                 
                'autoclose' => true,
                'todayHighlight' => true
            ]
                        
                ]) ?>    
        </div>
        
    </div>
</div>
<div id="bank_details" class="panel panel-primary pb-15">
        <div class="panel-heading light-panel-heading pb-15">
            <h4 class="panel-title">Bank Account Details</h4>
        </div>

        <div class="panel-body">
         <div class="col-lg-4">
            <?= $form->field($model, 'bank_name')->textInput(['maxlength' => true]) ?>
        </div>
         <div class="col-lg-4">
            <?= $form->field($model, 'account_number')->textInput(['maxlength' => true]) ?>
        </div>
         <div class="col-lg-4">
            <?= $form->field($model, 'ifsc_code')->textInput(['maxlength' => true]) ?>
        </div>
         <div class="col-lg-4">
            <?= $form->field($model, 'branch_name')->textInput(['maxlength' => true]) ?>
        </div>
    </div></div>
    <div id="salary_details" class="panel panel-primary pb-15">
        <div class="panel-heading light-panel-heading pb-15">
            <h4 class="panel-title">Salary Details</h4>
        </div>

        <div class="panel-body">
        <div class="col-lg-4">
            <?= $form->field($model, 'salaryType')->dropDownList($salaryTypeArr,['prompt'=>'Select Salary Type']);?>
        </div>
        <div class="col-lg-4">
            <?= $form->field($model, 'conveyanceType')->dropDownList($conveyanceTypeArr,['prompt'=>'Select Conveyance Type']);?>
        </div>
        <div class="col-lg-4" id="user-basicsalary-sec">
            <?= $form->field($model, 'basicSalary')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-lg-4" id="user-feespercase-sec">
            <?= $form->field($model, 'feesPerCase')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-lg-4" id="user-conveyanceamount-sec">
            <?= $form->field($model, 'conveyanceAmount')->textInput(['maxlength' => true]) ?>
        </div>
         <div class="col-lg-4" id="user-conveyanceperkm-sec">
            <?= $form->field($model, 'conveyancePerKM')->textInput(['maxlength' => true]) ?>
        </div>
        </div>
    </div>
    
    
        <div class="col-md-12 form-group text-center">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
</div>

<?php $this->registerJs('
        $("#user-salarytype").on("change",function(){
            var type = $(this).val();
            if(type=="Fixed Salary"){
                $("#user-basicsalary-sec").show();
                $("#user-feespercase-sec").hide();
            } else if(type=="Variable Salary"){
                $("#user-basicsalary-sec").hide();
                $("#user-feespercase-sec").show();
            } else{
                $("#user-basicsalary-sec").hide();
                $("#user-feespercase-sec").hide();
            }
        });

        $("#user-conveyancetype").on("change",function(){
            var type = $(this).val();
            if(type=="Fixed Conveyance"){
                $("#user-conveyanceamount-sec").show();
                $("#user-conveyanceperkm-sec").hide();
            } else if(type=="Variable Conveyance"){
                $("#user-conveyanceamount-sec").hide();
                $("#user-conveyanceperkm-sec").show();
            } else{
                $("#user-conveyanceamount-sec").hide();
                $("#user-conveyanceperkm-sec").hide();
            }
        });


        $("#user-basicsalary-sec").hide();
         $("#user-feespercase-sec").hide();
         $("#user-conveyanceamount-sec").hide();
          $("#user-conveyanceperkm-sec").hide();

         var stype = $("#user-salarytype").val();
            if(stype=="Fixed Salary"){
                $("#user-basicsalary-sec").show();
                $("#user-feespercase-sec").hide();
            }
            if(stype=="Variable Salary"){
                $("#user-basicsalary-sec").hide();
                $("#user-feespercase-sec").show();
            }

            var type = $("#user-conveyancetype").val();
            if(type=="Fixed Conveyance"){
                $("#user-conveyanceamount-sec").show();
                $("#user-conveyanceperkm-sec").hide();
            }
            if(type=="Variable Conveyance"){
                $("#user-conveyanceamount-sec").hide();
                $("#user-conveyanceperkm-sec").show();
            }
    '); 
?>