<?php

namespace app\models;
use yii\helpers\ArrayHelper;

use Yii;


/**
 * This is the model class for table "axion_preinspection_twowheeler".
 *
 * @property integer $id
 * @property integer $preinspection_id
 * @property string $frontMudgaurd
 * @property string $handleBar
 * @property string $leverClutchHeadBreak
 * @property string $forntHubDiselDrum
 * @property string $frontWheelRim
 * @property string $frontShockAbsorber
 * @property string $legGaurd
 * @property string $leftCoverShield
 * @property string $rightCoverShield
 * @property string $chassisFrame
 * @property string $crankCaseCylinder
 * @property string $rearWheelRim
 * @property string $rearShockAbsorber
 * @property string $rearDrumDisc
 * @property string $chainCover
 * @property string $fork
 * @property string $kickPedal
 * @property string $rearcowlLeftCenterRight
 * @property string $legshieldLeft
 * @property string $legshieldRight
 * @property string $fairing
 * @property string $silencer
 * @property string $rearMudguard
 * @property string $sareeGuard
 * @property string $wisor
 * @property string $helmetBox
 * @property string $luggageCarrier
 * @property string $created_on
 */
class AxionPreinspectionTwowheeler extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'axion_preinspection_twowheeler';
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
            [['frontMudgaurd', 'handleBar', 'leverClutchHeadBreak', 'forntHubDiselDrum', 'frontWheelRim', 
              'frontShockAbsorber', 'legGaurd', 'leftCoverShield', 'rightCoverShield','chassisFrame',
               'crankCaseCylinder', 'rearWheelRim', 'rearShockAbsorber', 'rearDrumDisc', 'chainCover',
               'fork', 'kickPedal', 'rearcowlLeftCenterRight', 'legshieldLeft','legshieldRight', 
               'fairing', 'silencer', 'rearMudguard', 'sareeGuard',
               'wisor','helmetBox','luggageCarrier'], 'string', 'max' => 50],
        ];
    }



 public function getTwowheelervalue()
    {
        $twowheelerList = [
             
                        ['id' => 'Safe', 'name' => 'Safe'],
                        ['id' => 'Crack', 'name' => 'Crack'],   
                        ['id' => 'Scratch', 'name' => 'Scratch'],
                        ['id' => 'Dented', 'name' => 'Dented'],
                        ['id' => 'Broken', 'name' => 'Broken'],
                        ['id' => 'Bend', 'name' => 'Bend'], 
                        ['id' => 'Not Fitted', 'name' => 'Not Fitted'],
                        ['id' => 'Rusted', 'name' => 'Rusted'],
                        ['id' => 'Pressed', 'name' => 'Pressed'],   
                        ['id' => 'Torn', 'name' => 'Torn'],
                        ['id' => 'Spot Dent', 'name' => 'Spot Dent'],
                        ['id' => 'Dry Dent', 'name' => 'Dry Dent'],
                        ['id' => 'Bracket Broken', 'name' => 'Bracket Broken'],
                        ['id' => 'Paint Peel Off', 'name' => 'Paint Peel Off'], 
                        ['id' => 'Paint Faded', 'name' => 'Paint Faded'],
                        ['id' => 'NA', 'name' => 'NA'],
                       ];
        $twowheelerArray = ArrayHelper::map($twowheelerList, 'id', 'name');
        return $twowheelerArray;
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'preinspection_id' => 'Preinspection ID',
            'frontMudgaurd' => 'FrontMudgaurd',
            'handleBar' => 'HandleBar',
            'leverClutchHeadBreak' => 'LeverClutchHeadBreak',
            'forntHubDiselDrum' => 'ForntHubDiselDrum',
            'frontWheelRim' => 'FrontWheelRim',
            'frontShockAbsorber' => 'FrontShockAbsorber',
            'legGaurd' => 'LegGaurd',
            'leftCoverShield' => 'LeftCoverShield',
            'rightCoverShield' => 'RightCoverShield',
            'chassisFrame' => 'ChassisFrame',
            'crankCaseCylinder' => 'CrankCaseCylinder',
            'rearWheelRim' => 'RearWheelRim',
            'rearShockAbsorber' => 'RearShockAbsorber',
            'rearDrumDisc' => 'RearDrumDisc',
            'chainCover' => 'ChainCover',
            'fork' => 'Fork',
            'kickPedal' => 'KickPedal',
            'rearcowlLeftCenterRight' => 'RearcowlLeftCenterRight',
            'legshieldLeft' => 'LegshieldLeft',
            'legshieldRight' => 'LegshieldRight',
            'fairing' => 'Fairing',
            'silencer' => 'Silencer',
            'rearMudguard' => 'RearMudguard',
            'sareeGuard' => 'SareeGuard',
            'wisor' => 'Wisor',
            'helmetBox' => 'HelmetBox',
            'luggageCarrier' => 'LuggageCarrier',
            'created_on' => 'Created On',
        ];
    }
}
