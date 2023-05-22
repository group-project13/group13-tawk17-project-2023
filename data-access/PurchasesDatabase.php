<?php

// Check for a defined constant or specific file inclusion
if (!defined('MY_APP') && basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    die('This file cannot be accessed directly.');
}


require_once __DIR__ . "/Database.php";
require_once __DIR__ . "/../models/PurchaseModel.php";

class PurchasesDatabase extends Database
{
    private $table_name = "purchases";
    private $id_name = "purchase_id";


    public function getOne($purchase_id)
    {
        $result = $this->getOneRowByIdFromTable($this->table_name, $this->id_name, $purchase_id);

        $purchase = $result->fetch_object("PurchaseModel");

        return $purchase;
    }



    public function getAll()
    {
        $result = $this->getAllRowsFromTable($this->table_name);

        $purchases = [];

        while ($purchase = $result->fetch_object("PurchaseModel")) {
            $purchases[] = $purchase;
        }

        return $purchases;
    }


    public function getByUserId($user_id)
    {
        $query = "SELECT * FROM purchases WHERE user_id = ?";

        $stmt = $this->conn->prepare($query);

        $stmt->bind_param("i", $user_id);

        $stmt->execute();

        $result = $stmt->get_result();

        $purchases = [];

        while ($purchase = $result->fetch_object("PurchaseModel")) {
            $purchases[] = $purchase;
        }

        return $purchases;
    }



    public function insert(PurchaseModel $purchase)
    {
        $query = "INSERT INTO purchases (product_name, price, purchase_time, user_id) VALUES (?, ?, ?, ?)";

        $stmt = $this->conn->prepare($query);

        $stmt->bind_param("siii", $purchase->product_name, $purchase->price, $purchase->purchase_time, $purchase->user_id);

        $success = $stmt->execute();

        return $success;
    }


     
    public function updateById($purchase_id, PurchaseModel $purchase)
    {
        $query = "UPDATE purchases SET product_name=?, price=?, purchase_time=?, user_id=? WHERE purchase_id=?;";

        $stmt = $this->conn->prepare($query);

        $stmt->bind_param("siiii", $purchase->product_name, $purchase->price, $purchase->purchase_time, $purchase->user_id, $purchase_id);

        $success = $stmt->execute();

        return $success;
    }

    
    public function deleteById($purchase_id)
    {
        $success = $this->deleteOneRowByIdFromTable($this->table_name, $this->id_name, $purchase_id);

        return $success;
    }
}