<?php

namespace app\models;

use Yii;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\base\Security;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "logs".
 *
 * @property integer $id
 * @property integer $leadNumber
 * @property string $message
 * @property string $createdOn
 */
class Logs extends \yii\db\ActiveRecord
{
    
    public static function tableName()
    {
        return 'logs';
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['createdOn'], 'safe'],
            [['id'], 'integer'],
            [['message','leadNumber','request'], 'string']            
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'leadNumber' => 'Lead Number',
            'message' => 'Message',
            'request' => 'Request',
            'createdOn' => 'Created On'
        ];
    }
    

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

}
