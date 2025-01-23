<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "fieldexecutives_tasks".
 *
 * @property integer $id
 * @property integer $processId
 * @property integer $processNo
 * @property string $companyName
 * @property string $location
 * @property string $customerAppointmentDateTime
 * @property string $requestDateTime
 * @property string $vehicleNumber
 * @property string $status
 * @property integer $fieldexecutiveId
 * @property string $processType
 * @property string $created_on
 */
class FieldexecutivesTasks extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'fieldexecutives_tasks';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['processId', 'processNo', 'customerAppointmentDateTime', 'fieldexecutiveId', 'processType'], 'required'],
            [['processId', 'fieldexecutiveId'], 'integer'],
            [['customerAppointmentDateTime', 'requestDateTime', 'created_on'], 'safe'],
            [['vehicleNumber', 'processNo'], 'string', 'max' => 15],
            [['companyName'], 'string', 'max' => 100],
            [['location'], 'string', 'max' => 255],
            [['processType','status'], 'string', 'max' => 50]
        ];
    }
    
    public function getFieldexecutiveUser()
    {
        return $this->hasOne(MasterFieldexecutives::className(), ['id' => 'fieldexecutiveId']);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'processId' => 'Process ID',
            'processNo' => 'Ref/Req No',
            'companyName' => 'Company Name',
            'location' => 'Veh/Sur Location',
            'customerAppointmentDateTime' => 'Cust App DateTime',
            'requestDateTime' => 'Req/Int DateTime',
            'vehicleNumber' => 'Veh Number',
            'status' => 'Status',
            'fieldexecutiveId' => 'FE Name',
            'processType' => 'Process Type',
            'created_on' => 'Created On',
        ];
    }
}
