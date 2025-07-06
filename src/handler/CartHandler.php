<?php
session_start();
require_once __DIR__ . "../../config/site_config.php";
require_once ROOT . "config/db_config.php";
require_once ROOT . "class/Cart.php";
require_once ROOT . "class/Coupon.php";
$cartRecords = [];
$cartItemCount = [];


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (!isset($_SESSION['user_id'])) {
        header('Location: /ToolCart/login');
        exit;
    }
    $userId = $_SESSION['user_id'];
    $cart = new Cart($userId);
    $productId = $_POST['productId'] ?? null;
    $cartQty = (int)$_POST['cartQty'] ?? 0;
    $action = $_POST['action'] ?? '';

    switch ($action) {
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
            } else {
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
            } else {
                $response = [
                    'error' => true
                ];
            }
            header('Content-Type: application/json');
            echo json_encode($response);
            break;
        }
        case 'coupon':
        {
            $code = $_POST['code'];
            $originalPrice = $cart->getCartValue();
            $savings = calculateSavings($code, $originalPrice);
            $cartRecords = $cart->getAllItem();
            $cartItemCount = $cart->getCartItemTotal()['total_qty'];
            $_SESSION['coupon_code'] = $code;
            break;
        }

        // No Request specified so just see it as add to cart
        case 'add_to_cart' :
        {
            $cart->addItem($productId);
            if (!empty($_SERVER['HTTP_REFERER'])) {
                header('Location: ' . $_SERVER['HTTP_REFERER']);
                exit;
            } else {
                // Fallback: If HTTP_REFERER is not available, redirect to a default page
                // This is important because HTTP_REFERER is not always guaranteed.
                header('Location:/ToolCart/home'); // Or your home page, etc.
                exit;
            }
        }
    }
} else {
    if (isset($_SESSION['user_id'])) {
        $cart = new Cart($_SESSION['user_id']);
        $cartRecords = $cart->getAllItem();
        $cartItemCount = $cart->getCartItemTotal()['total_qty'];
        $_SESSION['original_price'] = $originalPrice = $cart->getCartValue();
        if(isset($_SESSION['coupon_code'])){
            $code = $_SESSION['coupon_code'];
            $_SESSION['savings'] = $savings = calculateSavings($code, $originalPrice);
        }
    }
}

function calculateSavings($code, $originalPrice): float|int
{
    $coupon = (new Coupon())->getByCode($code);
    if ($coupon->getType() == 'amount'){
        $savings = $coupon->getValue();
    }else{
        $savings = $originalPrice * ($coupon->getValue() / 100);
    }
    return $savings;
}