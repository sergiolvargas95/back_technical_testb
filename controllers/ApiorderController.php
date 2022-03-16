<?php

namespace app\controllers;

use yii\rest\ActiveController;



class ApiorderController extends ActiveController {
    public function actions() {
        $actions = parent::actions();
        unset($actions['index']);
        return $actions;
    }

    public function actionIndex($id) {
        $query = \app\models\Orders::find();
        $query->where("idUser=".$id);
        return $query->all();
    }

    public function actionGetall($id) {
        $query = \app\models\Orders::find();
        $query->andWhere("idUser=".$id);
        $query->andWhere("status_request=3");
        return $query->all();
    }

    public $modelClass = 'app\models\Orders';
}