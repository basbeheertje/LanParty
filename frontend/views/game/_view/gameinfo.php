<?php

use frontend\models\Game;

/** @var Game $model */

?>
    <h2><?php echo Yii::t('frontend', 'info'); ?></h2>
    <p>
        <?php echo $model->description; ?>
    </p>
<?php

if ($model->link) {

    ?>
    <p>
        <a href="<?php echo $model->link; ?>" target="_BLANK"
           title="<?php echo Yii::t('frontend', 'View site of') . ' ' . $model->name; ?>">
            <?php echo $model->link; ?>
        </a>
    </p>
    <?php
}
?>