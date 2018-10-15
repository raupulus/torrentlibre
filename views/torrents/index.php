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
?>
<div class="torrents-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Añadir un torrent', ['create'], ['class' => 'btn 
    btn-primary']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
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
            'licencia.tipo:text:Licencia',
            'categoria.nombre:text:Categoría',
            'usuario.nick:text:Uploader',
            //'resumen',
            //'descripcion',
            //'imagen',
            //'hash',
            'size:shortSize',
            //'n_piezas',
            //'size_piezas',
            //'archivos',
            //'password',
            'created_at:datetime',
            //'torrentcreate_at',
            //'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
