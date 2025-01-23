<?php

namespace app\models;
use yii\helpers\ArrayHelper;

use Yii;

/**
 * This is the model class for table "preinspection_client_company".
 *
 * @property integer $id
 * @property string $companyName
 * @property string $created_on
 */
class PreinspectionClientCompany extends \yii\db\ActiveRecord
{
    public $billingAddresses,$stateId,$rate2WheelerArr,$rate3WheelerArr,$rate4WheelerArr,$rateCommercialArr,$rateConveyanceArr,$gstNoArr,$igstArr,$sgstArr,$cgstArr,$billingAddressArr,$billingStateArr,$stateArr,$branchId,$branchArr;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'preinspection_client_company';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
         return [
            [['companyName','billType','rate2Wheeler','rate3Wheeler','rate4Wheeler','rateCommercial','rateConveyance', 'companyStatus', 'billingState'], 'required'],
            [['created_on','gstNo','igst','sgst','cgst','billingAddress'], 'safe'],
            [['companyName'], 'string', 'max' => 100],
            [['billingAddress'], 'string', 'max' => 1000],
            [['gstNo', 'companyStatus'], 'string', 'max' => 20],
            [['billingState'], 'integer'],
            [['rate2Wheeler','rate3Wheeler','rate4Wheeler','rateCommercial','rateConveyance','igst','sgst','cgst'],'double']
        ];
    }

    public function getBillTypes()
    {
        $billTypes= [
            ['id' => 'Corporate Bill', 'name' => 'Corporate Bill'],
            ['id' => 'State Bill', 'name' => 'State Bill'],
            ['id' => 'Branch Bill', 'name' => 'Branch Bill'],
            ['id' => 'SBU Bill', 'name' => 'SBU Bill'],
        ];
        $billTypesArray = ArrayHelper::map($billTypes, 'id', 'name');
        return $billTypesArray;
    }

    public function getCompanyStatusArray()
    {
        $companyStatusList= [
                ['id' => 'Active', 'name' => 'Active'],
                ['id' => 'Deactive', 'name' => 'Deactive'],
              ];
        $companyStatusArray = ArrayHelper::map($companyStatusList, 'id', 'name');
        return $companyStatusArray;
    }

    public function getState()
    {
        return $this->hasOne(MasterState::className(), ['id' => 'billingState']);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'companyName' => 'Company Name',
            'billType' => 'Bill Type',
            'rate2Wheeler' => '2 Wheeler Rate',
            'rate3Wheeler' => '3 Wheeler Rate',
            'rate4Wheeler' => '4 Wheeler Rate',
            'rateCommercial' => 'Commercial Rate',
            'rateConveyance' => 'Conveynce Rate',
            'gstNo' => 'GST No.',
            'igst' => 'IGST(%)',
            'sgst' => 'SGST(%)',
            'cgst' => 'CGST(%)',
            'billingAddress' => 'Billing Address',
            'billingState' => 'Billing State',
            'rate2WheelerArr' => '2 Wheeler Rate',
            'rate3WheelerArr' => '3 Wheeler Rate',
            'rate4WheelerArr' => '4 Wheeler Rate',
            'rateCommercialArr' => 'Commercial Rate',
            'rateConveyanceArr' => 'Conveynce Rate',
            'gstNoArr' => 'GST No.',
            'igstArr' => 'IGST(%)',
            'sgstArr' => 'SGST(%)',
            'cgstArr' => 'CGST(%)',
            'billingAddressArr' => 'Billing Address',
            'billingStateArr' => 'Billing State',
            'created_on' => 'Created On',
            'stateArr' => 'State',
            'stateId' => 'State',
            'branchId' => 'Branch',
            'branchArr' => 'Branch',
            'companyStatus' => 'Company Status'
        ];
    }
}
