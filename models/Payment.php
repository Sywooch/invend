<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "payment".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $agreement_id
 * @property string $amount_paid
 * @property string $amount_changed
 * @property string $receipt_number
 * @property string $type
 * @property string $mode
 * @property string $bank_name
 * @property string $cheque_number
 * @property string $payee_name
 * @property string $payee_mobile_number
 * @property string $payee_email
 * @property string $payee_address
 * @property string $date
 * @property string $time
 * @property string $notes
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Agreement $agreement
 * @property User $user
 */
class Payment extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'payment';
    }

    public function behaviors()
    {
        return [
            [
                'class' => \yii\behaviors\BlameableBehavior::className(),
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
            ],
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
                'value' => function() { return date('U'); },
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'agreement_id', 'amount_paid', 'receipt_number', 'type', 'mode', 'payee_name', 'payee_mobile_number', 'date'], 'required'],
            [['user_id', 'agreement_id', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['amount_paid', 'amount_changed', 'payee_mobile_number'], 'number'],
            [['payee_mobile_number'], 'string', 'min' => 10, 'max' => 10],
            [['bank_name', 'cheque_number'], 'required', 'when' => function ($model) { return $model->mode == 'Cheque';}, 
            'whenClient' => "function (attribute, value) {
                return $('#payment-mode').val() == 'Cheque';
            }" ],
            [['cheque_number', 'receipt_number'], 'unique'],
            [['date', 'time'], 'safe'],
            [['payee_email'], 'email'],
            [['receipt_number', 'type', 'mode', 'bank_name', 'cheque_number', 'payee_name', 'payee_mobile_number', 'payee_email', 'payee_address', 'notes'], 'string', 'max' => 255],
            [['agreement_id'], 'exist', 'skipOnError' => true, 'targetClass' => Agreement::className(), 'targetAttribute' => ['agreement_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'agreement_id' => Yii::t('app', 'Agreement'),
            'amount_paid' => Yii::t('app', ''),
            'amount_changed' => Yii::t('app', 'Amount Changed'),
            'receipt_number' => Yii::t('app', 'Receipt Number'),
            'type' => Yii::t('app', 'Type'),
            'mode' => Yii::t('app', 'Mode'),
            'bank_name' => Yii::t('app', 'Bank Name'),
            'cheque_number' => Yii::t('app', 'Cheque Number'),
            'payee_name' => Yii::t('app', 'Payee Name'),
            'payee_mobile_number' => Yii::t('app', 'Payee Mobile Number'),
            'payee_email' => Yii::t('app', 'Payee Email'),
            'payee_address' => Yii::t('app', 'Payee Address'),
            'date' => Yii::t('app', 'Date'),
            'time' => Yii::t('app', 'Time'),
            'notes' => Yii::t('app', 'Notes'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAgreement()
    {
        return $this->hasOne(Agreement::className(), ['id' => 'agreement_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
