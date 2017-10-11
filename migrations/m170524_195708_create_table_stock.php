<?php

use yii\db\Migration;

class m170524_195708_create_table_stock extends Migration
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

        $this->createTable('stock', [

            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull()->defaultValue(1),
            'product_id' => $this->integer()->notNull(),
            'product_category_id' => $this->integer()->notNull(),
            'location_id' => $this->integer()->notNull()->defaultValue(1),
            'last_vendor_id' => $this->integer()->defaultValue(1),
            'quantity' => $this->integer()->notNull(),
            'active' => $this->boolean()->defaultValue(false),
            'time' => $this->datetime()->notNull(),
            'remarks' => $this->string()->defaultValue(''),           
            'created_by' => $this->integer()->notNull(), 
            'updated_by' => $this->integer()->notNull(),      
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->createIndex(
            'idx-stock-id', 
            'stock', 
            'id'
        );

        $this->createIndex(
            'idx-stock-user_id', 
            'stock', 
            'user_id'
        );

        $this->createIndex(
            'idx-stock-product_id', 
            'stock', 
            'product_id'
        );

        $this->createIndex(
            'idx-stock-product_category_id', 
            'stock', 
            'product_category_id'
        );

        $this->createIndex(
            'idx-stock-location_id', 
            'stock', 
            'location_id'
        );

        $this->createIndex(
            'idx-stock-last_vendor_id', 
            'stock', 
            'last_vendor_id'
        );

        // add foreign key for table `user`

        $this->addForeignKey(
            'fk-stock-user_id',
            'stock',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );

        // add foreign key for table `product`

        $this->addForeignKey(
            'fk-stock-product_id',
            'stock',
            'product_id',
            'product',
            'id',
            'CASCADE'
        );

        // add foreign key for table `product_category`

        $this->addForeignKey(
            'fk-stock-product_category_id',
            'stock',
            'product_category_id',
            'product_category',
            'id',
            'CASCADE'
        );

        // add foreign key for table `location`

        $this->addForeignKey(
            'fk-stock-location_id',
            'stock',
            'location_id',
            'location',
            'id',
            'CASCADE'
        );

        // add foreign key for table `vendor`

        $this->addForeignKey(
            'fk-stock-last_vendor_id',
            'stock',
            'last_vendor_id',
            'vendor',
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
            'fk-stock-user_id',
            'stock'
        );

        // drop foreign key for table `product`

        $this->dropForeignKey(
            'fk-stock-product_id',
            'stock'
        );

        // drop foreign key for table `product_category`

        $this->dropForeignKey(
            'fk-stock-product_category_id',
            'stock'
        );

        // drop foreign key for table `location`

        $this->dropForeignKey(
            'fk-stock-location_id',
            'stock'
        );

        // drop foreign key for table `vendor`

        $this->dropForeignKey(
            'fk-stock-last_vendor_id',
            'stock'
        );

        $this->dropIndex(
            'idx-stock-user_id', 
            'stock'
        );

        $this->dropIndex(
            'idx-stock-product_id', 
            'stock'
        );

        $this->dropIndex(
            'idx-stock-id', 
            'stock'
        );

        $this->dropIndex(
            'idx-stock-product_category_id', 
            'stock'
        );

        $this->dropIndex(
            'idx-stock-location_id', 
            'stock'
        );

        $this->dropIndex(
            'idx-stock-last_vendor_id', 
            'stock'
        );

        $this->dropTable('stock');
    }
}
