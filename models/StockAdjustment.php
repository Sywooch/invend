<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "stock_adjustment".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $number
 * @property integer $product_id
 * @property integer $location_id
 * @property integer $new_quantity
 * @property integer $old_quantity
 * @property integer $difference
 * @property string $date
 * @property integer $active
 * @property string $time
 * @property string $status
 * @property string $remarks
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Location $location
 * @property Product $product
 * @property User $user
 */
class StockAdjustment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'stock_adjustment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'number', 'product_id', 'location_id', 'new_quantity', 'old_quantity', 'difference', 'date', 'time', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'required'],
            [['user_id', 'product_id', 'location_id', 'new_quantity', 'old_quantity', 'difference', 'active', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['date', 'time'], 'safe'],
            [['number', 'status', 'remarks'], 'string', 'max' => 255],
            [['location_id'], 'exist', 'skipOnError' => true, 'targetClass' => Location::className(), 'targetAttribute' => ['location_id' => 'id']],
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
            'user_id' => Yii::t('app', 'User ID'),
            'number' => Yii::t('app', 'Number'),
            'product_id' => Yii::t('app', 'Product ID'),
            'location_id' => Yii::t('app', 'Location ID'),
            'new_quantity' => Yii::t('app', 'New Quantity'),
            'old_quantity' => Yii::t('app', 'Old Quantity'),
            'difference' => Yii::t('app', 'Difference'),
            'date' => Yii::t('app', 'Date'),
            'active' => Yii::t('app', 'Active'),
            'time' => Yii::t('app', 'Time'),
            'status' => Yii::t('app', 'Status'),
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
    public function getLocation()
    {
        return $this->hasOne(Location::className(), ['id' => 'location_id']);
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
}
