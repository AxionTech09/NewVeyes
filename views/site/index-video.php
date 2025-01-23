<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use OpenTok\OpenTok;


$this->title = 'Home';
//$apiKey = '46113702';
//$apiSecret = '379d55380836f6366d9115f96a595e9e03519b4e';
 //$opentok = new OpenTok($apiKey, $apiSecret);
 
 //$session = $opentok->createSession();
//echo $sessionId = $session->getSessionId();
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        Welcome to Process Control System.
    </p>
    

     <div id="videos">
        <div id="subscriber"></div>
        <div id="publisher"></div>
        </div>
    
</div>

<?php

$script = <<< JS
// replace these values with those generated in your TokBox Account
var apiKey = "46113702";
var sessionId = "1_MX40NjExMzcwMn5-MTUyNjEwOTM2ODI4Nn5Cc2dIc01Pc3NlejNSNW8wSDZma0xZK09-fg";
var token = "T1==cGFydG5lcl9pZD00NjExMzcwMiZzaWc9YzE2OThkZDViNDRhNDYwZjQwNTQ2NDFkMWFmMWI2NmZkYjhmZDg3NjpzZXNzaW9uX2lkPTFfTVg0ME5qRXhNemN3TW41LU1UVXlOakV3T1RNMk9ESTRObjVDYzJkSWMwMVBjM05sZWpOU05XOHdTRFptYTB4WkswOS1mZyZjcmVhdGVfdGltZT0xNTI2MTA5NDU1Jm5vbmNlPTAuMDc5MTc2MzM3MzkwMjQ3NDMmcm9sZT1wdWJsaXNoZXImZXhwaXJlX3RpbWU9MTUyNjExMzA1NCZpbml0aWFsX2xheW91dF9jbGFzc19saXN0PQ==";

// Handling all of our errors here by alerting them
function handleError(error) {
  if (error) {
    alert(error.message);
  }
}

// (optional) add server code here
initializeSession();

function initializeSession() {
  var session = OT.initSession(apiKey, sessionId);

  // Subscribe to a newly created stream
  session.on('streamCreated', function(event) {
    session.subscribe(event.stream, 'subscriber', {
      insertMode: 'append',
      width: '100%',
      height: '100%'
    }, handleError);
  });

  // Create a publisher
  var publisher = OT.initPublisher('publisher', {
    insertMode: 'append',
    width: '100%',
    height: '100%'
  }, handleError);

  // Connect to the session
  session.connect(token, function(error) {
    // If the connection is successful, initialize a publisher and publish to the session
    if (error) {
      handleError(error);
    } else {
      session.publish(publisher, handleError);
    }
  });
}
      

JS;
$this->registerJS($script);
?>
<?php
$style = <<< CSS
#videos {
    position: relative;
    width: 100%;
    height: 100%;
    margin-left: auto;
    margin-right: auto;
}

#subscriber {
    position: absolute;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    z-index: 10;
}

#publisher {
   /* position: absolute; */
    width: 360px;
    height: 240px;
    bottom: 10px;
    left: 10px;
   /* z-index: 100; */
    border: 3px solid white;
    border-radius: 3px;
}
CSS;
 $this->registerCss($style);
?>