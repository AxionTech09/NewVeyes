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
class HoRemarks extends \yii\db\ActiveRecord
{
    
    public static function tableName()
    {
        return 'ho_remarks';
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['createdOn'], 'safe'],
            [['id','hoBillId'], 'integer'],
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
            'hoBillId' => 'Bill Number',
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
        $query = HoRemarks::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['id' => SORT_DESC]],
        ]);
        $this->load($params);
        
        $query->where(["hoBillId"=>$id]);

        if ($params && !$this->validate()) {
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([    
            'id' => $this->id,
            'createdOn' => $this->createdOn,
            'hoBillId' => $this->billId,            
        ]);    


        //echo $query->createCommand()->getRawSql();
        return $dataProvider;
    }


    public function getHoBill()
    {
        return $this->hasOne(AxionPreinspectionHoBilling::className(), ['id' => 'hoBillId']);
    }

}