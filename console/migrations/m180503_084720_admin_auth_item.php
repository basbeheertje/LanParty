<?php

use yii\db\Migration;
use yii\base\Exception;
use yii\helpers\VarDumper;
use common\dao\AuthItem;

/**
 * Class m180503_084720_admin_auth_item
 */
class m180503_084720_admin_auth_item extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createIfNotExists("admin",1,"Admin role");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180503_084720_admin_auth_item cannot be reverted.\n";
        return false;
    }

    public function createIfNotExists($name,$type,$description = null,$rule_name = null,$data = null){
        /** @var AuthItem $authItem */
        $authItem = AuthItem::find()->where(['name'=>'admin','type'=>1])->one();
        if(!$authItem){
            $authItem = new AuthItem();
            $authItem->name = $name;
            $authItem->type = $type;
            $authItem->description = $description;
            $authItem->rule_name = $rule_name;
            $authItem->data = $data;
            if(!$authItem->save()){
                throw new Exception("Unable to create auth_item! " . VarDumper::dumpAsString($authItem->getErrors()));
            }
        }
    }
}
