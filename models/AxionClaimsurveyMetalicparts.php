<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "axion_claimsurvey_metalicparts".
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
 * @property string $partName10
 * @property string $partName11
 * @property string $partName12
 * @property string $partName13
 * @property string $partName14
 * @property string $partName15
 * @property string $partName16
 * @property string $partName17
 * @property string $partName18
 * @property string $partName19
 * @property string $partName20
 * @property string $metalicPartCode2
 * @property string $metalicPartCode3
 * @property string $metalicPartCode4
 * @property string $metalicPartCode5
 * @property string $metalicPartCode6
 * @property string $metalicPartCode7
 * @property string $metalicPartCode8
 * @property string $metalicPartCode9
 * @property string $metalicPartCode10
 * @property string $metalicPartCode11
 * @property string $metalicPartCode12
 * @property string $metalicPartCode13
 * @property string $metalicPartCode14
 * @property string $metalicPartCode15
 * @property string $metalicPartCode16
 * @property string $metalicPartCode17
 * @property string $metalicPartCode18
 * @property string $metalicPartCode19
 * @property string $metalicPartCode20
 * @property int $estimateAmt2
 * @property int $estimateAmt3
 * @property int $estimateAmt4
 * @property int $estimateAmt5
 * @property int $estimateAmt6
 * @property int $estimateAmt7
 * @property int $estimateAmt8
 * @property int $estimateAmt9
 * @property int $estimateAmt10
 * @property int $estimateAmt11
 * @property int $estimateAmt12
 * @property int $estimateAmt13
 * @property int $estimateAmt14
 * @property int $estimateAmt15
 * @property int $estimateAmt16
 * @property int $estimateAmt17
 * @property int $estimateAmt18
 * @property int $estimateAmt19
 * @property int $estimateAmt20
 * @property int $billedAmt2
 * @property int $billedAmt3
 * @property int $billedAmt4
 * @property int $billedAmt5
 * @property int $billedAmt6
 * @property int $billedAmt7
 * @property int $billedAmt8
 * @property int $billedAmt9
 * @property int $billedAmt10
 * @property int $billedAmt11
 * @property int $billedAmt12
 * @property int $billedAmt13
 * @property int $billedAmt14
 * @property int $billedAmt15
 * @property int $billedAmt16
 * @property int $billedAmt17
 * @property int $billedAmt18
 * @property int $billedAmt19
 * @property int $billedAmt20
 * @property int $assessedAmt2
 * @property int $assessedAmt3
 * @property int $assessedAmt4
 * @property int $assessedAmt5
 * @property int $assessedAmt6
 * @property int $assessedAmt7
 * @property int $assessedAmt8
 * @property int $assessedAmt9
 * @property int $assessedAmt10
 * @property int $assessedAmt11
 * @property int $assessedAmt12
 * @property int $assessedAmt13
 * @property int $assessedAmt14
 * @property int $assessedAmt15
 * @property int $assessedAmt16
 * @property int $assessedAmt17
 * @property int $assessedAmt18
 * @property int $assessedAmt19
 * @property int $assessedAmt20
 * @property double $gstTax2
 * @property double $gstTax3
 * @property double $gstTax4
 * @property double $gstTax5
 * @property double $gstTax6
 * @property double $gstTax7
 * @property double $gstTax8
 * @property double $gstTax9
 * @property double $gstTax10
 * @property double $gstTax11
 * @property double $gstTax12
 * @property double $gstTax13
 * @property double $gstTax14
 * @property double $gstTax15
 * @property double $gstTax16
 * @property double $gstTax17
 * @property double $gstTax18
 * @property double $gstTax19
 * @property double $gstTax20
 * @property double $gstTaxAmt2
 * @property double $gstTaxAmt3
 * @property double $gstTaxAmt4
 * @property double $gstTaxAmt5
 * @property double $gstTaxAmt6
 * @property double $gstTaxAmt7
 * @property double $gstTaxAmt8
 * @property double $gstTaxAmt9
 * @property double $gstTaxAmt10
 * @property double $gstTaxAmt11
 * @property double $gstTaxAmt12
 * @property double $gstTaxAmt13
 * @property double $gstTaxAmt14
 * @property double $gstTaxAmt15
 * @property double $gstTaxAmt16
 * @property double $gstTaxAmt17
 * @property double $gstTaxAmt18
 * @property double $gstTaxAmt19
 * @property double $gstTaxAmt20
 * @property double $totalAmt2
 * @property double $totalAmt3
 * @property double $totalAmt4
 * @property double $totalAmt5
 * @property double $totalAmt6
 * @property double $totalAmt7
 * @property double $totalAmt8
 * @property double $totalAmt9
 * @property double $totalAmt10
 * @property double $totalAmt11
 * @property double $totalAmt12
 * @property double $totalAmt13
 * @property double $totalAmt14
 * @property double $totalAmt15
 * @property double $totalAmt16
 * @property double $totalAmt17
 * @property double $totalAmt18
 * @property double $totalAmt19
 * @property double $totalAmt20
 * @property double $depri2
 * @property double $depri3
 * @property double $depri4
 * @property double $depri5
 * @property double $depri6
 * @property double $depri7
 * @property double $depri8
 * @property double $depri9
 * @property double $depri10
 * @property double $depri11
 * @property double $depri12
 * @property double $depri13
 * @property double $depri14
 * @property double $depri15
 * @property double $depri16
 * @property double $depri17
 * @property double $depri18
 * @property double $depri19
 * @property double $depri20
 * @property double $depriAmt2
 * @property double $depriAmt3
 * @property double $depriAmt4
 * @property double $depriAmt5
 * @property double $depriAmt6
 * @property double $depriAmt7
 * @property double $depriAmt8
 * @property double $depriAmt9
 * @property double $depriAmt10
 * @property double $depriAmt11
 * @property double $depriAmt12
 * @property double $depriAmt13
 * @property double $depriAmt14
 * @property double $depriAmt15
 * @property double $depriAmt16
 * @property double $depriAmt17
 * @property double $depriAmt18
 * @property double $depriAmt19
 * @property double $depriAmt20
 * @property double $netAmt2
 * @property double $netAmt3
 * @property double $netAmt4
 * @property double $netAmt5
 * @property double $netAmt6
 * @property double $netAmt7
 * @property double $netAmt8
 * @property double $netAmt9
 * @property double $netAmt10
 * @property double $netAmt11
 * @property double $netAmt12
 * @property double $netAmt13
 * @property double $netAmt14
 * @property double $netAmt15
 * @property double $netAmt16
 * @property double $netAmt17
 * @property double $netAmt18
 * @property double $netAmt19
 * @property double $netAmt20
 * @property string $lastUpdatedOn
 */
class AxionClaimsurveyMetalicparts extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'axion_claimsurvey_metalicparts';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['preinspection_id', 'estimateAmt', 'billedAmt', 'assessedAmt', 'userId', 'estimateAmt1', 'billedAmt1', 'assessedAmt1', 'estimateAmt2', 'estimateAmt3', 'estimateAmt4', 'estimateAmt5', 'estimateAmt6', 'estimateAmt7', 'estimateAmt8', 'estimateAmt9', 'estimateAmt10', 'estimateAmt11', 'estimateAmt12', 'estimateAmt13', 'estimateAmt14', 'estimateAmt15', 'estimateAmt16', 'estimateAmt17', 'estimateAmt18', 'estimateAmt19', 'estimateAmt20', 'billedAmt2', 'billedAmt3', 'billedAmt4', 'billedAmt5', 'billedAmt6', 'billedAmt7', 'billedAmt8', 'billedAmt9', 'billedAmt10', 'billedAmt11', 'billedAmt12', 'billedAmt13', 'billedAmt14', 'billedAmt15', 'billedAmt16', 'billedAmt17', 'billedAmt18', 'billedAmt19', 'billedAmt20', 'assessedAmt2', 'assessedAmt3', 'assessedAmt4', 'assessedAmt5', 'assessedAmt6', 'assessedAmt7', 'assessedAmt8', 'assessedAmt9', 'assessedAmt10', 'assessedAmt11', 'assessedAmt12', 'assessedAmt13', 'assessedAmt14', 'assessedAmt15', 'assessedAmt16', 'assessedAmt17', 'assessedAmt18', 'assessedAmt19', 'assessedAmt20'], 'integer'],
            [['gstTax', 'gstTaxAmt', 'totalAmt', 'depri', 'depriAmt', 'netAmt', 'gstTax1', 'gstTaxAmt1', 'totalAmt1', 'depri1', 'depriAmt1', 'netAmt1', 'gstTax2', 'gstTax3', 'gstTax4', 'gstTax5', 'gstTax6', 'gstTax7', 'gstTax8', 'gstTax9', 'gstTax10', 'gstTax11', 'gstTax12', 'gstTax13', 'gstTax14', 'gstTax15', 'gstTax16', 'gstTax17', 'gstTax18', 'gstTax19', 'gstTax20', 'gstTaxAmt2', 'gstTaxAmt3', 'gstTaxAmt4', 'gstTaxAmt5', 'gstTaxAmt6', 'gstTaxAmt7', 'gstTaxAmt8', 'gstTaxAmt9', 'gstTaxAmt10', 'gstTaxAmt11', 'gstTaxAmt12', 'gstTaxAmt13', 'gstTaxAmt14', 'gstTaxAmt15', 'gstTaxAmt16', 'gstTaxAmt17', 'gstTaxAmt18', 'gstTaxAmt19', 'gstTaxAmt20', 'totalAmt2', 'totalAmt3', 'totalAmt4', 'totalAmt5', 'totalAmt6', 'totalAmt7', 'totalAmt8', 'totalAmt9', 'totalAmt10', 'totalAmt11', 'totalAmt12', 'totalAmt13', 'totalAmt14', 'totalAmt15', 'totalAmt16', 'totalAmt17', 'totalAmt18', 'totalAmt19', 'totalAmt20', 'depri2', 'depri3', 'depri4', 'depri5', 'depri6', 'depri7', 'depri8', 'depri9', 'depri10', 'depri11', 'depri12', 'depri13', 'depri14', 'depri15', 'depri16', 'depri17', 'depri18', 'depri19', 'depri20', 'depriAmt2', 'depriAmt3', 'depriAmt4', 'depriAmt5', 'depriAmt6', 'depriAmt7', 'depriAmt8', 'depriAmt9', 'depriAmt10', 'depriAmt11', 'depriAmt12', 'depriAmt13', 'depriAmt14', 'depriAmt15', 'depriAmt16', 'depriAmt17', 'depriAmt18', 'depriAmt19', 'depriAmt20','netAmt2', 'netAmt3', 'netAmt4', 'netAmt5', 'netAmt6', 'netAmt7', 'netAmt8', 'netAmt9', 'netAmt10', 'netAmt11', 'netAmt12', 'netAmt13', 'netAmt14', 'netAmt15', 'netAmt16', 'netAmt17', 'netAmt18', 'netAmt19', 'netAmt20'], 'number'],
            [['createdOn','lastUpdatedOn'], 'safe'],
            [['partName', 'partName1', 'partName2', 'partName3', 'partName4', 'partName5', 'partName6', 'partName7', 'partName8', 'partName9', 'partName10', 'partName11', 'partName12', 'partName13', 'partName14', 'partName15', 'partName16', 'partName17', 'partName18', 'partName19', 'partName20','metalicPartCode2', 'metalicPartCode3', 'metalicPartCode4', 'metalicPartCode5', 'metalicPartCode6', 'metalicPartCode7', 'metalicPartCode8', 'metalicPartCode9', 'metalicPartCode10', 'metalicPartCode11', 'metalicPartCode12', 'metalicPartCode13', 'metalicPartCode14', 'metalicPartCode15', 'metalicPartCode16', 'metalicPartCode17', 'metalicPartCode18', 'metalicPartCode19', 'metalicPartCode20'], 'string', 'max' => 200],
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
            'partName10' => '',
            'partName11' => '',
            'partName12' => '',
            'partName13' => '',
            'partName14' => '',
            'partName15' => '',
            'partName16' => '',
            'partName17' => '',
            'partName18' => '',
            'partName19' => '',
            'partName20' => '',
           
'metalicPartCode2' => ' ',
'metalicPartCode3' => ' ',
'metalicPartCode4' => ' ',
'metalicPartCode5' => ' ',
'metalicPartCode6' => ' ',
'metalicPartCode7' => ' ',
'metalicPartCode8' => ' ',
'metalicPartCode9' => ' ',
'metalicPartCode10' => ' ',
'metalicPartCode11' => ' ',
'metalicPartCode12' => ' ',
'metalicPartCode13' => ' ',
'metalicPartCode14' => ' ',
'metalicPartCode15' => ' ',
'metalicPartCode16' => ' ',
'metalicPartCode17' => ' ',
'metalicPartCode18' => ' ',
'metalicPartCode19' => ' ',
'metalicPartCode20' => ' ',
'estimateAmt2' => '',
'estimateAmt3' => '',
'estimateAmt4' => '',
'estimateAmt5' => '',
'estimateAmt6' => '',
'estimateAmt7' => '',
'estimateAmt8' => '',
'estimateAmt9' => '',
'estimateAmt10' => '',
'estimateAmt11' => '',
'estimateAmt12' => '',
'estimateAmt13' => '',
'estimateAmt14' => '',
'estimateAmt15' => '',
'estimateAmt16' => '',
'estimateAmt17' => '',
'estimateAmt18' => '',
'estimateAmt19' => '',
'estimateAmt20' => '',
'billedAmt2' => '',
'billedAmt3' => '',
'billedAmt4' => '',
'billedAmt5' => '',
'billedAmt6' => '',
'billedAmt7' => '',
'billedAmt8' => '',
'billedAmt9' => '',
'billedAmt10' => '',
'billedAmt11' => '',
'billedAmt12' => '',
'billedAmt13' => '',
'billedAmt14' => '',
'billedAmt15' => '',
'billedAmt16' => '',
'billedAmt17' => '',
'billedAmt18' => '',
'billedAmt19' => '',
'billedAmt20' => '',
'assessedAmt2' => '',
'assessedAmt3' => '',
'assessedAmt4' => '',
'assessedAmt5' => '',
'assessedAmt6' => '',
'assessedAmt7' => '',
'assessedAmt8' => '',
'assessedAmt9' => '',
'assessedAmt10' => '',
'assessedAmt11' => '',
'assessedAmt12' => '',
'assessedAmt13' => '',
'assessedAmt14' => '',
'assessedAmt15' => '',
'assessedAmt16' => '',
'assessedAmt17' => '',
'assessedAmt18' => '',
'assessedAmt19' => '',
'assessedAmt20' => '',
'gstTax2' => '',
'gstTax3' => '',
'gstTax4' => '',
'gstTax5' => '',
'gstTax6' => '',
'gstTax7' => '',
'gstTax8' => '',
'gstTax9' => '',
'gstTax10' => '',
'gstTax11' => '',
'gstTax12' => '',
'gstTax13' => '',
'gstTax14' => '',
'gstTax15' => '',
'gstTax16' => '',
'gstTax17' => '',
'gstTax18' => '',
'gstTax19' => '',
'gstTax20' => '',
'gstTaxAmt2' => ' ',
'gstTaxAmt3' => ' ',
'gstTaxAmt4' => ' ',
'gstTaxAmt5' => ' ',
'gstTaxAmt6' => ' ',
'gstTaxAmt7' => ' ',
'gstTaxAmt8' => ' ',
'gstTaxAmt9' => ' ',
'gstTaxAmt10' => ' ',
'gstTaxAmt11' => ' ',
'gstTaxAmt12' => ' ',
'gstTaxAmt13' => ' ',
'gstTaxAmt14' => ' ',
'gstTaxAmt15' => ' ',
'gstTaxAmt16' => ' ',
'gstTaxAmt17' => ' ',
'gstTaxAmt18' => ' ',
'gstTaxAmt19' => ' ',
'gstTaxAmt20' => ' ',
'totalAmt2' => '',
'totalAmt3' => '',
'totalAmt4' => '',
'totalAmt5' => '',
'totalAmt6' => '',
'totalAmt7' => '',
'totalAmt8' => '',
'totalAmt9' => '',
'totalAmt10' => '',
'totalAmt11' => '',
'totalAmt12' => '',
'totalAmt13' => '',
'totalAmt14' => '',
'totalAmt15' => '',
'totalAmt16' => '',
'totalAmt17' => '',
'totalAmt18' => '',
'totalAmt19' => '',
'totalAmt20' => '',
'depri2' => '',
'depri3' => '',
'depri4' => '',
'depri5' => '',
'depri6' => '',
'depri7' => '',
'depri8' => '',
'depri9' => '',
'depri10' =>'',
'depri11' => '',
'depri12' => '',
'depri13' => '',
'depri14' => '',
'depri15' => '',
'depri16' => '',
'depri17' => '',
'depri18' => '',
'depri19' => '',
'depri20' => '',
'depriAmt2' => '',
'depriAmt3' => '',
'depriAmt4' => '',
'depriAmt5' => '',
'depriAmt6' => '',
'depriAmt7' => '',
'depriAmt8' => '',
'depriAmt9' => '',
'depriAmt10' => '',
'depriAmt11' => '',
'depriAmt12' => '',
'depriAmt13' => '',
'depriAmt14' => '',
'depriAmt15' => '',
'depriAmt16' => '',
'depriAmt17' => '',
'depriAmt18' => '',
'depriAmt19' => '',
'depriAmt20' => '',
'netAmt2' => '',
'netAmt3' => '',
'netAmt4' => '',
'netAmt5' => '',
'netAmt6' => '',
'netAmt7' => '',
'netAmt8' => '',
'netAmt9' => '',
'netAmt10' => '',
'netAmt11' => '',
'netAmt12' => '',
'netAmt13' => '',
'netAmt14' => '',
'netAmt15' => '',
'netAmt16' => '',
'netAmt17' => '',
'netAmt18' => '',
'netAmt19' => '',
'netAmt20' => '',
        ];
    }
}
