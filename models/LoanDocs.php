<?php
namespace app\models;

use yii\helpers\ArrayHelper;
use Yii;



/**
 * This is the model class for table "loan_docs".
 *
 * @property int $id
 * @property int $loanId
 * @property string $docType
 * @property string $docTitle
 * @property string $docName
 * @property string $docFile
 * @property string $createdOn
 * @property string $lastUpdatedOn
 */
class LoanDocs extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'loan_docs';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['loanId'], 'required'],
            [['loanId'], 'integer'],
            [['createdOn', 'lastUpdatedOn','docType', 'docTitle', 'docName', 'docFile', 'lastUpdatedOn'], 'safe'],
            [['docType', 'docTitle', 'docName'], 'string', 'max' => 100],
            [['docFile'], 'string', 'max' => 255],
           
        ];
    }



    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'loanId' => 'Loan ID',
            'docType' => 'Doc Type',
            'docTitle' => 'Doc Title',
            'docName' => 'Doc Name',
            'docFile' => 'Doc File',
            'createdOn' => 'Created On',
            'lastUpdatedOn' => 'Last Updated On',
        ];
    }
}



