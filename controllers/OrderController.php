<?php

namespace app\controllers;

use yii;
use yii\filters\AccessController;
use yii\web\Controller;

use app\models\Orders;

class OrderController extends Controller {
    //GET
    public function actionIndex($id) {
        //fetch all user order history
        $model = new Orders();
        $models = $model->findAll(['idUser' => $id]);
        \Yii::$app->response->format ='json';
        return $models;
    }

    //GET
    public function actionGetall() {
        //fetch all user orders that are on hold
        $model = new Orders();
        $roles = $model->Getrole(Yii::$app->user->id);
        $roleUser = 0;
        foreach($roles as $role) {
            $roleUser += $role['role'];
        }
        if($roleUser === 1) {
            $model = $model->findAll(['status_request' => 1]);
            \Yii::$app->response->format ='json';
            return $model;
        } else {
            return $this->redirect(['index']);
        }
    }
    //POST
    public function actionOrder($id) {
        //generate the order from the shopping cart
        $model = new Orders();

        $products = $model->getData(Yii::$app->user->id);
        $total = 0;
        $productsName = array();
        foreach ($products as $product) {
            $productName = array();
            $productName = $product['title'];
            $total += $product['unitValue'];
            array_push($productsName, $productName);
        }

        $deliveries = $model->getDeliveryPerson();
        $deliveriesName = array();
        foreach($deliveries as $delivery) {
            $deliveryUsername = array();

            $deliveryUsername = $delivery['username'];
            array_push($deliveriesName, $deliveryUsername);
        }

        $model->purchased_products = json_encode($productsName);
        $model->totalPrice = $total;
        $model->messenger = $deliveriesName[$id];
        $model->status_request = 1;
        $model->status_distribution = 1;
        $model->idUser = Yii::$app->user->id;
        $model->save();
        return $this->render('index', ['model' => $model]);
    }
    //UPDATE
    public function actionCancel($id)
    {
        //the user can cancel the order as long as it has not been dispatched
        $model = Orders::findOne(['idOrder' => $id]);
        if($model !== null && $model->status_request === 1) {
            $model->status_request = 0;
            $model->save();
            \Yii::$app->response->format ='json';
            return $model;
        } else {
            return $this->render('index', ['model' => $model]);
        }
    }

    //UPDATE
    public function actionUpdatestatus($id)
    {
        $model = Orders::findOne(['idOrder' => $id]);
        $models = new Orders();
        $roles = $models->Getrole(Yii::$app->user->id);

        $roleUser = 0;
        foreach($roles as $role) {
            $roleUser += $role['role'];
        }
        //the manager can change the status of the product to dispatched
        if($model !== null && $model->status_request != 0 && $roleUser === 1) {
            $model->status_request = 2;
            $model->save();
            \Yii::$app->response->format ='json';
            return $model;
        } else {
            return $this->redirect(['index']);
        }
    }
    //GET
    public function actionShipments($username) {
        $model = new Orders();
        $models = $model->findAll(['messenger' => $username]);
        $roles = $model->Getrole(Yii::$app->user->id);

        $roleUser = 0;
        foreach($roles as $role) {
            $roleUser += $role['role'];
        }
        if($roleUser === 2 && $models[3]->status_request === 1) {
            \Yii::$app->response->format ='json';
            return $models;
        } else {
            return $this->redirect(['index']);
        }
    }
    //UPDATE
    public function actionDelivered($id) {
        $model = Orders::findOne(['idOrder' => $id]);
        $roles = $model->Getrole(Yii::$app->user->id);
        $roleUser = 0;
        foreach($roles as $role) {
            $roleUser += $role['role'];
        }

        if($model !== null && $model->status_request === 2 && $roleUser === 2) {
            $model->status_request = 3;
            $model->save();
            \Yii::$app->response->format ='json';
            return $model;
        } else {
            return $this->render('index', ['model' => $model]);
        }
    }
}
