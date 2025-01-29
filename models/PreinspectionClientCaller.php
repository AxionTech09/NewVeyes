<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "preinspection_client_caller".
 *
 * @property integer $id
 * @property integer $companyId
 * @property integer $divisionId
 * @property integer $branchId
 * @property string $callerName
 * @property string $callerDesignation
 * @property string $callerMobileNo
 * @property string $callerEmailId
 * @property string $callerAdditionInfo
 * @property string $supervisorName
 * @property string $supervisorDesignation
 * @property string $created_on
 */
class PreinspectionClientCaller extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'preinspection_client_caller';
    }
    
    public function getCallerCompany()
    {
        return $this->hasOne(PreinspectionClientCompany::className(), ['id' => 'companyId']);
    }
    
    public function getCallerDivision()
    {
        return $this->hasOne(PreinspectionClientDivision::className(), ['id' => 'divisionId']);
    }
    
     public function getCallerBranch()
    {
        return $this->hasOne(PreinspectionClientBranch::className(), ['id' => 'branchId']);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['companyId', 'divisionId', 'branchId', 'callerName'], 'required'],
            [['companyId', 'divisionId', 'branchId'], 'integer'],
            [['created_on'], 'safe'],
            [['callerName', 'callerEmailId', 'supervisorName'], 'string', 'max' => 100],
            [['callerDesignation', 'supervisorDesignation'], 'string', 'max' => 50],
            [['callerMobileNo'], 'string', 'max' => 12],
            [['callerAdditionInfo'], 'string', 'max' => 255]
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
            'divisionId' => 'Division',
            'branchId' => 'Branch',
            'callerName' => 'Caller Name',
            'callerDesignation' => 'Caller Designation',
            'callerMobileNo' => 'Caller Mobile No',
            'callerEmailId' => 'Caller Email ID',
            'callerAdditionInfo' => 'Caller Addition Info',
            'supervisorName' => 'Supervisor Name',
            'supervisorDesignation' => 'Supervisor Designation',
            'created_on' => 'Created On',
        ];
    }
}
