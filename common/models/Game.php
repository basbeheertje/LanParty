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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGameKeys()
    {
        return $this->hasMany(GameKey::className(), ['game_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGameTorrents()
    {
        return $this->hasMany(GameTorrent::className(), ['game_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTorrents()
    {
        return $this->hasMany(Torrent::className(), ['id' => 'torrent_id'])->viaTable('game_torrent', ['game_id' => 'id']);
    }
}