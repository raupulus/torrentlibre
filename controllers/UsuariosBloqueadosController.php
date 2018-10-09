<?php

namespace app\controllers;

use app\models\Usuarios;
use redirect;
use Yii;
use app\models\UsuariosBloqueados;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UsuariosBloqueadosController implements the CRUD actions for UsuariosBloqueados model.
 */
class UsuariosBloqueadosController extends Controller
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
     * Bloquea el usuario recibido.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionBloquear($id)
    {
        if (!empty($id)) {
            // Crear modelo de UsuariosBloqueados con la id de usuario recibida.
            $model = new UsuariosBloqueados([
                'usuario_id' => $id,
            ]);
        } else {
            // responder mensaje de error flash
            Yii::$app->session->setFlash('error',
                'Error bloqueando usuario');
        }

        // Insertar una nueva entrada para este usuario en UsuariosBloqueados
        if ((!empty($model->usuario_id)) && ($model->save())) {
            Yii::$app->session->setFlash('success',
                'Se ha bloqueando el usuario correctamente');
            return $this->redirect(['usuarios/index']);
        }

        return $this->redirect(['usuarios/index']);
    }

    /**
     * Desbloquea el usuario recibido.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDesbloquear($id)
    {
        if (!empty($id) && ($this->findModel($id)->delete())) {
            Yii::$app->session->setFlash('success',
                'Se ha desbloqueando el usuario correctamente');
        } else {
            Yii::$app->session->setFlash('error',
                'Error al eliminar usuario');
            return $this->redirect(['usuarios/index']);
        }

        return $this->redirect(['usuarios/index']);
    }


    /**
     * Lists all UsuariosBloqueados models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => UsuariosBloqueados::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single UsuariosBloqueados model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new UsuariosBloqueados model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new UsuariosBloqueados();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing UsuariosBloqueados model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing UsuariosBloqueados model.
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
     * Finds the UsuariosBloqueados model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return UsuariosBloqueados the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = UsuariosBloqueados::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
