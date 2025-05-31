<?php
session_start();
require_once "../config/site_config.php";
require_once ROOT."config/db_config.php";
require_once ROOT . "class/Cart.php";

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $userId = $_SESSION['user_id'];
    $cart = new Cart($userId);
    CART::setDb($con);
    $productId = $_POST['productId'];
    $cartQty = (int) $_POST['cartQty'];
    $requestType = $_POST['requestType'];

    switch ($requestType){
        case 'decrementQty':
        case 'incrementQty':{
            $cart->setQuantity($productId, $cartQty);
            break;
        }
    }
}
