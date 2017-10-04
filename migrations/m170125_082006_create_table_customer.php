<?php

use yii\db\Migration;

class m170125_082006_create_table_customer extends Migration
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

        $this->createTable('customer', [

            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'balance' => $this->decimal(10,2)->notNull()->defaultValue(0),
            'credit' => $this->decimal(10,2)->notNull()->defaultValue(0),
            'number' => $this->string()->notNull()->defaultValue(''),
            'name' => $this->string()->notNull(),
            'active' => $this->boolean()->notNull()->defaultValue(false),
            'tax' => $this->boolean()->notNull()->defaultValue(false),
            'address' => $this->string()->notNull()->defaultValue(''),
            'contact' => $this->string()->notNull()->defaultValue(''),
            'phone' => $this->string()->notNull()->defaultValue(''),
            'fax' => $this->string()->notNull()->defaultValue(''),
            'email' => $this->string()->notNull()->defaultValue(''),
            'website' => $this->string()->notNull()->defaultValue(''),
            'payment_terms' => $this->string()->notNull()->defaultValue(''),
            'discount' => $this->decimal(10,2)->notNull()->defaultValue(0),
            'loyalty_point' => $this->decimal(10,2)->notNull()->defaultValue(0),
            'currency_id' => $this->integer()->notNull()->defaultValue(1),
            'taxing_scheme_id' => $this->integer()->notNull()->defaultValue(1),
            'default_location_id' => $this->integer()->notNull()->defaultValue(1),
            'default_sales_rep_id' => $this->integer(),
            'payment_method_id' => $this->integer()->notNull()->defaultValue(1),
            'tax_exempt_number' => $this->string()->defaultValue(''),
            'time' => $this->datetime()->notNull(),
            'remarks' => $this->string(),     
            'created_by' => $this->integer()->notNull(), 
            'updated_by' => $this->integer()->notNull(),      
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),

        ]);

        $this->createIndex(
            'idx-customer-id', 
            'customer', 
            'id'
        );

        $this->createIndex(
            'idx-customer-user_id', 
            'customer', 
            'user_id'
        );

        $this->createIndex(
            'idx-customer-currency_id', 
            'customer', 
            'currency_id'
        );

        $this->createIndex(
            'idx-customer-default_sales_rep_id', 
            'customer', 
            'default_sales_rep_id'
        );

        $this->createIndex(
            'idx-customer-default_location_id', 
            'customer', 
            'default_location_id'
        );

        $this->createIndex(
            'idx-customer-payment_method_id', 
            'customer', 
            'payment_method_id'
        );

        $this->createIndex(
            'idx-customer-taxing_scheme_id', 
            'customer', 
            'taxing_scheme_id'
        );

        $this->createIndex(
            'idx-customer-name', 
            'customer', 
            'name'
        );

        $this->createIndex(
            'idx-customer-number', 
            'customer', 
            'number'
        );

        // add foreign key for table `user`

        $this->addForeignKey(
            'fk-customer-user_id',
            'customer',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );

        // add foreign key for table `taxing_scheme`

        $this->addForeignKey(
            'fk-customer-taxing_scheme_id',
            'customer',
            'taxing_scheme_id',
            'taxing_scheme',
            'id',
            'CASCADE'
        );

        // add foreign key for table `currency`

        $this->addForeignKey(
            'fk-customer-currency_id',
            'customer',
            'currency_id',
            'currency',
            'id',
            'CASCADE'
        );

         // add foreign key for table `location`

        $this->addForeignKey(
            'fk-customer-default_location_id',
            'customer',
            'default_location_id',
            'location',
            'id',
            'CASCADE'
        );

         // add foreign key for table `user`

        $this->addForeignKey(
            'fk-customer-default_sales_rep_id',
            'customer',
            'default_sales_rep_id',
            'user',
            'id',
            'CASCADE'
        );

         // add foreign key for table `payment_method`

        $this->addForeignKey(
            'fk-customer-payment_method_id',
            'customer',
            'payment_method_id',
            'payment_method',
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
            'fk-customer-user_id',
            'customer'
        );

        // drop foreign key for table `taxing_scheme`

        $this->dropForeignKey(
            'fk-customer-taxing_scheme_id',
            'customer'
        );

        // drop foreign key for table `currency`

        $this->dropForeignKey(
            'fk-customer-currency_id',
            'customer'
        );

        // drop foreign key for table `location`

        $this->dropForeignKey(
            'fk-customer-default_location_id',
            'customer'
        );

        // drop foreign key for table `user`

        $this->dropForeignKey(
            'fk-customer-default_sales_rep_id',
            'customer'
        );

        // drop foreign key for table `payment_method`

        $this->dropForeignKey(
            'fk-customer-payment_method_id',
            'customer'
        );

        $this->dropIndex(
            'idx-customer-id', 
            'customer'
        );

        $this->dropIndex(
            'idx-customer-user_id', 
            'customer'
        );

        $this->dropIndex(
            'idx-customer-taxing_scheme_id', 
            'customer'
        );

        $this->dropIndex(
            'idx-customer-currency_id', 
            'customer'
        );

        $this->dropIndex(
            'idx-customer-default_location_id', 
            'customer'
        );

        $this->dropIndex(
            'idx-customer-default_sales_rep_id', 
            'customer'
        );

        $this->dropIndex(
            'idx-customer-payment_method_id', 
            'customer'
        );

        $this->dropIndex(
            'idx-customer-name', 
            'customer'
        );

        $this->dropIndex(
            'idx-customer-number', 
            'customer'
        );

        $this->dropTable('customer');
    }
}
