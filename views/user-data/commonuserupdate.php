<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Userdata */

$this->title = 'Update Executive: ' . ' ' . $model->firstName;
$this->params['breadcrumbs'][] = ['label' => 'Executive List', 'url' => ['commonuser']];
$this->params['breadcrumbs'][] = ['label' => $model->firstName, 'url' => ['view-commonuser', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="userdata-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('commonuser_form', [
        'model' => $model,
        'city' => $city,
    ]) ?>

</div>
