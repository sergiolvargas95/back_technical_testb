<?php

namespace app\models;

use Yii;
use yii\db\Query;

/**
 * This is the model class for table "orders".
 *
 * @property int $idOrder
 * @property int $status_request
 * @property int $status_distribution
 * @property string|null $purchased_products
 * @property int $totalPrice
 * @property int $idUser
 *
 * @property NewUser $idUser0
 */
class Orders extends \yii\db\ActiveRecord
{
    const STATUS_IN_PROGRESS = 1;
    const STATUS_DISPATCHED = 2;
    const STATUS_RECEIVED = 3;
    const STATUS_RETURNED = 4;
    const STATUS_CANCELLED = 0;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'orders';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['totalPrice', 'idUser', 'purchased_products'], 'required'],
            [['status_request', 'totalPrice', 'idUser'], 'integer', 'min' => 1],
            [['purchased_products', 'messenger'], 'string'],
            [['idUser'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['idUser' => 'id']],
            ['status_request', 'default', 'value' => self::STATUS_IN_PROGRESS],
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
            'purchased_products' => Yii::t('app', 'Purchased Products'),
            'totalPrice' => Yii::t('app', 'Total Price'),
            'idUser' => Yii::t('app', 'Id User'),
            'messenger' => Yii::t('app', 'Messenger'),
        ];
    }

    /**
     * Gets query for [[IdUser0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdUser0()
    {
        return $this->hasOne(User::className(), ['id' => 'idUser']);
    }

    public function deleteShopping($idUser)
    {
        Yii::$app->db->createCommand()->delete('shopping_car', 'idUser = :idUser', [':idUser' => $idUser])->execute();
    }

    public function getData($idUser) {
        //send all the products in the shopping cart to the order
        $query = new Query;
        $consult = array();

        $query->select(['product.idProduct', 'product.title', 'product.description', 'product.unitValue'])
            ->from('product')
            ->innerJoin('shopping_car', 'product.idProduct = shopping_car.idProduct')
            ->where(['shopping_car.idUser' => $idUser]);
            $consult = $query->all();
            $this->deleteShopping($idUser);
            return $consult;
    }


    public function Getrole($id) {
        //get the user's role
        $query = new Query;
        $userRole = 0;
        $query->select('new_user.role')
            ->from('new_user')
            ->where(['new_user.id' => $id]);
            $userRole = $query->all();
            return $userRole;
    }

    public function getDeliveryPerson() {
        //get the user's role
        $query = new Query;
        $deliveries = 0;
        $query->select(['new_user.username'])
            ->from('new_user')
            ->where(['new_user.role' => 2]);
            $deliveries = $query->all();
            return $deliveries;
    }
}
