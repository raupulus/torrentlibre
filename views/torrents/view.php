<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\assets\TorrentsViewAsset;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Torrents */

// Registro assets para esta vista
TorrentsViewAsset::register($this);

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Torrents', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="torrents-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            'titulo',

            [
                'attribute' => 'imagen',
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
            'licencia_id',
            'categoria_id',
            'usuario_id',
            'resumen',
            'descripcion',
            'imagen',
            'hash',
            'size',
            'n_piezas',
            'size_piezas',
            'archivos',
            'password',
            'created_at',
            'torrentcreate_at',
            'updated_at',
        ],
    ]) ?>

</div>
