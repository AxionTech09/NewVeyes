<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "master_sbu_head".
 *
 * @property int $id
 * @property string $sbuHead
 * @property string|null $mail
 * @property string|null $gst
 * @property int $stateId
 * @property string $sbuHeadStatus
 * @property int $updatedBy
 * @property string $updatedOn
 * @property int $createdBy
 * @property string $createdOn
 */
class MasterSbuHead extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'master_sbu_head';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'stateId', 'sbuHeadStatus', 'updatedBy', 'updatedOn', 'createdBy', 'createdOn'], 'required'],
            [['stateId', 'updatedBy', 'createdBy'], 'integer'],
            [['updatedOn', 'createdOn'], 'safe'],
            [['name', 'mail', 'gst'], 'string', 'max' => 150],
            [['sbuHeadStatus'], 'string', 'max' => 30],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'mail' => 'Mail',
            'gst' => 'Gst',
            'stateId' => 'State ID',
            'sbuHeadStatus' => 'Sbu Head Status',
            'updatedBy' => 'Updated By',
            'updatedOn' => 'Updated On',
            'createdBy' => 'Created By',
            'createdOn' => 'Created On',
        ];
    }
}
