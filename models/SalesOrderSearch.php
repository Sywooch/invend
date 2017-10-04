<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SalesOrder;

/**
 * SalesOrderSearch represents the model behind the search form about `app\models\SalesOrder`.
 */
class SalesOrderSearch extends SalesOrder
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'location_id', 'balance', 'customer_id', 'sales_rep_id', 'currency_id', 'status', 'cancel', 'reason', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['number', 'cancel_date', 'cancel_reason', 'date', 'due_date', 'time', 'remarks'], 'safe'],
            [['total', 'paid'], 'number'],
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
        $query = SalesOrder::find();

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
            'location_id' => $this->location_id,
            'total' => $this->total,
            'paid' => $this->paid,
            'balance' => $this->balance,
            'customer_id' => $this->customer_id,
            'sales_rep_id' => $this->sales_rep_id,
            'currency_id' => $this->currency_id,
            'status' => $this->status,
            'cancel' => $this->cancel,
            'cancel_date' => $this->cancel_date,
            'date' => $this->date,
            'due_date' => $this->due_date,
            'time' => $this->time,
            'reason' => $this->reason,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'number', $this->number])
            ->andFilterWhere(['like', 'cancel_reason', $this->cancel_reason])
            ->andFilterWhere(['like', 'remarks', $this->remarks]);

        return $dataProvider;
    }
}
