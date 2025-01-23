<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "axion_claimsurvey_doc_uploads".
 *
 * @property int $id
 * @property string $claimsurveyUuid
 * @property int $referenceNo
 * @property string|null $type
 * @property string|null $file_name
 * @property string|null $other_label
 */
class AxionCliamsueryDocUploads extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'axion_claimsurvey_doc_uploads';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['claimsurveyUuid', 'type', 'file_name', 'other_label','created_on'], 'safe'],
            [['referenceNo'], 'integer'],
            // [['type[Estimate]'], 'required'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'insured_upload_estimate' => 'Insured Upload Estimate',
            'insured_vehicular_doc' => 'Insured Vehicular Document',
            'insured_driving_licence' => 'Insured Driving Licence',
            'insured_police_doc' => 'Insured Police Document',
        ];
    }
    
}
