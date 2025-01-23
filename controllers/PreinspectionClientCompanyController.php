<?php

namespace app\controllers;

use Yii;
use app\models\PreinspectionClientCompany;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\PreinspectionClientDivision;
use app\models\PreinspectionClientBranch;
use app\models\PreinspectionClientCaller;
use app\models\CompanyBillingDetails;

/**
 * PreinspectionClientCompanyController implements the CRUD actions for PreinspectionClientCompany model.
 */
class PreinspectionClientCompanyController extends Controller
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
     * Lists all PreinspectionClientCompany models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => PreinspectionClientCompany::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PreinspectionClientCompany model.
     * @param integer $id
     * @return mixed
     */
   public function actionView($id)
    {
        $model = $this->findModel($id);
        $searchModel = new CompanyBillingDetails();
        $query = CompanyBillingDetails::find()->where(['companyId'=>$id]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $this->render('view', [
            'model' => $model,
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel
        ]);
    }
    
    /**
     * Creates a new PreinspectionClientCompany model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
   public function actionCreate()
    {
        $model = new PreinspectionClientCompany();
        $post = Yii::$app->request->post();

        if ($model->load($post)) {
            if($model->save()){
                 \Yii::$app
                    ->db
                    ->createCommand()
                    ->delete('company_billing_details', ['companyId' => $model->id])
                    ->execute();
                    
                    $stateArr = (isset($post['PreinspectionClientCompany']) && isset($post['PreinspectionClientCompany']['stateArr'])) ? $post['PreinspectionClientCompany']['stateArr'] : '';

                    if($stateArr){
                        foreach($stateArr as $key => $val){
                        if ($val!='') {                            
                            $companyArr = (isset($post['PreinspectionClientCompany'])) ? $post['PreinspectionClientCompany'] : '';
                            $subModel = new CompanyBillingDetails();
                            $subModel->companyId = $model->id;
                            $subModel->stateId = $companyArr["stateArr"][$key];
                            $subModel->rate2Wheeler = $companyArr["rate2WheelerArr"][$key];
                            $subModel->rate3Wheeler = $companyArr["rate3WheelerArr"][$key];
                            $subModel->rate4Wheeler = $companyArr["rate4WheelerArr"][$key];
                            $subModel->rateCommercial = $companyArr["rateCommercialArr"][$key];
                            $subModel->rateConveyance = $companyArr["rateConveyanceArr"][$key];
                            $subModel->gstNo = $companyArr["gstNoArr"][$key];
                            $subModel->igst = $companyArr["igstArr"][$key];
                            $subModel->sgst = $companyArr["sgstArr"][$key];
                            $subModel->cgst = $companyArr["cgstArr"][$key];
                            $subModel->address = $companyArr["billingAddressArr"][$key];
                            $subModel->billingState = $companyArr["billingStateArr"][$key];
                            $subModel->save();
                        }
                    }
                }
                Yii::$app->session->setFlash('Success', 'Company Created Successfully..!');
            }
            else {
                foreach ($model->getErrors() as $errorMsg) {
                    Yii::$app->session->setFlash('Failure', $errorMsg[0]); 
                }
            }
            return $this->redirect(['index']);
        } 
        else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing PreinspectionClientCompany model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    
    public function actionUpdate($id)
    {
        $model = $this->findModel($id); 
        $post = Yii::$app->request->post();
        if ($model->load($post)) { 
            if ($model->save()) {
                \Yii::$app
                    ->db
                    ->createCommand()
                    ->delete('company_billing_details', ['companyId' => $model->id])
                    ->execute();
                    
                    $stateArr = (isset($post['PreinspectionClientCompany']) && isset($post['PreinspectionClientCompany']['stateArr'])) ? $post['PreinspectionClientCompany']['stateArr'] : '';

                    if ($stateArr) {
                        foreach($stateArr as $key => $val){
                        if ($val!='') {                            
                            $companyArr = (isset($post['PreinspectionClientCompany'])) ? $post['PreinspectionClientCompany'] : '';
                            $subModel = new CompanyBillingDetails();
                            $subModel->companyId = $model->id;
                            $subModel->stateId = $companyArr["stateArr"][$key];
                            $subModel->rate2Wheeler = $companyArr["rate2WheelerArr"][$key];
                            $subModel->rate3Wheeler = $companyArr["rate3WheelerArr"][$key];
                            $subModel->rate4Wheeler = $companyArr["rate4WheelerArr"][$key];
                            $subModel->rateCommercial = $companyArr["rateCommercialArr"][$key];
                            $subModel->rateConveyance = $companyArr["rateConveyanceArr"][$key];
                            $subModel->gstNo = $companyArr["gstNoArr"][$key];
                            $subModel->igst = $companyArr["igstArr"][$key];
                            $subModel->sgst = $companyArr["sgstArr"][$key];
                            $subModel->cgst = $companyArr["cgstArr"][$key];
                            $subModel->address = $companyArr["billingAddressArr"][$key];
                            $subModel->billingState = $companyArr["billingStateArr"][$key];
                            $subModel->save();
                        }
                    }
                }
                Yii::$app->session->setFlash('Success', 'Updated Successfully..!');
            }
            else {
                foreach ($model->getErrors() as $errorMsg) {
                    Yii::$app->session->setFlash('Failure', $errorMsg[0]); 
                }
            }
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    public function actionChangeStatus($id, $companyStatus)
    {
        $model = $this->findModel($id);
        $model->companyStatus = $companyStatus;

        if ($model->save(false)) {
            Yii::$app->session->setFlash('Success', 'Status Changed Successfully!');
            return $this->redirect(['index']);
        } else {
            Yii::$app->session->setFlash('Failure', 'Something Went Wrong!');
            return $this->redirect(['index']);
        }
    }

    /**
     * Deletes an existing PreinspectionClientCompany model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        PreinspectionClientDivision::deleteAll(['companyId' => $id]);
        PreinspectionClientBranch::deleteAll(['companyId' => $id]);
        //PreinspectionClientCaller::deleteAll(['companyId' => $id]);

        return $this->redirect(['index']);
    }

    /**
     * Finds the PreinspectionClientCompany model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PreinspectionClientCompany the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PreinspectionClientCompany::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
