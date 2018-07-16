<?php

use yii\db\Migration;

/**
 * Class m180716_170706_game_event_user
 */
class m180716_170706_game_event_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        if (!in_array('game_event_user', $this->getDb()->schema->tableNames)) {
            $this->createTable(
                'game_event_user',
                [
                    'id' => $this->primaryKey(),
                    'game_event_id' => $this->integer()->notNull(),
                    'user_id' => $this->integer()->notNull()->unsigned(),
                    'created_by' => $this->integer()->notNull()->unsigned(),
                    'created_at' => $this->integer()->notNull(),
                    'updated_at' => $this->integer()->notNull(),
                ],
                $tableOptions
            );
            $this->addForeignKey(
                'fk_gameeventuser_gameevent',
                'game_event_user',
                'game_event_id',
                'game_event',
                'id'
            );
            $this->addForeignKey(
                'fk_gameeventuser_user',
                'game_event_user',
                'user_id',
                'user',
                'id'
            );
            $this->addForeignKey(
                'fk_gameeventuser_creator',
                'game_event_user',
                'created_by',
                'user',
                'id'
            );
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180716_170706_game_event_user cannot be reverted.\n";
        return false;
    }
}
