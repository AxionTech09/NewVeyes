<?php

namespace app\models;

use Yii;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\base\Security;
use yii\web\IdentityInterface;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "logs".
 *
 * @property integer $id
 * @property integer $leadNumber
 * @property string $message
 * @property string $createdOn
 */
class Remarks extends \yii\db\ActiveRecord
{
    
    public static function tableName()
    {
        return 'remarks';
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['createdOn'], 'safe'],
            [['id','billId'], 'integer'],
            [['remarks'], 'string'],     
            [['remarks'], 'required']            
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'billId' => 'Bill Number',
            'remarks' => 'Remarks',
            'createdOn' => 'Updated On'
        ];
    }
    

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    public function searchRemarks($id,$params=false)
    {
        $query = Remarks::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['id' => SORT_DESC]],
        ]);
        $this->load($params);
        
        $query->where(["billId"=>$id]);

        if ($params && !$this->validate()) {
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([    
            'id' => $this->id,
            'createdOn' => $this->createdOn,
            'billId' => $this->billId,            
        ]);    


        //echo $query->createCommand()->getRawSql();
        return $dataProvider;
    }


    public function getBill()
    {
        return $this->hasOne(AxionPreinspectionBilling::className(), ['id' => 'billId']);
    }

}