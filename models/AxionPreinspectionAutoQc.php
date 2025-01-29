<?php

namespace app\models;
use yii\helpers\ArrayHelper;


use Yii;

/**
 * This is the model class for table "axion_preinspection".
 *
 * @property integer $id
 * @property integer $referenceNo
 * @property integer $insurerName
 * @property integer $insurerDivision
 * @property integer $insurerBranch
 * @property string $intimationDate
 * @property integer $callerName
 * @property string $callerMobileNo
 * @property string $callerDetails
 * @property string $insuredName 
 * @property string $insuredMobile
 * @property string $induredEmail
 * @property string $contactPersonMobileNo
 * @property string $insuredAddress
 * @property string $registrationNo
 * @property string $engineNo
 * @property string $chassisNo
 * @property string $vehicleType
 * @property string $vehicleTypeRadio
 * @property string $manufacturer
 * @property string $model
 * @property integer $manufacturingYear
 * @property string $intimationRemarks
 * @property integer $cityId
 * @property integer $townId
 * @property integer $extraKM
 * @property string $surveyLocation
 * @property integer $surveyorName
 * @property string $sendLink
 * @property string $surveyorAppointDateTime
 * @property string $rescheduleReason
 * @property string $rescheduleDateTime
 * @property string $rescheduleReason1
 * @property string $rescheduleDateTime1
 * @property string $inspectionType
 * @property integer $paymentMode
 * @property integer $status
 * @property string $customerAppointDateTime
 * @property string $remarks
 * @property integer $cancellationReason
 * @property string $cashCollection
 * @property string $completedSurveyDateTime
 * @property integer $userId
 * @property integer $fristRoid
 * @property integer $followupReason
 * @property string $followupRemainder
 * @property string $followupUpdatedDateTime
 * @property string $followupUpdatedBy
 * @property string $ro
 * @property string $uploadSource
 * @property integer $vType_id
 * @property string $uploadPath
 * @property string $taigRequestStatus
 * @property integer $taigStatusCode
 * @property string $ErrorDesc
 * @property string $conveyanceApproval
 * @property string $conveyanceApprovalImg
 * @property string $created_on
 * @property string $regionName
 * @property string $total_score
 */
class AxionPreinspectionAutoQc extends \yii\db\ActiveRecord
{
    public $totalKm,$total2W,$total3W,$total4W,$totalCW,$billPeriodFrom,$billPeriodTo,$billDetails;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'axion_preinspection';
    }

    /**
     * @inheritdoc
     */
    public $vTypeName; 
    public $role;

    public function rules()
    {
        $role = array_keys(Yii::$app->authManager->getRolesByUser(Yii::$app->user->getId()))[0];
        $rules = [
            
            [['referenceNo', 'manufacturingYear','stateId', 'cityId', 'townId', 'surveyorName', 'status', 'paymentMode', 'cancellationReason', 'userId', 'followupReason','insurerName', 'insurerDivision', 'insurerBranch', 'callerName','taigStatusCode','updatedBy'], 'integer'],
            [['referenceNo'], 'unique', 'message' => 'referenceNo already exists'],
            [['intimationDate', 'surveyorAppointDateTime', 'rescheduleDateTime', 'rescheduleDateTime1', 'customerAppointDateTime', 'completedSurveyDateTime', 'followupRemainder', 'followupUpdatedDateTime', 'created_on','uploadSource','vehicleType','vehicleTypeRadio','vType_id', 'sbuCode', 'insuredMobileAlt', 'surveyDoneOn', 'updated_on','qcDoneOn','cancelledOn','fristRoid','inspectionType','insuredName','insuredMobile', 'callerName', 'induredEmail', 'oreder_id', 'pay_status', 'total_score', 'regionName', 'surveyLocation', 'surveyLocation2', 'extraKM', 'remarks'], 'safe'],
            [['callerDetails', 'insuredName', 'followupUpdatedBy', 'contactPersonMobileNo', 'model','taigRequestStatus','createMethod'], 'string', 'max' => 100],
            [['callerMobileNo', 'insuredMobile', 'insuredMobileAlt'], 'string', 'max' => 12],
            [['insuredAddress', 'intimationRemarks', 'rescheduleReason', 'rescheduleReason1', 'ro','vTypeName','uploadPath','ErrorDesc','customerOccupation','residence','customerAge','numberOfCarsOwned','vehicleParked','securityOfVehicle','relationship','maintenance','vehicleTimeOfInspection','updatedContact'], 'string', 'max' => 255],
            [['registrationNo', 'engineNo', 'chassisNo', 'manufacturer'], 'string', 'max' => 50],
            [['registrationNo', 'engineNo', 'chassisNo'], 'string', 'min' => 6, 'on'=>'vehicleqc'],
            ['callerDetails', 'email'],
            [['vehicleType'], 'string', 'max' => 30],
            [['sendLink', 'conveyanceApproval'], 'string', 'max' => 3],
            [['inspectionType'], 'string', 'max' => 50],
            [['cashCollection'], 'string', 'max' => 15],
            [['vType'], 'required'], 
            [['status'],'required','on'=>'update', 'when' => function ($model) {
                if($this->status != 9)
                {
                    if($this->surveyLocation == ''){
                        $this->addError('surveyLocation', 'Survey From Location cannot be blank.');
                    }
                    if($this->surveyLocation2 == ''){
                        $this->addError('surveyLocation2', 'Survey To Location cannot be blank.');
                    }
                    if($this->extraKM == ''){
                        $this->addError('extraKM', 'Extra Km cannot be blank.');
                    }
                }elseif($this->status == 9){
                    if($this->cancellationReason == ''){
                        $this->addError('cancellationReason', 'Reason of Cancellation cannot be blank.');
                    }
                }
            }], 
            [['paymentMode'], 'required','message' => 'Pay Mode is required', 'on'=>['assigned_role', 'bexe_role', 'billingUpdate']],
            [['paymentMode'], 'required', 'on'=>'update', 'when' => function ($model) {
                return $role == 'Superadmin' || $role == 'Branch Executive'; 
            }],
            [['paymentMode'], 'required', 'on'=>'vehicleqc', 'when' => function ($model) {
                return $role == 'Admin' || $role == 'Superadmin'; 
            }],
            /* [['cashCollection'], 'required', 'when' => function ($model) {
                return $model->paymentMode == 2; 
            }], */
            [['paymentMode'],'integer','on'=>'surveyor_role'],
            [['paymentMode'],'required','on'=>'update', 'when' => function ($model) {
                if(($this->paymentMode == 2 || $this->paymentMode == 3) && $this->cashCollection == '')
                {
                    $this->addError('cashCollection', 'Cash to be Collected cannot be blank.');
                } 
            }], 
            [['contactPersonMobileNo'], 'required', 'on'=>'vehicleqc', 'when' => function ($model) {
                return $role == 'Admin' || $role == 'Superadmin'; 
            }],
            [['completedSurveyDateTime','registrationNo','engineNo','chassisNo','remarks','extraKM','manufacturer','model', 'conveyanceApproval'], 'required', 'on' => 'vehicleqc'],
            [['registrationNo'],'required','message'=>'Enter Your Vehicle Registration Number'],

            // [['registrationNo'], 'match', 'pattern' => '/^[a-zA-Z]/', 'message' => 'Registration No. must start with an alphabet', 'on'=>['assigned_role', 'bexe_role', 'surveyor_role', 'update']], // , 'vehicleqc'

            // [['registrationNo'], 'match', 'pattern' => '/^[a-zA-Z0-9]+$/', 'message' => 'Registration No. must not contain space or special characters', 'on'=>['assigned_role', 'bexe_role', 'surveyor_role', 'update', 'vehicleqc']],

            // [['extraKM'],'required','on'=>'update'],
            [['conveyanceApprovalImg'], 'file', 'extensions' => ['jpg','jpeg'], 'mimeTypes' => 'image/jpeg' , 'maxSize' => 1024 * 1024 * 2],
            /* [['conveyanceApprovalImg'],'required', 'when' => function ($model) { 
                return $model->conveyanceApproval == 'Yes'; 
            }, 'whenClient' => "function (attribute, value) {
                return $('#axionpreinspection-conveyanceapproval').val() == 'Yes';
            }"], */

            //['conveyanceApproval','conveyanceApprovalCheck'],
            [['remarks'], 'required','message' => 'Remarks is required', 'on'=>['create', 'update']],
            [['registrationNo', 'insuredMobile', 'insuredAddress', 'vType'], 'required', 'on' => ['quickcreate']],
            ['completedSurveyDateTime','intimationDateCheck']
            
        ];
        
        
        //if(strpos( Yii::$app->request->absoluteUrl, 'taig-wb') !== false) {
        $rules_ULN = [
            [['contactPersonMobileNo'], 'required', 'message' => 'ULN is required', 'on'=>'assigned_role'],
            [['contactPersonMobileNo'], 'string','on'=>'surveyor_role'],
            [['contactPersonMobileNo'], 'unique', 'message' => 'ULN already exists' ],
            [['contactPersonMobileNo'], 'string', 'min' => '6', 'tooShort' => 'ULN should contain at most 6 characters.'],
            [['contactPersonMobileNo'], 'trim', 'message' => 'No white spaces allowed!'],
        ];
        
        $rules = ArrayHelper::merge($rules, $rules_ULN);
        //}
        
        return $rules;
    }
    
    public function intimationDateCheck()
    {
        date_default_timezone_set("Asia/Calcutta");   //India time (GMT+5:30)
        $model = AxionPreinspection::findOne($this->id);
        $date1 =  $model->intimationDate;
        $date2 = $this->completedSurveyDateTime;
        $current_date=date('Y-m-d H:i:s');

        // echo strtotime($date2)."<br>";
        // echo strtotime($current_date);
        // exit;
       
        if(strtotime($date2) < strtotime($date1))
        {
            $this->addError('completedSurveyDateTime', strtotime($date2).' < '.strtotime($date1));
        }
        if(strtotime($date2)>strtotime($current_date)) 
        {
           $this->addError('completedSurveyDateTime', 'Completed Date and time Not Match with Current Date and Time.');
        }           
    }

    /* public function conveyanceApprovalCheck()
    {
        $model = AxionPreinspection::findOne($this->id);
        echo $this->conveyanceApproval;
        print_r($_POST);
        exit;
        if ($this->conveyanceApproval == 'Yes') {
            //die('Img-'.$_FILES['AxionPreinspection']['conveyanceApprovalImg']);
            if (!$_FILES['AxionPreinspection']['conveyanceApprovalImg'])
                $this->addError('conveyanceApprovalImg', 'Please upload Conveyance Approval Image');
            //die('Img '.$this->conveyanceApprovalImg);
        }
        else {
            
        }          
    } */
    
    public function getHistory()
    {
        $query = $this->hasMany(AxionPreinspectionHistory::className(), ['preinspection_id' => 'id']);
        $query->select('smsType, smsText, smsSendStatus');
        return $query;
    }

    public function getCallerCompany()
    {
        return $this->hasOne(PreinspectionClientCompany::className(), ['id' => 'insurerName']);
    }
    
    public function getCallerDivision()
    {
        return $this->hasOne(PreinspectionClientDivision::className(), ['id' => 'insurerDivision']);
    }
    
     public function getCallerBranch()
    {
        return $this->hasOne(PreinspectionClientBranch::className(), ['id' => 'insurerBranch']);
    }

    public function getValuatorUser()
    {
        return $this->hasOne(User::className(), ['id' => 'surveyorName']);
    }
    
    public function getCallerFirstName()
    {
        return $this->hasOne(User::className(), ['id' => 'callerName']);
    }

    public function getSurveyorConveyance()
    {
        $query = $this->hasOne(MasterLocation::className(), ['cityId' => 'cityId']);
        $query->andOnCondition(['townId' => $this->townId]);
        return $query;
    }
    
    public function getVType()
    {
        return $this->hasOne(AxionPreinspectionVehicle::className(), ['preinspection_id' => 'id']);
    }
  
    public function getVTypeName() 
    {
        return $this->vType->vType;
    }
    
    public function getUpdatedByName()
    {
        return $this->hasOne(User::className(), ['id' => 'updatedBy']);
    }
    
    public function getState()
    {
        return $this->hasOne(MasterState::className(), ['id' => 'stateId']);
    }
    
    public function getRoUser() 
    {
        return $this->hasOne(User::className(), ['id' => 'userId']);
    }

    public function getCancelReasonsvalue()
    {
        $cancelReasonList= [
                ['id' => '99', 'name' => 'Customer contact number is incorrect'],
                ['id' => '89', 'name' => 'Customer did not co-operate with the field executive'],
                ['id' => '100', 'name' => 'Customer is not interested'],
                ['id' => '87', 'name' => 'Customer is not picking the phone/ phone is switched off & informed to the concerned insurer regarding the same'],
                ['id' => '98', 'name' => 'Customer refused to pay the PI and (or) conveyance fees'],
                ['id' => '94', 'name' => 'Customer was unable to confirm the location of the vehicle'],
                ['id' => '96', 'name' => 'Dummy/ testing lead'],
                ['id' => '97', 'name' => 'Inspection already done by other PI agency'],
                ['id' => '95', 'name' => 'Insurer asked to cancel the case'],
                ['id' => '101', 'name' => 'Location not in scope'],
                ['id' => '93', 'name' => 'New reference number generated for this lead'],
                ['id' => '88', 'name' => 'Repeat request'],
                ['id' => '102', 'name' => 'Vehicle not available'],
                ['id' => '90', 'name' => 'Vehicle/ customer is out of station'],
                ['id' => '92', 'name' => 'Wrong lead generated by the field executive'],
              ];
        $cancelReasonArray = ArrayHelper::map($cancelReasonList, 'id', 'name');
        return $cancelReasonArray;
    }

    public function getFollowupValue()
    {
        $followupReasonList= [
                ['id' => '0', 'name' => '-Select-'],
                ['id' => '1', 'name' => 'CALLER AND CUSTOMER NOT PICK THE CALL'],
                ['id' => '2', 'name' => 'CUSTOMER NOT PICK THE CALL'],
                ['id' => '3', 'name' => 'CUSTOMER DISCONNECT THE CALL'],
                ['id' => '4', 'name' => 'CUSTOMER NUMBER SWITCH OF / NOT REACHABLE'],
                ['id' => '5', 'name' => 'CUSTOMER OUT OF STATION'],
                ['id' => '6', 'name' => 'CUSTOMER NOT CO - OPERATE'],
                ['id' => '7', 'name' => 'CUSTOMER NOT INTERESTED'],
                ['id' => '8', 'name' => 'CUSTOMER NOT AVAILABLE'],
                ['id' => '9', 'name' => 'CUSTOMER NUMBER WRONG'],
                ['id' => '10', 'name' => 'CUSTOMER WILL CALL BACK'],
                ['id' => '11', 'name' => 'INSPECTION ALREADY DONE BY ANOTHER AGENCY'],
                ['id' => '12', 'name' => 'VEHICLE NOT AVAILABLE'],
                ['id' => '13', 'name' => 'NOT SERVICING AREA'],
                ['id' => '14', 'name' => 'CUSTOMER REFUSE FOR INSPECTION CHARGES'],
              ];
        $followupReasonArray = ArrayHelper::map($followupReasonList, 'id', 'name');
        return $followupReasonArray;
    }

    public function getInspectionTypevalue()
    {
        $inspectionTypeList= [
            ['id' => '', 'name' => '-Select-'],
            ['id' => 'Break In', 'name' => 'Break In'],
            ['id' => 'Name Transfer', 'name' => 'Name Transfer'],
            ['id' => 'Add On Cover', 'name' => 'Add On Cover'],
            ['id' => 'Endorsement', 'name' => 'Endorsement'],
            ['id' => 'TP To Comprehensive', 'name' => 'TP To Comprehensive'],
            ['id' => 'Cheque Bounce', 'name' => 'Cheque Bounce'],
            ['id' => 'CNG/LPG Kit Inclusion', 'name' => 'CNG/LPG Kit Inclusion'],
            ['id' => 'Add On Inclusion', 'name' => 'Add On Inclusion'],
            ['id' => 'Trailer Inclusion', 'name' => 'Trailer Inclusion'],
            ['id' => 'Accessories Inclusion', 'name' => 'Accessories Inclusion']
        ];
        $inspectionTypeArray = ArrayHelper::map($inspectionTypeList, 'id', 'name');
        return $inspectionTypeArray;
    }

    public function getPaymentValue()
    {
        $paymentList= [
                ['id' => '', 'name' => '-No Payment Mode-'],
                ['id' => '1', 'name' => 'Company Billing'],
                ['id' => '2', 'name' => 'Fee and Conv. From Client'],
                ['id' => '3', 'name' => 'Company Billing and Conv. From Client'],
              ];
        $paymentArray = ArrayHelper::map($paymentList, 'id', 'name');
        return $paymentArray;
    }
    
    
   
     public function getUploadValue()
    {
        $uploadList= [
                ['id' => '0', 'name' => 'None'],
                ['id' => 'Mobile App', 'name' => 'Mobile App'],
                ['id' => 'File Upload', 'name' => 'File Upload'],
                
              ];
        $uploadArray = ArrayHelper::map($uploadList, 'id', 'name');
        return $uploadArray;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'referenceNo' => 'Ref No.',
            'insurerName' => 'Insurer Name',
            'insurerDivision' => 'Insurer Division',
            'insurerBranch' => 'Insurer Branch',
            'intimationDate' => 'Intimation Date',
            'callerName' => 'Caller Name*',
            'callerMobileNo' => 'Caller Mobile No',
            'callerDetails' => 'Caller Email',
            'insuredName' => 'Insured Name',
            'insuredMobile' => 'Insured Mobile',
            'induredEmail' => 'Insured Email',
            'insuredMobileAlt' => 'Alternate Insured Mobile',
            'contactPersonMobileNo' => 'ULN*',
            'insuredAddress' => 'Insured Address',
            'registrationNo' => 'Vehicle No*',
            'engineNo' => 'Engine No',
            'chassisNo' => 'Chassis No',
            'vehicleType' => 'Vehicle*',
            'vehicleTypeRadio' => 'Type*',
            'manufacturer' => 'Manufacturer',
            'model' => 'Model',
            'manufacturingYear' => 'Manufacturing Year',
            'intimationRemarks' => 'OD Premium',
            'stateId'=>'State',
            'cityId' => 'City',
            'townId' => 'Town',
            'extraKM' => 'Extra Km*',
            'surveyLocation' => 'Survey From Location',
            'surveyLocation2' => 'Survey To Location',
            'surveyorName' => 'Surveyor Name*',
            'sendLink' => 'Send Link',
            'surveyorAppointDateTime' => 'Surveyor Appoint Time',
            'rescheduleReason' => 'Reason For Re-Schedule',
            'rescheduleDateTime' => 'Re-Scheduled Date Time',
            'rescheduleReason1' => 'Reason For Re-Schedule',
            'rescheduleDateTime1' => 'Re-Scheduled Date Time',
            'inspectionType' => 'Inspection Type',
            'paymentMode' => 'Payment Mode*',
            'status' => 'Status*',
            'customerAppointDateTime' => 'Customer Appoint Time',
            'sbuCode' => 'SBU Code',
            'remarks' => 'Remarks*',
            'cancellationReason' => 'Reason of Cancellation',
            'cashCollection' => 'Cash to be Collected',
            'completedSurveyDateTime' => 'Completed Survey Time*',
            'userId' => 'User ID',
            'followupReason' => 'Remarks',
            'followupRemainder' => 'Next Remainder',
            'followupUpdatedDateTime' => 'Remainder Updated Time',
            'followupUpdatedBy' => 'Updated By',
            'ro' => 'RO',
            'uploadSource' => 'Upload Source',
            'vType_id' => 'Vehicle',
            'vTypeName' => 'Vehicle',
            'uploadPath' => '',
            'taigRequestStatus' => '',
            'taigStatusCode' => '',
            'ErrorDesc' => 'File Upload Status', 
            'conveyanceApproval' => 'Conveyance Approval Required*',
            'conveyanceApprovalImg' => 'Conveyance Approval Image*',
            'created_on' => 'Created On',
            'updatedBy' => 'Final Updation RO Name',
            'createMethod' => 'Create Method',
            'qcDoneOn' => 'QC Done On',
            'regionName' => 'Insured RegionName',
            'vType' => 'Vehicle Type',
            'oreder_id' => 'OrderId',
            'pay_status' => 'Payment Status',
            'total_score' => 'Vehicle Damage Total Score'
        ];
    }
     public function getStateByCity($cityId){
        $query ="SELECT state FROM users INNER JOIN state_master sm on sm.id = users.stateId WHERE cityId=$cityId and stateId is not null LIMIT 1";
        $result = Yii::$app->db->createCommand($query)->queryOne();
        return $result && isset($result['state']) ? $result['state'] : '';
    }

    public function getStateByUser($userId){
        $query ="SELECT state FROM users INNER JOIN state_master sm on sm.id = users.stateId WHERE users.id=$userId and stateId is not null LIMIT 1";
        $result = Yii::$app->db->createCommand($query)->queryOne();
        return $result && isset($result['state']) ? $result['state'] : '';
    }

    public function getBill() 
    {
        return $this->hasOne(AxionPreinspectionBilling::className(), ['id' => 'billId']);
    }
}
