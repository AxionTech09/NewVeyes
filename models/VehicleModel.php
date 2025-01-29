<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "vehicle_model".
 *
 * @property integer $id
 * @property string $model
 * @property integer $makeId
 * @property string $createdOn
 */
class VehicleModel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vehicle_model';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['model', 'makeId'], 'required'],
            [['makeId'], 'integer'],
            [['createdOn'], 'safe'],
            [['model'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'model' => 'Model',
            'makeId' => 'Make',
            'createdOn' => 'Created On',
        ];
    }
    
    public function getModelmake()
    {
        return $this->hasOne(VehicleMake::className(), ['id' => 'makeId']);
    }
}
