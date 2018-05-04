<?php

use yii\db\Migration;
use yii\base\Exception;
use yii\helpers\VarDumper;
use common\dao\AuthItem;

/**
 * Class m180503_085848_default_auth_items
 */
class m180503_075848_default_auth_items extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createIfNotExists("/", 2);
        $this->createIfNotExists("/*", 2);
        $this->createIfNotExists("/admin/*", 2);
        $this->createIfNotExists("/admin/assignment/*", 2);
        $this->createIfNotExists("/admin/assignment/assign", 2);
        $this->createIfNotExists("/admin/assignment/index", 2);
        $this->createIfNotExists("/admin/assignment/revoke", 2);
        $this->createIfNotExists("/admin/assignment/view", 2);
        $this->createIfNotExists("/admin/default/*", 2);
        $this->createIfNotExists("/admin/default/index", 2);
        $this->createIfNotExists("/admin/menu/*", 2);
        $this->createIfNotExists("/admin/menu/create", 2);
        $this->createIfNotExists("/admin/menu/delete", 2);
        $this->createIfNotExists("/admin/menu/index", 2);
        $this->createIfNotExists("/admin/menu/update", 2);
        $this->createIfNotExists("/admin/menu/view", 2);
        $this->createIfNotExists("/admin/permission/*", 2);
        $this->createIfNotExists("/admin/permission/assign", 2);
        $this->createIfNotExists("/admin/permission/create", 2);
        $this->createIfNotExists("/admin/permission/delete", 2);
        $this->createIfNotExists("/admin/permission/index", 2);
        $this->createIfNotExists("/admin/permission/remove", 2);
        $this->createIfNotExists("/admin/permission/update", 2);
        $this->createIfNotExists("/admin/permission/view", 2);
        $this->createIfNotExists("/admin/role/*", 2);
        $this->createIfNotExists("/admin/role/assign", 2);
        $this->createIfNotExists("/admin/role/create", 2);
        $this->createIfNotExists("/admin/role/delete", 2);
        $this->createIfNotExists("/admin/role/index", 2);
        $this->createIfNotExists("/admin/role/remove", 2);
        $this->createIfNotExists("/admin/role/update", 2);
        $this->createIfNotExists("/admin/role/view", 2);
        $this->createIfNotExists("/admin/route/*", 2);
        $this->createIfNotExists("/admin/route/assign", 2);
        $this->createIfNotExists("/admin/route/create", 2);
        $this->createIfNotExists("/admin/route/index", 2);
        $this->createIfNotExists("/admin/route/refresh", 2);
        $this->createIfNotExists("/admin/route/remove", 2);
        $this->createIfNotExists("/admin/rule/*", 2);
        $this->createIfNotExists("/admin/rule/create", 2);
        $this->createIfNotExists("/admin/rule/delete", 2);
        $this->createIfNotExists("/admin/rule/index", 2);
        $this->createIfNotExists("/admin/rule/update", 2);
        $this->createIfNotExists("/admin/rule/view", 2);
        $this->createIfNotExists("/admin/user/*", 2);
        $this->createIfNotExists("/admin/user/activate", 2);
        $this->createIfNotExists("/admin/user/change-password", 2);
        $this->createIfNotExists("/admin/user/delete", 2);
        $this->createIfNotExists("/admin/user/index", 2);
        $this->createIfNotExists("/admin/user/login", 2);
        $this->createIfNotExists("/admin/user/logout", 2);
        $this->createIfNotExists("/admin/user/request-password-reset", 2);
        $this->createIfNotExists("/admin/user/reset-password", 2);
        $this->createIfNotExists("/admin/user/signup", 2);
        $this->createIfNotExists("/admin/user/view", 2);
        $this->createIfNotExists("/audit/*", 2);
        $this->createIfNotExists("/gii/*", 2);
        $this->createIfNotExists("/gii/default/*", 2);
        $this->createIfNotExists("/gii/default/action", 2);
        $this->createIfNotExists("/gii/default/diff", 2);
        $this->createIfNotExists("/gii/default/index", 2);
        $this->createIfNotExists("/gii/default/preview", 2);
        $this->createIfNotExists("/gii/default/view", 2);
        $this->createIfNotExists("/site/*", 2);
        $this->createIfNotExists("/site/captcha", 2);
        $this->createIfNotExists("/site/error", 2);
        $this->createIfNotExists("/site/index", 2);
        $this->createIfNotExists("/site/login", 2);
        $this->createIfNotExists("/site/logout", 2);
        $this->createIfNotExists("/site/request-password-reset", 2);
        $this->createIfNotExists("/site/reset-password", 2);
        $this->createIfNotExists("/site/signup", 2);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180503_085848_default_auth_items cannot be reverted.\n";
        return false;
    }

    public function createIfNotExists($name, $type, $description = null, $rule_name = null, $data = null)
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        if (!in_array('auth_item', $this->getDb()->schema->tableNames)) {
            require_once(Yii::getAlias('@vendor/yiisoft/yii2/rbac/migrations/m140506_102106_rbac_init.php'));
            $migration = new m140506_102106_rbac_init();
            $migration->up();
        }

        /** @var AuthItem $authItem */
        $authItem = AuthItem::find()->where(['name' => $name, 'type' => $type])->one();
        if (!$authItem) {
            $authItem = new AuthItem();
            $authItem->name = $name;
            $authItem->type = $type;
            $authItem->description = $description;
            $authItem->rule_name = $rule_name;
            $authItem->data = $data;
            $authItem->created_at = time();
            $authItem->updated_at = time();
            if (!$authItem->save()) {
                throw new Exception("Unable to create auth_item! " . VarDumper::dumpAsString($authItem->getErrors()));
            }
        }
    }
}
