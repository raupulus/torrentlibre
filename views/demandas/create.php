<?php

use app\assets\DemandasCreateAsset;
use yii\helpers\Html;

DemandasCreateAsset::register($this);

/* @var $this yii\web\View */
/* @var $model app\models\Demandas */

$this->title = 'Nueva Demanda';
$this->params['breadcrumbs'][] = ['label' => 'Demandas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="demandas-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
