<?php

namespace common\dao;

use Yii;
use yii\base\Exception;

/**
 * This is the model class for table "game_player".
 *
 * @property int $id
 * @property int $game_id
 * @property string $user_id
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Game $game
 * @property User $user
 */
class GamePlayer extends \yii\db\ActiveRecord
{

    const STATUS_PLAYING = 1;
    const STATUS_PLAYED = 0;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'game_player';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['game_id', 'user_id', 'status', 'created_at', 'updated_at'], 'required'],
            [['game_id', 'user_id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['game_id'], 'exist', 'skipOnError' => true, 'targetClass' => Game::className(), 'targetAttribute' => ['game_id' => 'id']],
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
            'game_id' => Yii::t('app', 'Game ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
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
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    static public function setAllToPlayed(){
        /** @var self[] $playingGames */
        $playingGames = self::find()->where(['status'=>self::STATUS_PLAYING])->all();
        if($playingGames){
            foreach($playingGames as $playingGame){
                /** @var self $playingGame */
                $playingGame->status = self::STATUS_PLAYED;
                if(!$playingGame->save()){
                    throw new Exception(Yii::t('frontend','Unable to save GamePlaying!'));
                }
            }
        }
    }
}
