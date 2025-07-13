<?php

include_once "../../config/site_config.php";
include_once ROOT . "config/db_config.php";
include_once ROOT . "class/Orders.php";
include_once ROOT . "class/Product.php";
include_once ROOT . "class/User.php";

$totalRevenue = Orders::getRevenue();
$pendingAmount = Orders::getPendingRevenue();
$totalOrders = Orders::getOrderCount();
$totalProducts = Product::getProductCount();
$totalCustomers = User::getUserCount();
$table_heads = ['Order ID', 'User', 'Amount', 'Delivery Status', 'Payment Type', 'Payment Status', 'Date', 'Order Status'];
$orders = Orders::getAllOrders(limit: $limit ?? QUERY_LIMIT);
$table_records = [];
$records = [];
foreach ($orders as $ordersRec) {
    $records['id'] = $ordersRec->getId();
    $records['user'] = User::getById($ordersRec->getUserId())->getName();
    $records['amount'] = $ordersRec->getAmount();
    $records['delivery_status'] = ucfirst($ordersRec->getDeliveryStatus());
    $records['payment_type'] = strtoupper($ordersRec->getPaymentType());
    $records['payment_status'] = ucfirst($ordersRec->getPaymentStatus() ?: 'Pending');
    $records['date'] = $ordersRec->getDate();
    $records['order_status'] = $ordersRec->getStatus();
    $table_records[] = $records;
}

