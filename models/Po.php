<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "po".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $number
 * @property integer $location_id
 * @property string $total
 * @property string $paid
 * @property integer $balance
 * @property integer $vendor_id
 * @property integer $currency_id
 * @property string $status
 * @property integer $cancel
 * @property string $cancel_date
 * @property string $cancel_reason
 * @property string $date
 * @property string $due_date
 * @property string $time
 * @property string $remarks
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Currency $currency
 * @property Location $location
 * @property User $user
 * @property Vendor $vendor
 * @property PoDocuments[] $poDocuments
 * @property PoLines[] $poLines
 */
class Po extends ActiveRecord
{
    public $count = 1;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'po';
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
            [['vendor_id'], 'required'],
            [['user_id', 'location_id', 'vendor_id', 'currency_id', 'cancel', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['total', 'status', 'balance'], 'number'],
            [['total', 'status', 'balance', 'paid'], 'default', 'value' => 0],
            [['location_id', 'user_id', 'location_id', 'currency_id'], 'default', 'value' => 1],
            [['total', 'paid'], 'number', 'min' => 0],
            [['cancel_date', 'cancel_reason', 'date', 'due_date', 'time', 'number', 'reason', 'item_name'], 'safe'],
            [['number', 'remarks'], 'string', 'max' => 255],
            [['currency_id'], 'exist', 'skipOnError' => true, 'targetClass' => Currency::className(), 'targetAttribute' => ['currency_id' => 'id']],
            [['location_id'], 'exist', 'skipOnError' => true, 'targetClass' => Location::className(), 'targetAttribute' => ['location_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['vendor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Vendor::className(), 'targetAttribute' => ['vendor_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User'),
            'number' => Yii::t('app', 'Order #'),
            'location_id' => Yii::t('app', 'Location'),
            'total' => Yii::t('app', 'Total'),
            'paid' => Yii::t('app', 'Paid'),
            'balance' => Yii::t('app', 'Balance'),
            'vendor_id' => Yii::t('app', 'Vendor'),
            'currency_id' => Yii::t('app', 'Currency'),
            'status' => Yii::t('app', 'Status'),
            'cancel' => Yii::t('app', 'Cancel'),
            'cancel_date' => Yii::t('app', 'Cancel Date'),
            'cancel_reason' => Yii::t('app', 'Cancel Reason'),
            'date' => Yii::t('app', 'Date'),
            'due_date' => Yii::t('app', 'Due Date'),
            'time' => Yii::t('app', 'Time'),
            'remarks' => Yii::t('app', 'Remarks'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCurrency()
    {
        return $this->hasOne(Currency::className(), ['id' => 'currency_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLocation()
    {
        return $this->hasOne(Location::className(), ['id' => 'location_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVendor()
    {
        return $this->hasOne(Vendor::className(), ['id' => 'vendor_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPoDocuments()
    {
        return $this->hasMany(PoDocuments::className(), ['po_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPoLines()
    {
        return $this->hasMany(PoLines::className(), ['po_id' => 'id']);
    }
}
