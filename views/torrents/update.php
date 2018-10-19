<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Torrents */

$this->title = 'Modificar Torrent: ' . $model->titulo;
$this->params['breadcrumbs'][] = ['label' => 'Torrents', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->titulo, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="torrents-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'licencias' => $licencias,
        'categorias' => $categorias,
    ]) ?>

</div>
