<?php
session_start();
require_once __DIR__ . "../../config/site_config.php";
require_once ROOT . "config/db_config.php";
require_once ROOT . "class/Cart.php";
$cartRecords = [];
$cartItemCount = [];
$userId = $_SESSION['user_id'];
$cart = new Cart($userId);
CART::setDb($con);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $productId = $_POST['productId'];
    $cartQty = (int)$_POST['cartQty'];
    $request = $_POST['request'];

    switch ($request) {
        case 'decrementQty':
        case 'incrementQty':
        {
            if ($cart->setQuantity($productId, $cartQty)) {
                /*
                 * I am updating the view variables, so that updated data is rendered in next refresh
                 * Also returning required data, so that it can be updated via ajax too.
                 * By this, page reload is not required for the action, and also data is updated in next refresh.
                 */
                $cartItemCount = $cart->getCartItemTotal()['total_qty'];
                $response = [
                    'success' => true,
                    'totalQty' => $cartItemCount
                ];
            }
            else{
                $response = [
                    'error' => true
                ];
            }
            header('Content-Type: application/json');
            echo json_encode($response);
            break;
        }
        case 'removeCartItem':
        {
            if ($cart->removeItem($productId)) {
            $cartItemCount = $cart->getCartItemTotal()['total_qty'];
            $cartRecords = $cart->getAllItem();
            $response = [
                'success' => true,
                'totalQty' => $cartItemCount
            ];
        }
        else{
            $response = [
                'error' => true
            ];
        }
            header('Content-Type: application/json');
            echo json_encode($response);
            break;
        }
    }
} else {
    if (isset($_SESSION['user_id'])) {
        $cartRecords = $cart->getAllItem();
        $cartItemCount = $cart->getCartItemTotal()['total_qty'];
    }
}
