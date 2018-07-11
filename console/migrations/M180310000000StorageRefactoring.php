<?php

use zhuravljov\yii\queue\monitor\base\Migration;

/**
 * Storage Refactoring
 *
 * @author Roman Zhuravlev <zhuravljov@gmail.com>
 */
class M180310000000StorageRefactoring extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->renameColumn($this->env->pushTableName, 'ttr', 'push_ttr');
        $this->renameColumn($this->env->pushTableName, 'delay', 'push_delay');
        $this->addColumn($this->env->pushTableName, 'push_trace_data', $this->binary()->after('push_delay'));
        $this->addColumn($this->env->pushTableName, 'push_env_data', $this->binary()->after('push_trace_data'));
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropColumn($this->env->pushTableName, 'push_env_data');
        $this->dropColumn($this->env->pushTableName, 'push_trace_data');
        $this->renameColumn($this->env->pushTableName, 'push_delay', 'delay');
        $this->renameColumn($this->env->pushTableName, 'push_ttr', 'ttr');
    }
}
