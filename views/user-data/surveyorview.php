<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\User;

/* @var $this yii\web\View */
/* @var $model app\models\Userdata */

$this->title = $model->firstName;
$this->params['breadcrumbs'][] = ['label' => 'Surveyor List', 'url' => ['surveyor']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="userdata-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update-surveyor', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete-surveyor', 'id' => $model->id], [
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
                ['attribute' => 'roId',
                    'label'=>'RO Name',
                 'value' => function ($model) {

                                $umodel=User::findOne($model->roId);
                                return $umodel->firstName;
                         },],
                ['attribute'=>'firstName','label'=>'Surveyor Name'],
                'email',
                'mobile',
                [
                    'attribute'=>'joiningDate',
                    'value' => function ($model){
                        return ($model->joiningDate) ? date('d-M-Y',strtotime($model->joiningDate)) : '';
                    }
                ],
                'bank_name',
                'account_number',
                'ifsc_code',
                'branch_name',
                'salaryType',
                'conveyanceType',
                [
                    'attribute'=>'basicSalary',
                    'visible' => ($model->salaryType == "Fixed Salary") ? true : false,
                ],
                [
                    'attribute'=>'feesPerCase',
                    'visible' => ($model->salaryType == "Variable Salary") ? true : false,
                ],
                [
                    'attribute'=>'conveyanceAmount',
                    'visible' => ($model->conveyanceType == "Fixed Conveyance") ? true : false,
                ],
                [
                    'attribute'=>'conveyancePerKM',
                    'visible' => ($model->conveyanceType == "Variable Conveyance") ? true : false,
                ],
            ],
        ]);

            ?>

</div>
