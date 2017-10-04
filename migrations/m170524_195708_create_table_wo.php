<?php

use yii\db\Migration;

class m170524_195708_create_table_wo extends Migration
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

        $this->createTable('wo', [

            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'bom_id' => $this->integer()->notNull(),
            'name' => $this->string()->notNull(),
            'number' => $this->string()->notNull(),
            'description' => $this->string(),
            'production_area_id' => $this->integer(),
            'production_quantity' => $this->integer()->notNull(),
            'planned_prod_date' => $this->datetime()->notNull(),
            'required_by' => $this->datetime()->notNull(),
            'max_prod_capability' => $this->integer(),
            'actual_prod_date' => $this->datetime()->notNull(),
            'completed_date' => $this->datetime()->notNull(),
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
            'idx-wo-id', 
            'wo', 
            'id'
        );

        $this->createIndex(
            'idx-wo-name', 
            'wo', 
            'name'
        );

        $this->createIndex(
            'idx-wo-number', 
            'wo', 
            'number'
        );

        $this->createIndex(
            'idx-wo-user_id', 
            'wo', 
            'user_id'
        );

        $this->createIndex(
            'idx-wo-bom_id', 
            'wo', 
            'bom_id'
        );

        $this->createIndex(
            'idx-wo-production_area_id', 
            'wo', 
            'production_area_id'
        );

        // add foreign key for table `user`

        $this->addForeignKey(
            'fk-wo-user_id',
            'wo',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );

        // add foreign key for table `bom`

        $this->addForeignKey(
            'fk-wo-bom_id',
            'wo',
            'bom_id',
            'bom',
            'id',
            'CASCADE'
        );

        // add foreign key for table `production_area`

        $this->addForeignKey(
            'fk-wo-production_area_id',
            'wo',
            'production_area_id',
            'production_area',
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
            'fk-wo-user_id',
            'wo'
        );

        // drop foreign key for table `bom`

        $this->dropForeignKey(
            'fk-wo-bom_id',
            'wo'
        );

        // drop foreign key for table `production_area`
        
        $this->dropForeignKey(
            'fk-wo-production_area_id',
            'wo'
        );

        $this->dropIndex(
            'idx-wo-user_id', 
            'wo'
        );

        $this->dropIndex(
            'idx-wo-production_area_id', 
            'wo'
        );

        $this->dropIndex(
            'idx-wo-id', 
            'wo'
        );

        $this->dropIndex(
            'idx-wo-bom_id', 
            'wo'
        );

        $this->dropIndex(
            'idx-wo-name', 
            'wo'
        );

        $this->dropIndex(
            'idx-wo-number', 
            'wo'
        );

        $this->dropTable('wo');
    }
}
