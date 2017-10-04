<?php

use yii\db\Migration;

/**
 * Handles the creation of table `production_area`.
 */
class m170125_082004_create_table_production_area extends Migration
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

        $this->createTable('production_area', [

            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'name' => $this->string()->notNull()->defaultValue('Main Area'),
            'code' => $this->string()->notNull()->defaultValue('PA0001'),
            'active' => $this->boolean()->defaultValue(true)->notNull(),
            'remarks' => $this->string()->notNull()->defaultValue(''),     
            'created_by' => $this->integer()->notNull(), 
            'updated_by' => $this->integer()->notNull(),      
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),

        ]);

        $this->createIndex(
            'idx-production_area-id', 
            'production_area', 
            'id'
        );

        $this->createIndex(
            'idx-production_area-user_id', 
            'production_area', 
            'user_id'
        );

        $this->createIndex(
            'idx-production_area-name', 
            'production_area', 
            'name'
        );

        $this->createIndex(
            'idx-production_area-code', 
            'production_area', 
            'code'
        );


        // add foreign key for table `user`

        $this->addForeignKey(
            'fk-production_area-user_id',
            'production_area',
            'user_id',
            'user',
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
            'fk-production_area-user_id',
            'production_area'
        );

        $this->dropIndex(
            'idx-production_area-id', 
            'production_area'
        );

        $this->dropIndex(
            'idx-production_area-user_id', 
            'production_area'
        );

        $this->dropIndex(
            'idx-production_area-name', 
            'production_area'
        );

        $this->dropIndex(
            'idx-production_area-code', 
            'production_area'
        );

        $this->dropTable('production_area');
    }
}
