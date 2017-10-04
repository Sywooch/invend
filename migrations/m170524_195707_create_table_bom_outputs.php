<?php

use yii\db\Migration;

class m170524_195707_create_table_bom_outputs extends Migration
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

        $this->createTable('bom_outputs', [

            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'bom_id' => $this->integer()->notNull(),
            'product_id' => $this->integer()->notNull(),
            'number' => $this->string()->notNull(),
            'quantity_type' => $this->string()->notNull(),
            'quantity' => $this->integer()->notNull(),
            'last_cost' => $this->decimal(10,2)->notNull(),
            'cost' => $this->decimal(10,2)->notNull(),
            'cost_percentage' => $this->decimal(10,2)->notNull(),
            'uom_id' => $this->integer(),
            'primary' => $this->boolean()->defaultValue(false),
            'active' => $this->boolean()->defaultValue(false),
            'time' => $this->datetime()->notNull(),
            'remarks' => $this->string()->defaultValue(''),           
            'created_by' => $this->integer()->notNull(), 
            'updated_by' => $this->integer()->notNull(),      
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),

        ]);

        $this->createIndex(
            'idx-bom_outputs-id', 
            'bom_outputs', 
            'id'
        );

        $this->createIndex(
            'idx-bom_outputs-product_id', 
            'bom_outputs', 
            'product_id'
        );

        $this->createIndex(
            'idx-bom_outputs-number', 
            'bom_outputs', 
            'number'
        );

        $this->createIndex(
            'idx-bom_outputs-user_id', 
            'bom_outputs', 
            'user_id'
        );

        $this->createIndex(
            'idx-bom_outputs-bom_id', 
            'bom_outputs', 
            'bom_id'
        );

        $this->createIndex(
            'idx-bom_outputs-uom_id', 
            'bom_outputs', 
            'uom_id'
        );

        // add foreign key for table `user`

        $this->addForeignKey(
            'fk-bom_outputs-user_id',
            'bom_outputs',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );

        // add foreign key for table `product`

        $this->addForeignKey(
            'fk-bom_outputs-product_id',
            'bom_outputs',
            'product_id',
            'product',
            'id',
            'CASCADE'
        );

        // add foreign key for table `bom`

        $this->addForeignKey(
            'fk-bom_outputs-bom_id',
            'bom_outputs',
            'bom_id',
            'bom',
            'id',
            'CASCADE'
        );

        // add foreign key for table `uom`

        $this->addForeignKey(
            'fk-bom_outputs-uom_id',
            'bom_outputs',
            'uom_id',
            'uom',
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
            'fk-bom_outputs-user_id',
            'bom_outputs'
        );

        // drop foreign key for table `product`

        $this->dropForeignKey(
            'fk-bom_outputs-product_id',
            'bom_outputs'
        );

        // drop foreign key for table `bom`

        $this->dropForeignKey(
            'fk-bom_outputs-bom_id',
            'bom_outputs'
        );

        // drop foreign key for table `uom`

        $this->dropForeignKey(
            'fk-bom_outputs-uom_id',
            'bom_outputs'
        );

        $this->dropIndex(
            'idx-bom_outputs-user_id', 
            'bom_outputs'
        );

        $this->dropIndex(
            'idx-bom_outputs-bom_id', 
            'bom_outputs'
        );

        $this->dropIndex(
            'idx-bom_outputs-id', 
            'bom_outputs'
        );

        $this->dropIndex(
            'idx-bom_outputs-product_id', 
            'bom_outputs'
        );

        $this->dropIndex(
            'idx-bom_outputs-number', 
            'bom_outputs'
        );

        $this->dropTable('bom_outputs');
    }
}
