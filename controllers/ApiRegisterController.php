<?php

namespace app\controllers;

use yii;
use yii\rest\ActiveController;
use yii\web\Controller;

use app\models\Register;

class ApiregisterController extends ActiveController {
    public function behaviors() {
    $behaviors = parent::behaviors();

    // add CORS filter
    $behaviors['corsFilter'] = [
        'class' => \yii\filters\Cors::class,
    ];
    return $behaviors;
    }

    public $password_hash_1;
    public $modelClass = 'app\models\Register';


    public function actionLogin($email, $password) {
        $model = new Register();
        $user = $model->findOne(['email' => $email]);

        if($user !== null) {
            $this->password_hash_1 = Yii::$app->security->validatePassword($password, $user->password_hash);

            if($user->email === $email && $this->password_hash_1 === true) {
                return $user;
            } else {
                return array('status' => false, 'data'=> 'usuario o contraseña incorrecto');
            }
        } else {
            return array('status' => false, 'data'=> 'usuario o contraseña incorrecto');
        }
    }
}