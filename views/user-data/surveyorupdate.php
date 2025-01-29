<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Userdata */

$this->title = 'Update Surveyor: ' . ' ' . $model->firstName;
$this->params['breadcrumbs'][] = ['label' => 'Surveyor List', 'url' => ['surveyor']];
$this->params['breadcrumbs'][] = ['label' => $model->firstName, 'url' => ['view-surveyor', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="userdata-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('surveyor_form', [
        'model' => $model,
        'city' => $city,
        'state' => $state,
        'ro_name'=>$ro_name,
    ]) ?>

</div>
