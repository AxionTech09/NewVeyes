<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "master_city".
 *
 * @property string $damage_name
 * @property string $damage_score
 * @property string $created_on
 */
class MasterDamageType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'master_damage_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['damage_name','damage_score'], 'required'],
            [['created_on'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'damage_name' => 'Damage Name',
            'damage_score' => 'Damage Score',
        ];
    }
}
