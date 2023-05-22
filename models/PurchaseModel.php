<?php

// Check for a defined constant or specific file inclusion
if (!defined('MY_APP') && basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    die('This file cannot be accessed directly.');
}

// Model class for users-table in database

class PurchaseModel{
    public $purchase_id;
    public $product_name;
    public $price;
    public $purchase_time;
    public $user_id;
}