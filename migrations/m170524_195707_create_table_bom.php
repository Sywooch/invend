<?php

use yii\db\Migration;

class m170524_195707_create_table_bom extends Migration
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

        $this->createTable('bom', [

            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'name' => $this->string()->notNull(),
            'number' => $this->string()->notNull(),
            'description' => $this->string(),
            'production_area_id' => $this->integer(),
            'total_input_cost' => $this->decimal(10,2)->defaultValue(0),
            'active' => $this->boolean()->defaultValue(false),
            'time' => $this->datetime()->notNull(),
            'remarks' => $this->string()->defaultValue(''),           
            'created_by' => $this->integer()->notNull(), 
            'updated_by' => $this->integer()->notNull(),      
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),

        ]);

        $this->createIndex(
            'idx-bom-id', 
            'bom', 
            'id'
        );

        $this->createIndex(
            'idx-bom-name', 
            'bom', 
            'name'
        );

        $this->createIndex(
            'idx-bom-number', 
            'bom', 
            'number'
        );

        $this->createIndex(
            'idx-bom-user_id', 
            'bom', 
            'user_id'
        );

        $this->createIndex(
            'idx-bom-production_area_id', 
            'bom', 
            'production_area_id'
        );

        // add foreign key for table `user`

        $this->addForeignKey(
            'fk-bom-user_id',
            'bom',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );

        // add foreign key for table `production_area`

        $this->addForeignKey(
            'fk-bom-production_area_id',
            'bom',
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
            'fk-bom-user_id',
            'bom'
        );

        $this->dropForeignKey(
            'fk-bom-production_area_id',
            'bom'
        );

        $this->dropIndex(
            'idx-bom-user_id', 
            'bom'
        );

        $this->dropIndex(
            'idx-bom-production_area_id', 
            'bom'
        );

        $this->dropIndex(
            'idx-bom-id', 
            'bom'
        );

        $this->dropIndex(
            'idx-bom-name', 
            'bom'
        );

        $this->dropIndex(
            'idx-bom-number', 
            'bom'
        );

        $this->dropTable('bom');
    }
}
