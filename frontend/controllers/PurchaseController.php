<?php

// Check for a defined constant or specific file inclusion
if (!defined('MY_APP') && basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    die('This file cannot be accessed directly.');
}

require_once __DIR__ . "/../ControllerBase.php";
require_once __DIR__ . "/../../business-logic/PurchasesService.php";
require_once __DIR__ . "/../../business-logic/ExchangeRateService.php";


class PurchaseController extends ControllerBase
{

    public function handleRequest()
    {

        // Check for POST method before checking any of the GET-routes
        if ($this->method == "POST") {
            $this->handlePost();
        }


        // GET: /home/purchases
        if ($this->path_count == 2) {
            $this->showAll();
        }


        // GET: /home/purchases/new
        else if ($this->path_count == 3 && $this->path_parts[2] == "new") {
            $this->showNewPurchaseForm();
        }


        // GET: /home/purchases/{id}
        else if ($this->path_count == 3) {
            $this->showOne();
        }


        // GET: /home/purchases/{id}/edit
        else if ($this->path_count == 4 && $this->path_parts[3] == "edit") {
            $this->showEditForm();
        }

        // Show "404 not found" if the path is invalid
        else {
            $this->notFound();
        }
    }



    // Gets all purchases and shows them in the index view
    private function showAll()
    {
        $this->requireAuth();

        if ($this->user->user_role === "admin") {
            $purchases = PurchasesService::getAllPurchases();
        } else {
            $purchases = PurchasesService::getPurchasesByUser($this->user->user_id);
        }

        // $this->model is used for sending data to the view
        $this->model = $purchases;

        $this->viewPage("purchases/index");
    }



    // Gets one purchase and shows the in the single view
    private function showOne()
    {
        // Get the purchase with the ID from the URL
        $purchase = $this->getPurchase();

        // $this->model is used for sending data to the view
        $this->model["purchase"] = $purchase;

        // Convert the price to USD and EUR
        $this->model["converted_currencies"] = [
            "usd" => ExchangeRateService::sekToUsd($purchase->price),
            "eur" => ExchangeRateService::sekToEur($purchase->price)
        ];

        // Convert the price to the currency specified in the query params
        if(isset($this->query_params["to_currency"])){

            // Get the currency from the query params
            $to_currency = $this->query_params["to_currency"];

            // Convert the price to the specified currency
            $to_currency_price = ExchangeRateService::sekToCurrency($to_currency, $purchase->price);

            // Add the converted price to the model
            $this->model["converted_currencies"][$to_currency] = $to_currency_price;
        }

        // Get all available currencies
        $this->model["available_currencies"] = ExchangeRateService::getCurrencies();

        // Shows the view file purchases/single.php
        $this->viewPage("purchases/single");
    }



    // Gets one and shows it in the edit view
    private function showEditForm()
    {
        $this->requireAuth(["admin"]);

        // Get the purchase with the ID from the URL
        $purchase = $this->getPurchase();

        // $this->model is used for sending data to the view
        $this->model = $purchase;

        // Shows the view file purchases/edit.php
        $this->viewPage("purchases/edit");
    }




    private function showNewPurchaseForm()
    {
        $this->requireAuth();

        // Shows the view file purchases/new.php
        $this->viewPage("purchases/new");
    }



    // Gets one purchase based on the id in the url
    private function getPurchase()
    {
        $this->requireAuth();

        // Get the purchase with the specified ID
        $id = $this->path_parts[2];

        $purchase = PurchasesService::getPurchaseById($id);

        if (!$purchase) {
            $this->notFound();
        }

        if ($this->user->user_role !== "admin" && $purchase->user_id !== $this->user->user_id) {
            $this->forbidden();
        }

        return $purchase;
    }


    // handle all post requests for purchases in one place
    private function handlePost()
    {
        // POST: /home/purchases
        if ($this->path_count == 2) {
            $this->createPurchase();
        }

        // POST: /home/purchase/{id}/edit
        else if ($this->path_count == 4 && $this->path_parts[3] == "edit") {
            $this->updatePurchase();
        }

        // POST: /home/purchase/{id}/delete
        else if ($this->path_count == 4 && $this->path_parts[3] == "delete") {
            $this->deletePurchase();
        }

        // Show "404 not found" if the path is invalid
        else {
            $this->notFound();
        }
    }


    // Create a purchase with data from the URL and body
    private function createPurchase()
    {
        $this->requireAuth();

        $purchase = new PurchaseModel();

        // Get updated properties from the body
        $purchase->product_name = $this->body["product_name"];
        $purchase->price = $this->body["price"];
        $purchase->purchase_time = time();

        // Admins can connect any user to the purchase
        if($this->user->user_role === "admin"){
            $purchase->user_id = $this->body["user_id"];
        }

        // Regular users can only add purchases to themself
        else{
            $purchase->user_id = $this->user->user_id;
        }

        // Save the purchase
        $success = PurchasesService::savePurchase($purchase);

        // Redirect or show error based on response from business logic layer
        if ($success) {
            $this->redirect($this->home . "/purchases");
        } else {
            $this->error();
        }
    }


    // Update a purchase with data from the URL and body
    private function updatePurchase()
    {
        $this->requireAuth(["admin"]);

        $purchase = new PurchaseModel();

        // Get ID from the URL
        $id = $this->path_parts[2];

        $existing_purchase = PurchasesService::getPurchaseById($id);

        // Get updated properties from the body
        $purchase->product_name = $this->body["product_name"];
        $purchase->price = $this->body["price"];
        $purchase->purchase_time = $existing_purchase->purchase_time;
        $purchase->user_id = $this->body["user_id"];

        $success = PurchasesService::updatePurchaseById($id, $purchase);

        // Redirect or show error based on response from business logic layer
        if ($success) {
            $this->redirect($this->home . "/purchases");
        } else {
            $this->error();
        }
    }


    // Delete a purchase with data from the URL
    private function deletePurchase()
    {
        $this->requireAuth(["admin"]);

        // Get ID from the URL
        $id = $this->path_parts[2];

        // Delete the purchase
        $success = PurchasesService::deletePurchaseById($id);

        // Redirect or show error based on response from business logic layer
        if ($success) {
            $this->redirect($this->home . "/purchases");
        } else {
            $this->error();
        }
    }
}