<?php

namespace common\dao;

use Yii;

/**
 * This is the model class for table "queue_worker".
 *
 * @property int $id
 * @property string $sender_name
 * @property int $pid
 * @property int $started_at
 * @property int $pinged_at
 * @property int $stopped_at
 * @property int $finished_at
 * @property int $last_exec_id
 */
class QueueWorker extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'queue_worker';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sender_name', 'pid', 'started_at', 'pinged_at'], 'required'],
            [['pid', 'started_at', 'pinged_at', 'stopped_at', 'finished_at', 'last_exec_id'], 'integer'],
            [['sender_name'], 'string', 'max' => 32],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'sender_name' => Yii::t('app', 'Sender Name'),
            'pid' => Yii::t('app', 'Pid'),
            'started_at' => Yii::t('app', 'Started At'),
            'pinged_at' => Yii::t('app', 'Pinged At'),
            'stopped_at' => Yii::t('app', 'Stopped At'),
            'finished_at' => Yii::t('app', 'Finished At'),
            'last_exec_id' => Yii::t('app', 'Last Exec ID'),
        ];
    }
}
