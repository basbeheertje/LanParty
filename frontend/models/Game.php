<?php

namespace frontend\models;

/**
 * Class Game
 * @package frontend\models
 *
 * @property boolean isDownloaded
 * @property User $downloaders
 */
class Game extends \common\models\Game {
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreator () {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGameTorrents () {
        return $this->hasMany(GameTorrent::className(), ['game_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTorrents () {
        return $this->hasMany(Torrent::className(), ['id' => 'torrent_id'])->viaTable('game_torrent', ['game_id' => 'id']);
    }

    /**
     * @return bool
     */
    public function getIsDownloaded () {
        /** @var Torrent $torrents */
        $torrents = $this->torrents;
        if ($torrents) {
            foreach ($torrents as $torrent) {
                /** @var Torrent $torrent */
                if ($torrent->isDownloaded) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * @return array
     */
    public function getDownloaders () {
        /** @var array $downloaders */
        $downloaders = [];

        if ($this->torrents) {
            foreach ($this->torrents as $torrent) {
                /** @var Torrent $torrent */
                /** @var TorrentDownload[] $downloads */
                $downloads = $torrent->downloads;
                if ($downloads) {
                    foreach ($downloads as $download) {
                        /** @var TorrentDownload $download */
                        if (!isset($downloaders[$download->user_id])) {
                            $downloaders[$download->user_id] = $download->user;
                        }
                    }
                }
            }
        }

        return $downloaders;
    }
}