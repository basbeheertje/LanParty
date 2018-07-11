<?php

use macgyer\yii2materializecss\widgets\media\Carousel;
use frontend\models\Game;
use yii\helpers\Html;

/** @var Game $model */
/** @var [] $items */
$items = [];

$items[] = [
    'content' => Html::img(Yii::getAlias('@web' . $model->profile_image)),
];

echo Carousel::widget(
    [
        'carouselOptions' => [
            'class' => 'center'
        ],
        'itemOptions' => [
            'clasa' => 'amber white-text'
        ],
        'items' => $items,
        'fixedItemOptions' => [
            'tag' => 'h1',
            'content' => $model->name,
            'class' => 'white-text'
        ],
        'fullWidth' => true,
        'showIndicators' => true
    ]
);

?>
<div class="game-profileimage">
    <img width="100%" height="100%" src="<?php echo Yii::getAlias('@web' . $model->avatar); ?>" title="<?php echo Yii::t('frontend','Profile image of') . ' ' . $model->name; ?>">
</div>