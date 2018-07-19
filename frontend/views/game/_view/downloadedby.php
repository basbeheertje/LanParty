<?php

use frontend\models\Game;
use frontend\models\User;
use yii\helpers\Url;

/** @var Game $model */
?>
<ul class="collection">
    <?php

    /** @var Game $model */
    if ($model->downloaders) {
        foreach ($model->downloaders as $downloader) {
            /** @var User $downloader */
            echo '
                <li class="collection-item avatar">
                    <a href="' . Url::to(['profile/view', 'id' => $downloader->id]) . '" title="' . Yii::t('frontend', 'View profile of') . ' ' . $downloader->username . '">
                        <img src="' . $downloader->getAvatarLink() . '" alt="" class="circle">
                        <span class="title" title="' . $downloader->username . '">
                            ' . $downloader->username . '
                        </span>
                    </a>
                </li>
            ';
        }
    }

    ?>
</ul>