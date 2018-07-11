<?php

use yii\db\Migration;

/**
 * Class m180710_133840_table_game_torrents
 */
class m180708_193840_table_game_torrents extends Migration
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

        if (!in_array('torrent', $this->getDb()->schema->tableNames)) {
            $this->createTable(
                'torrent',
                [
                    'id' => $this->primaryKey(),
                    'filename' => $this->string()->notNull()->unique(),
                    'path' => $this->string()->notNull()->unique(),
                    'created_by' => $this->integer()->notNull()->unsigned(),
                    'created_at' => $this->integer()->notNull(),
                    'updated_at' => $this->integer()->notNull(),
                ],
                $tableOptions
            );
            $this->addForeignKey(
                'fk_torrent_creator',
                'torrent',
                'created_by',
                'user',
                'id'
            );
        }

        if (!in_array('torrent_download', $this->getDb()->schema->tableNames)) {
            $this->createTable(
                'torrent_download',
                [
                    'id' => $this->primaryKey(),
                    'torrent_id' => $this->integer()->notNull(),
                    'user_id' => $this->integer()->notNull()->unsigned(),
                    'created_by' => $this->integer()->notNull()->unsigned(),
                    'created_at' => $this->integer()->notNull(),
                    'updated_at' => $this->integer()->notNull(),
                ],
                $tableOptions
            );
            $this->addForeignKey(
                'fk_torrentdownload_user',
                'torrent_download',
                'user_id',
                'user',
                'id'
            );
            $this->addForeignKey(
                'fk_torrentdownload_torrent',
                'torrent_download',
                'torrent_id',
                'torrent',
                'id'
            );
            $this->addForeignKey(
                'fk_torrentdownload_creator',
                'torrent_download',
                'created_by',
                'user',
                'id'
            );
        }

        if (!in_array('game_torrent', $this->getDb()->schema->tableNames)) {
            $this->createTable(
                'game_torrent',
                [
                    'game_id' => $this->integer()->notNull(),
                    'torrent_id' => $this->integer()->notNull(),
                    'created_by' => $this->integer()->notNull()->unsigned(),
                    'created_at' => $this->integer()->notNull(),
                    'updated_at' => $this->integer()->notNull(),
                ],
                $tableOptions
            );

            $this->createIndex(
                'idx-unique-gametorrent-game-torrent',
                'game_torrent',
                [
                    'game_id',
                    'torrent_id'
                ],
                true
            );

            $this->addForeignKey(
                'fk_game_torrent_creator',
                'game_torrent',
                'created_by',
                'user',
                'id'
            );
            $this->addForeignKey(
                'fk_game_torrent_game',
                'game_torrent',
                'game_id',
                'game',
                'id'
            );
            $this->addForeignKey(
                'fk_game_torrent_torrent',
                'game_torrent',
                'torrent_id',
                'torrent',
                'id'
            );
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        if (in_array('game_torrent', $this->getDb()->schema->tableNames)) {
            $gameTorrentTable = \Yii::$app->db->schema->getTableSchema('`game_torrent`');
            if (isset($gameTorrentTable->foreignKeys['fk_game_torrent_torrent'])) {
                $this->dropForeignKey('fk_game_torrent_torrent', 'game_torrent');
            }
            if (isset($gameTorrentTable->foreignKeys['fk_game_torrent_game'])) {
                $this->dropForeignKey('fk_game_torrent_game', 'game_torrent');
            }
            if (isset($gameTorrentTable->foreignKeys['fk_game_torrent_creator'])) {
                $this->dropForeignKey('fk_game_torrent_creator', 'game_torrent');
            }
            $this->dropIndex('idx-unique-gametorrent-game-torrent', 'game_torrent');
            $this->dropTable('game_torrent');
        }

        if (in_array('torrent_download', $this->getDb()->schema->tableNames)) {
            $torrentDownloadTable = \Yii::$app->db->schema->getTableSchema('`torrent_download`');
            if (isset($torrentDownloadTable->foreignKeys['fk_torrentdownload_creator'])) {
                $this->dropForeignKey('fk_torrentdownload_creator', 'torrent_download');
            }
            if (isset($torrentDownloadTable->foreignKeys['fk_torrentdownload_torrent'])) {
                $this->dropForeignKey('fk_torrentdownload_torrent', 'torrent_download');
            }
            if (isset($torrentDownloadTable->foreignKeys['fk_torrentdownload_user'])) {
                $this->dropForeignKey('fk_torrentdownload_user', 'torrent_download');
            }
            $this->dropTable('torrent_download');
        }

        if (in_array('torrent', $this->getDb()->schema->tableNames)) {
            $torrentTable = \Yii::$app->db->schema->getTableSchema('`torrent`');
            if (isset($torrentTable->foreignKeys['fk_torrent_creator'])) {
                $this->dropForeignKey('fk_torrent_creator', 'torrent');
            }
            $this->dropTable('torrent');
        }
    }
}
