<?php

use yii\db\Migration;

class m170125_082007_create_table_transactions extends Migration
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

            
        $this->createTable('transactions', [

            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'account' => $this->string()->notNull(),
            'type' => $this->string()->notNull(),
            'credit' => $this->string()->notNull(),
            'debit' => $this->string()->notNull(),
            'date' => $this->string()->notNull(),
            'time' => $this->datetime()->notNull(),
            'remarks' => $this->string()->notNull(),           
            'created_by' => $this->integer()->notNull(), 
            'updated_by' => $this->integer()->notNull(),      
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->createIndex(
            'idx-transactions-id', 
            'transactions', 
            'id'
        );

        $this->createIndex(
            'idx-transactions-account', 
            'transactions', 
            'account'
        );

        $this->createIndex(
            'idx-transactions-date', 
            'transactions', 
            'date'
        );

        $this->createIndex(
            'idx-transactions-type', 
            'transactions', 
            'type'
        );

        $this->createIndex(
            'idx-transactions-user_id', 
            'transactions', 
            'user_id'
        );

        // add foreign key for table `user`

        $this->addForeignKey(
            'fk-transactions-user_id',
            'transactions',
            'user_id',
            'user',
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
            'fk-transactions-user_id',
            'transactions'
        );

        $this->dropIndex(
            'idx-transactions-id', 
            'transactions'
        );

        $this->dropIndex(
            'idx-transactions-account', 
            'transactions'
        );

        $this->dropIndex(
            'idx-transactions-type', 
            'transactions'
        );

        $this->dropIndex(
            'idx-transactions-user_id', 
            'transactions'
        );

        $this->dropTable('transactions');

    }
}
