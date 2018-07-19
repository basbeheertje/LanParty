<?php

namespace common\models;

use yii\behaviors\TimestampBehavior;
use bedezign\yii2\audit\AuditTrailBehavior;

/**
 * Class Torrent
 * @package common\models
 *
 * @property TorrentDownload[] $downloads
 * @property Game $game
 */
class Torrent extends \common\dao\Torrent {
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
    public function getDownloads()
    {
        return $this->getTorrentDownloads();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGameTorrents()
    {
        return $this->hasMany(GameTorrent::className(), ['torrent_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGames()
    {
        return $this->hasMany(Game::className(), ['id' => 'game_id'])->viaTable('game_torrent', ['torrent_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTorrentDownloads()
    {
        return $this->hasMany(TorrentDownload::className(), ['torrent_id' => 'id']);
    }

    /**
     * @return \common\dao\Game|Game|null
     */
    public function getGame(){
        if(!$this->games){
            return null;
        }
        foreach($this->games as $game){
            /** @var Game $game */
            return $game;
        }
        return null;
    }
}