<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "product".
 *
 * @property int $idProduct
 * @property string $title
 * @property string $description
 * @property string $image
 * @property int $unitValue
 *
 * @property OrderProduct[] $orderProducts
 * @property Order[] $orders
 */
class Product extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'description', 'image', 'unitValue'], 'required'],
            [['description'], 'string'],
            [['unitValue'], 'integer'],
            [['title'], 'string', 'max' => 20],
            [['image'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idProduct' => Yii::t('app', 'Id Product'),
            'title' => Yii::t('app', 'Title'),
            'description' => Yii::t('app', 'Description'),
            'image' => Yii::t('app', 'Image'),
            'unitValue' => Yii::t('app', 'Unit Value'),
        ];
    }

    /**
     * Gets query for [[OrderProducts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrderProducts()
    {
        return $this->hasMany(OrderProduct::className(), ['idProduct' => 'idProduct']);
    }

    /**
     * Gets query for [[Orders]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Order::className(), ['idProduct' => 'idProduct']);
    }
}
