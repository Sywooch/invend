<?php

use yii\db\Migration;

class m170524_195708_create_table_bom_components extends Migration
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

        $this->createTable('bom_components', [

            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'bom_stages_id' => $this->integer()->notNull(),
            'product_id' => $this->integer()->notNull()->defaultValue(0),
            'number' => $this->string()->notNull(),
            'quantity_type' => $this->string()->notNull(),
            'quantity' => $this->integer()->notNull()->defaultValue(0),
            'last_cost' => $this->decimal(10,2)->notNull()->defaultValue(0),
            'total_line_cost' => $this->decimal(10,2)->defaultValue(0),
            'uom_id' => $this->integer(),
            'active' => $this->boolean()->defaultValue(false),
            'time' => $this->datetime()->notNull(),
            'remarks' => $this->string()->notNull()->defaultValue(''),           
            'created_by' => $this->integer()->notNull(), 
            'updated_by' => $this->integer()->notNull(),      
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),

        ]);

        $this->createIndex(
            'idx-bom_components-id', 
            'bom_components', 
            'id'
        );

        $this->createIndex(
            'idx-bom_components-user_id', 
            'bom_components', 
            'user_id'
        );

        $this->createIndex(
            'idx-bom_components-bom_stages_id', 
            'bom_components', 
            'bom_stages_id'
        );

        $this->createIndex(
            'idx-bom_components-product_id', 
            'bom_components', 
            'product_id'
        );

        $this->createIndex(
            'idx-bom_components-uom_id', 
            'bom_components', 
            'uom_id'
        );

        // add foreign key for table `user`

        $this->addForeignKey(
            'fk-bom_components-user_id',
            'bom_components',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );

        // add foreign key for table `product`

        $this->addForeignKey(
            'fk-bom_components-product_id',
            'bom_components',
            'product_id',
            'product',
            'id',
            'CASCADE'
        );

        // add foreign key for table `bom_stages`

        $this->addForeignKey(
            'fk-bom_components-bom_stages_id',
            'bom_components',
            'bom_stages_id',
            'bom_stages',
            'id',
            'CASCADE'
        );

        // add foreign key for table `uom`

        $this->addForeignKey(
            'fk-bom_components-uom_id',
            'bom_components',
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
            'fk-bom_components-user_id',
            'bom_components'
        );

        // drop foreign key for table `product`

        $this->dropForeignKey(
            'fk-bom_components-product_id',
            'bom_components'
        );

        // drop foreign key for table `bom_stages`

        $this->dropForeignKey(
            'fk-bom_components-bom_stages_id',
            'bom_components'
        );

        $this->dropForeignKey(
            'fk-bom_components-uom_id',
            'bom_components'
        );

        $this->dropIndex(
            'idx-bom_components-user_id', 
            'bom_components'
        );

        $this->dropIndex(
            'idx-bom_components-bom_stages_id', 
            'bom_components'
        );

        $this->dropIndex(
            'idx-bom_components-uom_id', 
            'bom_components'
        );

        $this->dropIndex(
            'idx-bom_components-product_id', 
            'bom_components'
        );

        $this->dropIndex(
            'idx-bom_components-id', 
            'bom_components'
        );

        $this->dropTable('bom_components');
    }
}
