<?php

use yii\db\Migration;

class m170530_192215_create_table_po_documents extends Migration
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

            
        $this->createTable('po_documents', [

            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'po_id' => $this->integer()->notNull(),
            'image_src_filename' => $this->string()->notNull(),
            'image_web_filename' => $this->string()->notNull(),
            'time' => $this->datetime()->notNull(),
            'notes' => $this->string()->notNull(),           
            'created_by' => $this->integer()->notNull(), 
            'updated_by' => $this->integer()->notNull(),      
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->createIndex(
            'idx-po_documents-id', 
            'po_documents', 
            'id'
        );

        $this->createIndex(
            'idx-po_documents-user_id', 
            'po_documents', 
            'user_id'
        );

        $this->createIndex(
            'idx-po_documents-po_id', 
            'po_documents', 
            'po_id'
        );

        $this->createIndex(
            'idx-po_documents-image_src_filename', 
            'po_documents', 
            'image_src_filename'
        );

        $this->createIndex(
            'idx-po_documents-image_web_filename', 
            'po_documents', 
            'image_web_filename'
        );

        // add foreign key for table `user`

        $this->addForeignKey(
            'fk-po_documents-user_id',
            'po_documents',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );

        // add foreign key for table `po`

        $this->addForeignKey(
            'fk-po_documents-po_id',
            'po_documents',
            'po_id',
            'po',
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
            'fk-po_documents-user_id',
            'po_documents'
        );

        // drop foreign key for table `po`

        $this->dropForeignKey(
            'fk-po_documents-po_id',
            'po_documents'
        );

        $this->dropIndex(
            'idx-po_documents-id', 
            'po_documents'
        );

        $this->dropIndex(
            'idx-po_documents-po_id', 
            'po_documents'
        );

        $this->dropIndex(
            'idx-po_documents-user_id', 
            'po_documents'
        );

        $this->dropIndex(
            'idx-po_documents-image_web_filename', 
            'po_documents'
        );

        $this->dropIndex(
            'idx-po_documents-image_src_filename', 
            'po_documents'
        );

        $this->dropTable('po_documents');
    }
}
