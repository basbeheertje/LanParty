<?php

namespace common\models;

use common\models\User;
//...

class Conversation extends \bubasuma\simplechat\db\Conversation
{
    public function getContact()
    {
        return $this->hasOne(User::class, ['id' => 'contact_id']);
    }

    /**
     * @inheritDoc
     */
    protected static function baseQuery($userId)
    {
        return parent::baseQuery($userId) ->with(['contact.profile']);
    }

    /**
     * @inheritDoc
     */
    public function fields()
    {
        return [
            'contact' => function ($model) {
                return $model['contact'];
            },
            'deleteUrl',
            'readUrl',
            'unreadUrl'
        ];
    }
}