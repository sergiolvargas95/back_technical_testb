<?php

use yii\db\Migration;

/**
 * Class m220310_124523_product
 */
class m220310_124523_product extends Migration
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

        $this->createTable('{{Product}}', [
            'idProduct' => $this->primaryKey(),
            'title' => $this->string(20)->notNull(),
            'description' => $this->text(20)->notNull(),
            'image' => $this->string(200)->notNull(),
            'unitValue' => $this->integer(40)->notNull(),
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%Product}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220310_124523_product cannot be reverted.\n";

        return false;
    }
    */
}
