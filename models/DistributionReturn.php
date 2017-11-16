<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "distribution_return".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $number
 * @property integer $location_id
 * @property integer $product_id
 * @property integer $quantity
 * @property string $price
 * @property integer $driver_id
 * @property integer $status
 * @property string $date
 * @property string $time
 * @property integer $reason
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Driver $driver
 * @property Location $location
 * @property User $user
 */
class DistributionReturn extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'distribution_return';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'location_id', 'product_id', 'quantity', 'driver_id', 'status', 'reason', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['number', 'product_id', 'quantity', 'price', 'date', 'time', 'reason', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'required'],
            [['price'], 'number'],
            [['time'], 'safe'],
            [['number', 'date'], 'string', 'max' => 255],
            [['driver_id'], 'exist', 'skipOnError' => true, 'targetClass' => Driver::className(), 'targetAttribute' => ['driver_id' => 'id']],
            [['location_id'], 'exist', 'skipOnError' => true, 'targetClass' => Location::className(), 'targetAttribute' => ['location_id' => 'id']],
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
            'location_id' => Yii::t('app', 'Location ID'),
            'product_id' => Yii::t('app', 'Product ID'),
            'quantity' => Yii::t('app', 'Quantity'),
            'price' => Yii::t('app', 'Price'),
            'driver_id' => Yii::t('app', 'Driver ID'),
            'status' => Yii::t('app', 'Status'),
            'date' => Yii::t('app', 'Date'),
            'time' => Yii::t('app', 'Time'),
            'reason' => Yii::t('app', 'Reason'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDriver()
    {
        return $this->hasOne(Driver::className(), ['id' => 'driver_id']);
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
}
