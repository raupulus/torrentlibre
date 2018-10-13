<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "categorias".
 *
 * @property int $id
 * @property string $nombre
 * @property string $descripcion
 *
 * @property Torrents[] $torrents
 */
class Categorias extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'categorias';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre'], 'required'],
            [['nombre'], 'string', 'max' => 255],
            [['descripcion'], 'string', 'max' => 500],
            [['nombre'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre' => 'Nombre',
            'descripcion' => 'Descripcion',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTorrents()
    {
        return $this->hasMany(Torrents::className(), ['categoria_id' => 'id']);
    }

    /**
     * Devuelve un Array con todas las licencias en pareja de clave/valor
     * siendo la clave el "id" y el valor su "tipo".
     * @return array Todas las licencias en parejas de clave/valor.
     */
    public static function getAll()
    {
        $query = Categorias::find();
        return array_combine(
            $query->select('id')->column(),
            $query->select('nombre')->column()
        );
    }
}
