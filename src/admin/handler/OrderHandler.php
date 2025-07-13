<?php
include_once ROOT . "class/Orders.php";
include_once ROOT . "config/db_config.php";
$table_heads = ['Order ID', 'User', 'Amount', 'Delivery Status', 'Payment Type', 'Payment Status','Date', 'Order Status'];
$orders = Orders::getAllOrders(limit: $limit ?? QUERY_LIMIT);
$table_records = [];
$records = [];
foreach ($orders as $ordersRec) {
    $records['id'] = $ordersRec->getId();
    $records['user'] = User::getById($ordersRec->getUserId())->getName();
    $records['amount'] = $ordersRec->getAmount();
    $records['delivery_status'] = ucfirst($ordersRec->getDeliveryStatus());
    $records['payment_type'] = strtoupper( $ordersRec->getPaymentType());
    $records['payment_status'] = ucfirst($ordersRec->getPaymentStatus() ?: 'Pending' );
    $records['date'] = $ordersRec->getDate();
    $records['order_status'] = $ordersRec->getStatus();
    $table_records[] = $records;
}
$primaryAction = 'Disabled';
$primaryActionLink = BASE_URL . "admin/add_coupon.php";
$deleteLink = 'handler/CouponHandler.php';
