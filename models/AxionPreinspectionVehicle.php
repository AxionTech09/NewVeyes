<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;


/**
 * This is the model class for table "axion_preinspection_vehicle".
 *
 * @property integer $id
 * @property integer $preinspection_id
 * @property string $colour
 * @property integer $odometerReading
 * @property string $rcVerified
 * @property string $fuelType
 * @property string $fuelTank
 * @property string $stereoMake
 * @property string $otherElectrical
 * @property string $frontBumper
 * @property string $rearBumper
 * @property string $bonnet
 * @property string $grill
 * @property string $headLights
 * @property string $indicatorLights
 * @property string $tailLamps
 * @property string $rearViewMirrors
 * @property string $tyres
 * @property string $spareTyre
 * @property string $dashBoard
 * @property string $seats
 * @property string $underCarriage
 * @property string $leftWindowGlass
 * @property string $frontwsGlassLaminated
 * @property string $rightWindowGlass
 * @property string $backGlass
 * @property string $vType
 * @property string $vehicleTypeRadio
 * @property string $created_on
 */
class AxionPreinspectionVehicle extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'axion_preinspection_vehicle';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['preinspection_id'], 'required'],
            [['preinspection_id','odometerReading','engineStatus'], 'integer'],
            [['created_on'], 'safe'],
            [['colour', 'rcVerified', 'fuelType', 'fuelTank', 'otherElectrical', 
              'stereoMake', 'frontBumper', 'rearBumper','grill', 'headLights', 'indicatorLights', 
              'bonnet', 'rearBumper', 'tailLamps','rearViewMirrors', 'tyres', 'spareTyre', 'dashBoard',
              'seats', 'leftWindowGlass', 'backGlass', 'frontwsGlassLaminated', 'underCarriage',
              'rightWindowGlass','vehicleTypeRadio'], 'string', 'max' => 50],
              [['vCategory', 'vType'], 'string', 'max' => 255],
              [['odometerReading','rcVerified','fuelType','rightWindowGlass','leftWindowGlass','frontwsGlassLaminated','backGlass','engineStatus', 'vType'],'required','on' => 'vehicleqc']
            // [['vType'], 'required', 'when' => function($model) {
            //   return $model->vType == 'Select';}],
            
   
        ];
    }

    public function getRcValue()
    {
        $rcList= [
                ['id' => '', 'name' => '-Select-'],  
                ['id' => 'RcParticulars', 'name' => 'Rc Particulars'],
                ['id' => 'Original', 'name' => 'Yes - Original'],
                ['id' => 'Photocopy', 'name' => 'Yes - Photocopy'],
                ['id' => 'Invoice', 'name' => 'Invoice'],
                ['id' => 'No', 'name' => 'No'],
              ];
        $rcArray = ArrayHelper::map($rcList, 'id', 'name');
        return $rcArray;
    }
    
 


    public function getGlassTypevalue()
    {
        $glassTypeList = [
                        ['id' => '', 'name' => 'Select'],
                        ['id' => 'Intact', 'name' => 'Intact'],
                        ['id' => 'Crack', 'name' => 'Crack'],   
                        ['id' => 'Scratch', 'name' => 'Scratch'],
                        ['id' => 'Dented', 'name' => 'Dented'],
                        ['id' => 'Broken', 'name' => 'Broken'],
                        ['id' => 'Scar', 'name' => 'Scar'], 
                        ['id' => 'Not Fitted', 'name' => 'Not Fitted'],
                        ['id' => 'Wiper Scratch', 'name' => 'Wiper Scratch'],
                        ['id' => 'Chiped Off', 'name' => 'Chiped Off'],
                        ['id' => 'NA', 'name' => 'NA'],
                       ];
        $glassTypeArray = ArrayHelper::map($glassTypeList, 'id', 'name');
        return $glassTypeArray;
    }


    public function getUnderCarriage()
    {
        $glassTypeList = [
                        ['id' => '', 'name' => 'Select'],
                        ['id' => 'Safe', 'name' => 'Safe'],
                        ['id' => 'Crack', 'name' => 'Crack'],   
                        ['id' => 'Scratch', 'name' => 'Scratch'],
                        ['id' => 'Dented', 'name' => 'Dented'],
                        ['id' => 'Broken', 'name' => 'Broken'],
                        ['id' => 'Scar', 'name' => 'Scar'], 
                        ['id' => 'Not Fitted', 'name' => 'Not Fitted'],
                        ['id' => 'Rusted', 'name' => 'Rusted'],
                        ['id' => 'Wiper Scratch', 'name' => 'Wiper Scratch'],
                        ['id' => 'Chiped Off', 'name' => 'Chiped Off'],
                        ['id' => 'NA', 'name' => 'NA'],
                       ];
        $glassTypeArray = ArrayHelper::map($glassTypeList, 'id', 'name');
        return $glassTypeArray;
    }
    
    
    
    public function getGlassType1value()
    {
        $glassType1List = [
                        ['id' => 'Safe', 'name' => 'Safe'],
                        ['id' => 'Intact', 'name' => 'Intact'],
                        ['id' => 'Crack', 'name' => 'Crack'],   
                        ['id' => 'Scratch', 'name' => 'Scratch'],
                        ['id' => 'Dented', 'name' => 'Dented'],
                        ['id' => 'Broken', 'name' => 'Broken'],
                        ['id' => 'Scar', 'name' => 'Scar'], 
                        ['id' => 'Not Fitted', 'name' => 'Not Fitted'],
                        ['id' => 'Wiper Scratch', 'name' => 'Wiper Scratch'],
                        ['id' => 'Chiped Off', 'name' => 'Chiped Off'],
                        ['id' => 'NA', 'name' => 'NA'],
                       ];
        $glassType1Array = ArrayHelper::map($glassType1List, 'id', 'name');
        return $glassType1Array;
    }
    



    public function getQcStatusValue()
    {
        $qcStatusList = [   
                        ['id' => '101', 'name' => 'PI-Recommended'],
                        ['id' => '8', 'name' => 'Survey Done'],
                        ['id' => '102', 'name' => 'PI-Not Recommended'],
                        ['id' => '104', 'name' => 'PI-Refer to Under Writer'],
                       ];
        $qcStatusArray = ArrayHelper::map($qcStatusList, 'id', 'name');
        return $qcStatusArray;
    }

    public function getSpareTyrevalue()
    {
        $spareTyreList = [
                  
                        ['id' => 'Safe', 'name' => 'Safe'],  
                        ['id' => 'Average', 'name' => 'Average'],
                        ['id' => 'Poor', 'name' => 'Poor'],
                        ['id' => 'Torn', 'name' => 'Torn'],
                        ['id' => 'Not Fitted', 'name' => 'Not Fitted'],                  
                        ['id' => 'NA', 'name' => 'NA'],
                       ];
        $spareTyreArray = ArrayHelper::map($spareTyreList, 'id', 'name');
        return $spareTyreArray;
    }

    public function getTyrevalue()
    {
        $TyreList = [
                  
                        ['id' => 'Safe', 'name' => 'Safe'],  
                        ['id' => 'Average', 'name' => 'Average'],
                        ['id' => 'Torn', 'name' => 'Torn'],
                        ['id' => 'Fitted', 'name' => 'Fitted'],
                        ['id' => 'Not Fitted', 'name' => 'Not Fitted'],                  
                        ['id' => 'NA', 'name' => 'NA'],
                    ];
        $TyreArray = ArrayHelper::map($TyreList, 'id', 'name');
        return $TyreArray;
    }

    public function getFuelTankvalue()
    {
        $fuelTankList = [
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
        $fuelTankArray = ArrayHelper::map($fuelTankList, 'id', 'name');
        return $fuelTankArray;
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
                        ['id' => 'LPG(Diesel)', 'name' => 'LPG(Diesel)'],
                        ['id' => 'HYBRID(Petrol)', 'name' => 'HYBRID(Petrol)'],
                        ['id' => 'HYBRID(Diesel)', 'name' => 'HYBRID(Diesel)'],
                        ['id' => 'Electric', 'name' => 'Electric'],
                       ];
        $fuelTypeArray = ArrayHelper::map($fuelTypeList, 'id', 'name');
        return $fuelTypeArray;
    }

    public function getRsFuelTypevalue()
    {
        $fuelTypeList = [
            ['id' => '', 'name' => '-Select-'],
            ['id' => 'Diesel', 'name' => 'Diesel'],
            ['id' => 'Petrol', 'name' => 'Petrol'],   
            ['id' => 'CNG', 'name' => 'CNG'],
            ['id' => 'Electric', 'name' => 'Electric'],
            ['id' => 'Bi-fuel', 'name' => 'Bi-fuel'],
        ];
        $fuelTypeArray = ArrayHelper::map($fuelTypeList, 'id', 'name');
        return $fuelTypeArray;
    }

    public function getVehicleCategoryvalue()
    {
        $vehicleCategoryList= [
            ['id' => '', 'name' => '-Select-'],
            ['id' => 'Passenger Carrying Vehicle', 'name' => 'Passenger Carrying Vehicle'],
            ['id' => 'Goods Carrying Vehicle', 'name' => 'Goods Carrying Vehicle'],
            ['id' => 'Miscellaneous Vehicle', 'name' => 'Miscellaneous Vehicle'],
            //['id' => 'Add On Cover', 'name' => 'Add On Cover'],
        ];
        $vehicleCategoryArray = ArrayHelper::map($vehicleCategoryList, 'id', 'name');
        return $vehicleCategoryArray;
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
            'odometerReading' => 'Odometer Reading*',
            'rcVerified' => 'Rc Verified*',
            'fuelType' => 'Fuel Type*',
            'fuelTank' => 'Fuel Tank',
            'engineStatus'=>'Engine Condition*',
            'otherElectrical' => 'Other Electrical',
            'stereoMake' => 'Stereo Make',
            'frontBumper' => 'Front Bumper',
            'grill' => 'Grill',
            'indicatorLights' => 'Indicator Light',
            'frontPanel' => 'Front Panel',
            'bonnet' => 'Bonnet',
            'headLights' => 'Head Lights',
            'rearBumper' => 'Rear Bumper',
            'tailLamps' => 'Tail Lamp',
            'rearViewMirrors' => 'Rear View Mirrors',
            'tyres' => 'Tyres',
            'spareTyre' => 'spare Tyre',
            'dashBoard' => 'Dashboard',
            'seats' => 'Seats',
            'backGlass' => 'Back Glass*',
            'frontwsGlassLaminated' => 'Frontws Glass Laminated*',
            'underCarriage' => 'Under Carriage',
            'leftWindowGlass' => 'Left Window Glass*',
            'rightWindowGlass' => 'Right Window Glass*',
            'vType' => 'Vehicle*',
            'vehicleTypeRadio' => 'Type*',
            'vCategory' => 'Vehicle Category*',
            'created_on' => 'Created On',
        ];
    }
}
