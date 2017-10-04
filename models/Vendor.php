<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "vendor".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $balance
 * @property string $credit
 * @property string $number
 * @property string $name
 * @property integer $active
 * @property integer $tax
 * @property string $address
 * @property string $contact
 * @property string $phone
 * @property string $fax
 * @property string $email
 * @property string $website
 * @property string $payment_terms
 * @property string $discount
 * @property integer $currency_id
 * @property integer $taxing_scheme_id
 * @property string $time
 * @property string $remarks
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Po[] $pos
 * @property Product[] $products
 * @property Currency $currency
 * @property TaxingScheme $taxingScheme
 * @property User $user
 */
class Vendor extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vendor';
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
            [['name'], 'required'],
            [['user_id', 'active', 'tax', 'currency_id', 'payment_method_id', 'taxing_scheme_id', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['balance', 'credit', 'discount'], 'number'],
            [['active'], 'default', 'value' => true],
            [['balance', 'credit', 'discount'], 'default', 'value' => 0],
            [['payment_method_id', 'taxing_scheme_id'], 'default', 'value' => 1],
            [['time','balance', 'credit', 'number','address', 'contact', 'phone', 'fax', 'email', 'website', 'payment_terms', 'discount', 'currency_id', 'taxing_scheme_id', 'time', 'remarks'], 'safe'],
            [['number', 'name', 'address', 'contact', 'phone', 'fax', 'email', 'website', 'payment_terms', 'remarks'], 'string', 'max' => 255],
            [['currency_id'], 'exist', 'skipOnError' => true, 'targetClass' => Currency::className(), 'targetAttribute' => ['currency_id' => 'id']],
            [['taxing_scheme_id'], 'exist', 'skipOnError' => true, 'targetClass' => TaxingScheme::className(), 'targetAttribute' => ['taxing_scheme_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['payment_method_id'], 'exist', 'skipOnError' => true, 'targetClass' => PaymentMethod::className(), 'targetAttribute' => ['payment_method_id' => 'id']],
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
            'balance' => Yii::t('app', 'Balance'),
            'credit' => Yii::t('app', 'Credit'),
            'number' => Yii::t('app', 'Vendor #'),
            'name' => Yii::t('app', 'Name'),
            'active' => Yii::t('app', 'Active'),
            'tax' => Yii::t('app', 'Tax'),
            'address' => Yii::t('app', 'Address'),
            'contact' => Yii::t('app', 'Contact'),
            'phone' => Yii::t('app', 'Phone'),
            'fax' => Yii::t('app', 'Fax'),
            'email' => Yii::t('app', 'Email'),
            'website' => Yii::t('app', 'Website'),
            'payment_terms' => Yii::t('app', 'Payment Terms'),
            'discount' => Yii::t('app', 'Discount'),
            'currency_id' => Yii::t('app', 'Currency'),
            'taxing_scheme_id' => Yii::t('app', 'Taxing Scheme'),
            'payment_method_id' => Yii::t('app', 'Payment Method'),
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
    public function getPos()
    {
        return $this->hasMany(Po::className(), ['vendor_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::className(), ['last_vendor_id' => 'id']);
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
    public function getPaymentMethod()
    {
        return $this->hasOne(PaymentMethod::className(), ['id' => 'payment_method_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTaxingScheme()
    {
        return $this->hasOne(TaxingScheme::className(), ['id' => 'taxing_scheme_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
