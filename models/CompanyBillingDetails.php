<?php
namespace app\models;

use Yii;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\base\Security;
use yii\web\IdentityInterface;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "logs".
 *
 * @property integer $id
 * @property integer $leadNumber
 * @property string $message
 * @property string $createdOn
 */
class CompanyBillingDetails extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'company_billing_details';
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['companyId'],'required',],
            [['createdOn'], 'safe'],
            [['id','companyId','stateId','branchId', 'billingState'], 'integer'],
            [['address','gstNo'], 'string'],
            [['rate2Wheeler','rate3Wheeler','rate4Wheeler','rateCommercial','rateConveyance','igst','sgst','cgst'],'double']
   
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'companyId' => 'Company',
            'stateId' => 'State',
            'branchId' => 'Branch',
            'address' => 'Address',
            'rate2Wheeler' => '2 Wheeler Rate',
            'rate3Wheeler' => '3 Wheeler Rate',
            'rate4Wheeler' => '4 Wheeler Rate',
            'rateCommercial' => 'Commercial Rate',
            'rateConveyance' => 'Conveynce Rate',
            'gstNo' => 'GST No.',
            'igst' => 'IGST(%)',
            'sgst' => 'SGST(%)',
            'cgst' => 'CGST(%)',
            'address' => 'Billing Address',
            'billingState' => 'Billing State',
            'createdOn' => 'Created On',
        ];
    }
    

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    public function getCompany()
    {
        return $this->hasOne(PreinspectionClientCompany::className(), ['id' => 'companyId']);
    }
    
    public function getState()
    {
        return $this->hasOne(MasterState::className(), ['id' => 'stateId']);
    }

    public function getBranch()
    {
        return $this->hasOne(PreinspectionClientBranch::className(), ['id' => 'branchId']);
    }

    public function getStateName($stateId)
    {
        $res =  MasterState::findOne(['id' => $stateId]);
        return ($res) ? $res->state : ''; 
    }

}
