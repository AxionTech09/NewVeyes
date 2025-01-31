<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Userdata */
/* @var $form yii\widgets\ActiveForm */
$staffData=ArrayHelper::map($staff,'id','name');

$assign_staff_display = "none";
if(!$model->isNewRecord && $model->type === 'Valuator')
{
   $assign_staff_display = "block"; 
}

?>

<div class="userdata-form">

    <?php $form = ActiveForm::begin(['id'=>$model->formName(),'enableAjaxValidation'=>true,]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'type')->dropDownList(['Staff'=>'Staff','Valuator'=>'Valuator','Surveyor'=>'Surveyor','Admin'=>'Admin'],['id'=>'valuator_staff']    // options
        );
 ?>
    <div id="assign_staff_display" style="display: <?php echo $assign_staff_display; ?>">
     <?= $form->field($model, 'valuator_staff')->dropDownList($staffData,['prompt'=>'Select']);?>
    </div>
    
    <?= $form->field($model, 'mobile')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php $this->registerJs(
      "$('#valuator_staff').change(function () {
         var selected = $('#valuator_staff').find('option:selected').val();
         if(selected == 'Valuator')
         {
            $('#assign_staff_display').show(); 
         }
         else
         {
            $('#assign_staff_display').hide();  
         }
      });
          "
    ); ?>