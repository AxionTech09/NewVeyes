<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "axion_claimsurvey_labourchrefitparts".
 *
 * @property int $id
 * @property int $preinspection_id
 * @property string $partName
 * @property string $metalicPartCode
 * @property int $estimateAmt
 * @property int $billedAmt
 * @property int $assessedAmt
 * @property double $gstTax
 * @property double $gstTaxAmt
 * @property double $totalAmt
 * @property double $depri
 * @property double $depriAmt
 * @property double $netAmt
 * @property int $userId
 * @property string $createdOn
 * @property string $partName1
 * @property string $metalicPartCode1
 * @property int $estimateAmt1
 * @property int $billedAmt1
 * @property int $assessedAmt1
 * @property double $gstTax1
 * @property double $gstTaxAmt1
 * @property double $totalAmt1
 * @property double $depri1
 * @property double $depriAmt1
 * @property double $netAmt1
 * @property string $partName2
 * @property string $partName3
 * @property string $partName4
 * @property string $partName5
 * @property string $partName6
 * @property string $partName7
 * @property string $partName8
 * @property string $partName9
 * @property string $metalicPartCode2
 * @property string $metalicPartCode3
 * @property string $metalicPartCode4
 * @property string $metalicPartCode5
 * @property string $metalicPartCode6
 * @property string $metalicPartCode7
 * @property string $metalicPartCode8
 * @property string $metalicPartCode9
 * @property int $estimateAmt2
 * @property int $estimateAmt3
 * @property int $estimateAmt4
 * @property int $estimateAmt5
 * @property int $estimateAmt6
 * @property int $estimateAmt7
 * @property int $estimateAmt8
 * @property int $estimateAmt9
 * @property int $billedAmt2
 * @property int $billedAmt3
 * @property int $billedAmt4
 * @property int $billedAmt5
 * @property int $billedAmt6
 * @property int $billedAmt7
 * @property int $billedAmt8
 * @property int $billedAmt9
 * @property int $assessedAmt2
 * @property int $assessedAmt3
 * @property int $assessedAmt4
 * @property int $assessedAmt5
 * @property int $assessedAmt6
 * @property int $assessedAmt7
 * @property int $assessedAmt8
 * @property int $assessedAmt9
 * @property double $gstTax2
 * @property double $gstTax3
 * @property double $gstTax4
 * @property double $gstTax5
 * @property double $gstTax6
 * @property double $gstTax7
 * @property double $gstTax8
 * @property double $gstTax9
 * @property double $gstTaxAmt2
 * @property double $gstTaxAmt3
 * @property double $gstTaxAmt4
 * @property double $gstTaxAmt5
 * @property double $gstTaxAmt6
 * @property double $gstTaxAmt7
 * @property double $gstTaxAmt8
 * @property double $gstTaxAmt9
 * @property double $totalAmt2
 * @property double $totalAmt3
 * @property double $totalAmt4
 * @property double $totalAmt5
 * @property double $totalAmt6
 * @property double $totalAmt7
 * @property double $totalAmt8
 * @property double $totalAmt9
 * @property double $depri2
 * @property double $depri3
 * @property double $depri4
 * @property double $depri5
 * @property double $depri6
 * @property double $depri7
 * @property double $depri8
 * @property double $depri9
 * @property double $depriAmt2
 * @property double $depriAmt3
 * @property double $depriAmt4
 * @property double $depriAmt5
 * @property double $depriAmt6
 * @property double $depriAmt7
 * @property double $depriAmt8
 * @property double $depriAmt9
 * @property double $netAmt2
 * @property double $netAmt3
 * @property double $netAmt4
 * @property double $netAmt5
 * @property double $netAmt6
 * @property double $netAmt7
 * @property double $netAmt8
 * @property double $netAmt9
 * @property string $lastUpdatedOn
 */
class AxionClaimsurveyLabourchrefitparts extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'axion_claimsurvey_labourchrefitparts';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['preinspection_id', 'estimateAmt', 'billedAmt', 'assessedAmt', 'userId', 'estimateAmt1', 'billedAmt1', 'assessedAmt1', 'estimateAmt2', 'estimateAmt3', 'estimateAmt4', 'estimateAmt5', 'estimateAmt6', 'estimateAmt7', 'estimateAmt8', 'estimateAmt9', 'billedAmt2', 'billedAmt3', 'billedAmt4', 'billedAmt5', 'billedAmt6', 'billedAmt7', 'billedAmt8', 'billedAmt9', 'assessedAmt2', 'assessedAmt3', 'assessedAmt4', 'assessedAmt5', 'assessedAmt6', 'assessedAmt7', 'assessedAmt8', 'assessedAmt9'], 'integer'],
            [['gstTax', 'gstTaxAmt', 'totalAmt', 'depri', 'depriAmt', 'netAmt', 'gstTax1', 'gstTaxAmt1', 'totalAmt1', 'depri1', 'depriAmt1', 'netAmt1', 'gstTax2', 'gstTax3', 'gstTax4', 'gstTax5', 'gstTax6', 'gstTax7', 'gstTax8', 'gstTax9', 'gstTaxAmt2', 'gstTaxAmt3', 'gstTaxAmt4', 'gstTaxAmt5', 'gstTaxAmt6', 'gstTaxAmt7', 'gstTaxAmt8', 'gstTaxAmt9', 'totalAmt2', 'totalAmt3', 'totalAmt4', 'totalAmt5', 'totalAmt6', 'totalAmt7', 'totalAmt8', 'totalAmt9', 'depri2', 'depri3', 'depri4', 'depri5', 'depri6', 'depri7', 'depri8', 'depri9',  'depriAmt2', 'depriAmt3', 'depriAmt4', 'depriAmt5', 'depriAmt6', 'depriAmt7', 'depriAmt8', 'depriAmt9','netAmt2', 'netAmt3', 'netAmt4', 'netAmt5', 'netAmt6', 'netAmt7', 'netAmt8', 'netAmt9'], 'number'],
            [['createdOn','lastUpdatedOn'], 'safe'],
            [['partName', 'partName1', 'partName2', 'partName3', 'partName4', 'partName5', 'partName6', 'partName7', 'partName8', 'partName9','metalicPartCode2', 'metalicPartCode3', 'metalicPartCode4', 'metalicPartCode5', 'metalicPartCode6', 'metalicPartCode7', 'metalicPartCode8', 'metalicPartCode9'], 'string', 'max' => 200],
            [['metalicPartCode', 'metalicPartCode1'], 'string', 'max' => 111],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'preinspection_id' => 'Preinspection ID',
            'partName' => '',
            'metalicPartCode' => '',
            'estimateAmt' => '',
            'billedAmt' => '',
            'assessedAmt' => '',
            'gstTax' => '',
            'gstTaxAmt' => '',
            'totalAmt' => '',
            'depri' => '',
            'depriAmt' => '',
            'netAmt' => '',
            'userId' => '',
            'createdOn' => '',
            'lastUpdatedOn' => '',
            'partName1' => '',
            'metalicPartCode1' => '',
            'estimateAmt1' => '',
            'billedAmt1' => '',
            'assessedAmt1' => '',
            'gstTax1' => '',
            'gstTaxAmt1' => '',
            'totalAmt1' => '',
            'depri1' => '',
            'depriAmt1' => '',
            'netAmt1' => '',
            'partName2' => '',
            'partName3' => '',
            'partName4' => '',
            'partName5' => '',
            'partName6' => '',
            'partName7' => '',
            'partName8' => '',
            'partName9' => '',
            'metalicPartCode2' => ' ',
            'metalicPartCode3' => ' ',
            'metalicPartCode4' => ' ',
            'metalicPartCode5' => ' ',
            'metalicPartCode6' => ' ',
            'metalicPartCode7' => ' ',
            'metalicPartCode8' => ' ',
            'metalicPartCode9' => ' ',
            'estimateAmt2' => '',
            'estimateAmt3' => '',
            'estimateAmt4' => '',
            'estimateAmt5' => '',
            'estimateAmt6' => '',
            'estimateAmt7' => '',
            'estimateAmt8' => '',
            'estimateAmt9' => '',
            'billedAmt2' => '',
            'billedAmt3' => '',
            'billedAmt4' => '',
            'billedAmt5' => '',
            'billedAmt6' => '',
            'billedAmt7' => '',
            'billedAmt8' => '',
            'billedAmt9' => '',
            'assessedAmt2' => '',
            'assessedAmt3' => '',
            'assessedAmt4' => '',
            'assessedAmt5' => '',
            'assessedAmt6' => '',
            'assessedAmt7' => '',
            'assessedAmt8' => '',
            'assessedAmt9' => '',
            'gstTax2' => '',
            'gstTax3' => '',
            'gstTax4' => '',
            'gstTax5' => '',
            'gstTax6' => '',
            'gstTax7' => '',
            'gstTax8' => '',
            'gstTax9' => '',
            'gstTaxAmt2' => ' ',
            'gstTaxAmt3' => ' ',
            'gstTaxAmt4' => ' ',
            'gstTaxAmt5' => ' ',
            'gstTaxAmt6' => ' ',
            'gstTaxAmt7' => ' ',
            'gstTaxAmt8' => ' ',
            'gstTaxAmt9' => ' ',
            'totalAmt2' => '',
            'totalAmt3' => '',
            'totalAmt4' => '',
            'totalAmt5' => '',
            'totalAmt6' => '',
            'totalAmt7' => '',
            'totalAmt8' => '',
            'totalAmt9' => '',
            'depri2' => '',
            'depri3' => '',
            'depri4' => '',
            'depri5' => '',
            'depri6' => '',
            'depri7' => '',
            'depri8' => '',
            'depri9' => '',
            'depriAmt2' => '',
            'depriAmt3' => '',
            'depriAmt4' => '',
            'depriAmt5' => '',
            'depriAmt6' => '',
            'depriAmt7' => '',
            'depriAmt8' => '',
            'depriAmt9' => '',
            'netAmt2' => '',
            'netAmt3' => '',
            'netAmt4' => '',
            'netAmt5' => '',
            'netAmt6' => '',
            'netAmt7' => '',
            'netAmt8' => '',
            'netAmt9' => '',
        ];
    }
}
