<?php

namespace common\dao;

use Yii;

/**
 * This is the model class for table "torrent_download".
 *
 * @property int $id
 * @property int $torrent_id
 * @property string $user_id
 * @property string $created_by
 * @property int $created_at
 * @property int $updated_at
 *
 * @property User $createdBy
 * @property Torrent $torrent
 * @property User $user
 */
class TorrentDownload extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'torrent_download';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['torrent_id', 'user_id', 'created_by', 'created_at', 'updated_at'], 'required'],
            [['torrent_id', 'user_id', 'created_by', 'created_at', 'updated_at'], 'integer'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['torrent_id'], 'exist', 'skipOnError' => true, 'targetClass' => Torrent::className(), 'targetAttribute' => ['torrent_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'torrent_id' => Yii::t('app', 'Torrent ID'),
            'user_id' => Yii::t('app', 'User ID'),
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
    public function getTorrent()
    {
        return $this->hasOne(Torrent::className(), ['id' => 'torrent_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
