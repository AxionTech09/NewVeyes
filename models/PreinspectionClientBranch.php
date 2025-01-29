<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "preinspection_client_branch".
 *
 * @property integer $id
 * @property string $branchName
 * @property integer $companyId
 * @property integer $divisionId
 * @property string $created_on
 */
class PreinspectionClientBranch extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'preinspection_client_branch';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['branchName', 'companyId', 'divisionId'], 'required'],
            [['companyId', 'divisionId'], 'integer'],
            [['created_on'], 'safe'],
            [['branchName'], 'string', 'max' => 100]
        ];
    }
    
    public function getBranchCompany()
    {
        return $this->hasOne(PreinspectionClientCompany::className(), ['id' => 'companyId']);
    }
    
    public function getBranchDivision()
    {
        return $this->hasOne(PreinspectionClientDivision::className(), ['id' => 'divisionId']);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'branchName' => 'Branch Name',
            'companyId' => 'Company',
            'divisionId' => 'Division',
            'created_on' => 'Created On',
        ];
    }
}
