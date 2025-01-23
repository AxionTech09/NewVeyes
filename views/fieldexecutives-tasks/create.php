<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\FieldexecutivesTasks */

$this->title = 'Create Fieldexecutives Tasks';
$this->params['breadcrumbs'][] = ['label' => 'Fieldexecutives Tasks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fieldexecutives-tasks-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
