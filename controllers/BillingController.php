<?php

namespace app\controllers;

use Yii;
use app\models\User;
use app\models\UserSearch;
use app\models\MasterCity;
use app\models\MasterState;
use app\models\PreinspectionClientCompany;
use app\models\PreinspectionClientDivision;
use app\models\PreinspectionClientBranch;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\widgets\ActiveForm;
use yii\web\Response;
use yii\rbac\DbManager;
use app\models\AxionPreinspection;
use app\models\AxionPreinspectionSearch;
use app\models\AxionPreinspectionBilling;
use app\models\AxionPreinspectionVehicle;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\db\Expression;
use \kartik\mpdf\Pdf;
use app\models\Remarks;
use yii2tech\spreadsheet\Spreadsheet;
use yii\data\ArrayDataProvider;
use app\models\CompanyBillingDetails;
use app\models\AxionPreinspectionHoBilling;
use app\models\AxionPreinspectionBillingSearch;
use app\models\HoRemarks;
use app\models\MasterSbuHead;
use app\helpers\SbuHelper;
use app\helpers\S3Helper;

ini_set('max_execution_time', '0');
ini_set('memory_limit', '-1');

/**
 * UserDataController implements the CRUD actions for User model.
 */
class BillingController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['corporate','state-level','mis-verification','mis-verification-admin','inspection-update','verify','verify-all','verify-selected','get-company-details','get-branches','edit-column'],
                'rules' => [
                    [
                        'actions' => ['corporate','state-level','mis-verification','mis-verification-admin','inspection-update','verify','verify-all','verify-selected','get-company-details','get-branches','edit-column'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],   
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'all-verify' => ['post','get'],
                ],
            ],         
        ];
    }

    /**
     * Lists all Preinspecton models.
     * @return mixed
     */
    public function actionCorporate()
    {

        $searchModel = new AxionPreinspectionSearch();
        $dataProvider = $searchModel->searchCorporate(Yii::$app->request->queryParams);
        if (Yii::$app->request->isPjax) {            
            return $this->renderAjax('corporate', [
                'dataProvider' => $dataProvider,
                'searchModel' => $searchModel
            ]);
        }else{ 
          if(!Yii::$app->request->queryParams){
            $dataProvider->totalCount = 0;
        }
        $searchModel->load(Yii::$app->request->queryParams);

        return $this->render('corporate', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel
        ]);
    }
    
}

    /**
     * Lists all Preinspection models.
     * @return mixed
     */
    public function actionStateLevel()
    {

        $searchModel = new AxionPreinspectionSearch();
        $dataProvider = $searchModel->searchStateLevel(Yii::$app->request->queryParams);

        return $this->render('state-level', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lists all Preinspecton models.
     * @return mixed
     */
    public function actionMisVerification()
    {
        $searchModel = new AxionPreinspectionBilling();
        $searchModel->scenario = 'search';
        $dataProvider = $searchModel->searchMisVerification(Yii::$app->request->queryParams);
        if (Yii::$app->request->isPjax) {      
            return $this->renderAjax('mis-verification', [
                'dataProvider' => $dataProvider,
                'searchModel' => $searchModel
            ]);
        }else{             
            $searchModel->load(Yii::$app->request->queryParams);

            return $this->render('mis-verification', [
                'dataProvider' => $dataProvider,
                'searchModel' => $searchModel
            ]);

        }
        
    } 


    /**
     * Lists all Preinspecton models.
     * @return mixed
     */
    public function actionMisVerificationAdmin()
    {

        $searchModel = new AxionPreinspectionBilling();
        $searchModel->scenario = 'search';
        $dataProvider = $searchModel->searchMisVerificationAdmin(Yii::$app->request->queryParams);
        $dataProvider->totalCount = count($dataProvider->getModels());

        //echo $dataProvider->totalCount;exit;
        if (Yii::$app->request->isPjax) {      
            return $this->renderAjax('mis-verification-admin', [
                'dataProvider' => $dataProvider,
                'searchModel' => $searchModel
            ]);
        }else{             
            $searchModel->load(Yii::$app->request->queryParams);

            return $this->render('mis-verification-admin', [
                'dataProvider' => $dataProvider,
                'searchModel' => $searchModel
            ]);

        }
        
    }

    public function actionInspectionUpdate($id){
        $model = $this->findInspection($id);
        $model->scenario='update';

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            $model->save();
            return json_encode(['status'=>'success','msg'=>'Success']);
        }else{
            return $this->renderAjax('inspection-update', [
                'model' => $model
            ]);
        }

    }

    public function actionEditColumn() {

        if (isset($_POST['hasEditable'])) {
            $model = $this->findInspection($_POST['editableKey']);
            $model->scenario = 'billingUpdate';
            $column = $_POST['editableAttribute'];
            $value = '';

            if(isset($_POST['AxionPreinspection'])){
                foreach($_POST['AxionPreinspection'] as $row){
                    if(isset($row[$column])){
                        $value = $row[$column];
                    }
                }
            }

            if(isset($value)){
                if ($column == 'paymentMode' || $column == 'extraKM') {
                    $vehicleDetails = AxionPreinspectionVehicle::findOne(['preinspection_id' => $model->id]);
                    
                    $billingRow = AxionPreinspectionBilling::findOne(['id' => $model->billId]);
                    $billDetails = json_decode($billingRow->billDetails);

                    if (!empty($billingRow->parentId)) {
                        $billingParentRow = AxionPreinspectionBilling::findOne(['id' => $billingRow->parentId]);
                        $billParentDetails = json_decode($billingParentRow->billDetails);
                    }

                    if ($column == 'paymentMode' && $value == 2) {
                        switch ($vehicleDetails->vType) {
                            case '4-WHEELER':
                                $billDetails->total4W -= 1;
                                if (!empty($billParentDetails)) {
                                    $billParentDetails->total4W -= 1;
                                }
                                break;
                            case '3-WHEELER':
                                $billDetails->total3W -= 1;
                                if (!empty($billParentDetails)) {
                                    $billParentDetails->total3W -= 1;
                                }
                                break;
                            case '2-WHEELER':
                                $billDetails->total2W -= 1;
                                if (!empty($billParentDetails)) {
                                    $billParentDetails->total2W -= 1;
                                }
                                break;
                            case 'COMMERCIAL':
                                $billDetails->totalCW -= 1;
                                if (!empty($billParentDetails)) {
                                    $billParentDetails->totalCW -= 1;
                                }
                                break;   
                        }

                        if (trim($model->extraKM) > 0) {
                            $billDetails->totalKm -= trim($model->extraKM);
                            if (!empty($billParentDetails)) {
                                $billParentDetails->totalKm -= trim($model->extraKM);
                            }
                        }   
                        
                        // Remove billing details
                        $model->billId = 0;
                        $model->billStatus = '';
                    }

                    else if ($column == 'extraKM') {

                        if ($model->insurerName == 10) {
                            if ($value >= 50 && $model->extraKM < 50) {
                                // Here addition or subtraction will happen depends on $model->extraKM value
                                $billDetails->totalKm += $value;
            
                                if (!empty($billParentDetails)) {
                                    $billParentDetails->totalKm += $value;
                                }
                            }
                            else if ($value < 50 && $model->extraKM >= 50) {
                                $updatedExtraKM = -$model->extraKM;
                                
                                // Here addition or subtraction will happen depends on $model->extraKM value
                                $billDetails->totalKm += $updatedExtraKM;
            
                                if (!empty($billParentDetails)) {
                                    $billParentDetails->totalKm += $updatedExtraKM;
                                }
                            }
                            else if ($value >= 50 && $model->extraKM >= 50) {
                                $updatedExtraKM = trim($value) - trim($model->extraKM);
            
                                // Here addition or subtraction will happen depends on $model->extraKM value
                                $billDetails->totalKm += $updatedExtraKM;
            
                                if (!empty($billParentDetails)) {
                                    $billParentDetails->totalKm += $updatedExtraKM;
                                }
                            }
                        }
                        else {

                            $extraKM = $value - trim($model->extraKM);

                            // Here addition or subtraction will happen depends on $extraKM value
                            $billDetails->totalKm += $extraKM;

                            if (!empty($billParentDetails)) {
                                $billParentDetails->totalKm += $extraKM;
                            }
                        }
                        
                    }

                    $billingRow->billDetails = json_encode($billDetails);
                    $billingRow->save();

                    if (!empty($billParentDetails)) {
                        $billingParentRow->billDetails = json_encode($billParentDetails);
                        $billingParentRow->save();
                    }
                }
                $model->$column = $value;
                $model->save();
            }
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

            return ['output'=>$value, 'message'=>''];
        }
        else {
            return ['output'=>'', 'message'=>''];
        }

        return $this->redirect('/billing/mis-verification');
    }

    public function actionVerify($id){
        $model = $this->findInspection($id);

        $model->billStatus = "Verified";
        if($model->save()){
            $statusArr = ["Verified"];
            $inspection = AxionPreinspection::find()->where(["billId"=>$model->billId])->andWhere(["NOT IN","billStatus",$statusArr])->all();
            if(!$inspection || empty($inspection)){
                $myRawSql=   Yii::$app->db->createCommand()->update('axion_preinspection_billing', ["billStatus"=> "Verified"],["id"=>$model->billId])->execute();
            }
            $parentId = (isset($model->bill) && isset($model->bill->parentId)) ?$model->bill->parentId:"";

            if($parentId){
                $exist = AxionPreinspectionBilling::find()->where(["billStatus" => 'Initiated',"parentId"=>$parentId])->one();
                if(!$exist){
                    $billModel = AxionPreinspectionBilling::findOne(['id'=>$parentId]);
                    $billModel->billStatus="Verified";
                    $billModel->save();
                }
            }
        }
        
        //return $this->redirect('/billing/mis-verification');
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionVerifyAll($ids){

        $data = ($ids) ? json_decode($ids) : '';
        $billIds=[];

        if ($data) {
            foreach ($data as $row => $val) {
                $model = $this->findInspection($val);
                $billIds[] = $model->billId;
                
                Yii::$app->db->createCommand()->update('axion_preinspection', ["billStatus"=> "Verified"], ["id" => $model->id, "billStatus" => "Initiated"])->execute();   
            }
            if ($billIds) {
                $arr = array_unique($billIds);
                if ($arr) {
                    $uniqueIds = implode(',', $arr);
                    Yii::$app->db->createCommand()->update('axion_preinspection_billing', ["billStatus"=> "Verified"], "`id` IN ($uniqueIds) AND `billStatus` = 'Initiated'")->execute();

                    foreach ($arr as $val) {
                        $model = AxionPreinspectionBilling::findOne(['id'=>$val]);
                        $parentId = (isset($model->parentId) && isset($model->parentId)) ?$model->parentId:"";
                        if ($parentId) {
                            $exist = AxionPreinspectionBilling::find()->where(["billStatus" => 'Initiated', "parentId" => $parentId])->andWhere(["REGEXP", "billDetails", ':[1-9]|:"[1-9]'])->one();
                            
                            if (!$exist) {
                                $billModel = AxionPreinspectionBilling::findOne(['id' => $parentId, "billStatus" => 'Initiated']);
                                
                                if ($billModel) {
                                    $billModel->billStatus = "Verified";
                                    $billModel->save();
                                }
                            }
                        }
                    }
                }

            }

        } 

        Yii::$app->session->setFlash('Success', 'Cases verified successfully..!');
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionVerifySelected(){    
        $post = Yii::$app->request->post();
        if ($post && isset($post['ids'])) {
            $ids = $post['ids'];
            $sql = "UPDATE axion_preinspection SET billStatus = 'Verified' WHERE id IN ($ids) AND `billStatus` = 'Initiated'";
            Yii::$app->db->createCommand($sql)->execute();

            if ($ids) {
                $idArr = explode(",", $ids);

                foreach ($idArr as $val) {
                    $inspectionModel = AxionPreinspection::findOne(['id'=>$val]);

                    //$model = AxionPreinspectionBilling::findOne(['id'=>$val]);
                    $statusArr = ["Verified"];
                    $inspection = AxionPreinspection::find()->where(["billId"=>$inspectionModel->billId])->andWhere(["NOT IN", "billStatus", $statusArr])->all();
                    
                    // If all cases verified for a particular billId
                    if (!$inspection || empty($inspection)) {
                        $myRawSql = Yii::$app->db->createCommand()->update('axion_preinspection_billing', ["billStatus" => "Verified"],["id" => $inspectionModel->billId])->execute();
                    }
                    
                    $parentId = (isset($inspectionModel->bill) && isset($inspectionModel->bill->parentId)) ? $inspectionModel->bill->parentId : "";

                    if ($parentId) {
                        $exist = AxionPreinspectionBilling::find()->where(["parentId" => $parentId])->andWhere(["IN", "billStatus", ["Initiated", "Billed"]])->one();
                        if (!$exist) {
                            $billModel = AxionPreinspectionBilling::findOne(['id'=>$parentId]);
                            $billModel->billStatus = "Verified";
                            $billModel->save();
                        }
                    }
                }
                
            }

        } 
        
        Yii::$app->session->setFlash('Success', 'Case(s) verified successfully..!');
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionGetCompanyDetails(){    
        $post = Yii::$app->request->post();
        if($post && isset($post['companyId'])){
            $id = $post['companyId'];
            $model = PreinspectionClientCompany::find()->where(['id'=>$id])->one();
            $result=[];
            if($model){
                $result = ["result" => "success","billType" => $model->billType];
            }else{
                $result = ["result" => "error"];
            }
            return json_encode($result);
        } 
        
    }


    /**
     * Finds the Preinspection model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Preinspection the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findInspection($id)
    {
        if (($model = AxionPreinspection::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    // THE CONTROLLER
    public function actionGetBranches() {  
        $companyId = (isset($_POST['companyId']) && $_POST['companyId']) ? $_POST['companyId'] : '';
        $branchId = (isset($_POST['branchId']) && $_POST['branchId']) ? $_POST['branchId'] : '';
        $result='error';

        //$res = PreinspectionClientBranch::find()->where(['companyId' => $companyId])->asArray()->all();
        $query = PreinspectionClientBranch::find();
        $option = '<option value="">Choose Branch</option>';
        if($companyId){
            $query->where(['companyId' => $companyId]); 
            $res = $query->asArray()->all();
            if($res){
                $result='success';
                foreach($res as $row => $val){
                    $id = $val['id'];
                    $name = $val['branchName'];
                    if($id == $branchId){
                        $option .= '<option value="'.$id.'" selected="selected">'.$name.'</option>';
                    }else{
                        $option .= '<option value="'.$id.'">'.$name.'</option>';

                    }
                    
                }
            }
        }
        return json_encode(['result'=>$result, 'data'=>$option]);
        //echo $option;exit;
        
    }

    public function getBranchList($companyId){
        $cats = PreinspectionClientBranch::find()->where(['companyId' => $companyId])->select(['id','branchName as name'])->asArray()->all();
        Yii::$app->response->format = Response::FORMAT_JSON;
        return $cats;
    }

    /**
     * Lists all Preinspecton models.
     * @return mixed
     */
    public function actionSummary()
    {
        $searchModel = new AxionPreinspectionBillingSearch();
        $searchModel->scenario = 'search';
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $company = PreinspectionClientCompany::find()
            ->where(['companyStatus' => 'Active'])->all();

        $states = MasterState::find()
            ->where(['stateStatus' => 'Active'])->all();

        $sbuHead = MasterSbuHead::find()
            ->where(['sbuHeadStatus' => 'Active'])->all();

        $params = Yii::$app->request->getQueryParams();

        if(isset($params['AxionPreinspectionBillingSearch']['branchId']))
        {
            $branch = PreinspectionClientBranch::find()
            ->where(['companyId' => $params['AxionPreinspectionBillingSearch']['companyId']])
            ->all();
        }
        
        if (Yii::$app->request->isPjax)
        {      
            return $this->renderAjax('summary', [
                'dataProvider' => $dataProvider,
                'searchModel' => $searchModel,
                'company' => $company,
                'states' => $states,
                'branch' => $branch,
                'sbuHead' => $sbuHead,
            ]);
        }
        else
        {             
            $searchModel->load(Yii::$app->request->queryParams);

            return $this->render('summary', [
                'dataProvider' => $dataProvider,
                'searchModel' => $searchModel,
                'company' => $company,
                'states' => $states,
                'branch' => $branch,
                'sbuHead' => $sbuHead,
            ]);

        }
        
    } 

  // THE CONTROLLER
    public function actionGetDivisions() {  
        $companyId = (isset($_POST['companyId']) && $_POST['companyId']) ? $_POST['companyId'] : '';
        $divisionId = (isset($_POST['divisionId']) && $_POST['divisionId']) ? $_POST['divisionId'] : '';
        $result='error';
        $query = PreinspectionClientDivision::find();
        $option = '<option value="">Choose State</option>';
        if($companyId){
            $query->where(['companyId' => $companyId]); 
            $res = $query->asArray()->all();
            if($res){
                $result='success';
                foreach($res as $row => $val){
                    $id = $val['id'];
                    $name = $val['divisionName'];
                    if($id==$divisionId){
                        $option .= '<option value="'.$id.'" selected="selected">'.$name.'</option>';
                    }else{
                        $option .= '<option value="'.$id.'">'.$name.'</option>';
                    }
                    
                }
            }
        }
        return json_encode(['result'=>$result, 'data'=>$option]);                 
    }


    public function actionGetStates() {  
        $companyId = (isset($_POST['companyId']) && $_POST['companyId']) ? $_POST['companyId'] : '';
        $stateId = (isset($_POST['stateId']) && $_POST['stateId']) ? $_POST['stateId'] : '';
        $result='error';
        $query = MasterState::find();
        $option = '<option value="">Choose State</option>';
        if($companyId){
        //$query->where(['companyId' => $companyId]); 
            $res = $query->asArray()->all();
            if($res){
                $result='success';
                foreach($res as $row => $val){
                    $id = $val['id'];
                    $name = $val['state'];
                    if($id==$stateId){
                        $option .= '<option value="'.$id.'" selected="selected">'.$name.'</option>';
                    }else{
                        $option .= '<option value="'.$id.'">'.$name.'</option>';
                    }
                    
                }
            }
        }
        return json_encode(['result'=>$result, 'data'=>$option]);                 
    }

    
    public function actionBillGenerate($id) {

        $billModel = $this->findModel($id);
        if ($billModel) {
            $parent = "";

            if (!in_array($billModel->billType, ['State Bill', 'Branch Bill', 'SBU Bill']) && $billModel->parentId == ""){
                $arr = AxionPreinspectionBilling::find()->where(['parentId'=>$billModel->id])->all();
                $parent=true;
            }
            else {
                $arr = AxionPreinspectionBilling::find()->where(['id'=>$billModel->id])->all();
            }

            $grandBillAmount = $grandTotalGst = $grandTotalAmount = $grandAmount2Wheeler = $grandAmount3Wheeler = 0;
            $grandAmount4Wheeler = $grandAmountCommmercial = $grandAmountTotalKm = 0;
            $grandTotalIgst = $grandTotalCgst = $grandTotalSgst = 0;

            foreach ($arr as $model) {
                $billDetails = json_decode($model->billDetails);

                if ($model->billType == "State Bill" || $model->billType == "SBU Bill" || ($model->companyId == 10 && !empty($model->stateId)) ) {
                    $company = CompanyBillingDetails::find()->where(['companyId'=>$model->companyId, 'stateId'=>$model->stateId])->one();
                }
                else {
                    $company = PreinspectionClientCompany::findOne(['id' => $model->companyId]);
                }

                // For ITGI
                if ($model->companyId == 9)
                {
                    $rate2Wheeler = $company->rate2Wheeler * $billDetails->total2W;
                    $rate3Wheeler = $company->rate3Wheeler * $billDetails->total3W;
                }
                else
                {
                    $rate2Wheeler = 0;
                    $rate3Wheeler = 0;
                }
                
                $rate4Wheeler = $company->rate4Wheeler * $billDetails->total4W;
                $rateCommmercial = $company->rateCommercial * $billDetails->totalCW;
                $rateTotalKm = $company->rateConveyance * $billDetails->totalKm;

                $total = $rate2Wheeler + $rate3Wheeler + $rate4Wheeler + $rateCommmercial + $rateTotalKm;
                
                $totalIgst = $totalCgst = $totalSgst = 0;
                if ($company->billingState == 2) {
                    $totalSgst = ($total * $company->sgst ) / 100;
                    $totalCgst = ($total * $company->cgst ) / 100;
                }
                else {
                    $totalIgst = ($total * $company->igst ) / 100;
                }

                $totalGst = $totalIgst + $totalSgst + $totalCgst;
                $totalAmount = $total + $totalGst;

                if ($model->billStatus != "Billed") { 
                    $grandBillAmount += $total;
                    $grandTotalIgst += $totalIgst;
                    $grandTotalCgst += $totalCgst;
                    $grandTotalSgst += $totalSgst;
                    $grandTotalGst += $totalGst;
                    $grandTotalAmount += $totalAmount;
                    $grandAmount2Wheeler += $rate2Wheeler;
                    $grandAmount3Wheeler += $rate3Wheeler;
                    $grandAmount4Wheeler += $rate4Wheeler;
                    $grandAmountCommmercial += $rateCommmercial;
                    $grandAmountTotalKm += $rateTotalKm;

                    $model->billAmount = $total;
                    $model->totalIgst = $totalIgst;
                    $model->totalSgst = $totalSgst;
                    $model->totalCgst = $totalCgst;
                    $model->totalGst = $totalGst;
                    $model->totalAmount = $totalAmount;
                    $model->amount2Wheeler = $rate2Wheeler;
                    $model->amount3Wheeler = $rate3Wheeler;
                    $model->amount4Wheeler = $rate4Wheeler;
                    $model->amountCommmercial = $rateCommmercial;
                    $model->amountTotalKm = $rateTotalKm;
                    $model->billStatus = 'Billed';
                    $model->generatedBy = Yii::$app->user->identity->id; 
                    $model->generatedDate = date('Y-m-d');

                    if (in_array($billModel->billType, ['State Bill', 'Branch Bill', 'SBU Bill'])) {
                        $idNumber = $this->getBillNo();
                        if($idNumber <= 999){
                            $runningNo = str_pad($idNumber, 3, '0', STR_PAD_LEFT);
                        }else{
                            $runningNo = $idNumber;
                        }
                        $model->orderNo = $idNumber;
                        // $idNumber = ($model->orderNo<10) ? '0'.$idNumber : $idNumber;

                        // Get financial year
                        $currentYear = date('y', strtotime('-3 months'));
                        $nextYear = $currentYear + 1;
                        $billNumber = '0101-'.$currentYear.'-'.$nextYear.'-'.$runningNo;
                        $model->billNumber = $billNumber;
                    }
                    
                    if($model->save()){
                        //Generate Reports
                        $this->saveMis($model->id);
                        $this->savePdf($model->id);

                        Yii::$app->db->createCommand()->update('axion_preinspection', ["billStatus"=> "Billed"], ["billId" => $model->id])->execute();
                    }
                }
                else {
                    $grandBillAmount += $model->billAmount;
                    $grandTotalIgst += $model->totalIgst;
                    $grandTotalCgst += $model->totalCgst;
                    $grandTotalSgst += $model->totalSgst;
                    $grandTotalGst += $model->totalGst;
                    $grandTotalAmount += $model->totalAmount;
                    $grandAmount2Wheeler += $model->amount2Wheeler;
                    $grandAmount3Wheeler += $model->amount3Wheeler;
                    $grandAmount4Wheeler += $model->amount4Wheeler;
                    $grandAmountCommmercial += $model->amountCommmercial;
                    $grandAmountTotalKm += $model->amountTotalKm;
                }

                if ($model->parentId != "") {
                    $exist = AxionPreinspectionBilling::find()->where(['parentId'=>$model->parentId])->andWhere("billStatus <> 'Billed'")->one();

                    $parentModel = AxionPreinspectionBilling::find()->where(['id'=>$model->parentId])->one();

                    if (!$exist) {
                        $res = AxionPreinspectionBilling::find()->where(['parentId'=>$model->parentId])->select([
                            new Expression('SUM(billAmount) as billAmount'),new Expression('SUM(totalGst) as totalGst'),
                            new Expression('SUM(totalAmount) as totalAmount'),new Expression('SUM(amount2Wheeler) as amount2Wheeler'),
                            new Expression('SUM(amount3Wheeler) as amount3Wheeler'),new Expression('SUM(amount4Wheeler) as amount4Wheeler'),
                            new Expression('SUM(amountCommmercial) as amountCommmercial'),new Expression('SUM(amountTotalKm) as amountTotalKm')])->one();
                        
                        $idNumber = $this->getBillNo();
                        if($idNumber <= 999){
                            $runningNo = str_pad($idNumber, 3, '0', STR_PAD_LEFT);
                        }else{
                            $runningNo = $idNumber;
                        }
                        $parentModel->orderNo = $idNumber;
                        // $idNumber = ($parentModel->orderNo < 10) ? '0'.$idNumber : $idNumber;

                        // Get financial year
                        $currentYear = date('y', strtotime('-3 months'));
                        $nextYear = $currentYear + 1;
                        $billNumber = '0101-'.$currentYear.'-'.$nextYear.'-'.$runningNo;
                        $parentModel->billNumber = $billNumber;
                        $parentModel->billAmount = $res->billAmount;
                        $parentModel->totalGst = $res->totalGst;
                        $parentModel->totalAmount = $res->totalAmount;
                        $parentModel->amount2Wheeler = $res->amount2Wheeler;
                        $parentModel->amount3Wheeler = $res->amount3Wheeler;
                        $parentModel->amount4Wheeler = $res->amount4Wheeler;
                        $parentModel->amountCommmercial = $res->amountCommmercial;
                        $parentModel->amountTotalKm = $res->amountTotalKm;
                        $parentModel->billStatus = "Billed";
                        $parentModel->generatedBy = Yii::$app->user->identity->id; 
                        $parentModel->generatedDate = date('Y-m-d');   

                        $parentModel->save();

                        //Generate Reports
                        $this->saveMis($parentModel->id);
                        $this->savePdf($parentModel->id);

                        Yii::$app->db->createCommand()->update('axion_preinspection_billing', 
                            ["orderNo"=> $parentModel->orderNo, "billNumber" => $parentModel->billNumber], 
                            ["parentId" => $parentModel->id])->execute();
                    }
                    else {
                        $parentModel->billAmount += $grandBillAmount;
                        $parentModel->totalIgst += $grandTotalIgst;
                        $parentModel->totalCgst += $grandTotalCgst;
                        $parentModel->totalSgst += $grandTotalSgst;
                        $parentModel->totalGst += $grandTotalGst;
                        $parentModel->totalAmount += $grandTotalAmount;
                        $parentModel->amount2Wheeler += $grandAmount2Wheeler;
                        $parentModel->amount3Wheeler += $grandAmount3Wheeler;
                        $parentModel->amount4Wheeler += $grandAmount4Wheeler;
                        $parentModel->amountCommmercial += $grandAmountCommmercial;
                        $parentModel->amountTotalKm += $grandAmountTotalKm;

                        $parentModel->save();

                        //Generate Reports
                        $this->saveMis($parentModel->id);
                        $this->savePdf($parentModel->id);
                    }
                }

            }

            if ($parent) {
                $billModel = $this->findModel($id);

                if (empty($billModel->billNumber)) {                    
                    $idNumber = $this->getBillNo();
                    if($idNumber <= 999){
                        $runningNo = str_pad($idNumber, 3, '0', STR_PAD_LEFT);
                    }else{
                        $runningNo = $idNumber;
                    }
                    $billModel->orderNo = $idNumber;
                    // $idNumber = ($billModel->orderNo < 10) ? '0'.$idNumber : $idNumber;
                    // Get financial year
                    $currentYear = date('y', strtotime('-3 months'));
                    $nextYear = $currentYear + 1;
                    $billNumber = '0101-'.$currentYear.'-'.$nextYear.'-'.$runningNo;
                    $billModel->billNumber = $billNumber;

                    Yii::$app->db->createCommand()->update('axion_preinspection_billing', 
                    ["orderNo"=> $billModel->orderNo, "billNumber" => $billModel->billNumber], 
                    ["parentId" => $billModel->id])->execute();
                }
                
                $billModel->billAmount = $grandBillAmount;
                $billModel->totalIgst = $grandTotalIgst;
                $billModel->totalCgst = $grandTotalCgst;
                $billModel->totalSgst = $grandTotalSgst;
                $billModel->totalGst = $grandTotalGst;
                $billModel->totalAmount = $grandTotalAmount;
                $billModel->amount2Wheeler = $grandAmount2Wheeler;
                $billModel->amount3Wheeler = $grandAmount3Wheeler;
                $billModel->amount4Wheeler = $grandAmount4Wheeler;
                $billModel->amountCommmercial = $grandAmountCommmercial;
                $billModel->amountTotalKm = $grandAmountTotalKm;
                $billModel->billStatus = "Billed";
                $billModel->generatedBy = Yii::$app->user->identity->id; 
                $billModel->generatedDate = date('Y-m-d');
                
                $billModel->save();

                //Generate Reports
                $this->saveMis($billModel->id);
                $this->savePdf($billModel->id);
            }
        }

        return $this->redirect('mis-verification-admin');
    }

     /**
     * Finds the Preinspection model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Preinspection the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AxionPreinspectionBilling::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

     /**
     * Lists all Preinspecton models.
     * @return mixed
     */
    public function actionDownloadPdf($id=false)
    {
        $id = isset($_GET['billId']) ? $_GET['billId'] : '';
        $model = $this->findModel($id);
        $date = date('M y',strtotime($model->billPeriodFrom));
        $billType = $model->callerCompany->billType;
        $company =  $model->callerCompany;
        $companyName =  $model->callerCompany->companyName;

        $fileName = $model->billNumber."-".$date;
        if ($billType == "State Bill" || $billType == "SBU Bill") {
            $company = CompanyBillingDetails::find()->where(['companyId'=>$model->companyId, 'stateId'=>$model->stateId])->one();
            if (!$company) {
                $company =  $model->callerCompany;
            }
            $stateName = $model->state->state;
            $fileName = $fileName." ".ucwords($stateName);
        }
        $companyAddress = (isset($company->billingAddress)) ? $company->billingAddress : ((isset($company->address)) ? $company->address : '');
        
        $content = $this->renderPartial('_billSummary', ['model' => $model,'company'=>$company,"companyName"=>$companyName,"companyAddress"=>$companyAddress]);
        
        $footer = '<p class="text-center">New No.2, Old No.L2/806, 48th Cross Street, Thiruvalluvar Nagar, Thiruvanmiyur, chennai 600041.</p>';
        $header = '<div class="text-right header-section clearfix">
                        <img src="images/Axion_logo_sm.png" class="pull-left header-logo" alt="header-logo" width="60" height="60">
                        <h4 class="header-text pull-right">Axion Technical <br> Services Pvt Ltd</h4>
                    </div>';

        // setup kartik\mpdf\Pdf component
        $pdf = new Pdf([
            // set to use core fonts only
            'mode' => Pdf::MODE_UTF8, 

            'filename' => $fileName.".pdf",
            // A4 paper format
            'format' => Pdf::FORMAT_A4, 
            // portrait orientation
            'orientation' => Pdf::ORIENT_PORTRAIT, 
            // stream to browser inline
            'destination' => Pdf::DEST_BROWSER, 
            // your html content input
            'content' => $content,  
            // format content from your own css file if needed or use the
            // enhanced bootstrap css built by Krajee for mPDF formatting 
            // any css to be embedded if required
            'cssInline' => '', 
             // set mPDF properties on the fly
            'options' => ['title' => '', 'defaultheaderline' => 0,],

            'cssFile' => ['@app/css/bootstrap.min.css', '@app/css/pdf.css'],
             // call mPDF methods on the fly
            'methods' => [ 
                'SetHeader' => $header, 
                'SetFooter' => $footer,
            ]
        ]);

        return $pdf->render(); 
        
    }

    private function savePdf($id)
    {
        $model = $this->findModel($id);
        $date = date('M y',strtotime($model->billPeriodFrom));
        $billType = $model->callerCompany->billType;
        $company =  $model->callerCompany;
        $companyName =  $model->callerCompany->companyName;

        $fileName = $model->billNumber."-".$date;
        if ($billType == "State Bill" || $billType == "SBU Bill") {
            $company = CompanyBillingDetails::find()->where(['companyId'=>$model->companyId, 'stateId'=>$model->stateId])->one();
            if (!$company) {
                $company =  $model->callerCompany;
            }
            $stateName = $model->state->state;
            $fileName = $fileName." ".ucwords($stateName);
        }
        $companyAddress = (isset($company->billingAddress)) ? $company->billingAddress : ((isset($company->address)) ? $company->address : '');
        
        $content = $this->renderPartial('_billSummary', ['model' => $model,'company'=>$company,"companyName"=>$companyName,"companyAddress"=>$companyAddress]);
        
        $footer = '<p class="text-center">New No.2, Old No.L2/806, 48th Cross Street, Thiruvalluvar Nagar, Thiruvanmiyur, chennai 600041.</p>';
        $header = '<div class="text-right header-section clearfix">
                        <img src="images/Axion_logo_sm.png" class="pull-left header-logo" alt="header-logo" width="60" height="60">
                        <h4 class="header-text pull-right">Axion Technical <br> Services Pvt Ltd</h4>
                    </div>';

        // setup kartik\mpdf\Pdf component
        $pdf = new Pdf([
            // set to use core fonts only
            'mode' => Pdf::MODE_UTF8, 

            'filename' => $fileName.".pdf",
            // A4 paper format
            'format' => Pdf::FORMAT_A4, 
            // portrait orientation
            'orientation' => Pdf::ORIENT_PORTRAIT, 
            // stream to browser inline
            'destination' => Pdf::DEST_BROWSER, 
            // your html content input
            'content' => $content,  
            // format content from your own css file if needed or use the
            // enhanced bootstrap css built by Krajee for mPDF formatting 
            // any css to be embedded if required
            'cssInline' => '', 
             // set mPDF properties on the fly
            'options' => ['title' => '', 'defaultheaderline' => 0,],

            'cssFile' => ['@app/css/bootstrap.min.css', '@app/css/pdf.css'],
             // call mPDF methods on the fly
            'methods' => [ 
                'SetHeader' => $header, 
                'SetFooter' => $footer,
            ]
        ]);

        $content = $pdf->content;
        $file = \Yii::$app->params['billingLoc'].'pdf/'.$model->billNumber."-".$date.'.pdf';
        $path = $pdf->Output($content, $file, \Mpdf\Output\Destination::FILE);
        
        return $path;
    }

    public function actionBillUpdate($id){
        $model = $this->findModel($id);
        //$model->scenario='update';
        //echo '<pre>';print_r($model);exit;
        if (Yii::$app->request->isAjax && Yii::$app->request->post()) {
            $billing = (isset(Yii::$app->request->post()['AxionPreinspectionBilling'])) ? Yii::$app->request->post()['AxionPreinspectionBilling'] : '';

            if(isset($billing['totalEast4W']) && isset($billing['totalEastCW'])){
                $arr = [
                    "totalKm" => isset($billing['totalKm']) ? $billing['totalKm'] : 0,
                    "total2W" => isset($billing['total2W']) ? $billing['total2W'] : 0,
                    "total3W" => isset($billing['total3W']) ? $billing['total3W'] : 0,
                    "total4W" => isset($billing['total4W']) ? $billing['total4W'] : 0,
                    "totalCW" => isset($billing['totalCW']) ? $billing['totalCW'] : 0,
                    "totalEast4W" => isset($billing['totalEast4W']) ? $billing['totalEast4W'] : 0,
                    "totalEastCW" => isset($billing['totalEastCW']) ? $billing['totalEastCW'] : 0,
                ];
            }else{
                $arr = [
                    "totalKm" => isset($billing['totalKm']) ? $billing['totalKm'] : 0,
                    "total2W" => isset($billing['total2W']) ? $billing['total2W'] : 0,
                    "total3W" => isset($billing['total3W']) ? $billing['total3W'] : 0,
                    "total4W" => isset($billing['total4W']) ? $billing['total4W'] : 0,
                    "totalCW" => isset($billing['totalCW']) ? $billing['totalCW'] : 0,
                ];
            }

            $model->billAmount = (isset($billing['totalAmount'])) ? $billing['totalAmount'] : 0;
            $model->totalGst = (isset($billing['totalGst'])) ? $billing['totalGst'] : 0;
            $model->totalAmount = (isset($billing['overallAmount'])) ? $billing['overallAmount'] : 0;          
            $model->billDetails = json_encode($arr);  
            $model->manualUpdate = "Y";            
            $model->save();
            return json_encode(['status'=>'success','msg'=>'Success']);
        }else{
            return $this->renderAjax('bill-update', [
                'model' => $model
            ]);
        }

    }
    
    /**
     * Lists all Preinspection models.
     * @return mixed
     */
    public function actionRemarks($id)
    {
        $searchModel = new Remarks;
        $dataProvider = $searchModel->searchRemarks($id,Yii::$app->request->queryParams);

        return $this->renderAjax('remarks', [
            'dataProvider' => $dataProvider,
            'model'=> $searchModel,
            'billId'=>$id
        ]);
    }

      /**
     * Lists all Preinspection models.
     * @return mixed
     */
    public function actionAddRemarks()
    { 
        $model = new Remarks;
        if (Yii::$app->request->post()) {
            $model->load(Yii::$app->request->post());
            date_default_timezone_set('Asia/Calcutta');
            $model->createdOn = date('Y-m-d H:i:s');
            if($model->validate()){
                $model->save();    
            }
            
            return json_encode(['status'=>'success','msg'=>'Success']);
        }
    }

    /**
     * Lists all Preinspecton models.
     * @return mixed
     */
    public function actionDownloadMis($billId = false)
    {
        $id = ($billId) ? $billId : isset($_GET['billId']) ? $_GET['billId'] : '';
        $model = $this->findModel($id);

        if($model)
        {
            $query = AxionPreinspection::find()->where(['billId'=>$id,'paymentMode'=>1]);
            $exporter = (new Spreadsheet([
               'title' => 'Bill Summary',
               'dataProvider' => new ActiveDataProvider([
                'query' => $query,
                ]),
                'columns' => [
                    [
                        'attribute'=>'referenceNo',
                        'label' => 'Ref No',
                    ],
                    [
                        'attribute' => 'status',
                        'label' => 'Status',
                        'value'=>function ($model) {
                            $status = $model->status;
                            
                            if($status == 101)
                            {
                                return  'PI-Recommended';
                            }
                            else if($status == 102)
                            {
                                return  'PI-Not Recommended';
                            }
                            else if($status == 103)
                            {
                                return  'PI-Inprogress';
                            }
                            else if($status == 104)
                            {
                                return  'PI-Refer to Under Writer';
                            }
                            else if($status == '9')
                            {
                                return  'Cancelled';
                            }
                            else { return '';}
                        },
                    ],
                    [
                        'attribute' => 'userId',
                        'label' => 'Regional Center', 
                        'value'=>function ($model) {
                            $res = $model->callerFirstName;
                            $data = '';
                            if(isset($res->roId) && $res->roId)
                            {
                                $user = User::find()->where(['id'=> $res->roId])->one();
                                $data =  $user->stateData->state;
                            }
                            else { 

                                $res = $model->state;
                                if(isset($res->state))
                                {
                                    $data = $res->state;
                                }
                                
                            }
                            return $data;
                        },      
                    ],  
                    [
                        'attribute' => 'callerCompany',
                        'label' => 'Company Name', 
                        'value'=>function ($model) {
                                $insurerName = $model->callerCompany;
                                if(isset($insurerName->companyName))
                                {
                                return  $insurerName->companyName;
                            }
                            else { return '';}
                        },        
                    ],
                    [
                        'attribute' => 'callerFirstName',
                        'label' => 'Caller/ Executive Name', 
                        'value'=>function ($model) {
                                $user = $model->callerFirstName;
                                if(isset($user->firstName))
                                {
                                return  $user->firstName;
                            }
                            else { return '';}
                        },     
                    ],           
                    [
                        'attribute' => 'callerDetails',
                        'label' => 'Caller/ Executive Email',
                        'value'=>function ($model) {
                            return $model->callerDetails ? $model->callerDetails : "";
                        },       
                    ],
                    [
                        'attribute' => 'callerFirstName',
                        'label' => 'Caller/ Executive Code',
                        'value'=>function ($model) {
                            $user = $model->callerFirstName;
                            if(isset($user->agent_code))
                            {
                                return  $user->agent_code;
                            }
                            else { return '';}
                        },   
                    ],
                    [
                        'attribute' => 'callerMobileNo',
                        'label' => 'Caller/ Executive Contact No',
                    ],
                    [
                        'attribute' => 'callerFirstName',
                        'label' => 'Zone',
                        'value'=>function ($model) {
                            $user = $model->callerFirstName;
                            if(isset($user->zone))
                            {
                                return  $user->zone;
                            }
                            else { return '';}
                        },       
                    ],
                    [
                        'attribute' => 'insurerBranch',
                        'label' => 'Branch',
                        'value' => 'callerBranch.branchName',
                    ],
                    [
                        'attribute' => 'insurerDivision',
                        'label' => 'Division',
                        'value' => 'callerDivision.divisionName',
                    ],
                    [
                        'attribute' => 'callerFirstName',
                        'label' => 'Channel',
                        'value'=>function ($model) {
                            $user = $model->callerFirstName;
                            if(isset($user->channel))
                            {
                            return  $user->channel;
                        }
                        else { return '';}
                    },      
                    ],
                    [
                        'attribute' => 'insuredName',
                        'label' => 'Insured Name',
                    ],
                    [
                        'attribute' => 'insuredAddress',
                        'label' => 'Insured Address',
                    ],
                    [
                        'attribute' => 'insuredMobile',
                        'label' => 'Insured Mobile No',
                    ],
                    [
                        'attribute' => 'registrationNo',
                        'label' => 'Vehicle Number',
                    ],
                    [
                        'attribute' => 'engineNo',
                        'label' => 'Engine No',
                    ],
                    [
                        'attribute' => 'chassisNo',
                        'label' => 'Chassis No',
                    ],
                    [
                        'attribute' => 'vehicleType',
                        'label' => 'Odo Meter', 
                        'value' => 'vType.odometerReading',
                    ],
                    [
                        'attribute' => 'vehicleType',
                        'label' => 'Vehicle Type',        
                        'value' => 'vType.vType',
                    ],
                    [
                        'attribute' => 'manufacturer',
                        'label' => 'Manufacturer',
                    ],
                    [
                        'attribute' => 'model',
                        'label' => 'Model',
                    ],
                    [
                        'attribute' => 'manufacturingYear',
                        'label' => 'Manufacturer Year',
                    ],
                    [
                        'attribute' => 'surveyLocation',
                        'label' => 'Survey From Lcoation',
                    ],
                    [
                        'attribute' => 'surveyLocation2',
                        'label' => 'Survey To Location',
                    ],

                    [
                        'attribute' => 'inspectionType',
                        'label' => 'Inspect Type',
                    ],
                    [
                        'attribute' => 'paymentMode',
                        'label' => 'Payment Mode',
                        'value'=>function ($model) {
                            $paymentMode = $model->paymentMode;
                            
                            if($paymentMode == 1)
                            {
                                return  'Company Billing';
                            }
                            else if($paymentMode == 2)
                            {
                                return  'Fee and Conv. From Client';
                            }
                            else if($paymentMode == 3)
                            {
                                return  'Company Billing and Conv. From Client';
                            }
                            else { return '';}
                        },
                    ],
                    [
                        'attribute' => 'cashCollection',
                        'value' => function($model){
                            return (float) $model->cashCollection;            
                        },
                    ],
                    [
                        'attribute' => 'extraKM',
                        'label' => 'Conveyance Km',
                    ],
                    [
                        'attribute' => 'intimationDate',
                        'label' => 'Intimation Date Time',      
                        'format' => ['date', 'php:d-m-Y h:i a'],
                    ],
                    [
                        'attribute' => 'surveyorName',
                        'label' => 'Surveyor', 
                        'value' => 'valuatorUser.firstName',
                    ],
                    [
                        'attribute' => 'surveyorName',
                        'label' => 'Surveyor Contact No',        
                        'value' => 'valuatorUser.mobile',
                    ],
                    [
                        'attribute' => 'completedSurveyDateTime',
                        'label' => 'Completed Date Time',   
                        'value' => function($model){
                            return ($model->completedSurveyDateTime) ? date('d-m-Y h:i',strtotime($model->completedSurveyDateTime)) : '';
                        },
                    ],
                    [
                        'attribute' => 'contactPersonMobileNo',
                        'label' => 'Unique Lead Number',
                    ],
                    [
                        'attribute' => 'billNumber',
                        'label' => 'Bill Number',
                        'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#337ab7;'],
                        'value' => 'bill.billNumber'
                    ],
                    [
                        'attribute' => 'sbuCode',
                        'label' => 'SBU Code',
                        'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#337ab7;']  
                    ],
                    [
                        'attribute' => 'name',
                        'label' => 'SBU Head Name',
                        'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#337ab7;'],
                        'value' => function($model) {
                            $bill = $model->bill;

                            if ($bill->sbuHeadId)
                            {
                                $sbuHead = SbuHelper::getSbuHeadDetails($bill->sbuHeadId);
                                return $sbuHead->name;
                            }
                            else    
                            {
                                return '';
                            }
                        }  
                    ],
                    [
                        'attribute' => 'uploadSource',
                        'label' => 'Upload Source',
                    ],
                    [
                        'attribute' => 'updatedBy',
                        'label' => 'Final Updation RO Name',
                        'value'=>function ($model) {
                            $res = $model->updatedByName;
                            if(isset($res->firstName) && isset($res->firstName))
                            {
                                return  $res->firstName;
                            }
                            else { return '';}
                        },
                    ],
                    [
                        'attribute'=>'remarks',
                    ],
                ],
            ]))->render();

            //$path = Yii::getAlias('@app/uploads/');
            $path = \Yii::$app->params['billingLoc'].'mis/';
            $fileName = "BILL-".$model->billNumber.".xls";

            $exporter->save($path.$fileName);
            $result = S3Helper::upload($path.$fileName, $path.$fileName);
            if ($result['status'])
            {
                //unlink($path.$fileName);
            }
            if (file_exists($path.$fileName)) {
                return Yii::$app->response->sendFile($result['data']['url'], $fileName);
            }

        }
    }


    private function saveMis($id)
    {
        $model = $this->findModel($id);

        if($model)
        {
            $query = AxionPreinspection::find()->where(['billId'=>$id,'paymentMode'=>1]);
            
            $exporter = (new Spreadsheet([
               'title' => 'Bill Summary',
               'dataProvider' => new ActiveDataProvider([
                'query' => $query,
                ]),
                'columns' => [
                    [
                        'attribute'=>'referenceNo',
                        'label' => 'Ref No',
                    ],
                    [
                        'attribute' => 'status',
                        'label' => 'Status',
                        'value'=>function ($model) {
                            $status = $model->status;
                            
                            if($status == 101)
                            {
                                return  'PI-Recommended';
                            }
                            else if($status == 102)
                            {
                                return  'PI-Not Recommended';
                            }
                            else if($status == 103)
                            {
                                return  'PI-Inprogress';
                            }
                            else if($status == 104)
                            {
                                return  'PI-Refer to Under Writer';
                            }
                            else if($status == '9')
                            {
                                return  'Cancelled';
                            }
                            else { return '';}
                        },
                    ],
                    [
                        'attribute' => 'userId',
                        'label' => 'Regional Center', 
                        'value'=>function ($model) {
                            $res = $model->callerFirstName;
                            $data = '';
                            if(isset($res->roId) && $res->roId)
                            {
                                $user = User::find()->where(['id'=> $res->roId])->one();
                                $data =  $user->stateData->state;
                            }
                            else { 

                                $res = $model->state;
                                if(isset($res->state))
                                {
                                    $data = $res->state;
                                }
                                
                            }
                            return $data;
                        },      
                    ],  
                    [
                        'attribute' => 'callerCompany',
                        'label' => 'Company Name', 
                        'value'=>function ($model) {
                                $insurerName = $model->callerCompany;
                                if(isset($insurerName->companyName))
                                {
                                return  $insurerName->companyName;
                            }
                            else { return '';}
                        },        
                    ],
                    [
                        'attribute' => 'callerFirstName',
                        'label' => 'Caller/ Executive Name', 
                        'value'=>function ($model) {
                                $user = $model->callerFirstName;
                                if(isset($user->firstName))
                                {
                                return  $user->firstName;
                            }
                            else { return '';}
                        },     
                    ],           
                    [
                        'attribute' => 'callerDetails',
                        'label' => 'Caller/ Executive Email',
                        'value'=>function ($model) {
                            return $model->callerDetails ? $model->callerDetails : "";
                        },       
                    ],
                    [
                        'attribute' => 'callerFirstName',
                        'label' => 'Caller/ Executive Code',
                        'value'=>function ($model) {
                            $user = $model->callerFirstName;
                            if(isset($user->agent_code))
                            {
                                return  $user->agent_code;
                            }
                            else { return '';}
                        },   
                    ],
                    [
                        'attribute' => 'callerMobileNo',
                        'label' => 'Caller/ Executive Contact No',
                    ],
                    [
                        'attribute' => 'callerFirstName',
                        'label' => 'Zone',
                        'value'=>function ($model) {
                            $user = $model->callerFirstName;
                            if(isset($user->zone))
                            {
                                return  $user->zone;
                            }
                            else { return '';}
                        },       
                    ],
                    [
                        'attribute' => 'insurerBranch',
                        'label' => 'Branch',
                        'value' => 'callerBranch.branchName',
                    ],
                    [
                        'attribute' => 'insurerDivision',
                        'label' => 'Division',
                        'value' => 'callerDivision.divisionName',
                    ],
                    [
                        'attribute' => 'callerFirstName',
                        'label' => 'Channel',
                        'value'=>function ($model) {
                            $user = $model->callerFirstName;
                            if(isset($user->channel))
                            {
                            return  $user->channel;
                        }
                        else { return '';}
                    },      
                    ],
                    [
                        'attribute' => 'insuredName',
                        'label' => 'Insured Name',
                    ],
                    [
                        'attribute' => 'insuredAddress',
                        'label' => 'Insured Address',
                    ],
                    [
                        'attribute' => 'insuredMobile',
                        'label' => 'Insured Mobile No',
                    ],
                    [
                        'attribute' => 'registrationNo',
                        'label' => 'Vehicle Number',
                    ],
                    [
                        'attribute' => 'engineNo',
                        'label' => 'Engine No',
                    ],
                    [
                        'attribute' => 'chassisNo',
                        'label' => 'Chassis No',
                    ],
                    [
                        'attribute' => 'vehicleType',
                        'label' => 'Odo Meter', 
                        'value' => 'vType.odometerReading',
                    ],
                    [
                        'attribute' => 'vehicleType',
                        'label' => 'Vehicle Type',        
                        'value' => 'vType.vType',
                    ],
                    [
                        'attribute' => 'manufacturer',
                        'label' => 'Manufacturer',
                    ],
                    [
                        'attribute' => 'model',
                        'label' => 'Model',
                    ],
                    [
                        'attribute' => 'manufacturingYear',
                        'label' => 'Manufacturer Year',
                    ],
                    [
                        'attribute' => 'surveyLocation',
                        'label' => 'Survey From Lcoation',
                    ],
                    [
                        'attribute' => 'surveyLocation2',
                        'label' => 'Survey To Location',
                    ],

                    [
                        'attribute' => 'inspectionType',
                        'label' => 'Inspect Type',
                    ],
                    [
                        'attribute' => 'paymentMode',
                        'label' => 'Payment Mode',
                        'value'=>function ($model) {
                            $paymentMode = $model->paymentMode;
                            
                            if($paymentMode == 1)
                            {
                                return  'Company Billing';
                            }
                            else if($paymentMode == 2)
                            {
                                return  'Fee and Conv. From Client';
                            }
                            else if($paymentMode == 3)
                            {
                                return  'Company Billing and Conv. From Client';
                            }
                            else { return '';}
                        },
                    ],
                    [
                        'attribute' => 'cashCollection',
                        'value' => function($model){
                            return (float) $model->cashCollection;            
                        },
                    ],
                    [
                        'attribute' => 'extraKM',
                        'label' => 'Conveyance Km',
                    ],
                    [
                        'attribute' => 'intimationDate',
                        'label' => 'Intimation Date Time',      
                        'format' => ['date', 'php:d-m-Y h:i a'],
                    ],
                    [
                        'attribute' => 'surveyorName',
                        'label' => 'Surveyor', 
                        'value' => 'valuatorUser.firstName',
                    ],
                    [
                        'attribute' => 'surveyorName',
                        'label' => 'Surveyor Contact No',        
                        'value' => 'valuatorUser.mobile',
                    ],
                    [
                        'attribute' => 'completedSurveyDateTime',
                        'label' => 'Completed Date Time',   
                        'value' => function($model){
                            return ($model->completedSurveyDateTime) ? date('d-m-Y h:i',strtotime($model->completedSurveyDateTime)) : '';
                        },
                    ],
                    [
                        'attribute' => 'contactPersonMobileNo',
                        'label' => 'Unique Lead Number',
                    ],
                    [
                        'attribute' => 'billNumber',
                        'label' => 'Bill Number',
                        'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#337ab7;'],
                        'value' => 'bill.billNumber'
                    ],
                    [
                        'attribute' => 'sbuCode',
                        'label' => 'SBU Code',
                        'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#337ab7;']  
                    ],
                    [
                        'attribute' => 'name',
                        'label' => 'SBU Head Name',
                        'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#337ab7;'],
                        'value' => function($model) {
                            $bill = $model->bill;

                            if ($bill->sbuHeadId)
                            {
                                $sbuHead = SbuHelper::getSbuHeadDetails($bill->sbuHeadId);
                                return $sbuHead->name;
                            }
                            else    
                            {
                                return '';
                            }
                        }  
                    ],
                    [
                        'attribute' => 'uploadSource',
                        'label' => 'Upload Source',
                    ],
                    [
                        'attribute' => 'updatedBy',
                        'label' => 'Final Updation RO Name',
                        'value'=>function ($model) {
                            $res = $model->updatedByName;
                            if(isset($res->firstName) && isset($res->firstName))
                            {
                                return  $res->firstName;
                            }
                            else { return '';}
                        },
                    ],
                    [
                        'attribute'=>'remarks',
                    ],
                ],
            ]));

            $path = \Yii::$app->params['billingLoc'].'mis/';
            $fileName = "BILL-".$model->billNumber.".xls";
     
            $exporter->save($path.$fileName);
            $result = S3Helper::upload($path.$fileName, $path.$fileName);
            if ($result['status'])
            {
                //unlink($path.$fileName);
            }
        }
    }

    private function saveITGIMis($id)
    {
        $model = $this->findModel($id);

        if($model)
        {
            $query = AxionPreinspection::find()->where(['billId'=>$id, 'paymentMode'=>1]);
            
            $exporter = (new Spreadsheet([
               'title' => 'Bill Summary',
               'dataProvider' => new ActiveDataProvider([
                'query' => $query,
                ]),
                'columns' => [
                    [
                        'attribute'=>'referenceNo',
                        'label' => 'Ref No',
                    ],
                    [
                        'attribute' => 'status',
                        'label' => 'Status',
                        'value'=>function ($model) {
                            $status = $model->status;
                            
                            if($status == 101)
                            {
                                return  'PI-Recommended';
                            }
                            else if($status == 102)
                            {
                                return  'PI-Not Recommended';
                            }
                            else if($status == 103)
                            {
                                return  'PI-Inprogress';
                            }
                            else if($status == 104)
                            {
                                return  'PI-Refer to Under Writer';
                            }
                            else if($status == '9')
                            {
                                return  'Cancelled';
                            }
                            else { return '';}
                        },
                    ],
                    [
                        'attribute' => 'name',
                        'label' => 'SBU Head Name',
                        'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#337ab7;'],
                        'value' => function($model) {
                            $bill = $model->bill;

                            if ($bill->sbuHeadId)
                            {
                                $sbuHead = SbuHelper::getSbuHeadDetails($bill->sbuHeadId);
                                return $sbuHead->name;
                            }
                            else    
                            {
                                return '';
                            }
                        }  
                    ],

                    [
                        'attribute' => 'gst',
                        'label' => 'GST Number',
                        'headerOptions' => ['style'=>'border: 2px #000 solid;background-color:#337ab7;'],
                        'value' => function($model) {
                            $bill = $model->bill;

                            if ($bill->sbuHeadId)
                            {
                                $sbuHead = SbuHelper::getSbuHeadDetails($bill->sbuHeadId);
                                return $sbuHead->gst;
                            }
                            else    
                            {
                                return '';
                            }
                        }  
                    ],

                    [
                        'attribute' => 'callerCompany',
                        'label' => 'Company Name', 
                        'value'=>function ($model) {
                                $insurerName = $model->callerCompany;
                                if(isset($insurerName->companyName))
                                {
                                return  $insurerName->companyName;
                            }
                            else { return '';}
                        },        
                    ],
                    
                    [
                        'attribute' => 'insuredName',
                        'label' => 'Insured Name',
                    ],
                    [
                        'attribute' => 'insuredMobile',
                        'label' => 'Insured Mobile No',
                    ],
                    [
                        'attribute' => 'registrationNo',
                        'label' => 'Vehicle Number',
                    ],
                    
                    [
                        'attribute' => 'vehicleType',
                        'label' => 'Vehicle Type',        
                        'value' => 'vType.vType',
                    ],

                    [
                        'attribute' => 'inspectionType',
                        'label' => 'Inspect Type',
                    ],
                    [
                        'attribute' => 'paymentMode',
                        'label' => 'Payment Mode',
                        'value'=>function ($model) {
                            $paymentMode = $model->paymentMode;
                            
                            if($paymentMode == 1)
                            {
                                return  'Company Billing';
                            }
                            else if($paymentMode == 2)
                            {
                                return  'Fee and Conv. From Client';
                            }
                            else if($paymentMode == 3)
                            {
                                return  'Company Billing and Conv. From Client';
                            }
                            else { return '';}
                        },
                    ],
                    
                    [
                        'attribute' => 'intimationDate',
                        'label' => 'Intimation Date Time',      
                        'format' => ['date', 'php:d-m-Y h:i a'],
                    ],
                   
                    [
                        'attribute' => 'completedSurveyDateTime',
                        'label' => 'Completed Date Time',   
                        'value' => function($model){
                            return ($model->completedSurveyDateTime) ? date('d-m-Y h:i',strtotime($model->completedSurveyDateTime)) : '';
                        },
                    ],

                    [
                        'attribute' => 'contactPersonMobileNo',
                        'label' => 'Pre Inspection ID',
                        'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#337ab7;']  
                    ],

                    [
                        'attribute' => 'sbuCode',
                        'label' => 'SBU Code',
                        'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#337ab7;']  
                    ],
                    
                    [
                        'attribute' => 'billNumber',
                        'label' => 'Bill Number',
                        'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#337ab7;'],
                        'value' => 'bill.billNumber'
                    ],
                    
                    [
                        'attribute' => 'Fees Amount',
                        'label' => 'Fees Amount',
                        'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#337ab7;'],
                        'value' => function() { 
                            return 95;
                        },
                    ],
                    [
                        'attribute' => 'Tax Amount',
                        'label' => 'Tax Amount',
                        'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#337ab7;'],
                        'value' => function() { 
                            return (int) (95 * (18 / 100));
                        },
                    ],
                    [
                        'attribute' => 'Total Amount',
                        'label' => 'Total Amount',
                        'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#337ab7;'],
                        'value' => function() { 
                            return 95 + ((int) (95 * (18 / 100)));
                        },
                    ],
                ],
            ]));

            $path = \Yii::$app->params['billingLoc'].'mis/';
            $fileName = "ITGI-BILL-".$model->billNumber.".xls";
     
            $exporter->save($path.$fileName);
        }
    }

    public function actionCheckBillNo(){
        return $this->getBillNo();
    }

    protected function getBillNo()
    {
        $year = date('Y');
        $month = date('m');
        if(intval($month) < 4){
            $year = $year - 1;
        }else{
            $year = $year;
        }
        $dateStart = $year.'-04-01'; 
        $dateEnd = ($year + 1).'-03-31';
        $start_date = date($dateStart.' 00:00:00');
        $end_date = date($dateEnd.' 23:59:59');
        
        if (($model = AxionPreinspectionBilling::find()->where(['between', 'generatedDate',$start_date,$end_date])->orderBy(['orderNo' => SORT_DESC])->one()) !== null) {
            return ($model->orderNo) + 1;
        } else {
            // return 17;
            return 1;
        }
    }

public function actionGenerateHo($id){

    $model = $this->findModel($id);
    

    date_default_timezone_set('Asia/Calcutta');

    if($model->billType != 'State Bill' && $model->billType != 'Branch Bill' && !$model->parentId){

        $roUsers = User::find()->join('LEFT JOIN','auth_assignment','auth_assignment.user_id = id')
        ->where(['auth_assignment.item_name' => 'BO User'])->groupBy('stateId')->all();

        foreach($roUsers as $row){
            $orderNo = $this->getHoBillNo();
            $num = 1000 + $orderNo;
                //echo '<pre>';print_r($row);exit;
            $userId = $row['id'];
            $stateId = $row['stateId'];

            if($stateId != NULL || $stateId!=''){
                $roUser = User::find()->join('LEFT JOIN','auth_assignment','auth_assignment.user_id = id')
                ->where(['auth_assignment.item_name' => 'BO User','users.stateId'=>$stateId])->one();


                $query = AxionPreinspection::find();
                        //$query->andWhere(['us.stateId' => $stateId]);
                $query->andWhere(['OR', ["userId"=>$roUser->id],['callerName'=>$roUser->id],['roId' => $roUser->id]]);
                $query->andWhere(['OR', ["ab.id"=>$model->id],['ab.parentId'=>$model->id]]);

                $query->join('left join','users as us', 'us.id=axion_preinspection.userId');
                $query->join('left join','axion_preinspection_vehicle as av2', 'av2.preinspection_id=axion_preinspection.id AND av2.vType="2-WHEELER"');
                $query->join('left join','axion_preinspection_vehicle as av3', 'av3.preinspection_id=axion_preinspection.id AND av3.vType="3-WHEELER"');
                $query->join('left join','axion_preinspection_vehicle as av4', 'av4.preinspection_id=axion_preinspection.id AND av4.vType="4-WHEELER"');
                $query->join('left join','axion_preinspection_vehicle as avc', 'avc.preinspection_id=axion_preinspection.id AND avc.vType="COMMERCIAL"');
                $query->join('left join','preinspection_client_company as pc', 'pc.id=axion_preinspection.insurerName');

                $query->join('left join','axion_preinspection_billing as ab', 'ab.id=axion_preinspection.billId');



                $query->select([new Expression('SUM(extraKM) as totalKm'),new Expression('COUNT(av2.id) as total2W'),new Expression('COUNT(av3.id) as total3W'),new Expression('COUNT(av4.id) as total4W'),new Expression('COUNT(avc.id) as totalCW')]);

                $res = $query->one();
                $company = (isset($model->callerCompany)) ? $model->callerCompany : '';
                $totalKm = ($res && isset($res->totalKm)) ? $res->totalKm : 0;
                    $total2W = 0;//($res && isset($res->total2W)) ? $res->total2W : 0;
                    $total3W = 0;//($res && isset($res->total3W)) ? $res->total3W : 0;
                    $total4W = ($res && isset($res->totalKm)) ? $res->total4W : 0;
                    $totalCW = ($res && isset($res->totalCW)) ? $res->totalCW : 0;

                    // $exist = AxionPreinspectionHoBilling::find()->join('left join','axion_preinspection_billing ab','ab.id=axion_preinspection_ho_billing.billId')->where(['or','billId'=>$model->id,'ab.parentId'=>$model->id])->andWhere(['axion_preinspection_ho_billing.stateId'=>$stateId])->one();

                    $exist = AxionPreinspectionHoBilling::find()
                    ->leftJoin('axion_preinspection_billing ab', 'ab.id = axion_preinspection_ho_billing.billId')
                    ->where([
                        'or',
                        ['axion_preinspection_ho_billing.billId' => $model->id],
                        ['ab.parentId' => $model->id],
                    ])
                    ->andWhere(['axion_preinspection_ho_billing.stateId' => $stateId])->one();

                    // $sql = $exist->createCommand()->getRawSql();

                    // echo $sql.'<br><br>';


                    if(($totalKm!=0 || $total4W !=0 || $totalCW!=0) && (!$exist)){
                        $perKm = ($company && isset($company->rateConveyance)) ? $company->rateConveyance : 0;
                        $per2w = 0;
                        $per3w = 0;
                        $per4w = ($company && isset($company->rate4Wheeler)) ? $company->rate4Wheeler : 0;
                        $perCw = ($company && isset($company->rateCommercial)) ? $company->rateCommercial : 0;

                        $igst = ($company && isset($company->igst)) ? $company->igst : 0;
                        $sgst = ($company && isset($company->sgst)) ? $company->sgst : 0;
                        $cgst = ($company && isset($company->cgst)) ? $company->cgst : 0;
                        /*$totalKmRate = $totalKm * $perKm;
                        $total2wRate = 0;
                        $total3wRate = 0;
                        $total4wRate = $total4W * $per4w;
                        $totalCwRate = $totalCW * $perCw;
                        $billAmount = $totalKmRate + $total2wRate + $total3wRate + $total4wRate + $totalCwRate;
                        $royaltyOnConveyance = ($totalKmRate * $roUsers->royaltyOnConveyance) / 100;
                        $royaltyOnFees = ($billAmount * $roUsers->royaltyOnFees) / 100; 
                        $totalGst = $royaltyOnConveyance + $royaltyOnFees;
                        $totalAmount = $billAmount + $totalGst;*/
                        $totalKmRoyalty = $perKm - (($perKm * $roUser->royaltyOnConveyance) / 100);
                        $total4WRoyalty = $per4w - (($per4w * $roUser->royaltyOnFees) / 100);
                        $totalCwRoyalty = $perCw - (($perCw * $roUser->royaltyOnFees) / 100);

                        $totalKmRate = $totalKm * $totalKmRoyalty;
                        $total2wRate = 0;
                        $total3wRate = 0;
                        $total4wRate = $total4W * $total4WRoyalty;
                        $totalCwRate = $totalCW * $totalCwRoyalty;


                        $billAmount = $totalKmRate + $total2wRate + $total3wRate + $total4wRate + $totalCwRate;

                        //$royaltyOnConveyance = ($totalKmRate * $roUsers->royaltyOnConveyance) / 100;
                        //$royaltyOnFees = ($billAmount * $roUsers->royaltyOnFees) / 100; 

                        $totalGst = $igst + $sgst + $cgst;//$royaltyOnConveyance + $royaltyOnFees;

                        $totalIgst = ($billAmount * $igst) / 100;
                        $totalSgst = ($billAmount * $sgst) / 100;
                        $totalCgst = ($billAmount * $cgst) / 100;

                        $totalGst = $totalIgst + $totalSgst + $totalCgst;
                        $overallAmount = $billAmount + $totalGst;
                        $roundAmt = round($overallAmount);


                        $arr = [
                            "perKm"=> $totalKmRoyalty,
                            "per2w" => $per2w,
                            "per3w"=> $per3w,
                            "per4w" => $total4WRoyalty,
                            "perCw" => $totalCwRoyalty,
                            "totalKm" => $totalKm,
                            "total2W" => $total2W,
                            "total3W" => $total3W,
                            "total4W" => $total4W,
                            "totalCW" => $totalCW,
                            "totalIgst" => $totalIgst,
                            "totalSgst" => $totalSgst,
                            "totalCgst" => $totalCgst,
                            "totalGst" =>$totalGst,
                            "igst" => $igst,
                            "sgst" => $sgst,
                            "cgst" => $cgst                        
                        ];

                        $hoModel = new AxionPreinspectionHoBilling();
                        $hoModel->billId = $model->id;
                        $hoModel->roId = $userId;
                        $hoModel->hoBillNumber = "HO".$num;
                        $hoModel->companyId = $model->companyId;
                        $hoModel->billType = $model->billType;
                        $hoModel->stateId = $stateId; //$model->stateId;
                        $hoModel->branchId =  '';//$model->branchId;
                        $hoModel->companyId = $model->companyId;
                        $hoModel->hoOrderNo = $orderNo;
                        $hoModel->generatedBy = Yii::$app->user->identity->id;
                        $hoModel->generatedDate = date('Y-m-d');
                        $hoModel->createdOn = date('Y-m-d H:i:s');
                        $hoModel->billStatus = "Not Paid";
                        $hoModel->billPeriodFrom = $model->billPeriodFrom;
                        $hoModel->billPeriodTo = $model->billPeriodTo;
                        $hoModel->billDetails = json_encode($arr);
                        $hoModel->billAmount = $billAmount;
                        $hoModel->totalGst = $totalGst;
                        $hoModel->totalAmount = $overallAmount;

                        $hoModel->save();
                    }
                }
            }
            
        }else{
            $exist = AxionPreinspectionHoBilling::find()->where(['billId'=>$model->id])->one();
            if(!$exist){
                $orderNo = $this->getHoBillNo();
                $num = 1000 + $orderNo;

                $roUsers = User::find()->join('LEFT JOIN','auth_assignment','auth_assignment.user_id = id')
                ->where(['auth_assignment.item_name' => 'BO User','users.stateId'=>$model->stateId])->one();


                $query = AxionPreinspection::find()->where(['billId'=>$model->id]);
            //$query->andWhere(['us.stateId' => $stateId]);
                $query->andWhere(['OR', ["userId"=>$roUsers->id],['callerName'=>$roUsers->id],['roId' => $roUsers->id]]);

                $query->join('left join','users as us', 'us.id=axion_preinspection.userId');
                $query->join('left join','axion_preinspection_vehicle as av2', 'av2.preinspection_id=axion_preinspection.id AND av2.vType="2-WHEELER"');
                $query->join('left join','axion_preinspection_vehicle as av3', 'av3.preinspection_id=axion_preinspection.id AND av3.vType="3-WHEELER"');
                $query->join('left join','axion_preinspection_vehicle as av4', 'av4.preinspection_id=axion_preinspection.id AND av4.vType="4-WHEELER"');
                $query->join('left join','axion_preinspection_vehicle as avc', 'avc.preinspection_id=axion_preinspection.id AND avc.vType="COMMERCIAL"');
                $query->join('left join','preinspection_client_company as pc', 'pc.id=axion_preinspection.insurerName');

                $query->select([new Expression('SUM(extraKM) as totalKm'),new Expression('COUNT(av2.id) as total2W'),new Expression('COUNT(av3.id) as total3W'),new Expression('COUNT(av4.id) as total4W'),new Expression('COUNT(avc.id) as totalCW')]);

                $res = $query->one();


                $hoModel = new AxionPreinspectionHoBilling();

                $hoModel->billId = $model->id;
                $hoModel->roId = $roUsers->id;
                $hoModel->hoBillNumber = "HO".$num;
                $hoModel->companyId = $model->companyId;
                $hoModel->billType = $model->billType;
                $hoModel->stateId = $model->stateId;
                $hoModel->branchId = ($model->billType=="Branch Bill") ? $model->branchId : "";
                $hoModel->companyId = $model->companyId;
                $hoModel->hoOrderNo = $orderNo;
                $hoModel->generatedBy = Yii::$app->user->identity->id;
                $hoModel->generatedDate = date('Y-m-d');
                $hoModel->createdOn = date('Y-m-d H:i:s');
                $hoModel->billStatus = "Not Paid";
                $hoModel->billPeriodFrom = $model->billPeriodFrom;
                $hoModel->billPeriodTo = $model->billPeriodTo;

                $company = (isset($model->callerCompany)) ? $model->callerCompany : '';
                $totalKm = ($res && isset($res->totalKm)) ? $res->totalKm : 0;
                $total2W = 0;
                $total3W = 0;
                $total4W = ($res && isset($res->totalKm)) ? $res->total4W : 0;
                $totalCW = ($res && isset($res->totalCW)) ? $res->totalCW : 0;

                $perKm = ($company && isset($company->rateConveyance)) ? $company->rateConveyance : 0;
                $per2w = 0;
                $per3w = 0;
                $per4w = ($company && isset($company->rate4Wheeler)) ? $company->rate4Wheeler : 0;
                $perCw = ($company && isset($company->rateCommercial)) ? $company->rateCommercial : 0;

                $igst = ($company && isset($company->igst)) ? $company->igst : 0;
                $sgst = ($company && isset($company->sgst)) ? $company->sgst : 0;
                $cgst = ($company && isset($company->cgst)) ? $company->cgst : 0;

                $totalKmRoyalty = $perKm - (($perKm * $roUsers->royaltyOnConveyance) / 100);
                $total4WRoyalty = $per4w - (($per4w * $roUsers->royaltyOnFees) / 100);
                $totalCwRoyalty = $perCw - (($perCw * $roUsers->royaltyOnFees) / 100);

                $totalKmRate = $totalKm * $totalKmRoyalty;
                $total2wRate = 0;
                $total3wRate = 0;
                $total4wRate = $total4W * $total4WRoyalty;
                $totalCwRate = $totalCW * $totalCwRoyalty;

                $billAmount = $totalKmRate + $total2wRate + $total3wRate + $total4wRate + $totalCwRate;

            //$royaltyOnConveyance = ($totalKmRate * $roUsers->royaltyOnConveyance) / 100;
            //$royaltyOnFees = ($billAmount * $roUsers->royaltyOnFees) / 100; 

            $totalGst = $igst + $sgst + $cgst;//$royaltyOnConveyance + $royaltyOnFees;

            $totalIgst = ($billAmount * $igst) / 100;
            $totalSgst = ($billAmount * $sgst) / 100;
            $totalCgst = ($billAmount * $cgst) / 100;

            $totalGst = $totalIgst + $totalSgst + $totalCgst;
            $overallAmount = $billAmount + $totalGst;
            $roundAmt = round($overallAmount);

            //$totalAmount = $billAmount + $totalGst;

             $arr = [
                "perKm"=> $totalKmRoyalty,
                "per2w" => $per2w,
                "per3w"=> $per3w,
                "per4w" => $total4WRoyalty,
                "perCw" => $totalCwRoyalty,
                "totalKm" => $totalKm,
                "total2W" => $total2W,
                "total3W" => $total3W,
                "total4W" => $total4W,
                "totalCW" => $totalCW,
                "totalIgst" => $totalIgst,
                "totalSgst" => $totalSgst,
                "totalCgst" => $totalCgst,
                "totalGst" =>$totalGst,
                "igst" => $igst,
                "sgst" => $sgst,
                "cgst" => $cgst                        
            ];
            
            $hoModel->billDetails = json_encode($arr);
            $hoModel->billAmount = $billAmount;
            $hoModel->totalGst = $totalGst;
            $hoModel->totalAmount = $overallAmount;
            $hoModel->save();
        }
    }
        /*if($model->save()){
            $res = ["status"=>"success","msg"=>"HO Bill Generated Successfully!"];
        }else{
            $res = ["status"=>"error","msg"=>"Could not generate HO Bill!"];
        }
        return json_encode($res);*/
        //return $this->redirect('/billing/mis-verification');
        return $this->redirect(Yii::$app->request->referrer);
        
    }

    protected function getHoBillNo()
    {
        if (($model = AxionPreinspectionHoBilling::find()->orderBy(['hoOrderNo' => SORT_DESC])->one()) !== null) {
            return ($model->hoOrderNo) + 1;
        } else {
            return 1;
        }
    }

    /**
     * Lists all Preinspecton models.
     * @return mixed
     */
    public function actionHoBillList()
    {

        $searchModel = new AxionPreinspectionHoBilling();
        //$searchModel->scenario = 'search';
        $dataProvider = $searchModel->searchHoBillList(Yii::$app->request->queryParams);
        if (Yii::$app->request->isPjax) {      
            return $this->renderAjax('ho-bill', [
                'dataProvider' => $dataProvider,
                'searchModel' => $searchModel
            ]);
        }else{             
            $searchModel->load(Yii::$app->request->queryParams);
            return $this->render('ho-bill', [
                'dataProvider' => $dataProvider,
                'searchModel' => $searchModel
            ]);
        }        
    }


     /**
     * Lists all Preinspecton models.
     * @return mixed
     */
     public function actionDownloadHoPdf($id=false)
     {
        $id = ($id) ? $id : isset($_GET['id']) ? $_GET['id'] : '';
        //$id = ($billId) ? $billId : isset($_GET['billId']) ? $_GET['billId'] : '';
        $hoModel = AxionPreinspectionHoBilling::find()->where(['id'=>$id])->one();
        $model = $this->findModel($hoModel->billId);

        $date = date('M y',strtotime($model->billPeriodFrom));
        $billType = $model->callerCompany->billType;
        $company =  $model->callerCompany;
        $companyName =  $model->callerCompany->companyName;

        $fileName = "HO-Invoice-".$model->billNumber."-".$date."-".$hoModel->hoBillNumber;
        //if($billType=="State Bill"){
        $company = CompanyBillingDetails::find()->where(['companyId'=>$model->companyId,'stateId'=>$hoModel->stateId])->one();
        if(!$company){
            $company =  $model->callerCompany;
        }
        $stateName = $model->state->state;
        $fileName = $fileName." ".ucwords($stateName);
        //}
        
        $companyAddress = (isset($company->billingAddress)) ? $company->billingAddress : ((isset($company->address)) ? $company->address : '');

        $content = $this->renderPartial('_hoBillSummary',['model' => $model,'hoModel'=>$hoModel,'company'=>$company,"companyName"=>$companyName,"companyAddress"=>$companyAddress]);

        // setup kartik\mpdf\Pdf component
        $pdf = new Pdf([
            // set to use core fonts only
            'mode' => Pdf::MODE_CORE, 

            'filename' => $fileName.".pdf",
            // A4 paper format
            'format' => Pdf::FORMAT_A4, 
            // portrait orientation
            'orientation' => Pdf::ORIENT_PORTRAIT, 
            // stream to browser inline
            'destination' => Pdf::DEST_BROWSER, 
            // your html content input
            'content' => $content,  
            // format content from your own css file if needed or use the
            // enhanced bootstrap css built by Krajee for mPDF formatting 
            // any css to be embedded if required
            'cssInline' => '', 
             // set mPDF properties on the fly
            'options' => ['title' => ''],

            'cssFile' => ['@app/css/bootstrap.min.css','@app/css/pdf.css'],
             // call mPDF methods on the fly
            'methods' => [ 
                'SetHeader'=>false, 
                'SetFooter'=>['{PAGENO}'],
            ]
        ]);

        return $pdf->render(); 
        
    }

    /**
     * Lists all Preinspecton models.
     * @return mixed
     */
    public function actionDownloadHoMis($id=false)
    {
        $id = ($id) ? $id : isset($_GET['id']) ? $_GET['id'] : '';
        //$id = ($billId) ? $billId : isset($_GET['billId']) ? $_GET['billId'] : '';
        $hoModel = AxionPreinspectionHoBilling::find()->where(['id'=>$id])->one();
        $model = $this->findModel($hoModel->billId);

        if($model){
            $stateId = $hoModel->stateId;
            $query = AxionPreinspection::find();
            $query->where(['billId'=>$model->id,'paymentMode'=>1]);

            if($model->billType=='Corporate Bill'){
                $query->join('left join','users as us', 'us.id=axion_preinspection.userId');
                $query->andWhere(['us.stateId'=>$stateId]);
            }

            $exporter = (new Spreadsheet([
               'title' => 'HO Bill Summary',
               'dataProvider' => new ActiveDataProvider([
                'query' => $query,
            ]),
               'columns' => [
                [
                    'attribute'=>'referenceNo',
                    'label' => 'Ref No',
                ],
                [
                    'attribute' => 'status',
                    'label' => 'Status',
                    'value'=>function ($model) {
                        $status = $model->status;
                        
                        if($status == 101)
                        {
                            return  'PI-Recommended';
                        }
                        else if($status == 102)
                        {
                            return  'PI-Not Recommended';
                        }
                        else if($status == 103)
                        {
                            return  'PI-Inprogress';
                        }
                        else if($status == 104)
                        {
                            return  'PI-Refer to Under Writer';
                        }
                        else if($status == '9')
                        {
                            return  'Cancelled';
                        }
                        else { return '';}
                    },
                ],
                [
                    'attribute' => 'userId',
                    'label' => 'Regional Center', 
                    'value'=>function ($model) {
                        $res = $model->callerFirstName;
                        $data = '';
                        if(isset($res->roId) && $res->roId)
                        {
                            $user = User::find()->where(['id'=> $res->roId])->one();
                            $data =  $user->stateData->state;
                        }
                        else { 

                            $res = $model->state;
                            if(isset($res->state))
                            {
                                $data = $res->state;
                            }
                            
                        }
                        return $data;
                    },      
                ],  
                [
                    'attribute' => 'callerCompany',
                    'label' => 'Company Name', 
                    'value'=>function ($model) {
                        $insurerName = $model->callerCompany;
                        if(isset($insurerName->companyName))
                        {
                         return  $insurerName->companyName;
                     }
                     else { return '';}
                 },        
             ],
             [
                'attribute' => 'callerFirstName',
                'label' => 'Caller/ Executive Name', 
                'value'=>function ($model) {
                    $user = $model->callerFirstName;
                    if(isset($user->firstName))
                    {
                     return  $user->firstName;
                 }
                 else { return '';}
             },     
         ],           
         [
            'attribute' => 'callerDetails',
            'label' => 'Caller/ Executive Email',
            'value'=>function ($model) {
                return $model->callerDetails ? $model->callerDetails : "";
            },       
        ],
        [
            'attribute' => 'callerFirstName',
            'label' => 'Caller/ Executive Code',
            'value'=>function ($model) {
                $user = $model->callerFirstName;
                if(isset($user->agent_code))
                {
                 return  $user->agent_code;
             }
             else { return '';}
         },   
     ],
     [
        'attribute' => 'callerMobileNo',
        'label' => 'Caller/ Executive Contact No',
    ],
    [
        'attribute' => 'callerFirstName',
        'label' => 'Zone',
        'value'=>function ($model) {
            $user = $model->callerFirstName;
            if(isset($user->zone))
            {
             return  $user->zone;
         }
         else { return '';}
     },       
 ],
 [
    'attribute' => 'insurerBranch',
    'label' => 'Branch',
    'value' => 'callerBranch.branchName',
],
[
    'attribute' => 'insurerDivision',
    'label' => 'Division',
    'value' => 'callerDivision.divisionName',
],
[
    'attribute' => 'callerFirstName',
    'label' => 'Channel',
    'value'=>function ($model) {
        $user = $model->callerFirstName;
        if(isset($user->channel))
        {
         return  $user->channel;
     }
     else { return '';}
 },      
],
[
    'attribute' => 'insuredName',
    'label' => 'Insured Name',
],
[
    'attribute' => 'insuredAddress',
    'label' => 'Insured Address',
],
[
    'attribute' => 'insuredMobile',
    'label' => 'Insured Mobile No',
],
[
    'attribute' => 'registrationNo',
    'label' => 'Vehicle Number',
],
[
    'attribute' => 'engineNo',
    'label' => 'Engine No',
],
[
    'attribute' => 'chassisNo',
    'label' => 'Chassis No',
],
[
    'attribute' => 'vehicleType',
    'label' => 'Odo Meter', 
    'value' => 'vType.odometerReading',
],
[
    'attribute' => 'vehicleType',
    'label' => 'Vehicle Type',        
    'value' => 'vType.vType',
],
[
    'attribute' => 'manufacturer',
    'label' => 'Manufacturer',
],
[
    'attribute' => 'model',
    'label' => 'Model',
],
[
    'attribute' => 'manufacturingYear',
    'label' => 'Manufacturer Year',
],
[
    'attribute' => 'surveyLocation',
    'label' => 'Survey From Lcoation',
],
[
    'attribute' => 'surveyLocation2',
    'label' => 'Survey To Location',
],

[
    'attribute' => 'inspectionType',
    'label' => 'Inspect Type',
],
[
    'attribute' => 'paymentMode',
    'label' => 'Payment Mode',
    'value'=>function ($model) {
        $paymentMode = $model->paymentMode;
        
        if($paymentMode == 1)
        {
            return  'Company Billing';
        }
        else if($paymentMode == 2)
        {
            return  'Fee and Conv. From Client';
        }
        else if($paymentMode == 3)
        {
            return  'Company Billing and Conv. From Client';
        }
        else { return '';}
    },
],
[
    'attribute' => 'cashCollection',
    'value' => function($model){
        return (float) $model->cashCollection;            
    },
],
[
    'attribute' => 'extraKM',
    'label' => 'Conveyance Km',
],
[
    'attribute' => 'intimationDate',
    'label' => 'Intimation Date Time',      
    'format' => ['date', 'php:d-m-Y h:i a'],
],
[
    'attribute' => 'surveyorName',
    'label' => 'Surveyor', 
    'value' => 'valuatorUser.firstName',
],
[
    'attribute' => 'surveyorName',
    'label' => 'Surveyor Contact No',        
    'value' => 'valuatorUser.mobile',
],
[
    'attribute' => 'completedSurveyDateTime',
    'label' => 'Completed Date Time',   
    'value' => function($model){
        return ($model->completedSurveyDateTime) ? date('d-m-Y h:i',strtotime($model->completedSurveyDateTime)) : '';
    },
],
[
    'attribute' => 'contactPersonMobileNo',
    'label' => 'Unique Lead Number',
],
[
    'attribute' => 'uploadSource',
    'label' => 'Upload Source',
],
[
    'attribute' => 'updatedBy',
    'label' => 'Final Updation RO Name',
    'value'=>function ($model) {
        $res = $model->updatedByName;
        if(isset($res->firstName) && isset($res->firstName))
        {
         return  $res->firstName;
     }
     else { return '';}
 },
],
[
    'attribute'=>'remarks',
],
],
]))->render();

//$path = Yii::getAlias('@app/uploads/');
$path = \Yii::$app->params['billingLoc'].'mis/';
$fileName = "HOBILL-".$hoModel->hoBillNumber.".xls";

$exporter->save($path.$fileName);

if (file_exists($path.$fileName)) {
    return Yii::$app->response->sendFile($path.$fileName, $fileName);
}

}
}

    /**
     * Lists all Preinspection models.
     * @return mixed
     */
    public function actionHoRemarks($id)
    {
        $searchModel = new HoRemarks;
        $dataProvider = $searchModel->searchRemarks($id,Yii::$app->request->queryParams);

        return $this->renderAjax('ho-remarks', [
            'dataProvider' => $dataProvider,
            'model'=> $searchModel,
            'hoBillId'=>$id
        ]);
    }

      /**
     * Lists all Preinspection models.
     * @return mixed
     */
    public function actionAddHoRemarks()
    { 
        $model = new HoRemarks;
        if (Yii::$app->request->post()) {
            $model->load(Yii::$app->request->post());
            date_default_timezone_set('Asia/Calcutta');
            $model->createdOn = date('Y-m-d H:i:s');
            if($model->validate()){
                $model->save();    
            }
            
            return json_encode(['status'=>'success','msg'=>'Success']);
        }
    }

    public function actionSendBillingReport($id)
    {   
        $model = $this->findModel($id);
        $sbuHead = MasterSbuHead::findOne($model->sbuHeadId);

        $date = date('M y', strtotime($model->billPeriodFrom));
        $dateStr = date('F Y', strtotime($model->billPeriodFrom));
        $subject = 'Axion - IFFCO TOKIO Bills & MIS - '.$dateStr;
        $message = '<div>Dear Sir,</div>
                    <div style="text-indent: 15px; margin-top: 5px;">Please find the attached bill and MIS for the month of '. $dateStr. '.Request you to kindly process the bill ASAP.</div>
                    <div style="margin-top: 15px;">Regards,</div>
                    <div>Mythili</div>';

        $smailer=\Yii::$app->itgibillingMailer->compose('/site/about',['message' => $message]);

        $from = ['mythili.gopi@axionpcs.in' => 'Mythili'];
        $to = $sbuHead->mail;
        $cc = ['anurag.kumar@iffcotokio.co.in' => 'Anurag', 'shubhanshu.sharma@iffcotokio.co.in' => 'Shubhanshu', 'deepankar.bharij@iffcotokio.co.in' => 'Deepankar', 'dk.jain@axionpcs.in' => 'Jain'];

        $mis = \Yii::$app->params['billingLoc'].'mis/ITGI-BILL-'.$model->billNumber.'.xls';
        $pdf = \Yii::$app->params['billingLoc'].'pdf/'.$model->billNumber."-".$date.'.pdf';

        if (!file_exists($mis))
            $this->saveITGIMis($model->id);

        if (!file_exists($pdf))
            $this->savePdf($model->id);
        
        // attach file from local file system
        $smailer->attach($pdf, ['fileName' => $model->billNumber.'-'.$date.'.pdf', 'contentType' => 'application/pdf']);
        $smailer->attach($mis, ['fileName' => 'BILL-'.$model->billNumber.'.xls', 'contentType' => 'application/vnd.ms-excel']);
           
        $smailer->setFrom($from)
                ->setTo($to)
                ->setCc($cc)
                ->setSubject($subject);

        if ($smailer->send())
        {
            $model->mailSent = 1;
            $model->save();

            if (file_exists($mis))
                unlink($mis);

            Yii::$app->session->setFlash("Success", "Mail successfully sent to <b>$to</b>");
            return $this->redirect(['summary']);
        }
    }

    public function actionPaymentUpdate($id){
        // return $id;
        $billSummary = AxionPreinspectionBilling::findOne(['id' => $id]);
        if (Yii::$app->request->isAjax && Yii::$app->request->post()) {
            
            // return json_encode(Yii::$app->request->post('AxionInvestigationBillingSummary'));
            // return $id;
            foreach ( Yii::$app->request->post('AxionPreinspectionBilling') as $field => $value) {      
                if($field == 'payment_received_on'){ $value = date('Y-m-d',strtotime($value)); }                 
                $billSummary->$field = $value;
            } 
            $billSummary->billStatus = 'Received';
            if($billSummary->save()){
                return json_encode(['status'=>'success']);
            }
        }else{
            $billSummary->payment_received_on = date('Y-m-d');
            return $this->renderAjax('payment-update', [
                'billSummary' => $billSummary
            ]);
        }
    }
}



