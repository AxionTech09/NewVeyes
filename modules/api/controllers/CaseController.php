<?php
namespace app\modules\api\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\AxionPreinspection;
use app\models\AxionPreinspectionSearch;
use app\models\AxionPreinspectionHistory;
use app\models\PreinspectionClientCaller;
use app\models\EmailHistory;
use app\models\AxionPreinspectionVehicle;
use app\models\AxionPreinspectionCommercial;
use app\models\AxionPreinspectionCommercialwheeler;
use app\models\AxionPreinspectionFwheeler;
use app\models\AxionPreinspectionTwowheeler;
use app\models\AxionPreinspectionPhotos;
use app\models\PreinspectionClientCompany;
use app\models\PreinspectionClientDivision;
use app\models\PreinspectionClientBranch;
use app\models\RoCaseAssignment;
use app\models\RoCaseAssignmentTracker;
use app\models\RoLastTracker;
use app\models\User;
use app\models\MasterSbu;
use app\models\MasterSbuHead;
use yii\rbac\DbManager;
use app\models\Logs;
use app\models\AxionPreinspectionBilling;
use app\models\MasterState;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use OpenTok\OpenTok;
use OpenTok\MediaMode;
use OpenTok\ArchiveMode;
use OpenTok\Session;
use OpenTok\Role;
use yii\web\Response;
use yii\web\JsonResponseFormatter;

class CaseController extends Controller
{
    public $modelClass = 'app\models\User';

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['fresh','create','qc','search'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['fresh','create','qc','search'],
                        'roles' => ['?'],
                    ],

                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'create' => ['post','get'],
                ],
            ],
        ];
    }

    public function beforeAction($action) 
    { 
        $this->enableCsrfValidation = false; 
        return parent::beforeAction($action); 
    }


    public function actionFresh()
    {



        $request = Yii::$app->request;

        $searchModel = new AxionPreinspectionSearch();
        $result = AxionPreinspection::find()
        ->where('status IN (0)')
        ->orderBy('referenceNo DESC, completedSurveyDateTime DESC')
        ->all();
        //return $this->asJson($result);

        return Yii::$app->api->sendSuccessResponse($result);

    }

    public function actionCreate(){

        $post = (file_get_contents("php://input"));
        $params = json_decode($post); 
        
        
        if (!empty($params)) {

            if(!isset($params->insurerName) || ($params->insurerName=="") ){
                $result = ["status" => 0,"message" => "Insurer Name is required"];
                return $this->asJson($result);
            }

            if(!isset($params->insurerDivision) || ($params->insurerDivision=="") ){
                $result = ["status" => 0,"message" => "Insurer Division is required"];
                return $this->asJson($result);
            }

            if(!isset($params->insurerBranch) || ($params->insurerBranch=="") ){
                $result = ["status" => 0,"message" => "Insurer Branch is required"];
                return $this->asJson($result);
            }

            if(!isset($params->callerName) || ($params->callerName=="") ){
                $result = ["status" => 0,"message" => "Caller Name is required"];
                return $this->asJson($result);
            }

            if(!isset($params->contactPersonMobileNo) || ($params->contactPersonMobileNo=="") ){
                $result = ["status" => 0,"message" => "ULN is required"];
                return $this->asJson($result);
            }


            $model = new AxionPreinspection();
            $model->vehicleType ="ALL-VEHICLE";
            $model->insurerName=$params->insurerName;
            $model->insurerDivision=$params->insurerDivision;
            $model->insurerBranch=$params->insurerBranch;
            $model->callerName=$params->callerName;
            $model->contactPersonMobileNo=$params->contactPersonMobileNo;
            $model->registrationNo=$params->registrationNo;
            $model->paymentMode=$params->paymentMode;
            date_default_timezone_set('Asia/Kolkata'); //India time (GMT+5:30)

            $model->created_on = date('Y-m-d H:i:s');
            $model->intimationDate = date('Y-m-d H:i:s');
            //$model->userId = Yii::$app->user->identity->id;
            $model->referenceNo = $this->getReferenceNo();
            $model->status = 0;

            if($model->save()) {    
                if($model->surveyorName != '' && $model->surveyorName == 0 && $model->insuredMobile != '')
                {
                    $this->createCustomerSession($model->id);
                }


                $twowheelermodel = new AxionPreinspectionTwowheeler();
                $twowheelermodel->preinspection_id = $model->id;
                $twowheelermodel->save();
                $fwheelermodel = new AxionPreinspectionFwheeler();
                $fwheelermodel->preinspection_id = $model->id;
                $fwheelermodel->save();
                $commercialwheelermodel = new AxionPreinspectionCommercialwheeler();
                $commercialwheelermodel->preinspection_id = $model->id;
                $commercialwheelermodel->save();

                $currentDateTime = date( 'Y-m-d H:i:s');
                $obj = $this->findModel($model->id);
                $hismodel = new AxionPreinspectionHistory();
                $hismodel->attributes = $obj->attributes;
                $hismodel->preinspection_id = $obj->id;
                $hismodel->id = 0;
                $hismodel->created_on = $currentDateTime;
                $hismodel->save();                   

            }else{
                return $this->asJson($model->getErrors());
            }
            $result = AxionPreinspection::find()
            ->where('id='.$model->id)
            ->all();


            return Yii::$app->api->sendSuccessResponse($result);

        } 
    }


    public function actionQc(){

        $post = (file_get_contents("php://input"));
        $params = json_decode($post); 


        if (!empty($params)) {
            $model = AxionPreinspection::findOne(['referenceNo' => $params->referenceNo]);
            $vehicleModel = AxionPreinspectionVehicle::findOne(['preinspection_id' => $model->id]);
            if(!empty($model)){
                $model->extraKM=$params->extraKM;
                $model->completedSurveyDateTime= date('Y-m-d h:i:s'); //$params->completedSurveyDateTime;
                $model->registrationNo=$params->registrationNo;
                $model->engineNo=$params->engineNo;
                $model->chassisNo=$params->chassisNo;
                $model->manufacturer=$params->manufacturer;
                $model->model=$params->model;

                $vehicleModel->odometerReading=$params->odometerReading;
                $vehicleModel->rcVerified=$params->rcVerified;
                $vehicleModel->fuelType=$params->fuelType;
                $vehicleModel->engineStatus=$params->engineStatus;
                $vehicleModel->rightWindowGlass=$params->rightWindowGlass;
                $vehicleModel->leftWindowGlass=$params->leftWindowGlass;
                $vehicleModel->frontwsGlassLaminated=$params->frontwsGlassLaminated;            
                $vehicleModel->backGlass=$params->backGlass;
                $model->remarks=$params->remarks;
                $model->status=$params->status;
                $model->surveyorName=$params->surveyorName;
                //$model->vType=$params->vType;

                date_default_timezone_set('Asia/Kolkata'); //India time (GMT+5:30)
                $statusArr=[0=>'followupReason',1=>'Intimation Re-Schedule',8=>'Survey Done',9=>'Cancelled',12=>   'Schedule-CustomerAppointment',100=>'Change RO',101=>'PI-Recommended',102=>'PI-Not Recommended',103=>'PI-Inprogress',104=>'PI-Refer to Under Writer'];
                if($model->status ==  101)
                {
                    $recommended = "Yes";
                    $status = "Approved";
                }
                else
                {
                    $recommended = "No";
                    $status = "Rejected";
                }


                if($model->save()){
                    $vehicleModel->save();
                    $user = User::find()->where('id='.$model->callerName)->one();
                    $surveyor = User::find()->where('id='.$model->surveyorName)->one();


                    $arr = [];

                    $arr["Registration_Number"] = $model->registrationNo;
                    $arr["Address"] = $model->surveyLocation2;
                    $arr["Field_Executive_Name_or_ID"] = $surveyor->firstName;
                    $arr["Field_Executive_Contact_Number"] = $surveyor->mobile;
                    $arr["Customer_Name"] = $user->firstName;
                    $arr["Customer_Contact_Number"] = $user->mobile;
                    $arr["Vehicle_Type"] = $vehicleModel->vType;
                    $arr["CaseType"] = $model->vehicleTypeRadio;
                    $arr["Mail_ID"] = $user->email;
                    $arr["ReferenceNo"] = $model->referenceNo;
                    $arr["Fuel_type"] = $vehicleModel->fuelType;
                    $arr["Vehicle_Make"] = $model->manufacturer;
                    $arr["Vehicle_Model"] = $model->model;
                    $arr["Year_of_Manufacture"] = $model->manufacturingYear;
                    $arr["Engine_Number"] = $model->engineNo;
                    $arr["Chassis_Number"] = $model->chassisNo;
                    $arr["Odometer_Reading"] = $vehicleModel->odometerReading;
                    $arr["ErrorCode"] = null;

                    $arr["ErrorMessage"] = null;
                    $arr["Created"] = $model->created_on;
                    $arr["CaseStatus"] = $status;
                    $arr["Remarks"] = $model->remarks;
                    $arr["Engine_in_Working_Condition"] = $vehicleModel->engineStatus ? 'Yes':'No';
                    //$arr["Central_Locking_Available"] = $model->registrationNo;
                    $arr["RC_Copy"] = $vehicleModel->rcVerified;
                    $arr["Recommended"] = $recommended;
                    $arr["ApporvedDate"] = ($status=='Approved') ? $model->completedSurveyDateTime : '';
                    $arr["Rejected Date"] = ($status!='Approved') ? $model->completedSurveyDateTime : '';

                    return Yii::$app->api->sendSuccessResponse($arr);

                }else{
                    return $this->asJson($model->getErrors());
                }

            }
            else{
                $result = ["status" => 0,"message" => "Record not found"];
                return $this->asJson($result);
            }
        }
    }


    protected function findModel($id)
    {
        if (($model = AxionPreinspection::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function getReferenceNo()
    {
        if (($model = AxionPreinspection::find()->orderBy(['id' => SORT_DESC])->one()) !== null) {
            return ($model->referenceNo) + 1;
        } else {
            return 6130;
        }
    }


    public function actionSearch()
    {

        $headers = apache_request_headers();
        if ($headers['Authorization'] != 'Basic UlNHSTpSU0dJQFZleWVz') {
            return Yii::$app->api->sendFailedResponse('Authorization failure');
        }

        $post = (file_get_contents("php://input"));
        $params = json_decode($post); 

        if (!empty($params)) {
            $inspectionArr=[];

            if(!empty($params->Registration_Number) || !empty($params->Engine_Number) || !empty($params->Chassis_Number)){

                $query = AxionPreinspection::find();
                if($params->Registration_Number && $params->Registration_Number != "") {             
                    $query->where(["trim(`registrationNo`)" => trim($params->Registration_Number)]);
                }
                if($params->Engine_Number && $params->Engine_Number != "") {
                    $query->andFilterWhere(["trim(`engineNo`)" => trim($params->Engine_Number)]);
                }
                if($params->Chassis_Number && $params->Chassis_Number != "") {
                    $chassisNo = substr(trim($params->Chassis_Number), -6);
                    $query->andFilterWhere(["trim(`chassisNo`)" => $chassisNo]);
                }
                //return Yii::$app->api->sendFailedResponse($query->createCommand()->getRawSql());
                $inspectionArr = $query->all();

                /*if (empty($inspectionArr))
                {
                    $query = AxionPreinspection::find();
                    if( ($params->Registration_Number && $params->Registration_Number != "") && ($params->Engine_Number && $params->Engine_Number != "")) {             
                        $query->where(["trim(`registrationNo`)" => trim($params->Registration_Number)])->andFilterWhere(["trim(`engineNo`)" => trim($params->Engine_Number)]);
                        $inspectionArr = $query->all();
                    }
                    
                }*/

                if (empty($inspectionArr) || empty($inspectionArr[0]))
                {
                    $query = AxionPreinspection::find();
                    if(($params->Engine_Number && $params->Engine_Number != "") && ($params->Chassis_Number && $params->Chassis_Number != "")) {
                        $chassisNo = substr(trim($params->Chassis_Number), -6);
                        $query->where(["trim(`engineNo`)" => trim($params->Engine_Number)])->andFilterWhere(["trim(`chassisNo`)" => $chassisNo]);
                        $resArr = $query->orderBy('completedSurveyDateTime DESC')->all();
                        $inspectionArr = [];
                        $inspectionArr[] = $resArr[0];
                    }
                }
                
                /*if (empty($inspectionArr))
                {
                    $query = AxionPreinspection::find();
                    if(($params->Registration_Number && $params->Registration_Number != "") && ($params->Chassis_Number && $params->Chassis_Number != "") ) {
                        $chassisNo = substr(trim($params->Chassis_Number), -6);
                        $query->where(["trim(`registrationNo`)" => trim($params->Registration_Number)])->andFilterWhere(["trim(`chassisNo`)" => $chassisNo]);
                        $inspectionArr = $query->all();
                    }
                }*/

                if(empty($inspectionArr) || empty($inspectionArr[0]))
                {

                    $query = AxionPreinspection::find();
                    if($params->Registration_Number && $params->Registration_Number != "") {             
                        $query->where(["trim(`registrationNo`)" => trim($params->Registration_Number)]);
                    }
                    /*if($params->Engine_Number && $params->Engine_Number != "") {
                        $query->orWhere(["trim(`engineNo`)" => trim($params->Engine_Number)]);
                    }
                    if($params->Chassis_Number && $params->Chassis_Number != "") {
                        $chassisNo = substr(trim($params->Chassis_Number), -6);
                        $query->orWhere(["trim(`chassisNo`)" => $chassisNo]);
                    }*/
                    //return Yii::$app->api->sendFailedResponse($query->createCommand()->getRawSql());
                    $resArr = $query->orderBy('completedSurveyDateTime DESC')->all();
                    $inspectionArr = [];
                    $inspectionArr[] = $resArr[0];
                }

                $resultArr = [];
                if(!empty($inspectionArr) && !empty($inspectionArr[0])){

                    foreach($inspectionArr as $model){
                        $arr = [];
                        $vehicleModel = $model->vType; //AxionPreinspectionVehicle::findOne(['preinspection_id' => $model->id]);
                        $user = $model->callerFirstName; //User::find()->where('id='.$model->callerName)->one();
                        $surveyor = $model->valuatorUser; //User::find()->where('id='.$model->surveyorName)->one();

                        if($model->status ==  101)
                        {
                            $recommended = "Yes";
                            $status = "Approved";
                        }
                        else
                        {
                            $recommended = "No";
                            $status = "Rejected";
                        }

                        /*$arr["Address"] = $model->surveyLocation2;
                        $arr["Field_Executive_Name_or_ID"] = $surveyor->firstName;
                        $arr["Field_Executive_Contact_Number"] = $surveyor->mobile;
                        $arr["Customer_Name"] = $user->firstName;
                        $arr["Customer_Contact_Number"] = $user->mobile;
                        $arr["Vehicle_Type"] = $vehicleModel->vType;
                        $arr["CaseType"] = $model->vehicleTypeRadio;
                        $arr["Mail_ID"] = $user->email;          
                        $arr["Fuel_type"] = $vehicleModel->fuelType;
                        $arr["Vehicle_Make"] = $model->manufacturer;
                        $arr["Vehicle_Model"] = $model->model;
                        $arr["Year_of_Manufacture"] = $model->manufacturingYear;
                        
                        $arr["Odometer_Reading"] = $vehicleModel->odometerReading;
                        $arr["ErrorCode"] = null;
                        $arr["ErrorMessage"] = null;
                        $arr["Created"] = $model->created_on;
                        $arr["CaseStatus"] = $status;
                        $arr["Remarks"] = $model->remarks;
                        $arr["Engine_in_Working_Condition"] = $vehicleModel->engineStatus ? 'Yes':'No';
                        //$arr["Central_Locking_Available"] = $model->registrationNo;
                        $arr["RC_Copy"] = $vehicleModel->rcVerified;
                        $arr["ApporvedDate"] = ($status=='Approved') ? $model->completedSurveyDateTime : '';
                        $arr["Rejected Date"] = ($status!='Approved') ? $model->completedSurveyDateTime : '';*/

                        $arr["Registration_Number"] = $model->registrationNo;
                        $arr["Engine_Number"] = $model->engineNo;
                        $arr["Chassis_Number"] = $model->chassisNo;
                        $arr["ReferenceNo"] = $model->referenceNo;
                        $arr["Recommended"] = $recommended;
                        $arr["Report_DateTime"] = $model->completedSurveyDateTime;

                        if (in_array($model->status, [101, 102, 103, 104]))
                        {
                            $link = Yii::$app->urlManager->createAbsoluteUrl('axion-preinspection/vehicleqcpdf?id='.$model->id);
                            $arr["link"] = $link;
                        }else{
                            $arr["link"] = 'File Not Found..!';
                        }
                        
                        $resultArr[] = $arr;

                    }
                }
            }
            
            if ($resultArr)
                return Yii::$app->api->sendSuccessResponse($resultArr);
            else 
                return Yii::$app->api->sendSuccessResponse(['No matching record found']);
            
        }

    }

    public function createApi($auth="PuwoFFOP+Zr2wtaTjv9KnQ==",$userId="2620568A-52FD-495E-BAD5-B869FBA8E19F",$divisionId=false,$stateId=false){

        $url = "https://tataaig.vahancheck.com/VCWebAPI/api/InspectionLeadInbox/GetLeadInBoxForAgencySM_UserId";
        $method = "POST";
        $fields =  array(
            "UserId" => $userId,
            "AgencyId" => "1"
        );

        $result = $this->curl($auth, $url, $method, json_encode($fields));
        if($result){
            $data = json_decode($result);   
            //echo '<pre>';print_r($data);exit; 
            if($data){
                $insurer = PreinspectionClientCompany::find()->where(['like', 'companyName', "TATA AIG" . '%', false])->one();

                foreach($data as $row){
                    date_default_timezone_set('Asia/Kolkata');
                    $currentDateTime = date('Y-m-d H:i:s');
                    $createdMonth = date("Ym",strtotime($row->CreatedDateTime));
                    $currentMonth = date("Ym",strtotime("-1 Months"));


                    if ( $createdMonth < $currentMonth ) {
                        continue;
                    }

                    //echo '<pre>';print_r($row);exit; 
                    
                    $exist = AxionPreinspection::findOne(['contactPersonMobileNo' => $row->LeadID]);  
                    //echo '<pre>';print_r($model);exit;                  
                    if(!$exist){

                        $query = User::find();
                        $query->join('LEFT JOIN','auth_assignment','auth_assignment.user_id = id')
                        ->andWhere(['auth_assignment.item_name' => 'BO User'])
                        ->andWhere(['users.stateId' => $stateId]);

                        $userData = $query->one();

                        $getinsurerBranch = PreinspectionClientBranch::find(['companyId' => $insurer->id, 'divisionId' => $divisionId])->one();
                        

                        $emails = ($row->ProposerEmailId) ? explode(",", $row->ProposerEmailId) : '';
                        $user='';
                        if($emails){
                            $user = isset($emails[0]) ? User::findOne(['email' => trim($emails[0])]) : '';
                            if(!$user && isset($emails[1])){
                                $user =  User::findOne(['email' => trim($emails[1])]);
                            }

                            if(!$user && isset($emails[0])){
                                $userModel = new User();
                                $userModel->scenario='api-create';
                                $userModel->activationLink = 'Y';
                                $userModel->createdOn = $currentDateTime;
                                $userModel->password = "123456";
                                $userModel->email = $emails[0];
                                $userModel->firstName = $row->ProposerorRepresentative;
                                if($divisionId){
                                    $userModel->companyId = ($insurer) ? $insurer->id : '';
                                    $userModel->divisionId = $divisionId;
                                    $userModel->branchId = @$getinsurerBranch->id;                                    
                                }
                                if($userModel->save())
                                {
                                    $auth = new DbManager;
                                    $auth->init();
                                    $role = $auth->getRole('Branch Executive');
                                    $auth->assign($role, $userModel->id);
                                    $user = $userModel;
                                }
                            }elseif(!empty($user)){
                                $user->scenario='api-create';
                                $user->email = $user->email;
                                $user->password = "123456";
                                $user->firstName = $row->ProposerorRepresentative;
                                if($divisionId){
                                    $user->companyId = ($insurer) ? $insurer->id : '';                                   
                                    $user->divisionId = $divisionId;                                   
                                    $user->branchId = @$getinsurerBranch->id;                                             
                                    $user->save();                    
                                }
                            }
                        }
                        else if(!$user) // If email id is empty
                        {
                            $query = User::find();
                            $query->join('LEFT JOIN','auth_assignment','auth_assignment.user_id = id')
                            ->andWhere(['auth_assignment.item_name' => 'Branch Executive'])
                            ->andWhere(['users.roId' => @$userData->id]);

                            $user = $query->one();
                        }


                        $model = new AxionPreinspection();
                        $model->referenceNo = $this->getReferenceNo();
                        $model->created_on = $currentDateTime;
                        $model->intimationDate = $currentDateTime;
                        $model->status = 0;

                        $model->insurerName = ($insurer) ? $insurer->id : '';
                        $model->manufacturer = $row->Make;
                        $model->model = $row->Models;
                        
                        if($user){
                            $model->userId = $userData->id;
                            $model->fristRoid = $userData->id;
                            $model->stateId = $stateId;
                            $model->callerName = $user->id;
                            $model->callerMobileNo = $user->mobile;
                            $model->callerDetails = $user->email;

                            $model->insurerDivision = ($user->divisionId) ? $user->divisionId : $divisionId;
                            $model->insurerBranch = $user->branchId;
                        }

                        $model->inspectionType = "Break In";
                        $model->registrationNo = $row->VehicleRegNo;
                        /*$insuredName = $row->Insurername;
                        if($row->CustomerFname || $row->CustomerLname){
                            $insuredName = $insuredName." - ".$row->CustomerFname." ".$row->CustomerLname;
                        }*/
                        $insuredName="";
                        if($row->CustomerFname || $row->CustomerLname){
                            $insuredName = $row->CustomerFname." ".$row->CustomerLname;
                        }
                        $checkPayment = AxionPreinspection::find()->where(['like','registrationNo','%'.$row->VehicleRegNo.'%',false])->andwhere(['between', 'intimationDate',$prefirstday,$today])->all();
                        if ($row->Lead_Payment_Status == 'Company Paid' && count($checkPayment) == 0)
                        {
                            $paymentMode = 1;
                        }
                        else if ($row->Lead_Payment_Status == 'Customer Paid')
                        {
                            $paymentMode = 2;
                        }
                        $model->insuredName = $insuredName;
                        $model->insuredMobile = $row->CustomerContactNo;
                        $model->engineNo = $row->EngineNo;
                        $model->chassisNo = $row->ChassisNo;
                        $model->paymentMode = $paymentMode;
                        $model->remarks = $row->Remark;
                        $model->contactPersonMobileNo = $row->LeadID;
                        $model->surveyLocation = $row->CustomerAddress1;
                        $model->insuredAddress = $row->CustomerCityName;
                        $model->createMethod = 'Api';
                        //echo '<pre>';print_r($model);exit;

                        if ($model->save()) {
                            $twowheelermodel = new AxionPreinspectionTwowheeler();
                            $twowheelermodel->preinspection_id = $model->id;
                            $twowheelermodel->save();
                            $fwheelermodel = new AxionPreinspectionFwheeler();
                            $fwheelermodel->preinspection_id = $model->id;
                            $fwheelermodel->save();
                            $commercialwheelermodel = new AxionPreinspectionCommercialwheeler();
                            $commercialwheelermodel->preinspection_id = $model->id;
                            $commercialwheelermodel->save();                            
                            
                            //updating qc
                            $this->updateQc($model, 'insert');                            
                            $currentDateTime = date( 'Y-m-d H:i:s');
                            $obj = $this->findModel($model->id);
                            $hismodel = new AxionPreinspectionHistory();
                            $hismodel->attributes = $obj->attributes;
                            $hismodel->preinspection_id = $obj->id;
                            $hismodel->id = 0;
                            $hismodel->created_on = $currentDateTime;
                            $hismodel->save();
                        }else{
                            //echo '<pre>';print_r($model->getErrors());exit;
                            $leadNumber = $row->LeadID;
                            $message = json_encode($model->getErrors());
                            $request = json_encode($model->attributes);
                            $this->log($leadNumber,$message,$request);
                        }

                        /*if(!$model->save()){
                            print_r($model->getErrors());exit;
                        }*/
                    }
                }
                $res = "Created Case Successfully";
            }else{
                $res = "No Results Found";
            }

        }
        else{
            $res = "No Results Found";
        }

        return $res;
    }


    public function curl($auth="PuwoFFOP+Zr2wtaTjv9KnQ==", $url, $method="GET", $fields=false){
        $curl = curl_init();

        //  "authorization: Basic PuwoFFOP+Zr2wtaTjv9KnQ==",

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_POSTFIELDS => $fields,
            CURLOPT_HTTPHEADER => array(
                "authorization: Basic $auth",
                "content-type: application/json"
            ),
        ));

        $response = curl_exec($curl);


        $err = curl_error($curl);

        if($err){
            $response = false;
        }
        // curl_close($curl);
        return $response;

    }

    //create request for Tamilnadu
    public function actionCreateTn(){
        $auth = base64_encode("axion:Pass@123");
        $userId = "2620568A-52FD-495E-BAD5-B869FBA8E19F";
        $divisionId = 5;
        $stateArr = ["Tamilnadu","TAMILNADU","Tamil Nadu","TAMIL NADU","Tamil nadu","tamilnadu"];
        $state =$this->getState($stateArr);
        $stateId = ($state) ? $state->id : '';
        return $this->createApi($auth,$userId,$divisionId,$stateId);
    }

    //create request for Kerala
    public function actionCreateKl(){
        $auth = base64_encode("axionker:Pass@123");
        $userId = "AFA56E42-25E1-4BC2-9DAE-E7EB68ECBC5A";
        $divisionId = 7;
        //$stateId = 3;
        $stateArr = ["Kerala","KERALA","kerala"];
        $state =$this->getState($stateArr);
        $stateId = ($state) ? $state->id : '';
        return $this->createApi($auth,$userId,$divisionId,$stateId);
    }

    //create request for Maharastra
    public function actionCreateMh(){
        $auth = base64_encode("axion1:Pass@1234");
        $userId = "97D9EEFB-A0B4-41DE-BE92-1200C9C1E7A3";
        $divisionId = 71;
        //$stateId = 6;
        $stateArr = ["Maharashtra","MAHARASHTRA","maharashtra"];
        $state =$this->getState($stateArr);
        $stateId = ($state) ? $state->id : '';
        return $this->createApi($auth,$userId,$divisionId,$stateId);
    }

    //create request for Delhi
    public function actionCreateDel(){
        $auth = base64_encode("axiondel:Pass@123");
        $userId = "2620568A-52FD-495E-BAD5-B869FBA8E19F";
        $divisionId = 5;
        //$stateId = 14;
        $stateArr = ["DELHI","Delhi","delhi"];
        $state =$this->getState($stateArr);
        $stateId = ($state) ? $state->id : '';
        return $this->createApi($auth,$userId,$divisionId,$stateId);
    }

    //create request for Karnataka
    public function actionCreateKn(){
        $auth = base64_encode("axionkar:Pass@1234");
        $userId = "B37D2F49-23C6-4AB2-AF33-93F3E88B835E";
        $divisionId = 47;
        //$stateId = 1;
        $stateArr = ["KARNATAKA","Karnataka","karnataka"];
        $state =$this->getState($stateArr);
        $stateId = ($state) ? $state->id : '';
        return $this->createApi($auth,$userId,$divisionId,$stateId);
    }

    //create request for Andhra/Telugana
    public function actionCreateAp(){
        $auth = base64_encode("axionap:Pass@123");
        $userId = "979678EE-DC89-4E32-8B6F-B18B208033D0";
        $divisionId = 14;
        //$stateId = 5;
        $stateArr = ["Andhra Pradesh","andhra pradesh","ANDHRA PRADESH"];
        $state =$this->getState($stateArr);
        $stateId = ($state) ? $state->id : '';
        return $this->createApi($auth,$userId,$divisionId,$stateId);
    }

    //create request for Bihar
    public function actionCreateBh(){
        $auth = base64_encode("axionbr:Pass@1234");
        $userId = "8A72527A-BF3B-4DAA-968F-37FC7A9AFD8C";
        $divisionId = 33;
        //$stateId = 10;
        $stateArr = ["Bihar","BIHAR","bihar"];
        $state =$this->getState($stateArr);
        $stateId = ($state) ? $state->id : '';
        return $this->createApi($auth,$userId,$divisionId,$stateId);
    }


    public function actionCreateRequest(){
        $post = (file_get_contents("php://input"));
        $params = json_decode($post); 
        if (!empty($params)) {
            $contactPersonMobileNo = (($params->contactPersonMobileNo) && ($params->contactPersonMobileNo) ) ? $params->contactPersonMobileNo : "";
            $registrationNo = (isset($params->registrationNo) && ($params->registrationNo) ) ? $params->registrationNo : "";
            $initiatorEmailId = (isset($params->initiatorEmailId) && ($params->initiatorEmailId) ) ? $params->initiatorEmailId : "";
            $insurerName = (isset($params->insurerName) && ($params->insurerName) ) ? $params->insurerName : "";
            $insuredName = (isset($params->insuredName) && ($params->insuredName) ) ? $params->insuredName : "";
            $insuredMobile = (isset($params->insuredMobile) && ($params->insuredMobile) ) ? $params->insuredMobile : "";
            $insuredAddress = (isset($params->insuredAddress) && ($params->insuredAddress) ) ? $params->insuredAddress : "";
            $paymentMode = (isset($params->paymentMode) && ($params->paymentMode) ) ? $params->paymentMode : "";
            $initiatorName = (isset($params->initiatorName) && ($params->initiatorName) ) ? $params->initiatorName : "";
            $initiatorMobile = (isset($params->initiatorMobile) && ($params->initiatorMobile) ) ? $params->initiatorMobile : "";

            $error=[];
            if(!$contactPersonMobileNo){
                $error[] = ["field"=>"contactPersonMobileNo","message" => "Case ID is required"];
            }

            if(!$registrationNo){
                $error[] = ["field"=>"registrationNo","message" => "Registration Number is required"];
            }

            if(!$initiatorEmailId){
                $error[] = ["field"=>"initiatorEmailId","message" => "Initiator Email is required"];
            }

            if(!$insurerName){
                $error[] = ["field"=>"insurerName","message"=> "Insurer Name is required"];
            }

            if(!$insuredName){
                $error[] = ["field"=>"insuredName","message"  => "Insured Name is required"];
            }

            if(!$insuredMobile){
                $error[] = ["field"=>"insuredMobile","message"=> "Insured Mobile is required"];
            }

            if(!$insuredAddress){
                $error[] = ["field"=>"insuredAddress","message" => "Insured Address is required"];
            }

            if(!$paymentMode){
                $error[] = ["field"=>"paymentMode","message"=> "Payment Mode is required"];
            }

            if(!empty($error)){
                return $this->asJson($error);
            }
            date_default_timezone_set('Asia/Kolkata');
            $currentDateTime = date( 'Y-m-d H:i:s');
            $user = User::findOne(['email' => trim($initiatorEmailId)]);

            if(!$user){
                $userModel = new User();
                $userModel->scenario='api-create';
                $userModel->activationLink = 'Y';
                $userModel->createdOn = $currentDateTime;
                $userModel->password = "123456";
                $userModel->email = $initiatorEmailId;
                $userModel->firstName = $initiatorName;
                if($userModel->save())
                {
                    $auth = new DbManager;
                    $auth->init();
                    $role = $auth->getRole('Branch Executive');
                    $auth->assign($role, $userModel->id);
                }
            }


            $model = new AxionPreinspection();
            $model->vehicleType ="ALL-VEHICLE";                    
            $model->referenceNo = $this->getReferenceNo();
            $model->insurerName=$insurerName;
            $model->insuredName=$insuredName;
            $model->insuredMobile=$insuredMobile;
            $model->insuredAddress=$insuredAddress;
            $model->contactPersonMobileNo=$contactPersonMobileNo;
            $model->registrationNo=$registrationNo;
            $model->paymentMode=$paymentMode;
            $model->inspectionType = "Break In";

            $model->created_on = $currentDateTime;
            $model->intimationDate = $currentDateTime;
            $model->referenceNo = $this->getReferenceNo();
            $model->status = 0;

            if($user){
                $model->callerName = $user->id;
                $model->callerMobileNo = $user->mobile;
                $model->callerDetails = $user->email;
                $model->insurerDivision = $user->divisionId;
                $model->insurerBranch = $user->branchId;

            }

            if(!$model->save()) {    
                return $this->asJson($model->getErrors());
            }

            $result = [
                "contactPersonMobileNo" => $model->contactPersonMobileNo,
                "registrationNo" => $model->registrationNo,
                "initiatorEmailId" => $initiatorEmailId,
                "initiatorName" => $initiatorName,
                "initiatorMobile" => $initiatorName,
                "insurerName" => "Raheja QBE General Insurance Company Limited ",
                "insuredName" => $model->insuredName,
                "insuredMobile" => $model->insuredMobile,
                "insuredAddress" => $model->insuredAddress,
                "paymentMode" => $paymentMode,
                "referenceNo" => $model->referenceNo,
                "status" => "0" 

            ];

            return Yii::$app->api->sendSuccessResponse($result);
        } 
    }

    public function log($num=false,$message=false,$request=false){
            date_default_timezone_set('Asia/Kolkata'); //India time (GMT+5:30)
            $model = new Logs();
            $model->createdOn = date('Y-m-d H:i:s');
            $model->leadNumber = $num;
            $model->message = $message;
            $model->request = $request;
            if(!$model->save(false)) {    
                return $this->asJson($model->getErrors());
            }else{
                return true;
            }
        }

        protected function insertQcImageRecord($preinspectionId,$type)
        {
            $phmodel = new AxionPreinspectionPhotos();
            $phmodel->preinspection_id = $preinspectionId;
            $phmodel->type = $type;
            $phmodel->save();
        }
        
        protected function updateQc($preModel,$updateType)
        {
            if($preModel->vehicleType == 'ALL-VEHICLE')
            {
                if($updateType == 'insert')
                {
                    $countPosts = AxionPreinspectionVehicle::find()
                    ->where(['preinspection_id' => $preModel->id])
                    ->count();

                    if($countPosts == 0)
                    {
                        $model = new AxionPreinspectionVehicle();
                        $model->preinspection_id = $preModel->id;
                        $model->save();
                        
                        $this->insertQcImageRecord($preModel->id, 'chassisThumb');
                        $this->insertQcImageRecord($preModel->id, 'frontViewNumberPlate');
                        $this->insertQcImageRecord($preModel->id, 'enginePhoto');
                        $this->insertQcImageRecord($preModel->id, 'frontBumper');
                        $this->insertQcImageRecord($preModel->id, 'frontLeftCorner45');
                        $this->insertQcImageRecord($preModel->id, 'leftSideFullView');
                        $this->insertQcImageRecord($preModel->id, 'leftQtrPanel');
                        $this->insertQcImageRecord($preModel->id, 'rearViewImage');
                        $this->insertQcImageRecord($preModel->id, 'rearBumper');
                        $this->insertQcImageRecord($preModel->id, 'dickyOpenImage');
                        $this->insertQcImageRecord($preModel->id, 'cngLpgKit');
                        $this->insertQcImageRecord($preModel->id, 'underChassis');
                        $this->insertQcImageRecord($preModel->id, 'rightQtrPanel');
                        $this->insertQcImageRecord($preModel->id, 'rightSideFullView');
                        $this->insertQcImageRecord($preModel->id, 'frontRightCorner45');
                        $this->insertQcImageRecord($preModel->id, 'chassisPlate');
                        $this->insertQcImageRecord($preModel->id, 'dashBoardPhoto');
                        $this->insertQcImageRecord($preModel->id, 'odometerReading');
                        $this->insertQcImageRecord($preModel->id, 'odometerWithRPMReading');
                        $this->insertQcImageRecord($preModel->id, 'closeupViewOfOdometerReading'); 
                        $this->insertQcImageRecord($preModel->id, 'frontWindshieldFromOutside');
                        $this->insertQcImageRecord($preModel->id, 'rcCopy');
                        $this->insertQcImageRecord($preModel->id, 'rcImageBack');
                        $this->insertQcImageRecord($preModel->id, 'preInsuranceCopy');
                        $this->insertQcImageRecord($preModel->id, 'dentsScratchImage1');
                        $this->insertQcImageRecord($preModel->id, 'dentsScratchImage2');
                        $this->insertQcImageRecord($preModel->id, 'dentsScratchImage3');
                        //$this->insertQcImageRecord($preModel->id, 'BO-Others-1');
                        //$this->insertQcImageRecord($preModel->id, 'BO-Others-2');
                        //$this->insertQcImageRecord($preModel->id, 'BO-Others-3');
                        //$this->insertQcImageRecord($preModel->id, 'BO-Others-4');
                        $this->insertQcImageRecord($preModel->id, 'vehicleVideo');   
                    }
                    
                    if($preModel->completedSurveyDateTime == 'NULL')
                    {
                        alert('please give completedSurveyDateTime');
                    }


                }
                //deleting record
                if($updateType == 'delete')
                {
                    AxionPreinspectionVehicle::deleteAll(['preinspection_id' => $preModel->id]);
                    AxionPreinspectionPhotos::deleteAll(['preinspection_id' => $preModel->id]);
                }
            }
            
        }

        public function actionTest(){

        // $ch = curl_init();
           $url = "http://125.22.81.132/eai_ws_enu/start.swe?SWEExtSource=WSWebService&SWEExtCmd=Execute";
           $str='<?xml version="1.0" encoding="UTF-8"?>
           <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:cus="http://siebel.com/CustomUI">
           <soapenv:Header/>
           <soapenv:Body>
           <cus:ITGIMotorPreInspectionAgencyRecommendationResponse_Input>
           <!--Optional:-->
           <cus:LatitudeLongitude>123314143</cus:LatitudeLongitude>
           <cus:PreInspectionNumber>1-6PEM1KF</cus:PreInspectionNumber>
           <cus:RecommendationResponse>Inspection Agency Assigned</cus:RecommendationResponse>
           <cus:InspectionLocation>3123123</cus:InspectionLocation>
           <cus:PreInspectionIntegrationId>2</cus:PreInspectionIntegrationId>
           <!--Optional:-->
           <cus:Remarks>this is for testing purrose</cus:Remarks>
           <!--Optional:-->
           <cus:ChassisNumber>413413</cus:ChassisNumber>
           <!--Optional:-->
           <cus:EngineNumber>123213</cus:EngineNumber>
           <!--Optional:-->
           <cus:InspectionDateTime>08/17/2021 15:35:00</cus:InspectionDateTime>
           </cus:ITGIMotorPreInspectionAgencyRecommendationResponse_Input>
           </soapenv:Body>
           </soapenv:Envelope>';

           $headers = array(
               "Content-type: application/xml;charset=\"utf-8\"",
               "Accept: text/xml",
               "Cache-Control: no-cache",
               "Pragma: no-cache",
               'SOAPAction:"document/http://siebel.com/CustomUI:ITGIMotorPreInspectionAgencyRecommendationResponse"',
               "Content-length: ".strlen($str),
           );
           $ch = curl_init();
           curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
           curl_setopt($ch, CURLOPT_URL, $url);
           curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
         //curl_setopt($ch, CURLOPT_USERPWD, $soapUser.":".$soapPassword); // username and password - 
           curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
           curl_setopt($ch, CURLOPT_TIMEOUT, 10);
           curl_setopt($ch, CURLOPT_POST, true);
         curl_setopt($ch, CURLOPT_POSTFIELDS, $str); // the SOAP request
         curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);


         // converting
         $response = curl_exec($ch);
         //echo json_encode(curl_error($ch));
         echo $response;
         exit;
         curl_close($ch);    
    }

    /**
     * Lists all Preinspecton models.
     * @return mixed
     */
    public function actionCompanyBilling()
    {
        $searchModel = new AxionPreinspectionSearch();
        $companies = PreinspectionClientCompany::find()->where(['companyStatus' => 'Active'])->all();

        if($companies){     
            date_default_timezone_set('Asia/Kolkata');
            /* $fromDateTime = date('Y-m-d 00:00:00',strtotime('first day of last month'));
            $toDateTime = date('Y-m-d 23:59:59',strtotime('last day of last month')); 
            $fromDate = date('Y-m-d',strtotime('first day of last month'));
            $toDate = date('Y-m-d',strtotime('last day of last month')); */

            $fromDateTime = '2023-04-01 00:00:00';
            $toDateTime = '2023-04-30 23:59:59';
            $fromDate = '2023-04-01';
            $toDate = '2023-04-30';

            $currentDateTime = date('Y-m-d H:i:s');

            foreach($companies as $company)
            {
                $billType = $company->billType;
                $companyId = $company->id;
   				if ($companyId == 5)
   			    {
	                if ($billType == 'SBU Bill') 
	                {
	                    $sbuHeads = MasterSbuHead::find()->where(['sbuHeadStatus' => 'Active'])->all();
	                    
	                    foreach($sbuHeads as $key => $sbuHeadRow)
	                    {
	                        $sbuHeadId = $sbuHeadRow->id;
	                        $stateId = $sbuHeadRow->stateId;

	                        if($sbuHeadId != NULL || $sbuHeadId != '') 
	                        {
	                            $query = $searchModel->sbuLevel($companyId, $fromDateTime, $toDateTime, $sbuHeadId);

	                            $oldQuery = clone $query;
	                            $query->select([new Expression('SUM(CASE WHEN `paymentMode` = 1 THEN extraKM ELSE 0 END) as totalKm'),new Expression('COUNT(av2.id) as total2W'),new Expression('COUNT(av3.id) as total3W'),new Expression('COUNT(av4.id) as total4W'),new Expression('COUNT(avc.id) as totalCW'),'pc.companyName','pc.billType','pc.rate2Wheeler','pc.rate3Wheeler','pc.rate4Wheeler','pc.rateCommercial','pc.rateConveyance','pc.billingAddress']);                           
	                            $res = $query->one();                                                

	                            $totalKm =  $res->totalKm ?  $res->totalKm : 0;
	                            $total2W =  $res->total2W ?  $res->total2W : 0;
	                            $total3W =  $res->total3W ?  $res->total3W : 0;
	                            $total4W =  $res->total4W ?  $res->total4W : 0;
	                            $totalCW =  $res->totalCW ?  $res->totalCW : 0;

	                            $arr = [
	                                "totalKm" => $totalKm,
	                                "total2W" => $total2W,
	                                "total3W" => $total3W,
	                                "total4W" => $total4W,
	                                "totalCW" => $totalCW                                
	                            ];

	                            $model = new AxionPreinspectionBilling();
	                            $model->companyId = $companyId;
	                            $model->billType = $billType;
	                            $model->stateId = $stateId;
	                            $model->branchId = "";
	                            $model->sbuHeadId = $sbuHeadId;
	                            $model->billPeriodFrom = $fromDate;
	                            $model->billPeriodTo = $toDate;
	                            $model->billDetails = json_encode($arr);  
	                            $model->billStatus = "Initiated";
	                            $model->createdOn = $currentDateTime;
	                            
	                            if($totalKm > 0 || $total2W > 0 || $total4W > 0|| $totalCW > 0){
	                                $exist = AxionPreinspectionBilling::find()->where(['companyId' => $companyId, 'billType' => $billType, 'billPeriodFrom' => $fromDate,'billPeriodTo' => $toDate, 'sbuHeadId' => $sbuHeadId])->one();
	                                if(!$exist){
	                                    if($model->save()){                      
	                                        $inspections = $oldQuery->select(['axion_preinspection.id'])->asArray()->all();
	                                        if($inspections){
	                                            $inspectionsArr=ArrayHelper::map($inspections,'id','id');
	                                            $result = AxionPreinspection::updateAll(['billStatus' => "Initiated", "billId" => $model->id], ['IN', 'id', $inspectionsArr]);
	                                        }

	                                    }
	                                }
	                            }

	                        }
	                    }
	                } 
	                
	                if($billType=='State Bill') {
	                    $roUsers = User::find()->join('LEFT JOIN','auth_assignment','auth_assignment.user_id = id')->where(['auth_assignment.item_name' => 'BO User'])->all();
	                    
	                    foreach($roUsers as $row){
	                        $roUsersList[$row['stateId']][] = $row['id'];
	                    }

	                    foreach($roUsersList as $key => $row){
	                        $roUsersStateWise = $row;
	                        $stateId = $key; //$row['stateId'];
	                        if($stateId != NULL || $stateId!='' ) {
                                //if($stateId == 18){
                                    $query = $searchModel->stateLevel($companyId, $fromDateTime, $toDateTime, $roUsersStateWise, $stateId);

                                    $oldQuery = clone $query;
                                    $query->select([new Expression('SUM(CASE WHEN `paymentMode` = 1 THEN extraKM ELSE 0 END) as totalKm'),new Expression('COUNT(av2.id) as total2W'),new Expression('COUNT(av3.id) as total3W'),new Expression('COUNT(av4.id) as total4W'),new Expression('COUNT(avc.id) as totalCW'),'pc.companyName','pc.billType','pc.rate2Wheeler','pc.rate3Wheeler','pc.rate4Wheeler','pc.rateCommercial','pc.rateConveyance','pc.billingAddress']);                           
                                    $res = $query->groupBy(['us.stateId'])->one();                                                

                                    $totalKm =  $res->totalKm ?  $res->totalKm : 0;
                                    $total2W =  0;//$res->total2W ?  $res->total2W : 0;
                                    $total3W =  0;//$res->total3W ?  $res->total3W : 0;
                                    $total4W =  $res->total4W ?  $res->total4W : 0;
                                    $totalCW =  $res->totalCW ?  $res->totalCW : 0;

                                    $arr = [
                                        "totalKm" => $totalKm,
                                        "total2W" => $total2W,
                                        "total3W" => $total3W,
                                        "total4W" => $total4W,
                                        "totalCW" => $totalCW                                
                                    ];

                                    $stateId = $stateId;
                                    $billPeriod =  $fromDate." to ".$toDate;
                                    $model = new AxionPreinspectionBilling();
                                    $model->companyId = $companyId;
                                    $model->billType = $billType;
                                    $model->stateId = $stateId;
                                    $model->branchId = "";
                                    //$model->billPeriod = $billPeriod;
                                    $model->billPeriodFrom = $fromDate;
                                    $model->billPeriodTo = $toDate;
                                    $model->billDetails = json_encode($arr);  
                                    $model->billStatus = "Initiated";
                                    $model->createdOn = $currentDateTime;
                                    
                                    if($totalKm>0 || $total4W>0|| $totalCW>0){
                                        $exist = AxionPreinspectionBilling::find()->where(['companyId'=>$companyId,'billType'=>$billType,'billPeriodFrom'=>$fromDate,'billPeriodTo' => $toDate,'stateId'=>$stateId])->one();
                                        if(!$exist){
                                            if($model->save()){                      
                                                $inspections = $oldQuery->select(['axion_preinspection.id'])->asArray()->all();
                                                if($inspections){
                                                    $inspectionsArr=ArrayHelper::map($inspections,'id','id');
                                                    $result = AxionPreinspection::updateAll(['billStatus' => "Initiated", "billId" => $model->id], ['IN', 'id', $inspectionsArr]);

                                                            //$sql = "UPDATE axion_preinspection SET billId=$model->id,billStatus = 'Initiated' WHERE status IN (101, 102, 104,103) AND completedSurveyDateTime BETWEEN '$fromDateTime' AND '$toDateTime' AND insurerName=$companyId AND paymentMode=1";
                                                }

                                            }
                                        }
                                    }
                                //}
	                        }
	                    }
	                } 
	                else if($billType=='Branch Bill') {
	                    $branches = PreinspectionClientBranch::find()->where(['companyId'=>$companyId])->groupBy(['branchName'])->all();
	                    foreach($branches as $branch){
	                        $branchId = $branch->id;
	                        if($branchId){
	                            $query = $searchModel->branchLevel($companyId,$fromDateTime,$toDateTime,$userId,$branchId);

	                            $oldQuery = clone $query;
	                            $query->select([new Expression('SUM(CASE WHEN `paymentMode` = 1 THEN extraKM ELSE 0 END) as totalKm'),new Expression('COUNT(av2.id) as total2W'),new Expression('COUNT(av3.id) as total3W'),new Expression('COUNT(av4.id) as total4W'),new Expression('COUNT(avc.id) as totalCW'),'pc.companyName','pc.billType','pc.rate2Wheeler','pc.rate3Wheeler','pc.rate4Wheeler','pc.rateCommercial','pc.rateConveyance','pc.billingAddress','axion_preinspection.userId as userId','callerName']);        

	                            $res = $query->groupBy(['insurerBranch'])->one();  

	                            if(!$res){
	                                continue;
	                            }

	                                //echo $query->createCommand()->getRawSql();exit;
	                            $userId = $res->userId;
	                            $callerName = $res->callerName;
	                            $ids = [$userId,$callerName];
	                            $userQuery = User::find()->join('LEFT JOIN','auth_assignment','auth_assignment.user_id = id')->where(['IN','id',$ids])->select(['users.*','auth_assignment.item_name as role'])->all();
	                            $stateId='';
	                            foreach($userQuery as $rows){
	                                if($rows->stateId!=""){
	                                    $stateId = $rows->stateId;
	                                }else{
	                                    $ro = User::find()->where(['id'=>$rows->roId])->one();
	                                    $stateId = $ro->stateId;
	                                }
	                                if($stateId){
	                                    break;
	                                }
	                            }

	                            $totalKm =  $res->totalKm ?  $res->totalKm : 0;
	                            $total2W =  0;//$res->total2W ?  $res->total2W : 0;
	                            $total3W =  0;//$res->total3W ?  $res->total3W : 0;
	                            $total4W =  $res->total4W ?  $res->total4W : 0;
	                            $totalCW =  $res->totalCW ?  $res->totalCW : 0;

	                            $arr = [
	                                "totalKm" => $totalKm,
	                                "total2W" => $total2W,
	                                "total3W" => $total3W,
	                                "total4W" => $total4W,
	                                "totalCW" => $totalCW                                
	                            ];
	                            $stateId = $stateId;
	                            $billPeriod =  $fromDate." to ".$toDate;
	                            $model = new AxionPreinspectionBilling();
	                            $model->companyId = $companyId;
	                            $model->billType = $billType;
	                            $model->stateId = $stateId;
	                            $model->branchId = $branchId;
	                            //$model->billPeriod = $billPeriod;
	                            $model->billPeriodFrom = $fromDate;
	                            $model->billPeriodTo = $toDate;
	                            $model->billDetails = json_encode($arr);  
	                            $model->billStatus = "Initiated";
	                            $model->createdOn = $currentDateTime;
	                            if($totalKm>0 || $total4W>0|| $totalCW>0){
	                                $exist = AxionPreinspectionBilling::find()->where(['companyId'=>$companyId,'billType'=>$billType,'billPeriodFrom'=>$fromDate,'billPeriodTo' => $toDate])->one();
	                                if(!$exist){
	                                    if($model->save()){                      
	                                        $inspections = $oldQuery->select(['axion_preinspection.id'])->asArray()->all();
	                                        if($inspections){
	                                            $inspectionsArr=ArrayHelper::map($inspections,'id','id');
	                                            $result = AxionPreinspection::updateAll(['billStatus' => "Initiated", "billId" => $model->id], ['IN', 'id', $inspectionsArr]);
	                                        }

	                                    }
	                                }
	                            }

	                        }
	                    }

	                }
	                else {
	                    $dataProvider = $searchModel->searchCompanyBilling($companyId,$fromDateTime,$toDateTime);
	                    
	                    if($dataProvider && $dataProvider->getTotalCount() > 0 ){
	                        $result = $dataProvider->getModels();
	                        
	                        foreach($result as $row){
	                            $billPeriod =  $fromDate." to ".$toDate;
	                            $model = new AxionPreinspectionBilling();
	                            $model->companyId = $companyId;
	                            $model->billType = $billType;
	                            $model->stateId = "";
	                            $model->branchId = "";
	                            $model->billPeriodFrom = $fromDate;
	                            $model->billPeriodTo = $toDate;
	                            //$model->billDetails = json_encode($row);  
	                            $model->billStatus = "Initiated";                       
	                            $model->createdOn = $currentDateTime;
	                            $exist = AxionPreinspectionBilling::find()->where(['companyId'=>$companyId,'billType'=>$billType,'billPeriodFrom'=>$fromDate,'billPeriodTo' => $toDate,'parentId'=>0])->one();
	                            if(!$exist) {
	                                if($model->save()) {
	                                    $roUsers = User::find()->join('LEFT JOIN','auth_assignment','auth_assignment.user_id = id')->where(['auth_assignment.item_name' => 'BO User'])->all();
	                                    $sumTotalKm = $sumTotal2W = $sumTotal3W = $sumTotal4W = $sumTotalCW = 0;

	                                    foreach($roUsers as $row){
	                                        $roUsersList[$row['stateId']][] = $row['id'];
	                                    }
	                                    
	                                    foreach($roUsersList as $key => $row) {
	                                        //print_r($row);die;
	                                        $roUsersStateWise = $row;
	                                        $stateId = $key; //$row['stateId'];
	                                        if($stateId != NULL || $stateId!='') {
	                                            $query = $searchModel->stateLevel($companyId, $fromDateTime, $toDateTime, $roUsersStateWise, $stateId);
	                                            $oldQuery = clone $query;

	                                            // For Royal sundaram KM will be claculated only it is > 50
	                                            if ($companyId == 10)
	                                                $query->select([new Expression('SUM(CASE WHEN `paymentMode` = 1 AND extraKM >= 50 THEN extraKM ELSE 0 END) as totalKm'),new Expression('COUNT(av2.id) as total2W'),new Expression('COUNT(av3.id) as total3W'),new Expression('COUNT(av4.id) as total4W'),new Expression('COUNT(avc.id) as totalCW'),'pc.companyName','pc.billType','pc.rate2Wheeler','pc.rate3Wheeler','pc.rate4Wheeler','pc.rateCommercial','pc.rateConveyance','pc.billingAddress']);                           
	                                            else
	                                                $query->select([new Expression('SUM(CASE WHEN `paymentMode` = 1 THEN extraKM ELSE 0 END) as totalKm'),new Expression('COUNT(av2.id) as total2W'),new Expression('COUNT(av3.id) as total3W'),new Expression('COUNT(av4.id) as total4W'),new Expression('COUNT(avc.id) as totalCW'),'pc.companyName','pc.billType','pc.rate2Wheeler','pc.rate3Wheeler','pc.rate4Wheeler','pc.rateCommercial','pc.rateConveyance','pc.billingAddress']);                         

	                                            $res = $query->groupBy(['us.stateId'])->one(); 
	                                            //echo $query->createCommand()->getRawSql();exit;

	                                            $totalKm =  $res->totalKm ?  $res->totalKm : 0;
	                                            $total2W =  0;//$res->total2W ?  $res->total2W : 0;
	                                            $total3W =  0;//$res->total3W ?  $res->total3W : 0;
	                                            $total4W =  $res->total4W ?  $res->total4W : 0;
	                                            $totalCW =  $res->totalCW ?  $res->totalCW : 0;

	                                            $sumTotalKm = $sumTotalKm + $totalKm;
	                                            $sumTotal2W = $sumTotal2W + $total2W;
	                                            $sumTotal3W = $sumTotal3W + $total3W;
	                                            $sumTotal4W = $sumTotal4W + $total4W;
	                                            $sumTotalCW = $sumTotalCW + $totalCW;
	                                            $arr = [
	                                                "totalKm" => $totalKm,
	                                                "total2W" => $total2W,
	                                                "total3W" => $total3W,
	                                                "total4W" => $total4W,
	                                                "totalCW" => $totalCW                                
	                                            ];

	                                            $billPeriod =  $fromDate." to ".$toDate;

	                                            $childModel = new AxionPreinspectionBilling();
	                                            $childModel->companyId = $companyId;
	                                            $childModel->billType = $billType;
	                                            $childModel->stateId = $stateId;
	                                            $childModel->branchId = "";
	                                            $childModel->billPeriodFrom = $fromDate;
	                                            $childModel->billPeriodTo = $toDate;
	                                            $childModel->billDetails = json_encode($arr);  
	                                            $childModel->billStatus = "Initiated";
	                                            $currentDateTime = date('Y-m-d H:i:s');
	                                            $childModel->createdOn = $currentDateTime;
	                                            $childModel->parentId = $model->id;
	                                            if($totalKm>0 || $total4W>0|| $totalCW>0){
	                                                $exist = AxionPreinspectionBilling::find()->where(['companyId'=>$companyId,'billType'=>$billType,'billPeriodFrom'=>$fromDate,'billPeriodTo' => $toDate,'stateId'=>$stateId,"parentId"=>$model->id])->one();
	                                                if(!$exist){
	                                                    if($childModel->save()){                      
	                                                        $inspections = $oldQuery->select(['axion_preinspection.id'])->asArray()->all();
	                                                        if($inspections){
	                                                            $inspectionsArr=ArrayHelper::map($inspections,'id','id');
	                                                            $result = AxionPreinspection::updateAll(['billStatus' => "Initiated", "billId" => $childModel->id], ['IN', 'id', $inspectionsArr]);
	                                                        }

	                                                    }
	                                                }

	                                            }
	                                        }
	                                    }
	                                    $totalArr = [
	                                        "totalKm" => $sumTotalKm,
	                                        "total2W" => $sumTotal2W,
	                                        "total3W" => $sumTotal3W,
	                                        "total4W" => $sumTotal4W,
	                                        "totalCW" => $sumTotalCW                                
	                                    ];
	                                    $billModel = AxionPreinspectionBilling::findOne(['id'=>$model->id]);
	                                    $billModel->billDetails = json_encode($totalArr);
	                                    $billModel->save();
	                                }
	                            }
	                                
	                        }
	                    }
	                }
	            }
            }
        }  
        return "Done";
    }

    public function actionCompanyBillingMonthStarting()
    {
        $searchModel = new AxionPreinspectionSearch();

        $companies = PreinspectionClientCompany::find()->where(['companyStatus' => 'Active'])->all();
        $states = MasterState::find()->where(['stateStatus' => 'Active'])->all();

        $arr = [
            "totalKm" => 0,
            "total2W" => 0,
            "total3W" => 0,
            "total4W" => 0,
            "totalCW" => 0                                
        ]; 

        if ($companies) {     
            date_default_timezone_set('Asia/Kolkata');
            $currentDateTime = date('Y-m-d H:i:s');
            $fromDate = date('Y-m-d', strtotime('first day of this month'));
            $toDate = date('Y-m-d', strtotime('last day of this month'));

            foreach ($companies as $company) {
                $billType = $company->billType;
                $companyId = $company->id;

                if ($billType == 'State Bill') {
                    foreach ($states as $key => $state) { 
                        $model = new AxionPreinspectionBilling();
                        $model->companyId = $companyId;
                        $model->billType = $billType;
                        $model->stateId = $state->id;
                        $model->branchId = "";
                        $model->billPeriodFrom = $fromDate;
                        $model->billPeriodTo = $toDate;
                        $model->billDetails = json_encode($arr);  
                        $model->billStatus = "Initiated";
                        $model->createdOn = $currentDateTime;
                        
                        $exist = AxionPreinspectionBilling::find()->where(['companyId'=>$companyId,'billType'=>$billType,'billPeriodFrom'=>$fromDate,'billPeriodTo' => $toDate,'stateId'=>$state->id])->one();
                        if(!$exist){
                            $model->save();
                        }   
                    }
                } 
                else if ($billType=='Branch Bill') {
                    $branches = PreinspectionClientBranch::find()->where(['companyId'=>$companyId])->groupBy(['branchName'])->all();
                    foreach($branches as $branch){
                        $branchId = $branch->id;
                        if($branchId){

                            //foreach($states as $key => $state) {
                                $model = new AxionPreinspectionBilling();
                                $model->companyId = $companyId;
                                $model->billType = $billType;
                                $model->stateId = $state;
                                $model->branchId = $branchId;
                                $model->billPeriodFrom = $fromDate;
                                $model->billPeriodTo = $toDate;
                                $model->billDetails = json_encode($arr);  
                                $model->billStatus = "Initiated";
                                $model->createdOn = $currentDateTime;
                                
                                $exist = AxionPreinspectionBilling::find()->where(['companyId'=>$companyId,'billType'=>$billType,'billPeriodFrom'=>$fromDate,'billPeriodTo' => $toDate])->one();
                                if(!$exist){
                                    $model->save();                       
                                }
                            //}

                        }
                    }

                }
                else {        
                    $model = new AxionPreinspectionBilling();
                    $model->companyId = $companyId;
                    $model->billType = $billType;
                    $model->stateId = "";
                    $model->branchId = "";
                    $model->billPeriodFrom = $fromDate;
                    $model->billPeriodTo = $toDate;
                    $model->billDetails = json_encode($arr);  
                    $model->billStatus = "Initiated";                       
                    $model->createdOn = $currentDateTime;
                    $exist = AxionPreinspectionBilling::find()->where(['companyId'=>$companyId, 'billType'=>$billType, 'billPeriodFrom'=>$fromDate, 'billPeriodTo' => $toDate, 'parentId'=>0])->one();
                    
                    if(!$exist) {
                        if($model->save()) {
                            foreach($states as $key => $state) {
                                $childModel = new AxionPreinspectionBilling();
                                $childModel->companyId = $companyId;
                                $childModel->billType = $billType;
                                $childModel->stateId = $state->id;
                                $childModel->branchId = "";
                                $childModel->billPeriodFrom = $fromDate;
                                $childModel->billPeriodTo = $toDate;
                                $childModel->billDetails = json_encode($arr);  
                                $childModel->billStatus = "Initiated";
                                $childModel->createdOn = $currentDateTime;
                                $childModel->parentId = $model->id;
                                
                                $exist = AxionPreinspectionBilling::find()->where(['companyId'=>$companyId, 'billType'=>$billType, 'billPeriodFrom'=>$fromDate, 'billPeriodTo' => $toDate, 'stateId'=>$state->id, "parentId"=>$model->id])->one();
                                if(!$exist){
                                    $childModel->save();
                                }
                            }                            
                        }
                    }

                }
            }
        }  
        return "Done";

    }

    public function getState($arr){
        $res = MasterState::find()->where(['IN','state',$arr])->one();
        return $res;
    }

    public function actionReadMessageData() {
        $text = $_POST["text"];

        if (!empty($text)) {
            $textArray = explode(', ', $text);
            foreach ($textArray as $keyValuePair) {
                $keyValue = explode(': ', $keyValuePair);
                $data[$keyValue[0]] = $keyValue[1];
            }

            $contactPersonMobileNo = ($data['ITGI Pre-Inspection ID']) ? trim($data['ITGI Pre-Inspection ID']) : "";
            $registrationNo = ($data['Vehicle No']) ? trim($data['Vehicle No']) : "";
            $insuredName = ($data['Vehicle No']) ? trim($data['Vehicle No']) : "";
            $insuredMobile = ($data['Inspector Mobile']) ? trim($data['Inspector Mobile']) : "";
            $sbuCode = ($data['SBU Code']) ? trim(str_replace(". Iffco Tokio GIC Ltd.", "", $data['SBU Code'])) : "";
            $paymentMode = 1;
            $initiatorEmailId = 'kavitha.naveenraj@gmail.com';

            /*$myfile = fopen("sms-text/data.txt", "w");
            fwrite($myfile, pack("CCC",0xef,0xbb,0xbf));  // convert to utf8
            fwrite($myfile, 'ULN: '.$contactPersonMobileNo.', Reg: '.$registrationNo.', Insured: '.$insuredName.', Mobile: '.$insuredMobile.', Payment: '.$paymentMode.', SBU: '.$sbuCode);
            fclose($myfile);*/

            $error=[];
            if(!$contactPersonMobileNo) {
                $error[] = ["field"=>"contactPersonMobileNo","message" => "Case ID is required"];
            }

            if(!$registrationNo) {
                $error[] = ["field"=>"registrationNo","message" => "Registration Number is required"];
            }

            if(!$insuredName) {
                $error[] = ["field"=>"insuredName","message"  => "Insured Name is required"];
            }

            if(!$insuredMobile) {
                $error[] = ["field"=>"insuredMobile","message"=> "Insured Mobile is required"];
            }

            if(!$paymentMode) {
                $error[] = ["field"=>"paymentMode","message"=> "Payment Mode is required"];
            }

            if(!empty($error)) {
                $this->log($contactPersonMobileNo, json_encode($error));
                return 'error';
            }
            date_default_timezone_set('Asia/Kolkata');
            $currentDateTime = date( 'Y-m-d H:i:s');
            $user = User::findOne(['email' => trim($initiatorEmailId)]);

            $model = new AxionPreinspection();
            $model->vehicleType ="ALL-VEHICLE";
            $model->insuredName=$insuredName;
            $model->insurerName = 9;
            $model->insuredMobile=$insuredMobile;
            $model->contactPersonMobileNo=$contactPersonMobileNo;
            $model->registrationNo=$registrationNo;
            $model->sbuCode=$sbuCode;
            $model->surveyorName = '0';
            $model->paymentMode=$paymentMode;
            $model->inspectionType = "Break In";
            $model->status = 12;
            $model->createMethod = 'Api - From SMS';

            $model->created_on = $currentDateTime;
            $model->intimationDate = $currentDateTime;
            $model->referenceNo = $this->getReferenceNo();

            if($user) {
                $model->callerName = $user->id;
                $model->callerMobileNo = $user->mobile;
                $model->callerDetails = $user->email;
                $model->insurerDivision = $user->divisionId;
                $model->insurerBranch = $user->branchId;
            }

            if ($model->save()) {
                if($model->insuredMobile != '')
                {
                    $this->createCustomerSession($model->id);
                }

                $twowheelermodel = new AxionPreinspectionTwowheeler();
                $twowheelermodel->preinspection_id = $model->id;
                $twowheelermodel->save();
                $fwheelermodel = new AxionPreinspectionFwheeler();
                $fwheelermodel->preinspection_id = $model->id;
                $fwheelermodel->save();
                $commercialwheelermodel = new AxionPreinspectionCommercialwheeler();
                $commercialwheelermodel->preinspection_id = $model->id;
                $commercialwheelermodel->save();
                
                
                //updating qc
                $this->updateQc($model, 'insert');

                $obj = $this->findModel($model->id);
                $hismodel = new AxionPreinspectionHistory();
                $hismodel->attributes = $obj->attributes;
                $hismodel->preinspection_id = $obj->id;
                $hismodel->id = 0;
                $hismodel->created_on = $currentDateTime;
                $hismodel->save();
            } 
            else{
                $this->log($contactPersonMobileNo, json_encode($model->getErrors()));
                $myfile = fopen("sms-text/error.txt", "w");
                fwrite($myfile, pack("CCC",0xef,0xbb,0xbf));  // convert to utf8
                fwrite($myfile, json_encode($model->getErrors()));
                fclose($myfile);
                return 'error';
            }

            $result = [
                "contactPersonMobileNo" => $model->contactPersonMobileNo,
                "registrationNo" => $model->registrationNo,
                "insurerName" => "IFFCO TOKIO GENERAL INSURANCE CO. LTD",
                "insuredName" => $model->insuredName,
                "paymentMode" => $paymentMode,
                "referenceNo" => $model->referenceNo,
                "status" => "12" 
            ];

            //return Yii::$app->api->sendSuccessResponse($result);

            $phone = "N/A";
            if(isset($_POST["phone"])){
                $phone =  $_POST["phone"];
            }else if(isset($_GET["phone"])){
                $phone =  $_GET["phone"];
            }
            $text = "N/A";
            if(isset($_POST["text"])){
                $text =  $_POST["text"];
            }else if(isset($_GET["text"])){
                $text =  $_GET["text"];
            }
            
            // extra post parameters
            $extra1 = "N/A";
            if(isset($_POST["extra1"])){
                $extra1 =  $_POST["extra1"];
            }else if(isset($_GET["extra1"])){
                $extra1 =  $_GET["extra1"];
            }
            if(strlen($extra1)>15){
                $extra1= substr($extra1, 0,15);
            }
            
            $extra2 = "N/A";
            if(isset($_POST["extra2"])){
                $extra2 =  $_POST["extra2"];
            }else if(isset($_GET["extra2"])){
                $extra2 =  $_GET["extra2"];
            }
            
            $device = "";
            if(isset($_POST["device"])){
                $device =  $_POST["device"];
            }
            $sim = "N/A";
            if(isset($_POST["sim"])){
                $sim =  $_POST["sim"];
            }else if(isset($_GET["sim"])){
                $sim =  $_GET["sim"];
            }

            $filename = ($data['ITGI Pre-Inspection ID']) ? $data['Vehicle No'] : "";

            $myfile = fopen("sms-text/$filename.txt", "w");
            fwrite($myfile, pack("CCC",0xef,0xbb,0xbf));  // convert to utf8
            fwrite($myfile, "phone=$phone\n");
            fwrite($myfile, "text=$text\n");
            fwrite($myfile, "sim=$sim\n");
            if($device!=""){
                fwrite($myfile, "device=$device\n");
            }
            fclose($myfile);
            
            //must return "OK" or APP will consider message as failed
            echo "OK";
        } 

    }
    

    protected function createCustomerSession($id)
    {

        $model = AxionPreinspection::findOne($id);
        if($model->ro == '')
        {
            $apiKey = \Yii::$app->params['tokApiKey'];
            $apiSecret = \Yii::$app->params['tokApiSecret'];
            $opentok = new OpenTok($apiKey, $apiSecret);
            $sessionOptions = array(
                                        'archiveMode' => ArchiveMode::ALWAYS,
                                        'mediaMode' => MediaMode::ROUTED
                                    );
            $session = $opentok->createSession($sessionOptions);
            $sessionId = $session->getSessionId();
            $model->ro = $sessionId;
            $model->save();
        }

        if($model->vehicleType == 'ALL-VEHICLE')
        {
            $link = Yii::$app->urlManager->createAbsoluteUrl('axion-preinspection/vehicleqc?id='.$model->id.'&page=index');
        }
        else
        {
            $link = Yii::$app->urlManager->createAbsoluteUrl('axion-preinspection/commercialqc?id='.$model->id);
        }

        $mobileno = $model->insuredMobile;
        $message = 'Dear Customer, Please click the below link to complete your Self Inspection for Vehicle No '.$model->registrationNo.',  Our Reference No'.$model->referenceNo.' Link: '.$link.' by Axion';

        $this->sendSms($mobileno, $message); 
        
        $customerEmail = $model->contactPersonMobileNo;
        if($customerEmail != '' && !is_numeric($customerEmail))
        {
        $emailSubject = 'Quality Check URL';
        $emailMessage = 'Username:'.$model->insuredMobile.'@pcs.in Password:'.$model->insuredMobile.' Quality Check Url - '.$link.' by Axion';

        $emailPosts = EmailHistory::find()
            ->where('email = :val1 AND subject = :val2 AND message = :val3',['val1' =>$customerEmail,'val2' => $emailSubject,'val3' => $emailMessage])
            ->count();

            if($emailPosts==0){
                $emailHistory =  new EmailHistory();
                $emailHistory->email = $customerEmail;
                $emailHistory->subject = $emailSubject;
                $emailHistory->message = $emailMessage;
                $emailHistory->save();
            }
        }
                
    }

    protected function sendSms($mobileno,$message) {
    
        $sendSmsUpdate = \Yii::$app->params['sendSmsUpdate'];
        $username = \Yii::$app->params['sendSmsUser'];
        $password = \Yii::$app->params['sendSmsPwd'];
        $sendername = \Yii::$app->params['sendSmsSender'];
        
        $mobileno = '91'.$mobileno;
        $message = urlencode($message);
          
        if($sendSmsUpdate == 'Y')
        {
            //$url = "http://bulksms.mysmsmantra.com/WebSMS/SMSAPI.jsp?username=$username&password=$password&sendername=$sendername&mobileno=$mobileno&message=$message";
            // $url = "http://bulksms.mysmsmantra.com:8080/WebSMS/SMSAPI.jsp?username=$username&password=$password&sendername=$sendername&mobileno=$mobileno&message=$message";
    
            $url="https://api.mylogin.co.in/api/v2/SendSMS?ApiKey=$username&ClientId=$password&SenderId=$sendername&Message=$message&MobileNumbers=$mobileno&Is_Unicode=false&Is_Flash=false";
            
            $useragent = 'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US) AppleWebKit/533.2 (KHTML, like Gecko) Chrome/5.0.342.3 Safari/533.2';
    
            $ch = curl_init($url);
            //curl_setopt($ch, CURLOPT_COOKIEJAR, 'C:\wamp\www\processcontrol\tmp\cookies.txt');
            //curl_setopt($ch, CURLOPT_COOKIEFILE, 'C:\wamp\www\processcontrol\tmp\cookies.txt');
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // required as godaddy fails
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); // required as godaddy fails
            curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
    
            $html = curl_exec($ch);
        
            if(!$html){
              echo "cURL error number:" .curl_errno($ch);
              echo "cURL error:" . curl_error($ch);
            }
          
            curl_close($ch);
        }  
    }

    public function actionCreateRequestFromMails($companyId) {

        if ($companyId == 12) {
            $hostname = '{imappro.zoho.com:993/imap/ssl}INBOX';
            $username = 'inspection.request@axionpcs.in';
            $password = '@xionPcs#321';
        }
        else if ($companyId == 9) {
            $hostname = '{imappro.zoho.com:993/imap/ssl}INBOX';
            $username = 'kavitha.naveenraj@axionpcs.in';
            $password = 'Axion@321';
        }

        $inbox = imap_open($hostname, $username, $password) or die('Cannot connect to gmail: ' . imap_last_error());
        
        if ($companyId == 12) {
            $mails = imap_search($inbox,'UNFLAGGED FROM "manual.PI@godigit.com"'); //imap_headers($inbox) or die('Could not get emails');
        }
        else if ($companyId == 9) {
            $mails = imap_search($inbox,'UNFLAGGED FROM "noreply@iffcotokio.co.in"'); //imap_headers($inbox) or die('Could not get emails');
        }

        if($mails) {
            $numEmails = sizeof($mails);
            echo "You have $numEmails new mails in your mailbox <br>";
        
            rsort($mails);
            $test = [];
            foreach($mails as $msgno) {
                $check = [];
                $mailHeader = imap_headerinfo($inbox, $msgno);
                /*$from = $mailHeader->fromaddress;
                $subject = strip_tags($mailHeader->subject);
                $date = $mailHeader->date;*/

                //$body = imap_body($inbox, $msgno);
                date_default_timezone_set('Asia/Kolkata');
                $body = imap_fetchbody($inbox, $msgno, '1');
                //print_r($body);echo '<br><br><br>';
                //print_r(base64_decode($body));echo '<br><br><br>';
                
                // For Go Digit
                if ($companyId == 12) {
                    $body = imap_fetchbody($inbox, $msgno, 1.1);
                    $bodyContent = strip_tags($body);

                    $bodyContent = preg_replace("/\s*\n/i", "", $bodyContent);
                    //$bodyContent = preg_replace("/[^>]*?\"agentName(.*)\"------=.*/i", "$1", $bodyContent);
                    $bodyContent = preg_replace("/^([^>]*?)\"agentName|(\=0A\=)$|=/i", "", $bodyContent);
                    $bodyContent = preg_replace('/"0A/i', '"', $bodyContent);
                    $contentObject = json_decode('{"agentName'.$bodyContent.'}');
                    
                    $contactPersonMobileNo = $contentObject->piRequestId;
                    $registrationNo = $contentObject->vechNo;
                    $insuredName = $contentObject->custName;
                    $insuredMobile = $contentObject->custMob;
                    $insuredAddress = $contentObject->address;
                    $manufacturer = $contentObject->vechMake;
                    $vehicleModel = $contentObject->vechModel;
                    $engineNo = $contentObject->vechEngNo;
                    $chassisNo = $contentObject->vechChasisNo;
                    $inspectionType = $contentObject->piReason;
                    $paymentMode = $contentObject->customerBilling;

                    $callerName = $contentObject->agentName;
                    $callerMobileNo = $contentObject->agentMob;
                    $callerEmail = $contentObject->agentEmail;
                    $currentDateTime = date('Y-m-d H:i:s');
                    /*$callerDivision = $contentObject->agentEmail;
                    $branch = PreinspectionClientBranch::findOne(['branchName' => $contentObject->goDigitBranch, 'companyId' => 12]);
                    
                    if ($branch)
                        $callerBranch = $branch->id;
                    else
                        $callerBranch = '';*/

                    if ($registrationNo) {
                        $regCode = preg_replace("/(..).*/i", "$1", trim($registrationNo));
                        if($regCode == 'KA'){
                            $getState = MasterState::findOne(['id' => 34]);
                        }else{ 
                            $getState = MasterState::findOne(['regCode' => $regCode]); 
                        }  
                    }
                    
                    $model = new AxionPreinspection();
                    $model->referenceNo = $this->getReferenceNo();
                    $model->created_on = $currentDateTime;
                    $model->intimationDate = $currentDateTime;
                    $model->status = 0;
                    $model->insurerName = 12;
                    $model->manufacturer = $manufacturer;
                    $model->model = $vehicleModel;
                   
                    if ($getState) {
                        $query = User::find();
                        $query->join('LEFT JOIN','auth_assignment','auth_assignment.user_id = id')
                        ->andWhere(['auth_assignment.item_name' => 'BO User'])
                        ->andWhere(['IN','users.active','Y'])
                        ->andWhere(['users.stateId' => $getState->id]);
                        $rouserData = $query->one();
                        // return $query->createCommand()->getRawSql();
                        $getstateCode = MasterState::find()->where(['id'=>$getState->id])->one();
                        $getstateCode = $getstateCode->regCode;
                        $getstateids = MasterState::find()->where(['regCode'=>$getstateCode])->select('id')->asArray()->groupBy('id')->all();
                        $stateIds = array_column($getstateids, 'id');
                        $rousers = User::find()->join('LEFT JOIN','auth_assignment','auth_assignment.user_id = id')
                        ->andWhere(['auth_assignment.item_name' => 'BO User'])
                        ->andWhere(['IN','users.stateId',$stateIds])
                        ->andWhere(['IN','users.active','Y'])
                        ->select('id')->asArray()->groupBy('id')->orderBy('id ASC')->all();
                        // ->count();
                        $rousersIds = array_column($rousers, 'id');
                        $rocaseCnt = [];
                        foreach($rousersIds as $roid){
                            $rocaseassignCnt = RoCaseAssignment::find()->where(['roId' => $roid, 'companyId' => 12])->one();
                            array_push($rocaseCnt,$rocaseassignCnt->caseCnt);
                        }
                        
                        // iterate through the array
                        foreach ($rocaseCnt as $key => $value) {
                            // check if the value is empty
                            if (empty(trim($value))) {
                                // remove the empty value from the array
                                unset($rocaseCnt[$key]);
                                unset($rousersIds[$key]);
                            }
                        }
                        // return print_r($rocaseCnt);
                    }

                    $getinsurerDivision = PreinspectionClientDivision::find()->where(['companyId' => 12])->andWhere(['stateid' => $getState->id])->one();
                    // return $getinsurerDivision->createCommand()->getRawSql(); die;
                    if($getinsurerDivision->id){
                        $getinsurerBranch = PreinspectionClientBranch::find()->where(['companyId' => 12, 'divisionId' => $getinsurerDivision->id])->one();
                    }               
                    // return $getinsurerDivision->id.' ~~ '.$getinsurerBranch->id;     
                    // return $getinsurerBranch->id;
                        //if (empty($userData)) {
                            $userData = isset($callerEmail) ? User::findOne(['email' => trim($callerEmail)]) : '';

                            if(!$userData && isset($callerEmail)){
                                $userModel = new User();
                                $userModel->scenario='api-create';
                                $userModel->activationLink = 'Y';
                                $userModel->createdOn = $currentDateTime;
                                $userModel->password = "123456";
                                // $userModel->password = $callerMobileNo;
                                $userModel->mobile = $callerMobileNo;
                                $userModel->email = $callerEmail;
                                $userModel->firstName = $callerName;
                                $userModel->companyId = 12;
                                $userModel->stateId = @$getState->id;
                                $userModel->divisionId = @$getinsurerDivision->id;
                                $userModel->branchId = @$getinsurerBranch->id;

                                if($userModel->save())
                                {
                                    $auth = new DbManager;
                                    $auth->init();
                                    $role = $auth->getRole('Branch Executive');
                                    $auth->assign($role, $userModel->id);

                                    $userData = $userModel;
                                }
                                
                            }elseif(!empty($userData)){
                                // return $callerName;
                                $userData->scenario='api-create';
                                $userData->activationLink = 'Y';
                                $userData->password = "123456";
                                $userData->mobile = $callerMobileNo;
                                $userData->email = $userData->email;
                                $userData->firstName = $userData->firstName ? $userData->firstName : $callerName;
                                $userData->companyId = 12;
                                $userData->stateId = @$getState->id;
                                $userData->divisionId = @$getinsurerDivision->id;
                                $userData->branchId = @$getinsurerBranch->id;
                                $userData->save();
                                // if($userData->save()){
                                //     return $userData->mobile;
                                // }else{
                                //     return json_encode($userData->getErrors());
                                // }
                            }
                        //}
                    // }

                    // $rousersIds
                    // $rocaseCnt

                    if(!empty($rousersIds) && !empty($rocaseCnt)){
                        $roassingTracker = RoCaseAssignmentTracker::find()->where(['IN','roId',$rousersIds])->one();
                        $rolastTracker = RoLastTracker::find()->where(['IN','roId',$rousersIds])->one();
                        if($roassingTracker->roId){
                            // return 'if';
                            $check['type'] = 'roassingTracker';
                            $check['roId'] = $roassingTracker->roId;
                            $check['trackerCnt'] = $roassingTracker->trackerCnt;
                            $rouserInfo = User::findOne(['id'=>$roassingTracker->roId]);
                            // return $rouserInfo->stateId;
                            $arrayKey = array_search($roassingTracker->roId, $rousersIds);                            
                            // return $arrayKey;
                            $trackerCnt = $roassingTracker->trackerCnt + 1;
                            if($trackerCnt == $rocaseCnt[$arrayKey]){
                                $check['if'] = 'Y';
                                RoCaseAssignmentTracker::findOne($roassingTracker->id)->delete();
                                $rolastTracker = new RoLastTracker();
                                $rolastTracker->roId = $roassingTracker->roId;
                                $rolastTracker->stateId = $roassingTracker->stateId;
                                $rolastTracker->companyId = 12;
                                $rolastTracker->save();
                            }else{
                                $check['else'] = 'Y';
                                $roassingTracker->trackerCnt = $trackerCnt;
                                $roassingTracker->updatedOn = date('Y-m-d H:i:s');
                                // return $trackerCnt.' Updated';
                            }
                            $model->userId = $roassingTracker->roId;                            
                            $model->stateId = @$rouserInfo->stateId;
                            $roassingTracker->save();
                        }elseif($rolastTracker->roId){
                            // return 'else if';
                            $check['type'] = 'rolastTracker';
                            $check['roId'] = $rolastTracker->roId;
                            $rouserInfo = User::findOne(['id'=>$rolastTracker->roId]);
                            $arrayKey = array_search($rolastTracker->roId, $rousersIds); 
                            //return count($rousersIds).' ~ '.$arrayKey;
                            if(count($rousersIds) == $arrayKey){
                                $check['samecount-if'] = 'Y';
                                $roId = $rousersIds[$arrayKey];
                                $roCnt = $rocaseCnt[$arrayKey];
                                //return print_r($check).' ~ '.print_r($rousersIds).' # '.$roId;
                            }else{
                                $check['samecount-else'] = 'Y';
                                $roId = $rousersIds[(($arrayKey) + 1)];
                                $roCnt = $rocaseCnt[(($arrayKey) + 1)];
                                //return print_r($check).' ~ '.print_r($rousersIds).' # '.$roId;
                            }
                            // return $roId.'~~'.$rolastTracker->id;
                            //if($roId){
                                $rouserInfo = User::findOne(['id'=>$roId]);
                                $model->userId = @$rouserInfo->id;
                                $model->stateId = @$rouserInfo->stateId;
                                if($roCnt == 1){
                                    $check['rocount1-if'] = 'Y';
                                    $rolastTracker0 = new RoLastTracker();
                                    $rolastTracker0->roId = @$rouserInfo->id;
                                    $rolastTracker0->stateId = @$rouserInfo->stateId;
                                    $rolastTracker0->companyId = 12;
                                    $rolastTracker0->save();
                                }else{
                                    $check['rocount1-else'] = 'Y';
                                    $roassingTracker = new RoCaseAssignmentTracker();
                                    $roassingTracker->roId = @$rouserInfo->id;
                                    $roassingTracker->companyId = 12;
                                    $roassingTracker->stateId = @$rouserInfo->stateId;
                                    $roassingTracker->trackerCnt = 1;
                                    $roassingTracker->save();
                                }
                            //}
                            RoLastTracker::findOne($rolastTracker->id)->delete();
                        }else{
                            $check['type'] = 'Main Else';
                            $check['roId'] = $rousersIds[0];
                            $rouserInfo = User::findOne(['id'=>$rousersIds[0]]);
                            // return $rouserInfo->stateId;
                            $model->userId = @$rouserInfo->id;
                            $model->stateId = @$rouserInfo->stateId;
                            if($rocaseCnt[0] == 1){
                                $check['if'] = 'Y';
                                $rolastTracker = new RoLastTracker();
                                $rolastTracker->roId = @$rouserInfo->id;
                                $rolastTracker->stateId = @$rouserInfo->stateId;
                                $rolastTracker->companyId = 12;
                                $rolastTracker->save();
                            }else{
                                $check['else'] = 'Y';
                                $roassingTracker = new RoCaseAssignmentTracker();
                                $roassingTracker->roId = @$rouserInfo->id;
                                $roassingTracker->companyId = 12;
                                $roassingTracker->stateId = $rouserInfo->stateId;
                                $roassingTracker->trackerCnt = 1;
                                $roassingTracker->save();
                            }    
                            // return 'ro else';
                        }
                        array_push($test,$check);
                        // return print_r($rocaseCnt);
                    }else{
                        $model->userId = $rouserData->id ?? $userData->id;
                        $model->stateId = $userData->stateId;
                        // return 'else';
                    }

                    $model->callerName = $userData->id;
                    $model->callerMobileNo = $userData->mobile;
                    $model->callerDetails = $userData->email;
                    $model->insurerDivision = @$getinsurerDivision->id;
                    $model->insurerBranch = @$getinsurerBranch->id;

                    $model->inspectionType = ($inspectionType == 'BREAK-IN') ? 'Break In' : $inspectionType;
                    $model->paymentMode = ($paymentMode) ? 2 : 1;
                    $model->registrationNo = $registrationNo;
                    $model->insuredName = $insuredName;
                    $model->insuredMobile = $insuredMobile;
                    //$model->engineNo = $engineNo;
                    //$model->chassisNo = $chassisNo;
                    $model->contactPersonMobileNo = $contactPersonMobileNo;
                    //$model->surveyLocation = $row->CustomerAddress1;
                    $model->insuredAddress = $insuredAddress;
                    $model->createMethod = 'Api - From Mail';
                   
                }

                // For IFFCO TOKIO GENERAL INSURANCE CO. LTD
                else if ($companyId == 9) { 
                    $bodyContent = base64_decode($body);
                   
                    preg_match("/^\<HTML\>([^>]*?)\<div\>/i", $bodyContent, $content);
                    
                    $textArray = explode(', ', $content[1]);
                    foreach ($textArray as $keyValuePair) {
                        $keyValue = explode(': ', $keyValuePair);
                        $data[$keyValue[0]] = $keyValue[1];
                    }
                    
                    $contactPersonMobileNo = ($data['ITGI Pre-Inspection ID']) ? trim($data['ITGI Pre-Inspection ID']) : "";
                    $registrationNo = ($data['Vehicle No']) ? trim($data['Vehicle No']) : "";
                    $insuredName = ($data['Vehicle No']) ? trim($data['Vehicle No']) : "";
                    $insuredMobile = ($data['Inspector Mobile']) ? trim($data['Inspector Mobile']) : "";
                    $sbuCode = ($data['SBU Code']) ? trim(str_replace(".", "", $data['SBU Code'])) : "";
                    $paymentMode = 1;
                    $initiatorEmailId = 'kavitha.naveenraj@gmail.com';

                    $error=[];
                    if(!$contactPersonMobileNo) {
                        $error[] = ["field"=>"contactPersonMobileNo","message" => "Case ID is required"];
                    }

                    if(!$registrationNo) {
                        $error[] = ["field"=>"registrationNo","message" => "Registration Number is required"];
                    }

                    if(!$insuredName) {
                        $error[] = ["field"=>"insuredName","message"  => "Insured Name is required"];
                    }

                    if(!$insuredMobile) {
                        $error[] = ["field"=>"insuredMobile","message"=> "Insured Mobile is required"];
                    }

                    if(!empty($error)) {
                        $this->log($contactPersonMobileNo, json_encode($error));
                        imap_setflag_full($inbox, $msgno, "\\Seen \\Flagged");
                        return 'error';
                    }

                    date_default_timezone_set('Asia/Kolkata');
                    $currentDateTime = date( 'Y-m-d H:i:s');
                    $user = User::findOne(['email' => trim($initiatorEmailId)]);

                    $model = new AxionPreinspection();
                    $model->vehicleType ="ALL-VEHICLE";
                    $model->insuredName=$insuredName;
                    $model->insurerName = 9;
                    $model->insuredMobile=$insuredMobile;
                    $model->contactPersonMobileNo=$contactPersonMobileNo;
                    $model->registrationNo=$registrationNo;
                    $model->sbuCode=$sbuCode;
                    $model->surveyorName = '0';
                    $model->paymentMode=$paymentMode;
                    $model->inspectionType = "Break In";
                    $model->status = 12;
                    $model->createMethod = 'Api - From Mail';

                    $model->created_on = $currentDateTime;
                    $model->intimationDate = $currentDateTime;
                    $model->referenceNo = $this->getReferenceNo();

                    if($user) {
                        $model->callerName = $user->id;
                        $model->callerMobileNo = $user->mobile;
                        $model->callerDetails = $user->email;
                        $model->insurerDivision = $user->divisionId;
                        $model->insurerBranch = $user->branchId;
                    }

                }

                // return 'UserId - '.$rouserData->id;

                if ($model->save()) {

                    if($model->insuredMobile != '' && $model->status != 0)
                    {
                        $this->createCustomerSession($model->id);
                    }

                    $twowheelermodel = new AxionPreinspectionTwowheeler();
                    $twowheelermodel->preinspection_id = $model->id;
                    $twowheelermodel->created_on = $currentDateTime;
                    if (!$twowheelermodel->save())
                    {
                        $this->log($model->contactPersonMobileNo, json_encode($twowheelermodel->getErrors()));
                    }
                    $fwheelermodel = new AxionPreinspectionFwheeler();
                    $fwheelermodel->preinspection_id = $model->id;
                    $fwheelermodel->created_on = $currentDateTime;
                    if (!$fwheelermodel->save())
                    {
                        $this->log($model->contactPersonMobileNo, json_encode($fwheelermodel->getErrors()));
                    }
                    $commercialwheelermodel = new AxionPreinspectionCommercialwheeler();
                    $commercialwheelermodel->preinspection_id = $model->id;  
                    $commercialwheelermodel->created_on = $currentDateTime;
                    if (!$commercialwheelermodel->save())
                    {
                        $this->log($model->contactPersonMobileNo, json_encode($commercialwheelermodel->getErrors()));
                    }
              
                    
                    //updating qc
                    $this->updateQc($model, 'insert');
                    $obj = $this->findModel($model->id);
                    $hismodel = new AxionPreinspectionHistory();
                    $hismodel->attributes = $obj->attributes;
                    $hismodel->preinspection_id = $obj->id;
                    $hismodel->id = 0;
                    $hismodel->created_on = $currentDateTime;
                    $hismodel->save();
                }
                else {
                    $message = json_encode($model->getErrors());
                    $this->log($contactPersonMobileNo,$message);
                }

                /*if(!$model->save()){
                    print_r($model->getErrors());exit;
                }*/

                // If 'referenceNo already exists' error occured, does not flag the mail
                if (strpos($message, 'referenceNo') < 1 ) {
                    imap_setflag_full($inbox, $msgno, "\\Seen \\Flagged");
                }
            }
            // print_r($test);
        }
        else {
            return "You have no new mails in your mailbox <br>";
        }
        
        imap_close($inbox);
    }

    public function actionRsCreateRequest()
    {

        Yii::$app->response->format = Response::FORMAT_JSON;
        Yii::$app->response->formatters = [
            Response::FORMAT_JSON => [
                'class' => JsonResponseFormatter::class,
                'prettyPrint' => true
            ]
        ];
        
        $post = (file_get_contents("php://input"));
        $params = json_decode($post);

        $error = [];

        $message = json_encode($params);
        if (isset($params->vir_case_number)) 
        {
            $request = "Case come form Royal Sundaram iLounge";
            $this->log($params->vir_case_number, $message, $request);
        }

        $headers = apache_request_headers();
        if ($headers['Authorization'] != 'Basic UlNHSTpSU0dJQFZleWVz') {
            Yii::$app->response->statusCode = 401;
            return ['status' => false, 'status_code' => 401, 'message' => 'Authorization failure', 'data' => ''];
        }
        
        if (!empty($params)) {

            if(!isset($params->vehicle_type) || ($params->vehicle_type=="") ){
                $error[] = "Vehicle type is required";
            }

            if(!isset($params->vehicle_make) || ($params->vehicle_make=="") ){
                $error[] = "Vehicle make is required";
            }

            if(!isset($params->vehicle_model) || ($params->vehicle_model=="") ){
                $error[] = "Vehicle model is required";
            }

            /* if(!isset($params->odometer_reading) || ($params->odometer_reading=="") ){
                $error[] = "Odometer reading is required";
            } */

            if(!isset($params->vir_case_number) || ($params->vir_case_number=="") ){
                $error[] = "VIR case number is required";
            }

            // if(!isset($params->initiator_region) || ($params->initiator_region=="") ){
            //     $error[] = "Initiator region is required";
            // }

            if(!isset($params->initiator_branch) || ($params->initiator_branch=="") ){
                $error[] = "Initiator branch is required";
            }

            if(!isset($params->initiator_name) || ($params->initiator_name=="") ){
                $error[] = "Initiator name is required";
            }

            if(!isset($params->initiator_code) || ($params->initiator_code=="") ){
                $error[] = "Initiator code is required";
            }

            if(!isset($params->initiator_mobile_no) || ($params->initiator_mobile_no=="") ){
                $error[] = "Initiator mobile no is required";
            }

            if(!isset($params->initiator_email_id) || ($params->initiator_email_id=="") ){
                $error[] = "Initiator email id is required";
            }

            if (count($error) > 0)
            {
                Yii::$app->response->statusCode = 422;
                $this->log($params->vir_case_number, json_encode($error), $message);
                return ['status' => false, 'status_code' => 422, 'message' => 'Incorrect Request Data', 'data' => ['error' => $error]];        
            }

            // $exist = AxionPreinspection::findOne(['contactPersonMobileNo' => $params->referenceNo]);  
            //         //echo '<pre>';print_r($model);exit;                  
            // if (!$exist)
            // {
	            date_default_timezone_set('Asia/Kolkata'); //India time (GMT+5:30)
                $currentDateTime = date('Y-m-d H:i:s');

            	$email = $params->initiator_email_id;

                if($email) {
                    $user = isset($email) ? User::findOne(['email' => trim($email)]) : '';
                    if (!empty($params->registration_number)) {
                        $regCode = preg_replace("/(..).*/i", "$1", trim($params->registration_number));
                        // return $regCode;
                        if($regCode == 'TS' || $regCode == 'ts' || $regCode == 'Ts' || $regCode == 'tS'){
                            $regCode = 'AP';
                        }
                        $getState = MasterState::findOne(['regCode' => $regCode]); 

                        $divModel = PreinspectionClientDivision::findOne(['stateId' => @$getState->id, 'companyId' => 10]);
                        $brModel = PreinspectionClientBranch::findOne(['divisionId' => @$divModel->id, 'companyId' => 10]);
                    }
                    if(!$user && isset($email)) {
                        $userModel = new User();
                        $userModel->scenario = 'api-create';
                        $userModel->activationLink = 'Y';
                        $userModel->createdOn = $currentDateTime;
                        $userModel->firstName = $params->initiator_name;
                        $userModel->mobile = $params->initiator_mobile_no;
                        $userModel->email = $email;
                        $userModel->password = "123456";                        
                        $userModel->stateId = @$getState->id;
                        $userModel->divisionId = @$divModel->id;
                        $userModel->branchId = @$brModel->id;
                        $userModel->companyId = 10;
                        
                        
                        if($userModel->save())
                        {
                            $auth = new DbManager;
                            $auth->init();
                            $role = $auth->getRole('Branch Executive');
                            $auth->assign($role, $userModel->id);
                            $user = $userModel;
                        }
                        else
                        {
                            $request = json_encode($userModel->attributes);
                            $this->log($params->vir_case_number, json_encode($userModel->getErrors()),$request);
                        }
                    }
                    else if($user)
                    {
                        if($user->stateId == null && $regCode != 'KA'){
                            $user->stateId = @$getState->id;
                        }else{
                            $user->stateId = 34;
                        }
                        if($user->divisionId == null){
                            $user->divisionId = @$divModel->id;
                        }
                        if($user->branchId == null){
                            $user->branchId = @$brModel->id;
                        }
                        if($user->companyId == null){
                            $user->companyId = 10;
                        }
                        $user->mobile = @$params->initiator_mobile_no;
                        $user->save();
                    }
                }

                // GET MULTIPLE RO IN SAME STATE 

                if ($getState && $regCode != 'KA') {
                    $query = User::find();
                    $query->join('LEFT JOIN','auth_assignment','auth_assignment.user_id = id')
                    ->andWhere(['auth_assignment.item_name' => 'BO User'])
                    ->andWhere(['users.stateId' => $getState->id]);
                    $rouserData = $query->one();

                    $getstateCode = MasterState::find()->where(['id'=>$getState->id])->one();
                    $getstateCode = $getstateCode->regCode;
                    $getstateids = MasterState::find()->where(['regCode'=>$getstateCode])->select('id')->asArray()->groupBy('id')->all();
                    $stateIds = array_column($getstateids, 'id');
                    $rousers = User::find()->join('LEFT JOIN','auth_assignment','auth_assignment.user_id = id')
                    ->andWhere(['auth_assignment.item_name' => 'BO User'])
                    ->andWhere(['IN','users.stateId',$stateIds])
                    ->andWhere(['IN','users.active','Y'])
                    ->select('id')->asArray()->groupBy('id')->orderBy('id ASC')->all();
                    // ->count();
                    $rousersIds = array_column($rousers, 'id');
                    $rocaseCnt = [];
                    foreach($rousersIds as $roid){
                        $rocaseassignCnt = RoCaseAssignment::find()->where(['roId' => $roid, 'companyId' => 10])->one();
                        array_push($rocaseCnt,$rocaseassignCnt->caseCnt);
                    }
                    
                    // iterate through the array
                    foreach ($rocaseCnt as $key => $value) {
                        // check if the value is empty
                        if (empty(trim($value))) {
                            // remove the empty value from the array
                            unset($rocaseCnt[$key]);
                            unset($rousersIds[$key]);
                        }
                    }
                    // return print_r($rocaseCnt);
                }

                // GET MULTIPLE RO IN SAME STATE
                
	            $model = new AxionPreinspection();
	            $model->vehicleType ="ALL-VEHICLE";
	            $model->registrationNo = $params->registration_number;
	            $model->engineNo=$params->engine_number;
	            $model->chassisNo=$params->chassis_number;
	            $model->manufacturer=$params->vehicle_make;
	            $model->model=$params->vehicle_model;
	            $model->manufacturingYear=$params->year_of_manufacture;
	            $model->surveyLocation=$params->vehicle_inspection_location;
                $model->contactPersonMobileNo = $params->vir_case_number;
                if($params->reason_of_vir == 'CNG\/LPG kit inclusion'){
                    $model->inspectionType = 'CNG/LPG Kit Inclusion';
                }else{
                    $model->inspectionType = ucwords($params->reason_of_vir);
                }
                $today = date("Y-m-d");
                $prefirstday = date('Y-m-01');
                $checkPayment = AxionPreinspection::find()->where(['like','registrationNo','%'.$params->registration_number.'%',false])->andwhere(['between', 'intimationDate',$prefirstday,$today])->all();
                if ($params->payment_option == 'Company Payment' && count($checkPayment) == 0)
                {  
	                $model->paymentMode = 1;
                }
                else if ($params->payment_option == 'Customer Payment' || $params->payment_option == 'Company Payment')
                {  
	                $model->paymentMode = 2;
                }

	            $model->insurerName = 10;
                $model->insurerDivision = @$divModel->id;
                $model->insurerBranch = @$brModel->id;
                $model->userId = @$user->id;                
                $model->fristRoid = @$user->id;

                $divisionModel = PreinspectionClientDivision::find()->where([
                    'divisionName' => @$params->initiator_region,
                    'companyId' => 10
                ])->one();
                //echo $divisionModel->createCommand()->getRawSql(); die;

                if (!empty($params->initiator_region) && empty($divisionModel))
                {
                    $divisionModel = new PreinspectionClientDivision;
                    $divisionModel->divisionName = @$params->initiator_region;
                    $divisionModel->companyId = 10;
                    $divisionModel->created_on = $currentDateTime;

                    if (!$divisionModel->save())
                    {                        
                        $request = json_encode($divisionModel->attributes);
                        $this->log($params->vir_case_number, json_encode($divisionModel->getErrors()), $request);
                    }
                }

                $branchModel = PreinspectionClientBranch::find()->where([
                    'branchName' => @$params->initiator_branch,
                    'divisionId' => @$divisionModel->id,
                    'companyId' => 10
                ])->one();

                if (!empty($params->initiator_branch) && empty($branchModel))
                {
                    $branchModel = new PreinspectionClientBranch;
                    $branchModel->branchName = @$params->initiator_branch;
                    $branchModel->divisionId = @$divisionModel->id;
                    $branchModel->companyId = 10;
                    $branchModel->created_on = $currentDateTime;

                    if (!$branchModel->save())
                    {
                        $request = json_encode($branchModel->attributes);
                        $this->log($params->vir_case_number, json_encode($branchModel->getErrors()), $request);
                    }
                }                

	            $model->insurerDivision = !empty($divModel) ? @$divModel->id: @$divisionModel->id;
	            $model->insurerBranch = !empty($brModel) ? @$brModel->id: @$branchModel->id;
                $model->callerName = $user->id;
                $model->callerMobileNo = $user->mobile;
                $model->callerDetails = $user->email;

                $model->insuredName = $params->insured_name;
                $model->insuredMobile = $params->insured_mobile_no;
                $model->insuredMobileAlt = $params->insured_alt_mobile_no;
                $model->insuredAddress = $params->insured_address;

	            $model->created_on = $currentDateTime;
	            $model->intimationDate = $currentDateTime;
	            //$model->userId = Yii::$app->user->identity->id;
	            $model->referenceNo = $this->getReferenceNo();

                switch($params->status)
                {
                    case 'Assigned':
                        $piStatus = 0;
                        break;

                    case 'Rejected':
                        $piStatus = 9;
                        break;

                    case 'QC Pending':
                        $piStatus = 12;
                        break;

                    case 'Recommended':
                        $piStatus = 101;
                        break;

                    case 'Not Recommended':
                        $piStatus = 102;
                        break;

                    default:
                        $piStatus = 0;
                }

	            $model->status = $piStatus;
                $model->createMethod = 'RS API';

                

                // Assign case to that RO's 

                if(!empty($rousersIds) && !empty($rocaseCnt) && $regCode != 'KA'){
                    $roassingTracker = RoCaseAssignmentTracker::find()->where(['IN','roId',$rousersIds])->one();
                    $rolastTracker = RoLastTracker::find()->where(['IN','roId',$rousersIds])->one();
                    if($roassingTracker->roId){
                        // return 'if';
                        $check['type'] = 'roassingTracker';
                        $check['roId'] = $roassingTracker->roId;
                        $check['trackerCnt'] = $roassingTracker->trackerCnt;
                        $rouserInfo = User::findOne(['id'=>$roassingTracker->roId]);
                        // return $rouserInfo->stateId;
                        $arrayKey = array_search($roassingTracker->roId, $rousersIds);                            
                        // return $arrayKey;
                        $trackerCnt = $roassingTracker->trackerCnt + 1;
                        if($trackerCnt == $rocaseCnt[$arrayKey]){
                            $check['if'] = 'Y';
                            RoCaseAssignmentTracker::findOne($roassingTracker->id)->delete();
                            $rolastTracker = new RoLastTracker();
                            $rolastTracker->roId = $roassingTracker->roId;
                            $rolastTracker->stateId = $roassingTracker->stateId;
                            $rolastTracker->companyId = 10;
                            $rolastTracker->save();
                        }else{
                            $check['else'] = 'Y';
                            $roassingTracker->trackerCnt = $trackerCnt;
                            $roassingTracker->updatedOn = date('Y-m-d H:i:s');
                            // return $trackerCnt.' Updated';
                        }
                        $model->userId = $roassingTracker->roId;
                        $model->fristRoid = $roassingTracker->roId;                       
                        $model->stateId = @$rouserInfo->stateId;
                        $roassingTracker->save();
                    }elseif($rolastTracker->roId){
                        // return 'else if';
                        $check['type'] = 'rolastTracker';
                        $check['roId'] = $rolastTracker->roId;
                        $rouserInfo = User::findOne(['id'=>$rolastTracker->roId]);
                        $arrayKey = array_search($rolastTracker->roId, $rousersIds); 
                        // return print_r($rousersIds);
                        if(count($rousersIds) == (($arrayKey) + 1)){
                            $check['samecount-if'] = 'Y';
                            $roId = $rousersIds[0];
                            $roCnt = $rocaseCnt[0];
                        }else{
                            $check['samecount-else'] = 'Y';
                            $roId = $rousersIds[(($arrayKey) + 1)];
                            $roCnt = $rocaseCnt[(($arrayKey) + 1)];
                        }
                        // return $roId;
                        $rouserInfo = User::findOne(['id'=>$roId]);
                        $model->userId = @$rouserInfo->id;
                        $model->fristRoid = @$rouserInfo->id;                       
                        $model->stateId = @$rouserInfo->stateId;
                        if($roCnt == 1){
                            $check['rocount1-if'] = 'Y';
                            $rolastTracker0 = new RoLastTracker();
                            $rolastTracker0->roId = @$rouserInfo->id;
                            $rolastTracker0->stateId = @$rouserInfo->stateId;
                            $rolastTracker0->companyId = 10;
                            $rolastTracker0->save();
                        }else{
                            $check['rocount1-else'] = 'Y';
                            $roassingTracker = new RoCaseAssignmentTracker();
                            $roassingTracker->roId = @$rouserInfo->id;
                            $roassingTracker->companyId = 10;
                            $roassingTracker->stateId = @$rouserInfo->stateId;
                            $roassingTracker->trackerCnt = 1;
                            $roassingTracker->save();
                        }
                        RoLastTracker::findOne($rolastTracker->id)->delete();
                    }else{
                        $check['type'] = 'Main Else';
                        $check['roId'] = $rousersIds[0];
                        $rouserInfo = User::findOne(['id'=>$rousersIds[0]]);
                        // return $rouserInfo->stateId;
                        $model->userId = @$rouserInfo->id;
                        $model->fristRoid = @$rouserInfo->id;                       
                        $model->stateId = @$rouserInfo->stateId;
                        if($rocaseCnt[0] == 1){
                            $check['if'] = 'Y';
                            $rolastTracker = new RoLastTracker();
                            $rolastTracker->roId = @$rouserInfo->id;
                            $rolastTracker->stateId = @$rouserInfo->stateId;
                            $rolastTracker->companyId = 10;
                            $rolastTracker->save();
                        }else{
                            $check['else'] = 'Y';
                            $roassingTracker = new RoCaseAssignmentTracker();
                            $roassingTracker->roId = @$rouserInfo->id;
                            $roassingTracker->companyId = 10;
                            $roassingTracker->stateId = $rouserInfo->stateId;
                            $roassingTracker->trackerCnt = 1;
                            $roassingTracker->save();
                        }    
                        // return 'ro else';
                    }
                    array_push($test,$check);
                    // return print_r($rocaseCnt);
                }else{
                    $roUser = User::find()->where(['id' => $user->roId])->one();
                    // return $roUser->firstName;
                    if($roUser){                        
                        $model->userId = $roUser->id;
                        $model->fristRoid = $roUser->id;
                        $model->stateId = $roUser->stateId;
                    }else{
                        $roUser1 = User::find();
                        $roUser1 = $roUser1->join('LEFT JOIN','auth_assignment','auth_assignment.user_id = id')
                        ->andWhere(['auth_assignment.item_name' => 'BO User'])
                        ->andWhere(['users.stateId' => $getState->id])->one();
                        if($roUser1){                        
                            $model->userId = $roUser1->id;
                            $model->fristRoid = $roUser1->id;
                            $model->stateId = $roUser1->stateId;
                        }
                        if($user->roId == null){
                            $user->roId = $roUser1->id;
                            $user->save();
                        }
                    }
                    // return 'else';
                }

                // Assign case to that RO's 

	            if($model->save()) {    
	                if($model->surveyorName != '' && $model->insuredMobile != '')
	                {
	                    //$this->createCustomerSession($model->id);
	                }

	                $twowheelermodel = new AxionPreinspectionTwowheeler();
	                $twowheelermodel->preinspection_id = $model->id;
	                $twowheelermodel->save();

	                $fwheelermodel = new AxionPreinspectionFwheeler();
	                $fwheelermodel->preinspection_id = $model->id;
	                $fwheelermodel->save();

	                $commercialwheelermodel = new AxionPreinspectionCommercialwheeler();
	                $commercialwheelermodel->preinspection_id = $model->id;
	                $commercialwheelermodel->save();

                    //updating qc
	                $this->updateQc($model, 'insert');

                    $vehicleModel = AxionPreinspectionVehicle::findOne(['preinspection_id' => $model->id]);
                    //$vehicleModel->preinspection_id = $model->id;
                    $vehicleModel->fuelType = $params->fuel_type;
                    $vehicleModel->odometerReading = $params->odometer_reading;

                    switch($params->vehicle_type)
                    {
                        case 'Private Car':
                            $vType = '4-WHEELER';
                            $vCategory = '';
                            break;

                        case 'Two-wheeler':
                            $vType = '2-WHEELER';
                            $vCategory = '';
                            break;

                        case 'Passenger Carrying Vehicle':
                            $vType = 'COMMERCIAL';
                            $vCategory = 'Passenger Carrying Vehicle';
                            break;

                        case 'Goods Carrying Vehicle':
                            $vType = 'COMMERCIAL';
                            $vCategory = 'Goods Carrying Vehicle';
                            break;
                        
                        case 'Miscellaneous Vehicle':
                            $vType = 'COMMERCIAL';
                            $vCategory = 'Miscellaneous Vehicle';
                            break;
                            
                        default:
                            $vType = '4-WHEELER';
                            $vCategory = '';
                    }
                    $vehicleModel->vType = $vType;
                    $vehicleModel->vCategory = $vCategory;
                    $vehicleModel->save();

	                $obj = $this->findModel($model->id);
	                $hismodel = new AxionPreinspectionHistory();
	                $hismodel->attributes = $obj->attributes;
	                $hismodel->preinspection_id = $obj->id;
	                $hismodel->id = 0;
	                $hismodel->created_on = $currentDateTime;
	                $hismodel->save();
                    
                    $message = 'RSA VIR Status- Vehicle NO '.$model->registrationNo.' Pre inspection request has been assigned to Axion';
                    
                    //Sending sms to agent
                    $this->sendSms(@$model->callerMobileNo, $message);

                    //Sending sms to customer
                    $this->sendSms(@$model->insuredMobile, $message);
                    
                    $preinspectionModel = AxionPreinspection::findOne($model->id);

                    switch($params->status)
                    {
                        case 0:
                            $status = 'Assigned';
                            break;

                        case 9:
                            $status = 'Rejected';
                            break;

                        case 12:
                            $status = 'QC Pending';
                            break;

                        case 101:
                            $status = 'Recommended';
                            break;

                        case 102:
                            $status = 'Not Recommended';
                            break;

                        default:
                            $status = 'Assigned';
                    }

                    $insuredUser = User::findOne(['mobile' => @$model->insuredMobile]);

                    $emailSubject = 'VEHICLE NO: '.$model->registrationNo.'/'.$model->referenceNo.' - STATUS';
                    $emailMessage = '<strong>Dear Sir/Madam,<br><br>RSA VIR Status- Vehicle NO '.$model->registrationNo.' Pre inspection request has been assigned to Axion at '.date( 'd/m/Y h:i A', strtotime( $currentDateTime )).'</strong>';
                    $emailMessage .= '<br><p>Thanks & Regards,</p>';
                    $emailMessage .= '<h4>Axion Technical Services</h4>';
                    try {
                        $smailer=\Yii::$app->googlemailer->compose('../views/site/about',['message' =>$emailMessage]);
                        if($smailer)
                        {
                            $smailer->setFrom(['axiontechnicalservices@gmail.com' => 'No-reply@Axion'])
                            ->setTo(@$model->callerDetails) //manual.PI@godigit.com mythili.gopi@axionpcs.in
                            ->setSubject($emailSubject);
                            $smailer->send();

                            if ($model->insurerName == 10 || $model->insurerName == "ROYAL SUNDARAM GENERAL INSURANCE CO. LTD.")
                            {
                                $smailer->setFrom(['axiontechnicalservices@gmail.com' => 'No-reply@Axion'])
                                ->setTo(@$insuredUser->email) //manual.PI@godigit.com mythili.gopi@axionpcs.in
                                ->setSubject($emailSubject);
                                $smailer->send();
                            }
                        }                        
                        $result = [
                            'registration_number' => $preinspectionModel->registrationNo,
                            'vir_case_number' => $preinspectionModel->contactPersonMobileNo,
                            'reference_no' => $preinspectionModel->referenceNo,
                            'status' => $status
                        ];
                        Yii::$app->response->statusCode = 200;
                        $request = "Case created successfully in our portal";
                        $this->log($params->vir_case_number, json_encode($result), $request);
                        return ['status' => true, 'status_code' => 200, 'message' => 'Case Created Successfully', 'data' => $result];                    
                    } catch (\Exception $e) {
                        $result = [
                            'registration_number' => $preinspectionModel->registrationNo,
                            'vir_case_number' => $preinspectionModel->contactPersonMobileNo,
                            'reference_no' => $preinspectionModel->referenceNo,
                            'status' => $status
                        ];
                        Yii::$app->response->statusCode = 200;
                        $request = "Case created successfully in our portal";
                        $this->log($params->vir_case_number, json_encode($result), $request);
                        return ['status' => true, 'status_code' => 200, 'message' => 'Case Created Successfully', 'data' => $result];
                    }
                }
                else {
                    foreach ($model->getErrors() as $errorKey => $errorValue)
                    {
                       switch ($errorKey) 
                       {
                            case 'contactPersonMobileNo':
                                $fieldName = 'vir_case_number';
                                $errorText = str_replace('ULN', 'VIR case number', $errorValue[0]);
                                break;

                            case 'paymentMode':
                                $fieldName = 'payment_option';
                                $errorText = str_replace('Payment Mode*', 'Payment option', $errorValue[0]);
                                break;

                            case 'inspectionType':
                                $fieldName = 'reason_of_vir';
                                $errorText = str_replace('Inspection Type', 'Reason of VIR', $errorValue[0]);
                                break;

                            case 'callerName':
                                $fieldName = 'initiator_email_id';
                                $errorText = str_replace('Caller Name*', 'Initiator email id', $errorValue[0]);
                                break;

                            default:
                                $fieldName = $errorKey;
                                $errorText = $errorValue[0];
                       }
                       $error[] = $errorText;
                    }

                    Yii::$app->response->statusCode = 422;
                    $request = "Case not created in our portal";
                    $this->log($params->vir_case_number, json_encode($error), $request);
                    return ['status' => false, 'status_code' => 422, 'message' => 'Incorrect Request Data', 'data' => ['error' => $error]];
	            }	            
	        // }

        } 
    }


    public function actionGetRsReport()
    {

        Yii::$app->response->format = Response::FORMAT_JSON;
        Yii::$app->response->formatters = [
            Response::FORMAT_JSON => [
                'class' => JsonResponseFormatter::class,
                'prettyPrint' => true
            ]
        ];
        
        $post = (file_get_contents("php://input"));
        $params = json_decode($post);

        $error = [];

        $message = json_encode($params);
        if (isset($params->vir_case_number)) 
        {
            $this->log($params->vir_case_number, $message);
        }

        $headers = apache_request_headers();
        if ($headers['Authorization'] != 'Basic UlNHSTpSU0dJQFZleWVz') {
            Yii::$app->response->statusCode = 401;
            return ['status' => false, 'status_code' => 401, 'message' => 'Authorization failure', 'data' => ''];
        }
        
        if (!empty($params)) {

            /* if(!isset($params->reference_no) || ($params->reference_no=="") ){
                $error[] = "Reference number is required";
            } */

            if(!isset($params->vir_case_number) || ($params->vir_case_number=="") ){
                $error[] = "VIR case number is required";
            }
    
            if (count($error) > 0)
            {
                Yii::$app->response->statusCode = 422;
                $this->log($params->vir_case_number, $error);
                return ['status' => false, 'status_code' => 422, 'message' => 'Incorrect Request Data', 'data' => ['error' => $error]];        
            }
            else
            {
                $piModel = AxionPreinspection::find()->where(
                    ['contactPersonMobileNo' => $params->vir_case_number])->andFilterWhere(['referenceNo' => $params->reference_no])->one();  
                
                if (isset($piModel->id))
                {
                    if (in_array($piModel->status, [101, 102, 103, 104]))
                    {
                        $link = Yii::$app->urlManager->createAbsoluteUrl('axion-preinspection/vehicleqcpdf?id='.$piModel->id);

                        Yii::$app->response->statusCode = 200;
                        return ['status' => true, 'status_code' => 200, 'message' => 'Report Retrieved Successfully.', 'data' => ['link' => $link]];
                    }
                    else
                    {
                        $error[] = "The selected case is not completed yet.";
    
                        Yii::$app->response->statusCode = 422;
                        $this->log($params->vir_case_number, json_encode($error));
                        return ['status' => false, 'status_code' => 422, 'message' => 'Incorrect Request Data', 'data' => ['error' => $error]];
                    }
                    
                }
                else
                {
                    $error[] = "VIR case number or Reference number is not exists.";

                    Yii::$app->response->statusCode = 422;
                    $this->log($params->vir_case_number, json_encode($error));
                    return ['status' => false, 'status_code' => 422, 'message' => 'Incorrect Request Data', 'data' => ['error' => $error]];
                }
            }
        }
    }

    public function actionGetRsStatus()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        Yii::$app->response->formatters = [
            Response::FORMAT_JSON => [
                'class' => JsonResponseFormatter::class,
                'prettyPrint' => true
            ]
        ];
        
        $post = (file_get_contents("php://input"));
        $params = json_decode($post);

        // return $params;

        $error = [];

        $message = json_encode($params);
        // if (isset($params->reference_number)) 
        // {
        //     $this->log('RS Status Check', $message);
        // }

        $headers = apache_request_headers();
        if ($headers['Authorization'] != 'Basic UlNHSTpSU0dJQFZleWVz') {
            Yii::$app->response->statusCode = 401;
            return ['status' => false, 'status_code' => 401, 'message' => 'Authorization failure', 'data' => ''];
        }
        
        if (!empty($params)) {

            if(!isset($params->reference_number) || ($params->reference_number == "") ){
                $error[] = "Reference number is required";
            }
    
            if (count($error) > 0)
            {
                Yii::$app->response->statusCode = 422;
                $this->log('RS Status Error',$error,$message); 
                return ['status' => false, 'status_code' => 422, 'message' => 'Incorrect Request Data', 'data' => ['error' => $error]];        
            }
            else
            {
                if((isset($params->reference_number) && $params->reference_number != "")){
                    $piModel = AxionPreinspection::find()->where(['contactPersonMobileNo' => $params->reference_number])->one();  
                }elseif((isset($params->registration_number) && $params->registration_number != "")){
                    $piModel = AxionPreinspection::find()->where(['registrationNo' => $params->registration_number])->one();  
                }
                // elseif((isset($params->engine_number) && $params->engine_number != "") && (isset($params->chassis_number) && $params->chassis_number != "")){
                //     $piModel = AxionPreinspection::find()->where(['engineNo' => $params->engine_number, 'chassisNo' => $params->chassis_number])->one();  
                // }
                // return $piModel->status;
                if (isset($piModel->id))
                {
                    if (isset($piModel->status))
                    {
                        if($piModel->status == 101){
                            $status = 'Recommended';
                        }elseif($piModel->status == 102){
                            $status = 'Not Recommended';
                        }elseif($piModel->status == 103){
                            $status = 'In Processing';
                        }elseif($piModel->status == 104){
                            $status = 'Refer to Under Writer';
                        }elseif($piModel->status == 9){
                            $status = 'Cancelled';
                        }elseif($piModel->status == 0){
                            $status = 'Assigned';
                        }elseif($piModel->status == 12){
                            $status = 'QC Pending';
                        }else{
                            $status = $piModel->status;
                        }

                        Yii::$app->response->statusCode = 200;

                        $this->log('RS Status Check',json_encode(['registration_number' => $piModel->registrationNo, 'vir_case_number' => $piModel->contactPersonMobileNo, 'reference_no' => $piModel->referenceNo,'status' => $status]),$message); 

                        return ['status' => true, 'status_code' => 200, 'message' => 'Case Status Retrieved Successfully', 'data' => ['registration_number' => $piModel->registrationNo, 'vir_case_number' => $piModel->contactPersonMobileNo, 'reference_no' => $piModel->referenceNo,'status' => $status]];
                    }
                    else
                    {
                        $error[] = "The selected case is not completed yet.";
    
                        Yii::$app->response->statusCode = 422;
                        // $this->log($params->vir_case_number, json_encode($error));
                        $this->log('RS Status Error',$error,$message); 
                        return ['status' => false, 'status_code' => 422, 'message' => 'Incorrect Request Data', 'data' => ['error' => $error]];
                    }
                    
                }
                else
                {
                    $error[] = "Given data's is not exists.";

                    Yii::$app->response->statusCode = 422;
                    // $this->log($params->vir_case_number, json_encode($error));
                    return ['status' => false, 'status_code' => 422, 'message' => 'Incorrect Request Data', 'data' => ['error' => $error]];
                }
            }
        }
    }

    public function actionCancelRsCase()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        Yii::$app->response->formatters = [
            Response::FORMAT_JSON => [
                'class' => JsonResponseFormatter::class,
                'prettyPrint' => true
            ]
        ];
        
        $post = (file_get_contents("php://input"));
        $params = json_decode($post);

        // return $params;

        $error = [];

        $message = json_encode($params);
        $headers = apache_request_headers();
        if ($headers['Authorization'] != 'Basic UlNHSTpSU0dJQFZleWVz') {
            Yii::$app->response->statusCode = 401;
            return ['status' => false, 'status_code' => 401, 'message' => 'Authorization failure', 'data' => ''];
        }
        
        if (!empty($params)) {

            if(!isset($params->action) || ($params->action == "") ){
                $error[] = "Action is required";
            }
    
            if(!isset($params->vir_case_number) || ($params->vir_case_number == "") ){
                $error[] = "VIR case number is required";
            }

            if(!isset($params->remarks) || ($params->remarks == "") ){
                $error[] = "Remarks is required";
            }


            if (count($error) > 0)
            {
                Yii::$app->response->statusCode = 422;
                $this->log("RS Cancel Error", $error, $message);
                return ['status' => false, 'status_code' => 422, 'message' => 'Incorrect Request Data', 'data' => ['error' => $error]];        
            }
            else
            {
                if((isset($params->vir_case_number) && $params->vir_case_number != "")){
                    $piModel = AxionPreinspection::find()->where(['contactPersonMobileNo' => $params->vir_case_number])->one();  
                }elseif((isset($params->registration_number) && $params->registration_number != "")){
                    $piModel = AxionPreinspection::find()->where(['registrationNo' => $params->registration_number])->one();  
                }elseif((isset($params->reference_number) && $params->reference_number != "")){
                    $piModel = AxionPreinspection::find()->where(['referenceNo' => $params->reference_number])->one();  
                }
                // return $piModel->status;
                date_default_timezone_set('Asia/Kolkata');
                $currentDateTime = date('Y-m-d H:i:s');
                if (isset($piModel->id))
                {
                    if($piModel->status == 0){                        
                        $piModel->status = 9;
                        $piModel->remarks = $params->remarks;
                        if($piModel->cancelledBy == Null){
                            $piModel->cancelledBy = "RS Cancel API";
                        }
                        if($piModel->save(false)){

                            $hismodel = new AxionPreinspectionHistory();
                            $hismodel->attributes = $piModel->attributes;
                            $hismodel->preinspection_id = $piModel->id;
                            $hismodel->id = 0;
                            $hismodel->created_on = $currentDateTime;
                            if (!$hismodel->save(false)) {
                                $this->log($piModel->contactPersonMobileNo, json_encode($hismodel->getErrors()));
                            }

                            $this->log("RS Cancel", json_encode(['status' => true, 'status_code' => 200, 'message' => 'Case Cancelled Successfully', 'data' => ['registration_number' => $piModel->registrationNo, 'vir_case_number' => $piModel->contactPersonMobileNo, 'reference_no' => $piModel->referenceNo]]), $message);

                            Yii::$app->response->statusCode = 200;
                            return ['status' => true, 'status_code' => 200, 'message' => 'Case Cancelled Successfully', 'data' => ['registration_number' => $piModel->registrationNo, 'vir_case_number' => $piModel->contactPersonMobileNo, 'reference_no' => $piModel->referenceNo]];
                            
                        }    
                    }else{
                        if($piModel->status != 9){
                            $error[] = "Cancellation request failed. The case is under processing.";
                        }else{
                            $error[] = "This requested case has already been cancelled.";
                        }
                        Yii::$app->response->statusCode = 422;
                        $this->log("RS Cancel Error", $error, $message);
                        return ['status' => false, 'status_code' => 422, 'message' => 'Request Data Failed', 'data' => ['error' => $error]];
                    }
                }
                else
                {
                    $error[] = "Given data's is not exists.";

                    Yii::$app->response->statusCode = 422;
                    $this->log("RS Cancel Error", $error, $message);
                    return ['status' => false, 'status_code' => 422, 'message' => 'Incorrect Request Data', 'data' => ['error' => $error]];
                }
            }
        }
    }

    // New Tata Agi API 23092023
    
    public function createTataAgiApi($auth,$divisionId=false,$stateId=false){

        // $url = "https://uatbyomkeshmotorapi.tataaig.com/api/lob-specific/motor-claims/inspections";  // TEST 
        $url = "https://byomkeshmotorapi.tataaig.com/api/lob-specific/motor-claims/inspections"; // Production
        $method = "GET";

        $result = $this->curltataagi($auth, $url, $method);
        if($result){
            $data = json_decode($result);   
            // echo '<pre>';print_r($data);exit; 
            if($data){
                $insurer = PreinspectionClientCompany::find()->where(['like', 'companyName', "TATA AIG" . '%', false])->one();

                foreach($data as $row){
                        
                    date_default_timezone_set('Asia/Kolkata');
                    $currentDateTime = date('Y-m-d H:i:s');
                    $createdMonth = date("Ym",strtotime($row->CreatedDateTime));
                    $currentMonth = date("Ym",strtotime("-1 Months"));


                    if ( $createdMonth < $currentMonth ) {
                        continue;
                    }

                    //echo '<pre>';print_r($row);exit; 
                    
                    $exist = AxionPreinspection::findOne(['contactPersonMobileNo' => $row->LeadID]);  
                    //echo '<pre>';print_r($model);exit;                  
                    if(!$exist){

                        $query = User::find();
                        $query->join('LEFT JOIN','auth_assignment','auth_assignment.user_id = id')
                        ->andWhere(['auth_assignment.item_name' => 'BO User'])
                        ->andWhere(['users.stateId' => $stateId]);

                        $userData = $query->one();

                        $getinsurerBranch = PreinspectionClientBranch::find(['companyId' => $insurer->id, 'divisionId' => $divisionId])->one();
                        

                        $emails = ($row->ProposerEmailId) ? explode(",", $row->ProposerEmailId) : '';
                        $userEmail1 = trim($emails[0]) == '' ? trim($emails[1]) : trim($emails[0]);
                        $userEmail2 = trim($emails[1]) == '' ? trim($emails[2]) : trim($emails[1]);
                        // return $userEmail1.' ~~ '.$userEmail2;
                        $user='';
                        if($emails){
                            if($userEmail1 != ''){
                                $user = isset($userEmail1) ? User::findOne(['email' => $userEmail1]) : '';
                                $userEmail = $userEmail1;
                            }elseif($userEmail2 != ''){
                                $user = isset($userEmail2) ? User::findOne(['email' => $userEmail2]) : '';
                                $userEmail = $userEmail2;
                            }
                            // return 'userEmail - '.$userEmail;
                            if(!$user && isset($userEmail)){
                                $userModel = new User();
                                $userModel->scenario='api-create';
                                $userModel->activationLink = 'Y';
                                $userModel->createdOn = $currentDateTime;
                                $userModel->password = "123456";
                                $userModel->email = $userEmail;
                                $userModel->firstName = $row->ProposerorRepresentative ?? explode('@',$emails[0])[0];
                                if($divisionId){
                                    $userModel->companyId = ($insurer) ? $insurer->id : '';
                                    $userModel->divisionId = $divisionId;
                                    $userModel->branchId = @$getinsurerBranch->id;                                    
                                }
                                if($userModel->save())
                                {
                                    $auth = new DbManager;
                                    $auth->init();
                                    $role = $auth->getRole('Branch Executive');
                                    $auth->assign($role, $userModel->id);
                                    $user = $userModel;
                                }
                            }elseif(!empty($user)){
                                $user->scenario='api-create';
                                $user->email = $user->email;
                                $user->password = "123456";
                                if($user->firstName == null || $user->firstName == ''){
                                    $user->firstName = $row->ProposerorRepresentative ?? explode('@',$emails[0])[0];
                                }
                                if($divisionId){
                                    $user->companyId = ($insurer) ? $insurer->id : '';                                   
                                    $user->divisionId = $divisionId;                                   
                                    $user->branchId = @$getinsurerBranch->id;                                             
                                    $user->save();                    
                                }
                            }
                        }
                        else if(!$user) // If email id is empty
                        {
                            $query = User::find();
                            $query->join('LEFT JOIN','auth_assignment','auth_assignment.user_id = id')
                            ->andWhere(['auth_assignment.item_name' => 'Branch Executive'])
                            ->andWhere(['users.roId' => @$userData->id]);

                            $user = $query->one();
                        }


                        $model = new AxionPreinspection();
                        $model->referenceNo = $this->getReferenceNo();
                        $model->created_on = $currentDateTime;
                        $model->intimationDate = $currentDateTime;
                        $model->status = 0;

                        $model->insurerName = ($insurer) ? $insurer->id : '';
                        $model->manufacturer = $row->Make;
                        $model->model = $row->Models;
                        
                        if($user){
                            $model->userId = $userData->id;
                            $model->fristRoid = $userData->id;
                            $model->stateId = $stateId;
                            $model->callerName = $user->id;
                            $model->callerMobileNo = $user->mobile;
                            $model->callerDetails = $user->email;

                            $model->insurerDivision = ($user->divisionId) ? $user->divisionId : $divisionId;
                            $model->insurerBranch = $user->branchId;
                        }

                        $model->inspectionType = "Break In";
                        $model->registrationNo = $row->VehicleRegNo;
                        /*$insuredName = $row->Insurername;
                        if($row->CustomerFname || $row->CustomerLname){
                            $insuredName = $insuredName." - ".$row->CustomerFname." ".$row->CustomerLname;
                        }*/
                        $insuredName="";
                        if($row->CustomerFname || $row->CustomerLname){
                            $insuredName = $row->CustomerFname." ".$row->CustomerLname;
                        }
                        $today = date("Y-m-d");
                        $prefirstday = date('Y-m-01');
                        $checkPayment = AxionPreinspection::find()->where(['like','registrationNo','%'.$row->VehicleRegNo.'%',false])->andwhere(['between', 'intimationDate',$prefirstday,$today])->all();
                        if ($row->Lead_Payment_Status == 'Company Paid' && count($checkPayment) == 0)
                        {
                            $paymentMode = 1;
                        }
                        else if ($row->Lead_Payment_Status == 'Customer Paid')
                        {
                            $paymentMode = 2;
                        }
                        $model->insuredName = $insuredName;
                        $model->insuredMobile = $row->CustomerContactNo;
                        $model->engineNo = $row->EngineNo;
                        $model->chassisNo = $row->ChassisNo;
                        $model->paymentMode = $paymentMode;
                        $model->remarks = $row->Remark;
                        $model->contactPersonMobileNo = sprintf('%d', $row->LeadID);
                        $model->surveyLocation = $row->CustomerAddress1;
                        $model->insuredAddress = $row->CustomerCityName;
                        $model->createMethod = 'New TataAgi Api';
                        //echo '<pre>';print_r($model);exit;

                        if ($model->save()) {
                            $twowheelermodel = new AxionPreinspectionTwowheeler();
                            $twowheelermodel->preinspection_id = $model->id;
                            $twowheelermodel->save();
                            $fwheelermodel = new AxionPreinspectionFwheeler();
                            $fwheelermodel->preinspection_id = $model->id;
                            $fwheelermodel->save();
                            $commercialwheelermodel = new AxionPreinspectionCommercialwheeler();
                            $commercialwheelermodel->preinspection_id = $model->id;
                            $commercialwheelermodel->save();                            
                            
                            //updating qc
                            $this->updateQc($model, 'insert');                            
                            $currentDateTime = date( 'Y-m-d H:i:s');
                            $obj = $this->findModel($model->id);
                            $hismodel = new AxionPreinspectionHistory();
                            $hismodel->attributes = $obj->attributes;
                            $hismodel->preinspection_id = $obj->id;
                            $hismodel->id = 0;
                            $hismodel->created_on = $currentDateTime;
                            $hismodel->save();
                            $this->log($model->contactPersonMobileNo,json_encode($data),"Created Case Successfully");
                        }else{
                            //echo '<pre>';print_r($model->getErrors());exit;
                            $leadNumber = $row->LeadID;
                            $message = json_encode($model->getErrors());
                            $request = json_encode($model->attributes);
                            $this->log($leadNumber,$message,$request);
                        }

                        /*if(!$model->save()){
                            print_r($model->getErrors());exit;
                        }*/
                    }
                    
                }
                $res = "Created Case Successfully";
            }else{
                $res = "No Results Found";
            }

        }
        else{
            $res = "No Results Found";
        }

        return $res;
    }

    public function createTataAgiApiTest($auth,$divisionId=false,$stateId=false){

        // $url = "https://uatbyomkeshmotorapi.tataaig.com/api/lob-specific/motor-claims/inspections";  // TEST 
        $url = "https://byomkeshmotorapi.tataaig.com/api/lob-specific/motor-claims/inspections"; // Production
        $method = "GET";

        $result = $this->curltataagi($auth, $url, $method);
        if($result){
            $data = json_decode($result);   
            // echo '<pre>';print_r($data);exit; 
            if($data){
                $insurer = PreinspectionClientCompany::find()->where(['like', 'companyName', "TATA AIG" . '%', false])->one();

                foreach($data as $row){
                        
                    date_default_timezone_set('Asia/Kolkata');
                    $currentDateTime = date('Y-m-d H:i:s');
                    $createdMonth = date("Ym",strtotime($row->CreatedDateTime));
                    $currentMonth = date("Ym",strtotime("-1 Months"));


                    if ( $createdMonth < $currentMonth ) {
                        continue;
                    }

                    //echo '<pre>';print_r($row);exit; 
                    // return gettype($row->LeadID);
                    if($row->LeadID == 5088716){    
                        // return $row->LeadID;                
                        $exist = AxionPreinspection::findOne(['contactPersonMobileNo' => $row->LeadID]);  
                        return $exist->id;
                        //echo '<pre>';print_r($model);exit;                  
                        if($exist){

                            $query = User::find();
                            $query->join('LEFT JOIN','auth_assignment','auth_assignment.user_id = id')
                            ->andWhere(['auth_assignment.item_name' => 'BO User'])
                            ->andWhere(['users.stateId' => $stateId]);

                            $userData = $query->one();

                            $getinsurerBranch = PreinspectionClientBranch::find(['companyId' => $insurer->id, 'divisionId' => $divisionId])->one();
                            

                            $emails = ($row->ProposerEmailId) ? explode(",", $row->ProposerEmailId) : '';
                            $userEmail1 = trim($emails[0]) == '' ? trim($emails[1]) : trim($emails[0]);
                            $userEmail2 = trim($emails[1]) == '' ? trim($emails[2]) : trim($emails[1]);
                            // return $userEmail1.' ~~ '.$userEmail2;
                            $user='';
                            if($emails){
                                if($userEmail1 != ''){
                                    $user = isset($userEmail1) ? User::findOne(['email' => $userEmail1]) : '';
                                    $userEmail = $userEmail1;
                                }elseif($userEmail2 != ''){
                                    $user = isset($userEmail2) ? User::findOne(['email' => $userEmail2]) : '';
                                    $userEmail = $userEmail2;
                                }
                                return 'userEmail - '.$userEmail;
                                if(!$user && isset($userEmail)){
                                    $userModel = new User();
                                    $userModel->scenario='api-create';
                                    $userModel->activationLink = 'Y';
                                    $userModel->createdOn = $currentDateTime;
                                    $userModel->password = "123456";
                                    $userModel->email = $userEmail;
                                    $userModel->firstName = $row->ProposerorRepresentative ?? explode('@',$emails[0])[0];
                                    if($divisionId){
                                        $userModel->companyId = ($insurer) ? $insurer->id : '';
                                        $userModel->divisionId = $divisionId;
                                        $userModel->branchId = @$getinsurerBranch->id;                                    
                                    }
                                    if($userModel->save())
                                    {
                                        $auth = new DbManager;
                                        $auth->init();
                                        $role = $auth->getRole('Branch Executive');
                                        $auth->assign($role, $userModel->id);
                                        $user = $userModel;
                                    }
                                }elseif(!empty($user)){
                                    $user->scenario='api-create';
                                    $user->email = $user->email;
                                    $user->password = "123456";
                                    if($user->firstName == null || $user->firstName == ''){
                                        $user->firstName = $row->ProposerorRepresentative ?? explode('@',$emails[0])[0];
                                    }
                                    if($divisionId){
                                        $user->companyId = ($insurer) ? $insurer->id : '';                                   
                                        $user->divisionId = $divisionId;                                   
                                        $user->branchId = @$getinsurerBranch->id;                                             
                                        $user->save();                    
                                    }
                                }
                            }
                            else if(!$user) // If email id is empty
                            {
                                $query = User::find();
                                $query->join('LEFT JOIN','auth_assignment','auth_assignment.user_id = id')
                                ->andWhere(['auth_assignment.item_name' => 'Branch Executive'])
                                ->andWhere(['users.roId' => @$userData->id]);

                                $user = $query->one();
                            }


                            $model = new AxionPreinspection();
                            $model->referenceNo = $this->getReferenceNo();
                            $model->created_on = $currentDateTime;
                            $model->intimationDate = $currentDateTime;
                            $model->status = 0;

                            $model->insurerName = ($insurer) ? $insurer->id : '';
                            $model->manufacturer = $row->Make;
                            $model->model = $row->Models;
                            
                            if($user){
                                $model->userId = $userData->id;
                                $model->fristRoid = $userData->id;
                                $model->stateId = $stateId;
                                $model->callerName = $user->id;
                                $model->callerMobileNo = $user->mobile;
                                $model->callerDetails = $user->email;

                                $model->insurerDivision = ($user->divisionId) ? $user->divisionId : $divisionId;
                                $model->insurerBranch = $user->branchId;
                            }

                            $model->inspectionType = "Break In";
                            $model->registrationNo = $row->VehicleRegNo;
                            /*$insuredName = $row->Insurername;
                            if($row->CustomerFname || $row->CustomerLname){
                                $insuredName = $insuredName." - ".$row->CustomerFname." ".$row->CustomerLname;
                            }*/
                            $insuredName="";
                            if($row->CustomerFname || $row->CustomerLname){
                                $insuredName = $row->CustomerFname." ".$row->CustomerLname;
                            }
                            $checkPayment = AxionPreinspection::find()->where(['like','registrationNo','%'.$row->VehicleRegNo.'%',false])->andwhere(['between', 'intimationDate',$prefirstday,$today])->all();
                            if ($row->Lead_Payment_Status == 'Company Paid' && count($checkPayment) == 0)
                            {
                                $paymentMode = 1;
                            }
                            else if ($row->Lead_Payment_Status == 'Customer Paid')
                            {
                                $paymentMode = 2;
                            }
                            $model->insuredName = $insuredName;
                            $model->insuredMobile = $row->CustomerContactNo;
                            $model->engineNo = $row->EngineNo;
                            $model->chassisNo = $row->ChassisNo;
                            $model->paymentMode = $paymentMode;
                            $model->remarks = $row->Remark;
                            $model->contactPersonMobileNo = sprintf('%d', $row->LeadID);
                            $model->surveyLocation = $row->CustomerAddress1;
                            $model->insuredAddress = $row->CustomerCityName;
                            $model->createMethod = 'New TataAgi Api';
                            //echo '<pre>';print_r($model);exit;

                            if ($model->save()) {
                                $twowheelermodel = new AxionPreinspectionTwowheeler();
                                $twowheelermodel->preinspection_id = $model->id;
                                $twowheelermodel->save();
                                $fwheelermodel = new AxionPreinspectionFwheeler();
                                $fwheelermodel->preinspection_id = $model->id;
                                $fwheelermodel->save();
                                $commercialwheelermodel = new AxionPreinspectionCommercialwheeler();
                                $commercialwheelermodel->preinspection_id = $model->id;
                                $commercialwheelermodel->save();                            
                                
                                //updating qc
                                $this->updateQc($model, 'insert');                            
                                $currentDateTime = date( 'Y-m-d H:i:s');
                                $obj = $this->findModel($model->id);
                                $hismodel = new AxionPreinspectionHistory();
                                $hismodel->attributes = $obj->attributes;
                                $hismodel->preinspection_id = $obj->id;
                                $hismodel->id = 0;
                                $hismodel->created_on = $currentDateTime;
                                $hismodel->save();
                                $this->log($model->contactPersonMobileNo,json_encode($data),"Created Case Successfully");
                            }else{
                                //echo '<pre>';print_r($model->getErrors());exit;
                                $leadNumber = $row->LeadID;
                                $message = json_encode($model->getErrors());
                                $request = json_encode($model->attributes);
                                $this->log($leadNumber,$message,$request);
                            }

                            /*if(!$model->save()){
                                print_r($model->getErrors());exit;
                            }*/
                        }
                    }
                    
                }
                $res = "Created Case Successfully";
            }else{
                $res = "No Results Found";
            }

        }
        else{
            $res = "No Results Found";
        }

        return $res;
    }
    
    public function curltataagi($auth, $url, $method="GET"){
        $curl = curl_init();

        //  "authorization: Basic PuwoFFOP+Zr2wtaTjv9KnQ==",

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_HTTPHEADER => array(
                "x-api-key: ".$auth
            ),
        ));

        $response = curl_exec($curl);


        $err = curl_error($curl);

        if($err){
            $response = false;
        }
        // curl_close($curl);
        return $response;

    }

    //create request for Tamilnadu
    public function actionCreateTataagiTn(){
        // return "test";
        $auth = "872f4d85-4083-4bb7-8be5-1cb82743d841";
        $divisionId = 5;
        $stateArr = ["Tamilnadu","TAMILNADU","Tamil Nadu","TAMIL NADU","Tamil nadu","tamilnadu"];
        $state =$this->getState($stateArr);
        $stateId = ($state) ? $state->id : '';
        return $this->createTataAgiApi($auth,$divisionId,$stateId);
    }
    //create request for Kerala
    public function actionCreateTataagiKl(){
        $auth = "479ec179-b5c8-44bc-8a50-bbb779e923c1";
        $divisionId = 7;
        $stateArr = ["Kerala","KERALA","kerala"];
        $state =$this->getState($stateArr);
        $stateId = ($state) ? $state->id : '';
        return $this->createTataAgiApi($auth,$divisionId,$stateId);
    }
    //create request for Karnataka
    public function actionCreateTataagiKn(){
        $auth = "8e9e003b-5ef4-4abf-acf2-fca7168b54eb";
        $divisionId = 47;
        $stateArr = ["KARNATAKA","Karnataka","karnataka"];
        $state =$this->getState($stateArr);
        $stateId = ($state) ? $state->id : '';
        return $this->createTataAgiApi($auth,$divisionId,$stateId);
    }
    //create request for Karnataka
    public function actionCreateTataagiKnTest(){
        $auth = "8e9e003b-5ef4-4abf-acf2-fca7168b54eb";
        $divisionId = 47;
        $stateArr = ["KARNATAKA","Karnataka","karnataka"];
        $state =$this->getState($stateArr);
        $stateId = ($state) ? $state->id : '';
        return $this->createTataAgiApiTest($auth,$divisionId,$stateId);
    }
    public function actionCreateTataagiAp(){
        $auth = "0de3a3c2-9d98-441c-9fa8-43da27013a8e";
        $divisionId = 14;
        $stateArr = ["Andhra Pradesh","andhra pradesh","ANDHRA PRADESH"];
        $state =$this->getState($stateArr);
        $stateId = ($state) ? $state->id : '';
        return $this->createTataAgiApi($auth,$divisionId,$stateId);
    }
}
?>