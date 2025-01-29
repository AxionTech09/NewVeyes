<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "preinspection_client_company".
 *
 * @property integer $id
 * @property string $make
 * @property string $createdOn
 */
class VehicleMake extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vehicle_make';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['make'], 'required'],
            [['createdOn'], 'safe'],
            [['make'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'make' => 'Make',
            'createdOn' => 'Created On',
        ];
    }
}
