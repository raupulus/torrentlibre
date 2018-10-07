<?php

/**
 * @author Raúl Caro Pastorino
 * @link https://fryntiz.es
 * @copyright Copyright (c) 2018 Raúl Caro Pastorino
 * @license https://www.gnu.org/licenses/gpl-3.0-standalone.html
 **/

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use juliardi\captcha\Captcha;

/* @var $this yii\web\View */
/* @var $model app\models\Usuarios */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="nav-form-usuario">
    <ul>
        <li data-seccion="datos-basicos" class="seccionactual">
            Datos básicos
        </li>
        <li data-seccion="datos-opcionales">Datos Opcionales</li>
        <li data-seccion="datos-sociales">Datos Sociales</li>
        <li data-seccion="datos-finalizar">Finalizar</li>
    </ul>
</div>

<div class="usuarios-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php // $form->field($model, 'id')->textInput() ?>

    <?php // $form->field($model, 'auth_key')->textInput(['maxlength' => true]) ?>

    <?php // $form->field($model, 'token')->textInput(['maxlength' => true]) ?>
    <?php // $form->field($model, 'lastlogin_at')->textInput() ?>

    <div id="datos-basicos" class="form-dividido">
        <h3>Datos Básicos</h3>

        <?= $form->field($model, 'nick')->textInput([
            'enableAjaxValidation' => true,
            'maxlength' => true]) ?>

        <?= $form->field($model, 'email')->textInput([
            'enableAjaxValidation' => true,
            'maxlength' => true]) ?>

        <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'password_repeat')->passwordInput(); ?>
    </div>

    <div id="datos-opcionales" class="form-dividido">
        <h3>Datos Opcionales</h3>
        <h4>Selecciona Avatar:</h4>
        <div id="avatar-selector" class="row">
            <div class="col-xs-3 col">
                <img src="/images/user-avatar/default.png"
                     data-name="default.png"
                     alt="Imagen de Avatar por defecto"
                     title="Imagen de Avatar por defecto" />
            </div>
            <div class="col-xs-3">
                <img src="/images/user-avatar/hippy.png"
                     data-name="hippy.png"
                     alt="Imagen de Avatar hippy"
                     title="Imagen de Avatar hippy" />
            </div>
            <div class="col-xs-3">
                <img src="/images/user-avatar/rey.png"
                     data-name="rey.png"
                     alt="Imagen de Avatar rey"
                     title="Imagen de Avatar rey" />
            </div>
            <div class="col-xs-3">
                <img src="/images/user-avatar/rockero.png"
                     data-name="rockero.png"
                     alt="Imagen de Avatar rockero"
                     title="Imagen de Avatar rockero" />
            </div>
        </div>

        <?= $form->field($model, 'avatar')
                 ->textInput(['maxlength' => true])
                 ->hiddenInput()
                 ->label(false)?>

        <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'biografia')->textInput(['maxlength' => true]) ?>
    </div>

    <div id="datos-sociales" class="form-dividido">
        <h3>Datos Sociales</h3>

        <?= $form->field($model, 'web')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'twitter')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'facebook')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'googleplus')->textInput(['maxlength' => true]) ?>
    </div>

    <!--
    <div id="datos-preferencias" class="form-dividido">
        <h3>Preferencias</h3>
        <?php // $form->field($model, 'preferencias_id')->textInput() ?>
    </div>
    -->

    <div id="datos-finalizar" class="form-dividido">
        <h3>¿No soy un Robot?</h3>
        <?php echo $form->field($model, 'captcha')->widget(Captcha::className()) ?>
    </div>

    <div class="form-group">
        <div class="btn-anterior-box">
            <?= Html::buttonInput('Anterior', [
                'id' => 'btn-form-usuarios-anterior',
                'class' => 'btn-form btn-anterior',
            ]); ?>
        </div>
        <div class="btn-siguiente-box">
            <?= Html::buttonInput('Siguiente', [
                'id' => 'btn-form-usuarios-siguiente',
                'class' => 'btn-form btn-siguiente'
            ]); ?>
        </div>
    </div>


    <div class="form-group">
        <div class="btn-confirmar-box">
            <?= Html::submitButton('Crear Cuenta', ['class' => 'btn-form 
            btn-confirmar']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
</div>
