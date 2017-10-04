<?php

use yii\db\Migration;

/**
 * Handles the creation of table `taxing_scheme`.
 */
class m170125_082005_create_table_taxing_scheme extends Migration
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

        $this->createTable('taxing_scheme', [

            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'name' => $this->string()->notNull(),
            'active' => $this->boolean()->defaultValue(false)->notNull(),
            'remarks' => $this->string()->notNull()->defaultValue(''),     
            'created_by' => $this->integer()->notNull(), 
            'updated_by' => $this->integer()->notNull(),      
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),

        ]);

        $this->createIndex(
            'idx-taxing_scheme-id', 
            'taxing_scheme', 
            'id'
        );

        $this->createIndex(
            'idx-taxing_scheme-user_id', 
            'taxing_scheme', 
            'user_id'
        );

        $this->createIndex(
            'idx-taxing_scheme-name', 
            'taxing_scheme', 
            'name'
        );


        // add foreign key for table `user`

        $this->addForeignKey(
            'fk-taxing_scheme-user_id',
            'taxing_scheme',
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
            'fk-taxing_scheme-user_id',
            'taxing_scheme'
        );

        $this->dropIndex(
            'idx-taxing_scheme-id', 
            'taxing_scheme'
        );

        $this->dropIndex(
            'idx-taxing_scheme-user_id', 
            'taxing_scheme'
        );

        $this->dropIndex(
            'idx-taxing_scheme-name', 
            'taxing_scheme'
        );

        $this->dropTable('taxing_scheme');
    }
}
