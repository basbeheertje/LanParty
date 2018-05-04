<?php

namespace common\dao;

use Yii;

/**
 * This is the model class for table "task_runs".
 *
 * @property int $task_run_id
 * @property int $task_id
 * @property string $status
 * @property string $execution_time
 * @property string $ts
 * @property string $output
 */
class TaskRuns extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'task_runs';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['task_id'], 'required'],
            [['task_id'], 'integer'],
            [['status', 'output'], 'string'],
            [['execution_time'], 'number'],
            [['ts'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'task_run_id' => Yii::t('app', 'Task Run ID'),
            'task_id' => Yii::t('app', 'Task ID'),
            'status' => Yii::t('app', 'Status'),
            'execution_time' => Yii::t('app', 'Execution Time'),
            'ts' => Yii::t('app', 'Ts'),
            'output' => Yii::t('app', 'Output'),
        ];
    }
}
