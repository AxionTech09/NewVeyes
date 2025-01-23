<?php

namespace app\controllers;

use Yii;
use app\models\PreinspectionClientCaller;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\PreinspectionClientCompany;
use app\models\PreinspectionClientDivision;
use app\models\PreinspectionClientBranch;

/**
 * PreinspectionClientCallerController implements the CRUD actions for PreinspectionClientCaller model.
 */
class PreinspectionClientCallerController extends Controller
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
     * Lists all PreinspectionClientCaller models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => PreinspectionClientCaller::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PreinspectionClientCaller model.
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
                ->orderBy('divisionName')
                ->all();
 
        if($countPosts>0){
            foreach($posts as $post){
                echo "<option value = ''>Select</option>";
                echo "<option value='".$post->id."'>".$post->divisionName."</option>";
            }
        }
        else{
            echo "<option value = ''>Select</option>";
        }
    }
    
    public function actionBranchlist($id,$cid)
    {
        $countPosts = PreinspectionClientBranch::find()
                ->where(['companyId' => $cid])
                ->andFilterWhere(['divisionId' => $id])
                ->count();
 
        $posts = PreinspectionClientBranch::find()
                ->where(['companyId' => $cid])
                ->andFilterWhere(['divisionId' => $id])
                ->orderBy('branchName')
                ->all();
 
        if($countPosts>0){
            echo "<option value = ''>Select</option>";
            foreach($posts as $post){
                
                echo "<option value='".$post->id."'>".$post->branchName."</option>";
            }
        }
        else{
            echo "<option value = ''>Select</option>";
        }
    }

    /**
     * Creates a new PreinspectionClientCaller model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new PreinspectionClientCaller();
        
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
     * Updates an existing PreinspectionClientCaller model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        
        $division = PreinspectionClientDivision::find()
                ->where(['companyId' => $model->companyId])
                ->orderBy('divisionName')
                ->all();
        
        $branch = PreinspectionClientBranch::find()
                ->where(['divisionId' => $model->divisionId])
                ->orderBy('branchName')
                ->all();
 
        
        $company = PreinspectionClientCompany::find()
                   ->all();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
                'company' => $company,
                'division' => $division,
                'branch' => $branch,
            ]);
        }
    }

    /**
     * Deletes an existing PreinspectionClientCaller model.
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
     * Finds the PreinspectionClientCaller model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PreinspectionClientCaller the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PreinspectionClientCaller::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
