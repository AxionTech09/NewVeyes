<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\MasterState;
use app\models\CompanyBillingDetails;
use yii\helpers\ArrayHelper;
use rmrevin\yii\fontawesome\FA;
use rmrevin\yii\fontawesome\FAS;
use rmrevin\yii\fontawesome\FAR;

/* @var $this yii\web\View */
/* @var $model app\models\PreinspectionClientCompany */
/* @var $form yii\widgets\ActiveForm */


$billTypes = $model->billTypes;
$companyStatus = $model->companyStatusArray;

$states = MasterState::find()->all();
$stateArr = ArrayHelper::map($states,'id','state');
?>

<div class="preinspection-client-company-form">

    <?php $form = ActiveForm::begin(); ?>
        <div id="company_details" class="panel panel-primary pb-15">
            <div class="panel-heading light-panel-heading pb-15">
                <h4 class="panel-title">Company Details</h4>
            </div>

            <div class="panel-body">
                <div class="col-sm-4 col-md-3 text-error">
                    <?= $form->field($model, 'companyName')->textInput() ?>
                </div>
                <div class="col-sm-4 col-md-3 text-error">
                    <?= $form->field($model, 'companyStatus')->dropDownList($companyStatus) ?>
                </div>
            </div>
        </div>

        <div id="billing_details" class="panel panel-primary pb-15">
            <div class="panel-heading light-panel-heading pb-15">
                <h4 class="panel-title">Billing Details</h4>
            </div>

            <div class="panel-body">
        
                <div class="col-sm-4 col-md-3 text-error">
                    <?= $form->field($model, 'billType')->dropDownList($billTypes,['prompt'=>'Select Bill Type']) ?>
                </div>
                <div class="col-sm-4 col-md-3">
                    <?= $form->field($model, 'stateId[]')->dropDownList($stateArr,['prompt'=>'All States','id'=>'stateId' ]) ?>
                </div>
          
                <div class="billSection" id="billSection">
                    <div class="col-sm-4 col-md-3 text-error">
                        <?= $form->field($model, "rate2Wheeler")->textInput() ?>
                    </div>
                    <div class="col-sm-4 col-md-3 text-error">
                        <?= $form->field($model, "rate3Wheeler")->textInput() ?>
                    </div>
                    <div class="col-sm-4 col-md-3 text-error">
                        <?= $form->field($model, "rate4Wheeler")->textInput() ?>
                    </div>
                    <div class="col-sm-4 col-md-3 text-error">
                        <?= $form->field($model, "rateCommercial")->textInput() ?>
                    </div>
                    <div class="col-sm-4 col-md-3 text-error">
                        <?= $form->field($model, "rateConveyance")->textInput() ?>
                    </div>
                    <div class="col-sm-4 col-md-3">
                        <?= $form->field($model, "gstNo")->textInput() ?>
                    </div>
                    <div class="col-sm-4 col-md-3">
                        <?= $form->field($model, "igst")->textInput() ?>
                    </div>
                    <div class="col-sm-4 col-md-3">
                        <?= $form->field($model, "sgst")->textInput() ?>
                    </div>
                    <div class="col-sm-4 col-md-3">
                    <?= $form->field($model, "cgst")->textInput() ?>
                    </div>
                    <div class="col-sm-4 col-md-3">
                        <?= $form->field($model, "billingAddress")->textArea(['rows' => 3]) ?>
                    </div>
                    <div class="col-sm-4 col-md-3 text-error">
                        <?= $form->field($model, "billingState")->dropDownList($stateArr,['prompt'=>'Select State']) ?>
                    </div>
                </div>

                <?php if ($stateArr) {
                    foreach ($stateArr as $key => $value) {

                        $result = (!$model->isNewRecord) ? CompanyBillingDetails::find()->where(['companyId' => $model->id,'stateId'=>$key])->one() : '';
                        if($result){
                            $model->stateArr[$key] = $result->stateId;
                            $model->rate2WheelerArr[$key] = $result->rate2Wheeler;
                            $model->rate3WheelerArr[$key] = $result->rate3Wheeler;
                            $model->rate4WheelerArr[$key] = $result->rate4Wheeler;
                            $model->rateCommercialArr[$key] = $result->rateCommercial;
                            $model->rateConveyanceArr[$key] = $result->rateConveyance;
                            $model->gstNoArr[$key] = $result->gstNo;
                            $model->igstArr[$key] = $result->igst;
                            $model->sgstArr[$key] = $result->sgst;
                            $model->cgstArr[$key] = $result->cgst;
                            $model->billingAddressArr[$key] = $result->address;
                            $model->billingStateArr[$key] = $result->billingState;
                        } ?>

                        <div id="billSection<?= $key ?>" class="billSection">
                            <?= $form->field($model, "stateArr[$key]")->hiddenInput(['id'=>"stateArr$key"])->label(false) ?>

                            <div class="col-sm-4 col-md-3">
                                <?= $form->field($model, "rate2WheelerArr[$key]")->textInput() ?>
                            </div>
                            <div class="col-sm-4 col-md-3">
                                <?= $form->field($model, "rate3WheelerArr[$key]")->textInput() ?>
                            </div>
                            <div class="col-sm-4 col-md-3">
                                <?= $form->field($model, "rate4WheelerArr[$key]")->textInput() ?>
                            </div>
                            <div class="col-sm-4 col-md-3">
                                <?= $form->field($model, "rateCommercialArr[$key]")->textInput() ?>
                            </div>
                            <div class="col-sm-4 col-md-3">
                                <?= $form->field($model, "rateConveyanceArr[$key]")->textInput() ?>
                            </div>
                            <div class="col-sm-4 col-md-3">
                                <?= $form->field($model, "gstNoArr[$key]")->textInput() ?>
                            </div>
                            <div class="col-sm-4 col-md-3">
                                <?= $form->field($model, "igstArr[$key]")->textInput() ?>
                            </div>
                            <div class="col-sm-4 col-md-3">
                                <?= $form->field($model, "sgstArr[$key]")->textInput() ?>
                            </div>
                            <div class="col-sm-4 col-md-3">
                            <?= $form->field($model, "cgstArr[$key]")->textInput() ?>
                            </div>
                            <div class="col-sm-4 col-md-3">
                                <?= $form->field($model, "billingAddressArr[$key]")->textArea(['rows' => 3]) ?>
                            </div>
                            <div class="col-sm-4 col-md-3">
                                <?= $form->field($model, "billingStateArr[$key]")->dropDownList($stateArr,['prompt'=>'Select State']) ?>
                            </div>
                        </div>
              <?php } 
                }
              ?>
            </div>
        </div>

        <div class="col-md-12 form-group text-center">
            <?= Html::submitButton($model->isNewRecord ? FA::icon('plus-circle', ['class' => 'mr-3 mt-5 text-white']).' Create' : FA::icon('edit', ['class' => 'mr-3 mt-5 text-white']).' Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div>

<style type="text/css">
    form div.required label.control-label:after {
        content:" *";
    }
</style>

<?php

$this->registerJs(
    "$('body').on('change', '#stateId', function() {
        var stateId = ($(this).val());
            showBillSection();
        });
        showBillSection();
''    ");
?>

<script type="text/javascript">
    function showBillSection(stateId=false){
        var stateId = (stateId) ? stateId : $("#stateId").val();
        if(stateId!=""){
            $("#stateArr"+stateId).val(stateId);
        }
        $(".billSection").hide();
        $("#billSection"+stateId).show();

    }
</script>