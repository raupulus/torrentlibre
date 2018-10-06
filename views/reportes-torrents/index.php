<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ReportesTorrentsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Reportes Torrents';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="reportes-torrents-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Reportes Torrents', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'usuario_id',
            'torrent_id',
            'ip',
            'titulo',
            //'resumen',
            //'comunicado:boolean',
            //'created_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
