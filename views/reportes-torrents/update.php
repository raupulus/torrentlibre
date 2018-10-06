<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ReportesTorrents */

$this->title = 'Update Reportes Torrents: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Reportes Torrents', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="reportes-torrents-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
