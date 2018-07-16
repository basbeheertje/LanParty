<?php

namespace common\dao;

use Yii;

/**
 * This is the model class for table "game_event_user".
 *
 * @property int $id
 * @property int $game_event_id
 * @property string $user_id
 * @property string $created_by
 * @property int $created_at
 * @property int $updated_at
 *
 * @property User $createdBy
 * @property GameEvent $gameEvent
 * @property User $user
 */
class GameEventUser extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'game_event_user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['game_event_id', 'user_id', 'created_by', 'created_at', 'updated_at'], 'required'],
            [['game_event_id', 'user_id', 'created_by', 'created_at', 'updated_at'], 'integer'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['game_event_id'], 'exist', 'skipOnError' => true, 'targetClass' => GameEvent::className(), 'targetAttribute' => ['game_event_id' => 'id']],
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
            'game_event_id' => Yii::t('app', 'Game Event ID'),
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
    public function getGameEvent()
    {
        return $this->hasOne(GameEvent::className(), ['id' => 'game_event_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
