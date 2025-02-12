<?php

namespace app\controllers;

use Yii;
use app\models\MasterLocation;
use app\models\MasterCity;
use app\models\MasterTown;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * MasterLocationController implements the CRUD actions for MasterLocation model.
 */
class MasterLocationController extends Controller
{
    public function behaviors()
    {
        return [
             'access' => [
                'class' => AccessControl::className(),
                'only' => ['index','view','create','update','delete'],
                'rules' => [
                    [
                        'actions' => ['index','view','create','update','delete'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all MasterLocation models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => MasterLocation::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MasterLocation model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
    
    public function actionTownlist($id)
    {
        $countPosts = MasterTown::find()
                ->where(['cityId' => $id])
                ->count();
 
        $posts = MasterTown::find()
                ->where(['cityId' => $id])
                ->orderBy('town ASC')
                ->all();
 
        if($countPosts>0){
            echo "<option value = ''>Select</option>";
            foreach($posts as $post){
                echo "<option value='".$post->id."'>".$post->town."</option>";
            }
        }
        else{
            echo "<option value = ''>Select</option>";
        }
    }

    /**
     * Creates a new MasterLocation model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MasterLocation();
        
        $city = MasterCity::find()
                   ->all();
        

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
                'city' => $city,
            ]);
        }
    }

    /**
     * Updates an existing MasterLocation model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        
        $city = MasterCity::find()
                   ->all();
        
        $town = MasterTown::find()
                ->where(['cityId' => $model->cityId])
                ->orderBy('town')
                ->all();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
                'city' => $city,
                'town' => $town,
            ]);
        }
    }

    /**
     * Deletes an existing MasterLocation model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the MasterLocation model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MasterLocation the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MasterLocation::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
