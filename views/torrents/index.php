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
    <?php if (Roles::canUpload()): ?>
        <p>
            <?= Html::a('Añadir un torrent', ['create'],
                ['class' => 'btn btn-primary']) ?>
        </p>
    <?php endif ?>

    <h1><?= Html::encode($this->title) ?></h1>
    <?= $this->render('_search', [
        'model' => $searchModel,
        'categorias' => $categorias,
    ]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'id' => 'torrents-index-gridview',
        'class' => 'torrents-index-class',
        'summary' => false,  // Oculto total de elementos
        'showHeader' => false,
        //'showFooter' => false,
        'emptyCell' => 'N/D',
        'tableOptions' => [
            'class' => 'tablaTorrentsIndex',

        ],
        'pager' => [
            'class' => \kop\y2sp\ScrollPager::className(),
            'container' => '#torrents-index-gridview tbody',
            'item' => 'tr',
            'triggerOffset' => 1000,
            'negativeMargin' => 100,
            'delay'=>0,
            'spinnerSrc'=> yii::getAlias('@r_img').'/load-torrent.gif',
            'paginationSelector' => '.grid-view .pagination',
            'enabledExtensions'=> [
                \kop\y2sp\ScrollPager::EXTENSION_TRIGGER,
                \kop\y2sp\ScrollPager::EXTENSION_SPINNER,
                \kop\y2sp\ScrollPager::EXTENSION_NONE_LEFT,
                \kop\y2sp\ScrollPager::EXTENSION_PAGING
            ],
            //'triggerTemplate' => '<tr class="ias-trigger"><td  colspan="100%" style="text-align: center"><a style="cursor: pointer">{text}</a></td></tr>',
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
                'format' => 'raw',
                'contentOptions' => ['class' => 'tabla-licencia'],
                'value' => function($model, $key, $index) {
                    $img = $model->licencia->imagen;
                    $r_img = yii::getAlias('@r_imgLicencias').'/'.$img;

                    return '<a href="'.$model->licencia->url.'" target="_blank">'.
                        '<img src="'.$r_img.'" /></a>';
                }
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
            [
                'attribute' => 'usuario.datos.nick',
                'format' => 'raw',
                'contentOptions' => ['class' => 'tabla-nick'],
                'value' => function($model) {
                    return Html::a($model->usuario->datos->nombre, [
                        Url::to('usuarios/view'),
                        'id' => $model->usuario->datos_id
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

</div>
