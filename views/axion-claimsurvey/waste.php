    <!-- <script src="//code.jquery.com/jquery-1.11.1.min.js"></script> -->
     <div id="inspection_photos" class="preinspection-box" style="margin-bottom: 30px">
    <table id="myTable" class=" table order-list">
        <div class="row">
           <h4 class="preinspection-box-title">Assessment</h4> 
<tr>
    <th>Parts</th>
    <th>Type</th>
    <th>Amount</th>
    <th>Assessed</th>
    <th>Remove</th>
</tr>
        <tr>
            <td class="col-sm-3">
                <input type="text" name="part" class="form-control" />
            </td>
            <td class="col-sm-2">
              <input type="text" name="type"  class="form-control"/>
              
            </td>
             <td class="col-sm-2">
                <input type="text" name="amount"  class="form-control"/>
            </td>
             <td class="col-sm-2">
                <input type="text" name="assessment"  class="form-control"/>
            </td>
          
            <td class="col-sm-3"><a class="deleteRow"></a>

            </td>
        </tr>
    <tfoot>
        <tr>
            <td colspan="" style="text-align: left;">
                <input type="button" class="btn btn-success" id="addrow" value="Add" />
            </td>
        </tr>
     
    </tfoot>

</div></table>
</div>
<?php
$script = <<< JS
   $(document).ready(function () {
    var counter = 0;

    $("#addrow").on("click", function () {
        var newRow = $("<tr>");
        var cols = "";

        cols += '<td><input type="text" class="form-control" name="assessment' + counter + '"/></td>';
        cols += '<td><input type="text" class="form-control" name="type' + counter + '"/></td>';
        cols += '<td><input type="text" class="form-control" name="amount' + counter + '"/></td>';
        cols += '<td><input type="text" class="form-control" name="assessed' + counter + '"/></td>';

        cols += '<td><input type="button" class="ibtnDel btn btn-md btn-danger "  value="Delete"></td>';
        newRow.append(cols);
        $("table.order-list").append(newRow);
        counter++;
    });



    $("table.order-list").on("click", ".ibtnDel", function (event) {
        $(this).closest("tr").remove();       
        counter -= 1
    });


});



function calculateRow(row) {
    var price = +row.find('input[name^="price"]').val();

}

function calculateGrandTotal() {
    var grandTotal = 0;
    $("table.order-list").find('input[name^="price"]').each(function () {
        grandTotal += +$(this).val();
    });
    $("#grandtotal").text(grandTotal.toFixed(2));
}


JS;
$this->registerJS($script);
?>


<td class="col-sm-2">
                 <?= $form->field($assests, 'parts')->textInput(['maxlength' => true]) ?>
                </td>
                <td class="col-sm-2">
                 <?= $form->field($assests, 'partsNo')->textInput() ?>
                </td>
                <td class="col-sm-2">
                 <?= $form->field($assests, 'type')->textInput(['maxlength' => true]) ?> 
                </td>
                <td class="col-sm-2">
                 <?= $form->field($assests, 'estimateAmount')->textInput() ?>
                </td>
                <td class="col-sm-2">
                 <?= $form->field($assests, 'assessment')->textInput() ?>
                </td>



<?php

$request = new HttpRequest();
$request->setUrl('http://tataaiguat.vahancheck.com/VCWebAPI/api/ExternalAgencyReport/Post');
$request->setMethod(HTTP_METH_POST);

$request->setHeaders(array(
  'postman-token' => 'a80bf1bd-add9-6d71-a297-8575b5a6f8db',
  'cache-control' => 'no-cache',
  'content-type' => 'multipart/form-data; boundary=----WebKitFormBoundary7MA4YWxkTrZu0gW',
  'authorization' => 'Basic PuwoFFOP+Zr2wtaTjv9KnQ=='
));

$request->setBody($postFields);

try {
  $response = $request->send();

  echo $response->getBody();
} catch (HttpException $ex) {
  echo $ex;
}


<?php

$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => "http://tataaiguat.vahancheck.com/VCWebAPI/api/ExternalAgencyReport/Post",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS =>
   "------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"leadID\"\r\n\r\n849746\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"vehicleRegistrationNo\"\r\n\r\nMH09AD0909\r\n
   ------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"qcStatus\"\r\n\r\nApproved\r\n
   ------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"zipArray\"; filename=\"1011-images-pdf.zip\"\r\nContent-Type: application/zip\r\n\r\n
   ------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"userID\"\r\n\r\naxion\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"remark\"\r\n\r\ntest  data\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW--",
  CURLOPT_HTTPHEADER => array(
    "authorization: Basic PuwoFFOP+Zr2wtaTjv9KnQ==",
    "cache-control: no-cache",
    "content-type: multipart/form-data; boundary=----WebKitFormBoundary7MA4YWxkTrZu0gW",
    "postman-token: a1ef4a35-a150-9b1d-ff44-6a6666d39f94"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  echo $response;
}


?>
<div class="receipt-form">

    <?php $form = ActiveForm::begin([
        'enableClientValidation' => false
    ]); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => 255]) ?>
    <?= "<h2>Details</h2>"?>

    <?php foreach ($modelDetails as $i => $modelDetail) : ?>
        <div class="row receipt-detail receipt-detail-<?= $i ?>">
            <div class="col-md-10">
                <?= Html::activeHiddenInput($modelDetail, "[$i]id") ?>
                <?= Html::activeHiddenInput($modelDetail, "[$i]updateType", ['class' => 'update-type']) ?>
                <?= $form->field($modelDetail, "[$i]item_name") ?>
            </div>
            <div class="col-md-2">
                <?= Html::button('x', ['class' => 'delete-button btn btn-danger', 'data-target' => "receipt-detail-$i"]) ?>
            </div>
        </div>
    <?php endforeach; ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::submitButton('Add row', ['name' => 'addRow', 'value' => 'true', 'class' => 'btn btn-info']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php


$targetDir = "uploads/";
$fileName = basename($_FILES["file"]["name"]);
$targetFilePath = $targetDir . $fileName;
$fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);

if(isset($_POST["submit"]) && !empty($_FILES["file"]["name"])){
    // Allow certain file formats

    if(in_array($fileType)){
        // Upload file to server
        if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)){
            // Insert image file name into database
            $insert = $db->query("INSERT into images (file_name, uploaded_on) VALUES ('".$fileName."', NOW())");
            if($insert){
                $statusMsg = "The file ".$fileName. " has been uploaded successfully.";
            }else{
                $statusMsg = "File upload failed, please try again.";
            } 
        }else{
            $statusMsg = "Sorry, there was an error uploading your file.";
        }
    }else{
        $statusMsg = 'Sorry, only JPG, JPEG, PNG, GIF, & PDF files are allowed to upload.';
    }
}else{
    $statusMsg = 'Please select a file to upload.';
}






<!DOCTYPE html>
<html>

<head>
    <title>Status  Report</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/bootstrap.min.css">
 
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  </head>
<body>
  <h2 style="text-align: center">Status</h2>
<div class="container">
  <form  enctype="multipart/form-data" method="post">

 <div class="form-group">
          <label>Lead No</label>
            <input type="text" class="form-control"  name="LeadNo" value="849747">
          </div>
          <div class="form-group">
            <label>Vehicle Number</label>
            <input type="text" class="form-control" name="reg" value="MH09AD0910" >
          </div>
          <div class="form-group">
            <label>Customer Name</label>
            <input type="text" class="form-control" name="user" value="axion">
          </div>
        
          <div class="form-group">
            <label >status</label>
            <input type="text" class="form-control" name="status"  value="Approved">
          </div>
          <div class="form-group">
            <label >zip file</label>
            <input type="file"  class="form-control" name="file_upl"/>
          </div>
 
          <div class="form-group">
            <label >Remark</label>
            <input type="text" class="form-control" name="remark" value="good" >
          </div>

<input type="submit" name="submit" value="submit"/>
</form>
</div>
</body>

</html>

<?php

// curl "http://tataaiguat.vahancheck.com/VCWebAPI/api/ExternalAgencyReport/Post" 
//  -X POST
//  -d {"_arcMeta":{"textParts":["leadID","vehicleRegistrationNo","qcStatus","userID","remark"]}} \
//  -H "Authorization: Basic PuwoFFOP+Zr2wtaTjv9KnQ==" \
//  -H "Content-Type: multipart/form-data; boundary=--------------------------025166953278401615980615" \
//  -H "content-length: 5822730" 



    echo "<pre>";
    
    error_reporting(9);
    
    


if (isset($_POST['submit'] ) ){
// extract($_POST);


        $id = $_POST['LeadNo'];

        $v = $_POST['reg'];
        $status = $_POST['status'];
        // $filePath = $_FILES['file_upl']['tmp_name'][0];
        $filePath = $_FILES['file'];
        // $filePath = realpath(basename($_FILES['file_upl']['tmp_name']));
        // $target_file = 'https://axionpcs.in/test/api-uploads/13-images-pdf.zip';
        // $extractResponse = openZip($target_file);
        $extractResponseArray = json_decode($filePath, true);


        // $fileName = $_FILES['file_upl']['name'];

        // $file = var_dump($filePath . $fileName);
        // print_r($file);

        // $data_string = var_dump($fileName);

        $user = $_POST['user'];
        $remark = $_POST['remark'];
        
        $postFields = array();

        $postFields["leadID"] = "$id";
        $postFields["vehicleRegistrationNo"] = "$v";
        $postFields["qcStatus"] = "$status";
        $postFields["zipArray"] = [@$extractResponseArray];
        $postFields["pdfArray1"] = [];
        $postFields["pdfArray2"] = [];
        $postFields["userID"] = "$user";
        $postFields["remark"] = "$remark";
        
    
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_URL, 'http://tataaiguat.vahancheck.com/VCWebAPI/api/ExternalAgencyReport/Post');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: multipart/form-data\r\n' ,'Authorization: Basic PuwoFFOP+Zr2wtaTjv9KnQ==','userID: axion'));
        $result = curl_exec($ch);
        // curl_close($ch);
        print_r($result);
        print_r($postFields);
    }
    
    echo "</pre>";
    
    
    
    
?>

<?php

        $id = $_POST['leadID'];
        $v = $_POST['vehicleRegistrationNo'];
        $status = $_POST['qcStatus'];       
        $filename = $_FILES['zipArray']['name'][0];
        $user = $_POST['userID'];
        $remark = $_POST['remark'];

$client = new http\Client;
$request = new http\Client\Request;

$body = new http\Message\Body;
$body->addForm(array(
  'leadID' => $id,
  'vehicleRegistrationNo' => $v,
  'qcStatus' => $status,
  'userID' => $user,
  'remark' => $remark
), array(
  array(
    'name' => 'zipArray',
    'type' => null,
    'file' => '13-images-pdf.zip',
    'data' => null
  ),
  array(
    'name' => 'pdfArray1',
    'type' => null,
    'file' => null,
    'data' => null
  ),
  array(
    'name' => 'pdfArray2',
    'type' => null,
    'file' => null,
    'data' => null
  )
));

$request->setRequestUrl('http://tataaiguat.vahancheck.com/VCWebAPI/api/ExternalAgencyReport/Post');
$request->setRequestMethod('POST');
$request->setBody($body);

$request->setHeaders(array(
  'postman-token' => '1ea38a62-0e15-439a-81ab-cf1ebcb5240d',
  'cache-control' => 'no-cache',
  'authorization' => 'Basic PuwoFFOP+Zr2wtaTjv9KnQ=='
));

$client->enqueue($request)->send();
$response = $client->getResponse();

echo $response->getBody();











      <table class="table" border="2">
    <th>
 <div id="inspection_photos" class="preinspection-box" style="margin-bottom: 30px">
    <table id="myTable" class=" table order-list">
        <div class="row">
           <h4 class="preinspection-box-title">Assessment</h4> 
         </div>
         <div class="container">

    <div class="form-group">
    <form name="add_name" id="add_name">
        <table class="table table-bordered" id="dynamic_field">
            <tr>
                <td>Remove</td>
                <td>
                    <input type="text" name="name[]" id="name" class="form-control name_list" />
                </td>
                <td>
                    <input type="text" name="name[]" id="name" class="form-control name_list" />
                </td>
            
            </tr>
        </table>
       <button type="button" name="add" id="add" class="btn btn-success">Add</button>
    </form>
</div>
</div>        

</table>

</th></table>


<?php

$url = YII::$app->request->baseUrl.'/axion-claimsurvey/Fourwheelerqc';

$script = <<< JS
$(document).ready(function(){
        var i = 1;
        $('#add').click(function(){
          i++;
          $('#dynamic_field').append('<tr id="row'+i+'"><td><button name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td><td><input type="text" name="assessment[{'+i+'}]" id="assessment" class="form-control name_list" /></td><td><input type="text" name="assessment[{'+i+'}]" id="assessment" class="form-control name_list" /></td></tr>');
        });

        $(document).on('click', '.btn_remove', function(){
           var button_id = $(this).attr("id");
           $('#row'+button_id+'').remove();
        });
        
        $('#submit').click(function(){
           $.ajax({
                 url:'$url',
                 method:'POST',
                 data:$('#add_name').serialize(),
                 success:function(data)
                 {
                    alert(data);
                    $('#add_name')[0].reset();

                 }
           });
        });
    });

JS;
$this->registerJS($script);
?>



Please wait for your IBM Live Advisor to respond.
Info at 16:48, Sep 24:
You are now chatting with Kory T.
Kory T at 16:49, Sep 24:
Hello, thank you for contacting IBM Cloud. How may I assist you today?
arul at 16:49, Sep 24:
hi
arul at 16:49, Sep 24:
we just upgrade our softlayer just now before 20 min
arul at 16:49, Sep 24:
now our server will not working
Kory T at 16:50, Sep 24:
I believe we have a chat engagement opened already regarding your server. Are you no longer connected to that session?
arul at 16:51, Sep 24:
am also working for that server
arul at 16:51, Sep 24:
how long it will take ?
Kory T at 16:51, Sep 24:
For verification purposes, can you please provide the IP address of the server in question?
arul at 16:52, Sep 24:
119.81.46.10
Kory T at 16:53, Sep 24:
Ok so from my initial look into the server was unsuccessful, as the instance was powered off. My attempts to manually start the server back up have failed. I've reached out to our internal development team who has also confirmed this on their end. Before placing the server into rescue and troubleshooting from there, the dev team will be checking the host to ensure the instance does not need to be migrated for any reason.
Kory T at 16:53, Sep 24:
I will be closing our previous chat engagement, as there are other customers awaiting chat support.
Kory T at 16:54, Sep 24:
Ok the dev team did not determine there anything wrong with the host in question. At this time, the next step would be to place the server into rescue and investigate what is causing the server from booting up.
Kory T at 16:55, Sep 24:
Has there been a ticket created for this issue already?
arul at 16:55, Sep 24:
u can response me am the admin
Kory T at 16:55, Sep 24:
Ok, do we have your permission to place the server into rescue and investigate from there?
arul at 16:56, Sep 24:
is there possible to downgrade to last version ?/
Kory T at 16:57, Sep 24:
We can revert to the latest used kernel, and try to boot that way.
Kory T at 16:57, Sep 24:
We can check the fstab for bad entries.
Kory T at 16:57, Sep 24:
We can check the file system for corruption.
arul at 16:58, Sep 24:
kindly fix this , am in pressure
arul at 16:58, Sep 24:
anything i do from myside ?
arul at 16:59, Sep 24:
my suppoting staff will upgrade as per your team guide
Kory T at 17:00, Sep 24:
Yes, we need approval to create a ticket and place the server into rescue.
arul at 17:00, Sep 24:
okay
arul at 17:00, Sep 24:
shall i raise a ticket now ?
Kory T at 17:01, Sep 24:
You can also create a ticket and provide the number. I will assign it to myself and get started once approval has been granted from you.
arul at 17:01, Sep 24:
u mean my mobile number ?
Kory T at 17:01, Sep 24:
The ticket number
arul at 17:02, Sep 24:
any mail id to contact you ?
Kory T at 17:02, Sep 24:
That information will be provided in the case notes
Kory T at 17:02, Sep 24:
(By default)
arul at 17:02, Sep 24:
ok i raise the ticket
Kory T at 17:03, Sep 24:
Understood. Standing by.
arul at 17:07, Sep 24:
91402730
arul at 17:07, Sep 24:
this is my ticket id
Kory T at 17:07, Sep 24:
Excellent, thanks. Checking now.
arul at 17:07, Sep 24:
fine
Kory T at 17:11, Sep 24:
Ok I've assigned myself to the case and provided an initial update.
Kory T at 17:11, Sep 24:
Just need you to update with approval.
arul at 17:12, Sep 24:
how to update
arul at 17:12, Sep 24:
need any reply to that ticket
Kory T at 17:14, Sep 24:
Ok, I will now be placing the server into rescue.
arul at 17:15, Sep 24:
ok
Kory T at 17:18, Sep 24:
Arul, the rescue transaction has been initiated. It will take approx. 5-10 minutes.
arul at 17:18, Sep 24:
what's the exact issue while upgrading
Kory T at 17:19, Sep 24:
I won't be able to make that determination until I've reviewed some things from within the server (logs, fstab, file system, etc.)
arul at 17:19, Sep 24:
god
arul at 17:20, Sep 24:
lets see
Kory T at 17:24, Sep 24:
I'm sorry for the delay. I'll be right with you.
arul at 17:27, Sep 24:
okay man
Kory T at 17:29, Sep 24:
I'll be right with you.
Kory T at 17:32, Sep 24:
Server has reached rescue. I'm checking a few things now.
arul at 17:32, Sep 24:
ok man
arul at 17:33, Sep 24:
i hope u find the issue soon
Kory T at 17:37, Sep 24:
Thank you for waiting. I'll be with you in just a moment.
arul at 17:38, Sep 24:
ok
Kory T at 17:42, Sep 24:
Thank you for waiting. I'll be with you in just a moment.
Kory T at 17:43, Sep 24:
Ok so the fstab looks ok. I'm now checking the boot configuration.
arul at 17:45, Sep 24:
ok
Kory T at 17:47, Sep 24:
Attempting to boot with previous kernel
Kory T at 17:47, Sep 24:
Checking console now
arul at 17:48, Sep 24:
i don't no y suddenly it was corrupted
Kory T at 17:52, Sep 24:
Reverting to the previous kernel did not resolve this issue. Server is still not coming back on. Placing back in to rescue.
arul at 17:53, Sep 24:
what kind of issue is this ?
Kory T at 17:54, Sep 24:
Still trying to determine that now.
arul at 17:54, Sep 24:
we can able to give any reply to our client
arul at 17:54, Sep 24:
ok man
Kory T at 17:59, Sep 24:
I'm sorry for the delay. I'll be right with you.
arul at 17:59, Sep 24:
ok
Kory T at 18:04, Sep 24:
Currently reviewing your logs. I am also not finding anything in messages, dmesg or boot.
Kory T at 18:08, Sep 24:
Arul, I'd like to run a file system check to ensure there's no file corruption. This process can cause data loss. It's recommended that backups be created if you don't already have them in place.
Kory T at 18:08, Sep 24:
Can we proceed with this?
arul at 18:09, Sep 24:
yes
Kory T at 18:09, Sep 24:
EXT3-fs warning: checktime reached, running e2fsck is recommended
EXT3 FS on xvda2, internal journal
EXT3-fs: mounted filesystem with ordered data mode.
Kory T at 18:09, Sep 24:
Understood. I'll get started now.
arul at 18:09, Sep 24:
ok
arul at 18:09, Sep 24:
need to fix this
Kory T at 18:10, Sep 24:
The file system check is now running.
arul at 18:10, Sep 24:
cpanel ?
Kory T at 18:11, Sep 24:
No, this is running from the rescue environment.
arul at 18:11, Sep 24:
ok ok
Kory T at 18:11, Sep 24:
/dev/xvda2 has gone 377 days without being checked, check forced.
Kory T at 18:12, Sep 24:
For future reference, I recommend initiating this type of maintenance on a routine basis to avoid any file corruption.
arul at 18:14, Sep 24:
/dev/xvda2 has gone 377 days without being checked, check forced. ->>> i caan't understand
Kory T at 18:14, Sep 24:
It's just stating that a file system check has not been run in 377 days.
arul at 18:14, Sep 24:
ho
Kory T at 18:15, Sep 24:
That's quite a bit of time to elapse without running one.
arul at 18:15, Sep 24:
ok
Kory T at 18:15, Sep 24:
The FSCK is still running. It's currently at 28.2%
Kory T at 18:16, Sep 24:
It should be done within the next 10-15 minutes.
Kory T at 18:16, Sep 24:
After this, I'll try rebooting again. If that does not work, I'll need to place the server back into rescue to allow you to back your data up.
Kory T at 18:16, Sep 24:
At that point, you would need to just initiate an OS reload from your customer portal.
Kory T at 18:16, Sep 24:
That will resolve any and all issues.
arul at 18:16, Sep 24:
ok
Kory T at 18:16, Sep 24:
Once the server has completed the reload, you can restore your backup data.
Kory T at 18:17, Sep 24:
Hopefully it doesn't come to that, but at least there is a course of action.
arul at 18:17, Sep 24:
ok
Kory T at 18:18, Sep 24:
Just to note, so far, we've checked the logs (boot, dmesg, message), boot configuration, attempted reverting to a previously used kernel, checked for any kernel related errors/failures, and are now running a file system check to ensure no file corruption.
arul at 18:18, Sep 24:
ok
Kory T at 18:19, Sep 24:
The FSCK is now at 42.3%
arul at 18:20, Sep 24:
ok
Kory T at 18:25, Sep 24:
I'll be right with you.
arul at 18:25, Sep 24:
sure
Kory T at 18:26, Sep 24:
The FSCK is now at 60.3%
arul at 18:27, Sep 24:
what's our current file system size ?
Kory T at 18:28, Sep 24:
The partition size is 100GB. 56GB used. 59GB Free.
Kory T at 18:28, Sep 24:
39GB Free excuse me.
arul at 18:28, Sep 24:
okk
arul at 18:33, Sep 24:
issue due to this -> /dev/xvda2 has gone 377 days without being checked, check forced. ?
arul at 18:33, Sep 24:
or anything else ??
Kory T at 18:33, Sep 24:
Not necessarily, but it is a severe cause for concern.
arul at 18:33, Sep 24:
why these kind of issue will happen?
Kory T at 18:35, Sep 24:
Just for hypothesis, significant changes to a system can affect how said system operates depending on the type of condition it was in prior to the change.
arul at 18:35, Sep 24:
so happen due to upgrade ?
Kory T at 18:36, Sep 24:
I'm not quite sure on that, and don't want to speculate.
Kory T at 18:36, Sep 24:
Component upgrades are typically seamless.
Kory T at 18:36, Sep 24:
Usually just a matter of a quick reboot.
Kory T at 18:36, Sep 24:
(The FSCK is currently at 82%)
arul at 18:36, Sep 24:
ok
Kory T at 18:41, Sep 24:
I'll be right with you.
arul at 18:42, Sep 24:
yes
Kory T at 18:45, Sep 24:
Ok the FSCK has completed. I'm attempting to boot the server up to normal now.
arul at 18:45, Sep 24:
sure man
arul at 18:45, Sep 24:
go ahead
Kory T at 18:48, Sep 24:
Ok unfortunately, I'm still unable to get this server booted up.
Kory T at 18:48, Sep 24:
As previously discussed, I'll place the server back into rescue, mount your root partition and allow you to back your data up.
Kory T at 18:48, Sep 24:
Doing this now.
arul at 18:48, Sep 24:
make it
arul at 18:49, Sep 24:
is there anny problem while try to boot
Kory T at 18:50, Sep 24:
Nothing in particular, it's just crashing on boot up attempt.
arul at 18:50, Sep 24:
ok ok
Kory T at 18:51, Sep 24:
Ok the server has now reached rescue. I've mounted the root partition to /mnt
Kory T at 18:51, Sep 24:
I'll also document this in the ticket.
Kory T at 18:51, Sep 24:
From there, you can backup your data, initiate the OS Reload from the customer portal, then restore your backup when it finishes.
arul at 18:51, Sep 24:
from softlayer ?
Kory T at 18:52, Sep 24:
Yes from your customer portal.
arul at 18:52, Sep 24:
shall i start now ?
Kory T at 18:52, Sep 24:
Yes, I am now exiting the server for you to go in and get your data.
Kory T at 18:53, Sep 24:
My shift has come to an end, but my colleagues are aware of the case. If you run into any additional issues, you can update the ticket, and your inquiries will be addressed.
Kory T at 18:53, Sep 24:
From this point, you'll just need to backup your data, then you can just leave the server in rescue while you initiate the reload from your portal.
arul at 18:53, Sep 24:
which way to get the data backup from my portal ?
arul at 18:54, Sep 24:
froom storage option ? or some where?
Kory T at 18:54, Sep 24:
You wouldn't get the data from your portal, you would back the data up to a remote location.
Kory T at 18:54, Sep 24:
By this, I mean you can back your data up locally or to portable storage.
arul at 18:54, Sep 24:
tell me step by step please
Kory T at 18:54, Sep 24:
You can use FileZilla, WinSCP, SCP, etc.
Kory T at 18:55, Sep 24:
Personally, I would use FileZilla. Connect to the server via sftp, then transfer the files you want to keep to your local machine.
Kory T at 18:55, Sep 24:
Then, from the customer portal, initiate the OS reload.
Kory T at 18:56, Sep 24:
Then when the reload has completed, you can restore your backed up data to the reloaded server.
arul at 18:56, Sep 24:
right now i dont have any ftp login details
arul at 18:56, Sep 24:
now am using filezilla
arul at 18:56, Sep 24:
u have any login details please share
Kory T at 18:57, Sep 24:
You will use your server's credentials
Kory T at 18:58, Sep 24:
And IP address
Kory T at 18:58, Sep 24:
You can access the server publicly or privately (must be connected to SL VPN).
arul at 18:58, Sep 24:
i dont no my password
Kory T at 18:58, Sep 24:
You can also find this information in the customer portal.
Kory T at 18:58, Sep 24:
I cannot provide this info to you in a chat engagement.
arul at 18:59, Sep 24:
ok
arul at 18:59, Sep 24:
soon man
arul at 19:02, Sep 24:
how can i access ?
Kory T at 19:02, Sep 24:
In FileZilla, you can use your public address, and your server's root credentials.
Kory T at 19:02, Sep 24:
You should be able to find your credentials from your customer portal in the server's device details.
Kory T at 19:05, Sep 24:
Were you able to find the server credentials from your portal?
arul at 19:05, Sep 24:
am searching ?
Kory T at 19:05, Sep 24:
Standing by
arul at 19:06, Sep 24:
which menu option i find the details
arul at 19:06, Sep 24:
devices ?
arul at 19:06, Sep 24:
network ?
arul at 19:06, Sep 24:
services?
Kory T at 19:06, Sep 24:
Should be under devices
Kory T at 19:06, Sep 24:
Device list > select server > password tab
Kory T at 19:08, Sep 24:
https://control.softlayer.com/devices/details/61340879/virtualGuest#Passwords
Kory T at 19:08, Sep 24:
You can locate your password at the bottom of this page.
Kory T at 19:08, Sep 24:
You can either hover your cursor over the anonymized password, or click on the anonymized password. Both will show you.
arul at 19:09, Sep 24:
in software option cent os i select
arul at 19:10, Sep 24:
shall i proceed add credentials
arul at 19:11, Sep 24:
after put username and password and software ddetails ?
Kory T at 19:12, Sep 24:
No, you don't need to add any credentials.
Kory T at 19:12, Sep 24:
Those are the credentials you'll use for FTP access.
arul at 19:12, Sep 24:
ok ok
Kory T at 19:12, Sep 24:
To be clear, changing the credentials in the portal does not change the credentials on the server.
Kory T at 19:13, Sep 24:
This is a very big misconception.
Kory T at 19:13, Sep 24:
Were you able to locate the credentials for this server?
arul at 19:13, Sep 24:
no no
arul at 19:13, Sep 24:
am clear
arul at 19:14, Sep 24:
i found the password user details
arul at 19:14, Sep 24:
let me try with file zilla
Kory T at 19:14, Sep 24:
Ok
Kory T at 19:16, Sep 24:
I was just able to login successfully.
arul at 19:16, Sep 24:
yes
Kory T at 19:16, Sep 24:
Remember, your root partition has been mounted to the /mnt mount point.
arul at 19:17, Sep 24:
shall i back up root folder ?
Kory T at 19:17, Sep 24:
You'll need to go to that directory
Kory T at 19:17, Sep 24:
Don't confuse this with the root directory
Kory T at 19:17, Sep 24:
You want to backup /mnt/
arul at 19:17, Sep 24:
which dir i need to backup
arul at 19:18, Sep 24:
ok
Kory T at 19:18, Sep 24:
Excellent.
Kory T at 19:18, Sep 24:
Did you have any other questions for me?
arul at 19:18, Sep 24:
so mnt only enough to backup ?
Kory T at 19:19, Sep 24:
That's correct.
arul at 19:20, Sep 24:
so no need to take any other dir backup ?
Kory T at 19:20, Sep 24:
No, everything else is unmounted.
Kory T at 19:20, Sep 24:
Everything being your boot and swap partitions.
Kory T at 19:20, Sep 24:
Both not necessary.
Kory T at 19:21, Sep 24:
Your xvdc drive will not be touched.
Kory T at 19:21, Sep 24:
So there's no need to back it up at this time.
arul at 19:21, Sep 24:
ok man
Kory T at 19:21, Sep 24:
Excellent. Did you have any additional questions?
arul at 19:21, Sep 24:
we need to fix this today
Kory T at 19:22, Sep 24:
The issue should be resolved when the reload is complete.
Kory T at 19:22, Sep 24:
If you run into any issues, you can update the ticket, and we can assist you further.
arul at 19:22, Sep 24:
ok after my mnt backup completed what's next step ?
Kory T at 19:23, Sep 24:
This has been discussed both in this engagement, as well as the ticket I've updated.
Kory T at 19:23, Sep 24:
When the backup is completed, you will initiate an OS reload from the portal.
Kory T at 19:23, Sep 24:
When the OS reload has completed, you will restore your backup.
arul at 19:24, Sep 24:
how to i reload the OS from my portal
arul at 19:24, Sep 24:
is there any link to find it clearly ?
Kory T at 19:24, Sep 24:
https://control.softlayer.com/devices/details/61340879/virtualGuest#Configuration
Kory T at 19:24, Sep 24:
You can initiate the reload from the actions drop-down menu on the far right.
Kory T at 19:24, Sep 24:
It's the 4th option on the list.
Kory T at 19:25, Sep 24:
Did you have any additional questions for me?
arul at 19:25, Sep 24:
ok
arul at 19:25, Sep 24:
os Reloaded option is there i got it
arul at 19:26, Sep 24:
once i reload it then i restore mnt dir througn ftp right ?
Kory T at 19:26, Sep 24:
Excellent. Sounds like you're headed in the right direction.
Kory T at 19:26, Sep 24:
Yes, that is correct.
arul at 19:26, Sep 24:
ok
arul at 19:26, Sep 24:
keep ssome one assist with me
Kory T at 19:27, Sep 24:
At this point, you will need to initiate the reload on your own. If you run into trouble after the reload, you can update the ticket and assistance will be provided.
arul at 19:27, Sep 24:
we are in middle of the prrocess so i can able to explain from the begining to someone again
arul at 19:27, Sep 24:
ok
Kory T at 19:27, Sep 24:
This process has been documented in the ticket.
arul at 19:28, Sep 24:
how long it will take mnt back up ?
Kory T at 19:29, Sep 24:
That is dependent on your own connection. I cannot determine that.
arul at 19:29, Sep 24:
i have only 1 gb net balance
Kory T at 19:29, Sep 24:
Arul, please continue with the file transfer and inform us when you run into an issue that requires our assistance.
Kory T at 19:29, Sep 24:
At this point, there is nothing further we can do to move this process along.
Kory T at 19:30, Sep 24:
You will need to backup your data, initiate the reload, then restore your data to your server.
arul at 19:30, Sep 24:
ok
Kory T at 19:30, Sep 24:
If you run into any issues, you're more than welcome to update the ticket with any inquiries you may have.
Kory T at 19:30, Sep 24:
Did you have any other questions for me at this time?
arul at 19:32, Sep 24:
no
arul at 19:32, Sep 24:
thanks
Kory T at 19:32, Sep 24:
You're very welcome. Thank you for choosing IBM Cloud. We really value your feedback. Are you able to answer a few questions at the end of this chat? Thanks and have a good day!
Info at 19:32, Sep 24:
Chat session has been terminated by the site operator.



