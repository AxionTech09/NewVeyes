<?php

namespace app\models;
use yii\helpers\ArrayHelper;

use Yii;

/**
 * This is the model class for table "axion_valuation_commercial".
 *
 * @property integer $id
 * @property integer $preinspection_id
 * @property string $odometerReading
 * @property string $rcVerified
 * @property string $bodyType
 * @property string $fuelType
 * @property string $cabin
 * @property string $interior
 * @property string $frontCabin
 * @property string $rear
 * @property string $cabinDoorRight
 * @property string $cabinDoorLeft
 * @property string $paint
 * @property string $bonnet
 * @property string $transmissionCondition
 * @property string $cluthCondition
 * @property string $headLampTailLamp
 * @property string $ac
 * @property string $abs
 * @property string $hpa
 * @property string $paintCondition
 * @property string $roadPermit
 * @property string $taxValidity
 * @property string $fcValidity
 * @property string $liftAxile
 * @property string $batteryCondition
 * @property string $fans
 * @property string $engineOilLeaks
 * @property string $chassisCondition
 * @property string $engineCondition
 * @property string $axleConfiguration
 * @property string $brakes
 * @property string $differentialCondition
 * @property string $fuelTank
 * @property string $suspension
 * @property string $noOfSeats
 * @property string $dieselPump
 * @property string $seatsCondition
 * @property string $noOfTyre
 * @property string $spareTyre
 * @property string $headLights
 * @property string $indicatorLights
 * @property string $axleCondition
 * @property string $steering
 * @property string $cubicCapacity
 * @property string $leftWindowGlass
 * @property string $rightWindowGlass
 * @property string $windShield
 * @property string $loadFloor
 * @property string $leftBodyCondition
 * @property string $rightBodyCondition
 * @property string $tailGate
 * @property string $hpaBank
 * @property string $tyreCondition
 * @property string $vehicleTonnage
 * @property string $insuranceType
 * @property string $vehicleOwnership
 * @property string $vehicleCondition
 * @property string $overAllLoadBody
 * @property string $rcOwnerName
 * @property string $insuranceDate
 * @property string $created_on
 * @property string $vehicleParkingLocation
 * @property string $systemGeneratedMarketValue
 * @property string $fixedMarketValue
 * @property string $finalRating
 * @property string $totalWeightage
 */
class AxionValuationCommercial extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'axion_valuation_commercial';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['preinspection_id'], 'required'],
            [['preinspection_id'], 'integer'],
            [['created_on','roadPermit','insuranceDate','systemGeneratedMarketValue','fixedMarketValue','totalWeightage','finalRating'], 'safe'],
            [['odometerReading', 'rcVerified', 'bodyType', 'fuelType', 'cabin', 'interior', 'frontCabin', 
              'rear', 'cabinDoorRight', 'cabinDoorLeft', 'paint', 'bonnet', 'transmissionCondition', 
              'headLampTailLamp', 'ac', 'fans', 'engineOilLeaks', 'chassisCondition', 'steering', 
              'dieselPump', 'noOfSeats', 'noOfTyre', 'spareTyre', 'headLights', 'indicatorLights', 
              'axleCondition', 'wsGlass', 'leftWindowGlass', 'rightWindowGlass', 'windShield', 'loadFloor', 
              'tailGate', 'tyreCondition', 'hpaBank', 'cluthCondition', 'vehicleTonnage','cubicCapacity', 
              'overAllLoadBody', 'abs', 'liftAxile', 'leftBodyCondition','rightBodyCondition', 
              'batteryCondition', 'axleConfiguration', 'engineCondition','brakes', 'differentialCondition',
              'taxValidity','fcValidity','suspension','seatsCondition','vehicleOwnership','vehicleCondition','hpa','paintCondition','insuranceType','rcOwnerName','vehicleParkingLocation'], 'string', 'max' => 50],
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

    public function getLoadBodyBuildValue()
    { 
        $LoadBodyBuildList = [
         ['id' => 'Fully Built Vehicle', 'name' => 'Fully Built Vehicle'],
         ['id' => 'Cabin & Chasis', 'name' => 'Cabin & Chasis'],
          ['id' => 'High Side Deck', 'name' => 'High Side Deck'],
              ['id' => 'Truck Tractor', 'name' => 'Truck Tractor'],
            ['id' => 'Flat Bed Trailer', 'name' => 'Flat Bed Trailer'],
                       ];
$LoadBodyBuildArray = ArrayHelper::map($LoadBodyBuildList, 'id', 'name');
        return $LoadBodyBuildArray;

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

public function getAbsValue()
{
   $AbsList = [

    ['id' => 'yes', 'name' => 'Yes'],
    ['id' => 'no', 'name' => 'No'],

    ];

    $AbsArray = ArrayHelper::map($AbsList, 'id', 'name');
    return $AbsArray;
}


public function getInsuranceTypeValue()
{
   $InsuranceTypeList = [

    ['id' => 'Company', 'name' => 'Company'],
    ['id' => 'ThirdParty', 'name' => 'ThirdParty'],
    ['id' => 'NA', 'name' => 'NA'],
    ];

    $InsuranceTypeArray = ArrayHelper::map($InsuranceTypeList, 'id', 'name');
    return $InsuranceTypeArray;
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


public function getWsValue()
    {
        $WsList= [
                ['id' => '', 'name' => '-Select-'],  
                ['id' => 'original', 'name' => 'Original'],
                ['id' => 're-fixed', 'name' => 'Re-Fixed'],
              
              ];
        $WsArray = ArrayHelper::map($WsList, 'id', 'name');
        return $WsArray;
    }


public function getSteeringValue()
    {
        $SteeringList= [
                ['id' => '', 'name' => '-Select-'],  
                ['id' => 'manual', 'name' => 'Manual'],
                ['id' => 'power', 'name' => 'Power'],
              
              ];
        $SteeringArray = ArrayHelper::map($SteeringList, 'id', 'name');
        return $SteeringArray;
    }



public function getAxleValue()
    {
        $AxleList =[
              // ['id' => '', 'name' => '-Select-'],
              ['id' => '4x2', 'name' => '4x2'],
              ['id' => '6x4', 'name' => '6x4'],
              ['id' => '8x4', 'name' => '8x4'],
              ['id' => '4x4', 'name' => '4x4'],
              ['id' => '6x2', 'name' => '6x2'],
              ['id' => '8x2', 'name' => '8x2'],        
        ];

        $AxleArray = ArrayHelper::map($AxleList, 'id', 'name');
        return $AxleArray;
    }

public function getSeatsValue()
{
   $SeatsList = [

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

    $SeatsArray = ArrayHelper::map($SeatsList, 'id', 'name');
    return $SeatsArray;
}


public function getVPLocationValue()
{
    $VPLocationList = [
          ['id' => 'Yard', 'name' => 'Yard'],
          ['id' => 'PoliceSt', 'name' => 'PoliceSt'],
           ['id' => 'RTO', 'name' => 'RTO'],
          ['id' => 'Highway', 'name' => 'Highway'],
          ['id' => 'CarShowroom', 'name' => 'CarShowroom'],
           ['id' => 'ServiceStation', 'name' => 'ServiceStation'],
          ['id' => 'Others', 'name' => 'Others'],

    ];
    $VPLocationArray = ArrayHelper::map($VPLocationList, 'id', 'name');
    return $VPLocationArray;
}



 public function getNoOfOwnersValue()
    {
        $noOfOwnersList =[
              // ['id' => '', 'name' => '-Select-'],
              ['id' => '1', 'name' => '1'],
              ['id' => '2', 'name' => '2'],
              ['id' => '3', 'name' => '3'],
              ['id' => '4', 'name' => '4'],
              ['id' => '5', 'name' => '5'],
              
        ];

 $noOfOwnersArray = ArrayHelper::map($noOfOwnersList, 'id', 'name');
        return $noOfOwnersArray;
    }

    public function getVConditionValue()
    {
        $VConditionList =[
              ['id' => '', 'name' => '-Select-'],
              ['id' => 'Running', 'name' => 'Running'],
              ['id' => 'Breakdown', 'name' => 'Breakdown'],
              ['id' => 'NeedsRepair', 'name' => 'NeedsRepair'],
              ['id' => 'Accident', 'name' => 'Accident'],
              ['id' => 'Towed', 'name' => 'Towed'],
              
        ];

 $VConditionArray = ArrayHelper::map($VConditionList, 'id', 'name');
        return $VConditionArray;
    }
    


     public function getCommenValue()
    {
        $CommenList =[
              // ['id' => '', 'name' => '-Select-'],
              ['id' => '1', 'name' => 'Average'],
              ['id' => '3', 'name' => 'Excellent'],
              ['id' => '2', 'name' => 'Good'],
             
              ['id' => '-1', 'name' => 'Bad'],
              ['id' => '-2', 'name' => 'VeryBad'],
              ['id' => '-3', 'name' => 'NA'],           
        ];

        $CommenArray = ArrayHelper::map($CommenList, 'id', 'name');
        return $CommenArray;
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
            'odometerReading' => 'Odometer Reading',
            'rcVerified' => 'Rc Verified',
            'bodyType' => 'Body Type',
            'fuelType' => 'Fuel Type',
            'cabin' => 'Cabin',
            'interior' => 'Interior',
            'frontCabin' => 'Front Cabin',
            'rear' => 'Rear',
            'cabinDoorRight' => 'Cabin Door Right',
            'cabinDoorLeft' => 'Cabin Door Left',
            'paint' => 'Paint',
            'bonnet' => 'Bonnet',
            'transmissionCondition' => 'Transmission Condition',
            'headLampTailLamp' => 'HeadLamp / TailLamp',
            'ac' => 'Air Condition',
            'liftAxile' => 'Lift Axile',
            'fans' => 'Fans',
            'engineOilLeaks' => 'Engine OilLeaks',
            'chassisCondition' => 'Chassis Condition',
            'engineCondition' => 'Engine Condition',
            'axleConfiguration' => 'Axle Configuration',
            'dieselPump' => 'Diesel Pump',
            'noOfSeats' => 'No Of Seats',
            'noOfTyre' => 'No Of Tyre',
            'spareTyre' => 'Spare Tyre',
            'headLights' => 'Head Lights',
            'indicatorLights' => 'Indicator Lights',
            'axleCondition' => 'Axle Condition',
            'wsGlass' => 'W.S. Glass',
            'leftWindowGlass' => 'Left Window Glass',
            'rightWindowGlass' => 'Right Window Glass',
            'windShield' => 'Wind Shield',
            'loadFloor' => 'Load Floor',
            'tailGate' => 'Tail Gate',
            'tyreCondition' => 'Tyre Condition',
            'hpaBank' => 'HPA Bank',
            'vehicleTonnage' => 'Vehicle Tonnage',
            'created_on' => 'Created On',
            'cubicCapacity' => 'Cubic Capacity',
            'overAllLoadBody' => 'OverAll LoadBody',
            'abs' => 'ABS',
            'leftBodyCondition' => 'Left Body Condition',
            'rightBodyCondition' => 'Right Body Condition',
            'batteryCondition' => 'Battery Condition',
            'brakes' => 'Brakes',
            'differentialCondition' => 'Differential Condition',
            'taxValidity' => 'Tax Validity',
            'fcValidity' => 'FC Validity',
            'suspension' => 'Suspension',
            'seatsCondition' => 'Seats Condition',
            'vehicleOwnership' => 'Vehicle Ownership',
            'vehicleCondition' => 'Vehicle Condition',
            'hpa' => 'HPA',
            'paintCondition' => 'Paint Condition',
            'roadPermit' => 'Road Permit',
            'insuranceType' => 'Insurance Type',
            'insuranceDate' => 'Insurance Date',
            'rcOwnerName' => 'RC Owner Name',
            'cluthCondition' => 'Cluth Condition',
            'vehicleParkingLocation' => 'Valuation Location',
            'systemGeneratedMarketValue' => 'System Market Value',
            'fixedMarketValue' => 'Fixed Market Value',
            'state' => 'State',
            'syd1to5' => 'SYD1to5',
            'syd6to10' => 'SYD6to10',
            'finalRating' => 'Final Rating',
            'totalWeightage' => 'TotalWeightage',
        ];
    }
}
