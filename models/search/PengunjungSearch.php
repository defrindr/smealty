<?php

namespace app\models\search;

use app\models\Pengunjung;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * PengunjungSearch represents the model behind the search form about `app\models\Pengunjung`.
 */
class PengunjungSearch extends Pengunjung
{
/**
 * @inheritdoc
 */
    public function rules()
    {
        return [
            [['id', 'pakai_masker'], 'integer'],
            [['foto', 'timestamp'], 'safe'],
            [['tegangan_piezoelektrik'], 'number'],
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
        $query = Pengunjung::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'pakai_masker' => $this->pakai_masker,
            'tegangan_piezoelektrik' => $this->tegangan_piezoelektrik,
            'timestamp' => $this->timestamp,
        ]);

        $query->andFilterWhere(['like', 'foto', $this->foto]);

        return $dataProvider;
    }
}
