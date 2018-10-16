<?php

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

// Variables
if (!Yii::$app->user->isGuest) {
    $rol = Yii::$app->user->identity->rol;
}
?>
<div class="torrents-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php if (!Yii::$app->user->isGuest): ?>
        <p>
            <?= Html::a('Añadir un torrent', ['create'],
                            ['class' => 'btn btn-primary']) ?>
        </p>
    <?php endif ?>

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
            [
                'attribute' => 'usuario.nick',
                'format' => 'raw',
                'contentOptions' => ['class' => 'tabla-nick'],
                'value' => function($model) {
                    return Html::a($model->usuario->nick, [
                        Url::to('usuarios/view'),
                        'id' => $model->id
                    ]);
                }
            ],

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
