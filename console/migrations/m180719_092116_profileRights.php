<?php

use yii\db\Migration;
use yii\base\Exception;
use yii\helpers\VarDumper;
use common\dao\AuthItem;
use common\dao\AuthItemChild;

/**
 * Class m180719_092116_profileRights
 */
class m180719_092116_profileRights extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createIfNotExists("player", "/profile/index");
        $this->createIfNotExists("player", "/profile/view");
        $this->createIfNotExists("player", "/torrent/view");
        $this->createIfNotExists("player", "/profile/set-playing");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180719_092116_profileRights cannot be reverted.\n";

        return false;
    }

    public function createIfNotExists($parent, $child)
    {
        /** @var AuthItemChild $authItemChild */
        $authItemChild = AuthItemChild::find()->where(['parent' => $parent, 'child' => $child])->one();
        if (!$authItemChild) {
            /** @var AuthItem $authItem */
            $authItem = AuthItem::find()->where(['name' => $child])->one();
            if (!$authItem) {
                $authItem = new AuthItem();
                $authItem->name = $child;
                $authItem->type = 2;
                $authItem->rule_name = null;
                if (!$authItem->save()) {
                    throw new Exception("Unable to create authItem(" . $child . ")! " . VarDumper::dumpAsString($authItem->getErrors()));
                }
            }
            $authItemChild = new AuthItemChild();
            $authItemChild->parent = $parent;
            $authItemChild->child = $child;
            if (!$authItemChild->save()) {
                throw new Exception("Unable to create auth_item_child(" . $child . ")! " . VarDumper::dumpAsString($authItemChild->getErrors()));
            }
        }
    }
}
