<?php

use app\helpers\Roles;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ReportesComentariosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Reportes de Comentarios';
$this->params['breadcrumbs'][] = $this->title;

$isAdmin = Roles::isAdmin();

$columns = [
    [
        'attribute' => 'comentario.content',
        'label' => 'Comentario',
    ],
    'titulo:text:Motivo',
    'resumen',
    [
        'attribute' => 'usuario.datos.nick',
        'label' => 'Reportador',
        'format' => 'raw',
        'value' => function($model) {
            return Html::a($model->usuario->datos->nick, [
                Url::to('/usuarios/view'),
                'id' => $model->usuario_id
            ]);
        }
    ],
    'created_at:datetime:Fecha',
];

if ($isAdmin) {
    array_push($columns, 'ip');

    $res = [
        'format' => 'raw',
        'label' => false,
        'value' => function($model) {
            $btn1 = Html::a('Eliminar Comentario', [
                'torrents/eliminarcommentario',
                'id' => $model->comentario_id,
            ], [
                'class' => 'btn btn-warning btn-sm',
                'data' => [
                    'confirm' => '¿Seguro que quieres eliminar este comentario?',
                    'method' => 'post',
                ],
            ]);

            $btn2 = Html::a('Eliminar Reporte', ['delete', 'id' =>
                $model->id], [
                'class' => 'btn btn-info btn-sm',
                'data' => [
                    'confirm' => '¿Seguro que quieres eliminar este reporte?',
                    'method' => 'post',
                ],
            ]);

            return $btn1 . '<br /><br />' . $btn2;
        }
    ];

    array_push($columns, $res);
}

?>
<div class="reportes-comentarios-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => $columns,
        'pager' => [
            'class' => \kop\y2sp\ScrollPager::className(),
            'container' => '#torrents-index-gridview tbody',
            'item' => 'tr',
            'triggerOffset' => 1000,
            'negativeMargin' => 100,
            'delay'=>0,
            'spinnerSrc'=> '/'.yii::getAlias('@r_img').'/load-torrent.gif',
            'paginationSelector' => '.grid-view .pagination',
            'enabledExtensions'=> [
                \kop\y2sp\ScrollPager::EXTENSION_TRIGGER,
                \kop\y2sp\ScrollPager::EXTENSION_SPINNER,
                \kop\y2sp\ScrollPager::EXTENSION_NONE_LEFT,
                \kop\y2sp\ScrollPager::EXTENSION_PAGING
            ],
        ],
    ]); ?>
</div>

<style>
    .table {
        border: 0;
    }
    .ias-noneleft {
        color: #bfca02;
        font-weight: bolder;
    }
</style>
