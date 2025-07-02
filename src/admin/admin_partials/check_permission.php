<?php
require_once '../config/db_config.php';
include_once "../class/User.php";
if (!isset($_SESSION['user_id'])) {
    header('Location: /ToolCart/login');
    exit;
}

$user = User::getUser($_SESSION['user_email']);
$user->getType() == 'customer' ? die('You dont have permission of this page') : '';
