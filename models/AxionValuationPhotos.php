<?php

namespace app\models;
use yii\helpers\ArrayHelper;

use Yii;

/**
 * This is the model class for table "axion_valuation_photos".
 *
 * @property integer $id
 * @property integer $preinspection_id
 * @property string $type
 * @property string $image
 * @property string $iLat
 * @property string $iLong
 * @property string $bLat
 * @property string $bLong
 * @property string $iTime
 * @property string $sTime
 * @property string $iLocation
 * @property string $bLocation
 * @property integer $locStatus
 * @property integer $timeStatus
 * @property string $created_on
 */
class AxionValuationPhotos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'axion_valuation_photos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['preinspection_id', 'type'], 'required'],
            [['preinspection_id', 'locStatus', 'timeStatus'], 'integer'],
            [['iTime', 'sTime', 'created_on'], 'safe'],
            [['type','iLat', 'iLong', 'bLat', 'bLong'], 'string', 'max' => 50],
            [['image'], 'string', 'max' => 255],
            [['image'], 'file', 'extensions' => 'jpg, jpeg'],
            [['iLocation','bLocation'], 'string', 'max' => 100]
        ];
    }

    
    public function getTypeName()
    {
        $list= [
                ['id' => 'chassisThumb', 'name' => 'Chassis Thumb'],
                ['id' => 'frontViewNumberPlate', 'name' => 'Front View With Number Plate'],
                ['id' => 'rearViewImage', 'name' => 'Rear View Image'],
                ['id' => 'frontBumper', 'name' => 'Front Bumper'],
                ['id' => 'rearBumper', 'name' => 'Rear Bumper'],
                ['id' => 'frontLeftCorner45', 'name' => 'Front Left Corner 45 Degrees'],
                ['id' => 'frontRightCorner45', 'name' => 'Front Right Corner 45 Degrees'],
                ['id' => 'leftSideFullView', 'name' => 'Left Side Full View'],
                ['id' => 'rightSideFullView', 'name' => 'Right Side Full View'],
                ['id' => 'leftQtrPanel', 'name' => 'Left Qtr Panel'],
                ['id' => 'rightQtrPanel', 'name' => 'Right Qtr Panel'],
                ['id' => 'enginePhoto', 'name' => 'Engine Photo'],
                ['id' => 'chassisPlate', 'name' => 'Chassis Plate'],
                ['id' => 'dickyOpenImage', 'name' => 'Dicky Open Image'],
                ['id' => 'underChassis', 'name' => 'Under Chassis'],
                ['id' => 'dashBoardPhoto', 'name' => 'Dash Board Photo'],
                ['id' => 'odometerReading', 'name' => 'Odometer Reading'],
                ['id' => 'cngLpgKit', 'name' => 'CNG/LPG Kit'],
                ['id' => 'rcCopy', 'name' => 'RC Copy'],
                ['id' => 'preInsuranceCopy', 'name' => 'Previous Insurance Copy'],
                ['id' => 'dentsScratchImage1', 'name' => 'Dents/Scratch Image 1'],
                ['id' => 'dentsScratchImage2', 'name' => 'Dents/Scratch Image 2'],
                ['id' => 'dentsScratchImage3', 'name' => 'Dents/Scratch Image 3'],
              ];
        $dataArray = ArrayHelper::map($list, 'id', 'name');
        return $dataArray;
    }
    
    public function getLocStatusValue()
    {
        $list= [
                ['id' => '0', 'name' => ''],
                ['id' => '1', 'name' => 'Location Mismatch'],
                ['id' => '2', 'name' => 'No Image and Browser Geolocation found'],
                ['id' => '3', 'name' => 'No Image Geolocation found'],
                ['id' => '4', 'name' => 'No Browser Geolocation found'],
              ];
        $dataArray = ArrayHelper::map($list, 'id', 'name');
        return $dataArray;
    }
    
    public function getTimeStatusValue()
    {
        $list= [
                ['id' => '0', 'name' => ''],
                ['id' => '1', 'name' => 'DateTime Mismatch'],
                ['id' => '2', 'name' => 'No Image DateTime found'],
              ];
        $dataArray = ArrayHelper::map($list, 'id', 'name');
        return $dataArray;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'preinspection_id' => 'Preinspection ID',
            'type' => 'Type',
            'image' => 'Image',
            'iLat' => 'I Lat',
            'iLong' => 'I Long',
            'bLat' => 'B Lat',
            'bLong' => 'B Long',
            'iTime' => 'I Time',
            'sTime' => 'S Time',
            'iLocation' => 'I Location',
            'bLocation' => 'B Location',
            'locStatus' => 'Loc Status',
            'timeStatus' => 'Time Status',
            'created_on' => 'Created On',
        ];
    }
}
