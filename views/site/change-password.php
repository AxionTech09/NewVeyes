<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $model app\models\Preinspection */

$this->title = 'Change Password';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="userdata-create">
   <h1 class="botitle"><?= Html::encode($this->title) ?></h1>
   <div class="userdata-form ">
    <div class="row userform">
      <?php $form = ActiveForm::begin(['id'=>$model->formName(),'enableAjaxValidation'=>false]); 

      ?>
      <div class="col-lg-4 input-icons">
         <?php $temp = ['template' => '{label}{input}<i class="glyphicon glyphicon-eye-open icon" id="showPassword"></i>
         <i class="glyphicon glyphicon-eye-close icon icon-open" style="display:none" id="hidePassword"></i>{error}'];

         echo $form->field($model, 'password',$temp)->passwordInput(['maxlength' => true,'class'=>'input-field form-input','id'=>'input-field']) ?>
      </div>
      <div class="clearfix"></div>

      <div class="col-lg-4 input-icons">
         <?php $temp_new = ['template' => '{label}{input}<i class="glyphicon glyphicon-eye-open icon-new"id="showPasswordNew" ></i><i class="glyphicon glyphicon-eye-close icon-new icon-open-new" style="display:none" id="hidePasswordNew"></i>{error}'];

         echo $form->field($model, 'password_repeat',$temp_new)->passwordInput(['maxlength' => true,'class'=>'input-field-new form-input','id'=>'input-field-new']) ?>         

      </div>

      <div class="clearfix"></div>
      <div class="col-lg-4">
         <?= Html::submitButton('Save', ['class' => 'btn btn-success btnSubmit']) ?>
      </div>
   </div>

   <?php ActiveForm::end(); ?>
</div>
</div>
<style>
form i {
  margin-left: -30px;
  cursor: pointer;
}
.form-input{
   width: 50%;
   padding: 10px;
}
.input-field {
   margin-left: 60px;
}
.input-field-new {
   margin-left: 10px;
}
.input-icons {
  width: 50%;
  margin-bottom: 5px;
  margin-top: 10px;
}
.btnSubmit{
   margin-bottom: 10px;
}

</style>

<?php $this->registerJs('
  const password = document.querySelector("#input-field");
  const passwordNew = document.querySelector("#input-field-new");
  $("#showPassword").on("click",function(){     
   password.setAttribute("type", "text");
   $("#showPassword").hide();
   $("#hidePassword").show();
   });
   $("#hidePassword").on("click",function(){
      password.setAttribute("type", "password");
      $("#showPassword").show();
      $("#hidePassword").hide();
      });

      $("#showPasswordNew").on("click",function(){     
         passwordNew.setAttribute("type", "text");
         $("#showPasswordNew").hide();
         $("#hidePasswordNew").show();
         });
         $("#hidePasswordNew").on("click",function(){
            passwordNew.setAttribute("type", "password");
            $("#showPasswordNew").show();
            $("#hidePasswordNew").hide();
            });

            '); ?>

