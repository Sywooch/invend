<?php

use yii\db\Migration;

/**
 * Handles the creation of table `driver`.
 */
class m170125_082004_create_table_driver extends Migration
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

        $this->createTable('driver', [

            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'name' => $this->string()->notNull(),
            'license_number' => $this->string()->notNull(),
            'phone_number' => $this->string()->notNull(),
            'code' => $this->string()->notNull()->defaultValue(''),
            'active' => $this->boolean()->defaultValue(true)->notNull(),
            'employed_date' => $this->string()->notNull(),    
            'time' => $this->datetime()->notNull(),
            'notes' => $this->string()->notNull()->defaultValue(''), 
            'created_by' => $this->integer()->notNull(), 
            'updated_by' => $this->integer()->notNull(),      
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),

        ]);

        $this->createIndex(
            'idx-driver-id', 
            'driver', 
            'id'
        );

        $this->createIndex(
            'idx-driver-user_id', 
            'driver', 
            'user_id'
        );

        $this->createIndex(
            'idx-driver-name', 
            'driver', 
            'name'
        );

        $this->createIndex(
            'idx-driver-license_number', 
            'driver', 
            'license_number'
        );

        $this->createIndex(
            'idx-driver-phone_number', 
            'driver', 
            'phone_number'
        );


        // add foreign key for table `user`

        $this->addForeignKey(
            'fk-driver-user_id',
            'driver',
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
            'fk-driver-user_id',
            'driver'
        );

        $this->dropIndex(
            'idx-driver-id', 
            'driver'
        );

        $this->dropIndex(
            'idx-driver-user_id', 
            'driver'
        );

        $this->dropIndex(
            'idx-driver-name', 
            'driver'
        );

        $this->dropIndex(
            'idx-driver-license_number', 
            'driver'
        );

        $this->dropIndex(
            'idx-driver-phone_number', 
            'driver'
        );

        $this->dropTable('driver');
    }
}
