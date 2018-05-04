<?php

use yii\db\Migration;
use common\dao\AuthItemChild;
use yii\base\Exception;
use yii\helpers\VarDumper;

/**
 * Class m180504_140643_adminAuthItemChilds
 */
class m180504_140643_adminAuthItemChilds extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createIfNotExists("admin","/*");
        $this->createIfNotExists("player","/site/*");
        $this->createIfNotExists("player","/game/index");
        $this->createIfNotExists("player","/game/view");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180504_140643_adminAuthItemChilds cannot be reverted.\n";
        return false;
    }

    public function createIfNotExists($parent,$child)
    {
        /** @var AuthItemChild $authItemChild */
        $authItemChild = AuthItemChild::find()->where(['parent' => $parent, 'child' => $child])->one();
        if (!$authItemChild) {
            $authItemChild = new AuthItemChild();
            $authItemChild->parent = $parent;
            $authItemChild->child = $child;
            if (!$authItemChild->save()) {
                throw new Exception("Unable to create auth_item_child! " . VarDumper::dumpAsString($authItemChild->getErrors()));
            }
        }
    }
}
