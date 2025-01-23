<?php

namespace app\models;
use yii\helpers\ArrayHelper;

use Yii;

/**
 * This is the model class for table "axion_claimsurvey_photos".
 *
 * @property integer $id
 * @property integer $preinspection_id
 * @property string $type
 * @property string $image
 * @property string $created_on
 */
class AxionPreinspectionAiPhotos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'axion_preinspection_ai_photos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['preinspection_id'], 'required'],
            [['image', 'image', 'created_on'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'preinspection_id' => 'Preinspection ID',
            'type' => 'Type',
            'image' => 'Image',
            'created_on' => 'Created On',
        ];
    }
}
