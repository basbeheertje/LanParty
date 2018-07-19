<?php

use frontend\models\User;
use frontend\models\Torrent;
use frontend\models\TorrentDownload;
use frontend\models\Game;
use yii\helpers\Url;

/** @var User $model */

if ($model->downloadedGames) {

    ?>
    <h2>
        <?php echo Yii::t('frontend', 'Games'); ?>
    </h2>
    <ul class="collection">
        <?php
        foreach ($model->downloadedGames as $downloadedGame) {
            /** @var TorrentDownload $downloadedGame */
            /** @var Game $game */
            if ($downloadedGame->game) {
                echo '
                <li class="collection-item avatar">
                    <a href="' . Url::to(['game/view', 'id' => $downloadedGame->game->id]) . '" title="' . Yii::t('frontend', 'View') . ' ' . $downloadedGame->game->name . '">
                        <img src="' . $downloadedGame->game->avatar . '" alt="" class="circle">
                    </a>
                    <span class="title">
                        ' . $downloadedGame->game->name . '
                    </span>
                </li>
            ';
            }
        }

        ?>
    </ul>
    <?php

}

?>