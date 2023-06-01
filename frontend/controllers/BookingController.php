<?php

// Check for a defined constant or specific file inclusion
if (!defined('MY_APP') && basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    die('This file cannot be accessed directly.');
}

require_once __DIR__ . "/../ControllerBase.php";
require_once __DIR__ . "/../../business-logic/BookingsService.php";
//require_once __DIR__ . "/../../business-logic/ExchangeRateService.php";


class BookingController extends ControllerBase
{

    public function handleRequest()
    {

        // Check for POST method before checking any of the GET-routes
        if ($this->method == "POST") {
            $this->handlePost();
        }


        // GET: /home/bookings
        if ($this->path_count == 2) {
            $this->showAll();
        }


        // GET: /home/bookings/new
        else if ($this->path_count == 3 && $this->path_parts[2] == "new") {
            $this->showNewBookingsForm();
        }


        // GET: /home/bookings/{id}
        else if ($this->path_count == 3) {
            $this->showOne();
        }


        // GET: /home/bookings/{id}/edit
        else if ($this->path_count == 4 && $this->path_parts[3] == "edit") {
            $this->showEditForm();
        }

        // Show "404 not found" if the path is invalid
        else {
            $this->notFound();
        }
    }



    // Gets all bookings and shows them in the index view
    private function showAll()
    {
        $this->requireAuth();

        if ($this->user->user_role === "admin") {
            $bookings = BookingsService::getAllBookings();
        } else {
            $bookings = BookingsService::getBookingsByUser($this->user->user_id);
        }

        // $this->model is used for sending data to the view
        $this->model = $bookings;

        $this->viewPage("bookings/index");
    }



    //HADE MED EXCHANGE CURRENCY HÄR INNAN ASDASDAS
    //ASDASDASD


    // Gets one booking and shows the in the single view
    private function showOne()
    {
        // Get the booking with the ID from the URL
        $booking = $this->getBooking();

        // $this->model is used for sending data to the view
        $this->model["booking"] = $booking;




        // Shows the view file bookings/single.php
        $this->viewPage("bookings/single");
        
    }



    // Gets one and shows it in the edit view
    private function showEditForm()
    {
        $this->requireAuth();

        // Get the booking with the ID from the URL
        $booking = $this->getBooking();

        // $this->model is used for sending data to the view
        $this->model = $booking;

        // Shows the view file bookings/edit.php
        $this->viewPage("bookings/edit");
    }




    private function showNewBookingsForm()
    {
        $this->requireAuth();

        // Shows the view file bookings/new.php
        $this->viewPage("bookings/new");
    }



    // Gets one booking based on the id in the url
    private function getBooking()
    {
        $this->requireAuth();

        // Get the booking with the specified ID
        $id = $this->path_parts[2];

        $booking = BookingsService::getBookingById($id);

        if (!$booking) {
            $this->notFound();
        }

        if ($this->user->user_role !== "admin" && $booking->user_id !== $this->user->user_id) {
            $this->forbidden();
        }

        return $booking;
    }


    // handle all post requests for bookings in one place
    private function handlePost()
    {
        // POST: /home/bookings
        if ($this->path_count == 2) {
            $this->createBooking();
        }

        // POST: /home/booking/{id}/edit
        else if ($this->path_count == 4 && $this->path_parts[3] == "edit") {
            $this->updateBooking();
        }

        // POST: /home/booking/{id}/delete
        else if ($this->path_count == 4 && $this->path_parts[3] == "delete") {
            $this->deleteBooking();
        }

        // Show "404 not found" if the path is invalid
        else {
            $this->notFound();
        }
    }


    // Create a booking with data from the URL and body
    private function createBooking()
    {
        $this->requireAuth();

        $booking = new BookingModel();

        // Get updated properties from the body
        $booking->booking_name = $this->body["booking_name"];
        $booking->restaurant_name = $this->body["restaurant_name"];
        $booking->date_time = $this->body["date_time"];

        // Admins can connect any user to the booking
        if($this->user->user_role === "admin"){
            $booking->user_id = $this->body["user_id"];
        }

        // Regular users can only add bookings to themself
        else{
            $booking->user_id = $this->user->user_id;
        }

        // Save the booking
        $success = BookingsService::saveBooking($booking);

        // Redirect or show error based on response from business logic layer
        if ($success) {
            $this->redirect($this->home . "/bookings");
        } else {
            $this->error();
        }
    }


    // Update a booking with data from the URL and body
    private function updateBooking()
    {
        $this->requireAuth();

        $booking = new BookingModel();

        // Get ID from the URL
        $id = $this->path_parts[2];

        $existing_booking = BookingsService::getBookingById($id);

        // Get updated properties from the body
        $booking->booking_name = $this->body["booking_name"];
        $booking->restaurant_name = $this->body["restaurant_name"];
        $booking->date_time = $this->body["date_time"]; 
        $booking->user_id = $this->body["user_id"];

        $success = BookingsService::updateBookingById($id, $booking);

        // Redirect or show error based on response from business logic layer
        if ($success) {
            $this->redirect($this->home . "/bookings");
        } else {
            $this->error();
        }
    }


    // Delete a booking with data from the URL
    private function deleteBooking()
    {
        $this->requireAuth();

        // Get ID from the URL
        $id = $this->path_parts[2];

        // Delete the booking
        $success = BookingsService::deleteBookingById($id);

        // Redirect or show error based on response from business logic layer
        if ($success) {
            $this->redirect($this->home . "/bookings");
        } else {
            $this->error();
        }
    }
}