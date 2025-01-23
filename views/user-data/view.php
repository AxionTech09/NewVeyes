<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Userdata */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="userdata-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?php
    if($model->type == 'Valuator')
    {
        echo DetailView::widget([
            'model' => $model,
            'attributes' => [
                'name',
                'username',
                'password',
                'type',
                [
                    'label' => 'Assigned to Staff',
                    'value' => isset($model->valuatorStaff->name) ? $model->valuatorStaff->name : '',
                ],
                'mobile',
            ],
        ]);
    }
    else
    {
       echo DetailView::widget([
            'model' => $model,
            'attributes' => [
                'name',
                'username',
                'password',
                'type',
                'mobile',
            ],
        ]); 
    }
            ?>

</div>
