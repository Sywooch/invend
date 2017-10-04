<?php

use yii\db\Migration;

class m170524_195708_create_table_stock_adjustment extends Migration
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

        $this->createTable('stock_adjustment', [

            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'number' => $this->string()->notNull(),
            'product_id' => $this->integer()->notNull(),
            'location_id' => $this->integer()->notNull(),
            'new_quantity' => $this->integer()->notNull(),
            'old_quantity' => $this->integer()->notNull(),
            'difference' => $this->integer()->notNull(),
            'date' => $this->date()->notNull(),
            'active' => $this->boolean()->defaultValue(false),
            'time' => $this->datetime()->notNull(),
            'status' => $this->string()->notNull()->defaultValue('UnSaved'), 
            'remarks' => $this->string()->defaultValue(''),           
            'created_by' => $this->integer()->notNull(), 
            'updated_by' => $this->integer()->notNull(),      
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->createIndex(
            'idx-stock_adjustment-id', 
            'stock_adjustment', 
            'id'
        );

        $this->createIndex(
            'idx-stock_adjustment-number', 
            'stock_adjustment', 
            'number'
        );

        $this->createIndex(
            'idx-stock_adjustment-user_id', 
            'stock_adjustment', 
            'user_id'
        );

        $this->createIndex(
            'idx-stock_adjustment-product_id', 
            'stock_adjustment', 
            'product_id'
        );

        $this->createIndex(
            'idx-stock_adjustment-location_id', 
            'stock_adjustment', 
            'location_id'
        );

        // add foreign key for table `user`

        $this->addForeignKey(
            'fk-stock_adjustment-user_id',
            'stock_adjustment',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );

        // add foreign key for table `product`

        $this->addForeignKey(
            'fk-stock_adjustment-product_id',
            'stock_adjustment',
            'product_id',
            'product',
            'id',
            'CASCADE'
        );

        // add foreign key for table `location`

        $this->addForeignKey(
            'fk-stock_adjustment-location_id',
            'stock_adjustment',
            'location_id',
            'location',
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
            'fk-stock_adjustment-user_id',
            'stock_adjustment'
        );

        // drop foreign key for table `product`

        $this->dropForeignKey(
            'fk-stock_adjustment-product_id',
            'stock_adjustment'
        );

        // drop foreign key for table `location`

        $this->dropForeignKey(
            'fk-stock_adjustment-location_id',
            'stock_adjustment'
        );

        $this->dropIndex(
            'idx-stock_adjustment-user_id', 
            'stock_adjustment'
        );

        $this->dropIndex(
            'idx-stock_adjustment-product_id', 
            'stock_adjustment'
        );

        $this->dropIndex(
            'idx-stock_adjustment-id', 
            'stock_adjustment'
        );

        $this->dropIndex(
            'idx-stock_adjustment-number', 
            'stock_adjustment'
        );

        $this->dropIndex(
            'idx-stock_adjustment-location_id', 
            'stock_adjustment'
        );

        $this->dropTable('stock_adjustment');
    }
}
