<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Loans;
use app\models\LoanBanks;
use app\models\User;
use Yii;

/**
 * LoansSearch represents the model behind the search form of `app\models\Loans`.
 */
class LoansSearch extends Loans
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'city', 'state', 'pincode', 'loanAppliedAmount', 'creditScore', 'sourceId', 'sanctionedBank'], 'integer'],
            [['firstname', 'lastname', 'email', 'telephone', 'mobile', 'address', 'dob', 'status', 'panNumber','aadharNumber', 'employmentType', 'loanType', 'sourceType',  'createdOn', 'lastUpdatedOn'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = Loans::find();
       

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);


   if($role == 'Car Dealers')
        {

             $query->andFilterWhere(['or',
            ['userId' => Yii::$app->user->getId()],['sourceId' => Yii::$app->user->getId()]
            ]);
        }
  

  if($role == 'Surveyor' )
        {
           $umodel = User::find()->select('id')->where(['surveyorId'=>Yii::$app->user->getId()])->all();

           foreach($umodel as $obj){
            $obj->id;
            $arr[] = $obj->id;
           }

           $query->andFilterWhere(['or',
            ['userId' => Yii::$app->user->getId()],['in','userId',$arr]
            ]);

           // $query->join('LEFT JOIN','users','users.id = userId');
           // $query->Where(['or',['userId=users.surveyorId'],['users.id=loans.'])

        }

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'city' => $this->city,
            'state' => $this->state,
            'pincode' => $this->pincode,
            'dob' => $this->dob,
            'loanAppliedAmount' => $this->loanAppliedAmount,
            'creditScore' => $this->creditScore,
            'sourceId' => $this->sourceId,
            'sanctionedBank' => $this->sanctionedBank,
            'createdOn' => $this->createdOn,
            'lastUpdatedOn' => $this->lastUpdatedOn,

        ]);

        $query->andFilterWhere(['like', 'firstname', $this->firstname])
            ->andFilterWhere(['like', 'lastname', $this->lastname])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'telephone', $this->telephone])
            ->andFilterWhere(['like', 'mobile', $this->mobile])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'panNumber', $this->panNumber])
            ->andFilterWhere(['like', 'employmentType', $this->employmentType])
            ->andFilterWhere(['like', 'loanType', $this->loanType])
            ->andFilterWhere(['like', 'sourceType', $this->sourceType])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
