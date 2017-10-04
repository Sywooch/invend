<?php

use yii\db\Migration;

class m170524_195718_insert_data extends Migration
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

        // User Table
        $this->insert('user',array(
            'email'=>'info@phantomgh.com',
            'username' => 'admin',
            'auth_key' => 'Cd4vPaE-c38uSURcXOOCvfVFCFqyXn-1',
            'password_hash' => '$2y$13$63XwUjt116GA0zFqnKvnRODObKmgeT3OHTiMlb.fgkNhXjnil5OyO',
            'status' => 10,
            'created_at' => '1496109620',
            'updated_at' => '1496109620',
        ));

        $this->insert('auth_item',array(
            'name'=>'Systems Administrator',
            'type' => '1',
            'description' => 'Systems Administrator has all privileges .',
            'created_at' => '1496109620',
            'updated_at' => '1496109620',
        ));

        $this->insert('auth_item',array(
            'name'=>'/*',
            'type' => '2',
            'description' => 'All',
            'created_at' => '1496109620',
            'updated_at' => '1496109620',
        ));

        $this->insert('auth_item_child',array(
            'parent'=>'Systems Administrator',
            'child' => '/*',
        ));

        $this->insert('auth_assignment',array(
            'item_name'=>'Systems Administrator',
            'user_id' => '1',
            'created_at' => '1496109620',
        ));

        // uom
        $this->insert('uom',array(
            'name'=>'Kilo',
            'user_id' => 1,
            'active' => 1,
            'created_at' => '1496109620',
            'updated_at' => '1496109620',
            'created_by' => 1,
            'updated_by' => 1
        ));

        $this->insert('uom',array(
            'name'=>'Each',
            'user_id' => 1,
            'active' => 1,
            'created_at' => '1496109620',
            'updated_at' => '1496109620',
            'created_by' => 1,
            'updated_by' => 1
        ));

        $this->insert('uom',array(
            'name'=>'Pieces',
            'user_id' => 1,
            'active' => 1,
            'created_at' => '1496109620',
            'updated_at' => '1496109620',
            'created_by' => 1,
            'updated_by' => 1
        ));

        $this->insert('uom',array(
            'name'=>'Bags',
            'user_id' => 1,
            'active' => 1,
            'created_at' => '1496109620',
            'updated_at' => '1496109620',
            'created_by' => 1,
            'updated_by' => 1
        ));

        $this->insert('uom',array(
            'name'=>'Packs',
            'user_id' => 1,
            'active' => 1,
            'created_at' => '1496109620',
            'updated_at' => '1496109620',
            'created_by' => 1,
            'updated_by' => 1
        ));

        $this->insert('uom',array(
            'name'=>'Bottles',
            'user_id' => 1,
            'active' => 1,
            'created_at' => '1496109620',
            'updated_at' => '1496109620',
            'created_by' => 1,
            'updated_by' => 1
        ));

        $this->insert('uom',array(
            'name'=>'Cases',
            'user_id' => 1,
            'active' => 1,
            'created_at' => '1496109620',
            'updated_at' => '1496109620',
            'created_by' => 1,
            'updated_by' => 1
        ));

        // location
        $this->insert('location',array(
            'name'=>'Main Warehouse',
            'user_id' => 1,
            'active' => 1,
            'created_at' => '1496109620',
            'updated_at' => '1496109620',
            'created_by' => 1,
            'updated_by' => 1
        ));

        // taxing_scheme
        $this->insert('taxing_scheme',array(
            'name'=>'No Tax',
            'user_id' => 1,
            'active' => 1,
            'created_at' => '1496109620',
            'updated_at' => '1496109620',
            'created_by' => 1,
            'updated_by' => 1
        ));

        // product_type
        $this->insert('product_type',array(
            'name'=>'Stocked Product',
            'code'=>'1000',
            'remarks'=>'Use this for products that you want to track how many are in stock',
            'user_id' => 1,
            'active' => 1,
            'created_at' => '1496109620',
            'updated_at' => '1496109620',
            'created_by' => 1,
            'updated_by' => 1
        ));

        $this->insert('product_type',array(
            'name'=>'Non-Stocked Product',
            'code'=>'1001',
            'remarks'=>'Use this for products that you dont need to track how many you have',
            'user_id' => 1,
            'active' => 1,
            'created_at' => '1496109620',
            'updated_at' => '1496109620',
            'created_by' => 1,
            'updated_by' => 1
        ));

        $this->insert('product_type',array(
            'name'=>'Serialized Product',
            'code'=>'1002',
            'remarks'=>'Use this when you want to track the different serial numbers for each individual unit in stock',
            'user_id' => 1,
            'active' => 1,
            'created_at' => '1496109620',
            'updated_at' => '1496109620',
            'created_by' => 1,
            'updated_by' => 1
        ));

        $this->insert('product_type',array(
            'name'=>'Service',
            'code'=>'1003',
            'remarks'=>'Use this for non-physical items',
            'user_id' => 1,
            'active' => 1,
            'created_at' => '1496109620',
            'updated_at' => '1496109620',
            'created_by' => 1,
            'updated_by' => 1
        ));

        // product_category
        $this->insert('product_category',array(
            'name'=>'Default Category',
            'code'=>'1000',
            'remarks'=>'Default Category',
            'user_id' => 1,
            'active' => 1,
            'created_at' => '1496109620',
            'updated_at' => '1496109620',
            'created_by' => 1,
            'updated_by' => 1
        ));

        // Currency
        $this->insert('currency',array(
            'name'=>'Ghana Cedis',
            'prefix'=> 'GHC ',
            'suffix'=> ' ',
            'user_id' => 1,
            'active' => 1,
            'created_at' => '1496109620',
            'updated_at' => '1496109620',
            'created_by' => 1,
            'updated_by' => 1
        ));

        $this->insert('currency',array(
            'name'=>'USA USD',
            'prefix'=> '$ ',
            'suffix'=> ' ',
            'user_id' => 1,
            'active' => 1,
            'created_at' => '1496109620',
            'updated_at' => '1496109620',
            'created_by' => 1,
            'updated_by' => 1
        ));

        // payment_method
        $this->insert('payment_method',array(
            'name'=>'Cash',
            'user_id' => 1,
            'active' => 1,
            'created_at' => '1496109620',
            'updated_at' => '1496109620',
            'created_by' => 1,
            'updated_by' => 1
        ));

        $this->insert('payment_method',array(
            'name'=>'Credit',
            'user_id' => 1,
            'active' => 1,
            'created_at' => '1496109620',
            'updated_at' => '1496109620',
            'created_by' => 1,
            'updated_by' => 1
        ));

        // vendor
        $this->insert('vendor',array(
            'name'=>'Walk In',
            'time'=>'2017-07-10 14:15:00',
            'user_id' => 1,
            'active' => 1,
            'created_at' => '1496109620',
            'updated_at' => '1496109620',
            'created_by' => 1,
            'updated_by' => 1
        ));

        // customer
        $this->insert('customer',array(
            'name'=>'Walk In',
            'time'=>'2017-07-10 14:15:00',
            'user_id' => 1,
            'active' => 1,
            'created_at' => '1496109620',
            'updated_at' => '1496109620',
            'created_by' => 1,
            'updated_by' => 1
        ));

        // status

        $this->insert('status',array(
            'id'=> 1,
            'name'=>'Unreceived, Unpaid',
            'user_id' => 1,
            'active' => 1,
            'created_at' => '1496109620',
            'updated_at' => '1496109620',
            'created_by' => 1,
            'updated_by' => 1
        ));

        $this->insert('status',array(
            'id'=> 2,
            'name'=>'Received, Paid',
            'user_id' => 1,
            'active' => 1,
            'created_at' => '1496109620',
            'updated_at' => '1496109620',
            'created_by' => 1,
            'updated_by' => 1
        ));

        $this->insert('status',array(
            'id'=> 3,
            'name'=>'Received, Unpaid',
            'user_id' => 1,
            'active' => 1,
            'created_at' => '1496109620',
            'updated_at' => '1496109620',
            'created_by' => 1,
            'updated_by' => 1
        ));

        $this->insert('status',array(
            'id'=> 4,
            'name'=>'Unreturned, Unpaid',
            'user_id' => 1,
            'active' => 1,
            'created_at' => '1496109620',
            'updated_at' => '1496109620',
            'created_by' => 1,
            'updated_by' => 1
        ));

        $this->insert('status',array(
            'id'=> 5,
            'name'=>'Returned, Paid',
            'user_id' => 1,
            'active' => 1,
            'created_at' => '1496109620',
            'updated_at' => '1496109620',
            'created_by' => 1,
            'updated_by' => 1
        ));

        $this->insert('status',array(
            'id'=> 6,
            'name'=>'Returned, Unpaid',
            'user_id' => 1,
            'active' => 1,
            'created_at' => '1496109620',
            'updated_at' => '1496109620',
            'created_by' => 1,
            'updated_by' => 1
        ));

        $this->insert('status',array(
            'id'=> 7,
            'name'=>'Unfulfilled, Uninvoiced',
            'user_id' => 1,
            'active' => 1,
            'created_at' => '1496109620',
            'updated_at' => '1496109620',
            'created_by' => 1,
            'updated_by' => 1
        ));

        $this->insert('status',array(
            'id'=> 8,
            'name'=>'Fulfilled, Invoiced',
            'user_id' => 1,
            'active' => 1,
            'created_at' => '1496109620',
            'updated_at' => '1496109620',
            'created_by' => 1,
            'updated_by' => 1
        ));

        $this->insert('status',array(
            'id'=> 9,
            'name'=>'Fulfilled, Uninvoiced',
            'user_id' => 1,
            'active' => 1,
            'created_at' => '1496109620',
            'updated_at' => '1496109620',
            'created_by' => 1,
            'updated_by' => 1
        ));

        $this->insert('status',array(
            'id'=> 10,
            'name'=>'Unreturned, Uninvoiced',
            'user_id' => 1,
            'active' => 1,
            'created_at' => '1496109620',
            'updated_at' => '1496109620',
            'created_by' => 1,
            'updated_by' => 1
        ));

        $this->insert('status',array(
            'id'=> 11,
            'name'=>'Returned, Invoiced',
            'user_id' => 1,
            'active' => 1,
            'created_at' => '1496109620',
            'updated_at' => '1496109620',
            'created_by' => 1,
            'updated_by' => 1
        ));

        $this->insert('status',array(
            'id'=> 12,
            'name'=>'Returned, Uninvoiced',
            'user_id' => 1,
            'active' => 1,
            'created_at' => '1496109620',
            'updated_at' => '1496109620',
            'created_by' => 1,
            'updated_by' => 1
        ));

    }


    /**
     * @inheritdoc

     */

    public function safeDown()
    {
        echo "m130726_010519_insert_user does not support migration down.\n";
    }
}
