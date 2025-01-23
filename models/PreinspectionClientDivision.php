<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "preinspection_client_division".
 *
 * @property integer $id
 * @property string $divisionName
 * @property integer $companyId
 * @property string $created_on
 */
class PreinspectionClientDivision extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'preinspection_client_division';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['divisionName', 'companyId','regionId'], 'required'],
            [['companyId'], 'integer'],
            [['created_on'], 'safe'],
            [['divisionName'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'divisionName' => 'Division Name',
            'companyId' => 'Company',
            'stateId' => 'State',
            'created_on' => 'Created On',
        ];
    }
    
    public function getDivisionCompany()
    {
        return $this->hasOne(PreinspectionClientCompany::className(), ['id' => 'companyId']);
    }

    public function getDivisionState()
    {
        return $this->hasOne(MasterState::className(), ['id' => 'stateId']);
    }
}
