<?php

namespace common\models;

//...

class Message extends \bubasuma\simplechat\db\Message
{
    /**
     * @inheritDoc
     */
    public function fields()
    {
        return [
            'text',
            'date' => 'created_at',
        ];
    }
}