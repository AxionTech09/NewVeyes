<?php
namespace app\models;

use Yii;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\base\Security;
use yii\web\IdentityInterface;
use yii\data\ActiveDataProvider;
use yii\db\Expression;

/**
 * This is the model class for table "logs".
 *
 * @property integer $id
 * @property integer $leadNumber
 * @property string $message
 * @property string $createdOn
 */
class AxionPreinspectionHoBilling extends \yii\db\ActiveRecord
{
    public $billPeriod,$insurerArr,$totalKm,$total2W,$total3W,$total4W,$totalCW,$igst,$cgst,$sgst,$overallAmount,$roundAmt;

    public static function tableName()
    {
        return 'axion_preinspection_ho_billing';
    }

    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['createdOn','generatedDate','billPeriodFrom','billPeriodTo'], 'safe'],
            [['id','billId','roId','companyId','stateId','branchId','hoOrderNo','generatedBy'], 'integer'],
            [['billType','billDetails','billStatus','hoBillNumber'], 'string'],
            [['totalAmount','totalGst','billAmount'],'double']       
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'companyId' => 'Company',
            'stateId' => 'State',
            'branchId' => 'Branch',
            'Bill Type' => 'Bill Type',
            'Bill Details'  => 'Bill Details',
            'billStatus ' => 'Bill Status',
            'createdOn' => 'Created On',
            'billPeriodFrom' => 'Bill Period From',
            'billPeriodTo' => 'Bill Period To',
            'billPeriod' => 'Bill Period'
        ];
    }
    

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function searchHoBillList($params)
    {
        $query = AxionPreinspectionHoBilling::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $this->load($params);

        if ($params && !$this->validate()) {
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([    
            'id' => $this->id,
            'createdOn' => $this->createdOn,
            'companyId' => $this->companyId,      
        ]);    
        $query->orderBy([
            'hoOrderNo' => SORT_ASC,
            'id' => SORT_ASC
        ]);

        //echo $query->createCommand()->getRawSql();
        return $dataProvider;
    }

    public function getBill()
    {
        return $this->hasOne(AxionPreinspectionBilling::className(), ['id' => 'billId']);
    }
    

    public function getCompany()
    {
        return $this->hasOne(PreinspectionClientCompany::className(), ['id' => 'companyId']);
    }
     
    public function getState()
    {
        return $this->hasOne(MasterState::className(), ['id' => 'stateId']);
    }

     public function getBranch()
    {
        return $this->hasOne(PreinspectionClientBranch::className(), ['id' => 'branchId']);
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'generatedBy']);
    }

    public function getRoUser()
    {
        return $this->hasOne(User::className(), ['id' => 'roId']);
    }

    public function getStateDetails($id)
    {
        $res = MasterState::find()->where(['id' => $id])->one();
        return $res;
    }

    public function getTotal($billId,$companyId,$stateId)
    {
        $query = AxionPreinspection::find();



        $query->join('left join','axion_preinspection_vehicle as av2', 'av2.preinspection_id=axion_preinspection.id AND av2.vType="2-WHEELER"');
        $query->join('left join','axion_preinspection_vehicle as av3', 'av3.preinspection_id=axion_preinspection.id AND av3.vType="3-WHEELER"');
        $query->join('left join','axion_preinspection_vehicle as av4', 'av4.preinspection_id=axion_preinspection.id AND av4.vType="4-WHEELER"');
        $query->join('left join','axion_preinspection_vehicle as avc', 'avc.preinspection_id=axion_preinspection.id AND avc.vType="COMMERCIAL"');
        $query->join('left join','preinspection_client_company as pc', 'pc.id=axion_preinspection.insurerName');
           
          
            //$query->andFilterWhere(['in','axion_preinspection.status',[101, 102, 104,103,9]]);

            //$query->andFilterWhere(['between','axion_preinspection.completedSurveyDateTime', $fromDate, $toDate]);
        $query->join('left join','users as us', 'us.id=axion_preinspection.userId');

        $query->where(['insurerName'=>$companyId,"billId"=>$billId]);
        $query->andWhere(['us.stateId'=>$stateId]);
        $query->andWhere(['paymentMode'=>1]);

        $query->select([new Expression('SUM(extraKM) as totalKm'),new Expression('COUNT(av2.id) as total2W'),new Expression('COUNT(av3.id) as total3W'),new Expression('COUNT(av4.id) as total4W'),new Expression('COUNT(avc.id) as totalCW')]);

        //echo $query->createCommand()->getRawSql();
        return $query->one();
    }

}
