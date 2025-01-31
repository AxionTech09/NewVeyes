<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ro_case_assignment_tracker".
 *
 * @property integer $id
 * @property integer $companyId
 * @property integer $stateId
 * @property integer $roId
 * @property integer $trackerCnt
 * @property string $createdOn
 * @property string $updatedOn
 */
class RoCaseAssignmentTracker extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ro_case_assignment_tracker';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['companyId','stateId','roId','trackerCnt','createdOn','updatedOn'], 'safe'],
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
            'trackerCnt' => 'Tracker Count',
            'createdOn' => 'Created On',
            'updatedOn' => 'Updated On',
        ];
    }

    public function getCompany()
    {
        return $this->hasOne(PreinspectionClientCompany::className(), ['id' => 'companyId']);
    }
}
