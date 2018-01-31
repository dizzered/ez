<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Promo;

/**
 * PromoSearch represents the model behind the search form about `app\models\Promo`.
 */
class PromoSearch extends Promo
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['promo_id', 'number'], 'integer'],
            [['code', 'type', 'expiration_date', 'group', 'items'], 'safe'],
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
        $query = Promo::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'promo_id' => $this->promo_id,
            'number' => $this->number,
        ]);

        $query->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'group', $this->group])
            ->andFilterWhere(['like', 'items', $this->items]);

        if ($this->expiration_date) {
            $range = explode('-', $this->expiration_date);
            $timestampStart = strtotime($range[0]);
            $timestampEnd = strtotime($range[1]);
            $query->andFilterWhere(['>=', 'order_date', date('Y-m-d H:i:s', mktime(0,0,0,date('m', $timestampStart), date('d', $timestampStart), date('Y', $timestampStart)))]);
            $query->andFilterWhere(['<=', 'order_date', date('Y-m-d H:i:s', mktime(23,59,59,date('m', $timestampEnd), date('d', $timestampEnd), date('Y', $timestampEnd)))]);
        }

        return $dataProvider;
    }
}
