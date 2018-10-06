<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Usuarios;

/**
 * UsuariosSearch represents the model behind the search form of `app\models\Usuarios`.
 */
class UsuariosSearch extends Usuarios
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'preferencias_id'], 'integer'],
            [['nombre', 'nick', 'web', 'biografia', 'email', 'twitter', 'facebook', 'googleplus', 'avatar', 'password', 'auth_key', 'token', 'lastlogin_at'], 'safe'],
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
        $query = Usuarios::find();

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
            'lastlogin_at' => $this->lastlogin_at,
            'preferencias_id' => $this->preferencias_id,
        ]);

        $query->andFilterWhere(['ilike', 'nombre', $this->nombre])
            ->andFilterWhere(['ilike', 'nick', $this->nick])
            ->andFilterWhere(['ilike', 'web', $this->web])
            ->andFilterWhere(['ilike', 'biografia', $this->biografia])
            ->andFilterWhere(['ilike', 'email', $this->email])
            ->andFilterWhere(['ilike', 'twitter', $this->twitter])
            ->andFilterWhere(['ilike', 'facebook', $this->facebook])
            ->andFilterWhere(['ilike', 'googleplus', $this->googleplus])
            ->andFilterWhere(['ilike', 'avatar', $this->avatar])
            ->andFilterWhere(['ilike', 'password', $this->password])
            ->andFilterWhere(['ilike', 'auth_key', $this->auth_key])
            ->andFilterWhere(['ilike', 'token', $this->token]);

        return $dataProvider;
    }
}
