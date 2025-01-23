<?php

namespace app\controllers;

use Yii;
use app\models\PreinspectionClientRegion;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\PreinspectionClientCompany;
use app\models\PreinspectionClientBranch;

/**
 * PreinspectionClientDivisionController implements the CRUD actions for PreinspectionClientDivision model.
 */
class PreinspectionClientRegionController extends Controller
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
            'query' => PreinspectionClientRegion::find(),
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
        $model = new PreinspectionClientRegion();
        
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

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
                'company' => $company,
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
        //PreinspectionClientRegion::deleteAll(['id' => $id]);
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
        if (($model = PreinspectionClientRegion::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
