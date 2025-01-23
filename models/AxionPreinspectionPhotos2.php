<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "axion_preinspection_photos".
 *
 * @property integer $id
 * @property integer $preinspection_id
 * @property string $chassisThumb
 * @property string $frontViewNumberPlate
 * @property string $rearViewImage
 * @property string $frontBumper
 * @property string $rearBumper
 * @property string $frontLeftCorner45
 * @property string $frontRightCorner45
 * @property string $leftSideFullView
 * @property string $rightSideFullView
 * @property string $leftQtrPanel
 * @property string $rightQtrPanel
 * @property string $enginePhoto
 * @property string $chassisPlate
 * @property string $dickyOpenImage
 * @property string $underChassis
 * @property string $dashBoardPhoto
 * @property string $odometerReading
 * @property string $cngLpgKit
 * @property string $rcCopy
 * @property string $preInsuranceCopy
 * @property string $dentsScratchImage1
 * @property string $dentsScratchImage2
 * @property string $dentsScratchImage3
 * @property string $created_on
 */
class AxionPreinspectionPhotos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'axion_preinspection_photos';
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
            [['chassisThumb', 'frontViewNumberPlate', 'rearViewImage', 'frontBumper', 'rearBumper', 'frontLeftCorner45', 'frontRightCorner45', 'leftSideFullView', 'rightSideFullView', 'leftQtrPanel', 'rightQtrPanel', 'enginePhoto', 'chassisPlate', 'dickyOpenImage', 'underChassis', 'dashBoardPhoto', 'odometerReading', 'cngLpgKit', 'rcCopy', 'preInsuranceCopy', 'dentsScratchImage1', 'dentsScratchImage2', 'dentsScratchImage3'], 'string', 'max' => 100],
            [['chassisThumb', 'frontViewNumberPlate', 'rearViewImage', 'frontBumper', 'rearBumper', 'frontLeftCorner45', 'frontRightCorner45', 'leftSideFullView', 'rightSideFullView', 'leftQtrPanel', 'rightQtrPanel', 'enginePhoto', 'chassisPlate', 'dickyOpenImage', 'underChassis', 'dashBoardPhoto', 'odometerReading', 'cngLpgKit', 'rcCopy', 'preInsuranceCopy', 'dentsScratchImage1', 'dentsScratchImage2', 'dentsScratchImage3'], 'file', 'extensions' => 'png, jpg, jpeg']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'preinspection_id' => 'Preinspection ID',
            'chassisThumb' => 'Chassis Thumb',
            'frontViewNumberPlate' => 'Front View With Number Plate',
            'rearViewImage' => 'Rear View Image',
            'frontBumper' => 'Front Bumper',
            'rearBumper' => 'Rear Bumper',
            'frontLeftCorner45' => 'Front Left Corner 45 Degrees',
            'frontRightCorner45' => 'Front Right Corner 45 Degrees',
            'leftSideFullView' => 'Left Side Full View',
            'rightSideFullView' => 'Right Side Full View',
            'leftQtrPanel' => 'Left Qtr Panel',
            'rightQtrPanel' => 'Right Qtr Panel',
            'enginePhoto' => 'Engine Photo',
            'chassisPlate' => 'Chassis Plate',
            'dickyOpenImage' => 'Dicky Open Image',
            'underChassis' => 'Under Chassis',
            'dashBoardPhoto' => 'Dash Board Photo',
            'odometerReading' => 'Odometer Reading',
            'cngLpgKit' => 'CNG/LPG Kit',
            'rcCopy' => 'RC Copy',
            'preInsuranceCopy' => 'Previous Insurance Copy',
            'dentsScratchImage1' => 'Dents/Scratch Image 1',
            'dentsScratchImage2' => 'Dents/Scratch Image 2',
            'dentsScratchImage3' => 'Dents/Scratch Image 3',
            'created_on' => 'Created On',
        ];
    }
}
