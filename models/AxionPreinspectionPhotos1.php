<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "axion_preinspection_photos".
 *
 * @property integer $id
 * @property integer $preinspection_id
 * @property string $photo
 * @property string $created_on
 */
class AxionPreinspectionPhotos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'axion_preinspection_photos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['preinspection_id'], 'required'],
            [['preinspection_id'], 'integer'],
            [['created_on'], 'safe'],
            [['photo'], 'string', 'max' => 100],
            [['photo'], 'file', 'extensions' => 'png, jpg, jpeg','maxFiles' => 50]
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
            'photo' => 'Photo',
            'created_on' => 'Created On',
        ];
    }
}
