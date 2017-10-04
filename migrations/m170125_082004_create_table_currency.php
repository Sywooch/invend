<?php

use yii\db\Migration;

/**
 * Handles the creation of table `currency`.
 */
class m170125_082004_create_table_currency extends Migration
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

        $this->createTable('currency', [

            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'name' => $this->string()->notNull()->defaultValue('All'),
            'prefix' => $this->string()->notNull(),
            'suffix' => $this->string()->notNull()->defaultValue(''),
            'active' => $this->boolean()->defaultValue(true)->notNull(),
            'notes' => $this->string()->notNull()->defaultValue(''),     
            'created_by' => $this->integer()->notNull(), 
            'updated_by' => $this->integer()->notNull(),      
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),

        ]);

        $this->createIndex(
            'idx-currency-id', 
            'currency', 
            'id'
        );

        $this->createIndex(
            'idx-currency-user_id', 
            'currency', 
            'user_id'
        );

        $this->createIndex(
            'idx-currency-name', 
            'currency', 
            'name'
        );


        // add foreign key for table `user`

        $this->addForeignKey(
            'fk-currency-user_id',
            'currency',
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
            'fk-currency-user_id',
            'currency'
        );

        $this->dropIndex(
            'idx-currency-id', 
            'currency'
        );

        $this->dropIndex(
            'idx-currency-user_id', 
            'currency'
        );

        $this->dropIndex(
            'idx-currency-name', 
            'currency'
        );

        $this->dropTable('currency');
    }
}
