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
 * @property string $password_hash
 * @property string|null $password_reset_token
 * @property int $created_at
 * @property int $updated_at
 * @property int $status
 * @property int $role
 * @property string|null $verification_token
 *
 * @property Order[] $orders
 */
class Register extends \yii\db\ActiveRecord
{
    const STATUS_DELETED = 0;
    const STATUS_INACTIVE = 9;
    const STATUS_ACTIVE = 10;
    const ADMIN = 1;
    const MANAGER = 2;
    const DELIVERY_PERSON = 3;
    const SIMPLE_USER = 4;
    public $password;
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
            [['name', 'lastName', 'username', 'email', 'address', 'phone'], 'required'],
            [['phone', 'created_at', 'updated_at', 'status', 'role'], 'integer', 'min' => 1],
            [['name', 'lastName', 'username'], 'string', 'max' => 20],
            [['email'], 'string', 'max' => 40],
            [['address'], 'string', 'max' => 30],
            [['auth_key'], 'string', 'max' => 32],
            [['password_hash', 'password_reset_token', 'verification_token'], 'string', 'max' => 255],
            [['email'], 'email'],
            [['email', 'username'], 'unique'],
            [['name', 'lastName', 'username', 'email', 'address', 'phone'], 'trim'],
            [['password_reset_token'], 'unique'],

            ['password', 'required'],
            ['password', 'string', 'min' => 8],

            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE, self::STATUS_DELETED]],
            ['role', 'default', 'value' => self::SIMPLE_USER],
            ['role', 'in', 'range' => [self::SIMPLE_USER, self::DELIVERY_PERSON, self::MANAGER, self::ADMIN]],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'lastName' => Yii::t('app', 'Last Name'),
            'username' => Yii::t('app', 'Username'),
            'email' => Yii::t('app', 'Email'),
            'address' => Yii::t('app', 'Address'),
            'phone' => Yii::t('app', 'Phone'),
            'auth_key' => Yii::t('app', 'Auth Key'),
            'password_hash' => Yii::t('app', 'Password Hash'),
            'password_reset_token' => Yii::t('app', 'Password Reset Token'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'status' => Yii::t('app', 'Status'),
            'role' => Yii::t('app', 'Role'),
            'verification_token' => Yii::t('app', 'Verification Token'),
        ];
    }

    /**
     * Gets query for [[Orders]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Order::class, ['idUser' => 'id']);
    }

    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }


    public function beforeSave($insert) {
        $this->generateAuthKey();
        $this->setPassword($this->password);//This sets the password_hash generated from the user password.
        $this->created_at = date("Ymd");
        $this->updated_at = date("Ymd");
        return true;
    }
}
