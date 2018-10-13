<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\UsuariosSearch */
/* @var $form yii\widgets\ActiveForm */

if (!Yii::$app->user->isGuest) {
    $rol = Yii::$app->user->identity->rol;
} else {
    return;
}
?>

<div id="box-form-search"
     class="text-center usuarios-search container center-block">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'id' => 'form-search-users-index',
    ]); ?>

    <div class="row col-sm-4 center-block">
        <?= $form->field($model, 'nick') ?>
    </div>

    <?php if ($rol === 'admin'): ?>
        <div class="row col-sm-4 center-block">
            <?= $form->field($model, 'email') ?>
        </div>

        <div class="row col-sm-4 center-block">
            <?= $form->field($model, 'id') ?>
        </div>
    <?php endif ?>



    <!-- IP -->
    <!-- ROL -->
</div>

<div id="box-form-button-search" class="container col-sm-12 center-block">
    <div class="col-sm-6 text-right center-block">
        <?= Html::submitButton(Yii::t('forms', 'search'), [
            'class' => 'btn btn-primary'
        ]) ?>
    </div>

    <div class="col-sm-6 text-left center-block">
        <?= Html::button(Yii::t('forms', 'clear'), [
            'id' => 'form-btn-clear',
            'class' => 'btn btn-danger',
        ]) ?>
    </div>
</div>

<?php ActiveForm::end(); ?>
