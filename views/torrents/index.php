<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TorrentsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Torrents';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="torrents-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Torrents', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'licencia_id',
            'categoria_id',
            'usuario_id',
            'titulo',
            //'resumen',
            //'descripcion',
            //'imagen',
            //'file',
            //'size',
            //'magnet',
            //'password',
            //'md5',
            //'n_descargas',
            //'n_visitas',
            //'created_at',
            //'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
