<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Payment;

/**
 * PaymentSearch represents the model behind the search form about `app\models\Payment`.
 */
class PaymentSearch extends Payment
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'agreement_id', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['amount_paid', 'amount_changed'], 'number'],
            [['receipt_number', 'type', 'mode', 'bank_name', 'cheque_number', 'payee_name', 'payee_mobile_number', 'payee_email', 'payee_address', 'date', 'time', 'notes'], 'safe'],
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
        $query = Payment::find();

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
            'amount_changed' => $this->amount_changed,
            'date' => $this->date,
            'time' => $this->time,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'receipt_number', $this->receipt_number])
            ->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'mode', $this->mode])
            ->andFilterWhere(['like', 'bank_name', $this->bank_name])
            ->andFilterWhere(['like', 'cheque_number', $this->cheque_number])
            ->andFilterWhere(['like', 'payee_name', $this->payee_name])
            ->andFilterWhere(['like', 'payee_mobile_number', $this->payee_mobile_number])
            ->andFilterWhere(['like', 'payee_email', $this->payee_email])
            ->andFilterWhere(['like', 'payee_address', $this->payee_address])
            ->andFilterWhere(['like', 'notes', $this->notes]);

        return $dataProvider;
    }
}
