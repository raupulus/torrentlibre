<?php

namespace app\controllers;

use app\helpers\Access;
use app\helpers\Roles;
use app\helpers\Security;
use function var_dump;
use Yii;
use app\models\ReportesComentarios;
use app\models\ReportesComentariosSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ReportesComentariosController implements the CRUD actions for ReportesComentarios model.
 */
class ReportesComentariosController extends Controller
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
                'only' => ['index', 'delete'],
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['delete'],
                        'allow' => true,
                        'matchCallback' => function($rule, $action) {
                            $isAdmin = Roles::isAdmin();

                            if ($isAdmin) {
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
     * Lists all ReportesComentarios models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ReportesComentariosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new ReportesComentarios model.
     * @return mixed
     */
    public function actionReportar($id, $titulo, $resumen)
    {
        $usuario = Yii::$app->user->id;
        $model = ReportesComentarios::find()->where([
            'comentario_id' => $id,
            'usuario_id' => $usuario,
        ])->one();

        if (empty($model)) {
            $model = new ReportesComentarios([
                'comentario_id' => $id,
                'usuario_id' => $usuario,
            ]);
        }

        $model->ip = Security::getIp();
        $model->titulo = $titulo;
        $model->resumen = $resumen;

        $model->save();
    }

    /**
     * Deletes an existing ReportesComentarios model.
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
     * Finds the ReportesComentarios model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ReportesComentarios the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ReportesComentarios::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
