<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "uom".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $name
 * @property integer $active
 * @property string $remarks
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property BomComponents[] $bomComponents
 * @property BomOutputs[] $bomOutputs
 * @property Product[] $products
 * @property Product[] $products0
 * @property Product[] $products1
 * @property User $user
 * @property WoComponents[] $woComponents
 */
class Uom extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'uom';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'required'],
            [['user_id', 'active', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['name', 'remarks'], 'string', 'max' => 255],
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
    public function getBomComponents()
    {
        return $this->hasMany(BomComponents::className(), ['uom_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBomOutputs()
    {
        return $this->hasMany(BomOutputs::className(), ['uom_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::className(), ['purchasing_uom_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts0()
    {
        return $this->hasMany(Product::className(), ['sales_uom_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts1()
    {
        return $this->hasMany(Product::className(), ['standard_uom_id' => 'id']);
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
    public function getWoComponents()
    {
        return $this->hasMany(WoComponents::className(), ['uom_id' => 'id']);
    }
}
