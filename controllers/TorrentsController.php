<?php

namespace app\controllers;

use app\helpers\Access;
use app\helpers\Amazons3;
use app\helpers\Imageresize;
use app\helpers\Magnet2torrent;
use app\helpers\Roles;
use app\helpers\Security;
use app\models\Comment;
use app\models\Descargas;
use function array_combine;
use function array_map;
use function array_push;
use Bhutanio\BEncode\BEncode;
use DateTime;
use function fclose;
use function fopen;
use function fwrite;
use function implode;
use function isEmpty;
use function json_encode;
use PHP\BitTorrent\Decoder;
use PHP\BitTorrent\Encoder;
use function random_int;
use function sha1;
use function var_dump;
use Yii;
use app\models\Torrents;
use app\models\TorrentsSearch;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\models\Categorias;
use app\models\Licencias;
use yii\web\UploadedFile;
use Devristo\Torrent\Torrent;
use yii2mod\editable\EditableAction;

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
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'edit-page' => [
                'class' => EditableAction::className(),
                'modelClass' => Comment::className(),
                'forceCreate' => false
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

        $query = Categorias::find()->select(['id', 'nombre'])->asArray()
            ->all();

        $categoriasId = [''];
        $categoriasNombres = ['Todas las Categorías'];

        foreach ($query as $ele) {
            array_push($categoriasId, $ele['id']);
            array_push($categoriasNombres, $ele['nombre']);
        }

        $categorias = array_combine($categoriasId, $categoriasNombres);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'categorias' => $categorias,
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
        if (! Roles::canUpload()) {
            Yii::$app->session->setFlash('error', 'Has subido el límite de torrents diarios para tu rango actual');
            $this->redirect(['torrents/index']);
        }

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
                $pieces = array_map(function($ele) {
                    return sha1($ele, false);
                }, $torrent->getPieces());
                $pieces = implode(',', $pieces);

                $length = [];
                $torrentArray = $torrent->toArray();
                if (!empty($torrentArray['info']['files'])) {
                    $files = $torrentArray['info']['files'];
                    foreach ($files as $file) {
                        $l = $file['length'];
                        array_push($length, $l);
                    }
                }

                $trackers = [];
                foreach ($torrent->getAnnounceList() as $tracker) {
                    array_push($trackers, $tracker[0]);
                }

                $model->n_piezas = $torrent->getNumPieces();
                $model->size_piezas = $torrent->getPieceSize();
                $model->torrentcreate_at = $torrent->getCreationDate()
                                            ->format('Y-m-d H:m:i');
                $model->size = $torrent->getSize(false);
                $model->hash = $torrent->getInfoHash(false);
                $model->archivos = implode(',', $torrent->getFiles());
                $model->archivos_hash = $pieces;
                $model->archivos_size = implode(',', $length);
                $model->trackers = implode(',', $trackers);
                $model->name = $torrent->getName();

                // Guardo imagen si existiera
                $model->u_img = UploadedFile::getInstance($model, 'u_img');
                if ($model->u_img !== null) {
                    $imgObject = new Imageresize($model->u_img);

                    // Subo Imagen a amazon
                    $imagenLocal = $imgObject->getRutaImagen();
                    $nombreAmazon = 'torrentimages/' . $imgObject->getNombre();
                    $amazon = new Amazons3();
                    $amazon->uploadImage(
                        $nombreAmazon,
                        $imagenLocal
                    );

                    $model->imagen = $amazon->getUrlImage($nombreAmazon);
                    $model->u_img = ''; // Deshabilito este atributo temporal.
                }

                if ($model->save()) {
                    //$rol = Yii::$app->user->identity->rol;
                    //$roles = Roles::allRoles();
                    Roles::subirRole();

                    return $this->redirect(['view', 'id' => $model->id]);
                }
            } else {
                Yii::$app->session->setFlash('error',
                                    'Es obligatorio el archivo torrent');
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
    public function actionDescargar($id)
    {
        // Anoto una descarga para el torrent actual.
        $this->actionAnotardescarga($id);

        // Array con toda la información del torrent.
        $info = Magnet2torrent::generateTorrentInfo($id);

        // Creo el torrent con la información de $info
        //$bcoder = new BEncode;
        //$torrent = $bcoder->bencode($info);

        $torrent = new Encoder();

        $torrent = $torrent->encodeDictionary($info);


        // Genero el archivo descargable
        $datetime = new DateTime('now');
        $datetime = $datetime->getTimestamp();
        $randomstring = random_int(1, 10000);
        $tmpName = $info['info']['root hash'].$datetime.$randomstring.'.torrent';

        $ruta = Yii::getAlias('@tmp');
        $rutaSave = 'uploads/'.$tmpName;

        $file = fopen($rutaSave, 'w+');
        $x = fwrite($file, $torrent);
        fclose($file);

        $this->redirect('/'.$rutaSave);
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

    /*
     * Anota una descarga para el torrent recibido.
     * Solo registra 1 acción por minuto en cada IP.
     *
     * @param $torrent_id El id del torrent que anotará la descarga.
     */
    public function actionAnotardescarga($torrent_id) {
        $ip = Security::getIp();

        $min1 = new DateTime('now');
        $min1->modify('-1 min');
        $min1 = $min1->format('Y-m-d H:i:s');

        $oldDesc = Descargas::find()
            ->where(['ip' => $ip])
            ->andWhere(['>=', 'registered_at', $min1])
            ->count();

        if ($oldDesc == 0) {
            $descargas = new Descargas([
                'torrent_id' => $torrent_id,
                'ip' => $ip
            ]);
            return $descargas->save();
        }

        return false;
    }

    /**
     * Recibe el "id" del torrent sobre el que obtener el número de descargas.
     * Devuelve el número de descargas para el torrent solicitado.
     *
     * @param $id Identificador del torrent
     *
     * @return false|string
     */
    public function actionObtenerdescargas($id)
    {
        $descargas = Descargas::find()->where(['torrent_id' => $id])->count();
        print_r(json_encode($descargas));
    }

    /**
     * Elimina un comentario.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionEliminarcommentario($id)
    {
        $model = Comment::findOne($id);

        if (Roles::isAdmin() || (Yii::$app->user->id == $model->createdBy)) {
            $model->delete();
            return $this->redirect(Yii::$app->request->referrer ?: Yii::$app->homeUrl);
        }

        return false;
    }
}
