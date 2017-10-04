<?php

use yii\db\Migration;

/**
 * Handles the creation of table `location`.
 */
class m170125_082004_create_table_location extends Migration
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

        $this->createTable('location', [

            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'name' => $this->string()->notNull()->defaultValue('Main Warehouse'),
            'code' => $this->string()->notNull()->defaultValue('0001'),
            'active' => $this->boolean()->defaultValue(true)->notNull(),
            'remarks' => $this->string()->notNull()->defaultValue(''),     
            'created_by' => $this->integer()->notNull(), 
            'updated_by' => $this->integer()->notNull(),      
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),

        ]);

        $this->createIndex(
            'idx-location-id', 
            'location', 
            'id'
        );

        $this->createIndex(
            'idx-location-user_id', 
            'location', 
            'user_id'
        );

        $this->createIndex(
            'idx-location-name', 
            'location', 
            'name'
        );

        $this->createIndex(
            'idx-location-code', 
            'location', 
            'code'
        );


        // add foreign key for table `user`

        $this->addForeignKey(
            'fk-location-user_id',
            'location',
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
            'fk-location-user_id',
            'location'
        );

        $this->dropIndex(
            'idx-location-id', 
            'location'
        );

        $this->dropIndex(
            'idx-location-user_id', 
            'location'
        );

        $this->dropIndex(
            'idx-location-name', 
            'location'
        );

        $this->dropIndex(
            'idx-location-code', 
            'location'
        );

        $this->dropTable('location');
    }
}
