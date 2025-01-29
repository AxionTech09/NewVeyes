<?php

namespace app\models;

use Yii;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\base\Security;
use app\models\MasterState;
use app\models\MasterCity;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "users".
 *
 * @property integer $id
 * @property string $firstName
 * @property string $lastName
 * @property string $address
 * @property string $email
 * @property string $password
 * @property string $mobile 
 * @property string $alternateMobile
 * @property string $authKey
 * @property string $accessToken
 * @property string $activationLink
 * @property string $active
 * @property string $createdOn
 * @property string $lastUpdatedOn
 * @property integer $companyId
 * @property integer $divisionId
 * @property integer $branchId
 * @property integer $cityId
 * @property integer $branchHeadId
 * @property integer $surveyorId
 */
class UserCopy extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    public $password_repeat;
    
    public static function tableName()
    {
        return 'userscopy';
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email', 'password', 'mobile'], 'required'],
            [['createdOn','lastUpdatedOn'], 'safe'],
            [['stateId','cityId','companyId','branchId','divisionId','branchHeadId','surveyorId','roId'], 'integer'],
            [['email','password'], 'string', 'max' => 255],
            [['address'],'string'],
            [['pan_number'],'string','max'=>255],
            [['gst_number'],'string','max'=>255],
            [['bank_name'],'string','max'=>255],
            [['account_number'],'string','max'=>255],
            [['ifsc_code'],'string','max'=>255],
            [['branch_name'],'string','max'=>255],
            [['ownerName'],'string','max'=>255],
            

            ['email', 'email'],
            [['authKey', 'accessToken'], 'string', 'max' => 50],
            [['activationLink', 'active'], 'string', 'max' => 1],
            [['firstName','lastName','address'], 'string', 'max' => 100],
            [['mobile'], 'string', 'max' => 23],
            [['email'], 'unique'],
            [['mobile','alternateMobile'], 'unique'],
            [['mobile','alternateMobile'], 'match', 'pattern' => '{^\+?[0-9-]+$}', 'message'=>"Invalid Mobile Number" ],
            [['firstName'],'required','message'=>"Enter Surveyor Name",'on'=>'surveyor' ],
            [['firstName'],'required','message'=>'Enter RO Name','on'=>'bouser'],
            [['ownerName'],'required','message'=>'Enter Owner Name','on'=>'bouser'],
            [['roId'],'required','message'=>"Select RO Name",'on'=>'surveyor' ],
            ['password_repeat', 'required'],
            ['password_repeat', 'compare', 'compareAttribute'=>'password', 'message'=>"Passwords don't match" ],
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'firstName' => 'First Name',
            'lastName' => 'Last Name',
            'ownerName' => 'Owner Name',
            'address' => 'Address',
            'stateId'=>'State',
            'cityId' => 'City',
            'pan_number'=>'PAN Card Number',
            'gst_number'=>'GST Number',
            'bank_name'=>'BANK Name',
            'account_number'=>'Account Number',
            'ifsc_code'=>'IFSC Code',
            'branch_name'=>'Branch Name',
            'companyId' => 'Company',
            'divisionId' => 'Division',
            'branchId' => 'Branch',
            'branchHeadId' => 'Branch Head',
            'surveyorId' => 'Associate Dealer Head',
            'email' => 'Email',
            'password' => 'Password',
            'password_repeat' => 'Retype Password',
            'mobile' => 'Mobile',
            'alternateMobile' => 'Alternate Mobile',
            'authKey' => 'Auth Key',
            'accessToken' => 'Access Token',
            'activationLink' => 'Activation Link',
            'active' => 'Active',
            'createdOn' => 'Created On',
            'lastUpdatedOn' => 'Last Updated On',
        ];
    }
    
    
    public function getCallerCompany()
    {
        return $this->hasOne(PreinspectionClientCompany::className(), ['id' => 'companyId']);
    }
    public function getStateData()
    {
        return $this->hasOne(MasterState::className(), ['id' => 'stateId']);
    }
    
    public function getCallerDivision()
    {
        return $this->hasOne(PreinspectionClientDivision::className(), ['id' => 'divisionId']);
    }
    
    public function getCallerBranch()
    {
        return $this->hasOne(PreinspectionClientBranch::className(), ['id' => 'branchId']);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        $user = User::findOne($id);
        if(count($user)){
           return new static($user);
        }
        return null;
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        $user = User::find()->where(['accessToken'=>$token])->one();
        if(count($user)){
            return new static($user);
        }
        return null;
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByEmail($email)
    {
        $user = User::find()->where(['email'=>$email])->one();
        if(count($user)){
            return new static($user);
        }
        return null;
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        //return $this->password === $password;
        return Yii::$app->getSecurity()->validatePassword($password, $this->password);
    }
    
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->authKey = Yii::$app->getSecurity()->generateRandomString();
                if(isset($this->password)) 
                $this->password = Yii::$app->getSecurity()->generatePasswordHash($this->password);
            }
            
            return true;
        }
        return false;
    }
    
}
