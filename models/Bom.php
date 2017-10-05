<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "bom".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $name
 * @property string $number
 * @property string $description
 * @property integer $production_area_id
 * @property integer $max_prod_capability
 * @property integer $active
 * @property string $time
 * @property string $remarks
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property ProductionArea $productionArea
 * @property User $user
 * @property BomOutputs[] $bomOutputs
 * @property Wo[] $wos
 * @property WoOutputs[] $woOutputs
 */
class Bom extends ActiveRecord
{
    public $count = 1;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'bom';
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
            [['user_id', 'production_area_id', 'max_prod_capability', 'active', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['max_prod_capability'], 'default', 'value' => 0],
            [['time', 'number'], 'safe'],
            [['name', 'number', 'description', 'remarks'], 'string', 'max' => 255],
            [['production_area_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProductionArea::className(), 'targetAttribute' => ['production_area_id' => 'id']],
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
            'name' => Yii::t('app', 'Name'),
            'number' => Yii::t('app', 'Bom #'),
            'description' => Yii::t('app', 'Description'),
            'production_area_id' => Yii::t('app', 'Production Area'),
            'max_prod_capability' => Yii::t('app', 'Max Prod Capability'),
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
    public function getProductionArea()
    {
        return $this->hasOne(ProductionArea::className(), ['id' => 'production_area_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBomOutputs()
    {
        return $this->hasMany(BomOutputs::className(), ['bom_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBomStages()
    {
        return $this->hasMany(BomStages::className(), ['bom_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWos()
    {
        return $this->hasMany(Wo::className(), ['bom_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWoOutputs()
    {
        return $this->hasMany(WoOutputs::className(), ['bom_id' => 'id']);
    }
}
