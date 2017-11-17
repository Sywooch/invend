<?php

use yii\db\Migration;

class m170524_194911_create_table_distribution extends Migration
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

            
        $this->createTable('distribution', [

            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull()->defaultValue(1),
            'number' => $this->string()->notNull(),
            'location_id' => $this->integer()->notNull()->defaultValue(1),
            'product_id' => $this->integer()->notNull(),
            'quantity' => $this->integer()->notNull(),
            'price' => $this->decimal(10,2)->notNull(),
            'driver_id' => $this->integer()->notNull(),
            'status' => $this->integer()->notNull()->defaultValue(1),
            'date' => $this->string()->notNull(),
            'time' => $this->datetime()->notNull(),
            'notes' => $this->string()->notNull(),        
            'created_by' => $this->integer()->notNull(), 
            'updated_by' => $this->integer()->notNull(),      
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->createIndex(
            'idx-distribution-id', 
            'distribution', 
            'id'
        );

        $this->createIndex(
            'idx-distribution-number', 
            'distribution', 
            'number'
        );

        $this->createIndex(
            'idx-distribution-user_id', 
            'distribution', 
            'user_id'
        );

        $this->createIndex(
            'idx-distribution-location_id', 
            'distribution', 
            'location_id'
        );

        $this->createIndex(
            'idx-distribution-driver_id', 
            'distribution', 
            'driver_id'
        );

        // add foreign key for table `user`

        $this->addForeignKey(
            'fk-distribution-user_id',
            'distribution',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );

        // add foreign key for table `location`

        $this->addForeignKey(
            'fk-distribution-location_id',
            'distribution',
            'location_id',
            'location',
            'id',
            'CASCADE'
        );

        // add foreign key for table `driver`

        $this->addForeignKey(
            'fk-distribution-driver_id',
            'distribution',
            'driver_id',
            'driver',
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
            'fk-distribution-user_id',
            'distribution'
        );

        // drop foreign key for table `location`

        $this->dropForeignKey(
            'fk-distribution-location_id',
            'distribution'
        );

        // drop foreign key for table `driver`

        $this->dropForeignKey(
            'fk-distribution-driver_id',
            'distribution'
        );

        $this->dropIndex(
            'idx-distribution-id', 
            'distribution'
        );

        $this->dropIndex(
            'idx-distribution-number', 
            'distribution'
        );

        $this->dropIndex(
            'idx-distribution-user_id', 
            'distribution'
        );

        $this->dropIndex(
            'idx-distribution-location_id', 
            'distribution'
        );

        $this->dropIndex(
            'idx-distribution-driver_id', 
            'distribution'
        );

        $this->dropTable('distribution');

    }
}
