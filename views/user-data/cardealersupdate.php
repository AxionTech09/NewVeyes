<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = 'Update Associate Dealers: ' . ' ' . $model->firstName;
$this->params['breadcrumbs'][] = ['label' => 'Associate Dealers List', 'url' => ['cardealers']];
$this->params['breadcrumbs'][] = ['label' => $model->firstName, 'url' => ['view-cardealers', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="userdata-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('cardealers_form', [
        'model' => $model,
        'surveyor' => $surveyor,
        
    ]) ?>

</div>