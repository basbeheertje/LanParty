<?php

namespace common\dao;

use Yii;

/**
 * This is the model class for table "queue_push".
 *
 * @property int $id
 * @property int $parent_id
 * @property string $sender_name
 * @property string $job_uid
 * @property string $job_class
 * @property resource $job_data
 * @property int $push_ttr
 * @property int $push_delay
 * @property resource $push_trace_data
 * @property resource $push_env_data
 * @property int $pushed_at
 * @property int $stopped_at
 * @property int $first_exec_id
 * @property int $last_exec_id
 */
class QueuePush extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'queue_push';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['parent_id', 'push_ttr', 'push_delay', 'pushed_at', 'stopped_at', 'first_exec_id', 'last_exec_id'], 'integer'],
            [['sender_name', 'job_uid', 'job_class', 'job_data', 'push_ttr', 'push_delay', 'pushed_at'], 'required'],
            [['job_data', 'push_trace_data', 'push_env_data'], 'string'],
            [['sender_name', 'job_uid'], 'string', 'max' => 32],
            [['job_class'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'parent_id' => Yii::t('app', 'Parent ID'),
            'sender_name' => Yii::t('app', 'Sender Name'),
            'job_uid' => Yii::t('app', 'Job Uid'),
            'job_class' => Yii::t('app', 'Job Class'),
            'job_data' => Yii::t('app', 'Job Data'),
            'push_ttr' => Yii::t('app', 'Push Ttr'),
            'push_delay' => Yii::t('app', 'Push Delay'),
            'push_trace_data' => Yii::t('app', 'Push Trace Data'),
            'push_env_data' => Yii::t('app', 'Push Env Data'),
            'pushed_at' => Yii::t('app', 'Pushed At'),
            'stopped_at' => Yii::t('app', 'Stopped At'),
            'first_exec_id' => Yii::t('app', 'First Exec ID'),
            'last_exec_id' => Yii::t('app', 'Last Exec ID'),
        ];
    }
}
