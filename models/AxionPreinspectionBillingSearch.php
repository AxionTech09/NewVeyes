<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\AxionPreinspection;
use yii\db\Expression;
use app\models\AxionPreinspectionBilling;

/**
 * AxionPreinspectionSearch represents the model behind the search form about `app\models\AxionPreinspection`.
 */
class AxionPreinspectionBillingSearch extends AxionPreinspectionBilling
{
        public $billPeriod,$billPeriodFrom,$billPeriodTo,$billType,$totalK,$insurerArr;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id','companyId','stateId','branchId','orderNo','parentId','sbuHeadId'], 'integer'],
            [['companyId'],'required','on' => 'search','message' => 'Choose Client'],
            ['billPeriod','required','on'=>'search'],   
            [['createdOn','billPeriodFrom','billPeriodTo', 'generatedDate', 'billPeriodFrom'], 'safe'],
            [['billType', 'billDetails', 'billStatus', 'billNumber'], 'string'],
            [['totalAmount', 'totalIgst', 'totalIgst', 'totalIgst', 'totalGst','billAmount', 'amount2Wheeler', 'amount3Wheeler', 'amount4Wheeler', 'amountCommmercial', 'amountTotalKm'], 'double']
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $role = array_keys(Yii::$app->authManager->getRolesByUser(Yii::$app->user->getId()))[0] ;
        
        $query = AxionPreinspectionBilling::find()->where('billStatus IN ("Billed", "Received")')->andWhere(['>', 'billAmount', 0]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['generatedDate' => SORT_DESC]],
            'pagination' => [
                'pagesize' => 20 // in case you want a default pagesize
            ]
        ]);
        
        
        if (!($this->load($params))) {
            return $dataProvider;
        }

        if($role == 'BO User')
        {   
            $roUser = User::find()->where(['id' => Yii::$app->user->getId()])->one();
            $query->andFilterWhere([
                'stateId' => $roUser->stateId,
            ]);
        }

        $query->andFilterWhere(['orderNo' => $this->orderNo]);
        $query->andFilterWhere(['like', 'billNumber', $this->billNumber]);
        $query->andFilterWhere(['=', 'companyId', $this->companyId]);
        $query->andFilterWhere(['=', 'stateId', $this->stateId]);
        $query->andFilterWhere(['=', 'branchId', $this->branchId]);
        $query->andFilterWhere(['=', 'sbuHeadId', $this->sbuHeadId]);
        $query->andFilterWhere(['like', 'billAmount', $this->billAmount]);
        $query->andFilterWhere(['like', 'totalGst', $this->totalGst]);
        $query->andFilterWhere(['like', 'totalAmount', $this->totalAmount]);
        $query->andFilterWhere(['=', 'billStatus', $this->billStatus]);
        $query->andFilterWhere(['=', 'generatedBy', $this->generatedBy]);
        
        if ( ! is_null($this->generatedDate) && strpos($this->generatedDate, ' - ') !== false ) {
            list($start_date, $end_date) = explode(' - ', $this->generatedDate);
            $query->andFilterWhere(['between', 'generatedDate', date('Y-m-d', strtotime($start_date)), date('Y-m-d', strtotime($end_date))]);
        }

        if ( ! is_null($this->billPeriodFrom) && strpos($this->billPeriodFrom, ' - ') !== false ) {
            list($start_date, $end_date) = explode(' - ', $this->billPeriodFrom);
            $query->andwhere("(billPeriodFrom LIKE '" . date('Y-m', strtotime($start_date)). "%' OR billPeriodFrom LIKE '" .date('Y-m', strtotime($end_date)). "%')");
        }
       
        // echo $query->createCommand()->getRawSql();
        return $dataProvider;
    }

}
