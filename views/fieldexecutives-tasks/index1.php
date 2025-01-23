<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\FieldexecutivesTasksSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Fieldexecutives Tasks';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fieldexecutives-tasks-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Fieldexecutives Tasks', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'processId',
            'processNo',
            'companyName',
            'location',
            // 'customerAppointmentDateTime',
            // 'fieldexecutiveId',
            // 'processType',
            // 'created_on',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
