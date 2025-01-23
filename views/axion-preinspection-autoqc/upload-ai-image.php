<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datecontrol\DateControl;
use yii\helpers\ArrayHelper;
use rmrevin\yii\fontawesome\FA;
use rmrevin\yii\fontawesome\FAS;
use rmrevin\yii\fontawesome\FAR;

/* @var $this yii\web\View */
/* @var $model app\models\AxionPreinspection */
/* @var $form yii\widgets\ActiveForm */

?>

<form id="uploadForm" enctype="multipart/form-data">
    <input type="file" id="imageInput" name="imageInput" accept="image/*">
    </br>
    <button type="button" onclick="uploadImage()">Upload Image</button>
    <a href="javascript:;" id="uploadImg">Upload</a>
</form>


<?php
$url = YII::$app->request->baseUrl . '/axion-preinspection/upload-ai-image';
$script = <<< JS

$(function () {
    $("#uploadImg").click(function(){
        alert('click');
        uploadImage();
    });
    function uploadImage() {
        alert('Load');
        var formData = new FormData();
        var fileInput = document.getElementById('imageInput');

        // Check if a file is selected
        if (fileInput.files.length > 0) {
            formData.append('image', fileInput.files[0]);

            // Make the AJAX request to upload the image
            $.ajax({
                type: 'POST',
                url: '$url', // Replace with the actual URL of your Yii action
                processData: false,
                contentType: false,
                data: formData,
                success: function (response) {
                    // Handle the response from the backend
                    console.log(response);
                },
                error: function (error) {
                    // Handle any errors
                    console.error(error);
                }
            });
        } else {
            alert('Please select an image.');
        }
    }
    
});
JS;
$this->registerJS($script);
?>


