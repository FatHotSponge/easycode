<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class User extends \yii\db\ActiveRecord implements IdentityInterface
{
    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return self::find()->where(['id' => $id])->one();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    public static function findByEmail($email) {
        return self::find()->where(['email' => $email])->one();
    }

    /**
     * Validates password
     *
     * @param  string  $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password === $password;
    }

    public static function findIdentityByAccessToken($token, $type = null) {

    }

    public function getAuthKey() {

    }

    public function validateAuthKey($authKey) {

    }
}
