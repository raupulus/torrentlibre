<?php

use app\helpers\Roles;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ReportesTorrentsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Reportes Torrents';
$this->params['breadcrumbs'][] = $this->title;

$isAdmin = Roles::isAdmin();

$columns = [
    [
        'attribute' => 'torrent.titulo',
        'label' => 'Torrent',
        'format' => 'raw',
            'value' => function($model) {
                return Html::a($model->torrent->titulo, [
                    Url::to('/torrents/view'),
                    'id' => $model->torrent_id
                ]);
            }
    ],
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
    'titulo',
    'resumen',
    'created_at:datetime:Fecha',
];

if ($isAdmin) {
    array_push($columns, 'ip');

    $res = [
        'format' => 'raw',
        'label' => false,
        'value' => function($model) {
            $btn1 = Html::a('Eliminar Torrent', [
                            '/torrents/eliminar', 'id' => $model->torrent_id
            ], [
                'class' => 'btn btn-warning btn-sm',
                'data' => [
                    'confirm' => '¿Seguro que quieres eliminar este torrent?',
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
<div class="reportes-torrents-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => $columns,
    ]); ?>
</div>
