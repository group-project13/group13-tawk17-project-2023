<?php

// Check for a defined constant or specific file inclusion
if (!defined('MY_APP') && basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    die('This file cannot be accessed directly.');
}

require_once __DIR__ . "/../data-access/BookingsDatabase.php";

class BookingsService{

    public static function getBookingById($id){
        $bookings_database = new BookingsDatabase();

        $booking = $bookings_database->getOne($id);

        return $booking;
    }
    

    public static function getAllBookings(){
        $bookings_database = new BookingsDatabase();

        $bookings = $bookings_database->getAll();

        return $bookings;
    }
    

    public static function getBookingsByUser($user_id){
        $bookings_database = new BookingsDatabase();

        $bookings = $bookings_database->getByUserId($user_id);

        return $bookings;
    }

    
    public static function saveBooking(BookingModel $booking){
        $bookings_database = new BookingsDatabase();

        $success = $bookings_database->insert($booking);

        return $success;
    }

    
    public static function updateBookingById($booking_id, BookingModel $booking){
        $booking_database = new BookingsDatabase();

        $success = $booking_database->updateById($booking_id, $booking);

        return $success;
    }

    
    public static function deleteBookingById($booking_id){
        $booking_database = new BookingsDatabase();

        $success = $booking_database->deleteById($booking_id);

        return $success;
    }
}
