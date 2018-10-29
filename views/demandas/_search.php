<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\DemandasSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="demandas-search container">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="row">
        <div class="col-sm-12 text-right">
            <?= $form->field($model, 'allfields') ?>
            <?= Html::submitButton('Buscar', ['class' => 'btn 
            btn-xs btn-primary']) ?>
        </div>
    </div>

    <div class="row">
        <!-- USAR ESTOS CAMPOS PARA PASAR AL MODELO DE BUSQUEDA COMO FILTRAR -->
        <?= $form->field($model, 'search_activas')
            ->hiddenInput(['id' => 'search_activas'])
            ->label(false) ?>

        <?= $form->field($model, 'search_encurso')
            ->hiddenInput(['id' => 'search_encurso'])
            ->label(false) ?>
    </div>

    <div class="row text-center">
        <button id="btn-search_activas" class="btn btn-warning btn-sm">
            Demandas Activas
        </button>

        <button id="btn-search_encurso" class="btn btn-warning btn-sm">
            Demandas en Curso
        </button>
    </div>

    <?php ActiveForm::end(); ?>

</div>
