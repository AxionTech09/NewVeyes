<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Userdata */

$this->title = $model->firstName;
$this->params['breadcrumbs'][] = ['label' => 'Branch Executive User List', 'url' => ['bexecutiveuser']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="userdata-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update-bexecutiveuser', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete-bexecutiveuser', 'id' => $model->id], [
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
                'firstName',
                'email',
                'mobile',
            ],
        ]);

            ?>

</div>
