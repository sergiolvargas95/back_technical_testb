<?php

namespace app\controllers;

use yii\rest\ActiveController;
use yii\db\Query;
use Yii;
use app\models\Orders;
use yii\helpers\ArrayHelper;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\AccessControl;

class ApiorderController extends ActiveController {
    const STATUS_IN_PROGRESS = 1;
    const STATUS_DISPATCHED = 2;
    const STATUS_ON_WAY = 3;
    const STATUS_RECEIVED = 4;
    const STATUS_RETURNED = 5;
    const STATUS_CANCELLED = 6;

    public function behaviors() {
        return ArrayHelper::merge(parent::behaviors(), [
            'authenticator' => [
                'class' => HttpBasicAuth::className(),
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'view', 'create', 'delete', 'update', 'getall', 'shipments', 'delivery', 'cancel', 'update-status', 'returned', 'new-order'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ]);
    }

    public function actions() {
        $actions = parent::actions();
        unset($actions['index'], $actions['update']);
        return $actions;
    }

    public function actionIndex() {
        //fetch all user order history
        $query = \app\models\Orders::find();
        $query->where("idUser=".Yii::$app->user->id);
        //$query->andWhere("status_request=".self::STATUS_RECEIVED);
        return $query->all();
    }

    public function actionGetall() {
        //fetch all user orders that are on hold to the manager
        $user = new Query;
        $userRole = 0;
        $user->select('new_user.role')
            ->from('new_user')
            ->where(['new_user.id' => Yii::$app->user->id]);
            $userRole = $user->all();
        $roleUser = 0;
        foreach($userRole as $role) {
            $roleUser += $role['role'];
        }
        if($roleUser == 1) {
            $query = \app\models\Orders::find();
            return $query->all();
        } else {
            return array('status' => false, 'data'=> 'the query could not be done successfully');
        }
    }

    public function actionShipments() {
        $user = new Query;
        $userRole = 0;
        $user->select(['new_user.role', 'new_user.username'])
            ->from('new_user')
            ->where(['new_user.id' => Yii::$app->user->id]);
            $userRole = $user->all();
        $roleUser = 0;
        $userName = array();
        foreach($userRole as $role) {
            $roleUser += $role['role'];
            $userName = $role['username'];
        }
        if($roleUser == 2) {
            //fetch all the orders waiting for the courier
            $query = \app\models\Orders::find();
            $query->andwhere("messenger="."'".$userName."'");
            $query->andWhere("status_request=".self::STATUS_DISPATCHED);
            return $query->all();
        } else {
            return array('status' => false, 'data'=> 'the query could not be done successfully');
        }
    }

    //UPDATE
    public function actionDelivery() {
        $user = new Query;
        $userRole = 0;
        $user->select('new_user.role')
            ->from('new_user')
            ->where(['new_user.id' => Yii::$app->user->id]);
            $userRole = $user->all();
        $roleUser = 0;
        foreach($userRole as $role) {
            $roleUser += $role['role'];
        }
        if($roleUser == 2) {
            $attributes = \yii::$app->request->post();
            $orders = \app\models\Orders::find()
            ->where(['idOrder' => $attributes['idOrder']])->one();
            if($orders->status_request == self::STATUS_ON_WAY) {
                $orders->status_request = 4;
                $orders->save();
                return $orders;
            } else {
                return array('status' => false, 'data'=> 'Order record is NOT updated successfully');
            }
        }
    }

    public function actionCancel() {
        $user = new Query;
        $userRole = 0;
        $user->select('new_user.role')
            ->from('new_user')
            ->where(['new_user.id' => Yii::$app->user->id]);
            $userRole = $user->all();
        $roleUser = 0;
        foreach($userRole as $role) {
            $roleUser += $role['role'];
        }
        if($roleUser == 4 || $roleUser == 1) {
            $attributes = \yii::$app->request->post();
            $orders = \app\models\Orders::find()
            ->where(['idOrder' => $attributes['idOrder']])->one();
            if($orders->status_request == self::STATUS_IN_PROGRESS) {
                $orders->status_request = 6;
                $orders->save();
                return $orders;
            } else {
                return array('status' => false, 'data'=> 'Order record is NOT updated successfully');
            }
        }  else {
            return array('status' => false, 'data'=> 'you are not authorized to perform this action');
        }
    }

    public function actionUpdateStatus() {
        $user = new Query;
        $userRole = 0;
        $user->select('new_user.role')
            ->from('new_user')
            ->where(['new_user.id' => Yii::$app->user->id]);
            $userRole = $user->all();
        $roleUser = 0;
        foreach($userRole as $role) {
            $roleUser += $role['role'];
        }
        if($roleUser == 1) {
            $attributes = \yii::$app->request->post();
            $orders = \app\models\Orders::find()
            ->where(['idOrder' => $attributes['id']])->one();
            if($orders->status_request == self::STATUS_IN_PROGRESS) {
                $orders->attributes = \yii::$app->request->post();
                $orders->status_request = 2;
                $orders->save();
                return $orders;
            } else {
                return array('status' => false, 'data'=> 'Order record is NOT updated successfully');
            }
        }  else {
            return array('status' => false, 'data'=> 'you are not authorized to perform this action');
        }
    }

    public function actionReturned() {
        $user = new Query;
        $userRole = 0;
        $user->select('new_user.role')
            ->from('new_user')
            ->where(['new_user.id' => Yii::$app->user->id]);
            $userRole = $user->all();
        $roleUser = 0;
        foreach($userRole as $role) {
            $roleUser += $role['role'];
        }
        if($roleUser == 2) {
            $attributes = \yii::$app->request->post();
            $orders = \app\models\Orders::find()
            ->where(['idOrder' => $attributes['idOrder']])->one();
            if($orders->status_request == self::STATUS_ON_WAY) {
                $orders->status_request = 5;
                $orders->save();
                return $orders;
            } else {
                return array('status' => false, 'data'=> 'Order record is NOT updated successfully');
            }
        } else {
            return array('status' => false, 'data'=> 'you are not authorized to perform this action');
        }
    }

    //---------------------------------------------------

    public function actionNewOrder() {
        $query = new Query;
        $model = new Orders();
        $products = array();

        $query->select(['product.idProduct', 'product.title', 'product.unitValue', 'shopping_car.quantity'])
            ->from('product')
            ->innerJoin('shopping_car', 'product.idProduct = shopping_car.idProduct')
            ->where(['shopping_car.idUser' => Yii::$app->user->id]);
            $products = $query->all();
            $total = 0;
        $productsName = array();
        $producsQuantities = array();
        foreach ($products as $product) {
            $productName = array();
            $quantity = array();
            $producsQuantities[$product['title']]=$product['quantity'];
            //$productName = $product['title'].'*('.strval($product['quantity'].')');
            $total += $product['unitValue']*$product['quantity'];
            //array_push($productsName, $productName);
        }
        $model->purchased_products = json_encode($producsQuantities);
        $model->totalPrice = $total;
        $model->idUser = Yii::$app->user->id;
        $model->save();
        Yii::$app->db->createCommand()->delete('shopping_car', 'idUser = :idUser', [':idUser' => Yii::$app->user->id])->execute();
        return $model;
    }

    public $modelClass = 'app\models\Orders';
}