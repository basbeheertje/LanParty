<?php

namespace common\dao;

use Yii;

/**
 * This is the model class for table "game_event".
 *
 * @property int $id
 * @property int $status
 * @property string $organiser
 * @property string $date
 * @property int $game_id
 * @property string $created_by
 * @property int $created_at
 * @property int $updated_at
 *
 * @property User $createdBy
 * @property Game $game
 * @property User $organiser0
 * @property GameEventUser[] $gameEventUsers
 */
class GameEvent extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'game_event';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status', 'organiser', 'game_id', 'created_by', 'created_at', 'updated_at'], 'integer'],
            [['organiser', 'date', 'game_id', 'created_by', 'created_at', 'updated_at'], 'required'],
            [['date'], 'safe'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['game_id'], 'exist', 'skipOnError' => true, 'targetClass' => Game::className(), 'targetAttribute' => ['game_id' => 'id']],
            [['organiser'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['organiser' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'status' => Yii::t('app', 'Status'),
            'organiser' => Yii::t('app', 'Organiser'),
            'date' => Yii::t('app', 'Date'),
            'game_id' => Yii::t('app', 'Game ID'),
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
    public function getOrganiser0()
    {
        return $this->hasOne(User::className(), ['id' => 'organiser']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGameEventUsers()
    {
        return $this->hasMany(GameEventUser::className(), ['game_event_id' => 'id']);
    }
}
