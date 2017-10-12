<?php

use yii\db\Migration;

class m170524_195708_create_table_production extends Migration
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

        $this->createTable('production', [

            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'name' => $this->string()->notNull()->defaultValue('Stage 1'),
            'start_weight' => $this->integer()->notNull(),
            'end_weight' => $this->integer()->notNull(),
            'quantity_produced' => $this->integer()->notNull(),
            'quantity_wasted' => $this->integer()->notNull(),
            'actual_prod_date' => $this->string()->notNull(),
            'completed_date' => $this->string()->notNull(),
            'status' => $this->string()->notNull()->defaultValue('Not Started'),
            'active' => $this->boolean()->defaultValue(false),
            'time' => $this->datetime()->notNull(),
            'remarks' => $this->string()->notNull()->defaultValue('Initial'),           
            'created_by' => $this->integer()->notNull(), 
            'updated_by' => $this->integer()->notNull(),      
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),

        ]);

        $this->createIndex(
            'idx-production-id', 
            'production', 
            'id'
        );

        $this->createIndex(
            'idx-production-name', 
            'production', 
            'name'
        );

        $this->createIndex(
            'idx-production-user_id', 
            'production', 
            'user_id'
        );

        // add foreign key for table `user`

        $this->addForeignKey(
            'fk-production-user_id',
            'production',
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
            'fk-production-user_id',
            'production'
        );

        $this->dropIndex(
            'idx-production-user_id', 
            'production'
        );

        $this->dropIndex(
            'idx-production-id', 
            'production'
        );

        $this->dropIndex(
            'idx-production-name', 
            'production'
        );

        $this->dropTable('production');
    }
}
