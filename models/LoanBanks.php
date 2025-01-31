<?php

namespace app\models;
use yii\helpers\ArrayHelper;

use Yii;

/**
 * This is the model class for table "loan_bank".
 *
 * @property int $id
 * @property int $loanId
 * @property int $bankId
 * @property int $bankAmount
 * @property string $loanTenure
 * @property int $rateOfIntrest
 * @property int $emi
 * @property string $bankStatus
 * @property string $selected
 * @property string $createdOn
 * @property string $lastUpdatedOn
 */
class LoanBanks extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'loan_banks';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['loanId', 'bankId', 'lastUpdatedOn'], 'required'],
            [['loanId', 'bankId', 'bankAmount','rateOfIntrest','emi'], 'integer'],
            [['createdOn', 'lastUpdatedOn','selected'], 'safe'],
            [['bankStatus','loanTenure'], 'string', 'max' => 100],
        ];
    }

        public function getBankdata() 
        {
            
           return $this->hasOne(MasterBanks::className(), ['id' => 'bankId']);
            
        }


 public function getbankStatusValue()
    {
        $bankStatusList= [
                ['id' => '0', 'name' => '-No Payment Mode-'],
                ['id' => 'New', 'name' => 'New'],
                ['id' => 'INprogress', 'name' => 'IN progress'],
                ['id' => 'ONhold', 'name' => 'ON Hold'],
                ['id' => 'Approved', 'name' => 'Approved'],
                ['id' => 'Disbursed', 'name' => 'Disbursed'],
                ['id' => 'Rejected', 'name' => 'Rejected'],
              ];
        $bankStatusArray = ArrayHelper::map($bankStatusList, 'id', 'name');
        return $bankStatusArray;
    }
    

// SELECT bankName FROM master_banks INNER JOIN loan_banks ON master_banks.id = loan_banks.bankId

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'loanId' => 'Loan ID',
            'bankId' => 'Bank ID',
            'bankAmount' => 'Bank Amount',
            'loanTenure' => 'Loan Tenure',
            'rateOfIntrest' => 'Intrest',
            'emi' => 'EMI',
            'bankStatus' => 'Bank Status',
            'selected' => '',
            'createdOn' => 'Created On',
            'lastUpdatedOn' => 'Last Updated On',
        ];
    }
}
