<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "po_lines".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $po_id
 * @property integer $product_id
 * @property string $item_name
 * @property string $item_code
 * @property integer $quantity
 * @property string $unit_price
 * @property string $discount
 * @property string $sub_total
 * @property integer $active
 * @property string $time
 * @property string $remarks
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Po $po
 * @property Product $product
 * @property User $user
 */
class PoLines extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'po_lines';
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
            [['product_id', 'quantity', 'unit_price'], 'required'],
            [['user_id', 'po_id', 'product_id', 'quantity', 'active', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['unit_price', 'discount', 'sub_total'], 'number'],
            [['unit_price', 'discount', 'sub_total'], 'default', 'value' => 0],
            [['unit_price', 'discount', 'sub_total'], 'number', 'min' => 0],
            [['quantity'], 'integer', 'min' => 1],
            [['time', 'discount', 'sub_total', 'item_code'], 'safe'],
            [['item_name', 'item_code', 'remarks'], 'string', 'max' => 255],
            [['po_id'], 'exist', 'skipOnError' => true, 'targetClass' => Po::className(), 'targetAttribute' => ['po_id' => 'id']],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['product_id' => 'id']],
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
            'user_id' => Yii::t('app', 'User'),
            'po_id' => Yii::t('app', 'Po'),
            'product_id' => Yii::t('app', 'Product'),
            'item_name' => Yii::t('app', 'Item Name'),
            'item_code' => Yii::t('app', 'Item Code'),
            'quantity' => Yii::t('app', 'Quantity'),
            'unit_price' => Yii::t('app', 'Unit Price'),
            'discount' => Yii::t('app', 'Discount'),
            'sub_total' => Yii::t('app', 'Sub Total'),
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
    public function getPo()
    {
        return $this->hasOne(Po::className(), ['id' => 'po_id']);
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
    public static function validatePo($modelsPoLines)
    {
        $valid = true;
        foreach ($modelsPoLines as $i => $modelPoLine) {
            $valid = $modelPoLine->validate() && $valid;
        }

        return $valid;
    }
}
