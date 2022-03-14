<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "shopping_car".
 *
 * @property int $idShopping
 * @property int $idProduct
 * @property int $idUser
 *
 * @property Product $idProduct0
 * @property NewUser $idUser0
 */
class Shopping extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'shopping_car';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idProduct', 'idUser'], 'required'],
            [['idProduct', 'idUser'], 'integer'],
            [['idProduct'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['idProduct' => 'idProduct']],
            [['idUser'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['idUser' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idShopping' => Yii::t('app', 'Id Shopping'),
            'idProduct' => Yii::t('app', 'Id Product'),
            'idUser' => Yii::t('app', 'Id User'),
        ];
    }

    /**
     * Gets query for [[IdProduct0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdProduct0()
    {
        return $this->hasOne(Product::className(), ['idProduct' => 'idProduct']);
    }

    /**
     * Gets query for [[IdUser0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdUser0()
    {
        return $this->hasOne(NewUser::className(), ['id' => 'idUser']);
    }
}
