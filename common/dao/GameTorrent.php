<?php

namespace common\dao;

use Yii;

/**
 * This is the model class for table "game_torrent".
 *
 * @property int $game_id
 * @property int $torrent_id
 * @property string $created_by
 * @property int $created_at
 * @property int $updated_at
 *
 * @property User $createdBy
 * @property Game $game
 * @property Torrent $torrent
 */
class GameTorrent extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'game_torrent';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['game_id', 'torrent_id', 'created_by', 'created_at', 'updated_at'], 'required'],
            [['game_id', 'torrent_id', 'created_by', 'created_at', 'updated_at'], 'integer'],
            [['game_id', 'torrent_id'], 'unique', 'targetAttribute' => ['game_id', 'torrent_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['game_id'], 'exist', 'skipOnError' => true, 'targetClass' => Game::className(), 'targetAttribute' => ['game_id' => 'id']],
            [['torrent_id'], 'exist', 'skipOnError' => true, 'targetClass' => Torrent::className(), 'targetAttribute' => ['torrent_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'game_id' => Yii::t('app', 'Game ID'),
            'torrent_id' => Yii::t('app', 'Torrent ID'),
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
    public function getGame()
    {
        return $this->hasOne(Game::className(), ['id' => 'game_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTorrent()
    {
        return $this->hasOne(Torrent::className(), ['id' => 'torrent_id']);
    }
}
