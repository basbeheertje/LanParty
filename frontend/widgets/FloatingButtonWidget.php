<?php

namespace frontend\widgets;

use yii\base\Widget;

class FloatingButtonWidget extends Widget
{
    public $title;
    public $url;
    public $icon;

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        /** @var string $html */
        $html = '<a class="btn-floating btn-large waves-effect waves-light red" title="'.$this->title.'" href="'.$this->url.'"><i class="material-icons">'.$this->icon.'</i></a>';
        return $html;
    }
}

?>