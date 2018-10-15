<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\assets\TorrentsViewAsset;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Torrents */

// Registro assets para esta vista
TorrentsViewAsset::register($this);

$this->title = $model->titulo;
$this->params['breadcrumbs'][] = ['label' => 'Torrents', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="torrents-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'options' => [
            'id' => 'tabletorrentview',
            'class' => [
                'table',
                'table-striped',
                'table-bordered',
                'detail-view',
            ],
        ],
        'attributes' => [
            //'id',
            [
                'attribute' => 'imagen',
                'label' => false,
                'labelColOptions' => ['hidden' => true],
                'captionOptions' => ['class' => 'labelhidden'],
                'contentOptions' => [
                    'class' => [
                        'text-center',
                        'imagenportada',
                        'col-sm-6'
                    ],
                    'colspan' => 2,
                ],
                'format' => 'raw',
                'value' => function($model) {
                    $img = $model->imagen;
                    $ruta = Yii::$app->request->baseUrl . yii::getAlias('@r_imgTorrent').'/';

                    if ((! isset($img)) || (! file_exists($ruta.$img))) {
                        $img = 'default.png';
                    }

                    return '<img src="'.$ruta.$img.'" />';
                }
            ],
            [
                'attribute' => 'resumen',
                'label' => false,
                'labelColOptions' => ['hidden' => true],
                'captionOptions' => ['class' => 'labelhidden'],
                'contentOptions' => [
                    'class' => [
                        'resumen'
                    ],
                    'colspan' => 2,
                ],
            ],
            'licencia.tipo:text:Licencia',
            'categoria.nombre:text:Categoría',
            'usuario.nick:text:Uploader',
            'descripcion',
            [
                'format' => 'raw',
                'label' => false,
                'labelColOptions' => ['hidden' => true],
                'captionOptions' => ['class' => 'labelhidden'],
                'contentOptions' => [
                    'class' => [
                        'magnet',
                        'text-center',
                    ],
                    'colspan' => 2,
                ],
                'value' => function($model) {
                    $magnet = 'magnet:?xt=urn:btih:' . $model->hash;
                    $magnet .= '&dn='.urlencode($model->titulo);

                    $r = Html::img('/images/icons/magnet.png', [
                        'id' => 'copymagnet',
                        'alt' => 'Copy '.$model->titulo.' magnet to clipboard',
                        'title' => 'Copy '.$model->titulo.' magnet to clipboard',
                    ]);

                    $r .= '<a id="magnet" href='.$magnet.'>'.$magnet.'</a>';

                    $r .= Html::a('Descargar Torrent',
                        Url::to(['torrents/descargar',
                            'id' => $model->id,
                            'hash' => $model->hash,
                        ]),
                        [
                            'title' => 'Descargar '.$model->titulo,
                            'alt' => 'Descargar '.$model->titulo,
                            'class' => 'btn btn-success col-sm-12',
                        ]
                    );

                    return $r;
                }
            ],
            'size:shortSize',
            'n_piezas',
            'size_piezas:shortSize',
            'archivos',
            [
                'attribute' => 'password',
                'visible' => (!empty($model->password)),
            ],
            'created_at:datetime',
            'torrentcreate_at:datetime',
            'updated_at:datetime',
        ],
    ]) ?>

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
</div>
