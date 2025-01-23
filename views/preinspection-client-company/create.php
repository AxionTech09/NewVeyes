<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\PreinspectionClientCompany */

$this->title = 'Create Preinspection Client Company';
$this->params['breadcrumbs'][] = ['label' => 'Preinspection Client Companies', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="preinspection-client-company-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
