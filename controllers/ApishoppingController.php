<?php

namespace app\controllers;

use yii\rest\ActiveController;
use yii\helpers\ArrayHelper;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\AccessControl;
use Yii;
use yii\db\Query;

use app\models\Shopping;




class ApishoppingController extends ActiveController {

    public function behaviors() {
        // return ArrayHelper::merge(parent::behaviors(), [
        //     'authenticator' => [
        //         'class' => HttpBasicAuth::className(),
        //     ],
        //     'access' => [
        //         'class' => AccessControl::className(),
        //         'rules' => [
        //             [
        //                 'actions' => ['index', 'view', 'create', 'delete', 'update', 'cart'],
        //                 'allow' => true,
        //                 'roles' => ['@'],
        //             ],
        //         ],
        //     ],
        // ]);

        $behaviors = parent::behaviors();
        // add CORS filter
        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::class,
        ];
        return $behaviors;
    }




    public function actions() {
        $actions = parent::actions();
        unset($actions['create']);
        return $actions;
    }

    public function actionCreate() {
        $shopping = new Shopping();
        $shopping->attributes = \yii::$app->request->post();
        //$shopping->idUser = $idUser;
        $shopping->save();
        return $shopping;

        /*$attributes = \yii::$app->request->post();
        $shopping = \app\models\Shopping::find();
        $shopping->attributes = \yii::$app->request->post(); attributes[]
        $shopping->idUser = Yii::$app->user->id;
        $shopping->save();
        return $shopping;*/
    }

    public function actionWatch($idUser) {
        $query = new Query;
        $consult = array();

        $query->select(['product.idProduct', 'product.title', 'product.description', 'product.unitValue', 'shopping_car.quantity', 'shopping_car.idShopping'])
            ->from('product')
            ->innerJoin('shopping_car', 'product.idProduct = shopping_car.idProduct')
            ->where(['shopping_car.idUser' => $idUser]);
            $consult = $query->all();
            return $consult;
    }

    public function actionErase($idUser)
    {
        Yii::$app->db->createCommand()->delete('shopping_car', 'idUser = :idUser', [':idUser' => $idUser])->execute();

    }

    public $modelClass = 'app\models\Shopping';
}