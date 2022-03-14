<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ShoppingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Shoppings');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="shopping-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Shopping'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'idShopping',
            'idProduct',
            'idUser',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action,  app\models\Shopping $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'idUser' => $model->idUser]);
                }
            ],
        ],
    ]); ?>


</div>
