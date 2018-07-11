<?php

use zhuravljov\yii\queue\monitor\base\Migration;

/**
 * Parent Jobs
 *
 * @author Roman Zhuravlev <zhuravljov@gmail.com>
 */
class M180311000000ParentJobs extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->addColumn($this->env->pushTableName, 'parent_id', $this->integer()->after('id'));
        $this->createIndex('parent_id', $this->env->pushTableName, 'parent_id');
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropIndex('parent_id', $this->env->pushTableName);
        $this->dropColumn($this->env->pushTableName, 'parent_id');
    }
}
