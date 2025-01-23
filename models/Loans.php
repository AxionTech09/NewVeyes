<?php

namespace app\models;

use Yii;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use app\models\User;
use app\models\LoanBanks;



/**
 * This is the model class for table "loans".
 *
 * @property int $id
 * @property int $userId
 * @property string $firstname
 * @property string $lastname
 * @property string $email
 * @property string $telephone
 * @property string $mobile
 * @property string $address
 * @property int $city
 * @property int $state
 * @property int $pincode
 * @property string $dob
 * @property string $vehicleRegNo
 * @property int $loanAppliedAmount
 * @property string $panNumber
 * @property string $aadharNumber
 * @property int $creditScore
 * @property string $employmentType
 * @property string $loanType
 * @property string $sourceType
 * @property int $sourceId
 * @property int $sanctionedBank
 * @property int $status
 * @property string $createdOn
 * @property string $lastUpdatedOn
 */
class Loans extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'loans';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['firstname','lastname', 'mobile', 'address','dob','loanAppliedAmount'], 'required'],
            [['city', 'state', 'pincode', 'loanAppliedAmount', 'creditScore', 'sourceId','userId'], 'integer'],
            [['dob', 'createdOn','lastUpdatedOn','status'], 'safe'],
            [[ 'email'], 'email','message'=>'The email isn`t correct'],
            [['firstname', 'lastname'], 'string', 'max' => 150],
            [['telephone'], 'string', 'max' => 50],
            [['mobile'], 'string', 'max' => 30],
            [['address', 'employmentType', 'loanType','sourceType','vehicleRegNo'], 'string', 'max' => 100],
            [['panNumber','aadharNumber'], 'string', 'max' => 15],
        ];
    }


 public function getstatusValue()
    {
        $statusList= [
                ['id' => '0', 'name' => '-No Payment Mode-'],
                ['id' => 'New', 'name' => 'New'],
                ['id' => 'INprogress', 'name' => 'IN progress'],
                ['id' => 'ONhold', 'name' => 'ON Hold'],
                ['id' => 'Approved', 'name' => 'Approved'],
                ['id' => 'Disbursed', 'name' => 'Disbursed'],
                ['id' => 'Rejected', 'name' => 'Rejected'],
              ];
        $statusArray = ArrayHelper::map($statusList, 'id', 'name');
        return $statusArray;
    }





    public function getLtypeValue()
    {
        $ltypeList= [
                ['id' => '0', 'name' => '-No Payment Mode-'],
                ['id' => 'NewCarLoan', 'name' => 'New Car Loan'],
                ['id' => 'UsedCarLoan', 'name' => 'Used Car Loan'],
                ['id' => 'CommercialVehicleLoan', 'name' => 'Commercial Vehicle Loan'],
                ['id' => 'ConstructionEquipmentLoan', 'name' => 'Construction Equipment Loan'],
                
              ];
        $ltypeArray = ArrayHelper::map($ltypeList, 'id', 'name');
        return $ltypeArray;
    }
    

  

     public function getEtypeValue()
    {
        $etypeList= [
                ['id' => '0', 'name' => '-No Payment Mode-'],
                ['id' => 'Salaried', 'name' => 'Salaried'],
                ['id' => 'Professional', 'name' => 'Professional'],
                ['id' => 'Business', 'name' => 'Business'],
                ['id' => 'Retired', 'name' => 'Retired'],
                
              ];
        $etypeArray = ArrayHelper::map($etypeList, 'id', 'name');
        return $etypeArray;
    }
    
    
    
     public function getLoanStateValue()
    {
        $lstateList= [
                ['id' => '0', 'name' => '-Select-'],
                ['id' => '1', 'name' => 'Thiruvallur'],
                ['id' => '2', 'name' => 'Vellore'],
                ['id' => '3', 'name' => 'Kanchipuram'],
                ['id' => '4', 'name' => 'Thiruvannamalai'],
                ['id' => '5', 'name' => 'Krishnagri'],
                ['id' => '6', 'name' => 'Dharmapuri'],
                ['id' => '7', 'name' => 'Salem'],
                ['id' => '8', 'name' => 'Villupuram'],
                ['id' => '9', 'name' => 'Cuddalore'],
                ['id' => '10', 'name' => 'Erode'],
                ['id' => '11', 'name' => 'Namakkal'],
                ['id' => '12', 'name' => 'Perambalur'],
                ['id' => '13', 'name' => 'Ariyalur'],
                ['id' => '14', 'name' => 'Tiruchirappali'],
                ['id' => '15', 'name' => 'Thanjavur'],
                ['id' => '16', 'name' => 'Nagapattinam'],
                ['id' => '17', 'name' => 'Thiruvarur'],
                ['id' => '18', 'name' => 'Karur'],
                ['id' => '19', 'name' => 'Tiruppur'],
                ['id' => '20', 'name' => 'Coimbatore'],
                ['id' => '21', 'name' => 'Madurai'],
                ['id' => '22', 'name' => 'Theni'],
                ['id' => '23', 'name' => 'Sivagangai'],
                ['id' => '24', 'name' => 'Virudhunagar'],
                ['id' => '25', 'name' => 'Ramanathapuram'],
                ['id' => '26', 'name' => 'Thoothukudi'],
                ['id' => '27', 'name' => 'Thirunelveli'],
                ['id' => '28', 'name' => 'Kanyakumari'],
                ['id' => '29', 'name' => 'Chennai'],
              ];
        $lstateArray = ArrayHelper::map($lstateList, 'id', 'name');
        return $lstateArray;
    }

    
    
    
        public function getCarDealers() 
        {
            
           return $this->hasOne(User::className(), ['id' => 'sourceId']);
            
        }


         public function getStatus() 
        {
            
          return $this->hasOne(LoanBanks::className(), ['id' => 'bankStatusId']);
        
        }



    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Ref No',
            'userId' => 'User',
            'firstname' => 'Firstname *',
            'lastname' => 'Lastname *',
            'email' => 'Email *',
            'telephone' => 'Telephone',
            'mobile' => 'Mobile *',
            'address' => 'Address *',
            'city' => 'City',
            'state' => 'State',
            'pincode' => 'Pincode',
            'dob' => 'Date Of Birth *',
            'vehicleRegNo' => 'Vehicle Registration No. *',
            'loanAppliedAmount' => 'Loan Applied Amount *',
            'panNumber' => 'PAN Number *',
            'aadharNumber' => 'AADHAR Number',
            'creditScore' => 'Credit Score',
            'employmentType' => 'Employment Type',
            'loanType' => 'Loan Type *',
            'sourceType' => 'Customer Type',
            'sourceId' => 'Associate Dealer Name',
            'status' => 'Status',
            'createdOn' => 'Created On',
            'lastUpdatedOn' => 'Last Updated On',
        ];
    }
}
