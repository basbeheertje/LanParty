<?php

use yii\db\Migration;

/**
 * Class m180721_103451_set_playing_game
 */
class m180721_103451_set_playing_game extends Migration {
    /**
     * {@inheritdoc}
     */
    public function safeUp () {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        if (!in_array('game_player', $this->getDb()->schema->tableNames)) {
            $this->createTable(
                'game_player',
                [
                    'id' => $this->primaryKey(),
                    'game_id' => $this->integer()->notNull(),
                    'user_id' => $this->integer()->notNull()->unsigned(),
                    'status' => $this->integer()->notNull(),
                    'created_at' => $this->integer()->notNull(),
                    'updated_at' => $this->integer()->notNull(),
                ],
                $tableOptions
            );
            $this->addForeignKey(
                'fk_gameplayer_user',
                'game_player',
                'user_id',
                'user',
                'id'
            );
            $this->addForeignKey(
                'fk_gameplayer_game',
                'game_player',
                'game_id',
                'game',
                'id'
            );
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown () {
        echo "m180721_103451_set_playing_game cannot be reverted.\n";

        return false;
    }
}
