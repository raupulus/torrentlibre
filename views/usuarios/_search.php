<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\UsuariosSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="usuarios-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'nombre') ?>

    <?= $form->field($model, 'nick') ?>

    <?= $form->field($model, 'web') ?>

    <?= $form->field($model, 'biografia') ?>

    <?php // echo $form->field($model, 'email') ?>

    <?php // echo $form->field($model, 'twitter') ?>

    <?php // echo $form->field($model, 'facebook') ?>

    <?php // echo $form->field($model, 'googleplus') ?>

    <?php // echo $form->field($model, 'avatar') ?>

    <?php // echo $form->field($model, 'password') ?>

    <?php // echo $form->field($model, 'auth_key') ?>

    <?php // echo $form->field($model, 'token') ?>

    <?php // echo $form->field($model, 'lastlogin_at') ?>

    <?php // echo $form->field($model, 'preferencias_id') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('forms', 'search'), [
                'class' => 'btn btn-primary'
        ]) ?>
        <?= Html::resetButton(Yii::t('forms', 'reset'), [
                'class' => 'btn btn-default'
        ]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
