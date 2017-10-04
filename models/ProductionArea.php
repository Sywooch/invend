<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "production_area".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $name
 * @property string $code
 * @property integer $active
 * @property string $remarks
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Bom[] $boms
 * @property User $user
 * @property ProductionLine[] $productionLines
 * @property Wo[] $wos
 */
class ProductionArea extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'production_area';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'required'],
            [['user_id', 'active', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['name', 'code', 'remarks'], 'string', 'max' => 255],
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
    public function getBoms()
    {
        return $this->hasMany(Bom::className(), ['production_area_id' => 'id']);
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
    public function getProductionLines()
    {
        return $this->hasMany(ProductionLine::className(), ['production_area_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWos()
    {
        return $this->hasMany(Wo::className(), ['production_area_id' => 'id']);
    }
}
