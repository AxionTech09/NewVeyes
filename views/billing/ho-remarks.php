<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Remarks';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="remarks-index">

    <!--h1><?= Html::encode($this->title) ?></h1-->

   <?php

    Pjax::begin(['id' => 'pjax-remarks-form']);

    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'id' => 'remarksGrid',
        'layout' => '{items}',
        'columns' => [
            [
                'class' => 'yii\grid\SerialColumn',
                'headerOptions'=>['style'=>'width:2%'],
            ],
            [
                'attribute' => 'hoBillId',
                'label' => 'Ho Bill Number',
                'headerOptions'=>['style'=>'width:2%'],
                'value' => 'hoBill.hoBillNumber'
            ],
            [
                'attribute' => 'hoBillId',
                'label' =>'Bill Number',
                'headerOptions'=>['style'=>'width:3%'],
                'value' => 'hoBill.bill.billNumber'
            ],
            [
                'attribute' => 'remarks',
                'headerOptions'=>['style'=>'width:9%'],
                'value' => 'remarks'
            ],
            [
                'attribute' => 'createdOn',
                'headerOptions'=>['style'=>'width:3%'],
                'value' => function($model){
                    return date('Y-m-d h:i A',strtotime($model->createdOn));
                }
            ],
            //['class' => 'yii\grid\ActionColumn'],
        ],
    ]); 

    Pjax::end();

    ?>
</div>
    <div class="clearfix"></div>
<div class="preinspection-form">
    <?php $form = ActiveForm::begin(['action'=>'#','id'=>'remarks-form']); ?>

    <?= $form->field($model, 'hoBillId')->hiddenInput(['style'=>'width:500px','id'=>'hoBillId','value'=>$hoBillId])->label(false) ?>

<div class="col-sm-12" style="margin-top: 30px;">
    <div class="col-md-8">
    <?= $form->field($model, 'remarks')->textArea(['id'=>'remarks','rows'=>5,'placeholder'=> 'Enter the remarks'])->label(false) ?>
     <?= Html::submitButton('Add Remarks', ['class' =>'btn btn-success','id'=>'submitButton']) ?>
</div>

</div>
    <?php ActiveForm::end(); ?>

</div>
<?php

$url = Yii::$app->request->baseUrl.'/billing/add-ho-remarks';
$hoUrl = Yii::$app->request->baseUrl.'/billing/ho-bill-list';
$script = <<< JS
$('#remarks-form').on('beforeSubmit', function(e) 
{    
        var remarks = $('#remarks').val();      
        if(remarks =='')
        {
            alert("Please enter Remarks");
            return false;
        }
        
        var form = $(this);
        var formData = form.serialize();
        $.ajax({
            url: "$url",
            type: form.attr("method"),
            data: formData,
            beforeSend: function() {
                 $("#loading-image").show();
              },
            success: function (data) {                
                   if(data != '')
                   {
                      var res = $.parseJSON(data)
                      if(res.status != 'success')
                      {
                        alert("Create Failed");
                        window.location.href = "./";
                      }
                      else{
                        alert("Remarks Created Succesfully");
                        $(form).trigger("reset");
                        $('#remarksGrid').yiiGridView('applyFilter');
                        $("#loading-image").hide();
                        //$.pjax({container: '#pjax-remarks-form'})
                        //location.reload();
                      }
                    }
            },
            error: function (jqXHR, exception) {
                //alert("Something went wrong");
                alert(jqXHR.responseText);
            }
        });
}).on('submit', function(e){
    e.preventDefault();
});

$('#comment-modal').on('hidden.bs.modal', function () {
        location.href = '$hoUrl'; 
});

JS;
$this->registerJS($script);
?>


