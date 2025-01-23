<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Userdata */

$this->title = 'Update Branch Head User: ' . ' ' . $model->firstName;
$this->params['breadcrumbs'][] = ['label' => 'Branch Head User List', 'url' => ['bheaduser']];
$this->params['breadcrumbs'][] = ['label' => $model->firstName, 'url' => ['view-bheaduser', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="userdata-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('bheaduser_form', [
        'model' => $model,
        'city' => $city,
        'company' => $company,
        'division' => $division,
        'branch' => $branch,
    ]) ?>

</div>
