<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Userdata */

$this->title = 'Update Branch Executive User: ' . ' ' . $model->firstName;
$this->params['breadcrumbs'][] = ['label' => 'Branch Executive User List', 'url' => ['bexecutiveuser']];
$this->params['breadcrumbs'][] = ['label' => $model->firstName, 'url' => ['view-bexecutiveuser', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="userdata-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('bexecutiveuser_form', [
        'model' => $model,
        'city' => $city,
        'company' => $company,
        'division' => $division,
        'branch' => $branch,
        'bhead' => $bhead,
        'roName' => $roName,
    ]) ?>

</div>
