<?php

namespace app\controllers;

use app\models\Comentarios;
use Yii;
use app\models\PuntuacionComentarios;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PuntuacionComentariosController implements the CRUD actions for PuntuacionComentarios model.
 */
class PuntuacionComentariosController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Puntua un comentario recibiendo una puntuación y el
     * comentario al que se valora.
     *
     * @param $puntuacion Puntos del 1-10.
     * @param $comentario Comentario sobre el que se puntúa.
     */
    public function actionModificar($puntuacion, $comentario) {
        $usuario = Yii::$app->user->id;
        $model = PuntuacionComentarios::find()->where([
            'comentario_id' => $comentario,
            'usuario_id' => $usuario,
        ])->one();

        if (empty($model)) {
            $model = new PuntuacionComentarios([
                'comentario_id' => $comentario,
                'usuario_id' => $usuario,
            ]);
        }

        $model->puntuacion = $puntuacion;
        $model->save();

        $puntos = Comentarios::findOne($comentario)->getPuntos();

        $respuesta = [
            'media' => $puntos,
            'puntuado' => $puntuacion
        ];

        print_r(json_encode($respuesta));
    }

    /**
     * Deletes an existing PuntuacionComentarios model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the PuntuacionComentarios model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PuntuacionComentarios the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PuntuacionComentarios::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
