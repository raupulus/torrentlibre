<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\ReportesTorrents */

$this->title = 'Create Reportes Torrents';
$this->params['breadcrumbs'][] = ['label' => 'Reportes Torrents', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="reportes-torrents-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
