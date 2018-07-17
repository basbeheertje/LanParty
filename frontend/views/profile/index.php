<?php

use yii\helpers\Html;
use frontend\models\User;
use frontend\widgets\CardWidget;
use yii\helpers\Url;
use frontend\widgets\FloatingButtonWidget;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Profiles');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="profile-index row">
    <div class="col s12">
        <h1><?php echo Html::encode($this->title); ?></h1>
    </div>
</div>
<div class="row">
    <?php

    /** @var User[] $profiles */
    $profiles = User::find()->where(['not in','status',[User::STATUS_DELETED]])->orderBy(['username' => SORT_ASC])->all();

    foreach ($profiles as $profile) {
        /** @var User $profile */
        ?>
        <div class="col s12 m3">
            <?php

            echo CardWidget::widget(
                [
                    'title' => $profile->username . '<span class="badge ' . $profile->getLobbycolor() . ' white-text">' . $profile->getLobbystate() . '</span>',
                    'message' => '',
                    'image' => $profile->getAvatarLink(),
                    'button' => [
                        'url' => Url::to(['profile/view', 'id' => $profile->id]),
                        'title' => Yii::t('frontend', 'view'),
                        'icon' => 'chevron_right'
                    ]
                ]
            );

            ?>
        </div>
        <?php
    }

    ?>
</div>
