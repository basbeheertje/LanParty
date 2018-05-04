<?php

namespace common\dao;

use Yii;

/**
 * This is the model class for table "tasks".
 *
 * @property int $task_id
 * @property string $time
 * @property string $command
 * @property string $status
 * @property string $comment
 * @property string $ts
 * @property string $ts_updated
 */
class Tasks extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tasks';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['time', 'command'], 'required'],
            [['status'], 'string'],
            [['ts', 'ts_updated'], 'safe'],
            [['time'], 'string', 'max' => 64],
            [['command', 'comment'], 'string', 'max' => 256],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'task_id' => Yii::t('app', 'Task ID'),
            'time' => Yii::t('app', 'Time'),
            'command' => Yii::t('app', 'Command'),
            'status' => Yii::t('app', 'Status'),
            'comment' => Yii::t('app', 'Comment'),
            'ts' => Yii::t('app', 'Ts'),
            'ts_updated' => Yii::t('app', 'Ts Updated'),
        ];
    }
}
