<?php

namespace app\controllers;

use Yii;
use app\models\User;
use app\models\UserSearch;
use app\models\MasterCity;
use app\models\MasterState;
use app\models\PreinspectionClientCompany;
use app\models\PreinspectionClientDivision;
use app\models\PreinspectionClientBranch;
use app\models\RoCaseAssignment;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\widgets\ActiveForm;
use yii\web\Response;
use yii\rbac\DbManager;

/**
 * UserDataController implements the CRUD actions for User model.
 */
class UserDataController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index','view','create','update','delete'],
                'rules' => [
                    [
                        'actions' => ['index','view','create','update','delete'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete-admin' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Userdata models.
     * @return mixed
     */
    public function actionAdmin()
    {

        $query = User::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
   
        $query->join('LEFT JOIN','auth_assignment','auth_assignment.user_id = id')
      ->andFilterWhere(['auth_assignment.item_name' => 'Admin']);
        
        return $this->render('admin', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Userdata model.
     * @param integer $id
     * @return mixed
     */
    public function actionViewAdmin($id)
    {

        return $this->render('adminview', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Userdata model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreateAdmin()
    {
        /*
        if(Yii::$app->user->identity->type != 'Admin')
        {
             return $this->goHome();
        }
         $model = new Userdata();
         $staff = Userdata::find()
                ->where(['type' => 'Staff'])
                ->all();
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
               return ActiveForm::validate($model);
            }
       

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            //return $this->redirect(['view', 'id' => $model->id]);
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
                'staff' => $staff,
            ]);
        }
         * 
         */
         $model = new User();
         $city = MasterCity::find()
                   ->all();
         
         if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
               return ActiveForm::validate($model);
            }
        if ($model->load(Yii::$app->request->post())) {
            date_default_timezone_set('Asia/Calcutta');
            $currentDateTime = date('Y-m-d H:i:s');
            $model->activationLink = 'Y';
            $model->createdOn = $currentDateTime;
                        
            if($model->save())
            {
                $auth = new DbManager;
                $auth->init();
                $role = $auth->getRole('Admin');
                $auth->assign($role, $model->id);
            }
            //print_r($model->getErrors());
            //die('test');

           
            return $this->redirect(['admin']);
    
        } else {
            return $this->render('admincreate', [
                'model' => $model,
                'city' => $city,
            ]);
        }
    }

    /**
     * Updates an existing Userdata model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdateAdmin($id)
    {
        /*
        if(Yii::$app->user->identity->type != 'Admin')
        {
             return $this->goHome();
        }
          $model = $this->findModel($id);
          $staff = Userdata::find()
                ->where(['type' => 'Staff'])
                ->all();
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
               return ActiveForm::validate($model);
            }
      

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            //return $this->redirect(['view', 'id' => $model->id]);
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
                'staff' => $staff,
            ]);
        }
         * 
         */
        $model = $this->findModel($id);
        $city = MasterCity::find()
                   ->all();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
               return ActiveForm::validate($model);
            }
        
        if ($model->load(Yii::$app->request->post()) ) {
            $model->password_repeat = $model->password;
            $model->save();
            //print_r($model->getErrors());
            //die('test');
            return $this->redirect(['admin']);
        } else {
            return $this->render('adminupdate', [
                'model' => $model,
                'city' => $city,
            ]);
        }
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDeleteAdmin($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['admin']);
    }
    
    
    
    public function actionSurveyor()
    {
        $role = array_keys(Yii::$app->authManager->getRolesByUser(Yii::$app->user->getId()))[0] ;
        $current_user = Yii::$app->user->identity->id;

        $searchModel = new UserSearch();   
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        // $query = User::find();
        // $dataProvider = new ActiveDataProvider([
        //     'query' => $query,
        // ]);
        
        // if($role=='Superadmin')
        // {
        //     $query->join('LEFT JOIN','auth_assignment','auth_assignment.user_id = id')
        //     ->andFilterWhere(['auth_assignment.item_name' => 'Surveyor']);
        // }
        // else
        // {
        //     $query->join('LEFT JOIN','auth_assignment','auth_assignment.user_id = id')
        //   ->andFilterWhere(['auth_assignment.item_name' => 'Surveyor'])
        //   ->andFilterWhere(['users.roId' => $current_user]);  
        // }
        
        
        return $this->render('surveyor', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }


    public function actionViewSurveyor($id)
    {

        return $this->render('surveyorview', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreateSurveyor()
    {

         $model = new User();

         $model->scenario='surveyor';

         $city = MasterCity::find()
                   ->all();
         $state=MasterState::find()->all();
        $ro_name = User::find()->join('LEFT JOIN','auth_assignment','auth_assignment.user_id = id')
                ->andFilterWhere(['auth_assignment.item_name' => 'BO User'])
                ->orderBy('firstName ASC')->all();
      // echo "<pre>";
      // print_r($ro_name);
      // exit;
         
         if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {


            Yii::$app->response->format = Response::FORMAT_JSON;
               return ActiveForm::validate($model);
            }
        if ($model->load(Yii::$app->request->post())) {
            date_default_timezone_set('Asia/Calcutta');
            $currentDateTime = date('Y-m-d H:i:s');
            $model->activationLink = 'Y';
            $model->createdOn = $currentDateTime;
            
            if($model->joiningDate){
                $date = str_replace('/', '-', $model->joiningDate);
                $model->joiningDate = date("Y-m-d",strtotime($date));
            }

            if($model->salaryType == 'Fixed Salary'){
                $model->feesPerCase = 0;
            }else if($model->salaryType == 'Variable Salary'){
                $model->basicSalary = 0;
            }
            if($model->conveyanceType == 'Fixed Conveyance'){
                $model->conveyancePerKM = 0;
            }else if($model->conveyanceType == 'Variable Conveyance'){
                $model->conveyanceAmount = 0;
            }

            if($model->save())
            {
                $auth = new DbManager;
                $auth->init();
                $role = $auth->getRole('Surveyor');
                $auth->assign($role, $model->id);
            }
            //print_r($model->getErrors());
            //die('test');

           
            return $this->redirect(['surveyor']);
    
        } else {
            return $this->render('surveyorcreate', [
                'model' => $model,
                'city' => $city,
                'state'=>$state,
                'ro_name'=>$ro_name,
            ]);
        }
    }


    public function actionUpdateSurveyor($id)
    {
       
        $model = $this->findModel($id);
        $model->scenario='surveyor';
        $city = MasterCity::find()
                   ->all();
        $state=MasterState::find()->all();
        $ro_name=User::find()->join('LEFT JOIN','auth_assignment','auth_assignment.user_id = id')
        ->andFilterWhere(['auth_assignment.item_name' => 'BO User'])
        ->orderBy('firstName ASC')->all();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
               return ActiveForm::validate($model);
            }
        
        if ($model->load(Yii::$app->request->post()) ) {
            $model->password_repeat = $model->password;
            
            if($model->joiningDate){
                $date = str_replace('/', '-', $model->joiningDate);
                $model->joiningDate = date("Y-m-d",strtotime($date));
            }

            if($model->salaryType == 'Fixed Salary'){
                $model->feesPerCase = 0;
            }else if($model->salaryType == 'Variable Salary'){
                $model->basicSalary = 0;
            }
            if($model->conveyanceType == 'Fixed Conveyance'){
                $model->conveyancePerKM = 0;
            }else if($model->conveyanceType == 'Variable Conveyance'){
                $model->conveyanceAmount = 0;
            }

            $model->save();
            return $this->redirect(['surveyor']);
        } else {
            return $this->render('surveyorupdate', [
                'model' => $model,
                'city' => $city,
                'state'=> $state,
                'ro_name'=>$ro_name,
            ]);
        }
    }

    public function actionResetPassword($id)
    {
       
        $model = $this->findModel($id);
        $model->scenario = 'change-password';

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        
        if ($model->load(Yii::$app->request->post()) ) {
            //$model->password_repeat = $model->password;
            
            if ($model->save())
                Yii::$app->session->setFlash('Success','Password has been changed successfully for <b>'. $model->email .'</b>');
            else
                Yii::$app->session->setFlash('Failure','Something went wrong..!');

            return $this->redirect(Yii::$app->request->referrer);
        } 
        else {
            return $this->render('password_reset', [
                'model' => $model
            ]);
        }
    }


    public function actionDeleteSurveyor($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['surveyor']);
    }
    
    public function actionBouser()
    {

        $query = User::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
   
        $query->join('LEFT JOIN','auth_assignment','auth_assignment.user_id = id')
      ->andFilterWhere(['auth_assignment.item_name' => 'BO User']);
        
        return $this->render('bouser', [
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionViewBouser($id)
    {
        $model = $this->findModel($id);
        $getstateCode = MasterState::find()->where(['id'=>$model->stateId])->one();
        $getstateCode = $getstateCode->regCode;
        $getstateids = MasterState::find()->where(['regCode'=>$getstateCode])->select('id')->asArray()->groupBy('id')->all();
        $stateIds = array_column($getstateids, 'id');
        $rousers = User::find()->join('LEFT JOIN','auth_assignment','auth_assignment.user_id = id')
        ->andWhere(['auth_assignment.item_name' => 'BO User'])
        ->andWhere(['IN','users.stateId',$stateIds])
        ->count();

        
        $rocaseassign = RoCaseAssignment::find()->where(['roId' => $model->id, 'stateId' => $model->stateId]);

        $dataProvider = new ActiveDataProvider([
            'query' => $rocaseassign,
        ]);


        return $this->render('bouserview', [
            'model' => $model,            
            'dataProvider'=>$dataProvider,
            'rousers'=>$rousers,
        ]);
    }

    public function actionCreateBouser()
    {
        
         $model = new User();
         $model->scenario='bouser';
         $city = MasterCity::find()
                   ->all();
         $state=MasterState::find()->all();
         
        $getstateCode = MasterState::find()->where(['id'=>$model->stateId])->one();
        $getstateCode = $getstateCode->regCode;
        $getstateids = MasterState::find()->where(['regCode'=>$getstateCode])->select('id')->asArray()->groupBy('id')->all();
        $stateIds = array_column($getstateids, 'id');
        $rousers = User::find()->join('LEFT JOIN','auth_assignment','auth_assignment.user_id = id')
        ->andWhere(['auth_assignment.item_name' => 'BO User'])
        ->andWhere(['IN','users.stateId',$stateIds])
        ->count();
        
        // return $rousers;

        $rocaseassign = new RoCaseAssignment();    

        $companiesInfo = PreinspectionClientCompany::find()
        ->all();
         
         if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
               return ActiveForm::validate($model);
            }
        if ($model->load(Yii::$app->request->post())) {
            
            $postData = Yii::$app->request->post();
            $createAccess = isset($postData['User']['create_access']) ? $postData['User']['create_access'] : null;
            $qcAccess = isset($postData['User']['qc_access']) ? $postData['User']['qc_access'] : null;

            date_default_timezone_set('Asia/Calcutta');
            $currentDateTime = date('Y-m-d H:i:s');
            $model->activationLink = 'Y';
            $model->createdOn = $currentDateTime;
            $model->create_access = $createAccess;
            $model->qc_access = $qcAccess;
                        
            if($model->save())
            {
                $auth = new DbManager;
                $auth->init();
                $role = $auth->getRole('BO User');
                $auth->assign($role, $model->id);

                if(Yii::$app->request->post('RoCaseAssignment') != null){
                    $rocaseassign = RoCaseAssignment::findOne(['roId' => $model->id, 'stateId' => $model->stateId,'companyId' => Yii::$app->request->post('RoCaseAssignment')['companyId']]);
                    if(empty($rocaseassign)){
                        $rocaseassign = new RoCaseAssignment();
                    }else{
                        $rocaseassign->updatedOn = date('Y-m-d H:i:s');
                    }
                    foreach ( Yii::$app->request->post('RoCaseAssignment') as $field => $value) {                        
                        $rocaseassign->$field = $value;
                    }            
                    $rocaseassign->roId = $model->id;
                    $rocaseassign->stateId = $model->stateId;
                    $rocaseassign->roId = $model->id;
                    $rocaseassign->save();
                }

                if ($model->save())
                    Yii::$app->session->setFlash('Success','RO user created successfully');
            
            }
            else
                Yii::$app->session->setFlash('Failure','Something went wrong..!');

           
            return $this->redirect(['bouser']);
    
        } else {
            return $this->render('bousercreate', [
                'model' => $model,
                'city' => $city,
                'state'=>$state,
                'rocaseassign'=>$rocaseassign,
                'companiesInfo'=>$companiesInfo,
            ]);
        }
    }


    public function actionUpdateBouser($id)
    {
       
        $model = $this->findModel($id);
        $city = MasterCity::find()
                   ->all();
        $state=MasterState::find()->all();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
               return ActiveForm::validate($model);
            }

        $getstateCode = MasterState::find()->where(['id'=>$model->stateId])->one();
        $getstateCode = $getstateCode->regCode;
        $getstateids = MasterState::find()->where(['regCode'=>$getstateCode])->select('id')->asArray()->groupBy('id')->all();
        $stateIds = array_column($getstateids, 'id');
        $rousers = User::find()->join('LEFT JOIN','auth_assignment','auth_assignment.user_id = id')
        ->andWhere(['auth_assignment.item_name' => 'BO User'])
        ->andWhere(['IN','users.stateId',$stateIds])
        ->count();
        
        // return $rousers;

        $rocaseassign = new RoCaseAssignment();    

        $companiesInfo = PreinspectionClientCompany::find()
        ->all();
        
        // return json_encode($company);
        
        if ($model->load(Yii::$app->request->post()) ) {
            $model->password_repeat = $model->password;
            $postData = Yii::$app->request->post();
            $createAccess = isset($postData['User']['create_access']) ? $postData['User']['create_access'] : null;
            $qcAccess = isset($postData['User']['qc_access']) ? $postData['User']['qc_access'] : null;

            $model->create_access = $createAccess;
            $model->qc_access = $qcAccess;
            //print_r($model->getErrors());
            //die('test');
            // return Yii::$app->request->post('RoCaseAssignment')['companyId'];
            if(Yii::$app->request->post('RoCaseAssignment') && $rousers > 1){
                $rocaseassign = RoCaseAssignment::findOne(['roId' => $model->id, 'stateId' => $model->stateId,'companyId' => Yii::$app->request->post('RoCaseAssignment')['companyId']]);
                if(empty($rocaseassign)){
                    $rocaseassign = new RoCaseAssignment();
                }else{
                    $rocaseassign->updatedOn = date('Y-m-d H:i:s');
                }
                foreach ( Yii::$app->request->post('RoCaseAssignment') as $field => $value) {                        
                    $rocaseassign->$field = $value;
                }            
                $rocaseassign->roId = $model->id;
                $rocaseassign->stateId = $model->stateId;
                $rocaseassign->roId = $model->id;
                $rocaseassign->save();
            }
            if ($model->save())
                Yii::$app->session->setFlash('Success','Updated Successfully');
            else
                Yii::$app->session->setFlash('Failure','Something went wrong..!');

            return $this->redirect(['bouser']);
        } else {
            return $this->render('bouserupdate', [
                'model' => $model,
                'city' => $city,
                'state'=>$state,
                'rocaseassign'=>$rocaseassign,
                'companiesInfo'=>$companiesInfo,
                'rousers'=>$rousers,
            ]);
        }
    }


    public function actionDeleteBouser($id)
    {
        $this->findModel($id)->delete();

        Yii::$app->session->setFlash('Success','Deleted Successfully');
        return $this->redirect(['bouser']);
    }
    
    public function actionBheaduser()
    {

        $query = User::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
   
        $query->join('LEFT JOIN','auth_assignment','auth_assignment.user_id = id')
      ->andFilterWhere(['auth_assignment.item_name' => 'Branch Head']);
        
        return $this->render('bheaduser', [
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionViewBheaduser($id)
    {

        return $this->render('bheaduserview', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreateBheaduser()
    {

         $model = new User();
         $city = MasterCity::find()
                   ->all();
         $company = PreinspectionClientCompany::find()
                   ->all();
         
         if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
               return ActiveForm::validate($model);
            }
        if ($model->load(Yii::$app->request->post())) {
            date_default_timezone_set('Asia/Calcutta');
            $currentDateTime = date('Y-m-d H:i:s');
            $model->activationLink = 'Y';
            $model->createdOn = $currentDateTime;
                        
            if($model->save())
            {
                $auth = new DbManager;
                $auth->init();
                $role = $auth->getRole('Branch Head');
                $auth->assign($role, $model->id);
            }
            //print_r($model->getErrors());
            //die('test');

           
            return $this->redirect(['bheaduser']);
    
        } else {
            return $this->render('bheadusercreate', [
                'model' => $model,
                'city' => $city,
                'company' => $company,
            ]);
        }
    }


    public function actionUpdateBheaduser($id)
    {
       
        $model = $this->findModel($id);
        $city = MasterCity::find()
                   ->all();
        $company = PreinspectionClientCompany::find()
                   ->all();
        $division = PreinspectionClientDivision::find()
                ->where(['companyId' => $model->companyId])
                ->orderBy('divisionName')
                ->all();
        
        $branch = PreinspectionClientBranch::find()
                ->where(['divisionId' => $model->divisionId])
                ->orderBy('branchName')
                ->all();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
               return ActiveForm::validate($model);
            }
        
        if ($model->load(Yii::$app->request->post()) ) {
            $model->password_repeat = $model->password;
            //print_r($model->getErrors());
            //die('test');
            $model->save();
            return $this->redirect(['bheaduser']);
        } else {
            return $this->render('bheaduserupdate', [
                'model' => $model,
                'city' => $city,
                'company' => $company,
                'division' => $division,
                'branch' => $branch,
            ]);
        }
    }


    public function actionDeleteBheaduser($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['bheaduser']);
    }
    
    public function actionBexecutiveuser()
    {


        
         $searchModel = new UserSearch();   
         $dataProvider = $searchModel->search(Yii::$app->request->queryParams);


      //   $query = User::find();
      //   $dataProvider = new ActiveDataProvider([
      //       'query' => $query,
      //   ]);
   
      //   $query->join('LEFT JOIN','auth_assignment','auth_assignment.user_id = id')
      // ->andFilterWhere(['auth_assignment.item_name' => 'Branch Executive']);
        
        return $this->render('bexecutiveuser', [
            'dataProvider' => $dataProvider,
            'searchModel'=>$searchModel
        ]);
    }


    public function actionViewBexecutiveuser($id)
    {

        return $this->render('bexecutiveuserview', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreateBexecutiveuser()
    {

        $model = new User();
        $city = MasterCity::find()
                   ->all();
        $company = PreinspectionClientCompany::find()
                   ->all();
        $roName = User::find()->join('LEFT JOIN','auth_assignment','auth_assignment.user_id = id')
                   ->andFilterWhere(['auth_assignment.item_name' => 'BO User'])
                   ->orderBy('firstName ASC')->all();

        // $division = PreinspectionClientDivision::find()
        //         ->where(['companyId' => $model->companyId])
        //         ->orderBy('divisionName')
        //         ->all();
          
         
         if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
               return ActiveForm::validate($model);
            }
        if ($model->load(Yii::$app->request->post())) {
            date_default_timezone_set('Asia/Calcutta');
            $currentDateTime = date('Y-m-d H:i:s');
            $model->activationLink = 'Y';
            $model->createdOn = $currentDateTime;
                        
            if($model->save())
            {
                $auth = new DbManager;
                $auth->init();
                $role = $auth->getRole('Branch Executive');
                $auth->assign($role, $model->id);
            }
            //print_r($model->getErrors());
            //die('test');

           
            return $this->redirect(['bexecutiveuser']);
    
        } else {
            return $this->render('bexecutiveusercreate', [
                'model' => $model,
                'city' => $city,
                'company' => $company,
                'roName' => $roName,
            ]);
        }
    }


    public function actionUpdateBexecutiveuser($id)
    {
       
        $model = $this->findModel($id);

        $city = MasterCity::find()
                   ->all();
        $company = PreinspectionClientCompany::find()
                   ->all();
        $division = PreinspectionClientDivision::find()
                ->where(['companyId' => $model->companyId])
                ->orderBy('divisionName')
                ->all();
                
        $roName = User::find()->join('LEFT JOIN','auth_assignment','auth_assignment.user_id = id')
                ->andFilterWhere(['auth_assignment.item_name' => 'BO User'])
                ->orderBy('firstName ASC')->all();
        
        $branch = PreinspectionClientBranch::find()
                ->where(['divisionId' => $model->divisionId])
                ->orderBy('branchName')
                ->all();

        $bhead = User::find()
                    ->join('LEFT JOIN','auth_assignment','auth_assignment.user_id = id')
                    ->andFilterWhere(['auth_assignment.item_name' => 'Branch Head'])
                    ->andFilterWhere(['companyId' => $model->companyId])
                    ->orderBy('firstName')
                    ->all();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
               return ActiveForm::validate($model);
            }
        
        if ($model->load(Yii::$app->request->post()) ) {
            $model->password_repeat = $model->password;
            //print_r($model->getErrors());
            //die('test');
            $model->save();
            return $this->redirect(['bexecutiveuser']);
        } else {
            return $this->render('bexecutiveuserupdate', [
                'model' => $model,
                'city' => $city,
                'company' => $company,
                'division' => $division,
                'branch' => $branch,
                'bhead' => $bhead,
                'roName' => $roName,
            ]);
        }
    }


    public function actionDeleteBexecutiveuser($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['bexecutiveuser']);
    }
    
    
    
    
    
    
/* car dealers controller */


public function actionCardealers()
    {

        $query = User::find();
        $dataProvider = new ActiveDataProvider([
         'query' => $query,
        ]);
   
        $query->join('LEFT JOIN','auth_assignment','auth_assignment.user_id = id')
      ->andFilterWhere(['auth_assignment.item_name' => 'Car Dealers']);
        
        return $this->render('cardealers', [
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionViewCardealers($id)
    {

        return $this->render('cardealersview', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreateCardealers()
    {

         $model = new User();
         $surveyor = User::find()
                    ->join('LEFT JOIN','auth_assignment','auth_assignment.user_id = id')
                    ->andFilterWhere(['auth_assignment.item_name' => 'Surveyor'])
                    ->orderBy('firstName')
                    ->all();
        
         
         if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
               return ActiveForm::validate($model);
            }
        if ($model->load(Yii::$app->request->post())) {
            date_default_timezone_set('Asia/Calcutta');
            $currentDateTime = date('Y-m-d H:i:s');
            $model->activationLink = 'Y';
            $model->createdOn = $currentDateTime;
                        
            if($model->save())
            {
                $auth = new DbManager;
                $auth->init();
                $role = $auth->getRole('Car Dealers');
                $auth->assign($role, $model->id);
            }
            //print_r($model->getErrors());
            //die('test');

           
            return $this->redirect(['cardealers']);
    
        } else {
            return $this->render('cardealerscreate', [
                'model' => $model,
                'surveyor' => $surveyor,
               
            ]);
        }
    }


    public function actionUpdateCardealers($id)
    {
       
        $model = $this->findModel($id);
        
        $surveyor = User::find()
                    ->join('LEFT JOIN','auth_assignment','auth_assignment.user_id = id')
                    ->andFilterWhere(['auth_assignment.item_name' => 'Surveyor'])
                    ->orderBy('firstName')
                    ->all();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
               return ActiveForm::validate($model);
            }
        
        if ($model->load(Yii::$app->request->post()) ) {
            $model->password_repeat = $model->password;
            //print_r($model->getErrors());
            //die('test');
            $model->save();
            return $this->redirect(['cardealers']);
        } else {
            return $this->render('cardealersupdate', [
                'model' => $model,
                'surveyor' => $surveyor,
              
            ]);
        }
    }


    public function actionDeleteCardealers($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['cardealers']);
    }



/* end of car dealers controllers */

    
    public function actionCommonuser()
    {

        $query = User::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
   
        $query->join('LEFT JOIN','auth_assignment','auth_assignment.user_id = id')
      ->andFilterWhere(['auth_assignment.item_name' => 'Commonuser']);
        
        return $this->render('commonuser', [
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionViewCommonuser($id)
    {

        return $this->render('commonuserview', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreateCommonuser()
    {

         $model = new User();
         $city = MasterCity::find()
                   ->all();
         
         if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
               return ActiveForm::validate($model);
            }
        if ($model->load(Yii::$app->request->post())) {
            date_default_timezone_set('Asia/Calcutta');
            $currentDateTime = date('Y-m-d H:i:s');
            $model->activationLink = 'Y';
            $model->createdOn = $currentDateTime;
                        
            if($model->save())
            {
                $auth = new DbManager;
                $auth->init();
                $role = $auth->getRole('Commonuser');
                $auth->assign($role, $model->id);
            }
            //print_r($model->getErrors());
            //die('test');

           
            return $this->redirect(['commonuser']);
    
        } else {
            return $this->render('commonusercreate', [
                'model' => $model,
                'city' => $city,
            ]);
        }
    }


    public function actionUpdateCommonuser($id)
    {
       
        $model = $this->findModel($id);
        $city = MasterCity::find()
                   ->all();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
               return ActiveForm::validate($model);
            }
        
        if ($model->load(Yii::$app->request->post()) ) {
            $model->password_repeat = $model->password;
            //print_r($model->getErrors());
            //die('test');
            $model->save();
            return $this->redirect(['commonuser']);
        } else {
            return $this->render('commonuserupdate', [
                'model' => $model,
                'city' => $city,
            ]);
        }
    }


    public function actionDeleteCommonuser($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['commonuser']);
    }
    
    
    
    
    
/* car dealers controller */
    
    
    
    
    
    
    
    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    public function actionDivisionlist($id)
    {

        $countPosts = PreinspectionClientDivision::find()
                ->where(['companyId' => $id])
                ->count();




 
        $posts = PreinspectionClientDivision::find()
                ->where(['companyId' => $id])
                ->orderBy('divisionName')
                ->all();


 
        if($countPosts>0){
            echo "<option value = ''>Select</option>";
            foreach($posts as $post){
                
                echo "<option value='".$post->id."'>".$post->divisionName."</option>";
            }
        }
        else{
            echo "<option value = ''>Select</option>";
        }
    }
    
    public function actionBranchlist($id,$cid)
    {
        $countPosts = PreinspectionClientBranch::find()
                ->where(['companyId' => $cid])
                ->andFilterWhere(['divisionId' => $id])
                ->count();
 
        $posts = PreinspectionClientBranch::find()
                ->where(['companyId' => $cid])
                ->andFilterWhere(['divisionId' => $id])
                ->orderBy('branchName')
                ->all();
 
        if($countPosts>0){
            echo "<option value = ''>Select</option>";
            foreach($posts as $post){
                
                echo "<option value='".$post->id."'>".$post->branchName."</option>";
            }
        }
        else{
            echo "<option value = ''>Select</option>";
        }
    }
    
    public function actionCallerlist($companyId,$divisionId,$branchId)
    {
       if($companyId != '' && $divisionId != '' && $branchId != '')
       {
        $countPosts = User::find()
                    ->join('LEFT JOIN','auth_assignment','auth_assignment.user_id = id')
                    ->andFilterWhere(['or',
                        ['auth_assignment.item_name' => 'Branch Head'],
                        ['auth_assignment.item_name' => 'Branch Executive']])
                    ->andFilterWhere(['companyId' => $companyId])
                    ->andFilterWhere(['divisionId' => $divisionId])
                    ->andFilterWhere(['branchId' => $branchId])
                    ->count();
        $posts = User::find()
                    ->join('LEFT JOIN','auth_assignment','auth_assignment.user_id = id')
                    ->andFilterWhere(['or',
                        ['auth_assignment.item_name' => 'Branch Head'],
                        ['auth_assignment.item_name' => 'Branch Executive']])
                    ->andFilterWhere(['companyId' => $companyId])
                    ->andFilterWhere(['divisionId' => $divisionId])
                    ->andFilterWhere(['branchId' => $branchId])
                    ->orderBy('firstName')
                    ->all();
       }
       else {
         $countPosts = 0;  
       }
 
         $options = '';
        if($countPosts>0){ 
            $options .= "<option value = ''>Select</option>";
            foreach($posts as $post){ 
                $options .= "<option value='".$post->id."'>".$post->firstName."</option>";
            }
        }
        else{
            $options .= "<option value = ''>Select</option>";
        }
        return $options;
    }
    
    public function actionCallerdetails($callerId)
    {
       $output = ''; 
       if($callerId != '')
       {
        $post = User::findOne($callerId);
        $output =  $post->mobile."|&|".$post->email;
       }
       return $output;
    }
    
    public function actionBheadlist($id)
    {
       if($id != '')
       {
        $countPosts = User::find()
                    ->join('LEFT JOIN','auth_assignment','auth_assignment.user_id = id')
                    ->andFilterWhere(['auth_assignment.item_name' => 'Branch Head'])
                    ->andFilterWhere(['companyId' => $id])
                    ->count();
        $posts = User::find()
                    ->join('LEFT JOIN','auth_assignment','auth_assignment.user_id = id')
                    ->andFilterWhere(['auth_assignment.item_name' => 'Branch Head'])
                    ->andFilterWhere(['companyId' => $id])
                    ->orderBy('firstName')
                    ->all();
       }
       else {
         $countPosts = 0;  
       }
 
        if($countPosts>0){
            echo "<option value = ''>Select</option>";
            foreach($posts as $post){ 
                echo "<option value='".$post->id."'>".$post->firstName."</option>";
            }
        }
        else{
            echo "<option value = ''>Select</option>";
        }
    }

    public function actionLoadRocaseInfo(){
        $response = array();
        $companyId = Yii::$app->request->post('companyId');
        $stateId = Yii::$app->request->post('stateId');
        $userId = Yii::$app->request->post('userId');
        // return $companyId.' !! '.$stateId.' !! '.$userId;
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if($companyId && $stateId && $userId){
            $rocaseassign = RoCaseAssignment::findOne(['roId' => $userId, 'stateId' => $stateId,'companyId' => $companyId]);
            $response['caseCnt'] = $rocaseassign->caseCnt;
            return $response;
        }
    }

    public function actionShowRocase(){
        $response = array();
        $stateId = Yii::$app->request->post('stateId');
        $getstateCode = MasterState::find()->where(['id'=>$stateId])->one();
        $getstateCode = $getstateCode->regCode;
        $getstateids = MasterState::find()->where(['regCode'=>$getstateCode])->select('id')->asArray()->groupBy('id')->all();
        $stateIds = array_column($getstateids, 'id');
        $rousers = User::find()->join('LEFT JOIN','auth_assignment','auth_assignment.user_id = id')
        ->andWhere(['auth_assignment.item_name' => 'BO User'])
        ->andWhere(['IN','users.stateId',$stateIds])
        ->count();
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if($stateId){
            $response['roCnt'] = $rousers;
            return $response;
        }
    }
}
