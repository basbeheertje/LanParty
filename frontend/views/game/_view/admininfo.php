<?php

use frontend\models\Game;

/** @var Game $model */

?>
<p>
    <?php echo Yii::t('frontend','Created by'); ?>: <?php echo $model->createdBy->username; ?>
</p>
<p>
    <?php echo Yii::t('frontend','Created on'); ?>: <?php echo date('Y-m-d H:i:s',$model->created_at); ?>
</p>
<p>
    <?php echo Yii::t('frontend','Modified on'); ?>: <?php echo date('Y-m-d H:i:s',$model->updated_at); ?>
</p>
