<?php

/**
 * @author Raúl Caro Pastorino
 * @link https://fryntiz.es
 * @copyright Copyright (c) 2018 Raúl Caro Pastorino
 * @license https://www.gnu.org/licenses/gpl-3.0-standalone.html
 **/

use function Composer\Autoload\includeFile;
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
            <?= Yii::t('usuarios-create', 'datos-basicos'); ?>
        </li>
        <li data-seccion="datos-opcionales">
            <?= Yii::t('usuarios-create', 'datos-opcionales'); ?>
        </li>
        <li data-seccion="datos-sociales">
            <?= Yii::t('usuarios-create', 'datos-sociales'); ?>
        </li>
        <li data-seccion="datos-finalizar">
            <?= Yii::t('usuarios-create', 'datos-finalizar'); ?>
        </li>
    </ul>
</div>

<div class="usuarios-form">

    <?php $form = ActiveForm::begin(); ?>

    <div id="datos-basicos" class="form-dividido">
        <h3><?= Yii::t('usuarios-create', 'datos-basicos'); ?></h3>

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
        <h3><?= Yii::t('usuarios-create', 'datos-opcionales'); ?></h3>
        <h4><?= Yii::t('usuarios-create', 'seleccionar-avatar'); ?></h4>
        <div id="avatar-selector" class="row">
            <?php require_once '_avatares.php'; ?>
        </div>

        <?= $form->field($model, 'avatar')
            ->textInput(['maxlength' => true])
            ->hiddenInput()
            ->label(false)?>

        <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'biografia')->textarea(['maxlength' => true]) ?>
    </div>

    <div id="datos-sociales" class="form-dividido">
        <h3><?= Yii::t('usuarios-create', 'datos-sociales'); ?></h3>

        <?= $form->field($model, 'web')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'twitter')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'facebook')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'googleplus')->textInput(['maxlength' => true]) ?>
    </div>

    <div id="datos-finalizar" class="form-dividido">
        <?php if ($model->scenario === 'create'): ?>
            <h3><?= Yii::t('usuarios-create', 'datos-finalizar'); ?></h3>
            <?= $form->field($model, 'captcha')->widget(Captcha::className()) ?>

            <?= $form->field($model, 'privacy')->checkbox([
                'label' => '',
                'template' => '{input}{beginLabel}{labelTitle}{endLabel}{error}',
            ])->label(
                'Yo acepto las ' . Html::a('Políticas de Privacidad',
                ['site/politicaprivacidad']) . ' del sitio web.'
            ) ?>

        <?php else: ?>
            <h3>Para guardar pulse el siguiente botón</h3>
            <?= Html::submitButton(Yii::t('forms', $model->scenario),
                [
                    'class' => 'btn btn-success center-block btn-guardar'
                ]) ?>
        <?php endif ?>

        <div class="row">
            <p>
                Puede leer las políticas y condiciones de uso para el sitio web en
                los siguientes enlaces:
            </p>

            <ul>
                <li><?= Html::a('Aviso Legal', ['site/avisolegal']) ?></li>
                <li><?= Html::a('Política de Privacidad',
                        ['site/politicaprivacidad']) ?></li>
                <li><?= Html::a('Política de Cookies', ['site/politicacookies']) ?></li>
            </ul>
        </div>
    </div>

    <div class="form-group">
        <div class="btn-anterior-box">
            <?= Html::buttonInput(Yii::t('forms', 'back'),
                [
                    'id' => 'btn-form-usuarios-anterior',
                    'class' => 'btn-form btn-anterior',
                ]); ?>
        </div>
        <div class="btn-siguiente-box">
            <?= Html::buttonInput(Yii::t('forms', 'next'),
                [
                    'id' => 'btn-form-usuarios-siguiente',
                    'class' => 'btn-form btn-siguiente'
                ]); ?>
        </div>
    </div>


    <div class="form-group">
        <div class="btn-confirmar-box">
            <?= Html::submitButton(Yii::t('forms', $model->scenario),
                [
                    'class' => 'btn-form btn-confirmar'
                ]) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
</div>
