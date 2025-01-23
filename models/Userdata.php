<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\base\NotSupportedException;

/**
 * This is the model class for table "userdata".
 *
 * @property integer $id
 * @property string $name
 * @property string $username
 * @property string $password
 * @property string $type
 * @property integer $valuator_staff
 * @property string $mobile
 * @property string $created_on
 */
class Userdata extends ActiveRecord implements IdentityInterface
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'userdata';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'username', 'password', 'type'], 'required'],
            [['valuator_staff'], 'integer'],
            [['created_on'], 'safe'],
            [['name'], 'string', 'max' => 25],
            [['username', 'password', 'type'], 'string', 'max' => 20],
            [['mobile'], 'string', 'max' => 12],
            [['username'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'username' => 'Username',
            'password' => 'Password',
            'type' => 'Type',
            'valuator_staff' => 'Assign Staff',
            'mobile' => 'Mobile',
            'create_access' => 'Create Access',
            'qc_access' => 'QC Access',
            'created_on' => 'Created On',
        ];
    }
    
    public function getStaffProcess()
    {
        return $this->hasMany(Processdata::className(), ['staffName' => 'id']);
    }
    
    public function getValuatorProcess()
    {
        return $this->hasMany(Processdata::className(), ['valuatorName' => 'id']);
    }
    
    public function getValuatorStaff()
    {
        return $this->hasOne(Userdata::className(), ['id' => 'valuator_staff']);
    }

    public static function findIdentity($id){
            return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null){
            throw new NotSupportedException();//I don't implement this method because I don't have any access token column in my database
    }

    public function getId(){
            return $this->id;
    }

    public function getAuthKey(){
            throw new NotSupportedException();//You should not implement this method if you don't have authKey column in your database
    }

    public function validateAuthKey($authKey){
            throw new NotSupportedException();//You should not implement this method if you don't have authKey column in your database
    }

    public static function findByUsername($username){
            return self::findOne(['username'=>$username]);
    }

    public function validatePassword($password){
            return $this->password === $password;
    }
}
