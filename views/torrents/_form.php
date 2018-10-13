<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Torrents */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="torrents-form container">
    <?php $form = ActiveForm::begin(); ?>

    <div class="row col-sm-12">
        <div class="row col-sm-6">
            <?= $form->field($model, 'titulo')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>
        </div>

        <div class="row col-sm-6">
            <?= $form->field($model, 'licencia_id')->dropDownList($licencias) ?>
            <?= $form->field($model, 'categoria_id')->dropDownList($categorias) ?>
        </div>
    </div>

    <div class="row col-sm-12">
        <?= $form->field($model, 'resumen')->textarea(['maxlength' => true]) ?>
    </div>

    <div class="row col-sm-12">
        <?= $form->field($model, 'u_img')->fileInput() ?>
        <?= $form->field($model, 'u_torrent')->fileInput() ?>
    </div>

    <div class="row col-sm-12">
        <?= $form->field($model, 'descripcion')->textarea(['maxlength' => true]) ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Subir', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
