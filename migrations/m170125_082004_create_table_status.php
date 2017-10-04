<?php

use yii\db\Migration;

/**
 * Handles the creation of table `status`.
 */
class m170125_082004_create_table_status extends Migration
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

        $this->createTable('status', [

            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'name' => $this->string()->notNull()->defaultValue(''),
            'active' => $this->boolean()->defaultValue(true)->notNull(),
            'notes' => $this->string()->notNull()->defaultValue(''),     
            'created_by' => $this->integer()->notNull(), 
            'updated_by' => $this->integer()->notNull(),      
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),

        ]);

        $this->createIndex(
            'idx-status-id', 
            'status', 
            'id'
        );

        $this->createIndex(
            'idx-status-user_id', 
            'status', 
            'user_id'
        );

        $this->createIndex(
            'idx-status-name', 
            'status', 
            'name'
        );


        // add foreign key for table `user`

        $this->addForeignKey(
            'fk-status-user_id',
            'status',
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
            'fk-status-user_id',
            'status'
        );

        $this->dropIndex(
            'idx-status-id', 
            'status'
        );

        $this->dropIndex(
            'idx-status-user_id', 
            'status'
        );

        $this->dropIndex(
            'idx-status-name', 
            'status'
        );

        $this->dropTable('status');
    }
}
