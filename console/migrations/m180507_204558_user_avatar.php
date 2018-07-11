<?php

use yii\db\Migration;

/**
 * Class m180507_204558_user_avatar
 */
class m180507_204558_user_avatar extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $table = Yii::$app->db->schema->getTableSchema('user');
        if (!isset($table->columns['avatar'])) {
            $this->addColumn(
                'user',
                'avatar',
                $this->string()->null()
                ->after('status')
            );
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180507_204558_user_avatar cannot be reverted.\n";
        return false;
    }
}
