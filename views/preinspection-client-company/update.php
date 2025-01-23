<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PreinspectionClientCompany */

$this->title = 'Update - ' .$model->companyName;
$this->params['breadcrumbs'][] = ['label' => 'Preinspection Client Companies', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->companyName, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="preinspection-client-company-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
