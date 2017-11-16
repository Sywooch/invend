<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "driver".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $name
 * @property string $license_number
 * @property string $phone_number
 * @property string $code
 * @property boolean $active
 * @property string $employed_date
 * @property string $time
 * @property string $notes
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Distribution[] $distributions
 * @property DistributionReturn[] $distributionReturns
 * @property User $user
 */
class Driver extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'driver';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'name', 'license_number', 'phone_number', 'employed_date', 'time', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'required'],
            [['user_id', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['active'], 'boolean'],
            [['time'], 'safe'],
            [['name', 'license_number', 'phone_number', 'code', 'employed_date', 'notes'], 'string', 'max' => 255],
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
            'name' => Yii::t('app', 'Name'),
            'license_number' => Yii::t('app', 'License Number'),
            'phone_number' => Yii::t('app', 'Phone Number'),
            'code' => Yii::t('app', 'Code'),
            'active' => Yii::t('app', 'Active'),
            'employed_date' => Yii::t('app', 'Employed Date'),
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
    public function getDistributions()
    {
        return $this->hasMany(Distribution::className(), ['driver_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDistributionReturns()
    {
        return $this->hasMany(DistributionReturn::className(), ['driver_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
