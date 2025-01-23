<?php

namespace app\models;
use yii\helpers\ArrayHelper;


use Yii;

/**
 * This is the model class for table "axion_preinspection_commercialwheeler".
 *
 * @property integer $id
 * @property integer $preinspection_id
 * @property string $typeOfBody
 * @property string $frontSideBody
 * @property string $rearSideBody
 * @property string $rightSideBody
 * @property string $leftSideBody
 * @property string $frontExcavator
 * @property string $craneBucket
 * @property string $craneHook
 * @property string $ac
 * @property string $boom
 * @property string $fans
 * @property string $hydrualicSystem
 * @property string $chassisFrame
 * @property string $doors
 * @property string $excavatorCabinGlass
 * @property string $craneCabinGlass
 * @property string $extraFittings
 * @property string $created_on
 */
class AxionPreinspectionCommercialwheeler extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'axion_preinspection_commercialwheeler';
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
            [[ 'typeOfBody', 'frontSideBody', 'rearSideBody', 'rightSideBody', 'leftSideBody','frontExcavator', 
               'craneBucket', 'craneHook', 'ac','boom', 'fans', 'hydrualicSystem', 'chassisFrame', 'doors',
              'excavatorCabinGlass','craneCabinGlass','extraFittings'], 'string', 'max' => 50],
        ];
    }



 public function getCommercialwheelervalue()
    {
        $commercialwheelerList = [
                        ['id' => '', 'name' => '-Select-'],
                        ['id' => 'Bus', 'name' => 'Bus'],
                        ['id' => 'Truck', 'name' => 'Truck'],   
                        ['id' => 'Dumper', 'name' => 'Dumper'],
                        ['id' => 'Excavator', 'name' => 'Excavator'],
                        ['id' => 'Three Wheeler', 'name' => 'Three Wheeler'], 
                        ['id' => 'Crane', 'name' => 'Crane'],
                        ['id' => 'Tanker', 'name' => 'Tanker'],
                        ['id' => 'Tractor', 'name' => 'Tractor'],   
                        ['id' => 'Refrigator Body', 'name' => 'Refrigator Body'],
                        ['id' => 'Fire Brigade', 'name' => 'Fire Brigade'],
                        ['id' => 'Concrete Mixture', 'name' => 'Concrete Mixture'],
                        ['id' => 'Machine', 'name' => 'Machine'],
                        
                       ];
        $commercialwheelerArray = ArrayHelper::map($commercialwheelerList, 'id', 'name');
        return $commercialwheelerArray;
    }

    

     public function getCommercialwheeler1value()
    {
        $commercialwheeler1List = [
            
                        ['id' => 'Safe', 'name' => 'Safe'],  
                        ['id' => 'Scratch', 'name' => 'Scratch'],
                        ['id' => 'Crack', 'name' => 'Crack'],
                        ['id' => 'Dented', 'name' => 'Dented'],
                        ['id' => 'Broken', 'name' => 'Broken'],
                        ['id' => 'Damage', 'name' => 'Damage'], 
                        ['id' => 'Not Fitted', 'name' => 'Not Fitted'],
                        ['id' => 'Rusted', 'name' => 'Rusted'],
                        ['id' => 'Pressed', 'name' => 'Pressed'],   
                        ['id' => 'Torn', 'name' => 'Torn'],
                        ['id' => 'Spot Dent', 'name' => 'Spot Dent'],
                        ['id' => 'Chiped Off', 'name' => 'Chiped Off'],
                        ['id' => 'NA', 'name' => 'NA'],
                        
                       ];
        $commercialwheeler1Array = ArrayHelper::map($commercialwheeler1List, 'id', 'name');
        return $commercialwheeler1Array;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'preinspection_id' => 'Preinspection ID',
            'typeOfBody' => 'Type Of Body',
            'frontSideBody' => 'FrontSideBody',
            'rearSideBody' => 'RearSideBody',
            'rightSideBody' => 'RightSideBody',
            'leftSideBody' => 'LeftSideBody',
            'frontExcavator' => 'FrontExcavator',
            'craneBucket' => 'CraneBucket',
            'craneHook' => 'CraneHook',
            'ac' => 'Ac',
            'boom' => 'Boom',
            'fans' => 'Fans',
            'hydrualicSystem' => 'HydrualicSystem',
            'chassisFrame' => 'ChassisFrame',
            'doors' => 'Doors',
            'excavatorCabinGlass' => 'Excavator Cabin Glass',
            'craneCabinGlass' => 'Crane Cabin Glass',
            'extraFittings' => 'Extra Fittings',
            'created_on' => 'Created On',
        ];
    }
}
