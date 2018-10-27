<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "comment".
 *
 * @property int $id
 * @property string $entity
 * @property int $entityId
 * @property string $content
 * @property int $parentId
 * @property int $level
 * @property int $createdBy
 * @property int $updatedBy
 * @property int $status
 * @property int $createdAt
 * @property int $updatedAt
 * @property string $relatedTo
 * @property string $url
 */
class Comment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'comment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['entity', 'entityId', 'content', 'createdBy', 'updatedBy', 'createdAt', 'updatedAt', 'relatedTo'], 'required'],
            [['entityId', 'parentId', 'level', 'createdBy', 'updatedBy', 'status', 'createdAt', 'updatedAt'], 'default', 'value' => null],
            [['entityId', 'parentId', 'level', 'createdBy', 'updatedBy', 'status', 'createdAt', 'updatedAt'], 'integer'],
            [['content', 'url'], 'string'],
            [['entity'], 'string', 'max' => 10],
            [['relatedTo'], 'string', 'max' => 500],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'entity' => 'Entidad',
            'entityId' => 'Entidad ID',
            'content' => 'Contenido',
            'parentId' => 'Padre ID',
            'level' => 'Level',
            'createdBy' => 'Creado por',
            'updatedBy' => 'Actualizado por',
            'status' => 'Estado',
            'createdAt' => 'Creado en',
            'updatedAt' => 'Actualizado en',
            'relatedTo' => 'Relacionado con',
            'url' => 'Url',
        ];
    }
}
