<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "master_fieldexecutives".
 *
 * @property integer $id
 * @property string $name
 * @property string $valuationUserId
 * @property string $piUserId
 * @property string $address
 * @property string $dob
 * @property string $email
 * @property string $mobile
 * @property string $nominee
 * @property string $spouseName
 * @property string $mobile2
 * @property integer $cityId
 * @property integer $basicSalary
 * @property integer $caseRate
 * @property integer $loans
 * @property integer $repaymentInstalment
 * @property string $bankName
 * @property string $accNumber
 * @property string $ifsc
 * @property string $branchName
 * @property string $created_on
 */
class MasterFieldexecutives extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'master_fieldexecutives';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'cityId'], 'required'],
            [['dob', 'created_on'], 'safe'],
            [['cityId', 'basicSalary', 'caseRate', 'loans', 'repaymentInstalment'], 'integer'],
            [['name', 'valuationUserId', 'piUserId', 'email', 'nominee', 'spouseName', 'bankName', 'branchName'], 'string', 'max' => 100],
            [['address'], 'string', 'max' => 255],
            [['mobile', 'mobile2'], 'string', 'max' => 12],
            [['accNumber', 'ifsc'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'valuationUserId' => 'Valuation User ID',
            'piUserId' => 'PI User ID',
            'address' => 'Address',
            'dob' => 'Date Of Birth',
            'email' => 'Email ID',
            'mobile' => 'Phone Number',
            'nominee' => 'Nominee',
            'spouseName' => 'Spouse Name',
            'mobile2' => 'Alternate Contact Number',
            'cityId' => 'Base Location',
            'townId' => 'Survey Location',
            'basicSalary' => 'Basic Salary',
            'caseRate' => 'Rate Per Case',
            'loans' => 'Loans/Advance',
            'repaymentInstalment' => 'Repayment number of Instalment',
            'bankName' => 'Bank Name',
            'accNumber' => 'Account Number',
            'ifsc' => 'IFSC Code',
            'branchName' => 'Branch Name',
            'created_on' => 'Branch Name',
        ];
    }
    
    public function getLocationCity()
    {
        return $this->hasOne(MasterCity::className(), ['id' => 'cityId']);
    }
    
    public function getLocationTown()
    {
        return $this->hasOne(MasterTown::className(), ['id' => 'townId']);
    }
    
   
}
