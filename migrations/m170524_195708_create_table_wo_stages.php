<?php

use yii\db\Migration;

class m170524_195708_create_table_wo_stages extends Migration
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

        $this->createTable('wo_stages', [

            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'name' => $this->string()->notNull(),
            'number' => $this->string()->notNull(),
            'description' => $this->string()->notNull(),
            'status' => $this->string()->notNull()->defaultValue('Not Started'),
            'work_centre_id' => $this->integer(),
            'required_capacity' => $this->integer(),
            'total_input_cost' => $this->decimal(10,2)->defaultValue(0),
            'start_date' => $this->date()->notNull(),
            'active' => $this->boolean()->defaultValue(false),
            'time' => $this->datetime()->notNull(),
            'remarks' => $this->string()->notNull()->defaultValue('Initial'),           
            'created_by' => $this->integer()->notNull(), 
            'updated_by' => $this->integer()->notNull(),      
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),

        ]);

        $this->createIndex(
            'idx-wo_stages-id', 
            'wo_stages', 
            'id'
        );

        $this->createIndex(
            'idx-wo_stages-name', 
            'wo_stages', 
            'name'
        );

        $this->createIndex(
            'idx-wo_stages-user_id', 
            'wo_stages', 
            'user_id'
        );

        $this->createIndex(
            'idx-wo_stages-work_centre_id', 
            'wo_stages', 
            'work_centre_id'
        );

        // add foreign key for table `user`

        $this->addForeignKey(
            'fk-wo_stages-user_id',
            'wo_stages',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );

        // add foreign key for table `work_centre`

        $this->addForeignKey(
            'fk-wo_stages-work_centre_id',
            'wo_stages',
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
            'fk-wo_stages-user_id',
            'wo_stages'
        );

        $this->dropForeignKey(
            'fk-wo_stages-work_centre_id',
            'wo_stages'
        );

        $this->dropIndex(
            'idx-wo_stages-user_id', 
            'wo_stages'
        );

        $this->dropIndex(
            'idx-wo_stages-work_centre_id', 
            'wo_stages'
        );

        $this->dropIndex(
            'idx-wo_stages-id', 
            'wo_stages'
        );

        $this->dropIndex(
            'idx-wo_stages-name', 
            'wo_stages'
        );

        $this->dropTable('wo_stages');
    }
}
