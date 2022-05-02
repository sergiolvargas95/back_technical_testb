<?php

namespace app\controllers;

use yii\rest\ActiveController;
use yii\filters\auth\HttpBasicAuth;
use Yii;
use yii\db\Query;

use app\models\Product;

class ApiproductController extends ActiveController {
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        // add CORS filter
        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::class,
        ];
        return $behaviors;
    }

    public function actionProduct() {
        $query = new Query;
        $consult = array();
        
        $consult= $query->from('product')->orderBy([
            'startDate' => SORT_DESC])->all();
        return $consult;
    }

public $modelClass = 'app\models\Product';
}