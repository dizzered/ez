<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Item;

/**
 * ItemSearch represents the model behind the search form about `app\models\Item`.
 */
class ItemSearch extends Item
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_firm', 'svisibility'], 'integer'],
            [['name', 'descr', 'image'], 'safe'],
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
        $query = Item::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['name' => SORT_ASC],
            ]
        ]);

        $this->load($params);

        if (!isset($params['ItemSearch']['svisibility'])) {
            $this->svisibility = 1;
        }

        if (isset($params['sort']) && strpos($params['sort'], 'id_firm') !== false) {
            $query->joinWith('firm');
            $dataProvider->setSort([
                'attributes' => [
                    'name',
                    'svisibility',
                    'id_firm' => [
                        'asc' => ['item_firm.name' => SORT_ASC],
                        'desc' => ['item_firm.name' => SORT_DESC],
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
            'id_firm' => $this->id_firm,
            'svisibility' => $this->svisibility
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'descr', $this->descr])
            ->andFilterWhere(['like', 'image', $this->image]);

        return $dataProvider;
    }

    public static function findItems($query)
    {
        return (new \yii\db\Query())
            ->select('items.*, item_firm.name as firm_name, carrier.name AS carrier_name, carrier.id AS id_carrier, item_prices.price_good')
            ->from('items')
            ->join('INNER JOIN', 'item_firm', 'item_firm.id = items.id_firm')
            ->join('INNER JOIN', 'item_prices', 'item_prices.id_item = items.id')
            ->join('INNER JOIN', 'carrier', 'carrier.id = item_prices.id_carrier')
            ->andWhere(['like', 'items.name',  $query])
            ->andWhere(['items.svisibility' => 1])
            ->orderBy(['item_prices.price_good' => SORT_DESC])
            ->all();
    }
}
