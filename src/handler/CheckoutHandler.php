<?php
session_start();
require_once __DIR__ . "../../config/site_config.php";
require_once ROOT . "config/db_config.php";
require_once ROOT . "class/Address.php";
require_once ROOT . "class/Helper.php";
if (!isset($_SESSION['user_id'])) {
    header(ROOT . 'login.php');
}
$messages = [];
$message_type = '';
$formData = [];
$userId = $_SESSION['user_id'];
$address = new Address();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    switch ($_POST['acton']) {
        case 'AddAddress':{

            $result = Helper:: validateAndSanitizeAddress($_POST, $userId);
            if ($result['valid']) {
                $address = new Address($result['data']);
                $address->addAddress();
                $_SESSION['messages'] = ['Success' => 'Address Added'];
                $_SESSION['message_type'] = 'success';
            } else {
                $_SESSION['messages'] = $result['errors'];
                $_SESSION['message_type'] = 'error';
                $formData = $_POST;
            }
        }
        case 'deleteAddress':
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'GET'){
    $action = $_GET['action'];
    switch ($action){
        case 'something':
            break;
        default:
            $res = $address->getAddress($userId);
    }
}
$res = $address->getAddress($userId);
