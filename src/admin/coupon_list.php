<?php
session_start();
include_once "../config/site_config.php";
include_once ROOT . "config/db_config.php";
include_once ROOT . "class/Coupon.php";
include ROOT . "partials/header.php";
include_once "admin_partials/admin_header.php";
$coupon = new Coupon();
$table_heads = ['Code', 'Type', 'Value','Description'];
$coupons = $coupon->getAllCoupons(99);
$table_records = [];
$records = [];
foreach ($coupons as $couponRec) {
    $records['code'] = $couponRec->getCode();
    $records['type'] = $couponRec->getType();
    $records['value'] = $couponRec->getValue();
    $records['desc'] = $couponRec->getDescription();
    $table_records[] = $records;
}
include "admin_partials/table.php";
include_once "admin_partials/admin_footer.php";
?>
