<?php

use yii\db\Migration;

class m170524_194911_create_table_donation extends Migration
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

            
        $this->createTable('donation', [

            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull()->defaultValue(1),
            'number' => $this->string()->notNull(),
            'location_id' => $this->integer()->notNull()->defaultValue(1),
            'product_id' => $this->integer()->notNull(),
            'quantity' => $this->integer()->notNull(),
            'price' => $this->decimal(10,2)->notNull(),
            'status' => $this->integer()->notNull()->defaultValue(1),
            'date' => $this->string()->notNull(),
            'time' => $this->datetime()->notNull(),
            'reason' => $this->string()->notNull(), 
            'notes' => $this->string()->notNull(),        
            'created_by' => $this->integer()->notNull(), 
            'updated_by' => $this->integer()->notNull(),      
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->createIndex(
            'idx-donation-id', 
            'donation', 
            'id'
        );

        $this->createIndex(
            'idx-donation-number', 
            'donation', 
            'number'
        );

        $this->createIndex(
            'idx-donation-user_id', 
            'donation', 
            'user_id'
        );

        $this->createIndex(
            'idx-donation-location_id', 
            'donation', 
            'location_id'
        );

        // add foreign key for table `user`

        $this->addForeignKey(
            'fk-donation-user_id',
            'donation',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );

        // add foreign key for table `location`

        $this->addForeignKey(
            'fk-donation-location_id',
            'donation',
            'location_id',
            'location',
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
            'fk-donation-user_id',
            'donation'
        );

        // drop foreign key for table `location`

        $this->dropForeignKey(
            'fk-donation-location_id',
            'donation'
        );

        $this->dropIndex(
            'idx-donation-id', 
            'donation'
        );

        $this->dropIndex(
            'idx-donation-number', 
            'donation'
        );

        $this->dropIndex(
            'idx-donation-user_id', 
            'donation'
        );

        $this->dropIndex(
            'idx-donation-location_id', 
            'donation'
        );

        $this->dropTable('donation');

    }
}
