<?php

use yii\db\Migration;

/**
 * Class m220310_124925_order
 */
class m220310_124925_order extends Migration
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

        $this->createTable('{{Order}}', [
            'idOrder' => $this->primaryKey(),
            'status_request' => $this->Integer()->notNull(),
            'status_distribution' => $this->Integer()->notNull(),
            'date' => $this->date(),
            'purchased_products' => $this->text(),
            'totalPrice' => $this->integer(),
            'idUser' => $this->integer(),
        ], $tableOptions);

            $this->addForeignKey('FK_new_user_order', 'Order', 'idUser', 'new_user', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('FK_new_user_order', 'Order');
        $this->dropTable('{{%Order}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220310_124925_order cannot be reverted.\n";

        return false;
    }
    */
}
