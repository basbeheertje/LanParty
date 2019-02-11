<?php

use frontend\models\User;

/** @var [] $excluded_players */
$excluded_players = [];

if(!Yii::$app->user->isGuest){
    $excluded_players[] = Yii::$app->user->identity->id;
}

/** @var User[] $profiles */
$profiles = User::find()
    ->where(
        ['in', 'status', [User::STATUS_FREE]]
    )
    ->andWhere(
        [
            'not in', 'id', $excluded_players
        ]
    )
    ->orderBy(['id' => SORT_DESC])->all();

foreach ($profiles as $profile) {
    /** @var User $profile */
    ?>
    <div class="col s12 m3">
        <?php

        echo $this->render('player', ['model' => $profile]);

        ?>
    </div>
    <?php
}

?>