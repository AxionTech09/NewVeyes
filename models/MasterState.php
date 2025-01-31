<?php

namespace app\models;
use yii\helpers\ArrayHelper;

use Yii;

/**
 * This is the model class for table "master_city".
 *
 * @property integer $id
 * @property string $city
 * @property string $created_on
 */
class MasterState extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'state_master';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['countryId', 'state', 'stateStatus'], 'required'],
            [['countryId', 'updatedBy'],'integer'],
            [['createdOn', 'createdBy', 'updatedOn', 'updatedBy'], 'safe'],
            [['state'], 'string', 'max' => 100],
            [['stateStatus', 'regCode'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'countryId'=>'Country',
            'state' => 'State',
            'regCode' => 'Vehicle Reg. Code',
            'stateStatus' => 'State Status',
            'createdOn' => 'Created On',
        ];
    }

    public function getUpdatedByName()
    {
        return $this->hasOne(User::className(), ['id' => 'updatedBy']);
    }

    public function getStateStatusArray()
    {
        $stateStatusList= [
                ['id' => 'Active', 'name' => 'Active'],
                ['id' => 'Deactive', 'name' => 'Deactive'],
              ];
        $stateStatusArray = ArrayHelper::map($stateStatusList, 'id', 'name');
        return $stateStatusArray;
    }

    public function beforeSave($insert) {

        if (parent::beforeSave($insert)) {
            date_default_timezone_set('Asia/Calcutta');

            if ($this->isNewRecord) {
                $this->createdOn = date("Y-m-d H:i:s");
                $this->updatedOn = date("Y-m-d H:i:s");
                $this->createdBy = Yii::$app->user->identity->id;
                $this->updatedBy = Yii::$app->user->identity->id;   
            }
            else {
                $this->updatedBy = Yii::$app->user->identity->id;
                $this->updatedOn = date("Y-m-d H:i:s");
            }
            return true;
        }
        return false;
    }

}
