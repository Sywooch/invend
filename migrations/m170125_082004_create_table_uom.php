<?php

use yii\db\Migration;

/**
 * Handles the creation of table `currency`.
 */
class m170125_082004_create_table_uom extends Migration
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

        $this->createTable('uom', [

            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'name' => $this->string()->notNull()->defaultValue('All'),
            'active' => $this->boolean()->defaultValue(true)->notNull(),
            'remarks' => $this->string()->notNull()->defaultValue(''),     
            'created_by' => $this->integer()->notNull(), 
            'updated_by' => $this->integer()->notNull(),      
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),

        ]);

        $this->createIndex(
            'idx-uom-id', 
            'uom', 
            'id'
        );

        $this->createIndex(
            'idx-uom-user_id', 
            'uom', 
            'user_id'
        );

        $this->createIndex(
            'idx-uom-name', 
            'uom', 
            'name'
        );


        // add foreign key for table `user`

        $this->addForeignKey(
            'fk-uom-user_id',
            'uom',
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
            'fk-uom-user_id',
            'uom'
        );

        $this->dropIndex(
            'idx-uom-id', 
            'uom'
        );

        $this->dropIndex(
            'idx-uom-user_id', 
            'uom'
        );

        $this->dropIndex(
            'idx-uom-name', 
            'uom'
        );

        $this->dropTable('uom');
    }
}
