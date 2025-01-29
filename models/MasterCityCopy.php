<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "master_city".
 *
 * @property integer $id
 * @property string $city
 * @property string $created_on
 */
class MasterCityCopy extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'master_citycopy';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['city'], 'required'],
            [['created_on'], 'safe'],
            [['city'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'city' => 'City/District',
            'created_on' => 'Created On',
        ];
    }
}
