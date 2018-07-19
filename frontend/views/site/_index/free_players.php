<?php

use frontend\models\User;

/** @var User[] $profiles */
$profiles = User::find()
    ->where(
        ['in', 'status', [User::STATUS_FREE]]
    )
    ->andWhere(
        [
            'not in', 'id', Yii::$app->user->identity->id
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