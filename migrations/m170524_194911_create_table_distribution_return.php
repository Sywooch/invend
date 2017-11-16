<?php

use yii\db\Migration;

class m170524_194911_create_table_distribution_return extends Migration
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

            
        $this->createTable('distribution_return', [

            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull()->defaultValue(1),
            'number' => $this->string()->notNull(),
            'location_id' => $this->integer()->notNull()->defaultValue(1),
            'product_id' => $this->integer()->notNull(),
            'quantity' => $this->integer()->notNull(),
            'price' => $this->decimal(10,2)->notNull(),
            'driver_id' => $this->integer()->notNull()->defaultValue(1),
            'status' => $this->integer()->notNull()->defaultValue(1),
            'date' => $this->string()->notNull(),
            'time' => $this->datetime()->notNull(),
            'reason' => $this->integer()->notNull(),        
            'created_by' => $this->integer()->notNull(), 
            'updated_by' => $this->integer()->notNull(),      
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->createIndex(
            'idx-distribution_return-id', 
            'distribution_return', 
            'id'
        );

        $this->createIndex(
            'idx-distribution_return-number', 
            'distribution_return', 
            'number'
        );

        $this->createIndex(
            'idx-distribution_return-user_id', 
            'distribution_return', 
            'user_id'
        );

        $this->createIndex(
            'idx-distribution_return-location_id', 
            'distribution_return', 
            'location_id'
        );

        $this->createIndex(
            'idx-distribution_return-driver_id', 
            'distribution_return', 
            'driver_id'
        );

        // add foreign key for table `user`

        $this->addForeignKey(
            'fk-distribution_return-user_id',
            'distribution_return',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );

        // add foreign key for table `location`

        $this->addForeignKey(
            'fk-distribution_return-location_id',
            'distribution_return',
            'location_id',
            'location',
            'id',
            'CASCADE'
        );

        // add foreign key for table `driver`

        $this->addForeignKey(
            'fk-distribution_return-driver_id',
            'distribution_return',
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
            'fk-distribution_return-user_id',
            'distribution_return'
        );

        // drop foreign key for table `location`

        $this->dropForeignKey(
            'fk-distribution_return-location_id',
            'distribution_return'
        );

        // drop foreign key for table `driver`

        $this->dropForeignKey(
            'fk-distribution_return-driver_id',
            'distribution_return'
        );

        $this->dropIndex(
            'idx-distribution_return-id', 
            'distribution_return'
        );

        $this->dropIndex(
            'idx-distribution_return-number', 
            'distribution_return'
        );

        $this->dropIndex(
            'idx-distribution_return-user_id', 
            'distribution_return'
        );

        $this->dropIndex(
            'idx-distribution_return-location_id', 
            'distribution_return'
        );

        $this->dropIndex(
            'idx-distribution_return-driver_id', 
            'distribution_return'
        );

        $this->dropTable('distribution_return');

    }
}
