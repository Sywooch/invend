<?php

use yii\db\Migration;

class m170524_195708_create_table_wo_components extends Migration
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

        $this->createTable('wo_components', [

            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'bom_stages_id' => $this->integer()->notNull(),
            'product_id' => $this->integer()->notNull(),
            'number' => $this->string()->notNull(),
            'quantity_type' => $this->string()->notNull(),
            'unit_quantity' => $this->integer()->notNull()->defaultValue(0),
            'total_quantity' => $this->integer()->notNull()->defaultValue(0),
            'total_stock_on_hand' => $this->integer()->notNull()->defaultValue(0),
            'total_stock_available' => $this->integer()->defaultValue(0),
            'quantity_taken' => $this->integer()->notNull()->defaultValue(0),
            'quantity_backorder' => $this->integer()->notNull()->defaultValue(0),
            'quantity_wastage' => $this->integer()->notNull()->defaultValue(0),
            'last_cost' => $this->decimal(10,2)->notNull()->defaultValue(0),
            'uom_id' => $this->integer(),
            'active' => $this->boolean()->defaultValue(false),
            'time' => $this->datetime()->notNull(),
            'remarks' => $this->string()->notNull()->defaultValue('Initial'),           
            'created_by' => $this->integer()->notNull(), 
            'updated_by' => $this->integer()->notNull(),      
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),

        ]);

        $this->createIndex(
            'idx-wo_components-id', 
            'wo_components', 
            'id'
        );

        $this->createIndex(
            'idx-wo_components-product_id', 
            'wo_components', 
            'product_id'
        );

        $this->createIndex(
            'idx-wo_components-number', 
            'wo_components', 
            'number'
        );

        $this->createIndex(
            'idx-wo_components-user_id', 
            'wo_components', 
            'user_id'
        );

        $this->createIndex(
            'idx-wo_components-bom_stages_id', 
            'wo_components', 
            'bom_stages_id'
        );

        $this->createIndex(
            'idx-wo_components-uom_id', 
            'wo_components', 
            'uom_id'
        );

        // add foreign key for table `user`

        $this->addForeignKey(
            'fk-wo_components-user_id',
            'wo_components',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );

        // add foreign key for table `product`

        $this->addForeignKey(
            'fk-wo_components-product_id',
            'wo_components',
            'product_id',
            'product',
            'id',
            'CASCADE'
        );

        // add foreign key for table `bom_stages`

        $this->addForeignKey(
            'fk-wo_components-bom_stages_id',
            'wo_components',
            'bom_stages_id',
            'bom_stages',
            'id',
            'CASCADE'
        );

        // add foreign key for table `uom`

        $this->addForeignKey(
            'fk-wo_components-uom_id',
            'wo_components',
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
            'fk-wo_components-user_id',
            'wo_components'
        );

        // drop foreign key for table `product`

        $this->dropForeignKey(
            'fk-wo_components-product_id',
            'wo_components'
        );

        // drop foreign key for table `bom_stages`

        $this->dropForeignKey(
            'fk-wo_components-bom_stages_id',
            'wo_components'
        );

        $this->dropForeignKey(
            'fk-wo_components-uom_id',
            'wo_components'
        );

        $this->dropIndex(
            'idx-wo_components-user_id', 
            'wo_components'
        );

        $this->dropIndex(
            'idx-wo_components-bom_stages_id', 
            'wo_components'
        );

        $this->dropIndex(
            'idx-wo_components-uom_id', 
            'wo_components'
        );

        $this->dropIndex(
            'idx-wo_components-id', 
            'wo_components'
        );

        $this->dropIndex(
            'idx-wo_components-product_id', 
            'wo_components'
        );

        $this->dropIndex(
            'idx-wo_components-number', 
            'wo_components'
        );

        $this->dropTable('wo_components');
    }
}
