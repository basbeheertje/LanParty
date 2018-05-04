<?php

use yii\db\Migration;

/**
 * Class m180504_134750_queueInstallation
 */
class m180504_134750_queueInstallation extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $task = new yii\queue\db\migrations\M161119140200Queue();
        $task->up();
        $task = new yii\queue\db\migrations\M170307170300Later();
        $task->up();
        $task = new yii\queue\db\migrations\M170509001400Retry();
        $task->up();
        $task = new yii\queue\db\migrations\M170601155600Priority();
        $task->up();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $task = new yii\queue\db\migrations\M161119140200Queue();
        $task->down();
        $task = new yii\queue\db\migrations\M170307170300Later();
        $task->down();
        $task = new yii\queue\db\migrations\M170509001400Retry();
        $task->down();
        $task = new yii\queue\db\migrations\M170601155600Priority();
        $task->down();
    }
}
