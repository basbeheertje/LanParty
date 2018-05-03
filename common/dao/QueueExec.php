<?php

namespace common\dao;

use Yii;

/**
 * This is the model class for table "queue_exec".
 *
 * @property int $id
 * @property int $push_id
 * @property int $worker_id
 * @property int $attempt
 * @property int $reserved_at
 * @property int $done_at
 * @property string $memory_usage
 * @property string $error
 * @property int $retry
 */
class QueueExec extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'queue_exec';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['push_id', 'attempt', 'reserved_at'], 'required'],
            [['push_id', 'worker_id', 'attempt', 'reserved_at', 'done_at', 'memory_usage', 'retry'], 'integer'],
            [['error'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'push_id' => Yii::t('app', 'Push ID'),
            'worker_id' => Yii::t('app', 'Worker ID'),
            'attempt' => Yii::t('app', 'Attempt'),
            'reserved_at' => Yii::t('app', 'Reserved At'),
            'done_at' => Yii::t('app', 'Done At'),
            'memory_usage' => Yii::t('app', 'Memory Usage'),
            'error' => Yii::t('app', 'Error'),
            'retry' => Yii::t('app', 'Retry'),
        ];
    }
}
