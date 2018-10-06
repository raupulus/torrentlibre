<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Torrents */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="torrents-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'licencia_id')->textInput() ?>

    <?= $form->field($model, 'categoria_id')->textInput() ?>

    <?= $form->field($model, 'usuario_id')->textInput() ?>

    <?= $form->field($model, 'titulo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'resumen')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'descripcion')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'imagen')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'file')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'size')->textInput() ?>

    <?= $form->field($model, 'magnet')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'md5')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'n_descargas')->textInput() ?>

    <?= $form->field($model, 'n_visitas')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
