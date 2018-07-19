<?php

namespace frontend\models;

use yii\base\Exception;
use yii\base\Model;
use common\models\User;
use yii\helpers\VarDumper;
use Yii;

/**
 * Signup form
 */
class SignupForm extends Model {
    public $username;
    public $email;
    public $password;


    /**
     * {@inheritdoc}
     */
    public function rules () {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     * @throws Exception
     */
    public function signup () {
        if (!$this->validate()) {
            return null;
        }
        /** @var User $user */
        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->created_at = time();
        $user->updated_at = time();
        $user->setPassword($this->password);
        $user->generateAuthKey();
        if (!$user->save()) {
            throw new Exception(Yii::t('frontend', 'Unable to save user!') . VarDumper::dumpAsString($user->getErrors()));
        }

        return $user;
    }
}
