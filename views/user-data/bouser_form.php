<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\datecontrol\DateControl;
use rmrevin\yii\fontawesome\FA;
use rmrevin\yii\fontawesome\FAS;
use rmrevin\yii\fontawesome\FAR;

/* @var $this yii\web\View */
/* @var $model app\models\Userdata */
/* @var $form yii\widgets\ActiveForm */

$activeList= [
  ['id' => 'Y', 'name' => 'Y'],
  ['id' => 'N', 'name' => 'N'],
];

$accessList= [
    ['id' => '', 'name' => 'Select'],
    ['id' => 'Y', 'name' => 'Y'],
    ['id' => 'N', 'name' => 'N'],
  ];

$zoneArray = $model->zoneList;
$activeArray = ArrayHelper::map($activeList, 'id', 'name');
$accessArray = ArrayHelper::map($accessList, 'id', 'name');
$stateList = ArrayHelper::map($state, 'id', 'state');
$cityList =ArrayHelper::map($city,'id','city');
$compArray = ArrayHelper::map($companiesInfo,'id','companyName');
?>
 <div class="userdata-form ">
        
    <?php $form = ActiveForm::begin(['id'=>$model->formName(),'enableAjaxValidation'=>true,]); ?>

        <div id="ro_details" class="panel panel-primary pb-15">
            <div class="panel-heading light-panel-heading pb-15">
                <h4 class="panel-title">RO Details</h4>
            </div>

            <div class="panel-body">

                <div class="col-sm-4 col-md-3">
                    <?= $form->field($model, 'firstName')->textInput(['maxlength' => true])->label('RO Name') ?>
                </div>
                <div class="col-sm-4 col-md-3">
                    <?= $form->field($model, 'ownerName')->textInput(['maxlength' => true])->label('Owner Name') ?>
                </div>
                <div class="col-sm-4 col-md-3">
                    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>  
                </div>
                
                <div class="col-sm-4 col-md-3">
                    <?php if($model->isNewRecord){ ?>
                        <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>
                    </div>
                    <div class="col-sm-4 col-md-3">
                        <?= $form->field($model, 'password_repeat')->passwordInput(['maxlength' => true]) ?>
                    <?php } ?> 
                </div>
                
                <div class="col-sm-4 col-md-3">
                    <?= $form->field($model, 'mobile')->textInput(['maxlength' => true]) ?>
                </div>

                <div  class="col-sm-4 col-md-3">
                    <?= $form->field($model, 'pan_number')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-sm-4 col-md-3">
                    <?= $form->field($model, 'gst_number')->textInput(['maxlength' => true]) ?>
                </div>
            
                <div class="col-sm-4 col-md-3">
                    <?= $form->field($model, 'stateId')->dropDownList($stateList,['prompt'=>'Select State']);?>
                </div>

                <div class="col-sm-4 col-md-3">
                    <?= $form->field($model, 'zone')->dropDownList($zoneArray);?>
                </div>

                <div class="col-sm-4 col-md-3">
                    <?= $form->field($model, 'cityId')->dropDownList($cityList,['prompt'=>'Select City']);?>
                </div>
                <div class="col-sm-4 col-md-3">
                    <?= $form->field($model, 'active')->dropDownList($activeArray);?>
                </div>

                <div class="col-sm-4 col-md-3">
                    <?php echo $form->field($model, 'activeFromDate')->widget(DateControl::classname(), [
                'type'=>DateControl::FORMAT_DATE,  'options' => [
                        'pluginOptions' => [
                            'autoclose' => true
                                ]
                            ]
                    ]); ?>
                </div>

                <div class="col-sm-4 col-md-3">
                    <?= $form->field($model, 'royaltyOnFees')->textInput(['type'=>'number']) ?>
                </div>
                
                <div class="col-sm-4 col-md-3">
                    <?= $form->field($model, 'royaltyOnConveyance')->textInput(['type'=>'number']) ?>
                </div>
                
                <div class="col-sm-4 col-md-3">
                    <?= $form->field($model, 'roCompletedCase')->textInput(['type'=>'number']) ?>
                </div>
                
                <div class="col-sm-4 col-md-3">
                    <?= $form->field($model, 'address')->textarea(['rows' => '1']) ?>
                </div>

                <div class="col-sm-4 col-md-3">
                    <?= $form->field($model, 'create_access')->dropDownList($accessArray);?>
                </div>

                <div class="col-sm-4 col-md-3">
                    <?= $form->field($model, 'qc_access')->dropDownList($accessArray);?>
                </div>
            </div>
        </div>
        

        <div id="ro_details" class="panel panel-primary pb-15">
            <div class="panel-heading light-panel-heading pb-15">
                <h4 class="panel-title">Bank Account Details</h4>
            </div>

            <div class="panel-body">
    
                <div class="col-sm-4 col-md-3">  
                    <?= $form->field($model, 'bank_name')->textInput() ?>
                </div>
                <div class="col-sm-4 col-md-3">
                    <?= $form->field($model, 'account_number')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-sm-4 col-md-3">
                    <?= $form->field($model, 'ifsc_code')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-sm-4 col-md-3">
                    <?= $form->field($model, 'branch_name')->textInput(['maxlength' => true]) ?>
                </div>
            </div>            
        </div>

        <?php if($rousers > 1 || $model->isNewRecord){ 
            
            $hide = $model->isNewRecord ? 'd-none' : '';

            ?>
            
            <div id="ro_case_assignment" class="panel panel-primary pb-15 <?php echo $hide;?>">
                <div class="panel-heading light-panel-heading pb-15">
                    <h4 class="panel-title">RO Case Assignment</h4>
                </div>

                <div class="panel-body">    
                    <div class="col-sm-4">  
                        <?= $form->field($rocaseassign, 'companyId')->dropDownList($compArray,['prompt'=>'Select Company']) ?>
                    </div>
                    <div class="col-sm-4">
                        <?= $form->field($rocaseassign, 'caseCnt')->textInput(['maxlength' => true]) ?>
                    </div>
                </div>            
            </div>
        <?php } ?>

        <div class="col-md-12 form-group text-center">
            <?= Html::submitButton($model->isNewRecord ? FA::icon('plus-circle', ['class' => 'mr-3 mt-5 text-white']).' Create' : FA::icon('edit', ['class' => 'mr-3 mt-5 text-white']).' Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

    <?php ActiveForm::end(); ?>
</div>


<?php
$url = Yii::$app->urlManager->createUrl('user-data/load-rocase-info');
$showurl = Yii::$app->urlManager->createUrl('user-data/show-rocase');
$userId = Yii::$app->getRequest()->getQueryParam('id');
$newRecord = $model->isNewRecord ? 'Y':'N';
$script = <<< JS
// alert('$url'+'comp_id=$compId&state_id=1');
$('#rocaseassignment-companyid').change(function(){
    let companyId = $(this).val();
    let stateId = $('#user-stateid').val();
    let url = '$url';
    // alert(companyId+' ~~ '+stateId+' ~~ $userId');
    // return false;
    $.ajax({
    url: url,
    type: 'POST',
        data: { 'companyId': companyId, 'stateId':stateId, 'userId':'$userId'},
        success: function(data) {
            if(data.caseCnt != null){
                $('#rocaseassignment-casecnt').val(data.caseCnt);
            }else{
                $('#rocaseassignment-casecnt').val('');
            }
        }
    });
});

if('$newRecord' == 'Y'){
    $('#user-stateid').change(function(){
        let stateId = $(this).val();
        let url = '$showurl';
        alert(stateId);
        $.ajax({
        url: url,
        type: 'POST',
            data: {'stateId':stateId},
            success: function(data) {
                alert(data.roCnt);
                if(data.roCnt > 1){
                    $('#ro_case_assignment').removeClass('d-none');
                    $('#rocaseassignment-casecnt').removeClass('d-none');                    
                }else{
                    $('#ro_case_assignment').addClass('d-none');
                    $('#rocaseassignment-companyid').val('');                    
                    $('#rocaseassignment-casecnt').val(''); 
                }
            }
        });
    }); 
}
JS;
$this->registerJS($script);

$style = <<< CSS

.d-none{
    display:none;
}

CSS;
$this->registerCss($style);
?>