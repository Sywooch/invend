<?php

use yii\db\Migration;

class m170524_195708_create_table_wo_outputs extends Migration
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

        $this->createTable('wo_outputs', [

            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'bom_id' => $this->integer()->notNull(),
            'product_id' => $this->integer()->notNull(),
            'number' => $this->string()->notNull(),
            'quantity_type' => $this->string()->notNull(),
            'unit_quantity' => $this->integer()->notNull(),
            'total_quantity_expected' => $this->integer()->notNull(),
            'unit_quantity' => $this->integer()->notNull(),
            'quantity_in_progress' => $this->integer()->notNull(),
            'quantity_produced' => $this->integer()->notNull(),
            'quantity_written_off' => $this->integer()->notNull(),
            'last_cost' => $this->decimal(10,2)->notNull(),
            'cost' => $this->decimal(10,2)->notNull(),
            'cost_percentage' => $this->decimal(10,2)->notNull(),
            'primary' => $this->boolean()->defaultValue(false),
            'active' => $this->boolean()->defaultValue(false),
            'time' => $this->datetime()->notNull(),
            'remarks' => $this->string()->notNull()->defaultValue('Initial'),           
            'created_by' => $this->integer()->notNull(), 
            'updated_by' => $this->integer()->notNull(),      
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),

        ]);

        $this->createIndex(
            'idx-wo_outputs-id', 
            'wo_outputs', 
            'id'
        );

        $this->createIndex(
            'idx-wo_outputs-product_id', 
            'wo_outputs', 
            'product_id'
        );

        $this->createIndex(
            'idx-wo_outputs-number', 
            'wo_outputs', 
            'number'
        );

        $this->createIndex(
            'idx-wo_outputs-user_id', 
            'wo_outputs', 
            'user_id'
        );

        $this->createIndex(
            'idx-wo_outputs-bom_id', 
            'wo_outputs', 
            'bom_id'
        );

        // add foreign key for table `product`

        $this->addForeignKey(
            'fk-wo_outputs-product_id',
            'wo_outputs',
            'product_id',
            'product',
            'id',
            'CASCADE'
        );

        // add foreign key for table `user`

        $this->addForeignKey(
            'fk-wo_outputs-user_id',
            'wo_outputs',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );

        // add foreign key for table `bom`

        $this->addForeignKey(
            'fk-wo_outputs-bom_id',
            'wo_outputs',
            'bom_id',
            'bom',
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
            'fk-wo_outputs-user_id',
            'wo_outputs'
        );

        // drop foreign key for table `product`

        $this->dropForeignKey(
            'fk-wo_outputs-product_id',
            'wo_outputs'
        );

        // drop foreign key for table `bom`

        $this->dropForeignKey(
            'fk-wo_outputs-bom_id',
            'wo_outputs'
        );

        $this->dropIndex(
            'idx-wo_outputs-user_id', 
            'wo_outputs'
        );

        $this->dropIndex(
            'idx-wo_outputs-bom_id', 
            'wo_outputs'
        );

        $this->dropIndex(
            'idx-wo_outputs-id', 
            'wo_outputs'
        );

        $this->dropIndex(
            'idx-wo_outputs-product_id', 
            'wo_outputs'
        );

        $this->dropIndex(
            'idx-wo_outputs-number', 
            'wo_outputs'
        );

        $this->dropTable('wo_outputs');
    }
}
