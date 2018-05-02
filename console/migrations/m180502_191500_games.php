<?php

use yii\db\Migration;

/**
 * Class m180502_151500_games
 */
class m180502_191500_games extends Migration
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

        if (!in_array('games', $this->getDb()->schema->tableNames)) {
            $this->createTable(
                'games',
                [
                    'id' => $this->primaryKey(),
                    'name' => $this->string()->notNull()->unique(),
                    'avatar' => $this->string()->notNull(),
                    'profile_image' => $this->string()->notNull(),
                    'link' => $this->string(),
                    'description' => $this->string(),
                    'installation' => $this->string(),
                    'created_by' => $this->integer()->notNull()->unsigned(),
                    'created_at' => $this->integer()->notNull(),
                    'updated_at' => $this->integer()->notNull(),
                ]
                ,
                $tableOptions
            );
            $this->addForeignKey(
                'fk_games_creator',
                'games',
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
