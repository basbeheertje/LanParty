<?php

use macgyer\yii2materializecss\widgets\media\Carousel;
use common\dao\Game;
use yii\helpers\Url;

/** @var Game[] $games */
$games = Game::find()->orderBy(['id' => SORT_DESC])->limit(4)->all();

/** @var [] $items */
$items = [];

/** @var [] $colors */
$colors = [
    'red white-text',
    'amber white-text',
    'green white-text',
    'blue white-text'
];

if ($games) {
    /** @var int $colorCounter */
    $colorCounter = 0;
    foreach ($games as $game) {
        /** @var Game $game */
        $items[] = [
            'content' => '<h2>' . $game->name . '</h2><span class="home-slider-gameavatar" style="background-position:center center;background-size:contain;margin-left:25px;border-radius:50%;width:200px;height:200px;display:inline-block;float:left;background-image:url(\''.$game->avatar.'\')"></span><p class="white-text" style="margin-right:200px;">' . $game->description . '</p><a class="btn waves-effect white grey-text darken-text-2" style="margin-right:215px;" href="'.Url::to(['game/view','id'=>$game->id]).'">' . Yii::t('frontend', 'View game') . '</a>',
            'options' => [
                'class' => $colors[$colorCounter]
            ]
        ];
        $colorCounter++;
        if ($colorCounter >= count($colors)) {
            $colorCounter = 0;
        }
    }
}

echo Carousel::widget(
    [
        'carouselOptions' => [
            'class' => 'center'
        ],
        'itemOptions' => [
            'clasa' => 'amber white-text'
        ],
        'items' => $items,
        'fullWidth' => true,
        'showIndicators' => true
    ]
);

?>