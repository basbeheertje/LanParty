<?php

/* @var $this \yii\web\View */

/* @var $content string */

use macgyer\yii2materializecss\widgets\navigation\Breadcrumbs;
use macgyer\yii2materializecss\assets\MaterializeAsset;
use frontend\assets\MaterialAsset;
use common\widgets\Alert;

//AppAsset::register($this);
MaterialAsset::register($this);
\bedezign\yii2\audit\web\JSLoggingAsset::register($this);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<?php
echo $this->render(
    'default/head'
);
?>
<body>
<?php $this->beginBody() ?>
<div class="row">
    <?php

    if (!Yii::$app->user->isGuest || !Yii::$app->params['loginrequired']) {

        ?>
        <div class="col s2">
            <?php
            echo $this->render(
                'default/left'
            );
            ?>
        </div>
        <?php

    }

    ?>
    <?php

    if (!Yii::$app->user->isGuest || !Yii::$app->params['loginrequired']) {

    ?>
    <div class="col s10">
        <?php

        }else{

        ?>
        <div class="col s12">
            <?php

            }

            //echo Breadcrumbs::widget([
            //    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            //]);

            ?>
            <?= Alert::widget() ?>
            <?= $content ?>
        </div>
    </div>
    <?php
    echo $this->render(
        'default/footer'
    );
    ?>
    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
