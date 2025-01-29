<?php

namespace app\models;
use yii\helpers\ArrayHelper;

use Yii;

/**
 * This is the model class for table "axion_preinspection_commercial".
 *
 * @property integer $id
 * @property integer $preinspection_id
 * @property string $odometerReading
 * @property string $rcVerified
 * @property string $typeOfBody
 * @property string $fuelType
 * @property string $cabin
 * @property string $dashBoard
 * @property string $frontSideBody
 * @property string $rearSideBody
 * @property string $rightSideBody
 * @property string $leftSideBody
 * @property string $frontExcavator
 * @property string $bonnet
 * @property string $craneBucket
 * @property string $craneHook
 * @property string $ac
 * @property string $boom
 * @property string $fans
 * @property string $hydrualicSystem
 * @property string $chassisFrame
 * @property string $fuelTank
 * @property string $seats
 * @property string $tyres
 * @property string $spareTyre
 * @property string $headLights
 * @property string $indicatorLights
 * @property string $doors
 * @property string $wsGlass
 * @property string $leftWindowGlass
 * @property string $rightWindowGlass
 * @property string $backGlass
 * @property string $excavatorCabinGlass
 * @property string $craneCabinGlass
 * @property string $rearViewMirrors
 * @property string $tailLamps
 * @property string $extraFittings
 * @property string $created_on
 */
class AxionPreinspectionCommercial extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'axion_preinspection_commercial';
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
            [['odometerReading', 'rcVerified', 'typeOfBody', 'fuelType', 'cabin', 'dashBoard', 'frontSideBody', 'rearSideBody', 'rightSideBody', 'leftSideBody', 'frontExcavator', 'bonnet', 'craneBucket', 'craneHook', 'ac', 'boom', 'fans', 'hydrualicSystem', 'chassisFrame', 'fuelTank', 'seats', 'tyres', 'spareTyre', 'headLights', 'indicatorLights', 'doors', 'wsGlass', 'leftWindowGlass', 'rightWindowGlass', 'backGlass', 'excavatorCabinGlass', 'craneCabinGlass', 'rearViewMirrors', 'tailLamps', 'extraFittings'], 'string', 'max' => 50],
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

    public function getBodyTypevalue()
    {
        $bodyTypeList = [
                        ['id' => '', 'name' => '-Select-'],
                        ['id' => 'Bus', 'name' => 'Bus'],
                        ['id' => 'Truck', 'name' => 'Truck'],
                        ['id' => 'Dumper', 'name' => 'Dumper'],
                        ['id' => 'Dent', 'name' => 'Dent'],
                        ['id' => 'Excavator', 'name' => 'Excavator'],
                        ['id' => 'Three Wheeler', 'name' => 'Three Wheeler'],
                        ['id' => 'Crane', 'name' => 'Crane'],
                        ['id' => 'Tanker', 'name' => 'Tanker'],
                        ['id' => 'LPG Tanker', 'name' => 'LPG Tanker'],
                        ['id' => 'Tractor', 'name' => 'Tractor'],
                        ['id' => 'Refrigator Body', 'name' => 'Refrigator Body'],
                        ['id' => 'Fire Brigade', 'name' => 'Fire Brigade'],
                        ['id' => 'Concrete Mixture', 'name' => 'Concrete Mixture'],
                        ['id' => 'Machine', 'name' => 'Machine'],
                       ];
        $bodyTypeArray = ArrayHelper::map($bodyTypeList, 'id', 'name');
        return $bodyTypeArray;
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

    public function getCabinValue()
    {
        $cabinList = [
                        ['id' => 'Safe', 'name' => 'Safe'],
                        ['id' => 'Steel', 'name' => 'Steel'],
                        ['id' => 'Wooden', 'name' => 'Wooden'],
                        ['id' => 'Glass', 'name' => 'Glass'],
                        ['id' => 'Rusted', 'name' => 'Rusted'],
                        ['id' => 'Average', 'name' => 'Average'],
                        ['id' => 'Poor', 'name' => 'Poor'],
                        ['id' => 'Scar', 'name' => 'Scar'],
                       ];
        $cabinArray = ArrayHelper::map($cabinList, 'id', 'name');
        return $cabinArray;
    }

    public function getDamageType1value()
    {
        /*Dash Board, Bonnet  */
        $damageType1List = [
                        ['id' => 'Safe', 'name' => 'Safe'],
                        ['id' => 'Scratch', 'name' => 'Scratch'],
                        ['id' => 'Dent', 'name' => 'Dent'],
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
        /* Front Side Body, Rear Side Body, Right Side Body, Left Side Body, Crane Bucket  */
        $damageType2List = [
                        ['id' => 'Safe', 'name' => 'Safe'],
                        ['id' => 'Crack', 'name' => 'Crack'],
                        ['id' => 'Scratch', 'name' => 'Scratch'],
                        ['id' => 'Broken', 'name' => 'Broken'],
                        ['id' => 'Dented', 'name' => 'Dented'],
                        ['id' => 'Damage', 'name' => 'Damage'],
                        ['id' => 'Rusted', 'name' => 'Rusted'],
                        ['id' => 'Not Fitted', 'name' => 'Not Fitted'],
                        ['id' => 'Torn', 'name' => 'Torn'],
                        ['id' => 'Chipped Off', 'name' => 'Chipped Off'],
                        ['id' => 'NA', 'name' => 'NA'],
                       ];
        $damageType2Array = ArrayHelper::map($damageType2List, 'id', 'name');
        return $damageType2Array;
    }

    public function getDamageType3value()
    {
        /* Front Excavator, Crane Hook, Boom, Chassis Frame */
        $damageType3List = [
                        ['id' => 'Safe', 'name' => 'Safe'],
                        ['id' => 'Crack', 'name' => 'Crack'],
                        ['id' => 'Scratch', 'name' => 'Scratch'],
                        ['id' => 'Broken', 'name' => 'Broken'],
                        ['id' => 'Dented', 'name' => 'Dented'],
                        ['id' => 'Damage', 'name' => 'Damage'],
                        ['id' => 'Not Fitted', 'name' => 'Not Fitted'],
                        ['id' => 'Not Working', 'name' => 'Not Working'],
                        ['id' => 'Rusted', 'name' => 'Rusted'],
                        ['id' => 'Torn', 'name' => 'Torn'],
                        ['id' => 'Chipped Off', 'name' => 'Chipped Off'],
                        ['id' => 'NA', 'name' => 'NA'],
                       ];
        $damageType3Array = ArrayHelper::map($damageType3List, 'id', 'name');
        return $damageType3Array;
    }

    public function getDamageType4value()
    {
        /* AC,Fans */
        $damageType4List = [
                        ['id' => 'Safe', 'name' => 'Safe'],
                        ['id' => 'Not Fitted', 'name' => 'Not Fitted'],
                        ['id' => 'Not Working', 'name' => 'Not Working'],
                        ['id' => 'Rusted', 'name' => 'Rusted'],
                        ['id' => 'Torn', 'name' => 'Torn'],
                        ['id' => 'NA', 'name' => 'NA'],
                       ];
        $damageType4Array = ArrayHelper::map($damageType4List, 'id', 'name');
        return $damageType4Array;
    }

    public function getDamageType5value()
    {
        /* Hydraualic System */
        $damageType5List = [
                        ['id' => 'Safe', 'name' => 'Safe'],
                        ['id' => 'Leak', 'name' => 'Leak'],
                        ['id' => 'Not Fitted', 'name' => 'Not Fitted'],
                        ['id' => 'Not Working', 'name' => 'Not Working'],
                        ['id' => 'Rusted', 'name' => 'Rusted'],
                        ['id' => 'NA', 'name' => 'NA'],
                       ];
        $damageType5Array = ArrayHelper::map($damageType5List, 'id', 'name');
        return $damageType5Array;
    }

    public function getDamageType6value()
    {
        /* Seats */
        $damageType6List = [
                        ['id' => 'Safe', 'name' => 'Safe'],
                        ['id' => 'Scratch', 'name' => 'Scratch'],
                        ['id' => 'Average', 'name' => 'Average'],
                        ['id' => 'Damaged', 'name' => 'Damaged'],
                        ['id' => 'Not Fitted', 'name' => 'Not Fitted'],
                        ['id' => 'Rusted', 'name' => 'Rusted'],
                        ['id' => 'NA', 'name' => 'NA'],
                       ];
        $damageType6Array = ArrayHelper::map($damageType6List, 'id', 'name');
        return $damageType6Array;
    }

    public function getDamageType7value()
    {
        /* Tyres */
        $damageType7List = [
                        ['id' => 'Safe', 'name' => 'Safe'],
                        ['id' => 'Average', 'name' => 'Average'],
                        ['id' => 'Poor', 'name' => 'Poor'],
                        ['id' => 'Damaged', 'name' => 'Damaged'],
                        ['id' => 'Not Fitted', 'name' => 'Not Fitted'],
                        ['id' => 'Rusted', 'name' => 'Rusted'],
                        ['id' => 'Torn', 'name' => 'Torn'],
                        ['id' => 'NA', 'name' => 'NA'],
                       ];
        $damageType7Array = ArrayHelper::map($damageType7List, 'id', 'name');
        return $damageType7Array;
    }

    public function getDamageType8value()
    {
        /* Spare Tyre */
        $damageType8List = [
                        ['id' => 'Safe', 'name' => 'Safe'],
                        ['id' => 'Average', 'name' => 'Average'],
                        ['id' => 'Scratch', 'name' => 'Scratch'],
                        ['id' => 'Not Fitted', 'name' => 'Not Fitted'],
                        ['id' => 'Damaged', 'name' => 'Damaged'],
                        ['id' => 'Rusted', 'name' => 'Rusted'],
                        ['id' => 'Torn', 'name' => 'Torn'],
                        ['id' => 'NA', 'name' => 'NA'],
                       ];
        $damageType8Array = ArrayHelper::map($damageType8List, 'id', 'name');
        return $damageType8Array;
    }

    public function getDamageType9value()
    {
        /* Head Lights, indicator lights, Tail Lamps  */
        $damageType9List = [
                        ['id' => 'Safe', 'name' => 'Safe'],
                        ['id' => 'Crack', 'name' => 'Crack'],
                        ['id' => 'Scratch', 'name' => 'Scratch'],
                        ['id' => 'Dented', 'name' => 'Dented'],
                        ['id' => 'Broken', 'name' => 'Broken'],
                        ['id' => 'Rusted', 'name' => 'Rusted'],
                        ['id' => 'Torn', 'name' => 'Torn'],
                        ['id' => 'Not Fitted', 'name' => 'Not Fitted'],
                        ['id' => 'Chipped Off', 'name' => 'Chipped Off'],
                        ['id' => 'NA', 'name' => 'NA'],
                       ];
        $damageType9Array = ArrayHelper::map($damageType9List, 'id', 'name');
        return $damageType9Array;
    }

    public function getDamageType10value()
    {
        /* Doors  */
        $damageType10List = [
                        ['id' => 'Safe', 'name' => 'Safe'],
                        ['id' => 'Crack', 'name' => 'Crack'],
                        ['id' => 'Scratch', 'name' => 'Scratch'],
                        ['id' => 'Dented', 'name' => 'Dented'],
                        ['id' => 'Broken', 'name' => 'Broken'],
                        ['id' => 'Not Fitted', 'name' => 'Not Fitted'],
                        ['id' => 'Chipped Off', 'name' => 'Chipped Off'],
                        ['id' => 'Torn', 'name' => 'Torn'],
                        ['id' => 'NA', 'name' => 'NA'],
                       ];
        $damageType10Array = ArrayHelper::map($damageType10List, 'id', 'name');
        return $damageType10Array;
    }

    public function getDamageType11value()
    {
        /* W.S. Glass  */
        $damageType11List = [
                        ['id' => 'Safe', 'name' => 'Safe'],
                        ['id' => 'Crack', 'name' => 'Crack'],
                        ['id' => 'Scratch', 'name' => 'Scratch'],
                        ['id' => 'Wiper Scratch', 'name' => 'Wiper Scratch'],
                        ['id' => 'Dented', 'name' => 'Dented'],
                        ['id' => 'Broken', 'name' => 'Broken'],
                        ['id' => 'Rusted', 'name' => 'Rusted'],
                        ['id' => 'Torn', 'name' => 'Torn'],
                        ['id' => 'Scar', 'name' => 'Scar'],
                        ['id' => 'Not Fitted', 'name' => 'Not Fitted'],
                        ['id' => 'Chipped Off', 'name' => 'Chipped Off'],
                        ['id' => 'NA', 'name' => 'NA'],
                       ];
        $damageType11Array = ArrayHelper::map($damageType11List, 'id', 'name');
        return $damageType11Array;
    }

    public function getDamageType12value()
    {
        /* Left Window Glass  */
        $damageType12List = [
                        ['id' => 'Safe', 'name' => 'Safe'],
                        ['id' => 'Crack', 'name' => 'Crack'],
                        ['id' => 'Scratch', 'name' => 'Scratch'],
                        ['id' => 'Broken', 'name' => 'Broken'],
                        ['id' => 'Not Fitted', 'name' => 'Not Fitted'],
                        ['id' => 'NA', 'name' => 'NA'],
                       ];
        $damageType12Array = ArrayHelper::map($damageType12List, 'id', 'name');
        return $damageType12Array;
    }

    public function getDamageType13value()
    {
        /* Right Window Glass  */
        $damageType13List = [
                        ['id' => 'Safe', 'name' => 'Safe'],
                        ['id' => 'Crack', 'name' => 'Crack'],
                        ['id' => 'Scratch', 'name' => 'Scratch'],
                        ['id' => 'Dented', 'name' => 'Dented'],
                        ['id' => 'Broken', 'name' => 'Broken'],
                        ['id' => 'Not Fitted', 'name' => 'Not Fitted'],
                        ['id' => 'NA', 'name' => 'NA'],
                       ];
        $damageType13Array = ArrayHelper::map($damageType13List, 'id', 'name');
        return $damageType13Array;
    }

    public function getDamageType14value()
    {
        /* Back Glass  */
        $damageType14List = [
                        ['id' => 'Safe', 'name' => 'Safe'],
                        ['id' => 'Wiper Scratch', 'name' => 'Wiper Scratch'],
                        ['id' => 'Broken', 'name' => 'Broken'],
                        ['id' => 'Not Fitted', 'name' => 'Not Fitted'],
                        ['id' => 'Chipped Off', 'name' => 'Chipped Off'],
                        ['id' => 'NA', 'name' => 'NA'],
                       ];
        $damageType14Array = ArrayHelper::map($damageType14List, 'id', 'name');
        return $damageType14Array;
    }

    public function getDamageType15value()
    {
        /* Excavator Cabin Glass, Crane Cabin Glass, Rear View Mirrors  */
        $list = [
                        ['id' => 'Safe', 'name' => 'Safe'],
                        ['id' => 'Broken', 'name' => 'Broken'],
                        ['id' => 'Not Fitted', 'name' => 'Not Fitted'],
                        ['id' => 'Chipped Off', 'name' => 'Chipped Off'],
                        ['id' => 'NA', 'name' => 'NA'],
                       ];
        $array = ArrayHelper::map($list, 'id', 'name');
        return $array;
    }

    public function getDamageType16value()
    {
        /*Fuel Tank  */
        $list = [
                        ['id' => 'Safe', 'name' => 'Safe'],
                        ['id' => 'Scratch', 'name' => 'Scratch'],
                        ['id' => 'Dented', 'name' => 'Dented'],
                        ['id' => 'Broken', 'name' => 'Broken'],
                        ['id' => 'Damaged', 'name' => 'Damaged'],
                        ['id' => 'Rusted', 'name' => 'Rusted'],
                        ['id' => 'Torn', 'name' => 'Torn'],
                        ['id' => 'Spot Dent', 'name' => 'Spot Dent'],
                        ['id' => 'Pressed', 'name' => 'Pressed'],
                        ['id' => 'Not Fitted', 'name' => 'Not Fitted'],
                        ['id' => 'NA', 'name' => 'NA'],
                       ];
        $array = ArrayHelper::map($list, 'id', 'name');
        return $array;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'preinspection_id' => 'Preinspection ID',
            'odometerReading' => 'Odometer Reading',
            'rcVerified' => 'Rc Verified',
            'typeOfBody' => 'Type Of Body',
            'fuelType' => 'Fuel Type',
            'cabin' => 'Cabin',
            'dashBoard' => 'Dash Board',
            'frontSideBody' => 'Front Side Body',
            'rearSideBody' => 'Rear Side Body',
            'rightSideBody' => 'Right Side Body',
            'leftSideBody' => 'Left Side Body',
            'frontExcavator' => 'Front Excavator',
            'bonnet' => 'Bonnet',
            'craneBucket' => 'Crane Bucket',
            'craneHook' => 'Crane Hook',
            'ac' => 'AC',
            'boom' => 'Boom',
            'fans' => 'Fans',
            'hydrualicSystem' => 'Hydrualic System',
            'chassisFrame' => 'Chassis Frame',
            'fuelTank' => 'Fuel Tank',
            'seats' => 'Seats',
            'tyres' => 'Tyres',
            'spareTyre' => 'Spare Tyre',
            'headLights' => 'Head Lights',
            'indicatorLights' => 'Indicator Lights',
            'doors' => 'Doors',
            'wsGlass' => 'W.S. Glass',
            'leftWindowGlass' => 'Left Window Glass',
            'rightWindowGlass' => 'Right Window Glass',
            'backGlass' => 'Back Glass',
            'excavatorCabinGlass' => 'Excavator Cabin Glass',
            'craneCabinGlass' => 'Crane Cabin Glass',
            'rearViewMirrors' => 'Rear View Mirrors',
            'tailLamps' => 'Tail Lamps',
            'extraFittings' => 'Extra Fittings',
            'created_on' => 'Created On',
        ];
    }
}
