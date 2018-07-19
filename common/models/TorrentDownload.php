<?php

namespace common\models;

use yii\behaviors\TimestampBehavior;
use bedezign\yii2\audit\AuditTrailBehavior;

/**
 * Class Torrent
 * @package common\models
 *
 * @property User $creator
 * @property User $createdBy
 * @property User $user
 * @property Game $game
 */
class TorrentDownload extends \common\dao\TorrentDownload {
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy () {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser () {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTorrent () {
        return $this->hasOne(Torrent::className(), ['id' => 'torrent_id']);
    }

    /**
     * @return mixed|null
     */
    public function getGame () {
        if (!$this->torrent) {
            return null;
        }
        if (!$this->torrent->game) {
            return null;
        }

        return $this->torrent->game;
    }
}