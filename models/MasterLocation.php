<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "master_location".
 *
 * @property integer $id
 * @property integer $cityId
 * @property integer $townId
 * @property integer $conveyance
 * @property integer $extraKms
 * @property string $created_on
 */
class MasterLocation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'master_location';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cityId', 'townId'], 'required'],
            [['cityId', 'townId', 'conveyance', 'extraKms'], 'integer'],
            [['created_on'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cityId' => 'City/District',
            'townId' => 'Town/Survey Location',
            'conveyance' => 'Conveyance to Surveyor / Valuator',
            'extraKms' => 'Extra KMS',
            'created_on' => 'Created On',
        ];
    }
    
    public function getLocationCity()
    {
        return $this->hasOne(MasterCity::className(), ['id' => 'cityId']);
    }
    
    public function getLocationTown()
    {
        return $this->hasOne(MasterTown::className(), ['id' => 'townId']);
    }
}
