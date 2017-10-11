<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "production".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $name
 * @property string $start_weight
 * @property string $end_weight
 * @property integer $quantity_produced
 * @property integer $quantity_wasted
 * @property string $actual_prod_date
 * @property string $completed_date
 * @property string $status
 * @property integer $active
 * @property string $time
 * @property string $remarks
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property User $user
 */
class Production extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'production';
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
            [['name', 'end_weight', 'start_weight', 'quantity_produced', 'quantity_wasted', 'actual_prod_date'], 'required'],
            [['user_id', 'quantity_produced', 'quantity_wasted', 'active', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['start_weight', 'end_weight'], 'number', 'min' => 1],
            [['quantity_produced', 'quantity_wasted'], 'integer', 'min' => 1],
            [['quantity_produced', 'quantity_wasted'], 'default', 'value' => 0],
            [['actual_prod_date', 'completed_date', 'time'], 'safe'],
            [['name', 'start_weight', 'end_weight', 'status', 'remarks'], 'string', 'max' => 255],
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
            'start_weight' => Yii::t('app', 'Start Weight'),
            'end_weight' => Yii::t('app', 'End Weight'),
            'quantity_produced' => Yii::t('app', 'Bags Produced'),
            'quantity_wasted' => Yii::t('app', 'Bags Wasted'),
            'actual_prod_date' => Yii::t('app', 'Actual Prod Date'),
            'completed_date' => Yii::t('app', 'Completed Date'),
            'status' => Yii::t('app', 'Status'),
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
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
