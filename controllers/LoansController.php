<?php

namespace app\controllers;



use Yii;
use app\models\Loans;
use app\models\LoansSearch;
use app\models\LoanDocs;
use app\models\LoanBanks;
use app\models\MasterBanks;
use app\models\User;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use yii\filters\VerbFilter;
use kartik\grid\GridView;
use kartik\file\FileInput;
use yii\helpers\Url;




/**
 * LoansController implements the CRUD actions for Loans model.
 */
class LoansController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }


    /**
     * Lists all Loans models.
     * @return mixed
     */
    public function actionIndex()
    {
        $role = array_keys(Yii::$app->authManager->getRolesByUser(Yii::$app->user->getId()))[0] ;
        $searchModel = new LoansSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'role' => $role,
        ]);
    }

    /**
     * Displays a single Loans model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->renderAjax('view', [
            'model' => $this->findModel($id),
        ]);
    }


 
    /**
     * Creates a new Loans model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $role = array_keys(Yii::$app->authManager->getRolesByUser(Yii::$app->user->getId()))[0] ;
        $model = new Loans();
        $ldmodel = new LoanDocs();
        // $bkmodel = new LoanBanks();
        $mbmodel = MasterBanks::find()->all();
        $cardealers = User::find()
                    ->join('LEFT JOIN','auth_assignment','auth_assignment.user_id = id')
                    ->andFilterWhere(['auth_assignment.item_name' => 'Car Dealers'])
                    ->andFilterWhere(['surveyorId' => Yii::$app->user->identity->id])
                    ->orderBy('firstName ASC')
                    ->all();
                   
                
                  
        $model->lastUpdatedOn = date('Y-m-d h:i:s');
        $model->userId = Yii::$app->user->identity->id;

        if ($model->load(Yii::$app->request->post()) ) 
         {
            if($role == 'Car Dealers'){
                $model->sourceType = 'associateDealers';
                $model->sourceId = $model->userId;
            }

            if($model->save())
            {

               foreach($mbmodel as $obj) 
                {
                    $bkmodel = new LoanBanks();
                    $bkmodel->bankId = $obj->id;
                    $bkmodel->loanId = $model->id;
                    $bkmodel->lastUpdatedOn = date('Y-m-d h:i:s');
                
                    $bkmodel->save();
                }

            $ldmodel = new LoanDocs(); 
            $ldmodel->loanId = $model->id;
            $ldmodel->docType = "addressProofFront";
            $ldmodel->docTitle = "Address Proof Front";
            $ldmodel->lastUpdatedOn = date('Y-m-d h:i:s');
            $ldmodel->save();
            
            $ldmodel = new LoanDocs(); 
            $ldmodel->loanId = $model->id;
            $ldmodel->docType = "addressProofBack";
            $ldmodel->docTitle = "Address Proof Back";
            $ldmodel->lastUpdatedOn = date('Y-m-d h:i:s');
            $ldmodel->save();

            $ldmodel = new LoanDocs(); 
            $ldmodel->loanId = $model->id;
            $ldmodel->docType = "idProofFront";
            $ldmodel->docTitle = "ID Proof Front";
            $ldmodel->lastUpdatedOn = date('Y-m-d h:i:s');
            $ldmodel->save();
            
             $ldmodel = new LoanDocs(); 
            $ldmodel->loanId = $model->id;
            $ldmodel->docType = "idProofBack";
            $ldmodel->docTitle = "ID Proof Back";
            $ldmodel->lastUpdatedOn = date('Y-m-d h:i:s');
            $ldmodel->save();


            $ldmodel = new LoanDocs(); 
            $ldmodel->loanId = $model->id;
            $ldmodel->docType = "bankStatement1";
            $ldmodel->docTitle = "Bank Statement1";
            $ldmodel->lastUpdatedOn = date('Y-m-d h:i:s');
            $ldmodel->save(); 

            $ldmodel = new LoanDocs(); 
            $ldmodel->loanId = $model->id;
            $ldmodel->docType = "bankStatement2";
            $ldmodel->docTitle = "Bank Statement 2";
            $ldmodel->lastUpdatedOn = date('Y-m-d h:i:s');
            $ldmodel->save();

            $ldmodel = new LoanDocs(); 
            $ldmodel->loanId = $model->id;
            $ldmodel->docType = "bankStatement3";
            $ldmodel->docTitle = "Bank Statement 3";
            $ldmodel->lastUpdatedOn = date('Y-m-d h:i:s');
            $ldmodel->save(); 

            $ldmodel = new LoanDocs(); 
            $ldmodel->loanId = $model->id;
            $ldmodel->docType = "vehicleInsuranceCopy";
            $ldmodel->docTitle = "Vehicle Insurance Copy";
            $ldmodel->lastUpdatedOn = date('Y-m-d h:i:s');
            $ldmodel->save(); 

            $ldmodel = new LoanDocs(); 
            $ldmodel->loanId = $model->id;
            $ldmodel->docType = "vehicleRCcopyFront";
            $ldmodel->docTitle = "Vehicle RC Copy Front";
            $ldmodel->lastUpdatedOn = date('Y-m-d h:i:s');
            $ldmodel->save();

            $ldmodel = new LoanDocs(); 
            $ldmodel->loanId = $model->id;
            $ldmodel->docType = "vehicleRCcopy Back";
            $ldmodel->docTitle = "Vehicle RC Copy Back";
            $ldmodel->lastUpdatedOn = date('Y-m-d h:i:s');
            $ldmodel->save();


            $ldmodel = new LoanDocs(); 
            $ldmodel->loanId = $model->id;
            $ldmodel->docType = "ITReturn1";
            $ldmodel->docTitle = "IT Return 1";
            $ldmodel->lastUpdatedOn = date('Y-m-d h:i:s');
            $ldmodel->save();
            
            $ldmodel = new LoanDocs(); 
            $ldmodel->loanId = $model->id;
            $ldmodel->docType = "ITReturn2";
            $ldmodel->docTitle = "IT Return 2";
            $ldmodel->lastUpdatedOn = date('Y-m-d h:i:s');
            $ldmodel->save();


            $ldmodel = new LoanDocs(); 
            $ldmodel->loanId = $model->id;
            $ldmodel->docType = "salarySlip1OrForm16A";
            $ldmodel->docTitle = "Salary Slip 1 or Form 16 A";
            $ldmodel->lastUpdatedOn = date('Y-m-d h:i:s');
            $ldmodel->save(); 
            
            $ldmodel = new LoanDocs(); 
            $ldmodel->loanId = $model->id;
            $ldmodel->docType = "salarySlip2";
            $ldmodel->docTitle = "Salary Slip 2";
            $ldmodel->lastUpdatedOn = date('Y-m-d h:i:s');
            $ldmodel->save();
            
            $ldmodel = new LoanDocs(); 
            $ldmodel->loanId = $model->id;
            $ldmodel->docType = "salarySlip3";
            $ldmodel->docTitle = "Salary Slip 3";
            $ldmodel->lastUpdatedOn = date('Y-m-d h:i:s');
            $ldmodel->save();

            $ldmodel = new LoanDocs(); 
            $ldmodel->loanId = $model->id;
            $ldmodel->docType = "loanFromOtherBanksLendersStatement";
            $ldmodel->docTitle = "Loan From Other Banks / Lenders / Last 1 Year Statement";
            $ldmodel->lastUpdatedOn = date('Y-m-d h:i:s');
            $ldmodel->save(); 
           

            $ldmodel = new LoanDocs(); 
            $ldmodel->loanId = $model->id;
            $ldmodel->docType = "photoCopy";
            $ldmodel->docTitle = "Photo Copy";
            $ldmodel->lastUpdatedOn = date('Y-m-d h:i:s');
            $ldmodel->save();

            $ldmodel = new LoanDocs(); 
            $ldmodel->loanId = $model->id;
            $ldmodel->docType = "tax";
            $ldmodel->docTitle = "Tax";
            $ldmodel->lastUpdatedOn = date('Y-m-d h:i:s');
            $ldmodel->save();
            
            $ldmodel = new LoanDocs(); 
            $ldmodel->loanId = $model->id;
            $ldmodel->docType = "permit";
            $ldmodel->docTitle = "Permit";
            $ldmodel->lastUpdatedOn = date('Y-m-d h:i:s');
            $ldmodel->save(); 


            $ldmodel = new LoanDocs(); 
            $ldmodel->loanId = $model->id;
            $ldmodel->docType = "batchLicense";
            $ldmodel->docTitle = "Batch License";
            $ldmodel->lastUpdatedOn = date('Y-m-d h:i:s');
            $ldmodel->save(); 
       
             $ldmodel = new LoanDocs(); 
            $ldmodel->loanId = $model->id;
            $ldmodel->docType = "ProofForResidential";
            $ldmodel->docTitle = "Proof for Residential";
            $ldmodel->lastUpdatedOn = date('Y-m-d h:i:s');
            $ldmodel->save();
            
            }
                
           return $this->redirect(['index',$model]);
                
         }   
          return $this->renderAjax('create', [
                        'model' => $model,
                        'ldmodel' => $ldmodel,
                        'mbmodel' => $mbmodel,
                        'cardealers' => $cardealers,
                        'role' => $role,
             
                    ]);
    }




    /**
     * Updates an existing Loans model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    

    public function actionUpdate($id)
    {
        $role = array_keys(Yii::$app->authManager->getRolesByUser(Yii::$app->user->getId()))[0] ;
        $model = $this->findModel($id);
        //$branch = MasterBanks::find()->where(['bankId' => $obj->bankId])->all();
        
      
        $ldmodel = LoanDocs::find()->where(['loanId' =>$id])->all();
        $bkmodel  = LoanBanks::find()->where(['loanId' =>$id])->all();
        $cardealers = User::find()
                    ->join('LEFT JOIN','auth_assignment','auth_assignment.user_id = id')
                    ->andFilterWhere(['auth_assignment.item_name' => 'Car Dealers'])
                    ->andFilterWhere(['surveyorId' => $model->userId])
                    ->orderBy('firstName ASC')
                    ->all();
       
                  

        if ($model->load(Yii::$app->request->post())) 
        {

        date_default_timezone_set('Asia/Calcutta');

        $model->lastUpdatedOn = date('Y-m-d h:i:s');
 
        $model->save();

//print_r(Yii::$app->request->post());                
//die('ok');
                 foreach($bkmodel as $obj) 
                {

                     if($obj->load(Yii::$app->request->post()))
                    { 
                        $smodel = LoanBanks::findOne($obj->id);
                        $smodel->selected = $obj->selected[$obj->id];
                        $smodel->bankBranch = $obj->bankBranch[$obj->id];
                        // print_r($smodel->bankBranch);

                        $smodel->bankAmount = $obj->bankAmount[$obj->id];
                        $smodel->loanTenure = $obj->loanTenure[$obj->id];
                        $smodel->rateOfIntrest = $obj->rateOfIntrest[$obj->id];
                        $smodel->emi = $obj->emi[$obj->id];
                        $smodel->bankStatus = $obj->bankStatus[$obj->id];
                        $smodel->save();
                        // print_r($model->getErrors());
                        // echo $obj->bankBranch[$obj->id];
                        // die("test");
                    }
                
            }

         foreach($ldmodel as $obj)
            {
                
                if($obj->docFile)
                $lastFile = $obj->docFile;
                else $lastFile = '';
                
                if($obj->load(Yii::$app->request->post()))
                {
                    
                    $doc = UploadedFile::getInstance($obj, 'docFile['.$obj->docType.']');
                    
                    if($doc)
                    {
                        $obj->docFile = 'loansdoc/'.$id.'-'.$obj->docType.'-'.$doc->name;
                    
                        if($doc->saveAs($obj->docFile))
                        {
                            $obj->save();
                            if($lastFile != '')
                            {
                                $filename = getcwd().'/'.$lastFile;
                                unlink($filename);
                            }

                        }
                        else
                        {
                            $obj->docFile = $lastFile;
                        }
                    }

                }
                
            }
      
             return $this->redirect(['index',$model]);    
           
    
        }else {
            return $this->renderAjax('update', [
            'model' => $model,
            'ldmodel' => $ldmodel,
            'bkmodel' => $bkmodel,
            // 'branch' => $branch,
            'cardealers' => $cardealers,
            'role' => $role,
            // 'mbmodel' => $mbmodel,
        
              ]);
         }
    }

 // SELECT LoanBanks.bankId,MasterBanks.branch  FROM MasterBanks 
 //   INNER JOIN LoanBanks
 //     WHERE MasterBanks.id = LoanBanks.bankId;
    


    /**
     * Deletes an existing Loans model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Loans model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Loans the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Loans::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}



