<?php

namespace app\controllers;

use yii\rest\ActiveController;


class ApiorderController extends ActiveController {
    public function actions() {
        $actions = parent::actions();
        unset($actions['index'], $actions['update']);
        return $actions;
    }

    public function actionIndex($id) {
        //fetch all user order history
        $query = \app\models\Orders::find();
        $query->where("idUser=".$id);
        return $query->all();
    }

    public function actionGetall($id) {
        //fetch all user orders that are on hold to the manager
        $query = \app\models\Orders::find();
        $query->andWhere("idUser=".$id);
        $query->andWhere("status_request=3");
        return $query->all();
    }

    public function actionShipments($username) {
        //fetch all the orders waiting for the courier
        $query = \app\models\Orders::find();
        $query->andwhere("messenger="."'".$username."'");
        $query->andWhere("status_request=1");
        return $query->all();
    }

    //UPDATE
    public function actionDelivery() {
        $attributes = \yii::$app->request->post();
        $orders = \app\models\Orders::find()
        ->where(['idOrder' => $attributes['id']])->one();
        $orders->attributes = \yii::$app->request->post();
        $orders->save();
        return $orders;
    }

    public function actionCancel() {
        $attributes = \yii::$app->request->post();
        $orders = \app\models\Orders::find()
        ->where(['idOrder' => $attributes['id']])->one();
        $orders->attributes = \yii::$app->request->post();
        $orders->save();
        return $orders;
    }

    public $modelClass = 'app\models\Orders';
}