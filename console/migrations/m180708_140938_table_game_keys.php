<?php

use yii\db\Migration;

/**
 * Class m180710_140938_table_game_keys
 */
class m180708_140938_table_game_keys extends Migration
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

        if (!in_array('game_key', $this->getDb()->schema->tableNames)) {
            $this->createTable(
                'game_key',
                [
                    'id' => $this->primaryKey(),
                    'game_id' => $this->integer()->notNull(),
                    'key' => $this->string()->notNull(),
                    'note' => $this->string(),
                    'created_by' => $this->integer()->notNull()->unsigned(),
                    'created_at' => $this->integer()->notNull(),
                    'updated_at' => $this->integer()->notNull(),
                ],
                $tableOptions
            );
            $this->addForeignKey(
                'fk_gamekey_creator',
                'game_key',
                'created_by',
                'user',
                'id'
            );
            $this->addForeignKey(
                'fk_gamekey_game',
                'game_key',
                'game_id',
                'game',
                'id'
            );
            $this->createIndex(
                'idx-unique-gamekey-game-key',
                'game_key',
                [
                    'game_id',
                    'key'
                ],
                true
            );
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        if (in_array('game_key', $this->getDb()->schema->tableNames)) {
            $gameTorrentTable = \Yii::$app->db->schema->getTableSchema('`game_key`');
            if (isset($gameTorrentTable->foreignKeys['fk_gamekey_creator'])) {
                $this->dropForeignKey('fk_gamekey_creator', 'game_key');
            }
            $this->dropIndex('idx-unique-gamekey-game-key', 'game_key');
            $this->dropTable('game_key');
        }
    }
}
