<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "product".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $item_name
 * @property string $item_code
 * @property string $item_description
 * @property integer $product_type_id
 * @property integer $product_category_id
 * @property string $barcode
 * @property integer $reorder_point
 * @property integer $reorder_quantity
 * @property integer $default_location_id
 * @property integer $last_vendor_id
 * @property integer $standard_uom_id
 * @property integer $sales_uom_id
 * @property integer $purchasing_uom_id
 * @property integer $length
 * @property integer $width
 * @property integer $height
 * @property integer $weight
 * @property string $cost
 * @property string $normal_price
 * @property string $retail_price
 * @property string $wholesale_price
 * @property integer $active
 * @property string $time
 * @property string $remarks
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property PoLines[] $poLines
 * @property Location $defaultLocation
 * @property Vendor $lastVendor
 * @property ProductCategory $productCategory
 * @property ProductType $productType
 * @property Uom $purchasingUom
 * @property Uom $salesUom
 * @property Uom $standardUom
 * @property User $user
 */
class Product extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product';
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
            [['item_name', 'item_code', 'product_type_id'], 'required'],
            [['user_id', 'product_type_id', 'product_category_id', 'reorder_point', 'reorder_quantity', 'default_location_id', 'last_vendor_id', 'standard_uom_id', 'sales_uom_id', 'purchasing_uom_id', 'length', 'width', 'height', 'weight', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['cost', 'normal_price', 'retail_price', 'wholesale_price'], 'number'],
            [['cost', 'normal_price', 'retail_price', 'wholesale_price'], 'default', 'value' => 0],
            [
                'item_name', 'unique', 
                'targetAttribute' => ['item_name','item_code'],
                'message' => 'Item name must be unique.'
            ],
            ['active', 'default', 'value' => true],
            [['time','product_category_id', 'reorder_point', 'reorder_quantity', 'default_location_id', 'last_vendor_id', 'standard_uom_id', 'sales_uom_id', 'purchasing_uom_id', 'cost', 'normal_price', 'retail_price', 'wholesale_price', 'active'], 'safe'],
            [['item_name', 'item_code', 'barcode', 'remarks', 'item_description'], 'string', 'max' => 255],
            [['default_location_id'], 'exist', 'skipOnError' => true, 'targetClass' => Location::className(), 'targetAttribute' => ['default_location_id' => 'id']],
            [['last_vendor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Vendor::className(), 'targetAttribute' => ['last_vendor_id' => 'id']],
            [['product_category_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProductCategory::className(), 'targetAttribute' => ['product_category_id' => 'id']],
            [['product_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProductType::className(), 'targetAttribute' => ['product_type_id' => 'id']],
            [['purchasing_uom_id'], 'exist', 'skipOnError' => true, 'targetClass' => Uom::className(), 'targetAttribute' => ['purchasing_uom_id' => 'id']],
            [['sales_uom_id'], 'exist', 'skipOnError' => true, 'targetClass' => Uom::className(), 'targetAttribute' => ['sales_uom_id' => 'id']],
            [['standard_uom_id'], 'exist', 'skipOnError' => true, 'targetClass' => Uom::className(), 'targetAttribute' => ['standard_uom_id' => 'id']],
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
            'item_name' => Yii::t('app', 'Item Name'),
            'item_code' => Yii::t('app', 'Item Code'),
            'item_description' => Yii::t('app', 'Item Description'),
            'product_type_id' => Yii::t('app', 'Product Type'),
            'product_category_id' => Yii::t('app', 'Product Category'),
            'barcode' => Yii::t('app', 'Barcode'),
            'reorder_point' => Yii::t('app', 'Reorder Point'),
            'reorder_quantity' => Yii::t('app', 'Reorder Quantity'),
            'default_location_id' => Yii::t('app', 'Default Location'),
            'last_vendor_id' => Yii::t('app', 'Last Vendor'),
            'standard_uom_id' => Yii::t('app', 'Standard Uom'),
            'sales_uom_id' => Yii::t('app', 'Sales Uom'),
            'purchasing_uom_id' => Yii::t('app', 'Purchasing Uom'),
            'length' => Yii::t('app', 'Length'),
            'width' => Yii::t('app', 'Width'),
            'height' => Yii::t('app', 'Height'),
            'weight' => Yii::t('app', 'Weight'),
            'cost' => Yii::t('app', 'Cost'),
            'normal_price' => Yii::t('app', 'Normal Price'),
            'retail_price' => Yii::t('app', 'Retail Price'),
            'wholesale_price' => Yii::t('app', 'Wholesale Price'),
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
    public function getPoLines()
    {
        return $this->hasMany(PoLines::className(), ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStocks()
    {
        return $this->hasMany(Stock::className(), ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDefaultLocation()
    {
        return $this->hasOne(Location::className(), ['id' => 'default_location_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLastVendor()
    {
        return $this->hasOne(Vendor::className(), ['id' => 'last_vendor_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductCategory()
    {
        return $this->hasOne(ProductCategory::className(), ['id' => 'product_category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductType()
    {
        return $this->hasOne(ProductType::className(), ['id' => 'product_type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPurchasingUom()
    {
        return $this->hasOne(Uom::className(), ['id' => 'purchasing_uom_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSalesUom()
    {
        return $this->hasOne(Uom::className(), ['id' => 'sales_uom_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStandardUom()
    {
        return $this->hasOne(Uom::className(), ['id' => 'standard_uom_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
