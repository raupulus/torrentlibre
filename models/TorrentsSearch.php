<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Torrents;

/**
 * TorrentsSearch represents the model behind the search form of `app\models\Torrents`.
 */
class TorrentsSearch extends Torrents
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'licencia_id', 'categoria_id', 'usuario_id', 'size', 'n_descargas', 'n_visitas'], 'integer'],
            [['titulo', 'resumen', 'descripcion', 'imagen', 'file', 'magnet', 'password', 'md5', 'created_at', 'updated_at'], 'safe'],
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
        $query = Torrents::find();

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
            'licencia_id' => $this->licencia_id,
            'categoria_id' => $this->categoria_id,
            'usuario_id' => $this->usuario_id,
            'size' => $this->size,
            'n_descargas' => $this->n_descargas,
            'n_visitas' => $this->n_visitas,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['ilike', 'titulo', $this->titulo])
            ->andFilterWhere(['ilike', 'resumen', $this->resumen])
            ->andFilterWhere(['ilike', 'descripcion', $this->descripcion])
            ->andFilterWhere(['ilike', 'imagen', $this->imagen])
            ->andFilterWhere(['ilike', 'file', $this->file])
            ->andFilterWhere(['ilike', 'magnet', $this->magnet])
            ->andFilterWhere(['ilike', 'password', $this->password])
            ->andFilterWhere(['ilike', 'md5', $this->md5]);

        return $dataProvider;
    }
}
