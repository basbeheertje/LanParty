<?php

use yii\helpers\Html;
use macgyer\yii2materializecss\widgets\navigation\SideNav;
use yii\helpers\Url;

/** @var array $menuItems */
$menuItems = [];

if (!Yii::$app->user->isGuest) {
    $menuItems = [
        '<li><div class="user-view">
      <div class="background">
        <img src="/images/background.jpg"/>
      </div>
      <a href="' . Url::to(['/profile/avatar']) . '"><img class="circle" src="' . Yii::$app->user->identity->getAvatarLink() . '"></a>
      <a href="' . Url::to(['/profile/view', 'id' => Yii::$app->user->identity->id]) . '"><span class="white-text name">' . Yii::$app->user->identity->username . '<span class="badge ' . Yii::$app->user->identity->lobbycolor . ' white-text">' . Yii::$app->user->identity->lobbystate . '</span></span></a>
      <a href="' . Url::to(['/profile/view', 'id' => Yii::$app->user->identity->id]) . '"><span class="white-text email">' . Yii::$app->user->identity->email . '</span></a>
    </div></li>',
        [
            'label' => Yii::t('frontend', 'Home'),
            'url' => ['/site/index']
        ],
    ];
}

if (Yii::$app->user->isGuest) {
    $menuItems[] = [
        'label' => Yii::t('frontend', 'Login'),
        'url' => ['/site/login']
    ];
}

if (!Yii::$app->user->isGuest && Yii::$app->user->can('admin')) {
    if (isset(Yii::$app->modules['audit']) && Yii::$app->modules['audit']) {
        $menuItems[] = [
            'label' => Yii::t('frontend', 'Audit'),
            'url' => ['/audit']
        ];
    }
    $menuItems[] = [
        'label' => Yii::t('frontend', 'Admin'),
        'url' => ['/admin']
    ];
    if (isset(Yii::$app->modules['gii']) && Yii::$app->modules['gii']) {
        $menuItems[] = [
            'label' => Yii::t('frontend', 'Gii'),
            'url' => ['/gii']
        ];
    }
    $menuItems[] = [
        'label' => Yii::t('frontend', 'Queue'),
        'url' => ['/monitor']
    ];
    $menuItems[] = [
        'label' => Yii::t('frontend', 'Cron'),
        'url' => ['/cron']
    ];
    $menuItems[] = [
        'label' => Yii::t('frontend', 'Users'),
        'url' => ['/user/index']
    ];
    $menuItems[] = [
        'label' => Yii::t('frontend', 'Logs'),
        'url' => ['/logreader']
    ];
}

$menuItems[] = [
    'label' => Yii::t('frontend', 'Profiles'),
    'url' => ['/profile/index']
];

$menuItems[] = [
    'label' => Yii::t('frontend', 'Games'),
    'url' => ['/game/index']
];

if (!Yii::$app->user->isGuest) {
    if (Yii::$app->user->identity->isFree) {
        $menuItems[] = [
            'id' => 'user-state-free',
            'title' => Yii::t('frontend', 'Set to playing'),
            'label' => Yii::t('frontend', 'Set to playing'),
            'url' => ['/profile/set-playing']
        ];
    } else {
        $menuItems[] = [
            'id' => 'user-state-playing',
            'title' => Yii::t('frontend', 'Set to free'),
            'label' => Yii::t('frontend', 'Set to free'),
            'url' => ['/profile/set-free']
        ];
    }
}

if (!Yii::$app->user->isGuest) {
    $menuItems[] = '<li>'
        . Html::beginForm(['/site/logout'], 'post')
        . Html::submitButton(
            Yii::t('frontend', 'Logout') . ' (' . Yii::$app->user->identity->username . ')',
            ['class' => 'btn btn-link logout']
        )
        . Html::endForm()
        . '</li>';
}

echo SideNav::widget([
    'options' => ['class' => 'fixed'],//['class' => 'navbar-nav navbar-right'],
    'items' => $menuItems,
]);

?>
<div id="left-nav">
    <div id="profile-image">
    </div>
</div>
