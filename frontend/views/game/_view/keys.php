<?php

use frontend\models\Game;
use frontend\models\GameKey;

/** @var Game $model */
?>
<ul class="collection">
    <?php

    if (Yii::$app->user->can('admin')) {
        echo '<li class="collection-item"><div>' . Yii::t('frontend', 'Add key') . '<a href="/game/addkey/' . $model->id . '" class="secondary-content"><i class="material-icons">add</i></a></div></li>';
    }

    /** @var Game $model */
    if ($model->gameKeys) {
        foreach ($model->gameKeys as $gameKey) {
            /** @var GameKey $gameKey */
            echo '
                <li class="collection-item avatar">
                    <a href="/profile/' . $gameKey->creator->id . '" title="' . Yii::t('frontend', 'View profile of') . ' ' . $gameKey->creator->username . '">
                        <img src="' . $gameKey->creator->getAvatarLink() . '" alt="" class="circle">
                    </a>
                    <span class="title" title="' . $gameKey->note . '">
                        ' . $gameKey->key . '
                    </span>
            ';

            if (Yii::$app->user->can('admin')) {
                echo '<a title="' . Yii::t('frontend', 'Delete key') . '" href="/game-key/delete/' . $gameKey->id . '" class="secondary - content">
                        <i class="material-icons">delete</i>
                    </a>';
            }

            echo "</li>";
        }
    }

    ?>
</ul>