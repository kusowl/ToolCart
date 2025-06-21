<?php
session_start();
include_once __DIR__."/../../config/site_config.php";
include_once ROOT . "config/db_config.php";
require_once ROOT."class/Coupon.php";
$messages  = [];
$message_type='';
$coupon = new Coupon();
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $code = $_POST['code'];
    $type = $_POST['type'];
    $value = $_POST['value'];
    $desc = $_POST['desc'];
   switch ($_POST['action']){
       case 'post':
           $coupon->addCoupon($code, $type, $value, $desc);
           break;
       case 'put':
           break;
       default:
   }
}
