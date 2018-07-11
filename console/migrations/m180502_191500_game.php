<?php

use yii\db\Migration;

/**
 * Class m180502_151500_games
 */
class m180502_191500_game extends Migration
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

        if (!in_array('game', $this->getDb()->schema->tableNames)) {
            $this->createTable(
                'game',
                [
                    'id' => $this->primaryKey(),
                    'name' => $this->string()->notNull()->unique(),
                    'avatar' => $this->string()->notNull(),
                    'profile_image' => $this->string()->notNull(),
                    'link' => $this->string(),
                    'description' => $this->string(),
                    'installation' => $this->string(),
                    'status' => $this->smallInteger()->notNull()->defaultValue(10),
                    'created_by' => $this->integer()->notNull()->unsigned(),
                    'created_at' => $this->integer()->notNull(),
                    'updated_at' => $this->integer()->notNull(),
                ],
                $tableOptions
            );
            $this->addForeignKey(
                'fk_games_creator',
                'game',
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
        echo "m180502_151500_games cannot be reverted.\n";
        return false;
    }
}
