<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TorrentsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="torrents-search container">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'allfields')->label('Buscar:') ?>
        </div>

        <div class="col-sm-6">
            <?= $form->field($model, 'categoria_id')->dropDownList($categorias) ?>
        </div>
    </div>


    <?php // echo $form->field($model, 'resumen') ?>

    <?php // echo $form->field($model, 'descripcion') ?>

    <?php // echo $form->field($model, 'imagen') ?>

    <?php // echo $form->field($model, 'hash') ?>

    <?php // echo $form->field($model, 'size') ?>

    <?php // echo $form->field($model, 'n_piezas') ?>

    <?php // echo $form->field($model, 'size_piezas') ?>

    <?php // echo $form->field($model, 'archivos') ?>

    <?php // echo $form->field($model, 'password') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'torrentcreate_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="row text-center">
        <?= Html::submitButton('Buscar', ['class' => 'btn btn-primary']) ?>
        <?php // Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
