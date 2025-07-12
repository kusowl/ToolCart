<?php

use Razorpay\Api\Order;

require_once __DIR__ . "../../config/site_config.php";
require_once ROOT.'class/Orders.php';
require_once ROOT.'class/OrderDetails.php';
require_once ROOT.'class/Address.php';
$orderId = $_GET['order_id'];
if($orderId == ''){
    header('Location:home');
}
try{
    $orders = Orders::getByOrderId($orderId);
    $address = (new Address())->getAddress($orders->getUserId(), $orders->getAddressId())[0];
}catch(Exception $e){
    error_log('Error in receipt handler | '.$e->getMessage());
    $_SESSION['messages'] = $e->getMessage();
    $_SESSION['message_type'] = 'error';
//    header('Location:home');
}
