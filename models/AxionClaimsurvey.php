<?php

namespace app\models;
use yii\helpers\ArrayHelper;


use Yii;

/**
 * This is the model class for table "axion_claimsurvey".
 * @property integer $id
 * @property integer $referenceNo
 * @property integer $insurerName
 * @property string $insurerDivision
 * @property string $insurerBranch
 * @property string $intimationDate
 * @property integer $callerName
 * @property string $callerMobileNo
 * @property string $callerDetails
 * @property string $insuredName
 * @property string $insuredMobile
 * @property string $contactPersonMobileNo
 * @property string $insuredAddress
 * @property string $claimVehicle
 * @property string $registrationNo
 * @property string $engineNo
 * @property string $chassisNo
 * @property string $vehicleType
 * @property string $vehicleTypeRadio
 * @property integer $makeId
 * @property integer $modelId
 * @property integer $variantId
 * @property integer $manufacturingYear
 * @property string $intimationRemarks
 * @property string $cityId
 * @property string $townId
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
 * @property integer $followupReason
 * @property string $followupRemainder
 * @property string $followupUpdatedDateTime
 * @property string $followupUpdatedBy
 * @property string $ro
 * @property string $uploadSource
 * @property string $policyNo
 * @property string $policyEndPeriod
 * @property string $policyStartPeriod
 * @property string $claimNumber
 * @property string $preAccidentCondition
 * @property string $finance
 * @property string $registrationDate
 * @property string $typeOfBody
 * @property string $speedometerReading
 * @property string $passangerCarryCapacity
 * @property string $registeredLadenWeight
 * @property string $unladenWeight
 * @property string $taxValidUpto
 * @property string $taxType
 * @property string $fitnessCertificateValidUpto
 * @property string $permitNoValidUpto
 * @property string $permitType
 * @property string $routeAreaOperation
 * @property string $workshopName
 * @property string $shopNumber
 * @property string $created_on
 */
class AxionClaimsurvey extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'axion_claimsurvey';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = [

            [['referenceNo', 'manufacturingYear', 'extraKM', 'surveyorName', 'status', 'paymentMode', 'cancellationReason', 'userId', 'followupReason','insurerName','callerName','makeId','modelId','variantId'], 'integer'],
            [['intimationDate', 'surveyorAppointDateTime', 'rescheduleDateTime', 'rescheduleDateTime1', 'customerAppointDateTime', 'completedSurveyDateTime', 'followupRemainder', 'followupUpdatedDateTime', 'created_on','uploadSource','vehicleTypeRadio', 'policyStartPeriod','policyEndPeriod', 'registrationDate', 'fitnessCertificateValidUpto','claimNumber','policyNo'], 'safe'],
            [['callerDetails', 'insuredName', 'followupUpdatedBy', 'contactPersonMobileNo','cityId', 'townId', 'insurerDivision', 'insurerBranch','workshopName'], 'string', 'max' => 100],
            [['callerMobileNo', 'insuredMobile','shopNumber'], 'string', 'max' => 12],
            [['insuredAddress', 'intimationRemarks', 'surveyLocation', 'rescheduleReason', 'rescheduleReason1', 'remarks', 'ro', 'speedometerReading', 'passangerCarryCapacity', 'taxValidUpto', 'permitNoValidUpto', 'permitType', 'routeAreaOperation','finance','preAccidentCondition','typeOfBody', 'registeredLadenWeight', 'unladenWeight','taxType'], 'string', 'max' => 255],
            [['registrationNo', 'engineNo', 'chassisNo','claimVehicle'], 'string', 'max' => 50],
            ['callerDetails', 'email'],
            [['vehicleType'], 'string', 'max' => 30], 
            [['sendLink'], 'string', 'max' => 3],
            [['inspectionType'], 'string', 'max' => 50],
            [['cashCollection'], 'string', 'max' => 15],
            // [['callerName'], 'required'],
            [['completedSurveyDateTime','registrationNo','engineNo','chassisNo'], 'required', 'on' => 'fourwheelerqc'],
            ['completedSurveyDateTime','intimationDateCheck']
        ];
        
        if(strpos( Yii::$app->request->absoluteUrl, 'taig') !== false) {
        $rules_ULN = [
            [['contactPersonMobileNo'], 'required', 'message' => 'ULN is required'],
            [['contactPersonMobileNo'], 'unique', 'message' => 'ULN already exists' ],
            [['contactPersonMobileNo'], 'string', 'min' => '6', 'tooShort' => 'ULN should contain at most 6 characters.'],
        ];
        
        $rules = ArrayHelper::merge($rules, $rules_ULN);
        }
        
        return $rules;
    }   
    
    public function intimationDateCheck()
    {
        $model = AxionClaimsurvey::findOne($this->id);
        $date1 =  $model->intimationDate;
        $date2 = $this->completedSurveyDateTime;
       
        if(strtotime($date2) < strtotime($date1))
        {
             $this->addError('completedSurveyDateTime', 'Completed time before intimation time.');
        }
       
           
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

         public function getPricemake()
    {
        return $this->hasOne(VehicleMake::className(), ['id' => 'makeId']);
    }
    
    public function getPricemodel()
    {
        return $this->hasOne(VehicleModel::className(), ['id' => 'modelId']);
    }

     public function getPricevariant()
    {
        return $this->hasOne(VehicleVariant::className(), ['id' => 'variantId']);
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
              ];
        $inspectionTypeArray = ArrayHelper::map($inspectionTypeList, 'id', 'name');
        return $inspectionTypeArray;
    }

    public function getPaymentValue()
    {
        $paymentList= [
                ['id' => '0', 'name' => '-No Payment Mode-'],
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


        public function getTaxValue()
    {
        $taxList= [
                ['id' => '0', 'name' => 'None'],
                ['id' => 'Life Time Tax Paid', 'name' => 'Life Time Tax Paid'],
              
              ];
        $taxArray = ArrayHelper::map($taxList, 'id', 'name');
        return $taxArray;
    } 
    

        public function getBodyTypevalue()
    {
        $bodyTypeList= [
                ['id' => '', 'name' => '-Select-'],
                ['id' => 'Hatchback', 'name' => 'Hatchback'],
                ['id' => 'Sedan', 'name' => 'Sedan'],
                ['id' => 'MUV/SUV', 'name' => 'MUV/SUV'],
                ['id' => 'Coupe', 'name' => 'Coupe'],
                ['id' => 'Convertible', 'name' => 'Convertible'],
                ['id' => 'Wagon', 'name' => 'Wagon'],
                ['id' => 'Van', 'name' => 'Van'],
                ['id' => 'Jeep', 'name' => 'Jeep'],
              ];
        $bodyTypeArray = ArrayHelper::map($bodyTypeList, 'id', 'name');
        return $bodyTypeArray;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'referenceNo' => 'Report No.',
            'insurerName' => 'Insurer Name',
            'insurerDivision' => 'Insurer Division/State',
            'insurerBranch' => 'Insurer Branch/City',
            'intimationDate' => 'Report Date',
            'callerName' => 'Caller Name',
            'callerMobileNo' => 'Caller Mobile No',
            'callerDetails' => 'Caller Email',
            'insuredName' => 'Insured Name',
            'insuredMobile' => 'Insured Mobile',
            'contactPersonMobileNo' => 'Insured Email',
            'insuredAddress' => 'Insured Address',
            'registrationNo' => 'Registration No',
            'engineNo' => 'Engine No',
            'chassisNo' => 'Chassis No',
            'claimVehicle' => 'Vehicle',
            'vehicleType' => 'Vehicle',
            'vehicleTypeRadio' => 'Type',
            'makeId' => 'Make',
            'modelId' => 'Model',
            'variantId' => 'Variant',
            'manufacturingYear' => 'Manufacturing Year',
            'intimationRemarks' => 'OD Premium',
            'cityId' => 'City',
            'townId' => 'Town',
            'extraKM' => 'Extra Km',
            'surveyLocation' => 'Survey Location',
            'surveyorName' => 'Surveyor Name',
            'sendLink' => 'Send Link',
            'surveyorAppointDateTime' => 'Surveyor Appoint Time',
            'rescheduleReason' => 'Reason For Re-Schedule',
            'rescheduleDateTime' => 'Re-Scheduled Date Time',
            'rescheduleReason1' => 'Reason For Re-Schedule',
            'rescheduleDateTime1' => 'Re-Scheduled Date Time',
            'inspectionType' => 'Inspection Type',
            'paymentMode' => 'Payment Mode',
            'status' => 'Status',
            'customerAppointDateTime' => 'Appointment Time',
            'remarks' => 'Remarks',
            'cancellationReason' => 'Reason of Cancellation',
            'cashCollection' => 'Cash to be Collected',
            'completedSurveyDateTime' => 'Completed Survey Time',
            'userId' => 'User ID',
            'followupReason' => 'Remarks',
            'followupRemainder' => 'Next Remainder',
            'followupUpdatedDateTime' => 'Remainder Updated Time',
            'followupUpdatedBy' => 'Updated By',
            'ro' => 'RO',
            'uploadSource' => 'Upload Source',
             'policyNo' => 'Policy No',
            'policyStatPeriod' => 'Policy Start Period',
            'policyEndPeriod' => 'Policy End Period',
            'claimNumber' => 'Claim Number',
             'preAccidentCondition' => 'Pre-Accident Condition',
            'finance' => 'Hypothecation',
             'registrationDate' => 'Registration Date',
             'typeOfBody' => 'Type Of Body',
            'speedometerReading' => 'Speedometer Reading',
            'passangerCarryCapacity' => 'Pass.Carry Capacity',
            'registeredLadenWeight' => 'Regd. Laden weight',
            'unladenWeight' => 'Unladen Weight',
            'taxValidUpto' => 'Tax Valid Upto',
            'taxType' => 'Tax Type',
            'fitnessCertificateValidUpto' => 'Fitness Certificate Upto',
            'permitNoValidUpto' => 'Permit Type Upto',
            'permitType' => 'Permit No',
            'routeAreaOperation' => 'Route / Area Operation',
            'workshopName' => 'Field officer / workshop man',
            'shopNumber' => 'Mobile Number',
            'created_on' => 'Created On',
        ];
    }
}
