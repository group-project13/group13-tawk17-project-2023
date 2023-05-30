<?php

// Check for a defined constant or specific file inclusion
if (!defined('MY_APP') && basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    die('This file cannot be accessed directly.');
}

require_once __DIR__ . "/RestAPI.php";
require_once __DIR__ . "/../business-logic/BookingsService.php";


class BookingsAPI extends RestAPI
{

    // Handles the request by calling the appropriate member function
    public function handleRequest()
    {

        // GET: /api/bookings
        if ($this->method == "GET" && $this->path_count == 2) {
            $this->getAll();
        }

        // GET: /api/bookings/{id}
        else if ($this->path_count == 3 && $this->method == "GET") {
            $this->getById($this->path_parts[2]);
        }

        // POST: /api/bookings
        else if ($this->path_count == 2 && $this->method == "POST") {
            $this->postOne();
        }

        // PUT: /api/bookings/{id}
        else if ($this->path_count == 3 && $this->method == "PUT") {
            $this->putOne($this->path_parts[2]);
        }

        // DELETE: /api/bookings/{id}
        else if ($this->path_count == 3 && $this->method == "DELETE") {
            $this->deleteOne($this->path_parts[2]);
        }

        // If none of our ifs are true, we should respond with "not found"
        else {
            $this->notFound();
        }
    }


    private function getAll()
    {
        $this->requireAuth();

        if ($this->user->user_role === "admin") {
            $bookings = BookingsService::getAllBookings();
        } else {
            $bookings = BookingsService::getBookingsByUser($this->user->user_id);
        }

        $this->sendJson($bookings);
    }


    private function getById($id)
    {
        $this->requireAuth();

        $booking = BookingsService::getBookingById($id);

        if (!$booking) {
            $this->notFound();
        }

        if ($this->user->user_role !== "admin" || $booking->user_id !== $this->user->user_id) {
            $this->forbidden();
        }

        $this->sendJson($booking);
    }


    private function postOne()
    {
        $this->requireAuth();

        $booking = new BookingModel();

        $booking->booking_name = $this->body["booking_name"];
        $booking->restaurant_name = $this->body["restaurant_name"];
        $booking->date_time = $this->body["date_time"];

        // Admins can connect any user to the booking
        if ($this->user->user_role === "admin") {
            $booking->user_id = $this->body["user_id"];
        }

        // Regular users can only add bookings to themself
        else {
            $booking->user_id = $this->user->user_id;
        }

        $success = BookingsService::saveBooking($booking);

        if ($success) {
            $this->created();
        } else {
            $this->error();
        }
    }


    private function putOne($id)
    {
        $this->requireAuth(["admin"]);

        $booking = new BookingModel();

        $booking->booking_name = $this->body["booking_name"];
        $booking->restaurant_name = $this->body["restaurant_name"];
        $booking->date_time = $this->body["date_time"];
        $booking->user_id = $this->body["user_id"];

        $success = BookingsService::updateBookingById($id, $booking);

        if ($success) {
            $this->ok();
        } else {
            $this->error();
        }
    }

    // Deletes the booking with the specified ID in the DB
    private function deleteOne($id)
    {
        // only admins can delete bookings
        $this->requireAuth(["admin"]);

        $booking = BookingsService::getBookingById($id);

        if ($booking == null) {
            $this->notFound();
        }

        $success = BookingsService::deleteBookingById($id);

        if ($success) {
            $this->noContent();
        } else {
            $this->error();
        }
    }
}