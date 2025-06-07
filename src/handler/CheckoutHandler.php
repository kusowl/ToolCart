<?php
session_start();
require_once __DIR__ . "../../config/site_config.php";
require_once ROOT . "config/db_config.php";
require_once ROOT . "class/Address.php";
if (!isset($_SESSION['user_id'])) {
    header(ROOT . 'login.php');
}
$userId = $_SESSION['user_id'];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (($_POST['action'] ?? '') === 'addAddress') {
        $address = new Address([
            'user_id' => $userId,
            "name" => $_POST['name'],
            "email" => $_POST['email'],
            "city" => $_POST['city'],
            "country" => $_POST['country'],
            "country_code" => $_POST['country_code'],
            "ph_no" => $_POST['ph_no'],
            "pin" => $_POST['pin'],
            "line_1" => $_POST['line_1'],
            "line_2" => $_POST['line_2'],
            "instructions" => $_POST['instructions']
        ]);
        $address->addAddress();
    }
}
