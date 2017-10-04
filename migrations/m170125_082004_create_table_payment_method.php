<?php

use yii\db\Migration;

/**
 * Handles the creation of table `payment_method`.
 */
class m170125_082004_create_table_payment_method extends Migration
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

        $this->createTable('payment_method', [

            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'name' => $this->string()->notNull()->defaultValue('Cash'),
            'active' => $this->boolean()->defaultValue(true)->notNull(),
            'notes' => $this->string()->notNull()->defaultValue(''),     
            'created_by' => $this->integer()->notNull(), 
            'updated_by' => $this->integer()->notNull(),      
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),

        ]);

        $this->createIndex(
            'idx-payment_method-id', 
            'payment_method', 
            'id'
        );

        $this->createIndex(
            'idx-payment_method-user_id', 
            'payment_method', 
            'user_id'
        );

        $this->createIndex(
            'idx-payment_method-name', 
            'payment_method', 
            'name'
        );


        // add foreign key for table `user`

        $this->addForeignKey(
            'fk-payment_method-user_id',
            'payment_method',
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
            'fk-payment_method-user_id',
            'payment_method'
        );

        $this->dropIndex(
            'idx-payment_method-id', 
            'payment_method'
        );

        $this->dropIndex(
            'idx-payment_method-user_id', 
            'payment_method'
        );

        $this->dropIndex(
            'idx-payment_method-name', 
            'payment_method'
        );

        $this->dropTable('payment_method');
    }
}
