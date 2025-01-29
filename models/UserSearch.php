<?php

namespace app\models;   
  
use Yii;   
use yii\base\Model;   
use yii\data\ActiveDataProvider;   
use app\models\User;
  
/**  
 * EmployeesSearch represents the model behind the search form about `frontend\models\Employees`.  
 */   
class UserSearch extends User   
{   
    /**  
     * @inheritdoc  
     */   
    public function rules()   
    {   
        return [   
            [['id'], 'integer'],   
            // [['name', 'designation', 'email'], 'safe'],

            [['email', 'password'], 'safe'],
            [['stateId','cityId','companyId','branchId','divisionId','branchHeadId','surveyorId','roId'], 'integer'],
            [['firstName','lastName','mobile','email','password','address','pan_number','gst_number','bank_name','account_number','ifsc_code','branch_name','ownerName'], 'string'],
            
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
       $query = User::find();   
  
        // add conditions that should always apply here   
  
        $dataProvider = new ActiveDataProvider([   
            'query' => $query,   
        ]);   
  
        $this->load($params);   
  
        if (!$this->validate()) {   
            // uncomment the following line if you do not want to return any   
    // records when validation fails   
            // $query->where('0=1');   
            return $dataProvider;   
        }   
  
       // grid filtering conditions   
        $query->andFilterWhere([   
            'id' => $this->id,   
               
        ]); 
        $action_name=Yii::$app->controller->action->id;

        $role = array_keys(Yii::$app->authManager->getRolesByUser(Yii::$app->user->getId()))[0] ;
        $current_user = Yii::$app->user->identity->id;

        if($action_name=='bexecutiveuser')
        {
            if($role=='BO User') {
                $query->join('LEFT JOIN','auth_assignment','auth_assignment.user_id = id')
                ->andFilterWhere(['auth_assignment.item_name' => 'Branch Executive'])
                ->andFilterWhere(['users.roId'=> $current_user]);

                //echo $query->createCommand()->sql;
            }
            else {
                $query->join('LEFT JOIN','auth_assignment','auth_assignment.user_id = id')
                ->andFilterWhere(['auth_assignment.item_name' => 'Branch Executive']);
            }   
        }
        elseif($action_name=='surveyor')
        {
            if($role=='BO User')
            {
                $query->join('LEFT JOIN','auth_assignment','auth_assignment.user_id = id')
                ->andFilterWhere(['auth_assignment.item_name' => 'Surveyor'])
                ->andFilterWhere(['users.roId'=> $current_user]);
            }
            else
            {
              $query->join('LEFT JOIN','auth_assignment','auth_assignment.user_id = id')
            ->andFilterWhere(['auth_assignment.item_name' => 'Surveyor']);  
            }            
        }
        

      // $query->join('LEFT JOIN','auth_assignment','auth_assignment.user_id = id')
      // ->andFilterWhere(['auth_assignment.item_name' => 'Surveyor']);
      // ->andFilterWhere(['users.roId' => $current_user]);
      
        $query->andFilterWhere(['like', 'firstName', $this->firstName]);   
        $query->andFilterWhere(['like', 'email', $this->email]);  
        // $query->andFilterWhere(['like', 'lastName', $this->lastName]);     
        $query->andFilterWhere(['like', 'mobile', $this->mobile]);   
        // $query->andFilterWhere(['like', 'lastName', $this->lastName]);   
        // $query->andFilterWhere(['like', 'lastName', $this->lastName]);   
  
        return $dataProvider;   
      }   
  }   