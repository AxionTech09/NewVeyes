<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use app\models\User;
use rmrevin\yii\fontawesome\FA;
use rmrevin\yii\fontawesome\FAS;
use rmrevin\yii\fontawesome\FAR;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Branch Executive User List';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="userdata-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Branch Executive User', ['create-bexecutiveuser'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,   
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            ['attribute' => 'roId','label'=>'RO Name',
                'value' => function ($model) {

                    $umodel=User::findOne($model->roId);
                    return $umodel->firstName;
            },],
            'firstName',
            'email',
            'mobile',
            [
                'attribute' => 'cityId',
                 'value' => function ($model) {

                    
                                if(isset($model->cityData->city))
                                {
                                       return  $model->cityData->city;
                                }
                                else { return '';}
                         },
            ],                   

            ['class' => 'yii\grid\ActionColumn',
             'template' => '{view}{update}{resetPassword}{delete}',  
               'buttons'  => [
                        'view'   => function ($url, $model) {
                            $url = Url::to(['user-data/view-bexecutiveuser', 'id' => $model->id]);                       
                            return Html::a(FA::icon('eye', ['class' => 'text-pink mr-5 mt-5']), $url, [
                                'title' => Yii::t('app', 'View'),
                            ]);
                        },
                        'update' => function ($url, $model) {
                            $url = Url::to(['user-data/update-bexecutiveuser', 'id' => $model->id]);
                            return Html::a(FA::icon('edit', ['class' => 'text-success mr-5 mt-5']), $url, [
                                'title' => Yii::t('app', 'Update'),
                            ]);
                        },
                        'resetPassword' => function ($url, $model) {
                            $role = array_keys(Yii::$app->authManager->getRolesByUser(Yii::$app->user->getId()))[0] ;
                            if ($role == 'Admin' || $role == 'Superadmin') {
                                $url = Url::to(['user-data/reset-password', 'id' => $model->id]);
                                return Html::a(FA::icon('key', ['class' => 'text-info mr-5 mt-5']), $url, [
                                    'title' => Yii::t('app', 'Reset Password'),
                                ]);
                            }
                        },
                        'delete' => function ($url, $model) {
                            return  Html::a(FA::icon('trash', ['class' => 'text-limered mr-5 mt-5']), ['user-data/delete-bexecutiveuser', 'id' => $model->id], [
                            'data'=>[
                                'method' => 'post',
                                'confirm' => 'Are you sure you want to delete this item?',
                            ]
                            ]);
                        },
                    ] 
           ],
        ],
    ]); ?>

</div>
