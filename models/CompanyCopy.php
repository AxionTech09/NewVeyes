<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "preinspection_client_company".
 *
 * @property integer $id
 * @property string $companyName
 * @property string $created_on
 */
class CompanyCopy extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'preinspection_client_companycopy';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['companyName'], 'required'],
            [['created_on'], 'safe'],
            [['companyName'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'companyName' => 'Company Name',
            'created_on' => 'Created On',
        ];
    }
}
