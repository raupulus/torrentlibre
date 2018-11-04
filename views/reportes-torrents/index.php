<?php

use app\helpers\Roles;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ReportesTorrentsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Reportes Torrents';
$this->params['breadcrumbs'][] = $this->title;

$isAdmin = Roles::isAdmin();

$columns = [
    'torrent.titulo:text:Torrent',
    'usuario.datos.nick:text:Reportador',
    'ip',
    'titulo',
    'resumen',
    'created_at:datetime:Fecha',
];

if ($isAdmin) {
    $res = [
        'format' => 'raw',
        'label' => false,
        'value' => function($model) {
            $btn1 = Html::a('Eliminar Torrent', [
                            '/torrent/delete', 'id' => $model->torrent_id
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

            //return $btn1 . '<br /><br />' . $btn2;
            return $btn2;
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
