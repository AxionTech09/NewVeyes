<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\PreinspectionClientDivision */

$this->title = 'Create Preinspection Client Division';
$this->params['breadcrumbs'][] = ['label' => 'Preinspection Client Divisions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="preinspection-client-division-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'company' => $company,
        'region' => $region,
    ]) ?>

</div>
