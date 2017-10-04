<?php

use yii\db\Migration;

/**
 * Handles the creation of table `company`.
 */
class m170616_014445_create_table_company extends Migration
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

        $this->createTable('company', [

            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'title' => $this->string()->notNull()->defaultValue(''),
            'name' => $this->string()->notNull()->defaultValue(''),
            'contact' => $this->string()->notNull(),
            'address' => $this->string()->notNull()->defaultValue(''),
            'postal_code' => $this->string()->notNull()->defaultValue(''),
            'city' => $this->string()->notNull()->defaultValue(''),
            'region' => $this->string()->notNull(),
            'country' => $this->string()->notNull()->defaultValue(''),
            'active' => $this->boolean()->defaultValue(true)->notNull(),
            'notes' => $this->string()->notNull()->defaultValue(''),     
            'created_by' => $this->integer()->notNull(), 
            'updated_by' => $this->integer()->notNull(),      
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),

        ]);

        $this->createIndex(
            'idx-company-id', 
            'company', 
            'id'
        );

        $this->createIndex(
            'idx-company-user_id', 
            'company', 
            'user_id'
        );

        $this->createIndex(
            'idx-company-name', 
            'company', 
            'name'
        );


        // add foreign key for table `user`

        $this->addForeignKey(
            'fk-company-user_id',
            'company',
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
            'fk-company-user_id',
            'company'
        );

        $this->dropIndex(
            'idx-company-id', 
            'company'
        );

        $this->dropIndex(
            'idx-company-user_id', 
            'company'
        );

        $this->dropIndex(
            'idx-company-name', 
            'company'
        );

        $this->dropTable('company');
    }
}
