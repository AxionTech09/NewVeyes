<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\PreinspectionClientBranch */

$this->title = 'Create Client Branch';
$this->params['breadcrumbs'][] = ['label' => 'Preinspection Client Branches', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="preinspection-client-branch-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'company' => $company,
    ]) ?>

</div>
