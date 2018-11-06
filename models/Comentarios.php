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
     * @var Atributo para check de políticas de privacidad.
     */
    public $privacy;

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
            [['privacy'], 'boolean'],
            [
                ['privacy'],
                'required',
                'requiredValue' => 1,
                'message' => 'Debes leer, entender y aceptar las políticas del sitio.'
            ],

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
            'privacy' => 'Privacidad',
        ]);
    }

    /**
     * Devuelve la puntuación media para el comentario actual.
     * @return float|int
     */
    public function getPuntos()
    {
        $p = PuntuacionComentarios::find()
            ->select('puntuacion')
            ->where(['comentario_id' => $this->id])
            ->column();

        $total = array_sum($p);
        $votos = count($p);

        if ($votos == 0) {
            return 0;
        }

        return $total / $votos;
    }
}
