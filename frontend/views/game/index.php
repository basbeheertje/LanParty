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
<?php

/** @var Game[] $games */
if (Yii::$app->user->can('admin')) {
    $games = Game::find()
        ->orderBy(
            [
                'status' => SORT_DESC,
                'name' => SORT_ASC
            ]
        )
        ->all();
} else {
    $games = Game::find()
        ->where([
            'not in',
            'status',
            Game::STATUS_INACTIVE
        ])
        ->orderBy([
            'name' => SORT_ASC
        ])
        ->all();
}

/** @var int $counter */
$counter = 0;

foreach ($games as $game) {
    /** @var Game $game */
    $counter++;

    if ($counter === 1) {
        echo '<div class="row">';
    }

    ?>
    <div class="col s12 m3">
        <?php

        /** @var string $name */
        $name = $game->name;
        /** @var string $description */
        $description = $game->description;
        if ($game->status === Game::STATUS_INACTIVE) {
            $name = "[" . strtoupper(Yii::t('frontend', 'disabled')) . "] " . $name;
            $description = "[" . strtoupper(Yii::t('frontend', 'disabled')) . "] " . $description;
        }


        echo CardWidget::widget(
            [
                'title' => $name,
                'message' => substr($description, 0, 255),
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

    if ($counter === 4) {
        echo "</div>";
        $counter = 0;
    }
}

if ($counter !== 4) {
    echo "</div>";
}

?>