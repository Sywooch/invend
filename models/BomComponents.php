<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "bom_components".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $bom_stages_id
 * @property integer $product_id
 * @property string $number
 * @property string $quantity_type
 * @property integer $quantity
 * @property string $last_cost
 * @property string $total_line_cost
 * @property integer $uom_id
 * @property integer $active
 * @property string $time
 * @property string $remarks
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property BomStages $bomStages
 * @property Uom $uom
 * @property Product $product
 * @property User $user
 */
class BomComponents extends ActiveRecord
{
    public $total_component;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'bom_components';
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
            [['product_id', 'number', 'quantity_type', 'quantity', 'last_cost', 'total_line_cost'], 'required'],
            [['user_id', 'product_id', 'bom_stages_id', 'quantity', 'uom_id', 'active', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['last_cost', 'total_line_cost'], 'number'],
            [['time'], 'safe'],
            [['number', 'quantity_type', 'remarks'], 'string', 'max' => 255],
            [['bom_stages_id'], 'exist', 'skipOnError' => true, 'targetClass' => BomStages::className(), 'targetAttribute' => ['bom_stages_id' => 'id']],
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
            'bom_stages_id' => Yii::t('app', 'Bom Stages'),
            'product_id' => Yii::t('app', 'Product'),
            'number' => Yii::t('app', 'Number'),
            'quantity_type' => Yii::t('app', 'Qty Type'),
            'quantity' => Yii::t('app', 'Qty'),
            'last_cost' => Yii::t('app', 'Last Cost'),
            'total_line_cost' => Yii::t('app', 'Total Line Cost'),
            'uom_id' => Yii::t('app', 'Uom'),
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
    public function getBomStages()
    {
        return $this->hasOne(BomStages::className(), ['id' => 'bom_stages_id']);
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
}
