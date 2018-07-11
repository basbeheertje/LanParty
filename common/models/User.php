<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\web\IdentityInterface;
use bedezign\yii2\audit\AuditTrailBehavior;
use yii\helpers\Url;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 *
 * @property Game[] $downloadedGames
 */
class User extends \common\dao\User implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;

    const AVATAR_COOKIENAME = "profileimage";

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            AuditTrailBehavior::class
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        $rules = parent::rules();
        $rules[] = ['status', 'default', 'value' => self::STATUS_ACTIVE];
        $rules[] = ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]];
        return $rules;
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by $email
     *
     * @param string $email
     * @return static|null
     */
    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int)substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    /**
     * @param bool $insert
     * @param array $changedAttributes
     * @return bool
     */
    public function afterSave($insert, $changedAttributes)
    {
        if (!parent::afterSave($insert, $changedAttributes)) {
            return false;
        }
        if ($this->isNewRecord) {
            $auth = \Yii::$app->authManager;
            $authorRole = $auth->getRole('player');
            $auth->assign($authorRole, $this->getId());
        }
        return true;
    }

    /**
     * Getter for avatarlink
     * @return string
     */
    public function getAvatarLink()
    {
        if (is_null($this->avatar)) {
            return Url::to('@web/images/') . 'profile.jpg';
        }
        return Url::to('@web' . $this->avatar);
    }

    /**
     * @return bool|\yii\web\Cookie
     */
    static public function getAvatarCookie()
    {
        /** @var yii\web\CookieCollection $cookies */
        $cookies = Yii::$app->request->cookies;
        if (($cookie = $cookies->get(self::AVATAR_COOKIENAME)) !== null) {
            return $cookie;
        }
        return false;
    }

    /**
     * @return bool
     */
    public function setAvatarCookie()
    {
        /** @var yii\web\CookieCollection $cookies */
        $cookies = Yii::$app->response->cookies;
        if (Yii::$app->user->isGuest) {
            return false;
        }
        if (!$this->avatar) {
            return false;
        }
        $cookies->add(new \yii\web\Cookie([
            'name' => self::AVATAR_COOKIENAME,
            'value' => $this->avatar,
        ]));
        return true;
    }

    /**
     * @return bool
     */
    static public function hasAvatarCookie()
    {
        /** @var yii\web\CookieCollection $cookies */
        $cookies = Yii::$app->request->cookies;
        if (($cookie = $cookies->get(self::AVATAR_COOKIENAME)) !== null) {
            return true;
        }
        return false;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDownloadedGames()
    {
        return $this->hasMany(TorrentDownload::className(), ['user_id' => 'id']);
    }
}
