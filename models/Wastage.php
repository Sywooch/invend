<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "wastage".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $number
 * @property integer $location_id
 * @property integer $product_id
 * @property integer $quantity
 * @property string $price
 * @property integer $status
 * @property string $date
 * @property string $time
 * @property string $notes
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property User $user
 */
class Wastage extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'wastage';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'location_id', 'product_id', 'quantity', 'status', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['number', 'product_id', 'quantity', 'price', 'date', 'time', 'notes', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'required'],
            [['price'], 'number'],
            [['time'], 'safe'],
            [['number', 'date', 'notes'], 'string', 'max' => 255],
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
            'status' => Yii::t('app', 'Status'),
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
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
