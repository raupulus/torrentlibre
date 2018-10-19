<?php

use app\helpers\Roles;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\UsuariosSearch */
/* @var $form yii\widgets\ActiveForm */

// Variables
$isAdmin = Roles::isAdmin();
?>

<div id="box-form-search"
     class="text-center usuarios-search container center-block">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'id' => 'form-search-users-index',
    ]); ?>

    <?php if ($isAdmin): ?>
        <?php $sizerow = '4' ?>
        <div class="row col-sm-<?=$sizerow?> center-block">
            <?= $form->field($model, 'email') ?>
        </div>

        <div class="row col-sm-<?=$sizerow?> center-block">
            <?= $form->field($model, 'id') ?>
        </div>

        <!-- IP -->
        <!-- ROL -->
    <?php else: ?>
        <?php $sizerow = '12' ?>
    <?php endif ?>

    <div class="row col-sm-<?=$sizerow?> center-block">
        <?= $form->field($model, 'nick') ?>
    </div>
</div>

<div id="box-form-button-search" class="container col-sm-12 center-block">
    <?php if ($isAdmin): ?>
        <?php $sizerow = '4' ?>
        <div class="col-sm-<?=$sizerow?> text-center center-block">
            <?= Html::a('Crear Usuario', ['usuarios/create'], [
                'class' => 'btn btn-success',
            ]); ?>
        </div>
    <?php else: ?>
        <?php $sizerow = '6' ?>
    <?php endif ?>

    <div class="col-sm-<?=$sizerow?> text-center center-block">
        <?= Html::submitButton(Yii::t('forms', 'search'), [
            'class' => 'btn btn-primary'
        ]) ?>
    </div>

    <div class="col-sm-<?=$sizerow?> text-center center-block">
        <?= Html::button(Yii::t('forms', 'clear'), [
            'id' => 'form-btn-clear',
            'class' => 'btn btn-danger',
        ]) ?>
    </div>
</div>

<?php ActiveForm::end(); ?>
