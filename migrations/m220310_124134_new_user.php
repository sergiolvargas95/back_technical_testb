<?php

use yii\db\Migration;

/**
 * Class m220310_124134_new_user
 */
class m220310_124134_new_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
            if($this->db->driverName === 'mysql') {
                $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
            }

            $this->createTable('{{%new_user}}', [
                'id' => $this->primaryKey(),
                'name' => $this->string(20)->notNull(),
                'lastName' => $this->string(20)->notNull(),
                'username' => $this->string(20)->notNull(),
                'email' => $this->string(40)->notNull()->unique(),
                'address' => $this->string(30)->notNull(),
                'phone' => $this->integer()->notNull(),
                'password' => $this->string(80)->notNull(),
                'status' => $this->smallInteger()->notNull()->defaultValue(10),
                'role' => $this->smallInteger()->notNull()->defaultValue(4),
                'auth_key' => $this->string(32)->notNull(),
            ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%new_user}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220310_124134_new_user cannot be reverted.\n";

        return false;
    }
    */
}
