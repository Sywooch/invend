<?php

use yii\db\Migration;

class m170125_082007_create_table_product extends Migration
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

            
        $this->createTable('product', [

            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'item_name' => $this->string()->notNull(),
            'item_code' => $this->string()->notNull(),
            'item_description' => $this->string()->defaultValue(''),
            'product_type_id' => $this->integer()->notNull(),
            'product_category_id' => $this->integer()->defaultValue(1),
            'barcode' => $this->string(),
            'reorder_point' => $this->integer()->defaultValue(0),
            'reorder_quantity' => $this->integer()->defaultValue(0),
            'default_location_id' => $this->integer()->defaultValue(1),
            'last_vendor_id' => $this->integer(),
            'standard_uom_id' => $this->integer(),
            'sales_uom_id' => $this->integer(),
            'purchasing_uom_id' => $this->integer(),
            'length' => $this->integer()->defaultValue(0),
            'width' => $this->integer()->defaultValue(0),
            'height' => $this->integer()->defaultValue(0),
            'weight' => $this->integer()->defaultValue(0),
            'cost' => $this->decimal(10,2)->defaultValue(0),
            'normal_price' => $this->decimal(10,2)->defaultValue(0),
            'retail_price' => $this->decimal(10,2)->defaultValue(0),
            'wholesale_price' => $this->decimal(10,2)->defaultValue(0),
            'active' => $this->boolean()->defaultValue(false),
            'time' => $this->datetime()->notNull(),
            'remarks' => $this->string()->notNull(),           
            'created_by' => $this->integer()->notNull(), 
            'updated_by' => $this->integer()->notNull(),      
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->createIndex(
            'idx-product-id', 
            'product', 
            'id'
        );

        $this->createIndex(
            'idx-product-item_name', 
            'product', 
            'item_name'
        );

        $this->createIndex(
            'idx-product-item_code', 
            'product', 
            'item_code'
        );

        $this->createIndex(
            'idx-product-user_id', 
            'product', 
            'user_id'
        );

        $this->createIndex(
            'idx-product-default_location_id', 
            'product', 
            'default_location_id'
        );

        $this->createIndex(
            'idx-product-last_vendor_id', 
            'product', 
            'last_vendor_id'
        );

        $this->createIndex(
            'idx-product-standard_uom_id', 
            'product', 
            'standard_uom_id'
        );

        $this->createIndex(
            'idx-product-sales_uom_id', 
            'product', 
            'sales_uom_id'
        );

        $this->createIndex(
            'idx-product-purchasing_uom_id', 
            'product', 
            'purchasing_uom_id'
        );

        $this->createIndex(
            'idx-product-product_type_id', 
            'product', 
            'product_type_id'
        );

        $this->createIndex(
            'idx-product-product_category_id', 
            'product', 
            'product_category_id'
        );

        // add foreign key for table `user`

        $this->addForeignKey(
            'fk-product-user_id',
            'product',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );

        // add foreign key for table `location`

        $this->addForeignKey(
            'fk-product-default_location_id',
            'product',
            'default_location_id',
            'location',
            'id',
            'CASCADE'
        );

        // add foreign key for table `vendor`

        $this->addForeignKey(
            'fk-product-last_vendor_id',
            'product',
            'last_vendor_id',
            'vendor',
            'id',
            'CASCADE'
        );

        // add foreign key for table `uom`

        $this->addForeignKey(
            'fk-product-standard_uom_id',
            'product',
            'standard_uom_id',
            'uom',
            'id',
            'CASCADE'
        );

        // add foreign key for table `uom`

        $this->addForeignKey(
            'fk-product-sales_uom_id',
            'product',
            'sales_uom_id',
            'uom',
            'id',
            'CASCADE'
        );

        // add foreign key for table `uom`

        $this->addForeignKey(
            'fk-product-purchasing_uom_id',
            'product',
            'purchasing_uom_id',
            'uom',
            'id',
            'CASCADE'
        );

        // add foreign key for table `product_type`

        $this->addForeignKey(
            'fk-product-product_type_id',
            'product',
            'product_type_id',
            'product_type',
            'id',
            'CASCADE'
        );

        // add foreign key for table `product_category`

        $this->addForeignKey(
            'fk-product-product_category_id',
            'product',
            'product_category_id',
            'product_category',
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
            'fk-product-user_id',
            'product'
        );

        // drop foreign key for table `location`

        $this->dropForeignKey(
            'fk-product-default_location_id',
            'product'
        );

        // drop foreign key for table `vendor`

        $this->dropForeignKey(
            'fk-product-last_vendor_id',
            'product'
        );

        // drop foreign key for table `uom`

        $this->dropForeignKey(
            'fk-product-standard_uom_id',
            'product'
        );

        // drop foreign key for table `uom`

        $this->dropForeignKey(
            'fk-product-sales_uom_id',
            'product'
        );

        // drop foreign key for table `uom`

        $this->dropForeignKey(
            'fk-product-purchasing_uom_id',
            'product'
        );

        // drop foreign key for table `product_type`

        $this->dropForeignKey(
            'fk-product-product_type_id',
            'product'
        );

        // drop foreign key for table `product_category`

        $this->dropForeignKey(
            'fk-product-product_category_id',
            'product'
        );

        $this->dropIndex(
            'idx-product-id', 
            'product'
        );

        $this->dropIndex(
            'idx-product-item_name', 
            'product'
        );

        $this->dropIndex(
            'idx-product-item_code', 
            'product'
        );

        $this->dropIndex(
            'idx-product-user_id', 
            'product'
        );

        $this->dropIndex(
            'idx-product-default_location_id', 
            'product'
        );

        $this->dropIndex(
            'idx-product-last_vendor_id', 
            'product'
        );

        $this->dropIndex(
            'idx-product-standard_uom_id', 
            'product'
        );

        $this->dropIndex(
            'idx-product-sales_uom_id', 
            'product'
        );

        $this->dropIndex(
            'idx-product-purchasing_uom_id', 
            'product'
        );

        $this->dropIndex(
            'idx-product-product_type_id', 
            'product'
        );

        $this->dropIndex(
            'idx-product-product_category_id', 
            'product'
        );

        $this->dropTable('product');

    }
}
