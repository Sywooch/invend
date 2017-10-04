<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\PaymentPlan;

/**
 * PaymentPlanSearch represents the model behind the search form about `app\models\PaymentPlan`.
 */
class PaymentPlanSearch extends PaymentPlan
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'agreement_id', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['amount_paid', 'running_total', 'amount_due', 'amount_in_arrears', 'goodwill_in_arrears', 'rent_in_arrears'], 'number'],
            [['time', 'notes', 'frequency', 'currency'], 'safe'],
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
        $query = PaymentPlan::find();

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
            'agreement_id' => $this->agreement_id,
            'amount_paid' => $this->amount_paid,
            'amount_due' => $this->amount_due,
            'amount_in_arrears' => $this->amount_in_arrears,
            'running_total' => $this->running_total,
            'frequency' => $this->frequency,
            'currency' => $this->currency,
            'goodwill_in_arrears' => $this->goodwill_in_arrears,
            'rent_in_arrears' => $this->rent_in_arrears,
            'time' => $this->time,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'notes', $this->notes]);

        return $dataProvider;
    }
}
