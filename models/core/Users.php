<?php

namespace app\models\core;

use Yii;
use yii\web\HttpException;

class Users extends \app\models\Users implements \yii\web\IdentityInterface {
    public $authKey;

    public function getName() {
        return $this->secondname . ' ' . $this->firstname . ($this->thirdname ? (' ' . $this->thirdname) : '');
    }

    public function getShortName() {
        return $this->secondname . ' ' . mb_substr($this->firstname, 0, 1) .'.'. ($this->thirdname ? (' ' . mb_substr($this->thirdname, 0, 1) . '.') : '');
    }

    public static function findByUsername($login) {
        return static::findOne(['username' => $login]);
    }

    public static function findIdentity($id) {
        return static::findOne(['id' => $id]);
    }

    public static function findIdentityByAccessToken($token, $type = null) {
        return static::findOne(['access_token' => $token]);
    }

    public function getId() {
        return $this->id;
    }

    public function getAuthKey() {
        return $this->authKey;
    }

    public function validateAuthKey($authKey) {
        return $this->authKey === $authKey;
    }

    public static function initDbSession() {
        if (Yii::$app->user->identity) Yii::$app->db->createCommand('SET session local.userid = "'. Yii::$app->user->identity->id .'"')->execute();
        else Yii::$app->db->createCommand('SET session local.userid = "3"')->execute();
    }
}