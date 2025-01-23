<?php

namespace app\models;

use Yii;


/**
 * This is the model class for table "master_banks".
 * @property int $id
 * @property string $bankName
 * @property string $branch
 * @property string $createdOn
 * @property string $lastUpdatedOn
 */
 
class MasterBanks extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'master_banks';
    }
 
    

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['createdOn', 'lastUpdatedOn'], 'safe'],
            [['branch'], 'required'],
            [['bankName'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'bankName' => 'Bank Name',
            'branch' => 'Branch',
            'lastUpdatedOn' => 'Last Updated On',
        ];
    }
}
