<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Introduce tus credenciales:</p>

    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ]); ?>

    <?= $form->field($model, 'login')->textInput(['autofocus' => true]) ?>

    <?= $form->field($model, 'password')->passwordInput() ?>

    <?= $form->field($model, 'rememberMe')->checkbox([
        'template' => "<div class=\"col-lg-offset-1 col-lg-3\">{input} {label}</div>\n<div class=\"col-lg-8\">{error}</div>",
    ]) ?>

    <div class="form-group">
        <div class="col-lg-offset-1 col-lg-10">
            <?= Html::submitButton('Entrar', ['class' => 'btn btn-primary',
                'name' => 'login-button']) ?>
            <?= Html::a('Crear Cuenta', ['usuarios/create'], ['class' => '',
                'name' => 'Crear cuenta']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

    <div class="col-lg-offset-1" style="color:#999;">
        <p>Temporalmente los datos se borrarán cada cierto tiempo.</p>

        <p>
            Además están disponibles los siguientes <strong>usuarios</strong> para
            depuración:
        </p>

        <ul>
            <li>admin → Es el administrador, con la contraseña:
                <strong>admin</strong> y su correo:
                <strong>admin@admin.com</strong>.
            </li>

            <li>editor → Es un usuario moderador/editor, con la contraseña:
                <strong>1234</strong>.
            </li>

            <li>
                pepe → Es un usuario básico y la contraseña:
                <strong>1234</strong>.
            </li>
        </ul>
    </div>
</div>
