<?php

namespace app\controllers;

use yii\rest\ActiveController;



class ApiRegisterController extends ActiveController {
    public $modelClass = 'app\models\SignupForm';
}