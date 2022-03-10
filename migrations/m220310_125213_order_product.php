<?php

use yii\db\Migration;

/**
 * Class m220310_125213_order_product
 */
class m220310_125213_order_product extends Migration
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

        $this->createTable('{{Order_product}}', [
            'idOrderProduct' => $this->primaryKey(),
            'idOrder' => $this->integer(),
            'idProduct' => $this->integer(),
            'productQuantity' => $this->integer(),
        ], $tableOptions);

        $this->addForeignKey('FK_order_product_order', 'Order_product', 'idOrder', 'Order', 'idOrder');
        $this->addForeignKey('FK_order_product_product', 'Order_product', 'idProduct', 'Product', 'idProduct');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('FK_order_product_order', 'Order_product');
        $this->dropForeignKey('FK_order_product_product', 'Order_product');
        $this->dropTable('{{%Order_product}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220310_125213_order_product cannot be reverted.\n";

        return false;
    }
    */
}
