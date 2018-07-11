<?php

use frontend\models\Game;
use frontend\models\Torrent;
use yii\helpers\Url;

/** @var Game $model */

?>
<h2>
    <?php echo Yii::t('frontend','Torrents'); ?>
</h2>
<ul class="collection">
    <?php

    if (Yii::$app->user->can('admin')) {
        echo '<li class="collection-item"><div>' . Yii::t('frontend', 'Add torrent') . '<a href="'.Url::to(['game/addtorrent', 'id' => $model->id]) . '" class="secondary-content"><i class="material-icons">add</i></a></div></li>';
    }

    /** @var Game $model */
    if ($model->torrents) {
        foreach ($model->torrents as $torrent) {
            /** @var Torrent $torrent */
            echo '
                <li class="collection-item avatar">
                    <a href="'.Url::to(['profile/view', 'id' => $torrent->createdBy->id]) . '" title="'.Yii::t('frontend','View profile of'). ' ' . $torrent->createdBy->username . '">
                        <img src="' . $torrent->createdBy->getAvatarLink() . '" alt="" class="circle">
                    </a>
                    <span class="title">
                        ' . $torrent->filename . '
                    </span>
                    <a title="'.Yii::t('frontend','Download').' ' . $torrent->filename . '" href="'.Url::to(['torrent/view', 'id' => $torrent->id]) . '" class="secondary-content">
                        <i class="material-icons">file_download</i>
                    </a>';

            if (Yii::$app->user->can('admin')) {
                echo '<a title="'.Yii::t('frontend','Delete').' ' . $torrent->filename . '" href="'. Url::to(['game-torrent/delete', 'id' => $torrent->id]) . '" class="secondary-content">
                        <i class="material-icons">delete</i>
                    </a>';
            }

            echo '</li>';
        }
    }

    ?>
</ul>