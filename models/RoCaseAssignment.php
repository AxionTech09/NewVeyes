<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ro_case_assignment".
 *
 * @property integer $id
 * @property integer $companyId
 * @property integer $stateId
 * @property integer $roId
 * @property integer $caseCnt
 * @property string $createdOn
 * @property string $updatedOn
 */
class RoCaseAssignment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ro_case_assignment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['companyId','stateId','roId','caseCnt','createdOn','updatedOn'], 'safe'],
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
            'caseCnt' => 'Case Count',
            'createdOn' => 'Created On',
            'updatedOn' => 'Updated On',
        ];
    }

    public function getCompany()
    {
        return $this->hasOne(PreinspectionClientCompany::className(), ['id' => 'companyId']);
    }
}
