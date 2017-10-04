<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Product;

/**
 * ProductSearch represents the model behind the search form about `app\models\Product`.
 */
class ProductSearch extends Product
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'product_type_id', 'product_category_id', 'reorder_point', 'reorder_quantity', 'default_location_id', 'last_vendor_id', 'standard_uom_id', 'sales_uom_id', 'purchasing_uom_id', 'length', 'width', 'height', 'weight', 'active', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['item_name', 'item_code', 'barcode', 'time', 'remarks'], 'safe'],
            [['item_description', 'cost', 'normal_price', 'retail_price', 'wholesale_price'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Product::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'item_description' => $this->item_description,
            'product_type_id' => $this->product_type_id,
            'product_category_id' => $this->product_category_id,
            'reorder_point' => $this->reorder_point,
            'reorder_quantity' => $this->reorder_quantity,
            'default_location_id' => $this->default_location_id,
            'last_vendor_id' => $this->last_vendor_id,
            'standard_uom_id' => $this->standard_uom_id,
            'sales_uom_id' => $this->sales_uom_id,
            'purchasing_uom_id' => $this->purchasing_uom_id,
            'length' => $this->length,
            'width' => $this->width,
            'height' => $this->height,
            'weight' => $this->weight,
            'cost' => $this->cost,
            'normal_price' => $this->normal_price,
            'retail_price' => $this->retail_price,
            'wholesale_price' => $this->wholesale_price,
            'active' => $this->active,
            'time' => $this->time,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'item_name', $this->item_name])
            ->andFilterWhere(['like', 'item_code', $this->item_code])
            ->andFilterWhere(['like', 'barcode', $this->barcode])
            ->andFilterWhere(['like', 'remarks', $this->remarks]);

        return $dataProvider;
    }
}
