<?php

namespace app\models;

use Yii;
use yii\db\Query;

/**
 * This is the model class for table "order".
 *
 * @property int $idOrder
 * @property int $status_request
 * @property int $status_distribution
 * @property string|null $date
 * @property string|null $request_time
 * @property string|null $delivery_time
 * @property int|null $totalPrice
 */
class Order extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'order';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status_request', 'status_distribution'], 'required'],
            [['status_request', 'status_distribution', 'totalPrice'], 'integer'],
            [['date', 'request_time', 'delivery_time'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idOrder' => Yii::t('app', 'Id Order'),
            'status_request' => Yii::t('app', 'Status Request'),
            'status_distribution' => Yii::t('app', 'Status Distribution'),
            'date' => Yii::t('app', 'Date'),
            'request_time' => Yii::t('app', 'Request Time'),
            'delivery_time' => Yii::t('app', 'Delivery Time'),
            'totalPrice' => Yii::t('app', 'Total Price'),
        ];
    }

    public function getData($idUser) {
        $query = new Query;
        $consult = array();

        $query->select(['product.idProduct', 'product.title', 'product.description', 'product.unitValue'])
            ->from('product')
            ->innerJoin('shopping_car', 'product.idProduct = shopping_car.idProduct')
            ->where(['shopping_car.idUser' => $idUser]);
            $consult = $query->all();
            return $consult;
    }

}
