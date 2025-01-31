<?php

namespace app\models;
use yii\helpers\ArrayHelper;

use Yii;

/**
 * This is the model class for table "axion_claimsurvey_assessment".
 *
 * @property int $id
 * @property int $preinspection_id
 * @property string $assessment
 * @property string $assessment1
* @property string $assessment2
 * @property string $assessment3
 * @property string $assessment4
 * @property string $assessment5
 * @property string $assessment6
 * @property string $assessment7
 * @property string $assessment8
* @property string $assessment9
* @property string $assessment10
 * @property string $assessment11
* @property string $assessment12
 * @property string $assessment13
 * @property string $assessment14
 * @property string $assessment15
 * @property string $assessment16
 * @property string $assessment17
 * @property string $assessment18
* @property string $assessment19
 * @property int $estimateAmount
 * @property int $estimateAmount1 
 * @property int $estimateAmount2
 * @property int $estimateAmount3
 * @property int $estimateAmount4 
 * @property int $estimateAmount5
 * @property int $estimateAmount6
 * @property int $estimateAmount7 
 * @property int $estimateAmount8
 * @property int $estimateAmount9
 * @property int $estimateAmount10 
 * @property int $estimateAmount11
 * @property int $estimateAmount12
 * @property int $estimateAmount13 
 * @property int $estimateAmount14
 * @property int $estimateAmount15
 * @property int $estimateAmount16
 * @property int $estimateAmount17 
  * @property int $estimateAmount18 
   * @property int $estimateAmount19
   * @property string $itemCode
   * @property string $itemCode1
   * @property string $itemCode2
   * @property string $itemCode3
   * @property string $itemCode4
   * @property string $itemCode5
   * @property string $itemCode6
   * @property string $itemCode7
   * @property string $itemCode8
   * @property string $itemCode9
   * @property string $itemCode10
   * @property string $itemCode11
   * @property string $itemCode12
   * @property string $itemCode13
   * @property string $itemCode14
   * @property string $itemCode15
   * @property string $itemCode16
   * @property string $itemCode17
   * @property string $itemCode18
   * @property string $itemCode19
   * @property int $estimate
   * @property int $estimate1
   * @property int $estimate2
   * @property int $estimate3
   * @property int $estimate4
   * @property int $estimate5
   * @property int $estimate6
   * @property int $estimate7
   * @property int $estimate8
   * @property int $estimate9
   * @property int $estimate10
   * @property int $estimate11
   * @property int $estimate12
   * @property int $estimate13
   * @property int $estimate14
   * @property int $estimate15
   * @property int $estimate16
   * @property int $estimate17
   * @property int $estimate18
   * @property int $estimate19
   * @property string $subTotal
   * @property string $subTotal1
   * @property string $depr
   * @property string $deprTotal
   * @property string $sgst
   * @property string $cgst
   * @property string $gstTotal
   * @property string $imposedExcess
   * @property string $compulsoryExcess
   * @property string $salvageValue
   * @property string $grandTotal
    * @property string $liability   
 * @property int $userId
 * @property string $created_on
 * @property string $lastUpdatedOn
 *
 */
class AxionClaimsurveyAssessment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'axion_claimsurvey_assessment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
          
            [['preinspection_id','userId','estimateAmount','estimateAmount1','estimateAmount2','estimateAmount3','estimateAmount4','estimateAmount5','estimateAmount6','estimateAmount7','estimateAmount8','estimateAmount9','estimateAmount10','estimateAmount11','estimateAmount12','estimateAmount13','estimateAmount14','estimateAmount15','estimateAmount16','estimateAmount17','estimateAmount18','estimateAmount19','estimate','estimate1','estimate2','estimate3','estimate4','estimate5','estimate6','estimate7','estimate8','estimate9','estimate10','estimate11','estimate12','estimate13','estimate14','estimate15','estimate16','estimate17','estimate18','estimate19'], 'integer'],
            [['created_on','lastUpdatedOn'], 'safe'],
            [['assessment','assessment1','assessment2','assessment3','assessment4','assessment5','assessment6','assessment7','assessment8','assessment9','assessment10','assessment11','assessment12','assessment13','assessment14','assessment15','assessment16','assessment17','assessment18','assessment19','itemCode','itemCode1','itemCode2','itemCode3','itemCode4','itemCode5','itemCode6','itemCode7','itemCode8','itemCode9','itemCode10','itemCode11','itemCode12','itemCode13','itemCode14','itemCode15','itemCode16','itemCode17','itemCode18','itemCode19'], 'string', 'max' => 100],
            [['subTotal','subTotal1','depr','deprTotal','sgst','cgst','gstTotal','imposedExcess','compulsoryExcess','salvageValue','grandTotal','liability'],'double'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'preinspection_id' => 'PreinspectionId',
            'assessment' => '',
            'assessment1' => '',
            'assessment2' => '',
            'assessment3' => '',
            'assessment4' => '',
            'assessment5' => '',
            'assessment6' => '',
            'assessment7' => '',
            'assessment8' => '',
            'assessment9' => '',
            'assessment10' => '',
            'assessment11' => '',
            'assessment12' => '',
            'assessment13' => '',
            'assessment14' => '',
            'assessment15' => '',
            'assessment16' => '',
            'assessment17' => '',
            'assessment18' => '',
            'assessment19' => '',
            'estimateAmount' => '',
            'estimateAmount1' => '',
            'estimateAmount2' => '',
            'estimateAmount3' => '',
            'estimateAmount4' => '',
            'estimateAmount5' => '',
            'estimateAmount6' => '',
            'estimateAmount7' => '',
            'estimateAmount8' => '',
            'estimateAmount9' => '',
            'estimateAmount10' => '',
            'estimateAmount11' => '',
            'estimateAmount12' => '',
            'estimateAmount13' => '',
            'estimateAmount14' => '',
            'estimateAmount15' => '',
            'estimateAmount16' => '',
            'estimateAmount17' => '',
            'estimateAmount18' => '',
            'estimateAmount19' => '',
            'itemCode' => '',
            'itemCode1' => '',
            'itemCode2' => '',
            'itemCode3' => '',
            'itemCode4' => '',
            'itemCode5' => '',
            'itemCode6' => '',
            'itemCode7' => '',
            'itemCode8' => '',
            'itemCode9' => '',
            'itemCode10' => '',
            'itemCode11' => '',
            'itemCode12' => '',
            'itemCode13' => '',
            'itemCode14' => '',
            'itemCode15' => '',
            'itemCode16' => '',
            'itemCode17' => '',
            'itemCode18' => '',
            'itemCode19' => '',
            'estimate' => '',
            'estimate1' => '',
            'estimate2' => '',
            'estimate3' => '',
            'estimate4' => '',
            'estimate5' => '',
            'estimate6' => '',
            'estimate7' => '',
            'estimate8' => '',
            'estimate9' => '',
            'estimate10' => '',
            'estimate11' => '',
            'estimate12' => '',
            'estimate13' => '',
            'estimate14' => '',
            'estimate15' => '',
            'estimate16' => '',
            'estimate17' => '',
            'estimate18' => '',
            'estimate19' => '',
            'subTotal' => '',
            'subTotal1' => '',
            'depr' => '',
            'deprTotal' => '',
            'sgst' => '',
            'cgst' => '',
            'gstTotal' => '',
            'imposedExcess' => '',
            'compulsoryExcess' => '',
            'salvageValue' => '',
            'grandTotal' => '',
            'liability' => '',
            'userId' => 'userId',
            'created_on' => 'Created On',
            'lastUpdatedOn' => '',
        ];
    }
}
