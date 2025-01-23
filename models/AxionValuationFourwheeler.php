<?php

namespace app\models;
use yii\helpers\ArrayHelper;

use Yii;

/**
 * This is the model class for table "axion_valuation_fourwheeler".
 *
 * @property integer $id
 * @property integer $preinspection_id
 * @property string $colour
 * @property string $odometerReading
 * @property string $rcVerified
 * @property string $fuelType
 * @property string $cubicCapacity
 * @property string $centerLock
 * @property string $frontBumperBonnet
 * @property string $paint
 * @property string $paintCondition
 * @property string $rhFenderDoors
 * @property string $lhFenderDoors
 * @property string $chassisCondition
 * @property string $indicatorLight
 * @property string $frontPanel
 * @property string $bonnet
 * @property string $leftApron
 * @property string $rightApron
 * @property string $dicky
 * @property string $rearBumperBonnet
 * @property string $transmission
 * @property string $transmissionCondition
 * @property string $absDrop
 * @property string $airBags
 * @property string $alloyWheels
 * @property string $cruiseControl
 * @property string $esp
 * @property string $airCondition
 * @property string $ltFrontFender
 * @property string $ltFrontDoor
 * @property string $ltRearDoor
 * @property string $ltRunningBoard
 * @property string $ltRear
 * @property string $ltQtrPanel
 * @property string $rtQtrPanel
 * @property string $rtRearDoor
 * @property string $rtFrontDoor
 * @property string $rtFrontPillar
 * @property string $rtRear
 * @property string $steering
 * @property string $vehicleType
 * @property string $interierAccessories
 * @property string $chassisAndVehicleFrame
 * @property string $starterMotor
 * @property string $brakes
 * @property string $suspension
 * @property string $rtRunningBoard
 * @property string $rtFrontFender
 * @property string $tyreCondition
 * @property string $noOfTyre
 * @property string $rcOwnerName
 * @property string $batteryCondition
 * @property string $engineCondition
 * @property string $taxValidity
 * @property string $alternator
 * @property string $ignitionAndFuelSystem
 * @property string $seats
 * @property string $seatsCondition
 * @property string $powerWindows
 * @property string $rcStatus
 * @property string $vehicleCondition
 * @property string $noOfOwners
 * @property string $insuranceType
 * @property string $fcValidity
 * @property string $insuranceDate
 * @property string $hpaStatus
 * @property string $hpaBank
 * @property integer $hpa
 * @property string $headLampAndTailLamp
 * @property string $vehicleParkingLocation
 * @property string $ltRearTyre
 * @property string $ltFrontTyre
 * @property string $rtRearTyre
 * @property string $rtFrontTyre
 * @property string $windshield
 * @property string $windshieldGlassCondition
 * @property string $underCarriage
 * @property string $created_on
 * @property integer $systemGeneratedMarketValue
 * @property string $fixedMarketValue
 * @property integer $finalRating
 * @property string $totalWeightage

 */
class AxionValuationFourwheeler extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'axion_valuation_fourwheeler';
    }

// SELECT sum(paintCondition)+sum(seatsCondition)+sum(vehicleCondition)+sum(chassisAndVehicleFrame)+sum(airCondition)+sum(headLampAndTailLamp)+sum(frontBumperBonnet)+sum(rearBumperBonnet)+sum(rhFenderDoors)+sum(lhFenderDoors)+sum(engineCondition)+sum(chassisCondition)+sum(brakes)+sum(suspension)+sum(transmissionCondition)+sum(interierAccessories)+sum(seatsCondition)+sum(batteryCondition) as finalRating from axion_preinspection_fourwheeler WHERE preinspection_id ='37'



    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['preinspection_id'], 'required'],
            [['preinspection_id','hpa','systemGeneratedMarketValue','finalRating'], 'integer'],
            [['created_on'], 'safe'],
            [['colour', 'odometerReading', 'rcVerified', 'fuelType', 'cubicCapacity', 'centerLock', 'frontBumperBonnet', 'paint', 'paintCondition', 'rhFenderDoors', 'lhFenderDoors', 'indicatorLight', 'frontPanel', 'bonnet', 'leftApron', 'rightApron', 'dicky', 'rearBumperBonnet', 'transmission', 'transmissionCondition','absDrop', 'airBags', 'alloyWheels', 'esp', 'cruiseControl', 'airCondition', 'ltFrontFender', 'ltFrontDoor', 'ltRearDoor', 'ltRunningBoard', 'ltRear', 'ltQtrPanel', 'rtQtrPanel', 'rtRearDoor', 'rtFrontDoor', 'rtFrontPillar','rtRear', 'steering', 'vehicleType', 'interierAccessories', 'chassisAndVehicleFrame', 'starterMotor', 'brakes', 'suspension', 'rtRunningBoard', 'rtFrontFender', 'tyreCondition', 'noOfTyre', 'rcOwnerName', 'batteryCondition', 'engineCondition', 'taxValidity', 'alternator', 'ignitionAndFuelSystem', 'seats', 'seatsCondition', 'powerWindows', 'rcStatus', 'vehicleCondition', 'noOfOwners', 'insuranceType', 'fcValidity', 'insuranceDate', 'chassisCondition','headLampAndTailLamp', 'hpaStatus', 'hpaBank','vehicleParkingLocation', 'ltRearTyre', 'ltFrontTyre', 'rtRearTyre', 'rtFrontTyre', 'windShield', 'windshieldGlassCondition', 'underCarriage','fixedMarketValue','totalWeightage'], 'string', 'max' => 50],
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


public function getVTypeValue()
{
   $VTypeList = [

    ['id' => 'Taxi', 'name' => 'Taxi'],
    ['id' => 'Private', 'name' => 'Private'],

    ];

    $VTypeArray = ArrayHelper::map($VTypeList, 'id', 'name');
    return $VTypeArray;
}




    
public function getBagsValue()
{
   $bagsList = [

    ['id' => 'yes', 'name' => 'Yes'],
    ['id' => 'no', 'name' => 'No'],

    ];

    $bagsArray = ArrayHelper::map($bagsList, 'id', 'name');
    return $bagsArray;
}


public function getInsuranceValue()
{
   $insuranceList = [

    ['id' => 'na', 'name' => 'NA'],
    ['id' => 'company', 'name' => 'Company'],
    ['id' => 'third-party', 'name' => 'Third-party'],

    ];

    $insuranceArray = ArrayHelper::map($insuranceList, 'id', 'name');
    return $insuranceArray;
}

public function getVehicleparkinglocationValue()
{
    $vehicleParkingLocationList = [
          ['id' => 'Yard', 'name' => 'Yard'],
          ['id' => 'PoliceSt', 'name' => 'PoliceSt'],
          ['id' => 'RTO', 'name' => 'RTO'],
          ['id' => 'Highway', 'name' => 'Highway'],
          ['id' => 'CarShowroom', 'name' => 'CarShowroom'],
        ['id' => 'ServiceStation', 'name' => 'ServiceStation'],
          ['id' => 'Others', 'name' => 'Others'],

    ];
    $vehicleParkingLocationArray = ArrayHelper::map($vehicleParkingLocationList, 'id', 'name');
    return $vehicleParkingLocationArray;
}

// public function withFinalRating()
// {
//     $this->getDbCriteria()->mergeWith(array(
//         'with'=>array(
//             'paintCondition',
//             'frontBumperBonnet',
//         ),
//         'select'=>'*, sum(projectcost.Percent*cost.Value) as adjustedCost',
//     ));

//     return $this;
// }


public function getseatsValue()
{
   $seatsList = [

    ['id' => '1', 'name' => '1'],
    ['id' => '2', 'name' => '2'],
    ['id' => '3', 'name' => '3'],
    ['id' => '4', 'name' => '4'],
    ['id' => '5', 'name' => '5'],
    ['id' => '6', 'name' => '6'],
    ['id' => '7', 'name' => '7'],
    ['id' => '8', 'name' => '8'],
    ['id' => '9', 'name' => '9'],
    ['id' => '10', 'name' => '10'],
    ['id' => '11', 'name' => '11'],
    ['id' => '12', 'name' => '12'],
    ['id' => '13', 'name' => '13'],
    ['id' => '14', 'name' => '14'],
    ['id' => '15', 'name' => '15'],
    ['id' => '16', 'name' => '16'],
    ['id' => '17', 'name' => '17'],
    ['id' => '18', 'name' => '18'],
    ['id' => '19', 'name' => '19'],
    ['id' => '20', 'name' => '20'],
    ];

    $seatsArray = ArrayHelper::map($seatsList, 'id', 'name');
    return $seatsArray;
}



public function getPaintValue()
    {
        $paintList= [
                ['id' => '', 'name' => '-Select-'],  
                ['id' => 'original', 'name' => 'Original'],
                ['id' => 're-paint', 'name' => 'Re-Paint'],
              
              ];
        $paintArray = ArrayHelper::map($paintList, 'id', 'name');
        return $paintArray;
    }

    public function getRcstatusValue()
    {
        $rcstatusList= [
                ['id' => '', 'name' => '-Select-'],  
                ['id' => 'original', 'name' => 'Original'],
                ['id' => 'xerox', 'name' => 'Xerox'],
                ['id' => 'na', 'name' => 'NA'],
              
              ];
        $rcstatusArray = ArrayHelper::map($rcstatusList, 'id', 'name');
        return $rcstatusArray;
    }

    public function getTransmissionValue()
    {
        $transmissionList =[
            ['id' => '', 'name' => '-Select-'],
            ['id' => 'manual', 'name' => 'Manual'],
            ['id' => 'automatic', 'name' => 'Automatic'],
            ['id' => 'amt', 'name' => 'AMT'],
        ];

    $transmissionArray = ArrayHelper::map($transmissionList, 'id', 'name');
     return $transmissionArray;
    }




    public function getltRearValue()
    {
        $ltrearList =[
              // ['id' => '', 'name' => '-Select-'],
              ['id' => '1', 'name' => 'Average'],
              ['id' => '3', 'name' => 'Excellent'],
              ['id' => '2', 'name' => 'Good'],
             
              ['id' => '-1', 'name' => 'Bad'],
              ['id' => '-2', 'name' => 'VeryBad'],
              ['id' => '-3', 'name' => 'NA'],        
        ];

     $ltrearArray = ArrayHelper::map($ltrearList, 'id', 'name');
        return $ltrearArray;
    }

     public function getTyreconditionValue()
    {
        $tyreconditionList =[
              // ['id' => '', 'name' => '-Select-'],
              ['id' => '-3', 'name' => 'NA'],
              ['id' => '-1', 'name' => 'Bad'],
              ['id' => '1', 'name' => 'Average'],
              ['id' => '2', 'name' => 'Good'],
              ['id' => '3', 'name' => 'Excellent'],    
        ];

 $tyreconditionArray = ArrayHelper::map($tyreconditionList, 'id', 'name');
        return $tyreconditionArray;
    }


         public function getWeightageValue()
       {
    $weightageList =[
       ['id' => '0.25', 'name' => '-1'], //bad
       ['id' => '1.5' , 'name' => '1'],  //average
       ['id' => '0.15', 'name' => '2'],  //good
       ['id' => '0.1', 'name' => '2'],   //good
    ];
    $weightageArray = ArrayHelper::map($weightageList,'id','name');
    return $weightageArray;
    }

     public function getNoOftyreValue()
    {
        $noOftyreList =[
              // ['id' => '', 'name' => '-Select-'],
              ['id' => '1', 'name' => '1'],
              ['id' => '2', 'name' => '2'],
              ['id' => '3', 'name' => '3'],
              ['id' => '4', 'name' => '4'],
              ['id' => '5', 'name' => '5'],
              ['id' => '6', 'name' => '6'],
              ['id' => '7', 'name' => '7'],
        ];

 $noOftyreArray = ArrayHelper::map($noOftyreList, 'id', 'name');
        return $noOftyreArray;
    }
    

    public function getWindshieldValue()
    {
        $windshieldList =[
              // ['id' => '', 'name' => '-Select-'],
              ['id' => 'original', 'name' => 'Original'],
              ['id' => 're-fixed', 'name' => 'Re-fixed'],
                
        ];

 $windshieldArray = ArrayHelper::map($windshieldList, 'id', 'name');
        return $windshieldArray;
    }
    

    public function getQcStatusvalue()
    {
        $qcStatusList = [   
                        ['id' => '8', 'name' => 'Survey Done'],
                        ['id' => '101', 'name' => 'PI-Recommended'],
                        ['id' => '102', 'name' => 'PI-Not Recommended'],
                        ['id' => '104', 'name' => 'PI-Refer to Under Writer'],
                        ['id' => '200', 'name' => 'PI-Recommended'],
 
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

    public function getMonthValue()
    {
        $monthList = [
            ['id' => '', 'name' => '-Select-'],
           ['id' => '1', 'name' => 'January'],
           ['id' => '2', 'name' => 'February'],
           ['id' => '3', 'name' => 'March'],
           ['id' => '4', 'name' => 'April'],
           ['id' => '5', 'name' => 'May'],
           ['id' => '6', 'name' => 'June'],
           ['id' => '7', 'name' => 'July'],
           ['id' => '8', 'name' => 'August'],
           ['id' => '9', 'name' => 'September'],
           ['id' => '10', 'name' => 'October'],
           ['id' => '11', 'name' => 'November'],
           ['id' => '12', 'name' => 'December'],
        ];
        $monthArray = ArrayHelper::map($monthList,'id','name');
        return $monthArray;
    }

     public function getYearValue()
    {
        $yearList = [
            ['id' => '', 'name' => '-Select-'],
           ['id' => '2009', 'name' => '2009'],
           ['id' => '2010', 'name' => '2010'],
           ['id' => '2011', 'name' => '2011'],
           ['id' => '2012', 'name' => '2012'],
           ['id' => '2013', 'name' => '2013'],
           ['id' => '2014', 'name' => '2014'],
           ['id' => '2015', 'name' => '2015'],
           ['id' => '2016', 'name' => '2016'],
           ['id' => '2017', 'name' => '2017'],
           ['id' => '2018', 'name' => '2018'],
           ['id' => '2019', 'name' => '2019'],
           
        ];
        $yearArray = ArrayHelper::map($yearList,'id','name');
        return $yearArray;
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
            'airCondition' => 'Air Condition',
            'cubicCapacity' => 'Cubic Capacity',
            'centerLock' => 'Center Lock',
            'frontBumperBonnet' => 'Front Bumper Bonnet',
            'paint' => 'Paint',
            'paintCondition' => 'Paint Condition',
            'vehicleType' => 'Vehicle Type',
            'rhFenderDoors' => 'RH-Fender Doors',
            'lhFenderDoors' => 'LH-Fender Doors',
            'chassisCondition' => 'Chassis Condition',
            'indicatorLight' => 'Indicator Light',
            'frontPanel' => 'Front Panel',
            'bonnet' => 'Bonnet',
            'leftApron' => 'Left Apron',
            'rightApron' => 'Right Apron',
            'dicky' => 'Dicky',
            'rearBumperBonnet' => 'Rear Bumper Bonnet',
            'transmission' => 'Transmission',
            'transmissionCondition' => 'Transmission Condition',
            'ltFrontFender' => 'Lt Front Fender',
            'ltFrontDoor' => 'Lt Front Door',
            'ltRearDoor' => 'Lt Rear Door',
            'ltRunningBoard' => 'Lt Running Board',
            'ltRear' => 'Lt Rear',
            'ltQtrPanel' => 'Lt Qtr Panel',
            'rtQtrPanel' => 'Rt Qtr Panel',
            'rtRearDoor' => 'Rt Rear Door',
            'rtFrontDoor' => 'Rt Front Door',
            'rtRear' => 'Rt Rear',
            'steering' => 'Steering',
            'interierAccessories' => 'Interier / Accessories',
            'chassisAndVehicleFrame' => 'Chassis / Vehicle Frame',
            'starterMotor' => 'Starter Motor',
            'brakes' => 'Brakes Systems',
            'suspension' => 'Suspension',
            'rtRunningBoard' => 'Rt Running Board',
            'rtFrontFender' => 'Rt Front Fender',
            'tyreCondition' => 'Tyre Condition',
            'noOfTyre' => 'No Of Tyre',
            'rcOwnerName' => 'Rc Owner Name',
            'batteryCondition' => 'Battery Condition',
            'engineCondition' => 'Engine Condition',
            'taxValidity' => 'Tax Validity',
            'alternator' => 'Alternator',
            'ignitionAndFuelSystem' => 'Ignition / FuelSystem',
            'seats' => 'No Of Seats',
            'seatsCondition' => 'Seats Condition',
            'powerWindows' => 'Power Windows',
            'rcStatus' => 'Rc Status',
            'vehicleCondition' => 'Vehicle Condition',
            'noOfOwners' => 'Vehicle Ownership',
            'insuranceType' => 'Insurance Type',
            'fcValidity' => 'Fc Validity',
            'insuranceDate' => 'Insurance Date',
            'hpa' => 'HPA',
            'hpaStatus' => 'HPA Status',
            'hpaBank' => 'HPA Bank',
            'headLampAndTailLamp' => 'HeadLamp / TailLamp',
            'vehicleParkingLocation' => 'Valuation Location',
            // 'valuationPrice' => 'Valuation Price',
            'ltRearTyre' => 'Lt Rear Tyre',
            'ltFrontTyre' => 'Lt Front Tyre',
            'rtRearTyre' => 'Rt Rear Tyre',
            'rtFrontTyre' => 'Rt Front Tyre',
            'windShield' => 'Wind Shield',
            'windshieldGlassCondition' => 'windshieldGlassCondition',
            'underCarriage' => 'Under Carriage',
            'created_on' => 'Created On',
            'airBags' => 'AIR BAG',
            'systemGeneratedMarketValue' => 'System Market Value',
            'fixedMarketValue' => 'Final Market Value',
            'absDrop' => 'ABS',
            'syd1to5' => 'SYD1to5',
            'syd6to10' => 'SYD6to10',
            'month' => 'Month',
            'finalDepri' => 'finalDepri',
            'totalWeightage' => 'Total Weightage',
            'finalRating' => 'Final Rating',
            

        ];
    }
}
