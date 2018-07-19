<?php

namespace common\models;

use yii\behaviors\TimestampBehavior;
use bedezign\yii2\audit\AuditTrailBehavior;

/**
 * Class GameEvent
 * @package common\models
 *
 * @property User $creator
 */
class GameEvent extends \common\dao\GameKey {
    /**
     * {@inheritdoc}
     */
    public function behaviors () {
        return [
            TimestampBehavior::class,
            AuditTrailBehavior::class
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreator () {
        return $this->hasOne(User::class, ['id' => 'created_by']);
    }
}