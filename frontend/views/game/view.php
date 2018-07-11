<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
use frontend\widgets\FloatingButtonWidget;

/* @var $this yii\web\View */
/* @var $model frontend\models\Game */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Games'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="game-view">
    <?php

    if (Yii::$app->user->can('admin')) {

        echo FloatingButtonWidget::widget(
            [
                'title' => Yii::t('frontend', 'Update'),
                'url' => Url::to(['game/update/' . $model->id]),
                'icon' => 'update'
            ]
        );

        /*echo FloatingButtonWidget::widget(
            [
                'title' => Yii::t('frontend', 'Delete'),
                'url' => Url::to(['delete', 'id' => $model->id]),
                'icon' => 'delete'
            ]
        );*/
    }

    echo $this->render('_view/slider', ['model' => $model]);

    ?>
    <div class="row" style="">
        <div class="col s12 m4 game-info fieldset">
            <?php

            echo $this->render('_view/gameinfo', ['model' => $model]);

            if (Yii::$app->user->can('admin')) {
                echo $this->render('_view/admininfo', ['model' => $model]);
            }

            ?>
        </div>
        <div class="col s12 m4 game-torrents fieldset">
            <?php

            echo $this->render('_view/torrents', ['model' => $model]);

            ?>
        </div>
        <div class="col s12 m4 game-keys fieldset">
            <h2><?php echo Yii::t('frontend','Keys'); ?></h2>
            <?php

            echo $this->render('_view/keys', ['model' => $model]);

            ?>
        </div>
    </div>
</div>