<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\base\Model;

/**
 * This is the model class for table "bom_stages".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $bom_id
 * @property string $name
 * @property string $number
 * @property string $description
 * @property integer $work_centre_id
 * @property integer $required_capacity
 * @property string $total_input_cost
 * @property integer $active
 * @property string $time
 * @property string $remarks
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property BomComponents[] $bomComponents
 * @property BomInstructions[] $bomInstructions
 * @property Bom $bom
 * @property User $user
 * @property WorkCentre $workCentre
 * @property WoComponents[] $woComponents
 * @property WoInstructions[] $woInstructions
 */
class BomStages extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'bom_stages';
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
            [['name', 'total_input_cost'], 'required'],
            [['user_id', 'bom_id', 'work_centre_id', 'required_capacity', 'active', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['total_input_cost'], 'number'],
            [['time'], 'safe'],
            [['name', 'number', 'description', 'remarks'], 'string', 'max' => 255],
            [['bom_id'], 'exist', 'skipOnError' => true, 'targetClass' => Bom::className(), 'targetAttribute' => ['bom_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['work_centre_id'], 'exist', 'skipOnError' => true, 'targetClass' => WorkCentre::className(), 'targetAttribute' => ['work_centre_id' => 'id']],
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
            'bom_id' => Yii::t('app', 'Bom ID'),
            'name' => Yii::t('app', 'Name'),
            'number' => Yii::t('app', 'Number'),
            'description' => Yii::t('app', 'Description'),
            'work_centre_id' => Yii::t('app', 'Work Centre ID'),
            'required_capacity' => Yii::t('app', 'Required Capacity'),
            'total_input_cost' => Yii::t('app', 'Total Input Cost'),
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
    public function getBomComponents()
    {
        return $this->hasMany(BomComponents::className(), ['bom_stages_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBomInstructions()
    {
        return $this->hasMany(BomInstructions::className(), ['bom_stages_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBom()
    {
        return $this->hasOne(Bom::className(), ['id' => 'bom_id']);
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
    public function getWorkCentre()
    {
        return $this->hasOne(WorkCentre::className(), ['id' => 'work_centre_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWoComponents()
    {
        return $this->hasMany(WoComponents::className(), ['bom_stages_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWoInstructions()
    {
        return $this->hasMany(WoInstructions::className(), ['bom_stages_id' => 'id']);
    }

    /**
     * Copied from Model class, validateMultiple function.
     * This method will validate every model of a Payment.
     * If the Payment model is NOT voided then it will validate the
     * multiple models of the Loads.
     * @param array $modelsPayment the Payment models to be validated
     * @param array $modelsPaymentLoads PaymentLoads models to be validated.
     *
     * @return boolean whether all models are valid. False will be returned if one
     * or multiple models have validation error.
     */
    public static function validateBom($modelsStage, $modelsComponents)
    {
        $valid = true;

        foreach ($modelsStage as $i => $modelStage) {
            $valid = $modelStage->validate() && $valid;
            $valid = Model::validateMultiple($modelsComponents[$i]) && $valid;
        }

        return $valid;
    }
}
