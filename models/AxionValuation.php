<?php

namespace app\models;
use yii\helpers\ArrayHelper;

use Yii;

/**
 * This is the model class for table "axion_valuation".
 * @property integer $id
 * @property integer $referenceNo
 * @property integer $insurerName
 * @property integer $insurerDivision
 * @property integer $insurerBranch
 * @property string $intimationDate
 * @property integer $callerName
 * @property string $callerMobileNo
 * @property string $callerDetails
 * @property string $customerName
 * @property string $customerMobile
 * @property string $contactPersonMobileNo
 * @property string $customerAddress
 * @property string $registrationNo
 * @property string $registrationYear
 * @property string $engineNo
 * @property string $chassisNo
 * @property string $vehicleType
 * @property string $vehicleTypeRadio
 * @property integer $makeId
 * @property integer $modelId
 * @property integer $variantId
 * @property string $month
 * @property string $state
 * @property integer $syd1to5
 * @property integer $syd6to8
 * @property integer $manufacturingYear
 * @property integer $exShowroomPrice
 * @property integer $currentMarketPrice
 * @property integer $age
 * @property integer $calculation
 * @property string $intimationRemarks
 * @property integer $cityId
 * @property integer $townId
 * @property integer $extraKm
 * @property string $vehicleLocation
 * @property integer $surveyorName
 * @property string $cashCollectedAmount
 * @property string $cashToBeCollected
 * @property string $rescheduleReason
 * @property string $rescheduleDateTime
 * @property string $rescheduleReason1
 * @property string $rescheduleDateTime1
 * @property integer $cashStatus
 * @property string $yardName
 * @property string $recordType
 * @property string $status
 * @property string $customerAppointDateTime
 * @property string $remarks
 * @property integer $cancellationReason
 * @property string $actualCashCollected
 * @property string $completedSurveyDateTime
 * @property integer $userId
 * @property integer $followupReason
 * @property string $followupRemainder
 * @property string $followupUpdatedDateTime
 * @property string $followupUpdatedBy
 * @property string $ro
 * @property string $created_on
 * @property integer $systemGeneratedMarketValue
 * @property integer $fixedMarketValue
 * @property integer $currentDepric
 * @property integer $depriAmount
 * @property integer $finalDepri
 * @property string $ratingAge
 */

class AxionValuation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */

    public static function tableName()
    {
        return 'axion_valuation';
    }

    /** * @inheritdoc */ public function rules()
     { $rules = [ 
        [['referenceNo','manufacturingYear', 'cityId', 'townId', 'extraKm', 'surveyorName', 
          'cashStatus', 'cancellationReason', 'userId', 'followupReason','insurerName',
          'insurerDivision', 'insurerBranch','callerName','status','syd1to5',
          'currentMarketPrice','age','systemGeneratedMarketValue','depriAmount','finalDepri',
          'fixedMarketValue','makeId','modelId','variantId'],'integer'],
 
        [['intimationDate', 'cashToBeCollected', 'rescheduleDateTime','rescheduleDateTime1', 
          'customerAppointDateTime', 'completedSurveyDateTime','followupRemainder', 
          'followupUpdatedDateTime', 'created_on','calculation','currentDepric','registrationYear','exShowroomPrice'], 'safe'],

        [['callerDetails', 'customerName', 'followupUpdatedBy','contactPersonMobileNo'], 'string', 
        'max' => 100],

        [['callerMobileNo','customerMobile'], 'string', 'max' => 12],
        [['customerAddress','intimationRemarks', 'vehicleLocation', 'rescheduleReason',
            'rescheduleReason1', 'remarks', 'ro'], 'string', 'max' => 255],
        [['registrationNo', 'engineNo', 'chassisNo','month','state','ratingAge'], 'string', 'max' => 50],
        [['callerDetails'] ,'email'], 
        [['vehicleType'], 'string', 'max' => 30], 
        [['vehicleTypeRadio'], 'string', 'max' => 4],
        [['cashCollectedAmount'],'string', 'max' => 3], 
        [[ 'yardName', 'recordType'], 'string', 'max'=> 50], 
        [['actualCashCollected'], 'string', 'max' => 15],
        [['makeId','manufacturingYear','month'], 'required'],
        ['completedSurveyDateTime', 'required', 'on' => 'fourwheelerqc'],
        ['completedSurveyDateTime', 'required', 'on' => 'commercialqc'],
        ['completedSurveyDateTime','intimationDateCheck'] ];
        
        if(strpos( Yii::$app->request->absoluteUrl, 'test') !== false) {
        $rules_ULN = [
            [['contactPersonMobileNo'], 'required', 'message' => 'ULN is required']
        ];
        
        $rules = ArrayHelper::merge($rules, $rules_ULN);
        }
        
        return $rules;
    }
    
    public function intimationDateCheck()
    {
        $model = AxionValuation::findOne($this->id);
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

    
    public function getSurveyorConveyance()
    {
        $query = $this->hasOne(MasterLocation::className(), ['cityId' => 'cityId']);
        $query->andOnCondition(['townId' => $this->townId]);
        return $query;
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



    public function getMonthValue()
    {
        $monthList = [
            ['id' => '', 'name' => '-Select-'],
           ['id' => '1', 'name' => 'January'],
           ['id' => '2', 'name' => 'February'],
           ['id' => '3', 'name' => 'March'],
           ['id' => '4', 'name' => 'April'],
           ['id' => '5', 'name' => 'May'],
           ['id' => '6', 'name' => 'June'],
           ['id' => '7', 'name' => 'July'],
           ['id' => '8', 'name' => 'August'],
           ['id' => '9', 'name' => 'September'],
           ['id' => '10', 'name' => 'October'],
           ['id' => '11', 'name' => 'November'],
           ['id' => '12', 'name' => 'December'],
        ];
        $monthArray = ArrayHelper::map($monthList,'id','name');
        return $monthArray;
    }


    public function getYearValue()
    {
        $yearList = [
            ['id' => '', 'name' => '-Select-'],
           ['id' => '2009', 'name' => '2009'],
           ['id' => '2010', 'name' => '2010'],
           ['id' => '2011', 'name' => '2011'],
           ['id' => '2012', 'name' => '2012'],
           ['id' => '2013', 'name' => '2013'],
           ['id' => '2014', 'name' => '2014'],
           ['id' => '2015', 'name' => '2015'],
           ['id' => '2016', 'name' => '2016'],
           ['id' => '2017', 'name' => '2017'],
           ['id' => '2018', 'name' => '2018'],
           ['id' => '2019', 'name' => '2019'],
           
        ];
        $yearArray = ArrayHelper::map($yearList,'id','name');
        return $yearArray;
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
        $variantList= [
                ['id' => '', 'name' => '-Select-'],
                ['id' => 'Break In', 'name' => 'Break In'],
                ['id' => 'Name Transfer', 'name' => 'Name Transfer'],
                ['id' => 'Add On Cover', 'name' => 'Add On Cover'],
                ['id' => 'Endorsement', 'name' => 'Endorsement'],
              ];
        $variantArray = ArrayHelper::map($variantList, 'id', 'name');
        return $variantArray;
    }

    public function getPaymentValue()
    {
        $paymentList= [
                ['id' => '0', 'name' => '-Payment Status-'],
                ['id' => '1', 'name' => 'With Surveyor'],
                ['id' => '2', 'name' => 'Deposited In Bank'],
                ['id' => '3', 'name' => 'Adjusted In Salary'],
                ['id' => '4', 'name' => 'Pending'],
              ];
        $paymentArray = ArrayHelper::map($paymentList, 'id', 'name');
        return $paymentArray;
    }


public function getWeightageValue()
       {
    $weightageList =[
       ['id' => '0.25', 'name' => '-1'], //bad
       ['id' => '1.5' , 'name' => '1'],  //average
       ['id' => '0.15', 'name' => '2'],  //good
       ['id' => '0.1', 'name' => '2'],   //good
    ];
    $weightageArray = ArrayHelper::map($weightageList,'id','name');
    return $weightageArray;
    }



 
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'referenceNo' => 'Ref No.',
            'insurerName' => 'Client Name',
            'insurerDivision' => 'Division',
            'insurerBranch' => 'Insurer Branch',
            'intimationDate' => 'Request Date Time',
            'callerName' => 'Executive Name',
            'callerMobileNo' => 'Executive Mobile No',
            'callerDetails' => 'Executive Email',
            'customerName' => 'Customer Name',
            'CustomerMobile' => 'Customer Mobile',
            'contactPersonMobileNo' => 'Customer Email',
            'customerAddress' => 'Customer Address',
            'registrationNo' => 'Registration No',
            'registrationYear' => 'Registration Year',
            'engineNo' => 'Engine No',
            'chassisNo' => 'Chassis No',
            'vehicleType' => 'Vehicle',
            'vehicleTypeRadio' => 'Type',
            'makeId' => 'Make',
            'modelId' => 'Model',
            'manufacturingYear' => 'Manufacturing Year',
            'exShowroomPrice' => 'Ex ShowRoom Price',
            'currentMarketPrice' => 'Current Market Price',
            'state' => 'State',
            'syd1to5' => 'SYD1to5',
            'syd6to8' => 'SYD6to8',
            'age' => 'AGE',
            'calculation' => 'Calculation',
            'intimationRemarks' => 'OD Premium',
            'cityId' => 'City',
            'townId' => 'Town',
            'extraKm' => 'Extra Km',
            'vehicleLocation' => 'Vehicle Location',
            'surveyorName' => 'Surveyor Name/Customer',
            'cashCollectedAmount' => 'CashCollectedAmount',
            'cashToBeCollected' => 'Cash To Be Collected',
            'rescheduleReason' => 'Reason For Re-Schedule',
            'rescheduleDateTime' => 'Re-Scheduled Date Time',
            'rescheduleReason1' => 'Reason For Re-Schedule',
            'rescheduleDateTime1' => 'Re-Scheduled Date Time',
            'variantId' => 'Variant',
            'cashStatus' => 'Cash Status',
            'yardName' => 'Yard Name',
            'recordType' => 'Record Type',
            'status' => 'Status',
            'customerAppointDateTime' => 'Customer Appoint Time',
            'remarks' => 'Remarks',
            'cancellationReason' => 'Reason of Cancellation',
            'actualCashCollected' => 'Actual Cash Collected',
            'completedSurveyDateTime' => 'Completed Survey Time',
            'userId' => 'User ID',
            'followupReason' => 'Remarks',
            'followupRemainder' => 'Next Remainder',
            'followupUpdatedDateTime' => 'Remainder Updated Time',
            'followupUpdatedBy' => 'Updated By',
            'ro' => 'RO',
            'created_on' => 'Created On',
            'fixedMarketValue' => 'Final Market Value',

        ];
    }
}
