<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TorrentsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="torrents-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?php // echo $form->field($model, 'id') ?>

    <?php // echo  $form->field($model, 'licencia_id') ?>

    <?php // echo  $form->field($model, 'categoria_id') ?>

    <?php // echo  $form->field($model, 'usuario_id') ?>

    <?php // echo  $form->field($model, 'titulo') ?>

    <?= $form->field($model, 'allfields')->label('Buscar:') ?>

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

    <div class="form-group">
        <?= Html::submitButton('Buscar', ['class' => 'btn btn-primary']) ?>
        <?php // Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
