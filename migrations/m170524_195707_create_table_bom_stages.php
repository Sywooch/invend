<?php

use yii\db\Migration;

class m170524_195707_create_table_bom_stages extends Migration
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

        $this->createTable('bom_stages', [

            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'bom_id' => $this->integer()->notNull(),
            'name' => $this->string()->notNull(),
            'number' => $this->string()->notNull(),
            'description' => $this->string()->notNull(),
            'work_centre_id' => $this->integer(),
            'required_capacity' => $this->integer(),
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
            'idx-bom_stages-id', 
            'bom_stages', 
            'id'
        );

        $this->createIndex(
            'idx-bom_stages-bom_id', 
            'bom_stages', 
            'bom_id'
        );

        $this->createIndex(
            'idx-bom_stages-name', 
            'bom_stages', 
            'name'
        );

        $this->createIndex(
            'idx-bom_stages-user_id', 
            'bom_stages', 
            'user_id'
        );

        $this->createIndex(
            'idx-bom_stages-work_centre_id', 
            'bom_stages', 
            'work_centre_id'
        );

        // add foreign key for table `user`

        $this->addForeignKey(
            'fk-bom_stages-user_id',
            'bom_stages',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );

        // add foreign key for table `bom`

        $this->addForeignKey(
            'fk-bom_stages-bom_id',
            'bom_stages',
            'bom_id',
            'bom',
            'id',
            'CASCADE'
        );

        // add foreign key for table `work_centre`

        $this->addForeignKey(
            'fk-bom_stages-work_centre_id',
            'bom_stages',
            'work_centre_id',
            'work_centre',
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
            'fk-bom_stages-user_id',
            'bom_stages'
        );

        // drop foreign key for table `bom`

        $this->dropForeignKey(
            'fk-bom_stages-bom_id',
            'bom_stages'
        );

        // drop foreign key for table `work_centre`

        $this->dropForeignKey(
            'fk-bom_stages-work_centre_id',
            'bom_stages'
        );

        $this->dropIndex(
            'idx-bom_stages-user_id', 
            'bom_stages'
        );

        $this->dropIndex(
            'idx-bom_stages-bom_id', 
            'bom_stages'
        );


        $this->dropIndex(
            'idx-bom_stages-work_centre_id', 
            'bom_stages'
        );

        $this->dropIndex(
            'idx-bom_stages-id', 
            'bom_stages'
        );

        $this->dropIndex(
            'idx-bom_stages-name', 
            'bom_stages'
        );

        $this->dropTable('bom_stages');
    }
}
