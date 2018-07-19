<?php

namespace frontend\controllers;

use frontend\models\User;
use Yii;
use yii\base\Exception;
use yii\base\InvalidParamException;
use yii\helpers\VarDumper;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use common\dao\AuthAssignment;

/**
 * Site controller
 */
class SiteController extends Controller {
    /**
     * {@inheritdoc}
     */
    public function behaviors () {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => [
                    'index',
                    'logout',
                    'signup'
                ],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions () {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex () {
        return $this->render('index');
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin () {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $this->layout = 'login';
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            //Set the cookie for the usersprofile image on loginpage
            Yii::$app->user->identity->setAvatarCookie();

            return $this->goBack();
        } else {
            $model->password = '';

            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     * @throws Exception
     */
    public function actionLogout () {
        /** @var User $user */
        $user = User::find()->where(['id' => Yii::$app->user->id])->one();
        if ($user) {
            $user->status = User::STATUS_ACTIVE;
            if (!$user->save()) {
                throw new Exception(Yii::t('frontend', 'Unable to save model!') . VarDumper::dumpAsString($user->getErrors()));
            }
        }
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Signs user up
     * @return mixed
     * @throws Exception
     */
    public function actionSignup () {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        /** @var SignupForm $model */
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                /** @var AuthAssignement $authAssignement */
                $authAssignement = new AuthAssignment();
                $authAssignement->item_name = 'player';
                $authAssignement->user_id = $user->id;
                $authAssignement->created_at = time();
                if (!$authAssignement->save()) {
                    throw new Exception(Yii::t('frontend', 'Unable to save authAssigment!') . VarDumper::dumpAsString($authAssignement->getErrors()));
                }
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            } else {
                throw new Exception(Yii::t('frontend', 'Unable to signup!') . VarDumper::dumpAsString($model->getErrors()));
            }
        }
        $this->layout = 'login';

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset () {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
            }
        }
        $this->layout = 'login';

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword ($token) {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }
        $this->layout = 'login';

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
}
