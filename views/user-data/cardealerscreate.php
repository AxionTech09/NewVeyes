<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = 'Create Associate Dealers';

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="userdata-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('cardealers_form', [
        'model' => $model,
        'surveyor' => $surveyor,
       
    ]) ?>

</div>
