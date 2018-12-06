<?php

use app\helpers\Access;
use app\helpers\Magnet2torrent;
use app\helpers\Roles;
use yii\helpers\Html;
use app\assets\TorrentsViewAsset;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Torrents */

// Registro assets para esta vista
TorrentsViewAsset::register($this);

$this->title = $model->titulo;
$this->params['breadcrumbs'][] = ['label' => 'Torrents', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

// Variables
$isAdmin = Roles::isAdmin();
$isAutor = Access::isAutor($model->usuario_id);

function imagen($model) {
    $img = $model->imagen;

    if ($model->imagen == '') {
        $img = Yii::$app->request->baseUrl . '/' .
            Yii::getAlias('@r_imgTorrent').'/default.png';
    }

    return '<img src="'.$img.'" alt="'.$model->titulo.'" class="imagen" />';
}

function licencia($model) {
    $img = $model->licencia->imagen;
    $r_img = '/'.yii::getAlias('@r_imgLicencias').'/'.$img;

    return '<a href="'.$model->licencia->url.'" target="_blank">'.
        '<img src="'.$r_img.'" class="licencia" /></a>';
}

function size($model) {
    return 'Tamaño:<br />' . Yii::$app->formatter->asShortSize($model->size);
}

function uploader($model) {
    return 'Uploader:<br />' . Html::a($model->usuario->datos->nick, [
        Url::to('usuarios/view'),
        'id' => $model->usuario->datos_id
    ]);
}

function resumen($model) {
    return $model->resumen;
}

function descargas($model) {
    return 'Descargado ' .
        '<span id="torrents-veces-descargado">' .
            $model->descargas .
        '</span>' .
        ' veces';
}

function categoria($model) {
    return 'Categoría: ' . $model->categoria->nombre;
}

function subido($model) {
    return 'Subido en ' . Yii::$app->formatter->asDatetime($model->created_at);
}

function contenido($model) {
    $archivos = explode(',', $model->archivos);
    $lista = '<ul class="listaArchivos">';
    foreach ($archivos as $archivo) {
        $lista .= '<li>'.$archivo.'</li>';
    }
    $lista .= '</ul>';

    return 'Contenido del torrent:<br />' . $lista;
}

function piezas($model) {
    return 'Piezas: ' . $model->n_piezas;
}

function piezasSize($model) {
    return 'Tamaño de Piezas: ' .
        Yii::$app->formatter->asShortSize($model->size_piezas);
}

function torrentCreacion($model) {
    return 'Creado en ' .
        Yii::$app->formatter->asDatetime($model->torrentcreate_at);
}

function descripcion($model) {
    return $model->descripcion;
}

function magnet($model) {
    $magnet = 'magnet:?xt=urn:btih:' . $model->hash;
    $magnet .= '&dn='.urlencode($model->titulo);

    $trackersArray = Magnet2torrent::trackers();
    $trackers = '';
    foreach ($trackersArray as $tracker) {
        $trackers .= '&tr=' . urlencode(trim($tracker));
    }

    $r = '<span id="copymagnet" class="btn btn-warning">' .
            Html::img('/images/icons/magnet.png', [
                'alt' => 'Copy '.$model->titulo.' magnet to clipboard',
                'title' => 'Copy '.$model->titulo.' magnet to clipboard',
            ]) .

            'Copiar al portapapeles' .
        '</span>'
    ;

    $r .= Html::a('Abrir magnet con tu programa de torrents',
        Url::to($magnet.$trackers),
        [
            'title' => 'Descargar Magnet',
            'alt' => 'Descargar Magnet',
            'id' => 'magnet',
            'class' => 'btn btn-primary'
        ]
    );

    $r .= Html::a('Descargar Torrent',
        Url::to(['torrents/descargar',
            'id' => $model->id,
        ]),
        [
            'title' => 'Descargar '.$model->titulo,
            'alt' => 'Descargar '.$model->titulo,
            'id' => 'btn-torrent-download',
            'class' => 'btn btn-success col-sm-12',
            'data-torrent_id' => $model->id,
            'download'
        ]
    );

    return $r;
}

function puntuacion($model) {
    $puntosUsuarioActual = $model->misPuntos;

    return '<p>Puntuación total: ' .
            '<span id="torrent-puntos" 
                   data-mispuntos="'.$puntosUsuarioActual.'">' .
                $model->puntos .
            '</span>/10
        </p>' .

        '<div class="torrentRating rating" data-rating-max="10" 
              data-torrent="' . $model->id . '"></div>';
}

function reportar($model) {
    if (Yii::$app->user->isGuest) {
        return '';
    }

    if ($model->estareportado) {
        return 'Ya has reportado este torrent';
    }

    return '
    <span id="reportar-terminado">El torrent ha sido reportado.</span>
    <span id="btn-reportar" class="btn btn-link">Reportar Torrent</span>
    <div id="box-reportes" data-torrent="'.$model->id.'">
        Título: <input type="text" id="reportar-titulo" />
        <br />
        Motivo: <input type="text" id="reportar-descripcion" />
        <br />
        <div id="btn-enviar-reporte" class="btn btn-warning">Enviar Reporte</div>
    </div>
    ';
}
?>

<div class="torrents-view container">

    <h1><?= Html::encode($this->title) ?></h1>

    <div id="torrents-view-box">
        <div class="row">
            <div class="text-center col-sm-6">
                <?= imagen($model) ?>
            </div>

            <div class="col-sm-6">
                <div class="row">
                    <div class="col-sm-4 text-center">
                        <?= licencia($model) ?>
                    </div>
                    <div class="col-sm-4 text-center">
                        <?= size($model) ?>
                    </div>
                    <div class="col-sm-4 text-center">
                        <?= uploader($model) ?>
                    </div>
                </div>

                <div class="row">
                    <?= resumen($model) ?>
                </div>

                <div class="lista row">
                    <?= contenido($model) ?>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-4">
                <?= descargas($model) ?>
            </div>

            <div class="col-sm-4">
                <?= categoria($model) ?>
            </div>

            <div class="col-sm-4">
                <?= subido($model) ?>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-4">
                <?= piezas($model) ?>
            </div>

            <div class="col-sm-4">
                <?= piezasSize($model) ?>
            </div>

            <div class="col-sm-4">
                <?= torrentCreacion($model) ?>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
                <div class="row">
                    <div class="col-sm-12">
                        Sembrando XXXXX
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        Sanguijuelas XXXXX
                    </div>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="row">
                    <div class="col-sm-12">
                        <?= puntuacion($model) ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <?= reportar($model) ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <?= descripcion($model) ?>
            </div>
        </div>

        <div class="row">
            <div class="magnet col-sm-12 text-center">
                <?= magnet($model) ?>
            </div>
        </div>

    </div>

    <?php if ($isAutor || $isAdmin): ?>
        <p>
            <?= Html::a('Modificar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>

            <?= Html::a('Eliminar', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => '¿Seguro que quieres eliminar este torrent?',
                    'method' => 'post',
                ],
            ]) ?>
        </p>
    <?php endif ?>
</div>

<?= \yii2mod\comments\widgets\Comment::widget([
    'model' => $model,
    'commentView' => '@app/views/torrents/comentarios/_index.php',
    'maxLevel' => 4,
    'dataProviderConfig' => [
        'pagination' => [
            'pageSize' => 10
        ],
    ],
    'listViewConfig' => [
        'emptyText' => 'No hay comentarios',
    ],
]); ?>

