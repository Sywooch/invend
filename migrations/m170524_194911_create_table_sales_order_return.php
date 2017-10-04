<?php

use yii\db\Migration;

class m170524_194911_create_table_sales_order_return extends Migration
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

            
        $this->createTable('sales_order_return', [

            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull()->defaultValue(1),
            'number' => $this->string()->notNull(),
            'location_id' => $this->integer()->notNull()->defaultValue(1),
            'total' => $this->decimal(10,2)->notNull()->defaultValue(0),
            'paid' => $this->decimal(10,2)->notNull()->defaultValue(0),
            'balance' => $this->integer()->notNull()->defaultValue(0),
            'customer_id' => $this->integer()->notNull()->defaultValue(1),
            'sales_rep_id' => $this->integer()->notNull()->defaultValue(1),
            'currency_id' => $this->integer()->notNull()->defaultValue(1),
            'status' => $this->integer()->notNull()->defaultValue(1),
            'cancel' => $this->boolean()->defaultValue(false),
            'cancel_date' => $this->string(),
            'cancel_reason' => $this->string(),
            'date' => $this->string()->notNull(),
            'due_date' => $this->string()->notNull(),
            'time' => $this->datetime()->notNull(),
            'remarks' => $this->string()->defaultValue('Unfulfilled, Unpaid'),   
            'reason' => $this->integer()->notNull(),        
            'created_by' => $this->integer()->notNull(), 
            'updated_by' => $this->integer()->notNull(),      
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->createIndex(
            'idx-sales_order_return-id', 
            'sales_order_return', 
            'id'
        );


        $this->createIndex(
            'idx-sales_order_return-sales_rep_id', 
            'sales_order_return', 
            'sales_rep_id'
        );

        $this->createIndex(
            'idx-sales_order_return-number', 
            'sales_order_return', 
            'number'
        );

        $this->createIndex(
            'idx-sales_order_return-user_id', 
            'sales_order_return', 
            'user_id'
        );

        $this->createIndex(
            'idx-sales_order_return-location_id', 
            'sales_order_return', 
            'location_id'
        );

        $this->createIndex(
            'idx-sales_order_return-customer_id', 
            'sales_order_return', 
            'customer_id'
        );

        $this->createIndex(
            'idx-sales_order_return-currency_id', 
            'sales_order_return', 
            'currency_id'
        );

        // add foreign key for table `user`

        $this->addForeignKey(
            'fk-sales_order_return-user_id',
            'sales_order_return',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );

        // add foreign key for table `user`

        $this->addForeignKey(
            'fk-sales_order_return-sales_rep_id',
            'sales_order_return',
            'sales_rep_id',
            'user',
            'id',
            'CASCADE'
        );

        // add foreign key for table `location`

        $this->addForeignKey(
            'fk-sales_order_return-location_id',
            'sales_order_return',
            'location_id',
            'location',
            'id',
            'CASCADE'
        );

        // add foreign key for table `customer`

        $this->addForeignKey(
            'fk-sales_order_return-customer_id',
            'sales_order_return',
            'customer_id',
            'customer',
            'id',
            'CASCADE'
        );

        // add foreign key for table `currency`

        $this->addForeignKey(
            'fk-sales_order_return-currency_id',
            'sales_order_return',
            'currency_id',
            'currency',
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
            'fk-sales_order_return-user_id',
            'sales_order_return'
        );

        // drop foreign key for table `user`

        $this->dropForeignKey(
            'fk-sales_order_return-sales_rep_id',
            'sales_order_return'
        );

        // drop foreign key for table `location`

        $this->dropForeignKey(
            'fk-sales_order_return-location_id',
            'sales_order_return'
        );

        // drop foreign key for table `customer`

        $this->dropForeignKey(
            'fk-sales_order_return-customer_id',
            'sales_order_return'
        );

        // drop foreign key for table `currency`

        $this->dropForeignKey(
            'fk-sales_order_return-currency_id',
            'sales_order_return'
        );

        $this->dropIndex(
            'idx-sales_order_return-id', 
            'sales_order_return'
        );

        $this->dropIndex(
            'idx-sales_order_return-number', 
            'sales_order_return'
        );

        $this->dropIndex(
            'idx-sales_order_return-user_id', 
            'sales_order_return'
        );

        $this->dropIndex(
            'idx-sales_order_return-sales_rep_id', 
            'sales_order_return'
        );


        $this->dropIndex(
            'idx-sales_order_return-location_id', 
            'sales_order_return'
        );

        $this->dropIndex(
            'idx-sales_order_return-customer_id', 
            'sales_order_return'
        );

        $this->dropIndex(
            'idx-sales_order_return-currency_id', 
            'sales_order_return'
        );

        $this->dropTable('sales_order_return');

    }
}
