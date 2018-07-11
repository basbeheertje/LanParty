<?php

namespace common\dao;

use Yii;

/**
 * This is the model class for table "torrent".
 *
 * @property int $id
 * @property string $filename
 * @property string $path
 * @property string $created_by
 * @property int $created_at
 * @property int $updated_at
 *
 * @property GameTorrent[] $gameTorrents
 * @property Game[] $games
 * @property User $createdBy
 * @property TorrentDownload[] $torrentDownloads
 */
class Torrent extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'torrent';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['filename', 'path', 'created_by', 'created_at', 'updated_at'], 'required'],
            [['created_by', 'created_at', 'updated_at'], 'integer'],
            [['filename', 'path'], 'string', 'max' => 255],
            [['filename'], 'unique'],
            [['path'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'filename' => Yii::t('app', 'Filename'),
            'path' => Yii::t('app', 'Path'),
            'created_by' => Yii::t('app', 'Created By'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
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
    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTorrentDownloads()
    {
        return $this->hasMany(TorrentDownload::className(), ['torrent_id' => 'id']);
    }
}
