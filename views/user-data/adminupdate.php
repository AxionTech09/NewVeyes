<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Userdata */

$this->title = 'Update Admin: ' . ' ' . $model->firstName;
$this->params['breadcrumbs'][] = ['label' => 'Admin List', 'url' => ['admin']];
$this->params['breadcrumbs'][] = ['label' => $model->firstName, 'url' => ['view-admin', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="userdata-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('admin_form', [
        'model' => $model,
        'city' => $city,
    ]) ?>

</div>
