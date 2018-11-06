<?php

namespace app\controllers;

use Yii;
use app\models\PuntuacionTorrents;
use app\models\PuntuacionTorrentsSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PuntuacionTorrentsController implements the CRUD actions for PuntuacionTorrents model.
 */
class PuntuacionTorrentsController extends Controller
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
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['modificar'],
                'rules' => [
                    [
                        'actions' => ['modificar'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ]
            ],
        ];
    }

    /**
     * Puntua un torrent recibiendo una puntuación y el torrent a valorar.
     * @param $puntuacion Puntos del 1-10.
     * @param $torrent Torrent sobre el que se puntúa.
     */
    public function actionModificar($puntuacion, $torrent) {
        $usuario = Yii::$app->user->id;
        $model = PuntuacionTorrents::find()->where([
            'torrent_id' => $torrent,
            'usuario_id' => $usuario,
        ])->one();

        if (empty($model)) {
            $model = new PuntuacionTorrents([
                'torrent_id' => $torrent,
                'usuario_id' => $usuario,
            ]);
        }

        $model->puntuacion = $puntuacion;

        $model->save();
    }

    /**
     * Deletes an existing PuntuacionTorrents model.
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
     * Finds the PuntuacionTorrents model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PuntuacionTorrents the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PuntuacionTorrents::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
