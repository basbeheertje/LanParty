<?php

use zhuravljov\yii\queue\monitor\base\Migration;

/**
 * Storage of worker events
 *
 * @author Roman Zhuravlev <zhuravljov@gmail.com>
 */
class M171221000000WorkerLastExec extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->addColumn($this->env->workerTableName, 'last_exec_id', $this->integer());
        $this->createIndex('last_exec_id', $this->env->workerTableName, 'last_exec_id');
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropIndex('last_exec_id', $this->env->workerTableName);
        $this->dropColumn($this->env->workerTableName, 'last_exec_id');
    }
}
