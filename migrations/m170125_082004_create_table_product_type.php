<?php

use yii\db\Migration;

/**
 * Handles the creation of table `product_type`.
 */
class m170125_082004_create_table_product_type extends Migration
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

        $this->createTable('product_type', [

            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'name' => $this->string()->notNull(),
            'code' => $this->string()->notNull()->defaultValue(''),
            'active' => $this->boolean()->defaultValue(true)->notNull(),
            'remarks' => $this->string()->notNull()->defaultValue(''),     
            'created_by' => $this->integer()->notNull(), 
            'updated_by' => $this->integer()->notNull(),      
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),

        ]);

        $this->createIndex(
            'idx-product_type-id', 
            'product_type', 
            'id'
        );

        $this->createIndex(
            'idx-product_type-user_id', 
            'product_type', 
            'user_id'
        );

        $this->createIndex(
            'idx-product_type-name', 
            'product_type', 
            'name'
        );

        $this->createIndex(
            'idx-product_type-code', 
            'product_type', 
            'code'
        );


        // add foreign key for table `user`

        $this->addForeignKey(
            'fk-product_type-user_id',
            'product_type',
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
            'fk-product_type-user_id',
            'product_type'
        );

        $this->dropIndex(
            'idx-product_type-id', 
            'product_type'
        );

        $this->dropIndex(
            'idx-product_type-user_id', 
            'product_type'
        );

        $this->dropIndex(
            'idx-product_type-name', 
            'product_type'
        );

        $this->dropIndex(
            'idx-product_type-code', 
            'product_type'
        );

        $this->dropTable('product_type');
    }
}
