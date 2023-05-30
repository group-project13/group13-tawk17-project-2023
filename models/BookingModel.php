<?php

// Check for a defined constant or specific file inclusion
if (!defined('MY_APP') && basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    die('This file cannot be accessed directly.');
}

// Model class for users-table in database

class BookingModel{
    public $booking_id;
    public $booking_name;
    public $restaurant_name;
    public $date_time;
    public $user_id;
}