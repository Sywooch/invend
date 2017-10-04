<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "po_documents".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $po_id
 * @property string $image_src_filename
 * @property string $image_web_filename
 * @property string $time
 * @property string $notes
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Po $po
 * @property User $user
 */
class PoDocuments extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'po_documents';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'po_id', 'image_src_filename', 'image_web_filename', 'time', 'notes', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'required'],
            [['user_id', 'po_id', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['time'], 'safe'],
            [['image_src_filename', 'image_web_filename', 'notes'], 'string', 'max' => 255],
            [['po_id'], 'exist', 'skipOnError' => true, 'targetClass' => Po::className(), 'targetAttribute' => ['po_id' => 'id']],
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
            'po_id' => Yii::t('app', 'Po ID'),
            'image_src_filename' => Yii::t('app', 'Image Src Filename'),
            'image_web_filename' => Yii::t('app', 'Image Web Filename'),
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
    public function getPo()
    {
        return $this->hasOne(Po::className(), ['id' => 'po_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
