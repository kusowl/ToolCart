<?php
session_start();
require_once __DIR__ . "../../config/site_config.php";
require_once ROOT . "config/db_config.php";
require_once ROOT.'class/Orders.php';
require_once ROOT.'class/OrderDetails.php';
require_once ROOT.'class/Product.php';

$userId = $_SESSION['user_id'] ?? '';
if($userId == '') header('Location: login');
$orders = Orders::getAllOrders($userId);
$ordersRecord = [];
foreach ($orders as $order) {
    $record['order_id'] = $order->getId();
    $record['payment_method'] = $order->getPaymentType();
    $record['payment_status'] = $order->getPaymentStatus() == '' ?: 'Pending';
    $record['delivery_status'] = $order->getDeliveryStatus();
    $record['date'] = $order->getDate();
    $record['amount'] = $order->getAmount();
    $productRecord = [];
    foreach ($order->getOrderDetails() as $orderDetail) {
        $productRecord[$orderDetail->getId()]['quantity'] = $orderDetail->getQty();
        $product = Product::findById($orderDetail->getProductId());
        $productRecord[$orderDetail->getId()]['product_id'] = $product->getId();
        $productRecord[$orderDetail->getId()]['product_name'] = $product->getTitle();
        $productRecord[$orderDetail->getId()]['product_brand'] = $product->getBrand();
        $productRecord[$orderDetail->getId()]['product_image'] = $product->getImage();
        $productRecord[$orderDetail->getId()]['price'] = $product->getPrice() * $orderDetail->getQty();
    }
    $record['product_details'] = $productRecord;
    $ordersRecord[] = $record;
}