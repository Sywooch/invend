<?php

use yii\db\Migration;

class m170524_195708_create_table_bom_instructions extends Migration
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

        $this->createTable('bom_instructions', [

            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'bom_stages_id' => $this->integer()->notNull(),
            'name' => $this->string()->notNull(),
            'description' => $this->string(),
            'active' => $this->boolean()->defaultValue(false),
            'time' => $this->datetime()->notNull(),
            'remarks' => $this->string()->notNull()->defaultValue('Initial'),           
            'created_by' => $this->integer()->notNull(), 
            'updated_by' => $this->integer()->notNull(),      
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),

        ]);

        $this->createIndex(
            'idx-bom_instructions-id', 
            'bom_instructions', 
            'id'
        );

        $this->createIndex(
            'idx-bom_instructions-name', 
            'bom_instructions', 
            'name'
        );


        $this->createIndex(
            'idx-bom_instructions-user_id', 
            'bom_instructions', 
            'user_id'
        );

        $this->createIndex(
            'idx-bom_instructions-bom_stages_id', 
            'bom_instructions', 
            'bom_stages_id'
        );


        // add foreign key for table `user`

        $this->addForeignKey(
            'fk-bom_instructions-user_id',
            'bom_instructions',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );

        // add foreign key for table `bom_stages`

        $this->addForeignKey(
            'fk-bom_instructions-bom_stages_id',
            'bom_instructions',
            'bom_stages_id',
            'bom_stages',
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
            'fk-bom_instructions-user_id',
            'bom_instructions'
        );

        // drop foreign key for table `bom_stages`

        $this->dropForeignKey(
            'fk-bom_instructions-bom_stages_id',
            'bom_instructions'
        );

        $this->dropIndex(
            'idx-bom_instructions-user_id', 
            'bom_instructions'
        );

        $this->dropIndex(
            'idx-bom_instructions-bom_stages_id', 
            'bom_instructions'
        );

        $this->dropIndex(
            'idx-bom_instructions-id', 
            'bom_instructions'
        );

        $this->dropIndex(
            'idx-bom_instructions-name', 
            'bom_instructions'
        );

        $this->dropTable('bom_instructions');
    }
}
