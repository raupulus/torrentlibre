<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "licencias".
 *
 * @property int $id
 * @property string $tipo
 * @property string $url
 * @property string $imagen
 *
 * @property Torrents[] $torrents
 */
class Licencias extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'licencias';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tipo', 'url'], 'required'],
            [['tipo', 'url', 'imagen'], 'string', 'max' => 255],
            [['tipo'], 'unique'],
            [['url'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tipo' => 'Tipo',
            'url' => 'Url',
            'imagen' => 'Imagen',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTorrents()
    {
        return $this->hasMany(Torrents::className(), ['licencia_id' => 'id']);
    }
}
