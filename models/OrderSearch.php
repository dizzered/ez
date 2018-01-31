<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Order;

/**
 * OrderSearch represents the model behind the search form about `app\models\Order`.
 */
class OrderSearch extends Order
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_address', 'id_shipping', 'payment_type', 'order_status', 'order_number'], 'integer'],
            [['payment_check', 'paypal', 'transaction_number', 'order_date', 'addition_info', 'id_user'], 'safe'],
            [['final_sum', 'promo_sum'], 'number'],
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
        $query = Order::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['order_date' => SORT_DESC],
            ]
        ]);

        $this->load($params);

        if (isset($params['sort']) && strpos($params['sort'], 'id_user') !== false) {
            $query->joinWith('user');
            $dataProvider->setSort([
                'attributes' => [
                    'order_number',
                    'order_date',
                    'order_status',
                    'id_user' => [
                        'asc' => ['users.email' => SORT_ASC],
                        'desc' => ['users.email' => SORT_DESC],
                        'default' => SORT_ASC,
                    ]
                ]
            ]);
        }

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'id_address' => $this->id_address,
            'id_shipping' => $this->id_shipping,
            'payment_type' => $this->payment_type,
            'order_status' => $this->order_status,
            'final_sum' => $this->final_sum,
            'promo_sum' => $this->promo_sum,
        ]);

        $query->andFilterWhere(['like', 'order_number', $this->order_number])
            ->andFilterWhere(['like', 'payment_check', $this->payment_check])
            ->andFilterWhere(['like', 'paypal', $this->paypal])
            ->andFilterWhere(['like', 'transaction_number', $this->transaction_number])
            ->andFilterWhere(['like', 'addition_info', $this->addition_info]);

        if ($this->order_date) {
            $range = explode('-', $this->order_date);
            $timestampStart = strtotime($range[0]);
            $timestampEnd = strtotime($range[1]);
            $query->andFilterWhere(['>=', 'order_date', date('Y-m-d H:i:s', mktime(0,0,0,date('m', $timestampStart), date('d', $timestampStart), date('Y', $timestampStart)))]);
            $query->andFilterWhere(['<=', 'order_date', date('Y-m-d H:i:s', mktime(23,59,59,date('m', $timestampEnd), date('d', $timestampEnd), date('Y', $timestampEnd)))]);
        }

        if ($this->id_user) {
            $query->joinWith('user');
            $query->andFilterWhere(['like', 'users.email', $this->id_user]);
        }

        return $dataProvider;
    }
}
