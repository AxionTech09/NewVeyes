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
class AxionPreinspectionBilling extends \yii\db\ActiveRecord
{
    public $billPeriod,$insurerArr,$totalKm,$total2W,$total3W,$total4W,$totalCW,$igst,$cgst,$sgst,$overallAmount,$roundAmt,$totalEast4W,$totalEastCW;

    public static function tableName()
    {
        return 'axion_preinspection_billing';
    }

    public function scenarios() {

        $scenarios = parent::scenarios();

        $scenarios['search'] = ['billPeriod', 'companyId'];

        return $scenarios;

    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['companyId'],'required','on' => 'search','message' => 'Choose Client'],
            ['billPeriod','required','on'=>'search'],   
            [['createdOn','billPeriodFrom','billPeriodTo','manualUpdate'], 'safe'],
            [['id','companyId','stateId','branchId','orderNo','parentId', 'sbuHeadId', 'mailSent'], 'integer'],
            [['billType','billDetails','billStatus','billNumber'], 'string'],
            [['totalAmount', 'totalIgst', 'totalIgst', 'totalIgst', 'totalGst','billAmount', 'amount2Wheeler', 'amount3Wheeler', 'amount4Wheeler', 'amountCommmercial', 'amountTotalKm'], 'double']
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
            'sbuHeadId' => 'SBU Head',
            'Bill Type' => 'Bill Type',
            'Bill Details'  => 'Bill Details',
            'billStatus ' => 'Bill Status',
            'createdOn' => 'Created On',
            'billPeriodFrom' => 'Bill Period From',
            'billPeriodTo' => 'Bill Period To',
            'billPeriod' => 'Bill Period',
            'manualUpdate' => 'Manual Update',
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
    public function searchMisVerification($params)
    {

        //$query = AxionPreinspectionBilling::find();
        $query = AxionPreinspection::find();

        // add conditions that should always apply here

        $pageSize = isset($_GET["per-page"]) ? $_GET["per-page"] : 50;
        $billId = isset($_GET["billId"]) ? $_GET["billId"] : "";
        $companyId = isset($_GET["companyId"]) ? $_GET["companyId"] : "";

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => ($pageSize != 'All') ? $pageSize : '',
            ],
        ]);
        
        if($billId){
            $query->join('left join','axion_preinspection_billing as ab', 'ab.id=axion_preinspection.billId');
            $query->join('left join','axion_preinspection_vehicle as av', 'av.preinspection_id=axion_preinspection.id');

            $query->where(['billId'=>$billId]);
            $query->orWhere(['ab.parentId'=>$billId]);
            $query->andWhere(['in', 'paymentMode', [1,3]]);
            
            // Except ITGI
            if ($companyId != 9)
            {
                //Only take 4-WHEELER, COMMERCIAL
                $query->andWhere(['in', 'av.vType', ['4-WHEELER', 'COMMERCIAL']]);
            }

                
            $stateId =(isset($_GET['stateId']) && $_GET['stateId']) ? $_GET['stateId'] : '';
            if($params && $stateId){            
                $query->join('left join','users as us', 'us.id=axion_preinspection.updatedBy');
                $query->andFilterWhere(['us.stateId'=>$stateId]);
            }
            //echo $query->createCommand()->getRawSql();exit;
            return $dataProvider;
        }

        $this->load($params);
        
        $query->join('left join','axion_preinspection_billing as ab', 'ab.id=axion_preinspection.billId');
        $query->join('left join','axion_preinspection_vehicle as av', 'av.preinspection_id=axion_preinspection.id');

        $role = array_keys(Yii::$app->authManager->getRolesByUser(Yii::$app->user->getId()))[0] ;

        $stateId = (isset($params['AxionPreinspectionBilling']) && isset($params['AxionPreinspectionBilling']['stateId'])) ? $params['AxionPreinspectionBilling']['stateId'] : ((isset($_GET['stateId']) && $_GET['stateId']) ? $_GET['stateId'] : '');

        //echo $stateId;exit;
        if($role == 'BO User')
        {
            $bexeUsers_list=$surveyorUsers_list=$boUsers_list=[];

            //Get Particular Bo User's/Ro User's Branch Executives user id. 
            $bexeUsers = User::find()->select('id')->join('LEFT JOIN','auth_assignment','auth_assignment.user_id = id')
                        ->andFilterWhere(['auth_assignment.item_name' => 'Branch Executive'])
                        ->andFilterWhere(['users.roId'=> Yii::$app->user->identity->id])->all();

            if($bexeUsers){
                foreach ($bexeUsers as $key => $value) {
                    $bexeUsers_list[] = $value->id;
                }
            }
 
            $surveyorUsers = User::find()->select('id')->join('LEFT JOIN','auth_assignment','auth_assignment.user_id = id')
                            ->andFilterWhere(['auth_assignment.item_name' => 'Surveyor'])
                            ->andFilterWhere(['users.roId'=> Yii::$app->user->identity->id])->all();

            if($surveyorUsers){
                foreach ($surveyorUsers as $key => $value) {
                    $surveyorUsers_list[] = $value->id;
                }
            }

            $boUsers_list[] = Yii::$app->user->identity->id;

            $usersLists = array_merge($boUsers_list, $bexeUsers_list, $surveyorUsers_list);
            $query->andWhere(['in', 'updatedBy', $usersLists]);
        }

        if ($this->billPeriod) { 
            $fromDate = date('Y-m-01 00:00:00',strtotime($this->billPeriod));
            $toDate = date('Y-m-t 23:59:59',strtotime($this->billPeriod));
        }
        else {
            $fromDate = date('Y-m-01 00:00:00', strtotime('first day of last month'));
            $toDate = date('Y-m-t 23:59:59', strtotime('first day of last month'));
        }

        $query->andFilterWhere(['between','axion_preinspection.completedSurveyDateTime', $fromDate, $toDate]);

        $query->andWhere(['<>','billId', ""]);
        $query->andWhere(['in', 'paymentMode', [1,3]]);

        // Except ITGI
        if ($companyId != 9)
        {
            //Only take 4-WHEELER, COMMERCIAL
            $query->andWhere(['in', 'vType', ['4-WHEELER', 'COMMERCIAL']]);
        }

        if($params) {
            if(!$pageSize && !$this->validate()){
                return $dataProvider;
            }
        }

        // grid filtering conditions
        $query->andFilterWhere([    
            'id' => $this->id,
            'createdOn' => $this->createdOn,
            'insurerName' => $this->companyId,            
        ]);
        
        if($params && $stateId){            
            $query->join('left join','users as us', 'us.id=axion_preinspection.updatedBy');
            $query->andFilterWhere(['us.stateId'=>$stateId]);
        }
        
        if($params && isset($params['AxionPreinspectionBilling']) && isset($params['AxionPreinspectionBilling']['branchId'])){
            $query->andFilterWhere(['insurerBranch'=>$params['AxionPreinspectionBilling']['branchId']]);           
        }        

        //echo $query->createCommand()->getRawSql();exit;
        return $dataProvider;
    }

     /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function searchMisVerificationAdmin($params)
    {
        $query = AxionPreinspectionBilling::find();
        // add conditions that should always apply here
        $pageSize = isset($_GET["per-page"]) ? $_GET["per-page"] : 50;
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => $pageSize,
            ],
        ]);
        $query->where(["IN", "axion_preinspection_billing.billStatus", ["Initiated","Verified"]]);
        $query->andWhere(["REGEXP", "axion_preinspection_billing.billDetails", ':[1-9]|:"[1-9]']);
        $this->load($params);         
        //$query->join('left join','axion_preinspection_billing as ab', 'ab.id=axion_preinspection.billId');

       if($params) {
            if(!$pageSize && !$this->validate()){
                return $dataProvider;
            }
        }

        $stateId = isset($params['AxionPreinspectionBilling']) && isset($params['AxionPreinspectionBilling']['stateId'])  ? $params['AxionPreinspectionBilling']['stateId']: '';
        $branchId = isset($params['AxionPreinspectionBilling']) && isset($params['AxionPreinspectionBilling']['branchId'])  ? $params['AxionPreinspectionBilling']['branchId']: '';
        //$branchId = isset($params['AxionPreinspectionBilling']) && isset($params['AxionPreinspectionBilling']['branchId'])  ? $params['AxionPreinspectionBilling']['branchId']: '';

        // grid filtering conditions
        $query->andFilterWhere([    
            'id' => $this->id,
            'createdOn' => $this->createdOn,
            'axion_preinspection_billing.companyId' => $this->companyId,            
            //'stateId' => $stateId,            
            'branchId' => $branchId,            
        ]);        

        if ($params && $stateId) { 
            $query->join('left join','axion_preinspection as ax', 'axion_preinspection_billing.id=ax.billId');
            $query->join('left join','users as us', 'us.id=ax.updatedBy');
            //$query->andFilterWhere(['us.stateId'=>$stateId]);
            $query->andFilterWhere(["OR", ['=','us.stateId', $stateId],['=','ax.stateId', $stateId]]);
        }

        $billPeriod = isset($params['AxionPreinspectionBilling']) && isset($params['AxionPreinspectionBilling']['billPeriod'])  ? $params['AxionPreinspectionBilling']['billPeriod']: '';
        
        if ($billPeriod){ 
            $fromDate = date('Y-m-01', strtotime($billPeriod));
            $toDate = date('Y-m-t', strtotime($billPeriod));

            //$query->andFilterWhere(["OR", ['<=','billPeriodFrom', $fromDate],['<=','billPeriodFrom', $toDate]]);
            //$query->andFilterWhere(["OR", ['>=','billPeriodTo', $fromDate],['>=','billPeriodTo', $toDate]]);
        }
        else {
            $fromDate = date('Y-m-01');
            $toDate = date('Y-m-t');
        }
        
        $query->andFilterWhere(['billPeriodFrom' => $fromDate, 'billPeriodTo' => $toDate]);
        // echo $query->createCommand()->getRawSql();
        return $dataProvider;
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function searchSummary($params)
    {
        $query = AxionPreinspectionBilling::find();
        $query->orderBy([
            'orderNo' => SORT_DESC,
        ]);

        // add conditions that should always apply here
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $this->load($params);
        
        $query->where(["IN","billStatus",["Billed"]]);

        $role = array_keys(Yii::$app->authManager->getRolesByUser(Yii::$app->user->getId()))[0] ;

        if($role == 'BO User')
        {   
            $roUser = User::find()->where(['id' => Yii::$app->user->getId()])->one();
            $query->andFilterWhere([
                'stateId' => $roUser->stateId,
            ]);
        }

        if ($params && !$this->validate()) {
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([    
            'id' => $this->id,
            'createdOn' => $this->createdOn,
            'companyId' => $this->companyId,            
        ]);

        //echo $query->createCommand()->getRawSql();
        return $dataProvider;
    }


    public function getCallerCompany()
    {
        return $this->hasOne(PreinspectionClientCompany::className(), ['id' => 'companyId']);
    }
    
    public function getCallerDivision()
    {
        return $this->hasOne(PreinspectionClientDivision::className(), ['id' => 'stateId']);
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
        return $this->hasOne(User::className(), ['id' => 'hoGeneratedBy']);
    }

    public function getStateDetails($id)
    {
        $res = MasterState::find()->where(['id' => $id])->one();
        return $res;
    }

    public function getSbuHead()
    {
        return $this->hasOne(MasterSbuHead::class, ['id' => 'sbuHeadId']);
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
        $query->join('left join','users as us', 'us.id=axion_preinspection.updatedBy');

        $query->where(['insurerName'=>$companyId,"billId"=>$billId]);
        $query->andWhere(['us.stateId'=>$stateId]);
        $query->andWhere(['in','paymentMode',[1, 3]]);

        $query->select([new Expression('SUM(CASE WHEN `paymentMode` = 1 THEN extraKM ELSE 0 END) as totalKm'), new Expression('COUNT(av2.id) as total2W'),new Expression('COUNT(av3.id) as total3W'),new Expression('COUNT(av4.id) as total4W'),new Expression('COUNT(avc.id) as totalCW')]);

        //echo $query->createCommand()->getRawSql();
        return $query->one();
    }

}
