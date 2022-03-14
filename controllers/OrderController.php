<?php

namespace app\controllers;

use yii;
use yii\filters\AccessController;
use yii\web\Controller;

use app\models\Order;

class OrderController extends Controller {
    public function actionOrder() {
        $model = new Order();

        $products = $model->getData(Yii::$app->user->id);
        $total = 0;
        foreach ($products as $product) {
            $total += $product['unitValue'];
        }
        $model->totalPrice = $total;
        $model->status_request = 1;
        $model->status_distribution = 1;
        $model->save();
        return $this->render('order', ['model' => $total]);
    }
}
