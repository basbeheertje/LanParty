<?php

use frontend\models\User;

/** @var User[] $profiles */
$profiles = User::find()->where(['in', 'status', [User::STATUS_FREE]])->orderBy(['id' => SORT_DESC])->all();

foreach ($profiles as $profile) {
    /** @var User $profile */
    ?>
    <div class="col s12 m3">
        <?php

        echo $this->render('_index/player', ['model' => $profile]);

        ?>
    </div>
    <?php
}

?>