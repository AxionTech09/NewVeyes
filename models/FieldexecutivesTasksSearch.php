<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\FieldexecutivesTasks;

/**
 * FieldexecutivesTasksSearch represents the model behind the search form about `app\models\FieldexecutivesTasks`.
 */
class FieldexecutivesTasksSearch extends FieldexecutivesTasks
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'processId', 'fieldexecutiveId'], 'integer'],
            [['processNo','companyName', 'location', 'customerAppointmentDateTime', 'requestDateTime', 'vehicleNumber', 'status', 'processType', 'created_on'], 'safe'],
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
        $query = FieldexecutivesTasks::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['fieldexecutiveId'=>SORT_ASC,'customerAppointmentDateTime'=>SORT_ASC]],
        ]);

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
            'processNo' => $this->processNo,
        ]);


        $query->andFilterWhere(['like', 'companyName', $this->companyName])
              ->andFilterWhere(['like', 'location', $this->location])
              ->andFilterWhere(['like', 'vehicleNumber', $this->vehicleNumber]);
        
         if ( ! is_null($this->requestDateTime) && strpos($this->requestDateTime, ' - ') !== false ) {
            list($start_date, $end_date) = explode(' - ', $this->requestDateTime);
            $format_start_date = \DateTime::createFromFormat('d-m-Y h:i A', $start_date);
            $format_end_date = \DateTime::createFromFormat('d-m-Y h:i A', $end_date);
            $query->andFilterWhere(['between', 'requestDateTime', $format_start_date->format('Y-m-d H:i:s'), $format_end_date->format('Y-m-d H:i:s')]);
        }
        
        if ( ! is_null($this->customerAppointmentDateTime) && strpos($this->customerAppointmentDateTime, ' - ') !== false ) {
            list($start_date, $end_date) = explode(' - ', $this->customerAppointmentDateTime);
            $format_start_date = \DateTime::createFromFormat('d-m-Y h:i A', $start_date);
            $format_end_date = \DateTime::createFromFormat('d-m-Y h:i A', $end_date);
            $query->andFilterWhere(['between', 'customerAppointmentDateTime', $format_start_date->format('Y-m-d H:i:s'), $format_end_date->format('Y-m-d H:i:s')]);
        }
        
        if (! is_null($this->fieldexecutiveId) && $this->fieldexecutiveId > 0  )
        {
            $query->andFilterWhere(['in', 'fieldexecutiveId', $this->fieldexecutiveId]);
        }
        
        if (! is_null($this->status) && $this->status > 0  )
        {
            $query->andFilterWhere(['in', 'status', $this->status]);

        }
        
        if (! is_null($this->processType) &&  $this->processType != 'Select')
        {
        $query->andFilterWhere([
        'processType' => $this->processType,
            ]);
        }

        return $dataProvider;
    }
}
