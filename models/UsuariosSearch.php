<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Usuarios;
use app\models\UsuariosDatos;

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
            [['id'], 'integer'],
            [['nombre', 'nick', 'email'], 'safe'],
        ];
    }

    public $nombre;
    public $nick;
    public $email;

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
        $query = Usuarios::find()
            ->leftJoin('usuarios_datos', 'usuarios.datos_id = usuarios_datos.id');

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
            'usuarios.id' => $this->id,
            //'lastlogin_at' => $this->lastlogin_at,
            //'preferencias_id' => $this->preferencias_id,
        ]);

        $query->andFilterWhere(['ilike', 'usuarios_datos.nombre',
            $this->nombre])
            ->andFilterWhere(['ilike', 'usuarios_datos.nick', $this->nick])
            //->andFilterWhere(['ilike', 'web', $this->web])
            //->andFilterWhere(['ilike', 'biografia', $this->biografia])
            ->andFilterWhere(['ilike', 'usuarios_datos.email', $this->email]);

            /*
            ->andFilterWhere(['ilike', 'twitter', $this->twitter])
            ->andFilterWhere(['ilike', 'facebook', $this->facebook])
            ->andFilterWhere(['ilike', 'googleplus', $this->googleplus])
            ->andFilterWhere(['ilike', 'avatar', $this->avatar])
            ->andFilterWhere(['ilike', 'password', $this->password])
            ->andFilterWhere(['ilike', 'auth_key', $this->auth_key])
            ->andFilterWhere(['ilike', 'token', $this->token]);
            */

        // Ordenar por defecto descendientemente
        $query->orderBy([
            'usuarios.created_at' => SORT_DESC,
        ]);

        return $dataProvider;
    }
}
