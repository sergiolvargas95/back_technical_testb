<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Shopping */

$this->title = Yii::t('app', 'Update Shopping: {name}', [
    'name' => $model->idShopping,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Shoppings'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idShopping, 'url' => ['view', 'idShopping' => $model->idShopping]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="shopping-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
