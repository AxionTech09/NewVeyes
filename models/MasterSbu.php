<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "master_sbu".
 *
 * @property int $id
 * @property string $sbuCode
 * @property string $sbuName
 * @property int $sbuHead
 * @property string $lsc
 * @property string $superSbu
 * @property string $sbuStatus
 * @property int $updatedBy
 * @property string $updatedOn
 * @property int $createdBy
 * @property string $createdOn
 */
class MasterSbu extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'master_sbu';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sbuCode', 'sbuName', 'sbuHead', 'lsc', 'superSbu', 'sbuStatus', 'updatedBy', 'updatedOn', 'createdBy', 'createdOn'], 'required'],
            [['sbuHead', 'updatedBy', 'createdBy'], 'integer'],
            [['updatedOn', 'createdOn'], 'safe'],
            [['sbuCode'], 'string', 'max' => 50],
            [['sbuName', 'lsc', 'superSbu'], 'string', 'max' => 150],
            [['sbuStatus'], 'string', 'max' => 30],
            [['sbuCode'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sbuCode' => 'Sbu Code',
            'sbuName' => 'Sbu Name',
            'sbuHead' => 'Sbu Head',
            'lsc' => 'Lsc',
            'superSbu' => 'Super Sbu',
            'sbuStatus' => 'Sbu Status',
            'updatedBy' => 'Updated By',
            'updatedOn' => 'Updated On',
            'createdBy' => 'Created By',
            'createdOn' => 'Created On',
        ];
    }
}
