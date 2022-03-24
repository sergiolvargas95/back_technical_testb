<?php

namespace app\controllers;

use yii\rest\ActiveController;
use yii\helpers\ArrayHelper;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\AccessControl;
use Yii;

use app\models\Shopping;




class ApishoppingController extends ActiveController {

    public function behaviors() {
        return ArrayHelper::merge(parent::behaviors(), [
            'authenticator' => [
                'class' => HttpBasicAuth::className(),
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'view', 'create', 'delete', 'update', 'cart'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ]);
    }

    public function actions() {
        $actions = parent::actions();
        unset($actions['create']);
        return $actions;
    }

    public function actionCreate() {
        $shopping = new Shopping();
        $shopping->attributes = \yii::$app->request->post();
        $shopping->idUser = Yii::$app->user->id;
        $shopping->save();
        return $shopping;

        /*$attributes = \yii::$app->request->post();
        $shopping = \app\models\Shopping::find();
        $shopping->attributes = \yii::$app->request->post(); attributes[]
        $shopping->idUser = Yii::$app->user->id;
        $shopping->save();
        return $shopping;*/
    }

    public $modelClass = 'app\models\Shopping';
}