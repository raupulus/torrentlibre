<?php

namespace app\controllers;

use app\helpers\Access;
use app\helpers\Roles;
use app\models\Preferencias;
use app\models\UsuariosDatos;
use function var_dump;
use Yii;
use app\models\Usuarios;
use app\models\UsuariosSearch;
use yii\db\Expression;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

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
                        'actions' => ['index', 'view'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],

                    [
                        'actions' => ['delete', 'update'],
                        'allow' => true,
                        'matchCallback' => function($rule, $action) {
                            $isAdmin = Roles::isAdmin();
                            $isAutor = Access::isAutor($_REQUEST['id']);

                            if ($isAdmin || $isAutor) {
                                return true;
                            }

                            return false;
                        },
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
        if (Access::ipBloqueada()) {
            Yii::$app->getResponse()
                ->redirect(['site/iplocked'])
                ->send();
        }

        $model = new UsuariosDatos([
            'scenario' => UsuariosDatos::ESCENARIO_CREATE,
            'lastlogin_at' => new Expression('NOW()'),
            'privacy' => false,
        ]);

        $isPOST = $model->load(Yii::$app->request->post());

        if ($isPOST && $model->save()) {
            $usuario_id = Usuarios::findOne($model->id);
            $usuario_id->datos_id = $model->id;
            $usuario_id->update();

            if (! Roles::isAdmin()) {
                Yii::$app->user->login($model);
            }

            return $this->redirect(['view', 'id' => $model->id]);
        }

        //var_dump($model->errors);die();
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
        $model = UsuariosDatos::findOne($id);
        $model->password = '';
        $model->scenario = UsuariosDatos::ESCENARIO_UPDATE;

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
        $isAdmin = Roles::isAdmin();

        $user = Usuarios::findOne($id);
        $user->datos_id = 2;
        $user->update();

        UsuariosDatos::findOne($id)->delete();

        if ($isAdmin) {
            return $this->redirect(['usuarios/index']);
        }

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
}
