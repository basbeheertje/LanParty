<?php

namespace common\models;

use yii\behaviors\TimestampBehavior;
use bedezign\yii2\audit\AuditTrailBehavior;

/**
 * Class Torrent
 * @package common\models
 */
class GameTorrent extends \common\dao\GameTorrent {
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