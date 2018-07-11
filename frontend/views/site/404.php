<?php

use yii\helpers\Html;

?>
<div class="site-notfound">
    <div id="notfoundbackground"></div>
    <h1>
        <?php

        echo Yii::t('frontend', 'Not found!');

        ?>
    </h1>
    <p>
        <?php echo Yii::t('frontend',"Sorry we didn't it so it's your mistake"); ?>
    </p>
</div>