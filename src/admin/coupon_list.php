<?php
ob_start();
session_start();
include_once "../config/site_config.php";
include_once ROOT . "config/db_config.php";
include_once "admin_partials/check_permission.php";
include_once ROOT . "class/Coupon.php";
include ROOT . "partials/header.php";
include_once "admin_partials/admin_header.php";
$coupon = new Coupon();
$table_heads = ['ID','Code', 'Type', 'Value','Expiry Date','Description'];
$coupons = $coupon->getAllCoupons(99);
$table_records = [];
$records = [];
foreach ($coupons as $couponRec) {
    $records['id'] = $couponRec->getId();
    $records['code'] = $couponRec->getCode();
    $records['type'] = $couponRec->getType();
    $records['value'] = $couponRec->getValue();
    $records['expiry_date'] = $couponRec->getExpiryDate() == '' ? "-" : $couponRec->getExpiryDate()->format('Y-m-d h:i:s');
    $records['desc'] = $couponRec->getDescription();
    $table_records[] = $records;
}
$primaryAction = 'Coupon';
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
