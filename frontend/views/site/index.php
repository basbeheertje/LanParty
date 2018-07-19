<?php

/* @var $this yii\web\View */

$this->title = Yii::$app->name;
?>
<div class="site-index">
    <?php

    echo $this->render('_index/slider');

    ?>
    <div class="row">
        <div class="col s12 m12">
            <?php

            echo $this->render('_index/free_players');

            ?>
        </div>
    </div>
</div>
