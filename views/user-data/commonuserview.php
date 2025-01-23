<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Userdata */

$this->title = $model->firstName;
$this->params['breadcrumbs'][] = ['label' => 'Executive List', 'url' => ['commonuser']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="userdata-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update-commonuser', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete-commonuser', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?php

        echo DetailView::widget([
            'model' => $model,
            'attributes' => [
                'id',
                'firstName',
                'email',
                'mobile',
                'address',
                'panNo',
            ],
        ]);

            ?>

</div>
