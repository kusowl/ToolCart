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
       case 'Add':
           $coupon->addCoupon($code, $type, $value, $desc);
           break;
       case 'Update':{
           $data['id']  = $_GET['id'];
           $data['code'] = $code;
           $data['type'] = $type;
           $data['value'] = $value;
           $data['desc'] = $desc;
           $coupon->update($data);
       }
           break;
       default:
   }
}
if ($_SERVER['REQUEST_METHOD'] == 'GET'){
    $id = $_GET['id'] ??  '';
    if ($id != ''){
        $coupon = new Coupon();
        $couponData = $coupon->getById($id);
        $formData['id'] = $couponData->getId();
        $formData['code'] = $couponData->getCode();
        $formData['type'] = $couponData->getType();
        $formData['value'] = $couponData->getValue();
        $formData['desc'] = $couponData->getDescription();
    }
}