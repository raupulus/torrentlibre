<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ReportesTorrents;

/**
 * ReportesTorrentsSearch represents the model behind the search form of `app\models\ReportesTorrents`.
 */
class ReportesTorrentsSearch extends ReportesTorrents
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'usuario_id', 'torrent_id'], 'integer'],
            [['ip', 'titulo', 'resumen', 'created_at'], 'safe'],
            [['comunicado'], 'boolean'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = ReportesTorrents::find();

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
            'usuario_id' => $this->usuario_id,
            'torrent_id' => $this->torrent_id,
            'comunicado' => $this->comunicado,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['ilike', 'ip', $this->ip])
            ->andFilterWhere(['ilike', 'titulo', $this->titulo])
            ->andFilterWhere(['ilike', 'resumen', $this->resumen]);

        return $dataProvider;
    }
}
