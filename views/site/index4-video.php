<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'Home';

?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        Welcome to Process Control System.
    </p>
    
    <div>
        <iframe
  src="https://tokbox.com/embed/embed/ot-embed.js?embedId=77e3841b-24d4-4ac3-8038-584bc242199e&room=DEFAULT_ROOM&iframe=true"
  width="800px"
  height="640px"
  allow="microphone; camera"
></iframe>
    </div>

</div>
