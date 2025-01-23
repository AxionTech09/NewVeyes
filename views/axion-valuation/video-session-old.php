<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use kartik\datecontrol\DateControl;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\AxionPreinspectionFourwheeler */
/* @var $form ActiveForm */

?>
<div class="axion-preinspection-fourwheelerqc">

    <?php $form = ActiveForm::begin(['id'=>$premodel->formName(),'options' => ['enctype' => 'multipart/form-data']]); ?>
    
    <?php if($premodel->valuatorName == 0 ) { ?>
    <h4 class="preinspection-box-title">Video Session</h4>
    <div id="inspection_session" class="preinspection-box" style="margin-bottom: 30px">
        
    <?php 
        if($apiSession != '' && $apiToken != ''){

        ?>
         
        <div id="videos">
        <?php if($role != 'Customer') { ?>
        <div id="subscriber"></div>
        <?php } else { ?>        
        <div id="publisher"></div>
        <?php } ?>
        </div>
        
         <?= Html::submitButton('End Video Session', ['class' => 'btn btn-primary', 'value'=>'end_session', 'name'=>'end_session']) ?>
         <?php } else if($apiSession != '' && $apiToken == '') { ?>
             <div class="form-group" style="text-align: center">
            <?= Html::submitButton('Join Video Session', ['class' => 'btn btn-primary', 'value'=>'join_session', 'name'=>'join_session']) ?>
            </div>
           <?php }
        ?>
     </div>
    <?php  }   ?>
    <div class="clear"></div>
    
    <?php ActiveForm::end(); ?>
    <h4 class="preinspection-box-title">Archives</h4> 
  <?php 

date_default_timezone_set("Asia/Calcutta");
    foreach( $archives as $arr){

    if($arr->status == "available")
    {

    //print_r($arr->status);
      ?>
    <div>
    <?= Html::a(date('d-m-Y H:i:s', $arr->createdAt/1000), $arr->url, ['class' => 'profile-link','target' => '_blank']) ?>
    </div>
    <?php
  }
        }
        //print_r($archives);
        ?>

</div>




<?php
if($apiKey != '' && $apiSession != '' && $apiToken != '')
{
$script = <<< JS
// replace these values with those generated in your TokBox Account
var apiKey = "$apiKey";
var sessionId = "$apiSession";
var token = "$apiToken";
var publisher;
var session;
// Handling all of our errors here by alerting them
function handleError(error) {
  if (error) {
    alert(error.message);
  }
}

// (optional) add server code here
initializeSession();

function initializeSession() {
  session = OT.initSession(apiKey, sessionId);

  // Subscribe to a newly created stream
  session.on('streamCreated', function streamCreated(event) {
    var subscriberOptions = {
      insertMode: 'append',
      width: '100%',
      height: '100%'
    };
    session.subscribe(event.stream, 'subscriber', subscriberOptions, handleError);
  });

  session.on('sessionDisconnected', function sessionDisconnected(event) {
    console.log('You were disconnected from the session.', event.reason);
  });

  // initialize the publisher
  var publisherOptions = {
    insertMode: 'append',
    width: '100%',
    height: '100%',
    facingMode : 'environment'
  };
  publisher = OT.initPublisher('publisher', publisherOptions, handleError);

  // Connect to the session
  session.connect(token, function callback(error) {
    if (error) {
      handleError(error);
    } else {
      // If the connection is successful, publish the publisher to the session
      session.publish(publisher, handleError);
    }
  });
}
  
   
         $(".buttonChangeCamera").click(function(){
        alert('ok');
        try {
publisher.cycleVideo();
}
catch(err) {
   alert(err);
}
        alert('test');
});  

JS;
$this->registerJS($script);

$style = <<< CSS
#videos {
    position: relative;
    width: 100%;
    height: 100%;
    margin-left: auto;
    margin-right: auto;
}

#subscriber {
    width: 360px;
    height: 240px;
    bottom: 10px;
    left: 10px;
    border: 3px solid white;
    border-radius: 3px;
}         

#publisher {
    width: 360px;
    height: 240px;
    bottom: 10px;
    left: 10px;
    border: 3px solid white;
    border-radius: 3px;
    background-color: green;
}
        
/*        
#subscriber {
    position: absolute;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    z-index: 10;
}
#publisher {
    position: absolute;
    width: 360px;
    height: 240px;
    bottom: 10px;
    left: 10px;
    z-index: 100;
    border: 3px solid white;
    border-radius: 3px;
}    
*/        
CSS;
 $this->registerCss($style);
}
?>

