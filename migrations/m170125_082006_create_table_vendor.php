<?php

use yii\db\Migration;

class m170125_082006_create_table_vendor extends Migration
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

        $this->createTable('vendor', [

            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull()->defaultValue(1),
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
            'currency_id' => $this->integer()->notNull()->defaultValue(1),
            'payment_method_id' => $this->integer()->notNull()->defaultValue(1),
            'taxing_scheme_id' => $this->integer()->notNull()->defaultValue(1),
            'time' => $this->datetime()->notNull(),
            'remarks' => $this->string(),     
            'created_by' => $this->integer()->notNull(), 
            'updated_by' => $this->integer()->notNull(),      
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),

        ]);

        $this->createIndex(
            'idx-vendor-id', 
            'vendor', 
            'id'
        );

        $this->createIndex(
            'idx-vendor-user_id', 
            'vendor', 
            'user_id'
        );

        $this->createIndex(
            'idx-vendor-payment_method_id', 
            'vendor', 
            'payment_method_id'
        );

        $this->createIndex(
            'idx-vendor-currency_id', 
            'vendor', 
            'currency_id'
        );

        $this->createIndex(
            'idx-vendor-taxing_scheme_id', 
            'vendor', 
            'taxing_scheme_id'
        );

        $this->createIndex(
            'idx-vendor-name', 
            'vendor', 
            'name'
        );

        $this->createIndex(
            'idx-vendor-number', 
            'vendor', 
            'number'
        );

        // add foreign key for table `user`

        $this->addForeignKey(
            'fk-vendor-user_id',
            'vendor',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );

        // add foreign key for table `taxing_scheme`

        $this->addForeignKey(
            'fk-vendor-taxing_scheme_id',
            'vendor',
            'taxing_scheme_id',
            'taxing_scheme',
            'id',
            'CASCADE'
        );

        // add foreign key for table `payment_method`

        $this->addForeignKey(
            'fk-vendor-payment_method_id',
            'vendor',
            'payment_method_id',
            'payment_method',
            'id',
            'CASCADE'
        );

        // add foreign key for table `currency`

        $this->addForeignKey(
            'fk-vendor-currency_id',
            'vendor',
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
            'fk-vendor-user_id',
            'vendor'
        );

        // drop foreign key for table `taxing_scheme`

        $this->dropForeignKey(
            'fk-vendor-taxing_scheme_id',
            'vendor'
        );

        // drop foreign key for table `payment_method`

        $this->dropForeignKey(
            'fk-vendor-payment_method_id',
            'vendor'
        );

        // drop foreign key for table `currency`

        $this->dropForeignKey(
            'fk-vendor-currency_id',
            'vendor'
        );

        $this->dropIndex(
            'idx-vendor-id', 
            'vendor'
        );

        $this->dropIndex(
            'idx-vendor-user_id', 
            'vendor'
        );

        $this->dropIndex(
            'idx-vendor-taxing_scheme_id', 
            'vendor'
        );

        $this->dropIndex(
            'idx-vendor-currency_id', 
            'vendor'
        );

        $this->dropIndex(
            'idx-vendor-name', 
            'vendor'
        );

        $this->dropIndex(
            'idx-vendor-number', 
            'vendor'
        );

        $this->dropTable('vendor');
    }
}
