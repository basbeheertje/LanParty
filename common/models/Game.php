<?php

namespace common\models;

use yii\behaviors\TimestampBehavior;
use bedezign\yii2\audit\AuditTrailBehavior;

/**
 * Class Conversation
 * @package common\models
 *
 * @property User $creator
 */
class Game extends \common\dao\Game
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            AuditTrailBehavior::class
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreator()
    {
        return $this->hasOne(User::class, ['id' => 'created_by']);
    }
}