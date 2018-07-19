<?php

use frontend\models\Game;
use yii\helpers\Url;

/** @var Game $model */

?>
<p>
    <?php echo Yii::t('frontend', 'Created by'); ?>: <?php echo $model->createdBy->username; ?>
</p>
<p>
    <?php echo Yii::t('frontend', 'Created on'); ?>: <?php echo date('Y-m-d H:i:s', $model->created_at); ?>
</p>
<p>
    <?php echo Yii::t('frontend', 'Modified on'); ?>: <?php echo date('Y-m-d H:i:s', $model->updated_at); ?>
</p>
<p>
    <?php

    if ($model->status === Game::STATUS_INACTIVE) {
        echo '<a href="' . Url::to(["game/enable", 'id' => $model->id]) . '">' . Yii::t("frontend", "Enable") . '</a>';
    } else {
        echo '<a href="' . Url::to(["game/disable", 'id' => $model->id]) . '">' . Yii::t("frontend", "Disable") . '</a>';
    }
    ?>
</p>