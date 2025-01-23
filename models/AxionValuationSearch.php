<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\AxionValuation;

/**
 * AxionValuationSearch represents the model behind the search form about `app\models\AxionValuation`.
 */
class AxionValuationSearch extends AxionValuation
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'referenceNo', 'manufacturingYear', 'callerDetails','makeId','modelId','variantId', 'surveyorName', 'userId',], 'integer'],
            [['insurerName', 'insurerDivision', 'insurerBranch', 'intimationDate', 'callerName', 'callerMobileNo', 'callerDetails', 'customerName', 'customerMobile', 'contactPersonMobileNo', 'customerAddress', 'registrationNo', 'engineNo', 'chassisNo', 'vehicleType', 'vehicleTypeRadio', 'manufacturer', 'intimationRemarks', 'vehicleLocation', 'cashCollectedAmount', 'cashToBeCollected', 'rescheduleReason', 'rescheduleDateTime', 'cashStatus', 'status', 'customerAppointDateTime', 'remarks', 'created_on', 'completedSurveyDateTime'], 'safe'],
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
    public function search($params,$request)
    {
        $role = array_keys(Yii::$app->authManager->getRolesByUser(Yii::$app->user->getId()))[0] ;
        
       

        if (!($this->load($params))) {
            if($request == 'index')
            {
              $query = AxionValuation::find()
                ->where('status IN (0, 12, 1)');
            }
            else {
              $query = AxionValuation::find()
                ->where('status IN (8, 101, 102, 104, 200)');
            }
        }
        else {
            $query = AxionValuation::find();
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['status'=>SORT_ASC,'remarks'=>SORT_ASC,'created_on'=>SORT_DESC]],
            'pagination' => [
                'pagesize' => 20 // in case you want a default pagesize
            ]
        ]);
        
        
        if($role == 'Branch Head' || $role == 'Branch Executive')
        {
            $query->andFilterWhere([
            'callerName' => Yii::$app->user->getId(),
            ]);
        }
        else if($role == 'Surveyor')
        {
            $query->andFilterWhere([
            'surveyorName' => Yii::$app->user->getId(),
        ]);
        }
        else if($role == 'Customer')
        {
            $query->andFilterWhere([
            'id' => Yii::$app->user->identity->companyId ,
        ]);
        }

        /*
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
         *
         */


        if (!($this->load($params))) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'referenceNo' => $this->referenceNo,
        ]);

        $query->andFilterWhere(['like', 'insurerName', $this->insurerName]);
        $query->andFilterWhere(['like', 'insurerDivision', $this->insurerDivision]);
        $query->andFilterWhere(['like', 'insurerBranch', $this->insurerBranch]);
        $query->andFilterWhere(['like', 'callerName', $this->callerName]);
        $query->andFilterWhere(['like', 'callerMobileNo', $this->callerMobileNo]);
        $query->andFilterWhere(['like', 'customerName', $this->customerName]);
        $query->andFilterWhere(['like', 'customerMobile', $this->customerMobile]);
        $query->andFilterWhere(['like', 'customerAddress', $this->customerAddress]);
        $query->andFilterWhere(['like', 'registrationNo', $this->registrationNo]);
        $query->andFilterWhere(['like', 'vehicleLocation', $this->vehicleLocation]);
        

        if ( ! is_null($this->intimationDate) && strpos($this->intimationDate, ' - ') !== false ) {
            list($start_date, $end_date) = explode(' - ', $this->intimationDate);
            $format_start_date = \DateTime::createFromFormat('d-m-Y h:i A', $start_date);
            $format_end_date = \DateTime::createFromFormat('d-m-Y h:i A', $end_date);
            $query->andFilterWhere(['between', 'intimationDate', $format_start_date->format('Y-m-d H:i:s'), $format_end_date->format('Y-m-d H:i:s')]);
        }

        if (! is_null($this->surveyorName) && $this->surveyorName > 0  )
        {
            $query->andFilterWhere(['in', 'surveyorName', $this->surveyorName]);
        }

        if (! is_null($this->cashStatus))
        {
            $query->andFilterWhere(['in', 'cashStatus', $this->cashStatus]);
        }

        if ( ! is_null($this->cashToBeCollected) && strpos($this->cashToBeCollected, ' - ') !== false ) {
            list($start_date, $end_date) = explode(' - ', $this->cashToBeCollected);
            $format_start_date = \DateTime::createFromFormat('d-m-Y h:i A', $start_date);
            $format_end_date = \DateTime::createFromFormat('d-m-Y h:i A', $end_date);
            $query->andFilterWhere(['between', 'surveyorAppointDateTime', $format_start_date->format('Y-m-d H:i:s'), $format_end_date->format('Y-m-d H:i:s')]);
        }

        if (! is_null($this->status) && $this->status > 0  )
        {
            $query->andFilterWhere(['in', 'status', $this->status]);
        }

        if ( ! is_null($this->customerAppointDateTime) && strpos($this->customerAppointDateTime, ' - ') !== false ) {
            list($start_date, $end_date) = explode(' - ', $this->customerAppointDateTime);
            $format_start_date = \DateTime::createFromFormat('d-m-Y h:i A', $start_date);
            $format_end_date = \DateTime::createFromFormat('d-m-Y h:i A', $end_date);
            $query->andFilterWhere(['between', 'customerAppointDateTime', $format_start_date->format('Y-m-d H:i:s'), $format_end_date->format('Y-m-d H:i:s')]);
        }

        if ( ! is_null($this->completedSurveyDateTime) && strpos($this->completedSurveyDateTime, ' - ') !== false ) {
            list($start_date, $end_date) = explode(' - ', $this->completedSurveyDateTime);
            $format_start_date = \DateTime::createFromFormat('d-m-Y h:i A', $start_date);
            $format_end_date = \DateTime::createFromFormat('d-m-Y h:i A', $end_date);
            $query->andFilterWhere(['between', 'completedSurveyDateTime', $format_start_date->format('Y-m-d H:i:s'), $format_end_date->format('Y-m-d H:i:s')]);
        }


        return $dataProvider;
    }
}
