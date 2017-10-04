<?php

use yii\db\Migration;

class m170524_194911_create_table_po_return_lines extends Migration
{
    /**
     * @inheritdoc

     */

    public function safeUp()
    {
        $tableOptions = null;

        if ( $this->db->driverName === 'mysql' )
        {
                $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

            
        $this->createTable('po_return_lines', [

            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'po_return_id' => $this->integer()->notNull(),
            'product_id' => $this->integer()->notNull(),
            'item_name' => $this->string()->notNull(),
            'item_code' => $this->string()->notNull(),
            'quantity' => $this->integer()->notNull(),
            'unit_price' => $this->decimal(10,2)->notNull(),
            'discount' => $this->decimal(10,2)->defaultValue(0),
            'sub_total' => $this->decimal(10,2)->notNull(),
            'active' => $this->boolean()->defaultValue(false),
            'time' => $this->datetime()->notNull(),
            'remarks' => $this->string(),           
            'created_by' => $this->integer()->notNull(), 
            'updated_by' => $this->integer()->notNull(),      
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->createIndex(
            'idx-po_return_lines-id', 
            'po_return_lines', 
            'id'
        );

        $this->createIndex(
            'idx-po_return_lines-item_name', 
            'po_return_lines', 
            'item_name'
        );

        $this->createIndex(
            'idx-po_return_lines-item_code', 
            'po_return_lines', 
            'item_code'
        );

        $this->createIndex(
            'idx-po_return_lines-user_id', 
            'po_return_lines', 
            'user_id'
        );

        $this->createIndex(
            'idx-po_return_lines-product_id', 
            'po_return_lines', 
            'product_id'
        );

        $this->createIndex(
            'idx-po_return_lines-po_return_id', 
            'po_return_lines', 
            'po_return_id'
        );

        // add foreign key for table `user`

        $this->addForeignKey(
            'fk-po_return_lines-user_id',
            'po_return_lines',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );

        // add foreign key for table `product`

        $this->addForeignKey(
            'fk-po_return_lines-product_id',
            'po_return_lines',
            'product_id',
            'product',
            'id',
            'CASCADE'
        );

        // add foreign key for table `po_return`

        $this->addForeignKey(
            'fk-po_return_lines-po_return_id',
            'po_return_lines',
            'po_return_id',
            'po_return',
            'id',
            'CASCADE'
        );

    }


    /**

     * @inheritdoc

     */

    public function safeDown()
    {

        // drop foreign key for table `user`

        $this->dropForeignKey(
            'fk-po_return_lines-user_id',
            'po_return_lines'
        );

        // drop foreign key for table `product`

        $this->dropForeignKey(
            'fk-po_return_lines-product_id',
            'po_return_lines'
        );

        // drop foreign key for table `po_return`

        $this->dropForeignKey(
            'fk-po_return_lines-po_return_id',
            'po_return_lines'
        );

        $this->dropIndex(
            'idx-po_return_lines-id', 
            'po_return_lines'
        );

        $this->dropIndex(
            'idx-po_return_lines-item_name', 
            'po_return_lines'
        );

        $this->dropIndex(
            'idx-po_return_lines-item_code', 
            'po_return_lines'
        );

        $this->dropIndex(
            'idx-po_return_lines-user_id', 
            'po_return_lines'
        );

        $this->dropIndex(
            'idx-po_return_lines-product_id', 
            'po_return_lines'
        );

        $this->dropIndex(
            'idx-po_return_lines-po_return_id', 
            'po_return_lines'
        );

        $this->dropTable('po_return_lines');

    }
}
