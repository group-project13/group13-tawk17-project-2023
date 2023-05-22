<?php

// Check for a defined constant or specific file inclusion
if (!defined('MY_APP') && basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    die('This file cannot be accessed directly.');
}

require_once __DIR__ . "/../data-access/PurchasesDatabase.php";

class PurchasesService{

    public static function getPurchaseById($id){
        $purchases_database = new PurchasesDatabase();

        $purchase = $purchases_database->getOne($id);

        return $purchase;
    }
    

    public static function getAllPurchases(){
        $purchases_database = new PurchasesDatabase();

        $purchases = $purchases_database->getAll();

        return $purchases;
    }
    

    public static function getPurchasesByUser($user_id){
        $purchases_database = new PurchasesDatabase();

        $purchases = $purchases_database->getByUserId($user_id);

        return $purchases;
    }

    
    public static function savePurchase(PurchaseModel $purchase){
        $purchases_database = new PurchasesDatabase();

        $success = $purchases_database->insert($purchase);

        return $success;
    }

    
    public static function updatePurchaseById($purchase_id, PurchaseModel $purchase){
        $purchase_database = new PurchasesDatabase();

        $success = $purchase_database->updateById($purchase_id, $purchase);

        return $success;
    }

    
    public static function deletePurchaseById($purchase_id){
        $purchase_database = new PurchasesDatabase();

        $success = $purchase_database->deleteById($purchase_id);

        return $success;
    }
}
