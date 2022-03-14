<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Shopping */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="shopping-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'idProduct')->textInput() ?>

    <?= $form->field($model, 'idUser')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
