<?php

namespace app\models;
use yii\helpers\ArrayHelper;

use Yii;

/**
 * This is the model class for table "axion_claimsurvey_photos".
 *
 * @property integer $id
 * @property integer $pre_id
 * @property string $amount
 * @property string $order_id
 * @property string $payment_id
 * @property string $signature
 * @property string $status
 */
class AxionPreinspectionPayments extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'axion_preinspection_payments';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // [['pre_id', 'amount', '', ''], 'required'],
            [['id', 'pre_id', 'amount', 'order_id', 'payment_id', 'signature', 'status', 'created_on'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pre_id' => 'Preinspection ID',
            'amount' => 'Amount',
            'order_id' => 'RazorpayOrderId',
            'signature' => 'Razorpay Signature',
            'payment_id' => 'Razorpay Payment Id',
            'status' => 'Status',
        ];
    }
}
