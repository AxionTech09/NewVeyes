<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;


/**
 * This is the model class for table "axion_claimsurvey_fourwheeler".
 *
* @property int $id
 * @property int $preinspection_id
 * @property string $driverName
 * @property string $drivingLicenceNo
 * @property string $dateOfIssue
 * @property string $validUpto
 * @property string $issuingAuthority
 * @property string $typeOfLicence
 * @property string $badgeNo
 * @property string $number
 * @property string $loadDate
 * @property string $loadWeight
 * @property string $loadFrom
 * @property string $loadTo
 * @property string $dateTimeAccident
 * @property string $placeOfAccident
 * @property string $causeOfAccident
 * @property string $placeOfSurvey
 * @property string $dateAllotmentOfSurvey
 * @property string $dateTimeOfSurvey
 * @property string $accidentReportedToPolice
 * @property string $nameOfPoliceStation
 * @property string $stationDiaryNo
 * @property string $thirdPartyDetails
 * @property string $personAvailableAtTimeOfSurvey
 * @property string $vehicleRemovedForRepairs
 * @property string $parts
 * @property string $type
 * @property int $amount
 * @property int $assessment
 * @property string $assestspart
 * @property string $assestspart2
 * @property string $assestspart3
 * @property string $assestspart4
 * @property string $assestspart5
 * @property string $assestspart6
 * @property string $assestspart7
 * @property string $assestspart8
 * @property string $assestspart9
 * @property string $assestspart10
 * @property string $assestspart11
 * @property string $assestspart12
 * @property string $assestspart13
 * @property string $assestspart14
 * @property string $assestspart15
 * @property string $assestspart16
 * @property string $assestspart17
 * @property string $assestspart18
 * @property string $assestspart19
 * @property string $assestspart20
 * @property string $assestspart21
 * @property string $assestspart22
 * @property string $assestspart23
 * @property string $assestspart24
 * @property string $assestspart25
 * @property string $assestspart26
 * @property string $assestspart27
 * @property string $assestspart28
 * @property string $assestspart29
 * @property string $assestspart30
 * @property double $estTotal
 * @property double $billTotal
 * @property double $assestTotal
 * @property double $gstcalTotal
 * @property double $gstTotal
 * @property double $depTotal
 * @property double $netTotal
 * @property double $compEx
 * @property double $imposEx
 * @property double $salvEx
 * @property double $ncbEx
 * @property double $exTotal
 * @property double $insurerTotal
 * @property string $created_on
 */
 
class AxionClaimsurveyFourwheeler extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'axion_claimsurvey_fourwheeler';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
             [['preinspection_id','amount','assessment'],'integer'],

            [['dateOfIssue', 'validUpto', 'loadDate', 'dateTimeAccident', 'dateAllotmentOfSurvey', 
              'dateTimeOfSurvey', 'personAvailableAtTimeOfSurvey', 'created_on','preinspection_id'], 'safe'],
            [['driverName', 'drivingLicenceNo', 'issuingAuthority', 'typeOfLicence', 'badgeNo', 'number',
              'loadWeight', 'placeOfAccident', 'placeOfSurvey', 'accidentReportedToPolice',
              'nameOfPoliceStation', 'stationDiaryNo', 'thirdPartyDetails', 'vehicleRemovedForRepairs',
              'parts','type','assestspart','assestspart2','assestspart3','assestspart4','assestspart5','assestspart6',
              'assestspart7','assestspart8','assestspart9','assestspart10','assestspart11','assestspart12','assestspart13',
              'assestspart14','assestspart15','assestspart16','assestspart17','assestspart18','assestspart19','assestspart20','assestspart21','assestspart22','assestspart23',
              'assestspart24','assestspart25','assestspart26','assestspart27','assestspart28','assestspart29','assestspart30'], 'string', 'max' => 100],
            [['loadFrom', 'loadTo'], 'string', 'max' => 300],
            [['causeOfAccident'], 'string', 'max' => 1000],
            [['estTotal','billTotal','assestTotal','gstcalTotal','gstTotal','depTotal','netTotal','compEx','imposEx','salvEx','ncbEx','exTotal','insurerTotal'], 'number'],
        ];
    }
    
        public function getAxionClaimsurveyAssessment()
    {
        return $this->hasMany(AxionClaimsurveyAssessment::className(), ['preinspection_id' => 'id']);
    }


    public function getRcValue()
    {
        $rcList= [
                ['id' => '', 'name' => '-Select-'],  
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
        $glassTypeList = [['id' => '', 'name' => '-Select-'],
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
    



     public function getQcStatusValue()
    {
        $qcStatusList = [   
                        ['id' => '8', 'name' => 'Spot Survey'],
                        ['id' => '101', 'name' => 'Final-Survey'],
                        ['id' => '102', 'name' => 'Re-Inspection'],
                        ['id' => '104', 'name' => 'Initial-Survey'], 
                       ];
        $qcStatusArray = ArrayHelper::map($qcStatusList, 'id', 'name');
        return $qcStatusArray;
    }

    public function getSpareTyrevalue()
    {
        $spareTyreList = [
                        ['id' => '', 'name' => '-Select-'],
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

    public function getFuelTankvalue()
    {
        $fuelTankList = [['id' => '', 'name' => '-Select-'],
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
                        ['id' => '', 'name' => '-Select-'],
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
        $damageType4List = [['id' => '', 'name' => '-Select-'],
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
        $damageType5List = [['id' => '', 'name' => '-Select-'],
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

        public function getLicenceTypevalue()
    {
        $licenceTypeList = [
                        ['id' => '', 'name' => '-Select-'],
                        ['id' => 'HGV', 'name' => 'HGV'],
                        ['id' => 'LCV', 'name' => 'LCV'],   
                        ['id' => 'LMV', 'name' => 'LMV'],
                        ['id' => 'MotorCycle', 'name' => 'MotorCycle'],
                        ['id' => 'Scooter Without Gear', 'name' => 'Scooter Without Gear'],
                       ];
        $licenceTypeArray = ArrayHelper::map($licenceTypeList, 'id', 'name');
        return $licenceTypeArray;
    }
    
     public function getAssestsTypevalue()
    {
        $assestsTypeList = [
                        ['id' => '', 'name' => '-Select-'],
                        ['id' => 'MetalicParts', 'name' => 'Metalic-Parts'],
                        ['id' => 'FiberGlassParts', 'name' => 'Fiber-Glass-Parts'],   
                        ['id' => 'RubberPlasticParts', 'name' => 'Rubber-Plastic-Parts'],
                        ['id' => 'GlassParts', 'name' => 'Glass-Parts'],
                        ['id' => 'RefurbishedParts', 'name' => 'Refurbished-Parts'],
                        ['id' => 'LabourChargeRefitParts', 'name' => 'Labour-Charge-Refit-Parts'],
                        ['id' => 'RepairParts', 'name' => 'Repair-Parts'],
                        ['id' => 'TowingParts', 'name' => 'Towing-Parts'],
                        ['id' => 'PaintParts', 'name' => 'Paint-Parts'],
                       ];
        $assestsTypeArray = ArrayHelper::map($assestsTypeList, 'id', 'name');
        return $assestsTypeArray;
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'preinspection_id' => 'Preinspection Id',
            'driverName' => 'Driver Name',
            'drivingLicenceNo' => 'Driving Licence No',
            'dateOfIssue' => 'Date Of Issue',
            'validUpto' => 'Valid Upto',
            'issuingAuthority' => 'Issuing Authority',
            'typeOfLicence' => 'Type Of Licence',
            'badgeNo' => 'Badge No',
            'number' => 'Number',
            'loadDate' => 'Load Date',
            'loadWeight' => 'Load Weight',
            'loadFrom' => 'Load From',
            'loadTo' => 'Load To',
            'dateTimeAccident' => 'Date Time Accident',
            'placeOfAccident' => 'Place Of Accident',
            'causeOfAccident' => 'Cause Of Accident',
            'placeOfSurvey' => 'Place Of Survey',
            'dateAllotmentOfSurvey' => 'Date Allotment Of Survey',
            'dateTimeOfSurvey' => 'Date Time Of Survey',
            'accidentReportedToPolice' => 'Accident Reported To Police',
            'nameOfPoliceStation' => 'Name Of Police Station',
            'stationDiaryNo' => 'Station Diary No',
            'thirdPartyDetails' => 'Third Party Details',
            'personAvailableAtTimeOfSurvey' => 'Person Available At Time Of Survey',
            'vehicleRemovedForRepairs' => 'Vehicle Removed For Repairs',
            'parts' => 'Parts',
            'type' => 'Type',
            'amount' => 'Amount',
            'assessment' => 'Assessment',
            'assestspart' =>'',
            'assestspart2' =>'',
            'assestspart3' =>'',
            'assestspart4' =>'',
            'assestspart5' =>'',
            'assestspart6' =>'',
            'assestspart7' =>'',
            'assestspart8' =>'',
            'assestspart9' =>'',
            'assestspart10' =>'',
            'assestspart11' =>'',
            'assestspart12' =>'',
            'assestspart13' =>'',
            'assestspart14' =>'',
            'assestspart15' =>'',
            'assestspart16' =>'',
            'assestspart17' =>'',
            'assestspart18' =>'',
            'assestspart19' =>'',
            'assestspart20' =>'',
            'assestspart21' =>'',
            'assestspart22' =>'',
            'assestspart23' =>'',
            'assestspart24' =>'',
            'assestspart25' =>'',
            'assestspart26' =>'',
            'assestspart27' =>'',
            'assestspart28' =>'',
            'assestspart29' =>'',
            'assestspart30' =>'',
            'estTotal' => '',
            'billTotal' => '',
            'assestTotal' => '',
            'gstcalTotal' => '',
            'gstTotal' => '',
            'depTotal' => '',
            'netTotal' => '',
            'compEx' => '',
            'imposEx' => '',
            'salvEx' => '',
            'ncbEx' => '',
            'exTotal' => '',
            'insurerTotal' => '',
            'created_on' => 'Created On',
        ];
    }
}
