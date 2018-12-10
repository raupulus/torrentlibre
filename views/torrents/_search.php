<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TorrentsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="torrents-search container">
    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'allfields')->label('Buscar:') ?>
        </div>

        <div class="col-sm-6">
            <?= $form->field($model, 'categoria_id')->dropDownList($categorias) ?>
        </div>
    </div>

    <div class="row text-center">
        <?= Html::submitButton('Buscar', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
