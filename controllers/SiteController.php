<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Processdata;
use app\models\Processsearch;
use app\models\ProcessdataHistory;
use app\models\User;
use app\models\MasterState;
use app\models\MasterTown;
use app\models\MasterCity;
use app\models\MasterTownCopy;
use app\models\MasterCityCopy;
use app\models\PreinspectionClientCompany;
use app\models\PreinspectionClientDivision;
use app\models\PreinspectionClientBranch;
use app\models\BranchCopy;
use app\models\DivisionCopy;
use app\models\UserCopy;
use app\models\CompanyCopy;
use app\models\EmailHistory;
use yii\data\ActiveDataProvider;
use yii\helpers\FileHelper;
use yii\rbac\DbManager;
use app\models\AxionPreinspection;
use app\models\AxionPreinspectionSearch;





class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout','about','index','change-password'],
                'rules' => [
                    [
                        'actions' => ['logout','about','index','change-password'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post','get'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }
    
   public function actionPasswd()
    {
        /*
        ini_set('max_execution_time', '300');
        $data = User::find()
              ->join('LEFT JOIN','auth_assignment','auth_assignment.user_id = id')
              ->andFilterWhere(['auth_assignment.item_name' => 'Surveyor'])
              ->all();
        foreach ($data as $val) {
            //echo $val->id.$val->firstName;
            # code...
            $model = User::findOne($val->id);
            $model->password = Yii::$app->getSecurity()->generatePasswordHash($val->mobile);
            $model->password_repeat = $model->password;
            $model->save();
            //print_r($model->getErrors());
            //die('test');
        }
        echo "updated";
        */
    }

    public function actionIndex()
    { 

        $role = array_keys(Yii::$app->authManager->getRolesByUser(Yii::$app->user->getId()))[0];
        if($role == 'Branch Head')
        {
            return $this->redirect(['/axion-preinspection/fresh']);
        }
        else{
            if(Yii::$app->session->get('dashboard')){
                if(Yii::$app->session->get('dashboard') == 'targetreport'){
                    Yii::$app->session->remove('dashboard');
                    Yii::$app->session->set('dashboard-menu','targetreport');
                    return $this->render('target-report');
                }elseif(Yii::$app->session->get('dashboard') == 'agingwise'){
                    Yii::$app->session->remove('dashboard');    
                    Yii::$app->session->set('dashboard-menu','agingwise');
                    return $this->render('aging-list');    
                }
            }else{
                Yii::$app->session->remove('dashboard-menu');   
                return $this->render('aging-list');            
            }
        }
       
        /*
        $dataProvider=new ActiveDataProvider([
            'query' => Processdata::find(),
            'sort'=> ['defaultOrder' => ['created_on'=>SORT_DESC]],
            'pagination'=>['pageSize'=>20],
        ]);
        return $this->render('index', ['dataProvider'=>$dataProvider]);
         * 
         */
        /*
    \Yii::$app->mailer->compose('/site/about',[])
    ->setFrom('thesridharworld@gmail.com')
    ->setTo('nag007usin@gmail.com')
    ->setSubject('This is a test mail ' )
    ->send();
         * 
         */

        // return $this->render('index');
        // return $this->render('aging-list');
        // return $this->render('target-report');

    }

    public function actionLogin()
    {
        
        $this->layout='main-login';
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionContact()
    {
        
        // $rows = (new \yii\db\Query())
        //     ->select(['item_name','user_id'])
        //     ->from('auth_assignmentcopy')->all();

    	// $user_data=User::find()->all();

       

    	
        // $citycopy=MasterCityCopy::find()->all();

        
        // $towncopy=MasterTownCopy::find()->all();
        // $towncopy;
        // $branchcopy=BranchCopy::find()->asArray()->all();
        // $divisioncopy=DivisionCopy::find()->asArray()->all();

        // foreach ($citycopy as $value) 
        // {
        //     $newcity=MasterCity::find()->where(['city'=>$value->city])->asArray()->one();
        //     if(!$newcity)
        //     {
        //         // echo "not in city list ".$value->city."<br>";
        //         // $city_model=new MasterCity();
        //         // $city_model->city=$value->city;
        //         // if($city_model->save())
        //         // {
        //             $city_id=$city_model->id;
        //             // foreach ($towncopy as $townlist) 
        //             // {
        //             //    $new_town=MasterTown::find()->where(['town'=>$townlist->town])->one();
        //             //    if(!$new_town)
        //             //    {
        //             //      echo " not in city list => ".$value->city." not in town list =>".$townlist->town."<br>";
                         
                         
        //             //    } 
        //             // }
        //         //}

        //     }
        // }
        // exit;



        // $old_cities=MasterCityCopy::find()->all();
        // // find()->where(['id'=>$newusertable->cityId])->one();
        // foreach ($old_cities as $value) 
        // {
        // 	if($value->city!='')
        //     {
        //                 // echo "old city record=> ".$old_cities->id." and city name". $old_cities->city."<br>";

        //         		$new_cities=MasterCity::find()->where(['city'=>$value->city])->one();
        //                 if(!$new_cities)
        //                 {
        //                 	$new_city=new MasterCity();
        //                 	$new_city->city=$value->city;
        //                     // $newusertable->cityId=$new_cities->id;
        //                     if($new_city->save())
        //                     {
        //                         echo  "new city record=> ".$new_city->id. " and ".$new_city->city." inserted successfully<br>";
        //                     }  
        //                 }
                		
        //     }
        // }
                	

        // exit;
        

        // $companylist=CompanyCopy::find()->all();
        $userlist=UserCopy::find()->all();

        // foreach ($userlist as $value) {
        //     $new_user=User::find()->where(['email'=>$value->email])->one();
        //     if($new_user)
        //     {
        //         $new_user->companyId=$value->companyId;
        //         $new_user->branchId=$value->branchId;
        //         $new_user->divisionId=$value->divisionId;
        //         $new_user->branchHeadId=$value->branchHeadId;
        //         $new_user->cityId=$value->cityId;
        //         // $new_user->stateId=$value->stateId;
                
        //         if($new_user->save())
        //         {
        //             echo 'user updated successfully';

        //         }

        //     }
        // }
        // exit;





        // $old_brach=BranchCopy::find()->all();
        // $old_division=DivisionCopy::find()->all();

        // foreach ($old_brach as $value) 
        // {
        //     $new_branch=PreinspectionClientBranch::find()->where(['companyId'=>$value->companyId])->all();
        //     if(!$new_branch)
        //     {
        //         $branch=New PreinspectionClientBranch();
        //         $branch->companyId=$value->companyId;
        //         if($branch->save())
        //         {
        //             echo "branch inserted successfully"."<br>";
        //         }

        //     }
        // }

        // exit;
        // foreach ($userlist as $value) 
        // {
            
            
        // // $old_brach=BranchCopy::find()->where(['id'=>$value->branchId])->one();
        // // $old_division=DivisionCopy::find()->where(['id'=>$value->divisionId])->one();

       

        //     if($old_brach)
        //     {
                
        //     //     TATA AIG GENERAL INSURANCE CO LTD
        //     //     TATA AIG GENERAL INSURANCE CO LTD
        //     //     echo "<pre>";
        //     // echo $old_company['id']."=>".$old_company['companyName']."<br>";
            

        //         $new_division=PreinspectionClientDivision::find()->where(['divisionName'=>$old_division->divisionName])->one();
        //         $new_branch=PreinspectionClientBranch::find()->where(['branchName'=>$old_brach->branchName])->one();
                

        //         if($new_branch)
        //         {
        //            $model = User::findOne($value->id);
        //            $model->branchId=$new_branch->id;
        //            isf($model->save())
        //            {
        //             echo "new_branch created successfully";
        //            }
        //            else
        //            {
        //             echo "failed";
        //            }

                   
                   
        //         }

        //     }

            
        
        // }

        // $companylist=CompanyCopy::find()->all();
        // // ->where(['id'=>$newusertable->companyId])->one();
        //         	if($companylist)
        //         	{	
                		
        //                 // echo "old record=> ".$companylist->id." => ".$companylist->companyName."<br>";
                      
        //         		$newcompanylist=PreinspectionClientCompany::find()->where(['companyName'=>$companylist->companyName])->one();
        //         		if($newcompanylist)
        //         		{
        //                      // echo "new record => ".$newcompanylist->id." => ".$newcompanylist->companyName."<br>";
              

        //         			$newusertable->companyId=$newcompanylist->id;
        //         			if($newusertable->save()){
        //         				echo "record updated successfully" ;
        //         			}

        //         		}
        //             }

        // exit;

       //  $userlist->join('LEFT JOIN','auth_assignment1','auth_assignment1.user_id = id')
      	// 			->andFilterWhere(['auth_assignment.item_name' => 'Admin'])->asArray()->all();

      	// echo "<pre>";
      	// print_r($userlist);
      	// exit;
        $i=1;
        foreach ($userlist as $olduserslist) 
        {


            if($olduserslist->email!='')
            {
            $newusertable=User::find()->where(['email'=>$olduserslist->email])->one();



            if($newusertable)
            {  

                // echo  $i." => ".$newusertable->email ."<br>";
                // $i++;
              //       // $newusertable->cityId=$olduserslist->cityId;
              //       $newusertable->branchId=$olduserslist->branchId;
              //       // $newusertable->divisionId=$olduserslist->divisionId;
            		// // $newusertable->companyId=$olduserslist->companyId;
              //       if($newusertable->save())
              //       {
              //           echo $i." = ".$newusertable->branchId."=> updated branchId successfully"."<br>";
              //           $i++;
              //       }

             //    	// echo "<pre>";
             //     //    echo $i." => ".$newusertable->email."<br>";
             //     //    $i++;
             //    $model=new User();
	            // $model->firstName = $olduserslist->firstName;
	            // $model->lastName =$olduserslist->lastName;
	            // $model->ownerName = NULL;
	            // $model->address = $olduserslist->address;
	            // $model->pan_number = NULL;
	            // $model->bank_name = NULL;
	            // $model->email = $olduserslist->email;
	            // $model->account_number = NULL;
	            // $model->ifsc_code = NULL;
	            // $model->branch_name = NULL;
	            // $model->password = $olduserslist->password;
	            // $model->mobile = $olduserslist->mobile;
	            // $model->alternateMobile = $olduserslist->alternateMobile;
	            // $model->authKey = $olduserslist->authKey;
	            // $model->accessToken = $olduserslist->accessToken;
	            // $model->activationLink = $olduserslist->activationLink;
	            // $model->active = $olduserslist->active;
	            // $model->companyId = $olduserslist->companyId;
	            // $model->branchId = $olduserslist->branchId;
	            // $model->divisionId = $olduserslist->divisionId;
	            // $model->branchHeadId = $olduserslist->branchHeadId;
	            // $model->roId = NULL;
	            // $model->stateId = NULL;
	            // $model->cityId = $olduserslist->cityId;
	            // $model->surveyorId = $olduserslist->surveyorId;
            	// if($model->save())
	            // {
	            // 	echo $i." => recorde inserted successfully"."<br>";
	            // 	$i++;
	            // }
	            // else
	            // {
	            // 	print_r($model->getErrors());
	            // }


            




                	// $companyid=$newusertable->companyId;
                	

                	// $old_branch=BranchCopy::find()->where(['id'=>$newusertable->branchId])->one();

                	// $old_cities=MasterCityCopy::find()->where(['id'=>$newusertable->cityId])->one();
                	// if($old_cities)
                	// {
                 //        // echo $i." = old city record=> ".$old_cities->id." and city name". $old_cities->city."<br>";
                 //        // $i++;

                	// 	$new_cities=MasterCity::find()->where(['city'=>$old_cities->city])->one();
                 //        if($new_cities)
                 //        {
                 //            $newusertable->cityId=$new_cities->id;
                 //            if($newusertable->save())
                 //            {
                 //                echo $i. " = new city record=> ".$new_cities->id. " and ".$new_cities->city." updated successfully<br>";
                 //                 $i++;
                 //            }  
                 //        }
                		
                	// }



                 //    $old_branch=BranchCopy::find()->where(['id'=>$newusertable->branchId])->one();
                	// if($old_branch)
                	// {
                	// 	$new_branch=PreinspectionClientBranch::find()->where(['branchName'=>$old_branch->branchName])->andWhere(['divisionId' => $newusertable->divisionId])->one();
                		
                		
                	// 	// echo $i." = ".$old_branch->id."  company id =".$old_branch->divisionId." and branch name= ".$old_branch->branchName."<br>";
                	// 	// $i++;
                	// 	$newusertable->branchId=$new->branch->id;
                 //        if($new_branch)
                 //        {
                 //            // echo $i." = ".$new_branch->id."  divisionId =".$new_branch->divisionId." and branch name= ".$new_branch->branchName."<br>";
                 //            // $i++;
                 //            $newusertable->branchId=$new_branch->id;
                 //            if($newusertable->save())
                 //            {
                 //             echo $i." = ".$newusertable->branchId. " => record updated successfully<br>";
                 //             $i++;
                 //            }
                 //        }

                	// }


                    // echo "division ID ".$newusertable->divisionId."<br>";
        			// $old_div=DivisionCopy::find()->where(['id'=>$newusertable->divisionId])->one();

        			

        			// if($old_div)
        			// {
        				
        				// echo $i." =>old record=> ".$old_div->id." = ".$old_div->divisionName."<br>";
        				// $i++;
                
                        

        			// 	$new_div=PreinspectionClientDivision::find()->where(['divisionName'=>$old_div->divisionName])
        			// 	->andWhere(['companyId' => $newusertable->companyId])->one();
        			// 	if($new_div)
        			// 	{
           //                  // echo $i." =>new record => company id =".$new_div->companyId." => divisionName".$new_div->divisionName. " and division id= ".$new_div->id."<br>";
           //                  // $i++;
                           
        			// 		$newusertable->divisionId=$new_div->id;
        			// 		if($newusertable->save())
        			// 		{
        			// 			echo $i." = ".$new_div->id." = " .$newusertable->divisionId."=>".$new_div->divisionName." updated successfully!<br>";
        			// 			$i++;
        			// 		}
        			// 	}

        			// }
                    // echo $newusertable->companyId."<br>";
                	// $companylist=CompanyCopy::find()->where(['id'=>$newusertable->companyId])->one();
                	// if($companylist)
                	// {	
                		
                 //       //  echo $i." => old record=> ".$companylist->id." and company name =".$companylist->companyName."<br>";
                 //      	// $i++;

                	// 	$newcompanylist=PreinspectionClientCompany::find()->where(['companyName'=>$companylist->companyName])->one();
                	// 	if($newcompanylist)
                	// 	{
                 //             // echo $i." => new record => ".$companylist->id." = ".$newcompanylist->id." => ".$newcompanylist->companyName."<br>";
                 //             // $i++;
              

                	// 		$newusertable->companyId=$newcompanylist->id;
                	// 		if($newusertable->save()){
                	// 			echo $i." =>record updated successfully<br>" ;
                	// 			$i++;
                	// 		}

                	// 	}
                 //    }
                			// $new_division=PreinspectionClientDivision::find()->where(['companyId'=>$newcompanylist->id])->one();

                	// 		// echo $new_division->id."<br>";
                	// 		// if($new_division)
                	// 		// {
                	// 		// 	$new_branch=PreinspectionClientBranch::find()->where(['divisionId'=>$new_division->id])->one();
                	// 		// 	$division_id=$new_division->id;
                	// 		// 	$branch_id=$new_branch->id;

                	// 		// 	
                	// 		// }
                	// 	// }
                	// }
                	
                	
                    $row = (new \yii\db\Query())->select(['user_id','item_name'])->where(['user_id'=>$olduserslist->id])->from('auth_assignmentcopy')->one();

                    // echo "<pre>";
                    // print_r($row['item_name'])."<br>";

          //           $query->join('LEFT JOIN','auth_assignment','auth_assignment.user_id = id')
      				// ->andFilterWhere(['auth_assignment.item_name' => 'Admin']);
          //       if(!count($row))
          //       {
               		// echo $newusertable->id.$newusertable->firstName."<br>";
                    if($row)
                    {

                    	$record = (new \yii\db\Query())->select(['user_id','item_name'])->where(['user_id'=>$newusertable->id])->andWhere(['item_name'=>$row['item_name']])->from('auth_assignment')->one();

                    	// echo $i. " = ".$record['id']."=> ".$record['item_name']."<br>";
                    	// $i++;
                    	if(!$record)
                    	{

                    		$auth = new DbManager;
	                        $auth->init();
	                        $role = $auth->getRole($row['item_name']);
	                        if($auth->assign($role,$newusertable->id))
	                        {
	                            echo $i."=> role assigned successfully"."<br>";
	                            $i++;
	                        }
                    	}	

                        
                    }
                }
            }
        }
        exit;

        // $model = new ContactForm();
        // if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
        //     Yii::$app->session->setFlash('contactFormSubmitted');

        //     return $this->refresh();
        // }
        // return $this->render('contact', [
        //     'model' => $model,
        // ]);
    }

    public function actionAbout()
    {
        return $this->render('about');
    }
    
    public function actionScriptemailhistory()
    {
        $emailHistory = EmailHistory::find()
                ->all();
        foreach ($emailHistory as $rec)
        {
            $emailCheck =  EmailHistory::findOne($rec->id);
            if($emailCheck)
            {
                if($this->sendEmail($rec->email,$rec->message,$rec->subject) == true)
                {
                   EmailHistory::findOne($rec->id)->delete();
                }
            }
        }
    }
    
    protected function sendEmail($emailId,$message,$subject) {
        
        $sendEmailUpdate = \Yii::$app->params['sendEmailUpdate'];
        $emailId =  trim($emailId);
         if($sendEmailUpdate == 'Y')
           { 
               if(\Yii::$app->mailer->compose('/site/about',['message' => $message])
                  ->setFrom('inspection.status@axionpcs.in')
                  ->setTo($emailId)
                  ->setSubject($subject )
                  ->send()){
                   return true;
               }
               else
               {
                   return false;
               }
           }
         return true;  
    }
    
    public function actionCustomeruser()
    {
        $customer = User::find()
                ->join('LEFT JOIN','auth_assignment','auth_assignment.user_id = id')
                ->andFilterWhere(['auth_assignment.item_name' => 'Customer'])->all();
        date_default_timezone_set('Asia/Calcutta');
        
        foreach ($customer as $rec)
        {
            $to_time = strtotime($rec->createdOn);
            $from_time = strtotime(date('Y-m-d H:i:s'));
            $min = round(abs($to_time - $from_time) / 60,2);
            if($min > 30)
            {
                $auth = new DbManager;
                $auth->init();
                if($auth->revokeAll($rec->id))
                {
                    User::findOne($rec->id)->delete();
                }
            }
        }
    }
    
    public function actionCopydropboximages()
    {
        $dropboxImageLoc = \Yii::$app->params['dropboxImageLoc'];
        $copyImageLoc = \Yii::$app->params['copyImageLoc'];
        
        FileHelper::copyDirectory($dropboxImageLoc,$copyImageLoc);
        
            $files= FileHelper::findFiles($dropboxImageLoc);

            if (isset($files[0])) {
                foreach ($files as $index => $file) {
                    //echo $file;
                    unlink($file);

                }
            } else {
                echo "There are no files available for download.";
            }
        
    }

    public function actionChangePassword()
    {

        $role = array_keys(Yii::$app->authManager->getRolesByUser(Yii::$app->user->getId()))[0] ;
        if($role!='Superadmin'){
            return $this->goHome();
        }

        $model = User::find()
        ->join('LEFT JOIN','auth_assignment','auth_assignment.user_id = id')
        ->andFilterWhere(['auth_assignment.item_name' => 'Superadmin'])
        ->one();

        $model->scenario = 'change-password';

        if (Yii::$app->request->post() && $model->load(Yii::$app->request->post())) {      
            if ($model->validate(false)) {
                $model->authKey = Yii::$app->getSecurity()->generateRandomString();
                if(isset($model->password)) 
                    $model->password = Yii::$app->getSecurity()->generatePasswordHash($model->password);
                    $model->password_repeat = $model->password;
                
                if ($model->save(false))
                    Yii::$app->session->setFlash('Success', 'Password changed successfully..!');
                else {
                    foreach ($model->getErrors() as $errorMsg) {
                        Yii::$app->session->setFlash('Failure', $errorMsg[0]); 
                    }
                }     
            }
            else {
                foreach ($model->getErrors() as $errorMsg) {
                    Yii::$app->session->setFlash('Failure', $errorMsg[0]); 
                }         
            }   

            return $this->goHome();
        } 
        else {
            $model->password='';
            return $this->render('change-password',[
                'model'=>$model
            ]);   
        }

    }

    public function actionLoadAging(){
        if(isset($_POST['status']) && $_POST['status'] != '' && isset($_POST['id']) && $_POST['id'] != '' && isset($_POST['day']) && $_POST['day'] != ''){
            // date_default_timezone_set('Asia/Kolkata');
            $role = array_keys(Yii::$app->authManager->getRolesByUser(Yii::$app->user->getId()))[0];
            if($role == 'BO User'){
            $userState = Yii::$app->user->identity->stateId;
            }else{
            $userState = '';
            }
            if($_POST['day'] == 1){
                $curDate = date('d-m-Y h:i A');
                $diffDate = date('d-m-Y h:i A',strtotime('-24 hours'));
            }elseif($_POST['day'] == 2){
                $curDate = date('d-m-Y h:i A',strtotime('-24 hours'));
                $diffDate = date('d-m-Y h:i A',strtotime('-48 hours'));
            }elseif($_POST['day'] == 3){
                $curDate = date('d-m-Y h:i A',strtotime('-48 hours'));
                $diffDate = date('d-m-Y h:i A',strtotime('-72 hours'));
            }elseif($_POST['day'] == 4){
                $curDate = date('d-m-Y h:i A',strtotime('-72 hours'));
                $diffDate = date('d-m-Y h:i A',strtotime('-96 hours'));
            }elseif($_POST['day'] == 5){
                $curDate = date('d-m-Y h:i A',strtotime('-96 hours'));
                $diffDate = date('d-m-Y h:i A',strtotime('-120 hours'));
            }elseif($_POST['day'] == 6){
                $curDate = date('d-m-Y h:i A',strtotime('-120 hours'));
                $diffDate = date('d-m-Y h:i A');
            }
            $curDate = str_replace(":","%3A",$curDate);
            $diffDate = str_replace(":","%3A",$diffDate);
            if($_POST['status'] == 0){
                $status = 'fresh';
            }elseif($_POST['status'] == 12){
                $status = 'scheduled';
            }elseif($_POST['status'] == 8){
                $status = 'completed';
            }
            if($_POST['tablename'] == 'company'){
                return YII::$app->request->baseUrl .'/axion-preinspection/'.$status.'?AxionPreinspectionSearch[referenceNo]=&AxionPreinspectionSearch[intimationDate]='.$diffDate.' - '.$curDate.'&AxionPreinspectionSearch[insurerName]='.$_POST['id'].'&AxionPreinspectionSearch[contactPersonMobileNo]=&AxionPreinspectionSearch[registrationNo]=&AxionPreinspectionSearch[insuredAddress]=&&AxionPreinspectionSearch[status][]='.$_POST['status'].'&AxionPreinspectionSearch[remarks]=&AxionPreinspectionSearch[day]='.$_POST['day'].'&AxionPreinspectionSearch[followupReason]=&AxionPreinspectionSearch[stateId]='.$userState.'';
            }elseif($_POST['tablename'] == 'status'){
                return YII::$app->request->baseUrl .'/axion-preinspection/'.$status.'?AxionPreinspectionSearch[referenceNo]=&AxionPreinspectionSearch[intimationDate]='.$diffDate.' - '.$curDate.'&AxionPreinspectionSearch[insurerName]=&AxionPreinspectionSearch[contactPersonMobileNo]=&AxionPreinspectionSearch[registrationNo]=&AxionPreinspectionSearch[insuredAddress]=&&AxionPreinspectionSearch[status][]='.$_POST['status'].'&AxionPreinspectionSearch[remarks]=&AxionPreinspectionSearch[day]='.$_POST['day'].'&AxionPreinspectionSearch[followupReason]='.$_POST['id'].'&AxionPreinspectionSearch[stateId]='.$userState.'';
            }elseif($_POST['tablename'] == 'ro'){
                return YII::$app->request->baseUrl .'/axion-preinspection/'.$status.'?AxionPreinspectionSearch[referenceNo]=&AxionPreinspectionSearch[intimationDate]='.$diffDate.' - '.$curDate.'&AxionPreinspectionSearch[insurerName]=&AxionPreinspectionSearch[contactPersonMobileNo]=&AxionPreinspectionSearch[registrationNo]=&AxionPreinspectionSearch[insuredAddress]=&&AxionPreinspectionSearch[status][]='.$_POST['status'].'&AxionPreinspectionSearch[remarks]=&AxionPreinspectionSearch[day]='.$_POST['day'].'&AxionPreinspectionSearch[followupReason]=&AxionPreinspectionSearch[stateId]='.$_POST['id'].'';
            }
            elseif($_POST['tablename'] == 'fe'){
                return YII::$app->request->baseUrl .'/axion-preinspection/'.$status.'?AxionPreinspectionSearch[referenceNo]=&AxionPreinspectionSearch[intimationDate]='.$diffDate.' - '.$curDate.'&AxionPreinspectionSearch[insurerName]=&AxionPreinspectionSearch[contactPersonMobileNo]=&AxionPreinspectionSearch[registrationNo]=&AxionPreinspectionSearch[insuredAddress]=&&AxionPreinspectionSearch[status][]='.$_POST['status'].'&AxionPreinspectionSearch[remarks]=&AxionPreinspectionSearch[day]='.$_POST['day'].'&AxionPreinspectionSearch[followupReason]=&AxionPreinspectionSearch[stateId]=&AxionPreinspectionSearch[surveyorName]='.$_POST['id'].'';
            }
        }
    }

    public function actionAutoLoadCompanyTable(){
        $role = array_keys(Yii::$app->authManager->getRolesByUser(Yii::$app->user->getId()))[0];
        $userState = Yii::$app->user->identity->stateId;
        $data = AxionPreinspection::find()
        ->join('LEFT JOIN','preinspection_client_company as companyinfo','companyinfo.id = axion_preinspection.insurerName')
        ->select(
                [
                    'companyinfo.companyName as name',
                    'axion_preinspection.insurerName as id',
                    'count(
                        case
                        when axion_preinspection.created_on between DATE_FORMAT(DATE_ADD(NOW(), INTERVAL -24 HOUR),\'%Y-%m-%d %H:%i:%s\') and DATE_FORMAT(NOW(),\'%Y-%m-%d %H:%i:%s\') and status = 0
                        then 1
                        else null
                        end
                    ) as dayone_status_Fresh',
                    'count(
                        case
                        when axion_preinspection.created_on between DATE_FORMAT(DATE_ADD(NOW(), INTERVAL -24 HOUR),\'%Y-%m-%d %H:%i:%s\') and DATE_FORMAT(NOW(),\'%Y-%m-%d %H:%i:%s\') and status = 12
                        then 1
                        else null
                        end
                    ) as dayone_status_Schedule',
                    'count(
                        case
                        when axion_preinspection.created_on between DATE_FORMAT(DATE_ADD(NOW(), INTERVAL -24 HOUR),\'%Y-%m-%d %H:%i:%s\') and DATE_FORMAT(NOW(),\'%Y-%m-%d %H:%i:%s\') and status = 8 
                        then 1
                        else null
                        end
                    ) as dayone_status_Surveydone',
                    'count(
                        case
                        when axion_preinspection.created_on between DATE_FORMAT(DATE_ADD(NOW(), INTERVAL -48 HOUR),\'%Y-%m-%d %H:%i:%s\') and DATE_FORMAT(DATE_ADD(NOW(), INTERVAL -24 HOUR),\'%Y-%m-%d %H:%i:%s\') and status = 0
                        then 1
                        else null
                        end
                    ) as daytwo_status_Fresh',
                    'count(
                        case
                        when axion_preinspection.created_on between DATE_FORMAT(DATE_ADD(NOW(), INTERVAL -48 HOUR),\'%Y-%m-%d %H:%i:%s\') and DATE_FORMAT(DATE_ADD(NOW(), INTERVAL -24 HOUR),\'%Y-%m-%d %H:%i:%s\') and status = 12
                        then 1
                        else null
                        end
                    ) as daytwo_status_Schedule',
                    'count(
                        case
                        when axion_preinspection.created_on between DATE_FORMAT(DATE_ADD(NOW(), INTERVAL -48 HOUR),\'%Y-%m-%d %H:%i:%s\') and DATE_FORMAT(DATE_ADD(NOW(), INTERVAL -24 HOUR),\'%Y-%m-%d %H:%i:%s\') and status = 8 then 1
                        else null
                        end
                    ) as daytwo_status_Surveydone',
                    'count(
                        case
                        when axion_preinspection.created_on between DATE_FORMAT(DATE_ADD(NOW(), INTERVAL -72 HOUR),\'%Y-%m-%d %H:%i:%s\') and DATE_FORMAT(DATE_ADD(NOW(), INTERVAL -48 HOUR),\'%Y-%m-%d %H:%i:%s\') and status = 0
                        then 1
                        else null
                        end
                    ) as daythree_status_Fresh',
                    'count(
                        case
                        when axion_preinspection.created_on between DATE_FORMAT(DATE_ADD(NOW(), INTERVAL -72 HOUR),\'%Y-%m-%d %H:%i:%s\') and DATE_FORMAT(DATE_ADD(NOW(), INTERVAL -48 HOUR),\'%Y-%m-%d %H:%i:%s\') and status = 12
                        then 1
                        else null
                        end
                    ) as daythree_status_Schedule',
                    'count(
                        case
                        when axion_preinspection.created_on between DATE_FORMAT(DATE_ADD(NOW(), INTERVAL -72 HOUR),\'%Y-%m-%d %H:%i:%s\') and DATE_FORMAT(DATE_ADD(NOW(), INTERVAL -48 HOUR),\'%Y-%m-%d %H:%i:%s\') and status = 8 then 1
                        else null
                        end
                    ) as daythree_status_Surveydone',
                    'count(
                        case
                        when axion_preinspection.created_on between DATE_FORMAT(DATE_ADD(NOW(), INTERVAL -96 HOUR),\'%Y-%m-%d %H:%i:%s\') and DATE_FORMAT(DATE_ADD(NOW(), INTERVAL -72 HOUR),\'%Y-%m-%d %H:%i:%s\') and status = 0
                        then 1
                        else null
                        end
                    ) as dayfour_status_Fresh',
                    'count(
                        case
                        when axion_preinspection.created_on between DATE_FORMAT(DATE_ADD(NOW(), INTERVAL -96 HOUR),\'%Y-%m-%d %H:%i:%s\') and DATE_FORMAT(DATE_ADD(NOW(), INTERVAL -72 HOUR),\'%Y-%m-%d %H:%i:%s\') and status = 12
                        then 1
                        else null
                        end
                    ) as dayfour_status_Schedule',
                    'count(
                        case
                        when axion_preinspection.created_on between DATE_FORMAT(DATE_ADD(NOW(), INTERVAL -96 HOUR),\'%Y-%m-%d %H:%i:%s\') and DATE_FORMAT(DATE_ADD(NOW(), INTERVAL -72 HOUR),\'%Y-%m-%d %H:%i:%s\') and status = 8 then 1
                        else null
                        end
                    ) as dayfour_status_Surveydone',
                    'count(
                        case
                        when axion_preinspection.created_on between DATE_FORMAT(DATE_ADD(NOW(), INTERVAL -120 HOUR),\'%Y-%m-%d %H:%i:%s\') and DATE_FORMAT(DATE_ADD(NOW(), INTERVAL -96 HOUR),\'%Y-%m-%d %H:%i:%s\') and status = 0
                        then 1
                        else null
                        end
                    ) as dayfive_status_Fresh',
                    'count(
                        case
                        when axion_preinspection.created_on between DATE_FORMAT(DATE_ADD(NOW(), INTERVAL -120 HOUR),\'%Y-%m-%d %H:%i:%s\') and DATE_FORMAT(DATE_ADD(NOW(), INTERVAL -96 HOUR),\'%Y-%m-%d %H:%i:%s\') and status = 12
                        then 1
                        else null
                        end
                    ) as dayfive_status_Schedule',
                    'count(
                        case
                        when axion_preinspection.created_on between DATE_FORMAT(DATE_ADD(NOW(), INTERVAL -120 HOUR),\'%Y-%m-%d %H:%i:%s\') and DATE_FORMAT(DATE_ADD(NOW(), INTERVAL -96 HOUR),\'%Y-%m-%d %H:%i:%s\') and status = 8 then 1
                        else null
                        end
                    ) as dayfive_status_Surveydone',
                    'count(
                        case
                            when axion_preinspection.created_on < DATE_ADD(NOW(), INTERVAL -120 HOUR) and status = 0
                        then 1
                        else null
                        end
                    ) as daysix_status_Fresh',
                    'count(
                        case
                        when axion_preinspection.created_on < DATE_ADD(NOW(), INTERVAL -120 HOUR) and status = 12
                        then 1
                        else null
                        end
                    ) as daysix_status_Schedule',
                    'count(
                        case
                        when axion_preinspection.created_on < DATE_ADD(NOW(), INTERVAL -120 HOUR) and status = 8 then 1
                        else null
                        end
                    ) as daysix_status_Surveydone',
                    'count(*) as status_TOTAL'
                ]
        );
        if($role == 'BO User'){
        $data->where(['axion_preinspection.stateId' => $userState]); 
        }elseif($role == 'Surveyor'){
        $data->where(['axion_preinspection.surveyorName' => Yii::$app->user->getId()]);
        }
        $data = $data->groupBy(['companyinfo.companyName'])
        ->orderBy('companyinfo.companyName ASC')
        ->asArray()
        ->all();
        // return $data->createCommand()->getRawSql();
        // Yii::$app->response->format = Response::FORMAT_JSON;
        // return $data;
        return $this->renderAjax('auto-load-aging-list', [
            'data' => $data,
            'title' => "Company"
        ]);
    }

    public function actionAutoLoadStatusTable(){
        $role = array_keys(Yii::$app->authManager->getRolesByUser(Yii::$app->user->getId()))[0];
        $userState = Yii::$app->user->identity->stateId;
        $data = AxionPreinspection::find()
        ->select([
            "(case 
                when followupReason = '1' then 'CALLER AND CUSTOMER NOT PICK THE CALL'
                when followupReason = '2' then 'CUSTOMER NOT PICK THE CALL'
                when followupReason = '3' then 'CUSTOMER DISCONNECT THE CALL'
                when followupReason = '4' then 'CUSTOMER NUMBER SWITCH OF / NOT REACHABLE'
                when followupReason = '5' then 'CUSTOMER OUT OF STATION'
                when followupReason = '6' then 'CUSTOMER NOT CO - OPERATE'
                when followupReason = '7' then 'CUSTOMER NOT INTERESTED'
                when followupReason = '8' then 'CUSTOMER NOT AVAILABLE'
                when followupReason = '9' then 'CUSTOMER NUMBER WRONG'
                when followupReason = '10' then 'CUSTOMER WILL CALL BACK'
                when followupReason = '11' then 'INSPECTION ALREADY DONE BY ANOTHER AGENCY'
                when followupReason = '12' then 'VEHICLE NOT AVAILABLE'
                when followupReason = '13' then 'NOT SERVICING AREA'
                when followupReason = '14' then 'CUSTOMER REFUSE FOR INSPECTION CHARGES'
                else null
            end) AS name",
            "followupReason as id",
            "count(
                case
                when created_on between DATE_FORMAT(DATE_ADD(NOW(), INTERVAL -24 HOUR),'%Y-%m-%d %H:%i:%s') and DATE_FORMAT(NOW(),'%Y-%m-%d %H:%i:%s') and status = 0
                then 1
                else null
                end
            ) as dayone_status_Fresh",
            "count(
                case
                when created_on between DATE_FORMAT(DATE_ADD(NOW(), INTERVAL -24 HOUR),'%Y-%m-%d %H:%i:%s') and DATE_FORMAT(NOW(),'%Y-%m-%d %H:%i:%s') and status = 12
                then 1
                else null
                end
            ) as dayone_status_Schedule",
            "count(
                case
                when created_on between DATE_FORMAT(DATE_ADD(NOW(), INTERVAL -24 HOUR),'%Y-%m-%d %H:%i:%s') and DATE_FORMAT(NOW(),'%Y-%m-%d %H:%i:%s') and status = 8 
                then 1
                else null
                end
            ) as dayone_status_Surveydone",
            "count(
                case
                when created_on between DATE_FORMAT(DATE_ADD(NOW(), INTERVAL -48 HOUR),'%Y-%m-%d %H:%i:%s') and DATE_FORMAT(DATE_ADD(NOW(), INTERVAL -24 HOUR),'%Y-%m-%d %H:%i:%s') and status = 0
                then 1
                else null
                end
            ) as daytwo_status_Fresh",
            "count(
                case
                when created_on between DATE_FORMAT(DATE_ADD(NOW(), INTERVAL -48 HOUR),'%Y-%m-%d %H:%i:%s') and DATE_FORMAT(DATE_ADD(NOW(), INTERVAL -24 HOUR),'%Y-%m-%d %H:%i:%s') and status = 12
                then 1
                else null
                end
            ) as daytwo_status_Schedule",
            "count(
                case
                when created_on between DATE_FORMAT(DATE_ADD(NOW(), INTERVAL -48 HOUR),'%Y-%m-%d %H:%i:%s') and DATE_FORMAT(DATE_ADD(NOW(), INTERVAL -24 HOUR),'%Y-%m-%d %H:%i:%s') and status = 8 then 1
                else null
                end
            ) as daytwo_status_Surveydone",
            "count(
                case
                when created_on between DATE_FORMAT(DATE_ADD(NOW(), INTERVAL -72 HOUR),'%Y-%m-%d %H:%i:%s') and DATE_FORMAT(DATE_ADD(NOW(), INTERVAL -48 HOUR),'%Y-%m-%d %H:%i:%s') and status = 0
                then 1
                else null
                end
            ) as daythree_status_Fresh",
            "count(
                case
                when created_on between DATE_FORMAT(DATE_ADD(NOW(), INTERVAL -72 HOUR),'%Y-%m-%d %H:%i:%s') and DATE_FORMAT(DATE_ADD(NOW(), INTERVAL -48 HOUR),'%Y-%m-%d %H:%i:%s') and status = 12
                then 1
                else null
                end
            ) as daythree_status_Schedule",
            "count(
                case
                when created_on between DATE_FORMAT(DATE_ADD(NOW(), INTERVAL -72 HOUR),'%Y-%m-%d %H:%i:%s') and DATE_FORMAT(DATE_ADD(NOW(), INTERVAL -48 HOUR),'%Y-%m-%d %H:%i:%s') and status = 8 then 1
                else null
                end
            ) as daythree_status_Surveydone",
            "count(
                case
                when created_on between DATE_FORMAT(DATE_ADD(NOW(), INTERVAL -96 HOUR),'%Y-%m-%d %H:%i:%s') and DATE_FORMAT(DATE_ADD(NOW(), INTERVAL -72 HOUR),'%Y-%m-%d %H:%i:%s') and status = 0
                then 1
                else null
                end
            ) as dayfour_status_Fresh",
            "count(
                case
                when created_on between DATE_FORMAT(DATE_ADD(NOW(), INTERVAL -96 HOUR),'%Y-%m-%d %H:%i:%s') and DATE_FORMAT(DATE_ADD(NOW(), INTERVAL -72 HOUR),'%Y-%m-%d %H:%i:%s') and status = 12
                then 1
                else null
                end
            ) as dayfour_status_Schedule",
            "count(
                case
                when created_on between DATE_FORMAT(DATE_ADD(NOW(), INTERVAL -96 HOUR),'%Y-%m-%d %H:%i:%s') and DATE_FORMAT(DATE_ADD(NOW(), INTERVAL -72 HOUR),'%Y-%m-%d %H:%i:%s') and status = 8 then 1
                else null
                end
            ) as dayfour_status_Surveydone",
            "count(
                case
                when created_on between DATE_FORMAT(DATE_ADD(NOW(), INTERVAL -120 HOUR),'%Y-%m-%d %H:%i:%s') and DATE_FORMAT(DATE_ADD(NOW(), INTERVAL -96 HOUR),'%Y-%m-%d %H:%i:%s') and status = 0
                then 1
                else null
                end
            ) as dayfive_status_Fresh",
            "count(
                case
                when created_on between DATE_FORMAT(DATE_ADD(NOW(), INTERVAL -120 HOUR),'%Y-%m-%d %H:%i:%s') and DATE_FORMAT(DATE_ADD(NOW(), INTERVAL -96 HOUR),'%Y-%m-%d %H:%i:%s') and status = 12
                then 1
                else null
                end
            ) as dayfive_status_Schedule",
            "count(
                case
                when created_on between DATE_FORMAT(DATE_ADD(NOW(), INTERVAL -120 HOUR),'%Y-%m-%d %H:%i:%s') and DATE_FORMAT(DATE_ADD(NOW(), INTERVAL -96 HOUR),'%Y-%m-%d %H:%i:%s') and status = 8 then 1
                else null
                end
            ) as dayfive_status_Surveydone",
            "count(
                case
                    when created_on < DATE_ADD(NOW(), INTERVAL -120 HOUR) and status = 0
                then 1
                else null
                end
            ) as daysix_status_Fresh",
            "count(
                case
                when created_on < DATE_ADD(NOW(), INTERVAL -120 HOUR) and status = 12
                then 1
                else null
                end
            ) as daysix_status_Schedule",
            "count(
                case
                when created_on < DATE_ADD(NOW(), INTERVAL -120 HOUR) and status = 8 then 1
                else null
                end
            ) as daysix_status_Surveydone",
            "count(*) as status_TOTAL"
        ])
        ->where(['not in','followupReason',[0]]);
        if($role == 'BO User'){
        $data->andFilterWhere(['axion_preinspection.stateId' => $userState]); 
        }elseif($role == 'Surveyor'){
        $data->andWhere(['axion_preinspection.surveyorName' => Yii::$app->user->getId()]);
        }
        $data = $data->groupBy(['followupReason'])
        ->orderBy('followupReason ASC')
        ->asArray()
        ->all();
        return $this->renderAjax('auto-load-aging-list', [
            'data' => $data,
            'title' => "Status"
        ]);
    }

    public function actionAutoLoadRoTable(){
        $role = array_keys(Yii::$app->authManager->getRolesByUser(Yii::$app->user->getId()))[0];
        $userState = Yii::$app->user->identity->stateId;
        $data = MasterState::find()
        ->join('INNER JOIN','users as users','state_master.id = users.stateId')
        ->join('INNER JOIN','auth_assignment as auth_assignment','users.id = auth_assignment.user_id')
        ->join('LEFT JOIN','axion_preinspection as axion_preinspection','users.stateId = axion_preinspection.stateId')
        ->select([
            "users.firstName as name",
            "users.stateId as id",
            "count(
                case
                when axion_preinspection.created_on between DATE_FORMAT(DATE_ADD(NOW(), INTERVAL -24 HOUR),'%Y-%m-%d %H:%i:%s') and DATE_FORMAT(NOW(),'%Y-%m-%d %H:%i:%s') and status = 0
                then 1
                else null
                end
            ) as dayone_status_Fresh",
            "count(
                case
                when axion_preinspection.created_on between DATE_FORMAT(DATE_ADD(NOW(), INTERVAL -24 HOUR),'%Y-%m-%d %H:%i:%s') and DATE_FORMAT(NOW(),'%Y-%m-%d %H:%i:%s') and status = 12
                then 1
                else null
                end
            ) as dayone_status_Schedule",
            "count(
                case
                when axion_preinspection.created_on between DATE_FORMAT(DATE_ADD(NOW(), INTERVAL -24 HOUR),'%Y-%m-%d %H:%i:%s') and DATE_FORMAT(NOW(),'%Y-%m-%d %H:%i:%s') and status = 8 
                then 1
                else null
                end
            ) as dayone_status_Surveydone",
            "count(
                case
                when axion_preinspection.created_on between DATE_FORMAT(DATE_ADD(NOW(), INTERVAL -48 HOUR),'%Y-%m-%d %H:%i:%s') and DATE_FORMAT(DATE_ADD(NOW(), INTERVAL -24 HOUR),'%Y-%m-%d %H:%i:%s') and status = 0
                then 1
                else null
                end
            ) as daytwo_status_Fresh",
            "count(
                case
                when axion_preinspection.created_on between DATE_FORMAT(DATE_ADD(NOW(), INTERVAL -48 HOUR),'%Y-%m-%d %H:%i:%s') and DATE_FORMAT(DATE_ADD(NOW(), INTERVAL -24 HOUR),'%Y-%m-%d %H:%i:%s') and status = 12
                then 1
                else null
                end
            ) as daytwo_status_Schedule",
            "count(
                case
                when axion_preinspection.created_on between DATE_FORMAT(DATE_ADD(NOW(), INTERVAL -48 HOUR),'%Y-%m-%d %H:%i:%s') and DATE_FORMAT(DATE_ADD(NOW(), INTERVAL -24 HOUR),'%Y-%m-%d %H:%i:%s') and status = 8 then 1
                else null
                end
            ) as daytwo_status_Surveydone",
            "count(
                case
                when axion_preinspection.created_on between DATE_FORMAT(DATE_ADD(NOW(), INTERVAL -72 HOUR),'%Y-%m-%d %H:%i:%s') and DATE_FORMAT(DATE_ADD(NOW(), INTERVAL -48 HOUR),'%Y-%m-%d %H:%i:%s') and status = 0
                then 1
                else null
                end
            ) as daythree_status_Fresh",
            "count(
                case
                when axion_preinspection.created_on between DATE_FORMAT(DATE_ADD(NOW(), INTERVAL -72 HOUR),'%Y-%m-%d %H:%i:%s') and DATE_FORMAT(DATE_ADD(NOW(), INTERVAL -48 HOUR),'%Y-%m-%d %H:%i:%s') and status = 12
                then 1
                else null
                end
            ) as daythree_status_Schedule",
            "count(
                case
                when axion_preinspection.created_on between DATE_FORMAT(DATE_ADD(NOW(), INTERVAL -72 HOUR),'%Y-%m-%d %H:%i:%s') and DATE_FORMAT(DATE_ADD(NOW(), INTERVAL -48 HOUR),'%Y-%m-%d %H:%i:%s') and status = 8 then 1
                else null
                end
            ) as daythree_status_Surveydone",
            "count(
                case
                when axion_preinspection.created_on between DATE_FORMAT(DATE_ADD(NOW(), INTERVAL -96 HOUR),'%Y-%m-%d %H:%i:%s') and DATE_FORMAT(DATE_ADD(NOW(), INTERVAL -72 HOUR),'%Y-%m-%d %H:%i:%s') and status = 0
                then 1
                else null
                end
            ) as dayfour_status_Fresh",
            "count(
                case
                when axion_preinspection.created_on between DATE_FORMAT(DATE_ADD(NOW(), INTERVAL -96 HOUR),'%Y-%m-%d %H:%i:%s') and DATE_FORMAT(DATE_ADD(NOW(), INTERVAL -72 HOUR),'%Y-%m-%d %H:%i:%s') and status = 12
                then 1
                else null
                end
            ) as dayfour_status_Schedule",
            "count(
                case
                when axion_preinspection.created_on between DATE_FORMAT(DATE_ADD(NOW(), INTERVAL -96 HOUR),'%Y-%m-%d %H:%i:%s') and DATE_FORMAT(DATE_ADD(NOW(), INTERVAL -72 HOUR),'%Y-%m-%d %H:%i:%s') and status = 8 then 1
                else null
                end
            ) as dayfour_status_Surveydone",
            "count(
                case
                when axion_preinspection.created_on between DATE_FORMAT(DATE_ADD(NOW(), INTERVAL -120 HOUR),'%Y-%m-%d %H:%i:%s') and DATE_FORMAT(DATE_ADD(NOW(), INTERVAL -96 HOUR),'%Y-%m-%d %H:%i:%s') and status = 0
                then 1
                else null
                end
            ) as dayfive_status_Fresh",
            "count(
                case
                when axion_preinspection.created_on between DATE_FORMAT(DATE_ADD(NOW(), INTERVAL -120 HOUR),'%Y-%m-%d %H:%i:%s') and DATE_FORMAT(DATE_ADD(NOW(), INTERVAL -96 HOUR),'%Y-%m-%d %H:%i:%s') and status = 12
                then 1
                else null
                end
            ) as dayfive_status_Schedule",
            "count(
                case
                when axion_preinspection.created_on between DATE_FORMAT(DATE_ADD(NOW(), INTERVAL -120 HOUR),'%Y-%m-%d %H:%i:%s') and DATE_FORMAT(DATE_ADD(NOW(), INTERVAL -96 HOUR),'%Y-%m-%d %H:%i:%s') and status = 8 then 1
                else null
                end
            ) as dayfive_status_Surveydone",
            "count(
                case
                    when axion_preinspection.created_on < DATE_ADD(NOW(), INTERVAL -120 HOUR) and status = 0
                then 1
                else null
                end
            ) as daysix_status_Fresh",
            "count(
                case
                when axion_preinspection.created_on < DATE_ADD(NOW(), INTERVAL -120 HOUR) and status = 12
                then 1
                else null
                end
            ) as daysix_status_Schedule",
            "count(
                case
                when axion_preinspection.created_on < DATE_ADD(NOW(), INTERVAL -120 HOUR) and status = 8 then 1
                else null
                end
            ) as daysix_status_Surveydone",
            "count(*) as status_TOTAL"
        ])
        ->where(['auth_assignment.item_name' => 'BO User']);
        if($role == 'BO User'){
        $data->andFilterWhere(['axion_preinspection.stateId' => $userState]); 
        }elseif($role == 'Surveyor'){
        $data->andWhere(['axion_preinspection.surveyorName' => Yii::$app->user->getId()]);
        }
        $data = $data->groupBy(['users.id'])
        ->orderBy('auth_assignment.item_name ASC')
        ->asArray()
        ->all();
        return $this->renderAjax('auto-load-aging-list', [
            'data' => $data,
            'title' => "RO"
        ]);
    }

    public function actionAutoLoadFeTable(){
        $role = array_keys(Yii::$app->authManager->getRolesByUser(Yii::$app->user->getId()))[0];
        $userState = Yii::$app->user->identity->stateId;
        $data = AxionPreinspection::find()
        ->join('INNER JOIN','users as users','users.id = axion_preinspection.surveyorName')
        ->join('INNER JOIN','auth_assignment as auth_assignment','users.id = auth_assignment.user_id')
        ->select([
            "users.firstName as name",
            "users.id as id",
            "count(
                case
                    when axion_preinspection.created_on between DATE_FORMAT(DATE_ADD(NOW(), INTERVAL -24 HOUR),'%Y-%m-%d %H:%i:%s') and DATE_FORMAT(NOW(),'%Y-%m-%d %H:%i:%s') and status = 0
                    then 1
                    else null
                end
            ) as dayone_status_Fresh",
            "count(
                case
                    when axion_preinspection.created_on between DATE_FORMAT(DATE_ADD(NOW(), INTERVAL -24 HOUR),'%Y-%m-%d %H:%i:%s') and DATE_FORMAT(NOW(),'%Y-%m-%d %H:%i:%s') and status = 12
                    then 1
                    else null
                end
            ) as dayone_status_Schedule",
            "count(
                case
                    when axion_preinspection.created_on between DATE_FORMAT(DATE_ADD(NOW(), INTERVAL -24 HOUR),'%Y-%m-%d %H:%i:%s') and DATE_FORMAT(NOW(),'%Y-%m-%d %H:%i:%s') and status = 8 
                    then 1
                    else null
                end
            ) as dayone_status_Surveydone",
            "count(
                case
                    when axion_preinspection.created_on between DATE_FORMAT(DATE_ADD(NOW(), INTERVAL -48 HOUR),'%Y-%m-%d %H:%i:%s') and DATE_FORMAT(DATE_ADD(NOW(), INTERVAL -24 HOUR),'%Y-%m-%d %H:%i:%s') and status = 0
                    then 1
                    else null
                end
            ) as daytwo_status_Fresh",
            "count(
                case
                    when axion_preinspection.created_on between DATE_FORMAT(DATE_ADD(NOW(), INTERVAL -48 HOUR),'%Y-%m-%d %H:%i:%s') and DATE_FORMAT(DATE_ADD(NOW(), INTERVAL -24 HOUR),'%Y-%m-%d %H:%i:%s') and status = 12
                    then 1
                    else null
                end
            ) as daytwo_status_Schedule",
            "count(
                case
                    when axion_preinspection.created_on between DATE_FORMAT(DATE_ADD(NOW(), INTERVAL -48 HOUR),'%Y-%m-%d %H:%i:%s') and DATE_FORMAT(DATE_ADD(NOW(), INTERVAL -24 HOUR),'%Y-%m-%d %H:%i:%s') and status = 8 then 1
                    else null
                end
            ) as daytwo_status_Surveydone",
            "count(
                case
                    when axion_preinspection.created_on between DATE_FORMAT(DATE_ADD(NOW(), INTERVAL -72 HOUR),'%Y-%m-%d %H:%i:%s') and DATE_FORMAT(DATE_ADD(NOW(), INTERVAL -48 HOUR),'%Y-%m-%d %H:%i:%s') and status = 0
                    then 1
                    else null
                end
            ) as daythree_status_Fresh",
            "count(
                case
                    when axion_preinspection.created_on between DATE_FORMAT(DATE_ADD(NOW(), INTERVAL -72 HOUR),'%Y-%m-%d %H:%i:%s') and DATE_FORMAT(DATE_ADD(NOW(), INTERVAL -48 HOUR),'%Y-%m-%d %H:%i:%s') and status = 12
                    then 1
                    else null
                end
            ) as daythree_status_Schedule",
            "count(
                case
                    when axion_preinspection.created_on between DATE_FORMAT(DATE_ADD(NOW(), INTERVAL -72 HOUR),'%Y-%m-%d %H:%i:%s') and DATE_FORMAT(DATE_ADD(NOW(), INTERVAL -48 HOUR),'%Y-%m-%d %H:%i:%s') and status = 8 then 1
                    else null
                end
            ) as daythree_status_Surveydone",
            "count(
                case
                    when axion_preinspection.created_on between DATE_FORMAT(DATE_ADD(NOW(), INTERVAL -96 HOUR),'%Y-%m-%d %H:%i:%s') and DATE_FORMAT(DATE_ADD(NOW(), INTERVAL -72 HOUR),'%Y-%m-%d %H:%i:%s') and status = 0
                    then 1
                    else null
                end
            ) as dayfour_status_Fresh",
            "count(
                case
                    when axion_preinspection.created_on between DATE_FORMAT(DATE_ADD(NOW(), INTERVAL -96 HOUR),'%Y-%m-%d %H:%i:%s') and DATE_FORMAT(DATE_ADD(NOW(), INTERVAL -72 HOUR),'%Y-%m-%d %H:%i:%s') and status = 12
                    then 1
                    else null
                end
            ) as dayfour_status_Schedule",
            "count(
                case
                    when axion_preinspection.created_on between DATE_FORMAT(DATE_ADD(NOW(), INTERVAL -96 HOUR),'%Y-%m-%d %H:%i:%s') and DATE_FORMAT(DATE_ADD(NOW(), INTERVAL -72 HOUR),'%Y-%m-%d %H:%i:%s') and status = 8 then 1
                    else null
                end
            ) as dayfour_status_Surveydone",
            "count(
                case
                    when axion_preinspection.created_on between DATE_FORMAT(DATE_ADD(NOW(), INTERVAL -120 HOUR),'%Y-%m-%d %H:%i:%s') and DATE_FORMAT(DATE_ADD(NOW(), INTERVAL -96 HOUR),'%Y-%m-%d %H:%i:%s') and status = 0
                    then 1
                    else null
                end
            ) as dayfive_status_Fresh",
            "count(
                case
                    when axion_preinspection.created_on between DATE_FORMAT(DATE_ADD(NOW(), INTERVAL -120 HOUR),'%Y-%m-%d %H:%i:%s') and DATE_FORMAT(DATE_ADD(NOW(), INTERVAL -96 HOUR),'%Y-%m-%d %H:%i:%s') and status = 12
                    then 1
                    else null
                end
            ) as dayfive_status_Schedule",
            "count(
                case
                    when axion_preinspection.created_on between DATE_FORMAT(DATE_ADD(NOW(), INTERVAL -120 HOUR),'%Y-%m-%d %H:%i:%s') and DATE_FORMAT(DATE_ADD(NOW(), INTERVAL -96 HOUR),'%Y-%m-%d %H:%i:%s') and status = 8 then 1
                    else null
                end
            ) as dayfive_status_Surveydone",
            "count(
                case
                        when axion_preinspection.created_on < DATE_ADD(NOW(), INTERVAL -120 HOUR) and status = 0
                    then 1
                    else null
                end
            ) as daysix_status_Fresh",
            "count(
                case
                    when axion_preinspection.created_on < DATE_ADD(NOW(), INTERVAL -120 HOUR) and status = 12
                    then 1
                    else null
                end
            ) as daysix_status_Schedule",
            "count(
                case
                    when axion_preinspection.created_on < DATE_ADD(NOW(), INTERVAL -120 HOUR) and status = 8 then 1
                    else null
                end
            ) as daysix_status_Surveydone",
            "count(*) as status_TOTAL"
        ])
        ->where(['auth_assignment.item_name' => 'Surveyor']);
        // ->andWhere(['axion_preinspection.surveyorName' => 'users.id'])
        if($role == 'BO User'){
            $surveyor_ids = User::find()->select(["GROUP_CONCAT(id ORDER BY id ASC SEPARATOR ',') as serveyor_ids"])->where(['roId' => Yii::$app->user->getId()])->asArray()
            ->all();
            // foreach($surveyor_ids as $surveyor_id){
                $surveyorArray = explode(',',$surveyor_ids[0]['serveyor_ids']);
                // return print_r($surveyorArray);
            // }
            $data->andFilterWhere(['axion_preinspection.stateId' => $userState])
           ->andWhere(['users.roId' => Yii::$app->user->getId()])
            ->andWhere(['in','axion_preinspection.surveyorName',$surveyorArray]);
        }elseif($role == 'Surveyor'){
            $data->andWhere(['axion_preinspection.surveyorName' => Yii::$app->user->getId()]);
        }
        $data = $data->groupBy(['axion_preinspection.surveyorName'])
        ->orderBy('users.firstName ASC')
        ->asArray()
        ->all();
        // return $data->createCommand()->getRawSql();
        return $this->renderAjax('auto-load-aging-list', [
            'data' => $data,
            'title' => "FE"
        ]);
    }
    
    // Target Report
    public function actionLoadCompletedTable(){
        $role = array_keys(Yii::$app->authManager->getRolesByUser(Yii::$app->user->getId()))[0];
        $userState = Yii::$app->user->identity->stateId;
        $currentday = date('d');
        $currentday = $currentday < 10 ? '0'.$currentday : $currentday;
        $currentMonth = date('m');
        $lastMonth = date('m') - 1;
        $year = date('Y');
        $year = $currentMonth == '01' ? ($year - 1) : $year;
        $lastMonth = $lastMonth < 10 ? '0'.$lastMonth : $lastMonth;
        $startDate = '01';
        $endDate = date('t', strtotime('last month'));
        $dayStart = '00:00:00';
        $dayEnd = '23:59:59';
        $resultArray = array();
        // return $year."-".$lastMonth."-".$startDate." ".$dayStart."' and '".$year."-".$lastMonth."-".$startDate." ".$dayEnd;
        if($lastMonth == 0){
            $data = AxionPreinspection::find()
            ->join('INNER JOIN','users as users','axion_preinspection.userId = users.id')
            ->join('LEFT JOIN','auth_assignment','auth_assignment.user_id = users.id')
            ->select([
                "users.firstName as name",
                "users.id as id",
                "users.roCompletedCase as completedcase",
                "count(
                    case
                    when axion_preinspection.completedSurveyDateTime between '".$year."-12-".$startDate." ".$dayStart."' and '".$year."-12-".$endDate." ".$dayEnd."' and status IN (101,102,104)
                    then 1
                    else null
                    end
                ) as last_month",
                "count(
                    case
                    when axion_preinspection.completedSurveyDateTime between '".$year."-12-".$startDate." ".$dayStart."' and '".$year."-12-".$currentday." ".$dayEnd."' and status IN (101,102,104)
                    then 1
                    else null
                    end
                ) as upto_last_month",
                "count(
                    case
                    when axion_preinspection.completedSurveyDateTime between '".($year + 1)."-".$currentMonth."-".$startDate." ".$dayStart."' and '".($year + 1)."-".$currentMonth."-".$currentday." ".$dayEnd."' and status IN (101,102,104)
                    then 1
                    else null
                    end
                ) as upto_current_month"
            ]);
        }else{
            $data = AxionPreinspection::find()
            ->join('INNER JOIN','users as users','axion_preinspection.userId = users.id')
            ->join('LEFT JOIN','auth_assignment','auth_assignment.user_id = users.id')
            ->select([
                "users.firstName as name",
                "users.id as id",
                "users.roCompletedCase as completedcase",
                "count(
                    case
                    when axion_preinspection.completedSurveyDateTime between '".$year."-".$lastMonth."-".$startDate." ".$dayStart."' and '".$year."-".$lastMonth."-".$endDate." ".$dayEnd."' and status IN (101,102,104)
                    then 1
                    else null
                    end
                ) as last_month",
                "count(
                    case
                    when axion_preinspection.completedSurveyDateTime between '".$year."-".$lastMonth."-".$startDate." ".$dayStart."' and '".$year."-".$lastMonth."-".$currentday." ".$dayEnd."' and status IN (101,102,104)
                    then 1
                    else null
                    end
                ) as upto_last_month",
                "count(
                    case
                    when axion_preinspection.completedSurveyDateTime between '".$year."-".$currentMonth."-".$startDate." ".$dayStart."' and '".$year."-".$currentMonth."-".$currentday." ".$dayEnd."' and status IN (101,102,104)
                    then 1
                    else null
                    end
                ) as upto_current_month"
            ]);
        }
        if($role == 'BO User'){            
            $bexeUsers_list=array();
            $surveyorUsers_list=array();
            $boUsers_list=array();
            $bexeUsers = User::find()->select('id')->join('LEFT JOIN','auth_assignment','auth_assignment.user_id = id')
                        ->andFilterWhere(['auth_assignment.item_name' => 'Branch Executive'])
                        ->andFilterWhere(['users.roId'=> Yii::$app->user->identity->id])->all();

            if($bexeUsers){
                foreach ($bexeUsers as $key => $value) {
                    $bexeUsers_list[] = $value->id;
                }
            }
            $bexeUsers_list = ($bexeUsers_list) ? implode(',', $bexeUsers_list) : '';

            $surveyorUsers = User::find()->select('id')->join('LEFT JOIN','auth_assignment','auth_assignment.user_id = id')
                            ->andFilterWhere(['auth_assignment.item_name' => 'Surveyor'])
                            ->andFilterWhere(['users.roId'=> Yii::$app->user->identity->id])->all();

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

            if($bexeUsers_list && !empty($bexeUsers_list)){
                if($surveyorUsers_list && !empty($surveyorUsers_list)){
                    // return json_encode($data);
                    $data->where(['and', 'status IS NOT NULL AND userId NOT IN ('.$boUsers_list.') AND auth_assignment.item_name = "BO User"', ['or', 'userId = '.Yii::$app->user->getId(), 'callerName IN ('.$bexeUsers_list.')', 'surveyorName IN ('.$surveyorUsers_list.')']]);
                }else{
                    $data->where(['and', 'status IS NOT NULL AND userId NOT IN ('.$boUsers_list.') AND auth_assignment.item_name = "BO User"', ['or', 'userId = '.Yii::$app->user->getId(), 'callerName IN ('.$bexeUsers_list.')']]);
                }                
            }else{
                if($surveyorUsers_list && !empty($surveyorUsers_list)){
                    $data->where(['and', 'status IS NOT NULL AND userId NOT IN ('.$boUsers_list.') AND auth_assignment.item_name = "BO User"', ['or', 'userId = '.Yii::$app->user->getId(), 'surveyorName IN ('.$surveyorUsers_list.')']]);
                }else{
                    $data->where(['and', 'status IS NOT NULL AND userId NOT IN ('.$boUsers_list.') AND auth_assignment.item_name = "BO User"', ['or', 'userId = '.Yii::$app->user->getId()]]);
                }      
            }
            // $data->andFilterWhere(['axion_preinspection.stateId' => $userState]);
            // $data->andFilterWhere(['>=', 'axion_preinspection.completedSurveyDateTime', $year."-".$lastMonth."-".$startDate." ".$dayStart]);
            // ->andFilterWhere(['users.id' => Yii::$app->user->getId()]); 
            $data = $data
            // ->andFilterWhere(['>=', 'axion_preinspection.completedSurveyDateTime', $year."-".$lastMonth."-".$startDate." ".$dayStart])
            ->groupBy(['MONTH(NOW())'])
            ->asArray()
            ->all();
            array_push($resultArray,$data);
        }
        else{
            $bousers = User::find()->select('id')->join('LEFT JOIN','auth_assignment','auth_assignment.user_id = id')
                        ->andFilterWhere(['auth_assignment.item_name' => 'BO User'])->all();
            foreach($bousers as $bouser){
                $bexeUsers_list1=array();
                $surveyorUsers_list1=array();
                $boUsers_list1=array();
                $bexeUsersAdmin = User::find()->select('id')->join('LEFT JOIN','auth_assignment','auth_assignment.user_id = id')
                        ->andFilterWhere(['auth_assignment.item_name' => 'Branch Executive'])
                        ->andFilterWhere(['users.roId'=> $bouser->id])->all();

                if($bexeUsersAdmin){
                    foreach ($bexeUsersAdmin as $key => $value) {
                        // $bexeUsers_list[] = $value->id;
                        // return gettype($bexeUsers_list);
                        if(is_array($bexeUsers_list1)){
                            array_push($bexeUsers_list1,$value->id);
                            // return gettype($bexeUsers_list);
                        }
                    }
                }
                // return json_encode($bexeUsers_list);
                if(is_array($bexeUsers_list1)){
                    $bexeUsers_list1 = ($bexeUsers_list1) ? implode(', ', $bexeUsers_list1) : '';
                }

                // return $bexeUsers_list;

                $surveyorUsersAdmin = User::find()->select('id')->join('LEFT JOIN','auth_assignment','auth_assignment.user_id = id')
                                ->andFilterWhere(['auth_assignment.item_name' => 'Surveyor'])
                                ->andFilterWhere(['users.roId'=> $bouser->id])->all();

                if($surveyorUsersAdmin){
                    foreach ($surveyorUsersAdmin as $key => $value) {
                        // $surveyorUsers_list[] = $value->id;
                        if(is_array($surveyorUsers_list1)){
                            array_push($surveyorUsers_list1,$value->id);
                            // return gettype($bexeUsers_list);
                        }
                        // array_push($surveyorUsers_list,$value->id);
                    }
                }
                if(is_array($surveyorUsers_list1)){
                    $surveyorUsers_list1 = ($surveyorUsers_list1) ? implode(', ', $surveyorUsers_list1) : '';
                }

                //Get All Bo User's/Ro User's user id. 
                $boUsersAdmin = User::find()->select('id')->join('LEFT JOIN','auth_assignment','auth_assignment.user_id = id')
                            ->andFilterWhere(['auth_assignment.item_name' => 'BO User'])
                            ->andFilterWhere(['!=', 'users.id', $bouser->id])->all();

                if($boUsersAdmin){
                    foreach ($boUsersAdmin as $key => $value) {
                        // $boUsers_list[] = $value->id;
                        if(is_array($boUsers_list1)){
                            array_push($boUsers_list1,$value->id);
                            // return gettype($bexeUsers_list);
                        }
                        // array_push($boUsers_list,$value->id);
                    }
                }
                if(is_array($boUsers_list1)){
                    $boUsers_list1 = ($boUsers_list1) ? implode(', ', $boUsers_list1) : '';
                }

                if($bexeUsers_list1 && !empty($bexeUsers_list1)){
                    if($surveyorUsers_list1 && !empty($surveyorUsers_list1)){
                        // return json_encode($data);
                        $data->where(['and', 'status IS NOT NULL AND userId NOT IN ('.$boUsers_list1.') AND auth_assignment.item_name = "BO User"', ['or', 'userId = '.$bouser->id, 'callerName IN ('.$bexeUsers_list1.')', 'surveyorName IN ('.$surveyorUsers_list1.')']]);
                    }else{
                        $data->where(['and', 'status IS NOT NULL AND userId NOT IN ('.$boUsers_list1.') AND auth_assignment.item_name = "BO User"', ['or', 'userId = '.$bouser->id, 'callerName IN ('.$bexeUsers_list1.')']]);
                    }                
                }else{
                    if($surveyorUsers_list && !empty($surveyorUsers_list)){
                        $data->where(['and', 'status IS NOT NULL AND userId NOT IN ('.$boUsers_list1.') AND auth_assignment.item_name = "BO User"', ['or', 'userId = '.$bouser->id, 'surveyorName IN ('.$surveyorUsers_list1.')']]);
                    }else{
                        $data->where(['and', 'status IS NOT NULL AND userId NOT IN ('.$boUsers_list1.') AND auth_assignment.item_name = "BO User"', ['or', 'userId = '.$bouser->id]]);
                    }      
                }
                $data1 = $data->
                // andFilterWhere(['>=', 'axion_preinspection.completedSurveyDateTime', $year."-".$lastMonth."-".$startDate." ".$dayStart])
                // ->
                groupBy(['MONTH(NOW())'])
                // ;
                // echo $data1->createCommand()->getRawSql();
                // echo "<br>";
                // echo "<br>";
                ->asArray()
                ->all();
                array_push($resultArray,$data1);
            }
        }
        // return die;
        return $this->renderAjax('target-report-case', [
            'data' => $resultArray,
            'title' => "Completed"
        ]);
    }

    public function actionLoadCancelledTable(){
        $role = array_keys(Yii::$app->authManager->getRolesByUser(Yii::$app->user->getId()))[0];
        $userState = Yii::$app->user->identity->stateId;
        $currentday = date('d');
        $currentday = $currentday < 10 ? '0'.$currentday : $currentday;
        $currentMonth = date('m');
        $lastMonth = date('m') - 1;
        $year = date('Y');
        $year = $currentMonth == '01' ? ($year - 1) : $year;
        $lastMonth = $lastMonth < 10 ? '0'.$lastMonth : $lastMonth;
        $startDate = '01';
        $endDate = date('t', strtotime('last month'));
        $dayStart = '00:00:00';
        $dayEnd = '23:59:59';
        $resultArray = array();
        // return $year."-".$lastMonth."-".$startDate." ".$dayStart."' and '".$year."-".$lastMonth."-".$startDate." ".$dayEnd;
        if($lastMonth == 0){
            $data = AxionPreinspection::find()
            ->join('INNER JOIN','users as users','axion_preinspection.userId = users.id')
            ->join('LEFT JOIN','auth_assignment','auth_assignment.user_id = users.id')
            ->select([
                "users.firstName as name",
                "users.id as id",
                "users.roCompletedCase as completedcase",
                "count(
                    case
                    when axion_preinspection.completedSurveyDateTime between '".$year."-12-".$startDate." ".$dayStart."' and '".$year."-12-".$endDate." ".$dayEnd."' and status IN (9)
                    then 1
                    else null
                    end
                ) as last_month",
                "count(
                    case
                    when axion_preinspection.completedSurveyDateTime between '".$year."-12-".$startDate." ".$dayStart."' and '".$year."-12-"."-".$currentday." ".$dayEnd."' and status IN (9)
                    then 1
                    else null
                    end
                ) as upto_last_month",
                "count(
                    case
                    when axion_preinspection.completedSurveyDateTime between '".($year + 1)."-".$currentMonth."-".$startDate." ".$dayStart."' and '".($year + 1)."-".$currentMonth."-".$currentday." ".$dayEnd."' and status IN (9)
                    then 1
                    else null
                    end
                ) as upto_current_month"
            ]);
        }else{
            $data = AxionPreinspection::find()
            ->join('INNER JOIN','users as users','axion_preinspection.userId = users.id')
            ->join('LEFT JOIN','auth_assignment','auth_assignment.user_id = users.id')
            ->select([
                "users.firstName as name",
                "users.id as id",
                "users.roCompletedCase as completedcase",
                "count(
                    case
                    when axion_preinspection.completedSurveyDateTime between '".$year."-".$lastMonth."-".$startDate." ".$dayStart."' and '".$year."-".$lastMonth."-".$endDate." ".$dayEnd."' and status IN (9)
                    then 1
                    else null
                    end
                ) as last_month",
                "count(
                    case
                    when axion_preinspection.completedSurveyDateTime between '".$year."-".$lastMonth."-".$startDate." ".$dayStart."' and '".$year."-".$lastMonth."-".$currentday." ".$dayEnd."' and status IN (9)
                    then 1
                    else null
                    end
                ) as upto_last_month",
                "count(
                    case
                    when axion_preinspection.completedSurveyDateTime between '".$year."-".$currentMonth."-".$startDate." ".$dayStart."' and '".$year."-".$currentMonth."-".$currentday." ".$dayEnd."' and status IN (9)
                    then 1
                    else null
                    end
                ) as upto_current_month"
            ]);
        }
        if($role == 'BO User'){            
            $bexeUsers_list=array();
            $surveyorUsers_list=array();
            $boUsers_list=array();
            $bexeUsers = User::find()->select('id')->join('LEFT JOIN','auth_assignment','auth_assignment.user_id = id')
                        ->andFilterWhere(['auth_assignment.item_name' => 'Branch Executive'])
                        ->andFilterWhere(['users.roId'=> Yii::$app->user->identity->id])->all();

            if($bexeUsers){
                foreach ($bexeUsers as $key => $value) {
                    $bexeUsers_list[] = $value->id;
                }
            }
            $bexeUsers_list = ($bexeUsers_list) ? implode(',', $bexeUsers_list) : '';

            $surveyorUsers = User::find()->select('id')->join('LEFT JOIN','auth_assignment','auth_assignment.user_id = id')
                            ->andFilterWhere(['auth_assignment.item_name' => 'Surveyor'])
                            ->andFilterWhere(['users.roId'=> Yii::$app->user->identity->id])->all();

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

            if($bexeUsers_list && !empty($bexeUsers_list)){
                if($surveyorUsers_list && !empty($surveyorUsers_list)){
                    // return json_encode($data);
                    $data->where(['and', 'status IS NOT NULL AND userId NOT IN ('.$boUsers_list.') AND auth_assignment.item_name = "BO User"', ['or', 'userId = '.Yii::$app->user->getId(), 'callerName IN ('.$bexeUsers_list.')', 'surveyorName IN ('.$surveyorUsers_list.')']]);
                }else{
                    $data->where(['and', 'status IS NOT NULL AND userId NOT IN ('.$boUsers_list.') AND auth_assignment.item_name = "BO User"', ['or', 'userId = '.Yii::$app->user->getId(), 'callerName IN ('.$bexeUsers_list.')']]);
                }                
            }else{
                if($surveyorUsers_list && !empty($surveyorUsers_list)){
                    $data->where(['and', 'status IS NOT NULL AND userId NOT IN ('.$boUsers_list.') AND auth_assignment.item_name = "BO User"', ['or', 'userId = '.Yii::$app->user->getId(), 'surveyorName IN ('.$surveyorUsers_list.')']]);
                }else{
                    $data->where(['and', 'status IS NOT NULL AND userId NOT IN ('.$boUsers_list.') AND auth_assignment.item_name = "BO User"', ['or', 'userId = '.Yii::$app->user->getId()]]);
                }      
            }
            // $data->andFilterWhere(['axion_preinspection.stateId' => $userState]);
            // $data->andFilterWhere(['>=', 'axion_preinspection.completedSurveyDateTime', $year."-".$lastMonth."-".$startDate." ".$dayStart]);
            // ->andFilterWhere(['users.id' => Yii::$app->user->getId()]); 
            $data = $data->
            // andFilterWhere(['>=', 'axion_preinspection.completedSurveyDateTime', $year."-".$lastMonth."-".$startDate." ".$dayStart])
            // ->
            groupBy(['MONTH(NOW())'])
            ->asArray()
            ->all();
            array_push($resultArray,$data);
        }
        else{
            $bousers = User::find()->select('id')->join('LEFT JOIN','auth_assignment','auth_assignment.user_id = id')
                        ->andFilterWhere(['auth_assignment.item_name' => 'BO User'])->all();
            foreach($bousers as $bouser){
                $bexeUsers_list1=array();
                $surveyorUsers_list1=array();
                $boUsers_list1=array();
                $bexeUsersAdmin = User::find()->select('id')->join('LEFT JOIN','auth_assignment','auth_assignment.user_id = id')
                        ->andFilterWhere(['auth_assignment.item_name' => 'Branch Executive'])
                        ->andFilterWhere(['users.roId'=> $bouser->id])->all();

                if($bexeUsersAdmin){
                    foreach ($bexeUsersAdmin as $key => $value) {
                        // $bexeUsers_list[] = $value->id;
                        // return gettype($bexeUsers_list);
                        if(is_array($bexeUsers_list1)){
                            array_push($bexeUsers_list1,$value->id);
                            // return gettype($bexeUsers_list);
                        }
                    }
                }
                // return json_encode($bexeUsers_list);
                if(is_array($bexeUsers_list1)){
                    $bexeUsers_list1 = ($bexeUsers_list1) ? implode(', ', $bexeUsers_list1) : '';
                }

                // return $bexeUsers_list;

                $surveyorUsersAdmin = User::find()->select('id')->join('LEFT JOIN','auth_assignment','auth_assignment.user_id = id')
                                ->andFilterWhere(['auth_assignment.item_name' => 'Surveyor'])
                                ->andFilterWhere(['users.roId'=> $bouser->id])->all();

                if($surveyorUsersAdmin){
                    foreach ($surveyorUsersAdmin as $key => $value) {
                        // $surveyorUsers_list[] = $value->id;
                        if(is_array($surveyorUsers_list1)){
                            array_push($surveyorUsers_list1,$value->id);
                            // return gettype($bexeUsers_list);
                        }
                        // array_push($surveyorUsers_list,$value->id);
                    }
                }
                if(is_array($surveyorUsers_list1)){
                    $surveyorUsers_list1 = ($surveyorUsers_list1) ? implode(', ', $surveyorUsers_list1) : '';
                }

                //Get All Bo User's/Ro User's user id. 
                $boUsersAdmin = User::find()->select('id')->join('LEFT JOIN','auth_assignment','auth_assignment.user_id = id')
                            ->andFilterWhere(['auth_assignment.item_name' => 'BO User'])
                            ->andFilterWhere(['!=', 'users.id', $bouser->id])->all();

                if($boUsersAdmin){
                    foreach ($boUsersAdmin as $key => $value) {
                        // $boUsers_list[] = $value->id;
                        if(is_array($boUsers_list1)){
                            array_push($boUsers_list1,$value->id);
                            // return gettype($bexeUsers_list);
                        }
                        // array_push($boUsers_list,$value->id);
                    }
                }
                if(is_array($boUsers_list1)){
                    $boUsers_list1 = ($boUsers_list1) ? implode(', ', $boUsers_list1) : '';
                }

                if($bexeUsers_list1 && !empty($bexeUsers_list1)){
                    if($surveyorUsers_list1 && !empty($surveyorUsers_list1)){
                        // return json_encode($data);
                        $data->where(['and', 'status IS NOT NULL AND userId NOT IN ('.$boUsers_list1.') AND auth_assignment.item_name = "BO User"', ['or', 'userId = '.$bouser->id, 'callerName IN ('.$bexeUsers_list1.')', 'surveyorName IN ('.$surveyorUsers_list1.')']]);
                    }else{
                        $data->where(['and', 'status IS NOT NULL AND userId NOT IN ('.$boUsers_list1.') AND auth_assignment.item_name = "BO User"', ['or', 'userId = '.$bouser->id, 'callerName IN ('.$bexeUsers_list1.')']]);
                    }                
                }else{
                    if($surveyorUsers_list && !empty($surveyorUsers_list)){
                        $data->where(['and', 'status IS NOT NULL AND userId NOT IN ('.$boUsers_list1.') AND auth_assignment.item_name = "BO User"', ['or', 'userId = '.$bouser->id, 'surveyorName IN ('.$surveyorUsers_list1.')']]);
                    }else{
                        $data->where(['and', 'status IS NOT NULL AND userId NOT IN ('.$boUsers_list1.') AND auth_assignment.item_name = "BO User"', ['or', 'userId = '.$bouser->id]]);
                    }      
                }
                $data1 = $data->
                // andFilterWhere(['>=', 'axion_preinspection.completedSurveyDateTime', $year."-".$lastMonth."-".$startDate." ".$dayStart])
                // ->
                groupBy(['MONTH(NOW())'])
                ->asArray()
                ->all();
                array_push($resultArray,$data1);
            }
        }
        // return $data->createCommand()->getRawSql();
        // return 'Under Processing....';
        // return print_r($resultArray);
        return $this->renderAjax('target-report-case', [
            'data' => $resultArray,
            'title' => "Cancelled"
        ]);
    }

    public function actionLoadDashboard(){
        if(isset($_POST['name'])){            
            Yii::$app->session->set('dashboard',$_POST['name']);
        }
        return $this->redirect(['/']);
    }

    public function actionPdfMerge(){
        
        $pdf_files = array(getcwd().'/api-uploads/pdf/50983.pdf', getcwd().'/api-uploads/pdf/50928.pdf', getcwd().'/api-uploads/pdf/50958.pdf'); // Replace with the names of your PDF files

        $output_folder = getcwd().'/api-uploads/pdf/'; // Replace with the path to the folder where you want to store the output file
        $output_file = $output_folder . 'combined.pdf'; // Replace with the name of the output PDF file

        $filecmd = '';
        foreach ($pdf_files as $file) {
            $filecmd .= $file . ' ';
        }

        // $command = "gs -dBATCH -dNOPAUSE -q -sDEVICE=pdfwrite -sOutputFile=".getcwd().'/api-uploads/pdf/merged.pdf '.getcwd().'/api-uploads/pdf/26265.pdf '.getcwd().'/api-uploads/pdf/50807.pdf' .getcwd().'/api-uploads/pdf/50928.pdf';

        $command = "gs -dBATCH -dNOPAUSE -q -sDEVICE=pdfwrite -sOutputFile=".$output_file.' '.$filecmd;

        exec($command);
    }

      //// Ro& company wise report 
      public function actionAutoLoadCroTable($month = null, $year = null)
      {
  
          $userState = Yii::$app->user->identity->stateId;
          // Default date range for last month
          $startDate = date('Y-m-01 00:00:00', strtotime('first day of last month'));
          $endDate = date('Y-m-d 23:59:59', strtotime('last day of last month'));
          // Update date range if month and year are provided
          if ($month && $year) {
              $startDate = date('Y-m-01', strtotime("$year-$month-01"));
              $endDate = date('Y-m-t', strtotime("$year-$month-01"));
          }
          $companyIds = AxionPreinspection::find()
              ->select(['GROUP_CONCAT(DISTINCT insurerName ORDER BY insurerName ASC)'])
              ->createCommand()
              ->queryScalar();
  
          $companies = PreinspectionClientCompany::find()
              ->select(['id', 'companyName'])
              ->where(['id' => explode(',', $companyIds)])
              ->all();
  
          $ros = User::find()
              ->join('LEFT JOIN', 'auth_assignment', 'auth_assignment.user_id = id')
              ->andFilterWhere(['auth_assignment.item_name' => 'BO User'])
              ->select(['id', 'firstName'])
              ->all();
  
          // Initialize an empty array to store the results
          $completedClaims = [];
          foreach ($ros as $ro) {
              foreach ($companies as $company) {
                  $query = (new \yii\db\Query())
                      ->from('axion_preinspection')
                      ->where([
                          'InsurerName' => $company->id,
                          'userId' => $ro->id,
                      ])
                      ->andWhere(['status' => [101, 102, 103, 104, '9']])
                      ->andWhere(['between', 'completedSurveyDateTime', $startDate, $endDate]);
  
                  $completedClaims[$ro->id][$company->id] = $query->count();
              }
          }
  
          return $this->render('auto-load-company-wise', [
              'title' => "Company Wise/Ro WISE Report",
              'companies' => $companies,
              'completedClaims' => $completedClaims,
              'ros' => $ros,
          ]);
      }
}
