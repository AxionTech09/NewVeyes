<?php

namespace app\models;
use yii\helpers\ArrayHelper;


use Yii;

/**
 * This is the model class for table "axion_preinspection_fwheeler".
 *
 * @property integer $id
 * @property integer $preinspection_id
* @property string $ltFrontFender
 * @property string $ltFrontDoor
 * @property string $ltRearDoor
 * @property string $ltRunningBoard
 * @property string $ltPillarDoor
 * @property string $ltPillarCenter
 * @property string $ltPillarRear
 * @property string $ltQtrPanel
 * @property string $rtQtrPanel
 * @property string $rtRearDoor
 * @property string $rtFrontDoor
 * @property string $rtFrontPillar
 * @property string $rtCenterPillar
 * @property string $rtRearPillar
 * @property string $rtRunningBoard
 * @property string $rtFrontFender
 * @property string $ltRearTyre
 * @property string $ltFrontTyre
 * @property string $rtRearTyre
 * @property string $rtFrontTyre
 * @property string $created_on
 */
class AxionPreinspectionFwheeler extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'axion_preinspection_fwheeler';
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['preinspection_id'], 'required'],
            [['preinspection_id'], 'integer'],
            [['created_on'], 'safe'],
            [[ 'ltFrontFender', 'ltFrontDoor', 'ltRearDoor', 'ltRunningBoard', 'ltPillarDoor', 
               'ltPillarCenter', 'ltPillarRear', 'ltQtrPanel', 'rtQtrPanel', 'rtRearDoor', 'rtFrontDoor', 
               'rtFrontPillar', 'rtCenterPillar', 'rtRearPillar', 'rtRunningBoard', 'rtFrontFender', 
               'ltRearTyre', 'ltFrontTyre', 'rtRearTyre', 'rtFrontTyre','dicky'],
               'string', 'max' => 50],
        ];
    }


   

     public function getFwheelervalue()
    {
        $fwheelerList = [
                    
                        ['id' => 'Safe', 'name' => 'Safe'],  
                        ['id' => 'Scratch', 'name' => 'Scratch'],
                     
                        ['id' => 'Dented', 'name' => 'Dented'],
                        ['id' => 'Broken', 'name' => 'Broken'],
                        ['id' => 'Damage', 'name' => 'Damage'], 
                        ['id' => 'Not Fitted', 'name' => 'Not Fitted'],
                        ['id' => 'Rusted', 'name' => 'Rusted'],
                        ['id' => 'Pressed', 'name' => 'Pressed'],   
                        ['id' => 'Torn', 'name' => 'Torn'],
                        ['id' => 'Spot Dent', 'name' => 'Spot Dent'],
                   
                        ['id' => 'NA', 'name' => 'NA'],
                        
                       ];
        $fwheelerArray = ArrayHelper::map($fwheelerList, 'id', 'name');
        return $fwheelerArray;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'preinspection_id' => 'Preinspection ID',
            'ltFrontFender' => 'Lt Front Fender',
            'ltFrontDoor' => 'Lt Front Door',
            'ltRearDoor' => 'Lt Rear Door',
            'ltRunningBoard' => 'Lt Running Board',
            'ltPillarDoor' => 'Lt Pillar Door',
            'ltPillarCenter' => 'Lt Pillar Center',
            'ltPillarRear' => 'Lt Pillar Rear',
            'ltQtrPanel' => 'Lt Qtr Panel',
            'rtQtrPanel' => 'Rt Qtr Panel',
            'rtRearDoor' => 'Rt Rear Door',
            'rtFrontDoor' => 'Rt Front Door',
            'rtFrontPillar' => 'Rt Front Pillar',
            'rtCenterPillar' => 'Rt Center Pillar',
            'rtRearPillar' => 'Rt Rear Pillar',
            'rtRunningBoard' => 'Rt Running Board',
            'rtFrontFender' => 'Rt Front Fender',
            'ltRearTyre' => 'Lt Rear Tyre',
            'ltFrontTyre' => 'Lt Front Tyre',
            'rtRearTyre' => 'Rt Rear Tyre',
            'rtFrontTyre' => 'Rt Front Tyre',
            'created_on' => 'Created On',
        ];
    }
}
