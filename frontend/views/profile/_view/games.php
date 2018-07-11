<?php

use frontend\models\User;
use frontend\models\Torrent;
use frontend\models\TorrentDownload;
use frontend\models\Game;

/** @var User $model */

if ($model->downloadedGames) {

    ?>
    <h2>
        <?php echo Yii::t('frontend', 'Games'); ?>
    </h2>
    <ul class="collection">
        <?php
        foreach ($model->torrents as $torrent) {
            /** @var Torrent $torrent */
            echo '
                <li class="collection-item avatar">
                    <a href="/profile/' . $torrent->createdBy->id . '" title="' . Yii::t('frontend', 'View profile of') . ' ' . $torrent->createdBy->username . '">
                        <img src="' . $torrent->createdBy->getAvatarLink() . '" alt="" class="circle">
                    </a>
                    <span class="title">
                        ' . $torrent->filename . '
                    </span>
                    <a title="' . Yii::t('frontend', 'Download') . ' ' . $torrent->filename . '" href="/torrent/' . $torrent->id . '" class="secondary-content">
                        <i class="material-icons">file_download</i>
                    </a>
                </li>
            ';
        }

        ?>
    </ul>
    <?php

}

?>