<?php

namespace app\controllers;

use function isEmpty;
use Yii;
use app\models\Usuarios;
use app\models\UsuariosSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Preferencias;
use app\models\UsuariosId;
use yii\filters\AccessControl;
use yii\db\Expression;


/**
 * UsuariosController implements the CRUD actions for Usuarios model.
 */
class UsuariosController extends Controller
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
                'only' => ['index', 'view', 'delete', 'update'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Usuarios models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UsuariosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Usuarios model.
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
     * Crea un nuevo usuario a partir del modelo.
     * Si consigue crearse correctamente, se redirigirá a la vista del usuario
     * recién creado.
     *
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Usuarios(['scenario' => Usuarios::ESCENARIO_CREATE]);

        if ($model->load(Yii::$app->request->post())) {
            // Creo un nuevo id para este usuarios desde "usuarios_id"
            $usuario_id = new UsuariosId();

            // Creo nuevo id para preferencias_id desde "preferencias"
            $preferencias = new Preferencias(['tema_id' => 1]);
        }

        // Si entra mediante POST y puedo crear el usuario_id lo cargo al modelo
        if ($model->load(Yii::$app->request->post()) &&
            $usuario_id->save() &&
            $preferencias->save()
        ) {
            $model->id = $usuario_id->id;
            $model->preferencias_id = $preferencias->id;

            if ($model->avatar == '') {
                $model->avatar = 'default.png';
            }

            $model->lastlogin_at = new Expression('NOW()');

            if ($model->save()) {
                Yii::$app->user->login($model);
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Usuarios model.
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
     * Deletes an existing Usuarios model.
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
     * Finds the Usuarios model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Usuarios the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Usuarios::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


    /**
     * Acciones para configurar el captcha en formulario.
     * @return array Devuelve la configuración del captcha
     */
    public function actions()
    {
        return [
            'captcha' => [
                'class' => 'juliardi\captcha\CaptchaAction',
                'length' => 4,   // Cantidad de carácteres
                'width' => 200,  // Ancho de la imagen generada
                'height' => 80,  // Alto de la imagen generada
            ],
        ];
    }
}
