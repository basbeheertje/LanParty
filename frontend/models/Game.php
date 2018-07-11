<?php

namespace frontend\models;

/**
 * Class Game
 * @package frontend\models
 */
class Game extends \common\models\Game
{
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreator()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
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