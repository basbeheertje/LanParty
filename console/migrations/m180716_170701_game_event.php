<?php

use yii\db\Migration;

/**
 * Class m180716_170701_game_event
 */
class m180716_170701_game_event extends Migration
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

        if (!in_array('game_event', $this->getDb()->schema->tableNames)) {
            $this->createTable(
                'game_event',
                [
                    'id' => $this->primaryKey(),
                    'status' => $this->integer()->notNull()->defaultValue(1),
                    'organiser' => $this->integer()->notNull()->unsigned(),
                    'date' => $this->dateTime()->notNull(),
                    'game_id' => $this->integer()->notNull(),
                    'created_by' => $this->integer()->notNull()->unsigned(),
                    'created_at' => $this->integer()->notNull(),
                    'updated_at' => $this->integer()->notNull(),
                ],
                $tableOptions
            );
            $this->addForeignKey(
                'fk_gameevent_organiser',
                'game_event',
                'organiser',
                'user',
                'id'
            );
            $this->addForeignKey(
                'fk_gameevent_game',
                'game_event',
                'game_id',
                'game',
                'id'
            );
            $this->addForeignKey(
                'fk_gameevent_creator',
                'game_event',
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
        echo "m180716_170701_game_event cannot be reverted.\n";
        return false;
    }
}
