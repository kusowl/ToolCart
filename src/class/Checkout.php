<?php

//namespace App\class;

require_once 'Model.php';
require_once 'Cart.php';
require_once 'Orders.php';
require_once 'Coupon.php';
class Checkout extends Model
{

    function createOrder($userId, $paymentType, $reciptOrderId = '', $success=false ): array
    {
        $amount = (int)($_SESSION['original_price'] - ($_SESSION['savings'] ?? 0)) ?? 1;
        $addressId = $_SESSION['address_id'];
        $coupon = $_SESSION['coupon_code'] ?? '';
        // get products from cart
        $cart = new Cart($userId);
        $products = $cart->getAllItem();
        $orderData = [
            'user_id' => $userId,
            'address_id' => (int)$addressId,
            'amount' => $amount,
            'payment_type' => $paymentType,
            'payment_status' => $success,
            'date' => date('Y-m-d H:i:s'),
            'products' => $products
        ];
        // Check if coupon is applied
        if($coupon != ''){
            $orderData['coupon_id']  = (int)Coupon::getByCode($coupon)->getId();
            $orderData['coupon_amount'] = $_SESSION['savings'];
        }
        if($paymentType == 'razorpay') {
            $orderData['razorpay_recipt' ] = $reciptOrderId;
        }
        // create order
        $orders = new Orders();
        $res = $orders->addOrder($orderData);
        if ($res['success']) {
            unset($_SESSION['cart']);
            unset($_SESSION['cart_total']);
            unset($_SESSION['coupon_id']);
            unset($_SESSION['coupon_code']);
            unset($_SESSION['savings']);
            unset($_SESSION['original_price']);
            unset($_SESSION['payment_method']);
            unset($_SESSION['address_id']);
            return [
                'success' => true,
                'order_id' => $res['order_id']
            ];
        }else{
            return [
                'success' => false,
                'message' => $res['error']
            ];
        }
    }
}