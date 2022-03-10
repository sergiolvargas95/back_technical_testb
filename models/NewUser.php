<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "new_user".
 *
 * @property int $id
 * @property string $name
 * @property string $lastName
 * @property string $username
 * @property string $email
 * @property string $address
 * @property int $phone
 * @property string $auth_key
 * @property string $password
 *
 * @property Order[] $orders
 */
class NewUser extends \yii\db\ActiveRecord
{
    /**const ADMIN = 1;
    const MANAGER = 2;
    const DELIVERY_PERSON = 3;
    const SIMPLE_USER = 4;
    const STATUS_DELETED = 0;
    const STATUS_INACTIVE = 9;
    const STATUS_ACTIVE = 10;**/

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'new_user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'lastName', 'username', 'email', 'address', 'phone', 'auth_key', 'password'], 'required'],
            [['phone'], 'integer'],
            [['name', 'lastName', 'username'], 'string', 'max' => 20],
            [['email'], 'string', 'max' => 40],
            [['address'], 'string', 'max' => 30],
            [['password'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['email'], 'unique'],
            /**['role', 'default', 'value' => self::SIMPLE_USER],
            ['role', 'in', 'range' => [self::SIMPLE_USER, self::DELIVERY_PERSON, self::MANAGER, self::ADMIN]],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE, self::STATUS_DELETED]],*/
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Name',
            'lastName' => 'Last Name',
            'username' => 'Username',
            'email' => 'Email',
            'address' => 'Address',
            'phone' => 'Phone',
            'password' => 'Password',
            /**'status' => Yii::t('app', 'Status'),
            'role' => Yii::t('app', 'Role'),*/
        ];
    }

    /**
     * Gets query for [[Orders]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Order::className(), ['idUser' => 'id']);
    }
}
