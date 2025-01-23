<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "preinspection_client_region".
 *
 * @property integer $id
 * @property string $regionName
 * @property string $regionCode
 * @property integer $companyId
 * @property string $created_on
 */
class PreinspectionClientRegion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'preinspection_client_region';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['regionName', 'companyId','regionCode'], 'required'],
            [['companyId'], 'integer'],
            [['created_on','id'], 'safe'],
            [['regionName'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'regionName' => 'Region Name',
            'regionCode' => 'Region Code',
            'companyId' => 'Company',
            'created_on' => 'Created On',
        ];
    }
    
    public function getRegionCompany()
    {
        return $this->hasOne(PreinspectionClientCompany::className(), ['id' => 'companyId']);
    }
}
