<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\MasterBanks */

$this->title = 'Create Master Banks';
$this->params['breadcrumbs'][] = ['label' => 'Master Banks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="master-banks-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
