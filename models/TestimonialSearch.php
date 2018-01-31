<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Testimonial;

/**
 * TestimonialSearch represents the model behind the search form about `app\models\Testimonial`.
 */
class TestimonialSearch extends Testimonial
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['created', 'modified', 'text', 'signature'], 'safe'],
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
        $query = Testimonial::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['created' => SORT_DESC],
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        if ($this->created) {
            $range = explode('-', $this->created);
            $timestampStart = strtotime($range[0]);
            $timestampEnd = strtotime($range[1]);
            $query->andFilterWhere(['>=', 'created', date('Y-m-d H:i:s', mktime(0,0,0,date('m', $timestampStart), date('d', $timestampStart), date('Y', $timestampStart)))]);
            $query->andFilterWhere(['<=', 'created', date('Y-m-d H:i:s', mktime(23,59,59,date('m', $timestampEnd), date('d', $timestampEnd), date('Y', $timestampEnd)))]);
        }

        $query->andFilterWhere(['like', 'text', $this->text])
            ->andFilterWhere(['like', 'signature', $this->signature]);

        return $dataProvider;
    }
}
