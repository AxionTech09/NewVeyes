<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\AxionPreinspection;
use app\models\User;
use yii\db\Expression;
use app\models\AxionPreinspectionBilling;

/**
 * AxionPreinspectionSearch represents the model behind the search form about `app\models\AxionPreinspection`.
 */
class AxionPreinspectionSearch extends AxionPreinspection
{
        public $billPeriod,$billPeriodFrom,$billPeriodTo,$billType,$totalK,$insurerArr,$day;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'referenceNo', 'manufacturingYear', 'extraKM', 'surveyorName', 'userId', 'followupReason','stateId'], 'integer'],
            [['vTypeName','insurerName', 'insurerDivision', 'insurerBranch', 'intimationDate', 'callerName', 'callerMobileNo', 'callerDetails', 'insuredName', 'insuredMobile', 'contactPersonMobileNo', 'insuredAddress', 'registrationNo', 'engineNo', 'chassisNo', 'vehicleType', 'vehicleTypeRadio', 'manufacturer', 'model', 'intimationRemarks', 'surveyLocation', 'surveyLocation2', 'sendLink', 'surveyorAppointDateTime', 'rescheduleReason', 'rescheduleDateTime', 'inspectionType', 'paymentMode', 'status', 'customerAppointDateTime', 'remarks', 'created_on', 'completedSurveyDateTime','surveyDoneOn','uploadSource','cashCollection','vType_id','billPeriodFrom','billPeriodTo', 'sbuCode', 'ErrorDesc','day','qcDoneOn','cancelledOn'], 'safe'],
            [['billPeriod','insurerName','billType','insurerArr'],'required']
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
                $query = AxionPreinspection::find()
                        ->where('status IN (0,12,1,101,102,104,9)')
                        ->orderBy('referenceNo DESC, completedSurveyDateTime DESC');

                $statusCondition = 'status IN (0,12,1,101,102,104,9)';
            }
            elseif ($request == 'fresh') 
            {
                
                $query = AxionPreinspection::find()
                ->where('status IN (0, 100)')
                ->orderBy('referenceNo DESC, completedSurveyDateTime DESC');
               $statusCondition = 'status IN (0, 100)';
            }
            elseif ($request == 'scheduled') 
            {
                
                $query = AxionPreinspection::find()
                ->where('status IN (1, 12)')
                ->orderBy('referenceNo DESC, completedSurveyDateTime DESC');
                $statusCondition = 'status IN (1, 12)';
            }
            elseif ($request == 'completed') 
            {  
                $query = AxionPreinspection::find()
                        ->where('status IN (8)')
                        ->orderBy('referenceNo DESC, completedSurveyDateTime DESC');

                $statusCondition = 'status IN (8)';
            }
            else
            {    
                $query = AxionPreinspection::find()
                        ->where('status IN (9, 101, 102, 104,103)')
                        ->orderBy('referenceNo DESC, completedSurveyDateTime DESC');
                        
                $statusCondition = 'status IN (9, 101, 102, 104,103)';
            }
        }
        else {

            $query = AxionPreinspection::find();
           
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['status'=>SORT_ASC,'remarks'=>SORT_ASC,'created_on'=>SORT_DESC]],
            'pagination' => [
                'pagesize' => 20 // in case you want a default pagesize
            ]
        ]);

        
        if($role == 'Branch Head')
        {
            $user = User::findOne(Yii::$app->user->getId());
            $query->andFilterWhere([
                'insurerName' => $user->companyId,
            ]);
        }
        else if($role == 'Branch Executive')
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
        else if($role == 'Veyes UAT')
        {
            $query->andFilterWhere([
                'userId' => Yii::$app->user->getId(),
            ]);
        }
        else if($role == 'Customer')
        {
            $query->andFilterWhere([
                'id' => Yii::$app->user->identity->companyId ,
            ]);
        }
        else if($role == 'BO User') {

            $bexeUsers_list=$surveyorUsers_list=$boUsers_list=[];

            //Get Particular Bo User's/Ro User's Branch Executives user id. 
            $bexeUsers = User::find()->select('id')->join('LEFT JOIN','auth_assignment','auth_assignment.user_id = id')
                        ->andFilterWhere(['auth_assignment.item_name' => 'Branch Executive'])
                        ->andFilterWhere(['users.roId' => Yii::$app->user->identity->id])->all();
            

            if($bexeUsers){
                foreach ($bexeUsers as $key => $value) {
                    $bexeUsers_list[] = $value->id;
                }
            }
            $bexeUsers_list = ($bexeUsers_list) ? implode(',', $bexeUsers_list) : '';
 
            $surveyorUsers = User::find()->select('id')->join('LEFT JOIN','auth_assignment','auth_assignment.user_id = id')
                            ->andFilterWhere(['auth_assignment.item_name' => 'Surveyor'])
                            ->andFilterWhere(['users.roId' => Yii::$app->user->identity->id])->all();

            if($surveyorUsers){
                foreach ($surveyorUsers as $key => $value) {
                    $surveyorUsers_list[] = $value->id;
                }
            }
            $surveyorUsers_list = ($surveyorUsers_list) ? implode(',', $surveyorUsers_list) : '';


            //Get All Bo User's/Ro User's user id. 
            $boUsers = User::find()->select('id')->join('LEFT JOIN','auth_assignment','auth_assignment.user_id = id')
                        ->andFilterWhere(['auth_assignment.item_name' => 'BO User'])
                        ->andFilterWhere(['!=', 'users.id', Yii::$app->user->identity->id])->all();

            if($boUsers){
                foreach ($boUsers as $key => $value) {
                    $boUsers_list[] = $value->id;
                }
            }
            $boUsers_list = ($boUsers_list) ? implode(',', $boUsers_list) : '';
            

            if ($statusCondition == '') {
                $statusCondition = "status IS NOT NULL";
            }

            // Make sure whether we don't get other RO's case
            $statusCondition .= ' AND userId NOT IN ('.$boUsers_list.')';

            if($bexeUsers_list && !empty($bexeUsers_list)){
                if($surveyorUsers_list && !empty($surveyorUsers_list)){
                    $query->where(['and', $statusCondition, ['or', 'userId = '.Yii::$app->user->getId(), 'callerName IN ('.$bexeUsers_list.')', 'surveyorName IN ('.$surveyorUsers_list.')']]);
                }else{
                    $query->where(['and', $statusCondition, ['or', 'userId = '.Yii::$app->user->getId(), 'callerName IN ('.$bexeUsers_list.')']]);
                }                
            }else{
                if($surveyorUsers_list && !empty($surveyorUsers_list)){
                    $query->where(['and', $statusCondition, ['or', 'userId = '.Yii::$app->user->getId(), 'surveyorName IN ('.$surveyorUsers_list.')']]);
                }else{
                    $query->where(['and', $statusCondition, ['or', 'userId = '.Yii::$app->user->getId()]]);
                }      
            }
           // $query->where(['and', $statusCondition, ['or', 'userId = '.Yii::$app->user->getId(), 'callerName IN ('.$bexeUsers_list.')', 'surveyorName IN ('.$surveyorUsers_list.')']]);
            // echo $query->createCommand()->sql;
        }
        //die;
        /*else if($role == 'BO User')
        {
            $query->andFilterWhere([
            'userId' => Yii::$app->user->getId(),
            ]);

            //Get Particular Bo User's/Ro User's Branch Executives user id. 
            $bexeUsers = User::find()->select('id')->join('LEFT JOIN','auth_assignment','auth_assignment.user_id = id')
            ->andFilterWhere(['auth_assignment.item_name' => 'Branch Executive'])
            ->andFilterWhere(['users.roId '=> Yii::$app->user->identity->id]);

            $query->orFilterWhere([ 'in', 'callerName', $bexeUsers]);

            $SurveyorUsers = User::find()->select('id')->join('LEFT JOIN','auth_assignment','auth_assignment.user_id = id')
            ->andFilterWhere(['auth_assignment.item_name' => 'Surveyor'])
            ->andFilterWhere(['users.roId '=> Yii::$app->user->identity->id]);

            $query->orFilterWhere([ 'in', 'surveyorName', $SurveyorUsers]);
        }*/
        //echo $query->createCommand()->sql;
        /*
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
         *
         */
            //print_r($this->paymentMode);
            // echo $this->paymentMode[0];exit;
        if (!($this->load($params))) {
            return $dataProvider;
        }

        $query->andFilterWhere(['referenceNo' => $this->referenceNo]);
        $query->andFilterWhere(['like', 'insurerName', $this->insurerName]);
        $query->andFilterWhere(['like', 'insurerDivision', $this->insurerDivision]);
        $query->andFilterWhere(['like', 'insurerBranch', $this->insurerBranch]);
        $query->andFilterWhere(['like', 'callerName', $this->callerName]);
        $query->andFilterWhere(['like', 'callerMobileNo', $this->callerMobileNo]);
        $query->andFilterWhere(['like', 'contactPersonMobileNo', $this->contactPersonMobileNo]);
        $query->andFilterWhere(['like', 'insuredName', $this->insuredName]);
        $query->andFilterWhere(['like', 'insuredMobile', $this->insuredMobile]);
        $query->andFilterWhere(['like', 'insuredAddress', $this->insuredAddress]);
        $query->andFilterWhere(['like', 'registrationNo', $this->registrationNo]);
        $query->andFilterWhere(['like', 'surveyLocation', $this->surveyLocation]);
        $query->andFilterWhere(['like', 'surveyLocation2', $this->surveyLocation2]);
        $query->andFilterWhere(['like', 'extraKM', $this->extraKM]);
        $query->andFilterWhere(['like', 'uploadSource', $this->uploadSource]);
        $query->andFilterWhere(['like', 'cashCollection', $this->cashCollection]);
        $query->andFilterWhere(['like', 'vType_id', $this->vType_id]);
        $query->andFilterWhere(['like', 'vType.vType', $this->vTypeName->vType]);
        $query->andFilterWhere(['like', 'sbuCode', $this->sbuCode]);
        $query->andFilterWhere(['like', 'ErrorDesc', $this->ErrorDesc]);
        $query->andFilterWhere(['=', 'followupReason', $this->followupReason]);
        $query->andFilterWhere(['=', 'stateId', $this->stateId]);
        
        if ( ! is_null($this->intimationDate) && strpos($this->intimationDate, ' - ') !== false ) {
            if($this->day == 6){
                list($start_date, $end_date) = explode(' - ', $this->intimationDate);
                $format_start_date = \DateTime::createFromFormat('d-m-Y h:i A', $start_date);
                $format_end_date = \DateTime::createFromFormat('d-m-Y h:i A', $end_date);
                $query->andFilterWhere(['<','intimationDate',$format_end_date->format('Y-m-d H:i:s')]);
            }else{
                list($start_date, $end_date) = explode(' - ', $this->intimationDate);
                $format_start_date = \DateTime::createFromFormat('d-m-Y h:i A', $start_date);
                $format_end_date = \DateTime::createFromFormat('d-m-Y h:i A', $end_date);
                $query->andFilterWhere(['between', 'intimationDate', $format_start_date->format('Y-m-d H:i:s'), $format_end_date->format('Y-m-d H:i:s')]);
            }
        }

        if (! is_null($this->surveyorName) && $this->surveyorName > 0  )
        {
            $query->andFilterWhere(['in', 'surveyorName', $this->surveyorName]);
        }


        if (! is_null($this->paymentMode) && count($this->paymentMode)>1)
        {
            $query->andFilterWhere(['in', 'paymentMode', $this->paymentMode]);
        }

        if ( ! is_null($this->surveyorAppointDateTime) && strpos($this->surveyorAppointDateTime, ' - ') !== false ) {
            list($start_date, $end_date) = explode(' - ', $this->surveyorAppointDateTime);
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

        if ( ! is_null($this->completedSurveyDateTime) && strpos($this->completedSurveyDateTime, ' - ') !== false ) {

            list($start_date, $end_date) = explode(' - ', $this->completedSurveyDateTime);
            $format_start_date = \DateTime::createFromFormat('d-m-Y h:i A', $start_date);
            $format_end_date = \DateTime::createFromFormat('d-m-Y h:i A', $end_date);
            $query->andFilterWhere(['between', 'completedSurveyDateTime', $format_start_date->format('Y-m-d H:i:s'), $format_end_date->format('Y-m-d H:i:s')]);
        }

        if ( ! is_null($this->surveyDoneOn) && strpos($this->surveyDoneOn, ' - ') !== false ) {

            list($start_date, $end_date) = explode(' - ', $this->surveyDoneOn);
            $format_start_date = \DateTime::createFromFormat('d-m-Y h:i A', $start_date);
            $format_end_date = \DateTime::createFromFormat('d-m-Y h:i A', $end_date);
            $query->andFilterWhere(['between', 'surveyDoneOn', $format_start_date->format('Y-m-d H:i:s'), $format_end_date->format('Y-m-d H:i:s')]);
        }
                
        if ( ! is_null($this->qcDoneOn) && strpos($this->qcDoneOn, ' - ') !== false ) {

            list($start_date, $end_date) = explode(' - ', $this->qcDoneOn);
            $format_start_date = \DateTime::createFromFormat('d-m-Y h:i A', $start_date);
            $format_end_date = \DateTime::createFromFormat('d-m-Y h:i A', $end_date);
            $query->andFilterWhere(['between', 'qcDoneOn', $format_start_date->format('Y-m-d H:i:s'), $format_end_date->format('Y-m-d H:i:s')]);
        }

        if ( ! is_null($this->cancelledOn) && strpos($this->cancelledOn, ' - ') !== false ) {

            list($start_date, $end_date) = explode(' - ', $this->cancelledOn);
            $format_start_date = \DateTime::createFromFormat('d-m-Y h:i A', $start_date);
            $format_end_date = \DateTime::createFromFormat('d-m-Y h:i A', $end_date);
            $query->andFilterWhere(['between', 'cancelledOn', $format_start_date->format('Y-m-d H:i:s'), $format_end_date->format('Y-m-d H:i:s')]);
        }

        // echo $query->createCommand()->getRawSql();
        return $dataProvider;
    }

    public function checkWhichRoCase($RO, $id = '') {
        $query = AxionPreinspection::find();

        $bexeUsers_list=$surveyorUsers_list=$boUsers_list=[];

        //Get Particular Bo User's/Ro User's Branch Executives user id. 
        $bexeUsers = User::find()->select('id')->join('LEFT JOIN','auth_assignment','auth_assignment.user_id = id')
                    ->andFilterWhere(['auth_assignment.item_name' => 'Branch Executive'])
                    ->andFilterWhere(['users.roId '=> $RO])->all();
        

        if($bexeUsers){
            foreach ($bexeUsers as $key => $value) {
                $bexeUsers_list[] = $value->id;
            }
        }
        $bexeUsers_list = ($bexeUsers_list) ? implode(',', $bexeUsers_list) : '';

        $surveyorUsers = User::find()->select('id')->join('LEFT JOIN','auth_assignment','auth_assignment.user_id = id')
                        ->andFilterWhere(['auth_assignment.item_name' => 'Surveyor'])
                        ->andFilterWhere(['users.roId '=> $RO])->all();

        if($surveyorUsers){
            foreach ($surveyorUsers as $key => $value) {
                $surveyorUsers_list[] = $value->id;
            }
        }
        $surveyorUsers_list = ($surveyorUsers_list) ? implode(',', $surveyorUsers_list) : '';


        //Get All Bo User's/Ro User's user id. 
        $boUsers = User::find()->select('id')->join('LEFT JOIN','auth_assignment','auth_assignment.user_id = id')
                    ->andFilterWhere(['auth_assignment.item_name' => 'BO User'])
                    ->andFilterWhere(['!=', 'users.id', $RO])->all();

        if($boUsers){
            foreach ($boUsers as $key => $value) {
                $boUsers_list[] = $value->id;
            }
        }
        $boUsers_list = ($boUsers_list) ? implode(',', $boUsers_list) : '';
        

        // Make sure whether we don't get other RO's case
        $statusCondition = 'userId NOT IN ('.$boUsers_list.')';

        if ($id != '') {
            $statusCondition .= "AND `id` = ".$id;
        }

        if($bexeUsers_list && !empty($bexeUsers_list)){
            if($surveyorUsers_list && !empty($surveyorUsers_list)){
                    $query->where(['and', $statusCondition, ['or', 'userId = '.$RO, 'callerName IN ('.$bexeUsers_list.')', 'surveyorName IN ('.$surveyorUsers_list.')']]);
            }else{
                    $query->where(['and', $statusCondition, ['or', 'userId = '.$RO, 'callerName IN ('.$bexeUsers_list.')']]);
            }                
        }else{
            if($surveyorUsers_list && !empty($surveyorUsers_list)){
                    $query->where(['and', $statusCondition, ['or', 'userId = '.$RO, 'surveyorName IN ('.$surveyorUsers_list.')']]);
            }else{
                    $query->where(['and', $statusCondition, ['or', 'userId = '.$RO]]);
            }      
        }

        //echo $query->createCommand()->getRawSql();exit;
        $result = $query->all();
        if (count($result) > 0)
            return true;
        else   
            return false;
    }

    public function getRoFromCaseID($id) {
        $inspectionData = AxionPreinspection::find()->where(['id'=> $id])->all();
        
        //print_r($inspectionData); die;
        //echo $inspectionData->createCommand()->getRawSql(); die;

        //Get All Bo User's / Ro User's user id. 
        $boUsers = User::find()->select('id')->join('LEFT JOIN','auth_assignment','auth_assignment.user_id = id')
                    ->andFilterWhere(['auth_assignment.item_name' => 'BO User'])->all();

        if($boUsers){
            foreach ($boUsers as $key => $value) {
                $boUsers_list[] = $value->id;
            }
        }

        if (in_array($inspectionData[0]['userId'], $boUsers_list)) {
            return $inspectionData[0]['userId'];
        }
        else {
            $RO = User::find()->select('roId')
                ->where(['id' => $inspectionData[0]['callerName']])
                ->all();

            if (!empty($RO[0]['roId'])){
                return $RO[0]['roId'];
            }
            else {
                $RO = User::find()->select('roId')
                    ->where(['id' => $inspectionData[0]['surveyorName']])
                    ->all();

                if (!empty($RO[0]['roId'])){
                    return $RO[0]['roId'];
                }
                else {
                    return 16; // Superadmin's Userid
                }
            }
        }
        
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function searchCorporate($params)
    {
        $query = AxionPreinspection::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
        
        if(!Yii::$app->request->isPjax){
            $this->insurerName = $this->insurerArr ? $this->insurerArr : '';
        }else{
            $this->insurerName = $this->insurerName ? $this->insurerName : '';
        }
        if (!$this->validate()) {
            $dataProvider->totalCount = 0;
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'axion_preinspection.id' => $this->id,
            'axion_preinspection.created_on' => $this->created_on,
            //'insurerName' => $this->insurerName
        ]);
        
        if(Yii::$app->request->isPjax){
            $query->andFilterWhere(['in','insurerName',$this->insurerName]);
        }
        $query->join('left join','axion_preinspection_vehicle as av2', 'av2.preinspection_id=axion_preinspection.id AND av2.vType="2-WHEELER"');
        $query->join('left join','axion_preinspection_vehicle as av3', 'av3.preinspection_id=axion_preinspection.id AND av3.vType="3-WHEELER"');
        $query->join('left join','axion_preinspection_vehicle as av4', 'av4.preinspection_id=axion_preinspection.id AND av4.vType="4-WHEELER"');
        $query->join('left join','axion_preinspection_vehicle as avc', 'avc.preinspection_id=axion_preinspection.id AND avc.vType="COMMERCIAL"');

        if(!$params){
            $dataProvider->totalCount = 0;
          }else{
            
            $fromDate = ($this->billPeriodFrom) ? date('Y-m-d',strtotime($this->billPeriodFrom)) :'';
            $toDate = ($this->billPeriodTo) ? date('Y-m-d',strtotime($this->billPeriodTo)) :'';
            if(!Yii::$app->request->isPjax){
                $query->andFilterWhere(['in','insurerName',$this->insurerArr]);
            }
            $query->andFilterWhere(['in','axion_preinspection.status',[101, 102, 104]]);

            $query->andFilterWhere(['between','axion_preinspection.created_on', $fromDate, $toDate]);

            if($this->billType == 'division'){
                $query->groupBy(['insurerDivision']);

            }else if($this->billType == 'branch'){
                $query->groupBy(['insurerBranch']);
            }
            $query->select([new Expression('SUM(extraKM) as totalKm'),new Expression('COUNT(av2.id) as total2W'),new Expression('COUNT(av3.id) as total3W'),new Expression('COUNT(av4.id) as total4W'),new Expression('COUNT(avc.id) as totalCW'),'axion_preinspection.*']);
           
            //$query->andWhere(['in','insurerName',$this->insurerName]);
          }

        //echo $query->createCommand()->getRawSql();
        return $dataProvider;
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function searchStateLevel($params)
    {
        $query = AxionPreinspection::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'created_on' => $this->created_on
        ]);

        //$query->andFilterWhere(['like', 'bankName', $this->bankName]);

        return $dataProvider;
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function searchCompanyBilling($companyId,$fromDate,$toDate)
    {
        $query = AxionPreinspection::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $query->join('left join','axion_preinspection_vehicle as av2', 'av2.preinspection_id=axion_preinspection.id AND av2.vType="2-WHEELER"');
        $query->join('left join','axion_preinspection_vehicle as av3', 'av3.preinspection_id=axion_preinspection.id AND av3.vType="3-WHEELER"');
        $query->join('left join','axion_preinspection_vehicle as av4', 'av4.preinspection_id=axion_preinspection.id AND av4.vType="4-WHEELER"');
        $query->join('left join','axion_preinspection_vehicle as avc', 'avc.preinspection_id=axion_preinspection.id AND avc.vType="COMMERCIAL"');
        $query->join('left join','preinspection_client_company as pc', 'pc.id=axion_preinspection.insurerName');
        $query->join('left join','users as us', 'us.id=axion_preinspection.updatedBy'); 


        $query->where(['in','axion_preinspection.status',[101, 102, 104]]);
        $query->andWhere(['between','axion_preinspection.completedSurveyDateTime', $fromDate, $toDate]);
        $query->andWhere(['insurerName'=>$companyId]);
        $query->andWhere(['in','paymentMode',[1, 3]]);

        $query->groupBy(['insurerName']);            
        
        $query->select([new Expression('SUM(CASE WHEN `paymentMode` = 1 THEN extraKM ELSE 0 END) as totalKm'),new Expression('COUNT(av2.id) as total2W'),new Expression('COUNT(av3.id) as total3W'),new Expression('COUNT(av4.id) as total4W'),new Expression('COUNT(avc.id) as totalCW'),'axion_preinspection.*','pc.companyName','pc.billType','pc.rate2Wheeler','pc.rate3Wheeler','pc.rate4Wheeler','pc.rateCommercial','pc.rateConveyance']);
        //$query->andWhere(['in','insurerName',$this->insurerName]);
        //echo $query->createCommand()->getRawSql();exit;
        return $dataProvider;
    }
    

    public function sbuLevel($companyId, $fromDate, $toDate, $sbuHeadId)
    {
        $query = AxionPreinspection::find();
        
        $query->join('left join','axion_preinspection_vehicle as av2', 'av2.preinspection_id=axion_preinspection.id AND av2.vType="2-WHEELER"');
        $query->join('left join','axion_preinspection_vehicle as av3', 'av3.preinspection_id=axion_preinspection.id AND av3.vType="3-WHEELER"');
        $query->join('left join','axion_preinspection_vehicle as av4', 'av4.preinspection_id=axion_preinspection.id AND av4.vType="4-WHEELER"');
        $query->join('left join','axion_preinspection_vehicle as avc', 'avc.preinspection_id=axion_preinspection.id AND avc.vType="COMMERCIAL"');
        $query->join('left join','preinspection_client_company as pc', 'pc.id=axion_preinspection.insurerName');
        
        //$query->join('left join','users as us', 'us.id=axion_preinspection.userId OR callerName=us.id'); 
        //$query->join('left join','users as us', 'us.id=axion_preinspection.userId OR callerName=us.id OR surveyorName=us.id'); 
        //$query->join('left join','users as us', 'us.id=axion_preinspection.updatedBy'); 
        
        $query->andWhere(['in','axion_preinspection.status',[101, 102, 104]]);
        $query->andWhere(['between','axion_preinspection.completedSurveyDateTime', $fromDate, $toDate]);
        
        $sbuCodeList = MasterSbu::find()->where(['sbuHead' => $sbuHeadId])->all(); 
        $sbuCodes = [];   
        foreach ($sbuCodeList as $sbcCodeRow)
        {
            $sbuCodes[] = $sbcCodeRow['sbuCode'];
        }   
         
        $query->andWhere(['insurerName' => $companyId]);
        $query->andWhere(['in', 'sbuCode', $sbuCodes]);
        $query->andWhere(['in', 'paymentMode', [1, 3]]);

        //$query->select([new Expression('SUM(extraKM) as totalKm'),new Expression('COUNT(av2.id) as total2W'),new Expression('COUNT(av3.id) as total3W'),new Expression('COUNT(av4.id) as total4W'),new Expression('COUNT(avc.id) as totalCW'),'pc.companyName','pc.billType','pc.rate2Wheeler','pc.rate3Wheeler','pc.rate4Wheeler','pc.rateCommercial','pc.rateConveyance','pc.billingAddress']);
            //$query->andWhere(['in','insurerName',$this->insurerName]);

        //echo $query->createCommand()->getRawSql().'<br>';exit;
        return $query;
    }

    public function stateLevel($companyId,$fromDate,$toDate,$roUsersStateWise,$stateId)
    {
        $query = AxionPreinspection::find();
        
        $query->join('left join','axion_preinspection_vehicle as av2', 'av2.preinspection_id=axion_preinspection.id AND av2.vType="2-WHEELER"');
        $query->join('left join','axion_preinspection_vehicle as av3', 'av3.preinspection_id=axion_preinspection.id AND av3.vType="3-WHEELER"');
        $query->join('left join','axion_preinspection_vehicle as av4', 'av4.preinspection_id=axion_preinspection.id AND av4.vType="4-WHEELER"');
        $query->join('left join','axion_preinspection_vehicle as avc', 'avc.preinspection_id=axion_preinspection.id AND avc.vType="COMMERCIAL"');
        $query->join('left join','preinspection_client_company as pc', 'pc.id=axion_preinspection.insurerName');
        
        //$query->join('left join','users as us', 'us.id=axion_preinspection.userId OR callerName=us.id'); 
        //$query->join('left join','users as us', 'us.id=axion_preinspection.userId OR callerName=us.id OR surveyorName=us.id'); 
        $query->join('left join','users as us', 'us.id=axion_preinspection.updatedBy'); 
        
        $query->andWhere(['in','axion_preinspection.status',[101, 102, 104]]);

        // For TATA AIG
        if ($companyId == 5) {
            $query->andWhere(['between','axion_preinspection.intimationDate', $fromDate, $toDate]);
            $query->andWhere(['between','axion_preinspection.completedSurveyDateTime', $fromDate, date('Y-m-d H:i:s', strtotime('+5 days', strtotime($toDate)))]);
        } 
        else {
            $query->andWhere(['between','axion_preinspection.completedSurveyDateTime', $fromDate, $toDate]);
        }
        
        $bexeUsers_list = $surveyorUsers_list = [];
        //Get Particular Bo User's/Ro User's Branch Executives user id. 
        $bexeUsers = User::find()->select('id')->join('LEFT JOIN','auth_assignment','auth_assignment.user_id = id')
                    ->andFilterWhere(['auth_assignment.item_name' => 'Branch Executive'])
                    ->andFilterWhere(['in', 'users.roId', $roUsersStateWise])->all();
        

        if($bexeUsers){
            foreach ($bexeUsers as $key => $value) {
                $bexeUsers_list[] = $value->id;
            }
        }

        $surveyorUsers = User::find()->select('id')->join('LEFT JOIN','auth_assignment','auth_assignment.user_id = id')
                        ->andFilterWhere(['auth_assignment.item_name' => 'Surveyor'])
                        ->andFilterWhere(['in', 'users.roId', $roUsersStateWise])->all();

        if($surveyorUsers){
            foreach ($surveyorUsers as $key => $value) {
                $surveyorUsers_list[] = $value->id;
            }
        }

        if($stateId == 23){
            $usersLists = array_merge($roUsersStateWise, $bexeUsers_list, $surveyorUsers_list,[16]); 
        }else{
            $usersLists = array_merge($roUsersStateWise, $bexeUsers_list, $surveyorUsers_list);
        }

        $query->andWhere(['in', 'updatedBy', $usersLists]);
        //$query->andWhere(["us.stateId"=>$stateId]);            
        $query->andWhere(['insurerName'=>$companyId]);
        $query->andWhere(['in','paymentMode',[1, 3]]);

        //$query->select([new Expression('SUM(extraKM) as totalKm'),new Expression('COUNT(av2.id) as total2W'),new Expression('COUNT(av3.id) as total3W'),new Expression('COUNT(av4.id) as total4W'),new Expression('COUNT(avc.id) as totalCW'),'pc.companyName','pc.billType','pc.rate2Wheeler','pc.rate3Wheeler','pc.rate4Wheeler','pc.rateCommercial','pc.rateConveyance','pc.billingAddress']);
            //$query->andWhere(['in','insurerName',$this->insurerName]);

        //echo $query->createCommand()->getRawSql();exit;
        return $query;
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function branchLevel($companyId,$fromDate,$toDate,$userId,$branchId)
    {
        $query = AxionPreinspection::find();

        $query->join('left join','axion_preinspection_vehicle as av2', 'av2.preinspection_id=axion_preinspection.id AND av2.vType="2-WHEELER"');
        $query->join('left join','axion_preinspection_vehicle as av3', 'av3.preinspection_id=axion_preinspection.id AND av3.vType="3-WHEELER"');
        $query->join('left join','axion_preinspection_vehicle as av4', 'av4.preinspection_id=axion_preinspection.id AND av4.vType="4-WHEELER"');
        $query->join('left join','axion_preinspection_vehicle as avc', 'avc.preinspection_id=axion_preinspection.id AND avc.vType="COMMERCIAL"');
        $query->join('left join','preinspection_client_company as pc', 'pc.id=axion_preinspection.insurerName');
        
        $query->join('left join','users as us', 'us.id=axion_preinspection.updatedBy'); 
        
        $query->andWhere(['in','axion_preinspection.status',[101, 102, 104]]);

        $query->andWhere(['between','axion_preinspection.completedSurveyDateTime', $fromDate, $toDate]);

        //$query->andWhere(['OR', ["userId"=>$userId],['roId' => $userId]]);

        $query->andWhere(["insurerBranch"=>$branchId]);             

        $query->andWhere(['insurerName'=>$companyId]);

        $query->andWhere(['in', 'paymentMode', [1, 3]]);

        // echo $query->createCommand()->getRawSql();exit;
        return $query;
    }
}
