<?php

use yii\db\Migration;

/**
 * Handles the creation of table `production_line`.
 */
class m170125_082004_create_table_production_line extends Migration
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

        $this->createTable('production_line', [

            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'production_area_id' => $this->integer()->notNull(),
            'name' => $this->string()->notNull()->defaultValue('Main Line'),
            'code' => $this->string()->notNull()->defaultValue('PL0001'),
            'active' => $this->boolean()->defaultValue(true)->notNull(),
            'remarks' => $this->string()->notNull()->defaultValue(''),     
            'created_by' => $this->integer()->notNull(), 
            'updated_by' => $this->integer()->notNull(),      
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),

        ]);

        $this->createIndex(
            'idx-production_line-id', 
            'production_line', 
            'id'
        );

        $this->createIndex(
            'idx-production_line-user_id', 
            'production_line', 
            'user_id'
        );

        $this->createIndex(
            'idx-production_line-production_area_id', 
            'production_line', 
            'user_id'
        );

        $this->createIndex(
            'idx-production_line-name', 
            'production_line', 
            'name'
        );

        $this->createIndex(
            'idx-production_line-code', 
            'production_line', 
            'code'
        );


        // add foreign key for table `user`

        $this->addForeignKey(
            'fk-production_line-user_id',
            'production_line',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );

        // add foreign key for table `production_area`

        $this->addForeignKey(
            'fk-production_line-production_area_id',
            'production_line',
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
            'fk-production_line-user_id',
            'production_line'
        );

        // drop foreign key for table `production_area`

        $this->dropForeignKey(
            'fk-production_line-production_area_id',
            'production_line'
        );

        $this->dropIndex(
            'idx-production_line-id', 
            'production_line'
        );

        $this->dropIndex(
            'idx-production_line-user_id', 
            'production_line'
        );

        $this->dropIndex(
            'idx-production_line-name', 
            'production_line'
        );

        $this->dropIndex(
            'idx-production_line-code', 
            'production_line'
        );

        $this->dropIndex(
            'idx-production_line-production_area_id', 
            'production_line'
        );

        $this->dropTable('production_line');
    }
}
