<?php

use app\helpers\Roles;
use yii\helpers\Html;
use yii\grid\GridView;
use app\assets\TorrentsIndexAsset;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TorrentsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

// Registro assets para esta vista
TorrentsIndexAsset::register($this);

$this->title = 'Torrents';
$this->params['breadcrumbs'][] = $this->title;

$isAdmin = Roles::isAdmin();
$isGuest = Yii::$app->user->isGuest;
?>
<div class="torrents-index">
    <?php if (!$isGuest): ?>
        <p>
            <?= Html::a('Añadir un torrent', ['create'],
                ['class' => 'btn btn-primary']) ?>
        </p>
    <?php endif ?>

    <h1><?= Html::encode($this->title) ?></h1>
    <?= $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'class' => 'grid-view',
        'showHeader' => false,
        //'showFooter' => false,
        'emptyCell' => 'N/D',
        'tableOptions' => [
            'class' => 'tablaTorrentsIndex',
        ],
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],
            //'id',
            [
                'attribute' => 'titulo',
                'format' => 'raw',
                'contentOptions' => ['class' => 'tabla-titulo'],
                //'headerOptions' => ['class' => 'titulo2'],
                'value' => function($model) {
                    return Html::a($model->titulo, [
                        Url::to('torrents/view'),
                        'id' => $model->id
                    ]);
                }
            ],
            [
                'attribute' => 'imagen',
                'format' => 'raw',
                'contentOptions' => ['class' => 'tabla-imagen'],
                'value' => function($model, $key, $index) {
                    $img = $model->imagen;
                    $ruta = yii::getAlias('@r_imgTorrent').'/';

                    if ((! isset($img)) || (! file_exists($ruta.$img))) {
                        $img = 'default.png';
                    }

                    $img = '<img src="'.$ruta.$img.'" />';
                    $link = Html::a($img, [
                        Url::to('torrents/view'),
                        'id' => $model->id
                    ]);

                    return $link;
                }
            ],
            [
                'attribute' => 'resumen',
                'contentOptions' => ['class' => 'tabla-resumen'],
            ],
            [
                'attribute' => 'licencia.tipo',
                'contentOptions' => ['class' => 'tabla-licencia'],
            ],
            [
                'attribute' => 'categoria.nombre',
                'contentOptions' => ['class' => 'tabla-categoria'],
            ],
            /*
            [
                'attribute' => 'usuario',
                'format' => 'raw',
                'contentOptions' => ['class' => 'tabla-nick'],
                'value' => function($model) {
                    return Html::a($model->usuario->datos->id0, [
                        Url::to('usuarios/view'),
                        'id' => $model->id
                    ]);
                }
            ],
            */
            'usuario.datos.nick',

            /*
            [
                'attribute' => 'n_descargas',
                'contentOptions' => ['class' => 'tabla-n_descargas'],
            ],
            */

            [
                'label' => 'Ficha del Torrent',
                'format' => 'raw',
                'contentOptions' => ['class' => 'tabla-vertorrent'],
                'value' => function($model) {
                    return Html::a('Ir a la ficha del Torrent', [
                        Url::to('torrents/view'),
                        'id' => $model->id
                    ]);
                }
            ],
            'size:shortSize',
            'created_at:date',
            [
                'label' => 'Subido el:',
                'format' => 'raw',
                'contentOptions' => ['class' => 'tabla-createdat'],
                'value' => function($model) {
                    return '<small class="torrentindexcreatedat">'.
                        'Subido el: '. Yii::$app->formatter
                            ->format($model->created_at, 'date') .
                        '</small>';
                }
            ],

            //'descripcion',
            //'imagen',
            //'hash',
            //'n_piezas',
            //'size_piezas',
            //'archivos',
            //'password',
            //'torrentcreate_at:date',
            //'updated_at:date',

            //['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
