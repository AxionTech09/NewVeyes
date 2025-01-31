<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\MasterCity */

$this->title = 'Create State';
$this->params['breadcrumbs'][] = ['label' => 'State', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="master-state-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
