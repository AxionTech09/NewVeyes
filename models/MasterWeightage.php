<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "master_city".
 *
 * @property string $weightage_name
 * @property string $weightage_score
 * @property string $created_on
 */
class MasterWeightage extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'master_weightage';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['weightage_name','weightage_score'], 'required'],
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
            'weightage_name' => 'Weightage Name',
            'weightage_score' => 'Weightage Score',
        ];
    }
}
