<?php

namespace app\controllers;

use Yii;
use app\models\MasterFieldexecutives;
use app\models\MasterCity;
use app\models\Retaildata;
use app\models\Preinspection;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * MasterFieldexecutivesController implements the CRUD actions for MasterFieldexecutives model.
 */
class MasterFieldexecutivesController extends Controller
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
     * Lists all MasterFieldexecutives models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => MasterFieldexecutives::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionAppointment()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => MasterFieldexecutives::find(),
            'pagination'=> false,
        ]);

        return $this->render('appointment', [
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function getAppointment($executiveId,$appointmentTime)
    {
        $tomoDate = date("Y-m-d", strtotime("tomorrow"));
        $val = '';
        if($appointmentTime == 9)
        { 
          $appointmentDateTime =  $tomoDate.' 09:00:00'; 
        }
        else if($appointmentTime == 10)
        {
          $appointmentDateTime =  $tomoDate.' 10:00:00'; 
        }
        $countRetail = Retaildata::find()
                ->where('valuatorName = :val1 AND customerAppointmentDateTime = :val2',['val1' =>$executiveId,'val2' => $appointmentDateTime])
                ->count();
        $retail = Retaildata::find()
                ->where('valuatorName = :val1 AND customerAppointmentDateTime = :val2',['val1' =>$executiveId,'val2' => $appointmentDateTime])
                ->all();
         if($countRetail>0){
                foreach($retail as $row){
                    $val .= 'Retail:'.$row->requestNo.' ';
                }
        }
        
        $countPre = Preinspection::find()
                ->where('surveyorName = :val1 AND customerAppointDateTime = :val2',['val1' =>$executiveId,'val2' => $appointmentDateTime])
                ->count();
        $pre = Preinspection::find()
                ->where('surveyorName = :val1 AND customerAppointDateTime = :val2',['val1' =>$executiveId,'val2' => $appointmentDateTime])
                ->all();
         if($countPre>0){
                foreach($pre as $row){
                    $val .= 'PI:'.$row->referenceNo.' ';
                }
        }
        return $val;
    }

    /**
     * Displays a single MasterFieldexecutives model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
    
    /**
     * Creates a new MasterFieldexecutives model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MasterFieldexecutives();
        
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
     * Updates an existing MasterFieldexecutives model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        
        $city = MasterCity::find()
                   ->all();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
                'city' => $city,
            ]);
        }
    }

    /**
     * Deletes an existing MasterFieldexecutives model.
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
     * Finds the MasterFieldexecutives model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MasterFieldexecutives the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MasterFieldexecutives::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
