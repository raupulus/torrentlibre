<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\DemandasSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="demandas-search container">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="row">
        <div class="col-sm-12 text-right">
            <?= $form->field($model, 'allfields') ?>
            <?= Html::submitButton('Buscar', ['class' => 'btn 
            btn-xs btn-primary']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
