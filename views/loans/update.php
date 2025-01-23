<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Loans */

$this->title = 'Update Loans: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Loans', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="loans-update">

   <!--  <h1><?= Html::encode($this->title) ?></h1>
 -->
    <?= $this->render('_form', [
        'model' => $model,
        'ldmodel' => $ldmodel,
        'bkmodel' => $bkmodel,
        'cardealers' => $cardealers,
        'role' => $role,
    ]) ?>

</div>

