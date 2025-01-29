<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\PreinspectionClientDivision */

$this->title = 'Create Preinspection Client Region';
$this->params['breadcrumbs'][] = ['label' => 'Preinspection Client Region', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="preinspection-client-region-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'company' => $company,
    ]) ?>

</div>
