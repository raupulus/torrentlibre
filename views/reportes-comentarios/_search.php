<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ReportesComentariosSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="reportes-comentarios-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'usuario_id') ?>

    <?= $form->field($model, 'comentario_id') ?>

    <?= $form->field($model, 'ip') ?>

    <?= $form->field($model, 'titulo') ?>

    <?php // echo $form->field($model, 'resumen') ?>

    <?php // echo $form->field($model, 'comunicado')->checkbox() ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
