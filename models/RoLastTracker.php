<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ro_last_tracker".
 *
 * @property integer $id
 * @property integer $companyId
 * @property integer $stateId
 * @property integer $roId
 * @property string $createdOn
 */
class RoLastTracker extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ro_last_tracker';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['companyId','stateId','roId','createdOn'], 'safe'],
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
            'roId' => 'Ro User',
            'createdOn' => 'Created On',
        ];
    }

    public function getCompany()
    {
        return $this->hasOne(PreinspectionClientCompany::className(), ['id' => 'companyId']);
    }
}
