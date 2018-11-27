<?php

namespace app\controllers;

use app\helpers\Roles;
use app\helpers\Security;
use Yii;
use app\models\ReportesTorrents;
use app\models\ReportesTorrentsSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ReportesTorrentsController implements the CRUD actions for ReportesTorrents model.
 */
class ReportesTorrentsController extends Controller
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
     * Lists all ReportesTorrents models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ReportesTorrentsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionReportar($torrent, $titulo, $descripcion) {
        $usuario = Yii::$app->user->id;
        $model = ReportesTorrents::find()->where([
            'torrent_id' => $torrent,
            'usuario_id' => $usuario,
        ])->one();

        if (empty($model)) {
            $model = new ReportesTorrents([
                'torrent_id' => $torrent,
                'usuario_id' => $usuario,
            ]);
        }

        $model->ip = Security::getIp();
        $model->titulo = $titulo;
        $model->resumen = $descripcion;

        $model->save();

        /*
        Yii::$app->getResponse()
            ->redirect(['/torrents/view?id='.$id])
            ->send();
        */
    }


    /**
     * Deletes an existing ReportesTorrents model.
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
     * Finds the ReportesTorrents model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ReportesTorrents the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ReportesTorrents::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
