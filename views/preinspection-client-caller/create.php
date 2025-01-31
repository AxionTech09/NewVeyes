<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\PreinspectionClientCaller */

$this->title = 'Create Client';
$this->params['breadcrumbs'][] = ['label' => 'Preinspection Clients', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="preinspection-client-caller-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'company' => $company,
    ]) ?>

</div>
