<?php

namespace app\controllers;

use app\helpers\Access;
use app\helpers\Roles;
use Bhutanio\BEncode\BEncode;
use Devristo\Torrent\Bee;
use function var_dump;
use Yii;
use app\models\Torrents;
use app\models\TorrentsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\models\Categorias;
use app\models\Licencias;
use yii\web\UploadedFile;
use Devristo\Torrent\Torrent;

/**
 * TorrentsController implements the CRUD actions for Torrents model.
 */
class TorrentsController extends Controller
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
                'only' => ['create', 'delete', 'update'],
                'rules' => [
                    [
                        'actions' => ['create'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['delete', 'update'],
                        'allow' => true,
                        'matchCallback' => function($rule, $action) {
                            $id = Torrents::findOne($_REQUEST['id'])->usuario_id;
                            $isAdmin = Roles::isAdmin();
                            $isAutor = Access::isAutor($id);

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
     * Lists all Torrents models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TorrentsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Torrents model.
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
     * Creates a new Torrents model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Torrents([
            'usuario_id' => Yii::$app->user->identity->id,
            'scenario' => Torrents::ESCENARIO_CREATE,

        ]);

        // En el caso de existir datos mediante POST los proceso
        if ($model->load(Yii::$app->request->post())) {
            $model->u_torrent = UploadedFile::getInstance($model, 'u_torrent');

            // Es obligatorio que haya un torrent para continuar
            if ($model->u_torrent !== null) {
                $torrent = Torrent::fromFile($model->u_torrent->tempName);
                $model->n_piezas = $torrent->getNumPieces();
                $model->size_piezas = $torrent->getPieceSize();
                $model->torrentcreate_at = $torrent->getCreationDate()
                                            ->format('Y-m-d H:m:i');
                $model->size = $torrent->getSize(false);
                $model->hash = $torrent->getInfoHash(false);
                $model->archivos = implode(",", $torrent->getFiles());

                // Modifico valores del torrent
                $torrent->setName($model->titulo);
                $torrent->setPrivate(false);
                $torrent->setComment($model->descripcion);

                if ($model->save()) {
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            } else {
                Yii::$app->session->setFlash('error', 'Es obligatorio el archivo torrent');
                $model->addError('u_torrent',
                    'Es obligatorio agregar un Torrent válido');
            }
        }

        $licencias = Licencias::getAll();
        $categorias = Categorias::getAll();

        return $this->render('create', [
            'model' => $model,
            'licencias' => $licencias,
            'categorias' => $categorias,
        ]);
    }

    /**
     * Updates an existing Torrents model.
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

        $model->scenario = Torrents::ESCENARIO_UPDATE;

        $licencias = Licencias::getAll();
        $categorias = Categorias::getAll();

        return $this->render('update', [
            'model' => $model,
            'licencias' => $licencias,
            'categorias' => $categorias,
        ]);
    }

    /**
     * Convierte el enlace hash del magnet recibido en un archivo torrent
     * @param $hash
     */
    public function actionDescargar($id, $hash)
    {
        $bcoder = new BEncode;
        $bcoder->set([
            'announce'=>'http://www.private-tracker.com',
            'comment'=>'Downloaded from Private Tracker',
            'created_by'=>'PrivateTracker v1.0',
            'hash' =>'c7c7f829f48653bfd0ab0a4f896bdc2e8bee0a91',
        ]);




        //die();
        /*
        $torrent = $bcoder->bencode(
            [
                ['c7c7f829f48653bfd0ab0a4f896bdc2e8bee0a91&dn=asdasdasd']
        ]);
        */

        //print_r($bcoder->bdecode(['info']['infohash']));
        //echo $bcoder->bencode($torrent);

        //var_dump($torrent);
    }

    /**
     * Deletes an existing Torrents model.
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
     * Finds the Torrents model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Torrents the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Torrents::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
