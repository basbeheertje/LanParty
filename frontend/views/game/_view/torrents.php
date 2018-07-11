<?php

use frontend\models\Game;
use frontend\models\Torrent;

/** @var Game $model */

?>
<h2>
    <?php echo Yii::t('frontend','Torrents'); ?>
</h2>
<ul class="collection">
    <?php

    if (Yii::$app->user->can('admin')) {
        echo '<li class="collection-item"><div>' . Yii::t('frontend', 'Add torrent') . '<a href="/game/addtorrent/' . $model->id . '" class="secondary-content"><i class="material-icons">add</i></a></div></li>';
    }

    /** @var Game $model */
    if ($model->torrents) {
        foreach ($model->torrents as $torrent) {
            /** @var Torrent $torrent */
            echo '
                <li class="collection-item avatar">
                    <a href="/profile/'.$torrent->createdBy->id.'" title="'.Yii::t('frontend','View profile of'). ' ' . $torrent->createdBy->username . '">
                        <img src="' . $torrent->createdBy->getAvatarLink() . '" alt="" class="circle">
                    </a>
                    <span class="title">
                        ' . $torrent->filename . '
                    </span>
                    <a title="'.Yii::t('frontend','Download').' ' . $torrent->filename . '" href="/torrent/' . $torrent->id . '" class="secondary-content">
                        <i class="material-icons">file_download</i>
                    </a>';

            if (Yii::$app->user->can('admin')) {
                echo '<a title="'.Yii::t('frontend','Delete').' ' . $torrent->filename . '" href="/game-torrent/delete/' . $torrent->id . '" class="secondary-content">
                        <i class="material-icons">delete</i>
                    </a>';
            }

            echo '</li>';
        }
    }

    ?>
</ul>