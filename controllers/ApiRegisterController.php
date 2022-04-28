<?php

namespace app\controllers;

use yii\rest\ActiveController;
use yii\filters\auth\HttpBasicAuth;



class ApiregisterController extends ActiveController {
    public $modelClass = 'app\models\Register';

    public function behaviors()

    {
    
        $behaviors = parent::behaviors();
    
    
    
        // add CORS filter
    
        $behaviors['corsFilter'] = [
    
            'class' => \yii\filters\Cors::class,
    
        ];
    
    
    
    
        return $behaviors;
    
    }
}