<?php

namespace common\controllers;

use yii\filters\AccessControl;
use Yii;

class BaseController extends \yii\web\Controller
{

    /**
     * @inheritdoc
     * @return array
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['authenticator'] = [
            'class' => CompositeAuth::class,
            'authMethods' => [
                [
                    'class' => HttpBasicAuth::class,
                    'auth' =>
                        function ($username, $password) {
                            $user = Users::findIdentityByUsernamePassword($username, $password);

                            if (!isset($user)) {
                                return null;
                            }
                            return $user;
                        }
                ]
            ],

        ];

        /** @var array $only */
        $only = [];

        /** @var array $rules */
        $rules = [];

        // Alle verbs toevoegen
        if (method_exists($this, 'verbs')) {
            foreach ($this->verbs() as $verb) {
                $rules[] = [
                    'allow' => true,
                    'verbs' => [$verb]
                ];
            }
        }

        if (method_exists($this, 'actions')) {
            $only = $this->actions();
        }

        /** @var array $adminActions */
        $adminActions = [];

        if (method_exists($this, 'adminActions')) {
            $adminActions = $this->adminActions();
            $only = array_merge(
                $only,
                $adminActions
            );
        }

        /** @var array $guestActions */
        $guestActions = [];

        if (method_exists($this, 'guestActions')) {
            $guestActions = $this->guestActions();
            $only = array_merge(
                $only,
                $guestActions
            );
        }

        /** @var array $userActions */
        $userActions = $only;

        if ($guestActions && !empty($guestActions)) {
            $rules[] = [
                'allow' => true,
                'actions' => $guestActions,
                'roles' => ['?']
            ];
            foreach ($guestActions as $guestKey => $guestAction) {
                if (!isset($behaviors['authenticator']['except'])) {
                    $behaviors['authenticator']['except'] = [];
                }
                if (is_array($guestAction)) {
                    $guestAction = $guestKey;
                }
                $behaviors['authenticator']['except'][] = $guestAction;
                while (($key = array_search($guestAction, $userActions)) !== false) {
                    if (($key = array_search($guestAction, $userActions)) !== false) {
                        unset($userActions[$key]);//Verwijder de admin action uit de onlylijst
                    }
                }
                if (isset($userActions[$guestAction])) {
                    unset($userActions[$guestAction]);
                }
            }
        }

        if ($adminActions && !empty($adminActions)) {
            $rules[] = [
                'actions' => $adminActions,
                'allow' => true,
                'roles' => ['@'],
                'matchCallback' => function ($rule, $action) {
                    if (Yii::$app->user->isGuest) {
                        return false;
                    }
                    if (!method_exists(Yii::$app->user->identity, "isAdmin")) {
                        return false;
                    }
                    if (Yii::$app->user->identity->isAdmin()) {
                        return true;
                    }
                    return false;
                }
            ];
            foreach ($adminActions as $adminAction) {
                while (($key = array_search($adminAction, $userActions)) !== false) {
                    if (($key = array_search($adminAction, $userActions)) !== false) {
                        unset($userActions[$key]);//Verwijder de admin action uit de onlylijst
                    }
                }
            }
        }

        if ($userActions && !empty($userActions)) {
            $rules[] = [
                'allow' => true,
                'actions' => array_unique($userActions),
                'roles' => ['@']
            ];
        }

        foreach ($only as $key => $value) {
            if (is_array($value)) {
                $only[$key] = $key;
            }
        }

        foreach ($userActions as $key => $value) {
            if (is_array($value)) {
                $userActions[$key] = $key;
            }
        }

        $behaviors = array_merge(
            [
                'access' => [
                    'class' => AccessControl::class,
                    'only' => array_unique($only),
                    'rules' => $rules
                ]
            ],
            $behaviors
        );

        if (!isset($behaviors['verbs'])) {
            $behaviors['verbs'] = [
                'class' => \yii\filters\VerbFilter::class,
                'actions' => []
            ];
        }
        if (!isset($behaviors['verbs']['actions'])) {
            $behaviors['verbs']['actions'] = [];
        }
        $behaviors['verbs']['actions']['verb'] = array_unique($this->verbs());

        return $behaviors;
    }

    /**
     * @return array
     */
    public function verbs()
    {
        return [
            'GET'
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return array_merge(
            parent::actions(),
            [
                'error' => [
                    'class' => 'yii\web\ErrorAction',
                ],
                "index"
            ]
        );
    }

    /**
     * Guest actions
     * @return array
     */
    public function guestActions()
    {
        return [
            "error" => [
                'class' => 'yii\web\ErrorAction'
            ]
        ];
    }

    /**
     * This can be used to define disabled CSRF actions
     * @return array
     */
    protected function csrfDisabledActions()
    {
        return [];
    }

    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {
        if (in_array($action->id, array_unique($this->csrfDisabledActions()))) {
            $this->enableCsrfValidation = false;
        }
        return parent::beforeAction($action);
    }
}