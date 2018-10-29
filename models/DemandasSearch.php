<?php

namespace app\models;

use DateTime;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Demandas;

/**
 * DemandasSearch represents the model behind the search form of `app\models\Demandas`.
 */
class DemandasSearch extends Demandas
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'solicitante_id', 'atendedor_id'], 'integer'],
            [['titulo', 'descripcion', 'created_at', 'allfields'], 'safe'],
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
        $query = Demandas::find()
            ->leftJoin(
                'usuarios_datos',
                'demandas.solicitante_id = usuarios_datos.id'
            );

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

        $treintadias = new DateTime('now');
        $treintadias->modify('-30 days');
        $treintadias = $treintadias->format('Y-m-d H:i:s');

        /*
         * Solo muestro los últimos 30 días de peticiones que no fueron
         * atendidas por ningún usuario.
         */
        $query->where(['>=', 'created_at', $treintadias])
              ->andWhere(['atendedor_id' => null]);

        $query->andFilterWhere(['ilike', 'titulo', $this->allfields])
              ->orFilterWhere(['ilike', 'descripcion', $this->allfields])
              ->orFilterWhere(['ilike', 'nick', $this->allfields]);

        // Ordenar por defecto descendientemente
        $query->orderBy([
            'created_at' => SORT_DESC,
        ]);

        return $dataProvider;
    }
}
