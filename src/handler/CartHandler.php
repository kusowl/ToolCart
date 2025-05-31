<?php
session_start();
require_once __DIR__."../../config/site_config.php";
require_once ROOT."config/db_config.php";
require_once ROOT . "class/Cart.php";

$userId = $_SESSION['user_id'];
$cart = new Cart($userId);
CART::setDb($con);

if($_SERVER['REQUEST_METHOD'] == "GET"){
    $request = $_GET['q'];
    switch ($request){
        case 'totalCartQty':{
            $cartItemCount = $cart->getCartItemTotal()['total_qty'];
            $response = [
                'success' => true,
                'totalQty' => $cartItemCount
            ];
            header('Content-Type: application/json');
            echo json_encode($response);
        }
    }

}
if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $productId = $_POST['productId'];
    $cartQty = (int) $_POST['cartQty'];
    $request = $_POST['request'];

    switch ($request){
        case 'decrementQty':
        case 'incrementQty':{
            $cart->setQuantity($productId, $cartQty);
            break;
        }
    }
}else{
    if (isset($_SESSION['user_id'])) {
        $cartRecords = $cart->getAllItem();
        $cartItemCount = $cart->getCartItemTotal()['total_qty'];
    }
}
