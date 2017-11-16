<?php

use yii\db\Migration;

/**
 * Handles the creation of table `expenses`.
 */
class m170125_082004_create_table_expenses extends Migration
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

        $this->createTable('expenses', [

            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'purpose' => $this->string()->notNull(),
            'amount' => $this->decimal(10,2)->notNull(),
            'active' => $this->boolean()->defaultValue(true)->notNull(),
            'notes' => $this->string()->notNull()->defaultValue(''),  
            'time' => $this->datetime()->notNull(),
            'created_by' => $this->integer()->notNull(), 
            'updated_by' => $this->integer()->notNull(),      
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->createIndex(
            'idx-expenses-id', 
            'expenses', 
            'id'
        );

        $this->createIndex(
            'idx-expenses-user_id', 
            'expenses', 
            'user_id'
        );

        // add foreign key for table `user`

        $this->addForeignKey(
            'fk-expenses-user_id',
            'expenses',
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
            'fk-expenses-user_id',
            'expenses'
        );

        $this->dropIndex(
            'idx-expenses-id', 
            'expenses'
        );

        $this->dropIndex(
            'idx-expenses-user_id', 
            'expenses'
        );

        $this->dropTable('expenses');
    }
}
