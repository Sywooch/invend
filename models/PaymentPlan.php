<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "payment_plan".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $agreement_id
 * @property string $amount_paid
 * @property string $amount_due
 * @property string $amount_in_arrears
 * @property string $goodwill_in_arrears
 * @property string $rent_in_arrears
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
class PaymentPlan extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'payment_plan';
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
            [['user_id', 'amount_due', 'currency'], 'required'],
            [['user_id', 'agreement_id', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['amount_paid', 'amount_due', 'amount_in_arrears', 'goodwill_in_arrears', 'rent_in_arrears'], 'number'],
            [['time'], 'safe'],
            [['notes'], 'string', 'max' => 255],
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
            'currency' => Yii::t('app', 'Currency'),
            'agreement_id' => Yii::t('app', 'Agreement'),
            'amount_paid' => Yii::t('app', 'Amount Paid'),
            'amount_due' => Yii::t('app', 'Amount Due'),
            'running_total' => Yii::t('app', 'Running Total'),
            'amount_in_arrears' => Yii::t('app', 'Amount In Arrears'),
            'goodwill_in_arrears' => Yii::t('app', 'Goodwill In Arrears'),
            'rent_in_arrears' => Yii::t('app', 'Rent In Arrears'),
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
