<?php

use frontend\models\User;
use yii\helpers\Url;
use frontend\widgets\CardWidget;

/** @var User $model */

?>
<div class="col s12 m3">
    <?php

    echo CardWidget::widget(
        [
            'title' => $model->username . '<span class="badge ' . $model->getLobbycolor() . ' white-text">' . $model->getLobbystate() . '</span>',
            'message' => '',
            'image' => $model->getAvatarLink(),
            'button' => [
                'url' => Url::to(['profile/view', 'id' => $model->id]),
                'title' => Yii::t('frontend', 'view'),
                'icon' => 'chevron_right'
            ]
        ]
    );

    ?>
</div>