<?php

namespace frontend\widgets;

use yii\base\Widget;

/**
 * Class CardWidget
 * @package frontend\widgets
 *
 * @property string $title
 * @property string $message
 * @property string $actions
 * @property string $image
 * @property string $colorclass
 * @property string $textclass
 * @property string $button
 * @property string $title_in_image
 */
class CardWidget extends Widget
{
    public $title;
    public $message;
    public $actions;
    public $image;
    public $colorclass;
    public $textclass;
    public $button;
    public $title_in_image = true;

    /**
     * @todo describe
     */
    public function init()
    {
        parent::init();
        if ($this->message === null) {
            $this->message = '';
        }
    }

    /**
     * @todo describe
     * @return string
     */
    public function run()
    {
        /** @var string $html */
        $html = '<div class="card ' . $this->colorclass . '">';
        if ($this->image) {
            $html .= '<div class="card-image">';
        }
        if ($this->image) {
            $html .= '
          <img src="' . $this->image . '">
          
            ';
        }

        if ($this->title_in_image) {
            $html .= '<span class="card-title">' . $this->title . '</span>';
        }

        if ($this->button) {
            $html .= '<a class="btn-floating halfway-fab waves-effect waves-light red" href="' . $this->button['url'] . '" title="' . $this->button['title'] . '"><i class="material-icons">' . $this->button['icon'] . '</i></a>';
        }

        if ($this->image) {
            $html .= '</div>';
        }

        if ($this->image) {
            $html .= '<div class="card-content ' . $this->textclass . '">
          <p>' . $this->message . '</p>
        </div>';
        } else {
            $html .= '<div class="card-content ' . $this->textclass . '">
          <span class="card-title">' . $this->title . '</span>
          <p>' . $this->message . '</p>
        </div>';
        }

        if ($this->actions) {
            $html .= '<div class="card-action">';
            foreach ($this->actions as $action) {
                $html .= '<a href="' . $action - url . '">' . $action->text . '</a>';
            }
            $html .= '</div>';
        }

        $html .= '</div>';
        return $html;
    }
}

?>