<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "work_centre".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $production_line_id
 * @property string $name
 * @property string $code
 * @property integer $active
 * @property string $remarks
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property BomStages[] $bomStages
 * @property WoStages[] $woStages
 * @property ProductionLine $productionLine
 * @property User $user
 */
class WorkCentre extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'work_centre';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'production_line_id', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'required'],
            [['user_id', 'production_line_id', 'active', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['name', 'code', 'remarks'], 'string', 'max' => 255],
            [['production_line_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProductionLine::className(), 'targetAttribute' => ['production_line_id' => 'id']],
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
            'production_line_id' => Yii::t('app', 'Production Line ID'),
            'name' => Yii::t('app', 'Name'),
            'code' => Yii::t('app', 'Code'),
            'active' => Yii::t('app', 'Active'),
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
        return $this->hasMany(BomStages::className(), ['work_centre_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWoStages()
    {
        return $this->hasMany(WoStages::className(), ['work_centre_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductionLine()
    {
        return $this->hasOne(ProductionLine::className(), ['id' => 'production_line_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
