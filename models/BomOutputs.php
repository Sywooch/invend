<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "bom_outputs".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $bom_id
 * @property integer $product_id
 * @property string $number
 * @property string $quantity_type
 * @property integer $quantity
 * @property string $last_cost
 * @property string $cost
 * @property string $cost_percentage
 * @property integer $uom_id
 * @property integer $primary
 * @property integer $active
 * @property string $time
 * @property string $remarks
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Bom $bom
 * @property Uom $uom
 * @property Product $product
 * @property User $user
 */
class BomOutputs extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'bom_outputs';
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
            [['product_id', 'number', 'quantity_type', 'quantity', 'last_cost', 'cost', 'cost_percentage'], 'required'],
            [['user_id', 'product_id', 'bom_id', 'quantity', 'uom_id', 'primary', 'active', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['last_cost', 'cost', 'cost_percentage'], 'number'],
            [['cost_percentage'], 'string', 'min' => 0, 'max' => 6],
            [['time'], 'safe'],
            [['number', 'quantity_type', 'remarks'], 'string', 'max' => 255],
            [['bom_id'], 'exist', 'skipOnError' => true, 'targetClass' => Bom::className(), 'targetAttribute' => ['bom_id' => 'id']],
            [['uom_id'], 'exist', 'skipOnError' => true, 'targetClass' => Uom::className(), 'targetAttribute' => ['uom_id' => 'id']],
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
            'bom_id' => Yii::t('app', 'Bom'),
            'product_id' => Yii::t('app', 'Product'),
            'number' => Yii::t('app', 'Number'),
            'quantity_type' => Yii::t('app', 'Quantity Type'),
            'quantity' => Yii::t('app', 'Quantity'),
            'last_cost' => Yii::t('app', 'Last Cost'),
            'cost' => Yii::t('app', 'Cost'),
            'cost_percentage' => Yii::t('app', 'Cost Percentage'),
            'uom_id' => Yii::t('app', 'Uom'),
            'primary' => Yii::t('app', 'Primary'),
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
    public function getBom()
    {
        return $this->hasOne(Bom::className(), ['id' => 'bom_id']);
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
    public function getUom()
    {
        return $this->hasOne(Uom::className(), ['id' => 'uom_id']);
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
    public static function validateBom($modelsOutput)
    {
        $valid = true;
        foreach ($modelsOutput as $i => $modelOutput) {
            $valid = $modelOutput->validate() && $valid;
        }

        return $valid;
    }
}
