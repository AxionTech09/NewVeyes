<?php

namespace app\controllers;

use Yii;
use app\models\PreinspectionClientBranch;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\PreinspectionClientCompany;
use app\models\PreinspectionClientDivision;

/**
 * PreinspectionClientBranchController implements the CRUD actions for PreinspectionClientBranch model.
 */
class PreinspectionClientBranchController extends Controller
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
     * Lists all PreinspectionClientBranch models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => PreinspectionClientBranch::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PreinspectionClientBranch model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
    
    public function actionDivisionlist($id)
    {
        $countPosts = PreinspectionClientDivision::find()
                ->where(['companyId' => $id])
                ->count();
 
        $posts = PreinspectionClientDivision::find()
                ->where(['companyId' => $id])
                ->orderBy('id DESC')
                ->all();
 
        if($countPosts>0){
            echo "<option value = ''>Select</option>";
            foreach($posts as $post){
                echo "<option value='".$post->id."'>".$post->divisionName."</option>";
            }
        }
        else{
            echo "<option value = ''>Select</option>";
        }
    }

    /**
     * Creates a new PreinspectionClientBranch model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new PreinspectionClientBranch();
        
        $company = PreinspectionClientCompany::find()
                   ->all();


        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
                'company' => $company,
            ]);
        }
    }

    /**
     * Updates an existing PreinspectionClientBranch model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        
        $company = PreinspectionClientCompany::find()
                   ->all();


        $division = PreinspectionClientDivision::find()
                ->where(['companyId' => $model->companyId])
                ->orderBy('divisionName')
                ->all();
                

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
                'company' => $company,
                'division' => $division,
            ]);
        }
    }

    /**
     * Deletes an existing PreinspectionClientBranch model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        //PreinspectionClientCaller::deleteAll(['branchId' => $id]);

        return $this->redirect(['index']);
    }

    /**
     * Finds the PreinspectionClientBranch model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PreinspectionClientBranch the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PreinspectionClientBranch::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
