<?php

namespace app\models;

use function date_diff;
use DateTime;
use Yii;
use yii2mod\moderation\enums\Status;

/**
 * This is the model class for table "comments".
 *
 */
class Comentarios extends \yii2mod\comments\models\CommentModel
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['entity', 'entityId'], 'required'],
            ['content', 'required', 'message' => 'El Comentario no puede estar en blanco'],
            [['content', 'entity', 'relatedTo', 'url'], 'string'],
            ['status', 'default', 'value' => Status::APPROVED],
            ['status', 'in', 'range' => Status::getConstantsByName()],
            ['level', 'default', 'value' => 1],
            ['parentId', 'validateParentID'],
            [['entityId', 'parentId', 'status', 'level'], 'integer'],
            ['content', function($model) {
                $userId = Yii::$app->user->id;
                $ultimoComentario = Comentarios::find()->where([
                    'createdBy' => $userId,
                ])->orderBy(['createdAt' => SORT_DESC])->one();

                if (empty($ultimoComentario)) {
                    return true;
                }

                $ultimoComentario = new DateTime($ultimoComentario->created_at);


                $diferencia = $ultimoComentario->diff(new DateTime('now'));
                $minutos = (new DateTime())->setTimeStamp(0)
                                           ->add($diferencia)
                                           ->getTimeStamp();
                $minutos = (int) ($minutos/60);

                if ($minutos < 5) {
                    $this->addError(
                        $model,
                        'Solo puedes realizar un comentario cada 5 minutos. ' .
                        'Aún te faltan ' . (5-$minutos) . ' minutos.'
                    );
                }

                return true;
            }]
        ];
    }

    /**
     * {@inheritdoc}
     * @return array
     */
    public function attributes()
    {
        return array_merge(parent::attributes(), [

        ]);
    }

    /**
     * Acciones llevadas a cabo antes de insertar un comentario
     * @param bool $insert Acción a realizar, si existe está insertando
     * @return bool Devuelve un booleano, si se lleva a cabo es true.
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($insert) {

            }


            return true;
        }
        return false;
    }
}
