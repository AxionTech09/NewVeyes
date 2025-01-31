<?php

namespace app\models;
use yii\helpers\ArrayHelper;

use Yii;

/**
 * This is the model class for table "axion_claimsurvey_bill".
 *
 * @property int $id
 * @property int $preinspection_id
 * @property string $name
 * @property string $address
 * @property string $mobile
 * @property string $particular1
 * @property string $particular2
 * @property string $particular3
 * @property string $particular4
 * @property string $particular5
 * @property string $particular6
 * @property string $particular7
 * @property string $particular8
 * @property string $sgst
 * @property string $cgst
 * @property string $roundedOffTo
 * @property string $total
 * @property string $particularAmount1
 * @property string $particularAmount2
 * @property string $particularAmount3
 * @property string $particularAmount4
 * @property string $particularAmount5
 * @property string $particularAmount6
 * @property string $particularAmount7
 * @property string $particularAmount8
 * @property int $userId
 * @property string $created_on
 * @property string $lastUpdatedOn
 *
 */
class AxionClaimsurveyBill extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'axion_claimsurvey_bill';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
          
            [['preinspection_id','userId'], 'integer'],
            [['created_on','lastUpdatedOn'], 'safe'],
            [['name','address','mobile','particular1','particular2','particular3','particular4','particular5','particular6','particular7','particular8'], 'string', 'max' => 250],
            [['sgst','cgst','roundedOffTo','total','particularAmount1','particularAmount2','particularAmount2','particularAmount3','particularAmount4','particularAmount5','particularAmount6','particularAmount7','particularAmount8'],'double']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'preinspection_id' => 'PreinspectionId',
            'name' => 'Name',
            'address' => 'Address',
            'mobile' => 'mobile',
            'particular1' => '',
            'particular2' => '',
            'particular3' => '',
            'particular4' => '',
            'particular5' => '',
            'particular6' => '',
            'particular7' => '',
            'particular8' => '',
            'sgst' => '',
            'cgst' => '',
            'total' => '',
            'roundedOffTo' => '',
            'particularAmount1' => '',
            'particularAmount2' => '',
            'particularAmount3' => '',
            'particularAmount4' => '',
            'particularAmount5' => '',
            'particularAmount6' => '',
            'particularAmount7' => '',
            'particularAmount8' => '',
            'userId' => 'userId',
            'created_on' => 'Created On',
            'lastUpdatedOn' => '',
        ];
    }
}
