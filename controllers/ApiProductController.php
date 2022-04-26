<?php

namespace app\controllers;

use yii\rest\ActiveController;
use yii\filters\auth\HttpBasicAuth;

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

public $modelClass = 'app\models\Product';
}