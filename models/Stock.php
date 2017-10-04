<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "stock".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $product_id
 * @property integer $product_category_id
 * @property integer $location_id
 * @property integer $last_vendor_id
 * @property integer $quantity
 * @property integer $active
 * @property string $time
 * @property string $remarks
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Vendor $lastVendor
 * @property Location $location
 * @property ProductCategory $productCategory
 * @property Product $product
 * @property User $user
 */
class Stock extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'stock';
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
            [['location_id', 'quantity', 'quantity'], 'required'],
            [['user_id', 'product_id', 'product_category_id', 'location_id', 'last_vendor_id', 'quantity', 'active', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['time', 'product_id', 'product_category_id', 'last_vendor_id'], 'safe'],
            [['remarks'], 'string', 'max' => 255],
            [['quantity'], 'default', 'value' => 0],
            [['user_id', 'product_category_id', 'location_id', 'last_vendor_id'], 'default', 'value' => 1],
            [['last_vendor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Vendor::className(), 'targetAttribute' => ['last_vendor_id' => 'id']],
            [['location_id'], 'exist', 'skipOnError' => true, 'targetClass' => Location::className(), 'targetAttribute' => ['location_id' => 'id']],
            [['product_category_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProductCategory::className(), 'targetAttribute' => ['product_category_id' => 'id']],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['product_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['last_vendor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Vendor::className(), 'targetAttribute' => ['last_vendor_id' => 'id']],
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
            'product_id' => Yii::t('app', 'Product'),
            'product_category_id' => Yii::t('app', 'Product Category'),
            'location_id' => Yii::t('app', 'Location'),
            'last_vendor_id' => Yii::t('app', 'Last Vendor'),
            'quantity' => Yii::t('app', 'Quantity'),
            'active' => Yii::t('app', 'Active'),
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
    public function getLastVendor()
    {
        return $this->hasOne(Vendor::className(), ['id' => 'last_vendor_id']);
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
    public function getProductCategory()
    {
        return $this->hasOne(ProductCategory::className(), ['id' => 'product_category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVendor()
    {
        return $this->hasOne(Vendor::className(), ['id' => 'last_vendor_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * Copied from Model class, validateMultiple function.
     * This method will validate every model of a Payment.
     * If the Payment model is NOT voided then it will validate the
     * multiple models of the Loads.
     * @param array $modelsPayment the Payment models to be validated
     * @param array $modelsPaymentLoads PaymentLoads models to be validated.
     *
     * @return boolean whether all models are valid. False will be returned if one
     * or multiple models have validation error.
     */
    public static function validateProduct($modelsStock)
    {
        $valid = true;
        foreach ($modelsStock as $i => $modelsStock) {
            $valid = $modelsStock->validate() && $valid;
        }

        return $valid;
    }
}
