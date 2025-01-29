<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "email_history".
 *
 * @property integer $id
 * @property string $email
 * @property string $subject
 * @property string $message
 * @property string $created_on
 */
class EmailHistory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'email_history';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email', 'subject', 'message'], 'required'],
            [['message'], 'string'],
            [['created_on'], 'safe'],
            [['email'], 'string', 'max' => 100],
            [['subject'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email' => 'Email',
            'subject' => 'Subject',
            'message' => 'Message',
            'created_on' => 'Created On',
        ];
    }
}
