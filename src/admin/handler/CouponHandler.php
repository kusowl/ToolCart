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
    $expiryDate = $_POST['expiry_date'];
   switch ($_POST['action']){
       case 'Add':
           $coupon->addCoupon($code, $type, $value, $desc, $expiryDate);
           break;
       case 'Update':{
           $data['id']  = $_GET['id'];
           $data['code'] = $code;
           $data['type'] = $type;
           $data['value'] = $value;
           $data['desc'] = $desc;
           $data['expiry_date'] = $expiryDate;
           $coupon->update($data);
           break;
       }
       case 'Delete':{
           $id  = $_POST['id'];
           $coupon = new Coupon(['id' => $id]);

           if ($coupon->delete()) {
               $messages['Success'] = "Product Deleted.";
           } else {
               $messages['Error'] = "failed  sql query ";
           }
           $message_type = "Error";
           $_SESSION["messages"] = $messages;
           $_SESSION["message_type"] = $message_type;
           header("Location: /ToolCart/admin/coupon_list");
       }
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
        $formData['expiry_date'] =  $couponData->getExpiryDate() == '' ? "-" : $couponData->getExpiryDate()->format('Y-m-d h:i:s');;
    }
}