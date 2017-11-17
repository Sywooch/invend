<?php

use yii\db\Migration;

class m170524_194911_create_table_wastage extends Migration
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

            
        $this->createTable('wastage', [

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
            'notes' => $this->string(),        
            'created_by' => $this->integer()->notNull(), 
            'updated_by' => $this->integer()->notNull(),      
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->createIndex(
            'idx-wastage-id', 
            'wastage', 
            'id'
        );

        $this->createIndex(
            'idx-wastage-number', 
            'wastage', 
            'number'
        );

        $this->createIndex(
            'idx-wastage-user_id', 
            'wastage', 
            'user_id'
        );

        // add foreign key for table `user`

        $this->addForeignKey(
            'fk-wastage-user_id',
            'wastage',
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
            'fk-wastage-user_id',
            'wastage'
        );

        $this->dropIndex(
            'idx-wastage-id', 
            'wastage'
        );

        $this->dropIndex(
            'idx-wastage-number', 
            'wastage'
        );

        $this->dropIndex(
            'idx-wastage-user_id', 
            'wastage'
        );

        $this->dropTable('wastage');

    }
}
