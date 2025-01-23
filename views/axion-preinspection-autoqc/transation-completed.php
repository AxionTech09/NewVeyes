<?php
/* @var $this yii\web\View */
/* @var $premodel app\models\AxionPreinspection */
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$pdfUrl = Yii::$app->request->baseUrl . '/axion-preinspection/vehicleqcpdf?id=' . $premodel->id;
$url = YII::$app->request->baseUrl . '/axion-preinspection/mail-send-function?id=' . $premodel->id;
?>


<div id="Transaction_Completed" class="panel panel-primary pb-15 mt-80">
  <!-- <div class="panel-heading light-panel-heading pb-15">
    <h4 class="panel-title">TRANSACTION COMPLETED</h4>
  </div> -->
  
  <?php $form = ActiveForm::begin(); ?>
  <table class="table table-bordered" style="width: 100%; table-layout: fixed;">
    <tr>
        <td class="col-sm-2" style="padding: 10px; vertical-align: middle;">
            <?= $form->field($premodel, 'registrationNo', [
                'template' => "<div style='display: flex; align-items: center;'>{label}{input}</div>\n{hint}\n{error}"
            ])->textInput([
                'readonly' => $premodel->isNewRecord ? false : true,
                'maxlength' => true,
                'style' => 'margin-left: 10px; flex: 1;'
            ])->label('Vehicle No', ['style' => 'flex: 1;']) ?>
        </td>
    </tr>
    <tr>
        <td class="col-sm-2" style="padding: 10px; vertical-align: middle;">
            <?= $form->field($premodel, 'insuredName', [
                'template' => "<div style='display: flex; align-items: center;'>{label}{input}</div>\n{hint}\n{error}"
            ])->textInput([
                'readonly' => $premodel->isNewRecord ? false : true,
                'maxlength' => true,
                'style' => 'margin-left: 10px; flex: 1;'
            ])->label('Rc Owner Name', ['style' => 'flex: 1;']) ?>
        </td>
    </tr>
    <tr>
        <td class="col-sm-2" style="padding: 10px; vertical-align: middle;">
            <?= $form->field($premodel, 'status', [
                'template' => "<div style='display: flex; align-items: center;'>{label}{input}</div>\n{hint}\n{error}"
            ])->textInput([
                'readonly' => true,
                'maxlength' => true,
                'value' => $statusLabel, 
                'style' => 'margin-left: 10px; flex: 1;'
            ])->label('Inspection Status', ['style' => 'flex: 1;']) ?>
        </td>
    </tr>
    <tr>
    <td class="col-sm-2" style="padding: 10px; vertical-align: middle;">
    <!-- Container for Download Report label and button -->
    <div style="display: flex; align-items: center; position: relative;">
        <span style="margin-right: auto;">Download Report</span>
        <div style="position: absolute; left: 60%; transform: translateX(-40%);">
            <a id="downloadPdf" target="_BLANK" href="./vehicleqcpdf?id=<?= $premodel->id; ?>" style="padding: 5px 10px; background-color: #007BFF; color: white; text-decoration: none; border-radius: 5px; text-align: center;">
                  Download 
            </a>
        </div>
    </div>
</td>

</tr>
</table>

  <?php ActiveForm::end(); ?>
<div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>   
<script>
  document.addEventListener('DOMContentLoaded', function () { 
    
    var downloadButton = document.querySelector('.download-pdf');
    if (downloadButton) {       
        downloadButton.href = '<?= $pdfUrl ?>';    
        alert($pdfUrl) ;
        downloadButton.addEventListener('click', function (event) {          
            if ('<?= $premodel->status ?>' !== 'Completed') {          
              event.preventDefault();               
              alert('The PDF cannot be downloaded unless the inspection status is "Completed".');
            }
        });
    }
 } );

</script>