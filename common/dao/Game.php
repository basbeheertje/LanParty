<?php

namespace common\dao;

use Yii;

/**
 * This is the model class for table "game".
 *
 * @property int $id
 * @property string $name
 * @property string $avatar
 * @property string $profile_image
 * @property string $link
 * @property string $description
 * @property string $installation
 * @property int $status
 * @property string $created_by
 * @property int $created_at
 * @property int $updated_at
 *
 * @property User $createdBy
 * @property GameEvent[] $gameEvents
 * @property GameKey[] $gameKeys
 * @property GamePlayer[] $gamePlayers
 * @property GameTorrent[] $gameTorrents
 * @property Torrent[] $torrents
 */
class Game extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'game';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'avatar', 'profile_image', 'created_by', 'created_at', 'updated_at'], 'required'],
            [['status', 'created_by', 'created_at', 'updated_at'], 'integer'],
            [['name', 'avatar', 'profile_image', 'link', 'description', 'installation'], 'string', 'max' => 255],
            [['name'], 'unique'],
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
            'name' => Yii::t('app', 'Name'),
            'avatar' => Yii::t('app', 'Avatar'),
            'profile_image' => Yii::t('app', 'Profile Image'),
            'link' => Yii::t('app', 'Link'),
            'description' => Yii::t('app', 'Description'),
            'installation' => Yii::t('app', 'Installation'),
            'status' => Yii::t('app', 'Status'),
            'created_by' => Yii::t('app', 'Created By'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
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
    public function getGameEvents()
    {
        return $this->hasMany(GameEvent::className(), ['game_id' => 'id']);
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
    public function getGamePlayers()
    {
        return $this->hasMany(GamePlayer::className(), ['game_id' => 'id']);
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
