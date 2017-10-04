<?php

use yii\db\Migration;

class m170524_194911_create_table_po_return extends Migration
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

            
        $this->createTable('po_return', [

            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull()->defaultValue(1),
            'number' => $this->string()->notNull(),
            'location_id' => $this->integer()->notNull()->defaultValue(1),
            'total' => $this->decimal(10,2)->notNull()->defaultValue(0),
            'paid' => $this->decimal(10,2)->notNull()->defaultValue(0),
            'balance' => $this->integer()->notNull()->defaultValue(0),
            'vendor_id' => $this->integer()->notNull()->defaultValue(1),
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
            'idx-po_return-id', 
            'po_return', 
            'id'
        );

        $this->createIndex(
            'idx-po_return-number', 
            'po_return', 
            'number'
        );

        $this->createIndex(
            'idx-po_return-user_id', 
            'po_return', 
            'user_id'
        );

        $this->createIndex(
            'idx-po_return-location_id', 
            'po_return', 
            'location_id'
        );

        $this->createIndex(
            'idx-po_return-vendor_id', 
            'po_return', 
            'vendor_id'
        );

        $this->createIndex(
            'idx-po_return-currency_id', 
            'po_return', 
            'currency_id'
        );

        // add foreign key for table `user`

        $this->addForeignKey(
            'fk-po_return-user_id',
            'po_return',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );

        // add foreign key for table `location`

        $this->addForeignKey(
            'fk-po_return-location_id',
            'po_return',
            'location_id',
            'location',
            'id',
            'CASCADE'
        );

        // add foreign key for table `vendor`

        $this->addForeignKey(
            'fk-po_return-vendor_id',
            'po_return',
            'vendor_id',
            'vendor',
            'id',
            'CASCADE'
        );

        // add foreign key for table `currency`

        $this->addForeignKey(
            'fk-po_return-currency_id',
            'po_return',
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
            'fk-po_return-user_id',
            'po_return'
        );

        // drop foreign key for table `location`

        $this->dropForeignKey(
            'fk-po_return-location_id',
            'po_return'
        );

        // drop foreign key for table `vendor`

        $this->dropForeignKey(
            'fk-po_return-vendor_id',
            'po_return'
        );

        // drop foreign key for table `currency`

        $this->dropForeignKey(
            'fk-po_return-currency_id',
            'po_return'
        );

        $this->dropIndex(
            'idx-po_return-id', 
            'po_return'
        );

        $this->dropIndex(
            'idx-po_return-number', 
            'po_return'
        );

        $this->dropIndex(
            'idx-po_return-user_id', 
            'po_return'
        );

        $this->dropIndex(
            'idx-po_return-location_id', 
            'po_return'
        );

        $this->dropIndex(
            'idx-po_return-vendor_id', 
            'po_return'
        );

        $this->dropIndex(
            'idx-po_return-currency_id', 
            'po_return'
        );

        $this->dropTable('po_return');

    }
}
