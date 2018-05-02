<?php

namespace common\dao;

use Yii;

/**
 * This is the model class for table "message".
 *
 * @property string $id
 * @property string $sender_id
 * @property string $receiver_id
 * @property string $text
 * @property int $is_new
 * @property int $is_deleted_by_sender
 * @property int $is_deleted_by_receiver
 * @property string $created_at
 *
 * @property User $receiver
 * @property User $sender
 */
class Message extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'message';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sender_id', 'receiver_id', 'text', 'created_at'], 'required'],
            [['sender_id', 'receiver_id'], 'integer'],
            [['created_at'], 'safe'],
            [['text'], 'string', 'max' => 1020],
            [['is_new', 'is_deleted_by_sender', 'is_deleted_by_receiver'], 'string', 'max' => 1],
            [['receiver_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['receiver_id' => 'id']],
            [['sender_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['sender_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'sender_id' => Yii::t('app', 'Sender ID'),
            'receiver_id' => Yii::t('app', 'Receiver ID'),
            'text' => Yii::t('app', 'Text'),
            'is_new' => Yii::t('app', 'Is New'),
            'is_deleted_by_sender' => Yii::t('app', 'Is Deleted By Sender'),
            'is_deleted_by_receiver' => Yii::t('app', 'Is Deleted By Receiver'),
            'created_at' => Yii::t('app', 'Created At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReceiver()
    {
        return $this->hasOne(User::className(), ['id' => 'receiver_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSender()
    {
        return $this->hasOne(User::className(), ['id' => 'sender_id']);
    }
}
