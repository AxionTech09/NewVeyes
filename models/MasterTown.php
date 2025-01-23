<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "master_town".
 *
 * @property integer $id
 * @property string $town
 * @property integer $cityId
 * @property string $created_on
 */
class MasterTown extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'master_town';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['town', 'cityId'], 'required'],
            [['cityId'], 'integer'],
            [['created_on'], 'safe'],
            [['town'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'town' => 'Town/Survey Location',
            'cityId' => 'City/District',
            'created_on' => 'Created On',
        ];
    }
    
    public function getTownCity()
    {
        return $this->hasOne(MasterCity::className(), ['id' => 'cityId']);
    }
}
