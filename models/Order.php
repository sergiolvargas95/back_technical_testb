<?php

namespace backend\models;
use yii;
use yii\db\Query;

class Order {
    public function getdb() {
        return Yii::$app->db;
    }

    public function getData() {
        $consulta = $query->select(['id', 'name'])->from('user')->where(['id' => 1]);

        var_dump($consulta);
    }
}