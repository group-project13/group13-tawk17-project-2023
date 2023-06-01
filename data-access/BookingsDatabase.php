<?php

// Check for a defined constant or specific file inclusion
if (!defined('MY_APP') && basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    die('This file cannot be accessed directly.');
}


require_once __DIR__ . "/Database.php";
require_once __DIR__ . "/../models/BookingModel.php";

class BookingsDatabase extends Database
{
    private $table_name = "bookings";
    private $id_name = "booking_id";


    public function getOne($booking_id)
    {
        $result = $this->getOneRowByIdFromTable($this->table_name, $this->id_name, $booking_id);

        $booking = $result->fetch_object("BookingModel");

        return $booking;
    }



    public function getAll()
    {
        $result = $this->getAllRowsFromTable($this->table_name);

        $bookings = [];

        while ($booking = $result->fetch_object("BookingModel")) {
            $bookings[] = $booking;
        }

        return $bookings;
    }


    public function getByUserId($user_id)
    {
        $query = "SELECT * FROM bookings WHERE user_id = ?";

        $stmt = $this->conn->prepare($query);

        $stmt->bind_param("i", $user_id);

        $stmt->execute();

        $result = $stmt->get_result();

        $bookings = [];

        while ($booking = $result->fetch_object("BookingModel")) {
            $bookings[] = $booking;
        }

        return $bookings;
    }



    public function insert(BookingModel $booking)
    {
        $query = "INSERT INTO bookings (booking_name, restaurant_name, date_time, user_id) VALUES (?, ?, ?, ?)";

        $stmt = $this->conn->prepare($query);

        $stmt->bind_param("sssi", $booking->booking_name, $booking->restaurant_name, $booking->date_time, $booking->user_id);

        $success = $stmt->execute();

        return $success;

    }


     
    public function updateById($booking_id, BookingModel $booking)
    {
        $query = "UPDATE bookings SET booking_name=?, restaurant_name=?, date_time=?, user_id=? WHERE booking_id=?;";

        $stmt = $this->conn->prepare($query);

        $stmt->bind_param("sssii", $booking->booking_name, $booking->restaurant_name, $booking->date_time, $booking->user_id, $booking_id);

        $success = $stmt->execute();

        return $success;
    }

    
    public function deleteById($booking_id)
    {
        $success = $this->deleteOneRowByIdFromTable($this->table_name, $this->id_name, $booking_id);

        return $success;
    }
}