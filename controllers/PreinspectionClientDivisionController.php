<?php

namespace app\controllers;

use Yii;
use app\models\PreinspectionClientDivision;
use app\models\PreinspectionClientRegion;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\PreinspectionClientCompany;

/**
 * PreinspectionClientDivisionController implements the CRUD actions for PreinspectionClientDivision model.
 */
class PreinspectionClientDivisionController extends Controller
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
     * Lists all PreinspectionClientDivision models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => PreinspectionClientDivision::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PreinspectionClientDivision model.
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
     * Creates a new PreinspectionClientDivision model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new PreinspectionClientDivision();
        
        $company = PreinspectionClientCompany::find()
                   ->all();

                   //Region load secion start
                   $region = PreinspectionClientRegion::find()
                   ->all();

                   if ($model->load(Yii::$app->request->post())) {
                    $postData = Yii::$app->request->post();
                    $companyId = $postData['PreinspectionClientDivision']['companyId'];
                    $regionId = $postData['PreinspectionClientDivision']['regionId'];
                    $divisionName = $postData['PreinspectionClientDivision']['divisionName'];
                    $divisionCode = $postData['PreinspectionClientDivision']['divisionCode'];
                    $model->companyId = $companyId;
                    $model->regionId = $regionId;
                    $model->divisionName = $divisionName;
                    $model->divisionCode = $divisionCode;

                    if ($model->save()) {
                        return $this->redirect(['index']);
                    } else {
                        echo 'Error -'.json_encode($model->getErrors()).'<br>';
                    }
        } else {
            return $this->render('create', [
                'model' => $model,
                'company' => $company,
                'region' => $region,
            ]);
        }
    }

    //
    public function actionDivisionlist($id)
    {
        $countPosts = PreinspectionClientRegion::find()
                ->where(['companyId' => $id])
                ->count();
 
        $posts = PreinspectionClientRegion::find()
                ->where(['companyId' => $id])
                ->orderBy('id DESC')
                ->all();
 
        if($countPosts>0){
            echo "<option value = ''>Select</option>";
            foreach($posts as $post){
                echo "<option value='".$post->id."'>".$post->regionName."</option>";
            }
        }
        else{
            echo "<option value = ''>Select</option>";
        }
    }
    /**
     * Updates an existing PreinspectionClientDivision model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
         $company = PreinspectionClientCompany::find()
                   ->all();
                   //Region load secion start
                   $region = PreinspectionClientRegion::find()->where(['companyId' => $model->companyId])
                   ->all();

                   //Region section End

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
                'company' => $company,
                'region' => $region,
            ]);
        }
    }

    /**
     * Deletes an existing PreinspectionClientDivision model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        PreinspectionClientBranch::deleteAll(['divisionId' => $id]);
        //PreinspectionClientCaller::deleteAll(['divisionId' => $id]);

        return $this->redirect(['index']);
    }

    /**
     * Finds the PreinspectionClientDivision model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PreinspectionClientDivision the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PreinspectionClientDivision::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}