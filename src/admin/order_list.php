<?php
ob_start();
session_start();
include_once "../config/site_config.php";
include_once ROOT . "config/db_config.php";
include_once "admin_partials/check_permission.php";
include_once ROOT . "class/User.php";
include_once ROOT . "class/Orders.php";
include ROOT . "partials/header.php";
include_once "admin_partials/admin_header.php";
$table_heads = ['Order ID', 'User', 'Amount', 'Delivery Status', 'Payment Type', 'Payment Status','Date', 'Order Status'];
$orders = Orders::getAllOrders(limit: 99);
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

$messages = $_SESSION["messages"] ?? '';
$message_type = $_SESSION["message_type"] ?? '';
if ($messages != '') {
    include_once "../partials/popup.php";
    unset($_SESSION["messages"]);
    unset($_SESSION["message_type"]);
}
include "admin_partials/table.php";
include_once "admin_partials/admin_footer.php";
?>
<?php
