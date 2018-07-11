<?php

use yii\helpers\Html;
use common\models\Game;
use frontend\widgets\CardWidget;
use yii\helpers\Url;
use frontend\widgets\FloatingButtonWidget;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Games');
$this->params['breadcrumbs'][] = $this->title;

if (Yii::$app->user->can('admin')) {
    echo FloatingButtonWidget::widget(
        [
            'title' => Yii::t('frontend', 'Create Game'),
            'url' => Url::to(['game/create/']),
            'icon' => 'add'
        ]
    );
}

?>
<div class="game-index row">
    <div class="col s12">
        <h1><?php echo Html::encode($this->title); ?></h1>
    </div>
</div>
<div class="row">
    <?php

    /** @var Game[] $games */
    $games = Game::find()->orderBy(['name' => SORT_ASC])->all();

    foreach ($games as $game) {
        /** @var Game $game */
        ?>
        <div class="col s12 m3">
            <?php

            echo CardWidget::widget(
                [
                    'title' => $game->name,
                    'message' => substr($game->description, 0, 255),
                    'image' => $game->avatar,
                    'button' => [
                        'url' => Url::to(['game/view', 'id' => $game->id]),
                        'title' => Yii::t('frontend', 'view'),
                        'icon' => 'chevron_right'
                    ]
                ]
            );

            ?>
        </div>
        <?php
    }

    ?>
</div>
