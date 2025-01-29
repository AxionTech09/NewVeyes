<?php

namespace app\models;
use yii\helpers\ArrayHelper;

use Yii;

/**
 * This is the model class for table "axion_preinspection_fourwheeler".
 *
 * @property integer $id
 * @property integer $preinspection_id
 * @property string $colour
 * @property string $odometerReading
 * @property string $rcVerified
 * @property string $fuelType
 * @property string $stereoMake
 * @property string $otherElectrical
 * @property string $centerLock
 * @property string $frontBumper
 * @property string $grill
 * @property string $headLamp
 * @property string $indicatorLight
 * @property string $frontPanel
 * @property string $bonnet
 * @property string $leftApron
 * @property string $rightApron
 * @property string $dicky
 * @property string $rearBumper
 * @property string $tallLamp
 * @property string $ltFrontFender
 * @property string $ltFrontDoor
 * @property string $ltRearDoor
 * @property string $ltRunningBoard
 * @property string $ltPillarDoor
 * @property string $ltPillarCentre
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
 * @property string $rearViewMirror
 * @property string $tyres
 * @property string $ltRearTyre
 * @property string $ltFrontTyre
 * @property string $rtRearTyre
 * @property string $rtFrontTyre
 * @property string $backGlass
 * @property string $frontwsGlassLaminated
 * @property string $underCarriage
 * @property string $created_on
 */
class AxionPreinspectionFourwheeler extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'axion_preinspection_fourwheeler';
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
            [['colour', 'odometerReading', 'rcVerified', 'fuelType', 'stereoMake', 'otherElectrical', 'centerLock', 'frontBumper', 'grill', 'headLamp', 'indicatorLight', 'frontPanel', 'bonnet', 'leftApron', 'rightApron', 'dicky', 'rearBumper', 'tallLamp', 'ltFrontFender', 'ltFrontDoor', 'ltRearDoor', 'ltRunningBoard', 'ltPillarDoor', 'ltPillarCentre', 'ltPillarRear', 'ltQtrPanel', 'rtQtrPanel', 'rtRearDoor', 'rtFrontDoor', 'rtFrontPillar', 'rtCenterPillar', 'rtRearPillar', 'rtRunningBoard', 'rtFrontFender', 'rearViewMirror', 'tyres', 'ltRearTyre', 'ltFrontTyre', 'rtRearTyre', 'rtFrontTyre', 'backGlass', 'frontwsGlassLaminated', 'underCarriage'], 'string', 'max' => 50],
        ];
    }

    public function getRcValue()
    {
        $rcList= [
                ['id' => '', 'name' => '-Select-'],  
                ['id' => 'Original', 'name' => 'Yes - Original'],
                ['id' => 'Photocopy', 'name' => 'Yes - Photocopy'],
                ['id' => 'No', 'name' => 'No'],
              ];
        $rcArray = ArrayHelper::map($rcList, 'id', 'name');
        return $rcArray;
    }
    
    public function getQcStatusvalue()
    {
        $qcStatusList = [   
                        ['id' => '8', 'name' => 'Survey Done'],
                        ['id' => '101', 'name' => 'PI-Recommended'],
                        ['id' => '102', 'name' => 'PI-Not Recommended'],
                        ['id' => '104', 'name' => 'PI-Refer to Under Writer'], 
                       ];
        $qcStatusArray = ArrayHelper::map($qcStatusList, 'id', 'name');
        return $qcStatusArray;
    }
    
    public function getDamageType1value()
    {
        $damageType1List = [
                        ['id' => 'Safe', 'name' => 'Safe'],
                        ['id' => 'Crack', 'name' => 'Crack'],   
                        ['id' => 'Scratch', 'name' => 'Scratch'],
                        ['id' => 'Dented', 'name' => 'Dented'],
                        ['id' => 'Broken', 'name' => 'Broken'],
                        ['id' => 'Damage', 'name' => 'Damage'], 
                        ['id' => 'Not Fitted', 'name' => 'Not Fitted'],
                        ['id' => 'Rusted', 'name' => 'Rusted'],
                        ['id' => 'Pressed', 'name' => 'Pressed'],   
                        ['id' => 'Torn', 'name' => 'Torn'],
                        ['id' => 'Spot Dent', 'name' => 'Spot Dent'],
                        ['id' => 'Dry Dent', 'name' => 'Dry Dent'],
                        ['id' => 'Paint Peel Off', 'name' => 'Paint Peel Off'], 
                        ['id' => 'NA', 'name' => 'NA'],
                       ];
        $damageType1Array = ArrayHelper::map($damageType1List, 'id', 'name');
        return $damageType1Array;
    }
    
    public function getDamageType2value()
    {
        $damageType2List = [
                        ['id' => '', 'name' => '-Select-'],
                        ['id' => 'Intact', 'name' => 'Intact'],
                        ['id' => 'Crack', 'name' => 'Crack'],   
                        ['id' => 'Scar', 'name' => 'Scar'],
                        ['id' => 'Broken', 'name' => 'Broken'],
                        ['id' => 'Dented', 'name' => 'Dented'],
                        ['id' => 'Not Fitted', 'name' => 'Not Fitted'],
                        ['id' => 'Chipped Off', 'name' => 'Chipped Off'],
                        ['id' => 'NA', 'name' => 'NA'],
                       ];
        $damageType2Array = ArrayHelper::map($damageType2List, 'id', 'name');
        return $damageType2Array;
    }
    
    public function getDamageType3value()
    {
        $damageType3List = [
                        ['id' => '', 'name' => '-Select-'],
                        ['id' => 'Intact', 'name' => 'Intact'],
                        ['id' => 'Crack', 'name' => 'Crack'],
                        ['id' => 'Scratch', 'name' => 'Scratch'],
                        ['id' => 'Scar', 'name' => 'Scar'],
                        ['id' => 'Wiper Scratch', 'name' => 'Wiper Scratch'],
                        ['id' => 'Broken', 'name' => 'Broken'],
                        ['id' => 'Not Fitted', 'name' => 'Not Fitted'],
                        ['id' => 'Chipped Off', 'name' => 'Chipped Off'],
                        ['id' => 'Dented', 'name' => 'Dented'],
                        ['id' => 'NA', 'name' => 'NA'],
                       ];
        $damageType3Array = ArrayHelper::map($damageType3List, 'id', 'name');
        return $damageType3Array;
    }
    
    public function getDamageType4value()
    {
        $damageType4List = [
                        ['id' => 'Safe', 'name' => 'Safe'],
                        ['id' => 'Crack', 'name' => 'Crack'],   
                        ['id' => 'Scratch', 'name' => 'Scratch'],
                        ['id' => 'Dented', 'name' => 'Dented'],
                        ['id' => 'Broken', 'name' => 'Broken'],
                        ['id' => 'Not Fitted', 'name' => 'Not Fitted'],
                        ['id' => 'Rusted', 'name' => 'Rusted'],
                        ['id' => 'Spot Dent', 'name' => 'Spot Dent'],
                        ['id' => 'Pressed', 'name' => 'Pressed'],   
                        ['id' => 'Torn', 'name' => 'Torn'],
                        ['id' => 'NA', 'name' => 'NA'],
                       ];
        $damageType4Array = ArrayHelper::map($damageType4List, 'id', 'name');
        return $damageType4Array;
    }
    
    public function getDamageType5value()
    {
        /* Tyres */
        $damageType5List = [
                        ['id' => 'Safe', 'name' => 'Safe'],
                        ['id' => 'Average', 'name' => 'Average'],
                        ['id' => 'Poor', 'name' => 'Poor'],
                        ['id' => 'Damaged', 'name' => 'Damaged'],
                        ['id' => 'Not Fitted', 'name' => 'Not Fitted'],
                        ['id' => 'Rusted', 'name' => 'Rusted'],
                        ['id' => 'Torn', 'name' => 'Torn'],
                        ['id' => 'NA', 'name' => 'NA'],
                       ];
        $damageType5Array = ArrayHelper::map($damageType5List, 'id', 'name');
        return $damageType5Array;
    }
    
    public function getFuelTypevalue()
    {
        $fuelTypeList = [
                        ['id' => '', 'name' => '-Select-'],
                        ['id' => 'Diesel', 'name' => 'Diesel'],
                        ['id' => 'Petrol', 'name' => 'Petrol'],   
                        ['id' => 'CNG(Petrol)', 'name' => 'CNG(Petrol)'],
                        ['id' => 'CNG(Diesel)', 'name' => 'CNG(Diesel)'],
                        ['id' => 'LPG(Petrol)', 'name' => 'LPG(Petrol)'],
                        ['id' => 'LPG', 'name' => 'LPG'],
                        ['id' => 'Electric', 'name' => 'Electric'],
                       ];
        $fuelTypeArray = ArrayHelper::map($fuelTypeList, 'id', 'name');
        return $fuelTypeArray;
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'preinspection_id' => 'Preinspection ID',
            'colour' => 'Colour',
            'odometerReading' => 'Odometer Reading',
            'rcVerified' => 'Rc Verified',
            'fuelType' => 'Fuel Type',
            'stereoMake' => 'Stereo Make',
            'otherElectrical' => 'Other Electrical',
            'centerLock' => 'Center Lock',
            'frontBumper' => 'Front Bumper',
            'grill' => 'Grill',
            'headLamp' => 'Head Lamp',
            'indicatorLight' => 'Indicator Light',
            'frontPanel' => 'Front Panel',
            'bonnet' => 'Bonnet',
            'leftApron' => 'Left Apron',
            'rightApron' => 'Right Apron',
            'dicky' => 'Dicky',
            'rearBumper' => 'Rear Bumper',
            'tallLamp' => 'Tail Lamp',
            'ltFrontFender' => 'Lt Front Fender',
            'ltFrontDoor' => 'Lt Front Door',
            'ltRearDoor' => 'Lt Rear Door',
            'ltRunningBoard' => 'Lt Running Board',
            'ltPillarDoor' => 'Lt Pillar Door',
            'ltPillarCentre' => 'Lt Pillar Centre',
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
            'rearViewMirror' => 'Rear View Mirror',
            'tyres' => 'Tyres',
            'ltRearTyre' => 'Lt Rear Tyre',
            'ltFrontTyre' => 'Lt Front Tyre',
            'rtRearTyre' => 'Rt Rear Tyre',
            'rtFrontTyre' => 'Rt Front Tyre',
            'backGlass' => 'Back Glass',
            'frontwsGlassLaminated' => 'Frontws Glass Laminated',
            'underCarriage' => 'Under Carriage',
            'created_on' => 'Created On',
        ];
    }
}
