<?php

use yii\db\Migration;

/**
 * Handles the creation of table `work_centre`.
 */
class m170125_082004_create_table_work_centre extends Migration
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

        $this->createTable('work_centre', [

            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'production_line_id' => $this->integer()->notNull(),
            'name' => $this->string()->notNull()->defaultValue('Main Centre'),
            'code' => $this->string()->notNull()->defaultValue('WC0001'),
            'active' => $this->boolean()->defaultValue(true)->notNull(),
            'remarks' => $this->string()->notNull()->defaultValue(''),     
            'created_by' => $this->integer()->notNull(), 
            'updated_by' => $this->integer()->notNull(),      
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),

        ]);

        $this->createIndex(
            'idx-work_centre-id', 
            'work_centre', 
            'id'
        );

        $this->createIndex(
            'idx-work_centre-production_line_id', 
            'work_centre', 
            'production_line_id'
        );

        $this->createIndex(
            'idx-work_centre-user_id', 
            'work_centre', 
            'user_id'
        );

        $this->createIndex(
            'idx-work_centre-name', 
            'work_centre', 
            'name'
        );

        $this->createIndex(
            'idx-work_centre-code', 
            'work_centre', 
            'code'
        );


        // add foreign key for table `user`

        $this->addForeignKey(
            'fk-work_centre-user_id',
            'work_centre',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );

        // add foreign key for table `production_line`

        $this->addForeignKey(
            'fk-work_centre-production_line_id',
            'work_centre',
            'production_line_id',
            'production_line',
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
            'fk-work_centre-user_id',
            'work_centre'
        );

        // drop foreign key for table `production_line`

        $this->dropForeignKey(
            'fk-work_centre-production_line_id',
            'work_centre'
        );

        $this->dropIndex(
            'idx-work_centre-id', 
            'work_centre'
        );

        $this->dropIndex(
            'idx-work_centre-user_id', 
            'work_centre'
        );

        $this->dropIndex(
            'idx-work_centre-name', 
            'work_centre'
        );

        $this->dropIndex(
            'idx-work_centre-code', 
            'work_centre'
        );

        $this->dropIndex(
            'idx-work_centre-production_line_id', 
            'work_centre'
        );

        $this->dropTable('work_centre');
    }
}
