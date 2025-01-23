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

<div class="container" style="max-width: 1100px;">
    <div id="message"></div>
    <div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Select CSV File</h3>
    </div>
    <div class="panel-body" style="max-width: 1100px;overflow:auto;position: relative">
        <div class="row" id="upload_area">
        <form method="post" id="upload_form" enctype="multipart/form-data">
            <div class="col-md-6" align="right">Select File</div>
            <div class="col-md-6">
            <input type="file" name="file" id="csv_file" />
            </div>
            <br /><br /><br />
            <div class="col-md-12" align="center">
                <input type="submit" name="upload_file" id="upload_file" class="btn btn-primary" value="Upload" />
            </div>
        </form>
        
        </div>
        <div class="table-responsive" id="process_area">

        </div>
    </div>
    </div>
</div>


<?php
$url = YII::$app->request->baseUrl . '/axion-preinspection/upload-csv';
$saveurl = YII::$app->request->baseUrl . '/axion-preinspection/save-csv';
$script = <<< JS

$(function () {
    
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

    // csv functions

    $('#upload_form').on('submit', function(event){
        event.preventDefault();
        $.ajax({
            url:"$url",
            method:"POST",
            data:new FormData(this),
            dataType:'json',
            contentType:false,
            cache:false,
            processData:false,
            success:function(data)
            {
                if(data.error != '')
                {
                $('#message').html('<div class="alert alert-danger">'+data.error+'</div>');
                }
                else
                {
                $('#process_area').html(data.output);
                $('#upload_area').css('display', 'none');
                }
            }
        });
    });

    var total_selection = 0;

    var sno;
    var part_type;
    var part_code;
    var part_name;
    var spare_parts_allowed;
    var quantity;
    var rate;
    var billed_amount;
    var assessed_amount;
    var tax;
    var column_data = [];

    $(document).on('change', '.set_column_data', function(){

        var column_name = $(this).val();

        var column_number = $(this).data('column_number');

        if(column_name in column_data)
        {
        alert('You have already define '+column_name+ ' column');

        $(this).val('');

        return false;
        }

        if(column_name != '')
        {       
            var objectLength = Object.keys(column_data).length;
            console.log(objectLength);
            if(objectLength == 0){
                column_data[column_name] = column_number;
            }else{
                for (var key in column_data) {
                    if(column_data[key] == column_number){
                        delete column_data[key]; 
                        column_data[column_name] = column_number;
                    }else{
                        column_data[column_name] = column_number;
                    }
                }
            }

        }
        else
        {
            const entries = Object.entries(column_data);
            for(const [key, value] of entries)
            {
                if(value == column_number)
                {
                delete column_data[key];
                }
            }
        }

        // Convert object to array of key-value pairs
        var keyValueArray = Object.entries(column_data);

        // Sort the array by values in ascending order
        keyValueArray.sort(function(a, b) {
            return a[1] - b[1];
        });

        // Convert the sorted array back to an object
        var sortedObject = {};
        keyValueArray.forEach(function(item) {
            sortedObject[item[0]] = item[1];
        });

        console.log(sortedObject);

        total_selection = Object.keys(column_data).length;

        if(total_selection >= 1)
        {
        $('#import').attr('disabled', false);
            sno = column_data.sno;
            part_type = column_data.part_type;
            part_code = column_data.part_code;
            part_name = column_data.part_name;
            spare_parts_allowed = column_data.spare_parts_allowed;
            quantity = column_data.quantity;
            rate = column_data.rate;
            billed_amount = column_data.billed_amount;
            assessed_amount = column_data.assessed_amount;
            tax = column_data.tax;
        }
        else
        {
        $('#import').attr('disabled', 'disabled');
        }
        console.log(column_data);
    });

    $(document).on('click', '#import', function(event){

        var tabledata = [];

        // Iterate through each table row
        $('#csv_table tr').each(function() {
            var row_data = [];

            // Iterate through each cell in the row and retrieve the input values
            $(this).find('input').each(function() { // input
                row_data.push($(this).val());
            });

            // Push the row data into the main data array
            tabledata.push(row_data);
        });

        // At this point, 'data' contains all the values from the input fields in array format
        console.log(tabledata);

        event.preventDefault();

        var columnOrder = {
            'Sno':sno,
            'Part Type':part_type,
            'Part Code':part_code,
            'Part Name':part_name,
            'Spare Parts Allowed':spare_parts_allowed,
            'Quantity':quantity,
            'Rate':rate,
            'Billed Amount':billed_amount,
            'Assessed Amount':assessed_amount,
            'Tax':tax
        }
            

        $.ajax({
        url:"$saveurl",
        method:"POST",
        data:{columnOrder,tabledata},
        beforeSend:function(){
            $('#import').attr('disabled', 'disabled');
            $('#import').text('Importing...');
        },
        success:function(data)
        {
            $('#import').attr('disabled', false);
            $('#import').text('Import');
            // $('#process_area').css('display', 'none');
            // $('#upload_area').css('display', 'block');
            $('#upload_form')[0].reset();
            $('#message').html("<div class='alert alert-success'>"+data+"</div>");
        }
        })

    });

    $(document).on('click', '.remove_row',function(event){
        console.log($(this).attr('data-rowid'));
        var rowId = $(this).attr('data-rowid');
        var result = confirm("Are you sure you want to delete this row?");
        if(result) {
            $('.row_'+rowId).remove();
            alert("Row deleted.");
            // Add your code for OK action here
        }
    });
    
});
JS;
$this->registerJS($script);
?>


