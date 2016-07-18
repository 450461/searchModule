<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Words;

/**
 * WordsSearch represents the model behind the search form about `app\models\Words`.
 */
class WordsSearch extends Words
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'sum', 'ext_id'], 'integer'],
            [['word'], 'safe'],
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
        $query = Words::find();

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
            'sum' => $this->sum,
            'ext_id' => $this->ext_id,
        ]);

        $query->andFilterWhere(['like', 'word', $this->word]);

        return $dataProvider;
    }
}
