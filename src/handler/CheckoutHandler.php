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
$address = new Address($userId);
// Handle ajax requests
if (str_contains($_SERVER['CONTENT_TYPE'] ?? '', 'application/json')) {
    // This is an AJAX request

    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        $jsonData = array_keys($_GET)[0];
    } else {
        $jsonData = file_get_contents('php://input');
    }
    $data = json_decode($jsonData, true);

    if ($data['action'] == 'deleteAddress') {
        $result = $address->deleteAddress($data['address_id']);
        if ($result) {
            http_response_code(200);
            $messages = ['Success' => 'Address deleted'];
            $message_type = 'success';
            echo json_encode($messages);
        } else {
            http_response_code(400);
            $messages = ['failed' => 'Address cannot be deleted'];
            $message_type = 'error';
            echo json_encode($messages);
        }
    } elseif ($data['action'] == 'getAddressData') {

        $res = $address->getAddress($userId, $data['id'], 1);
        echo json_encode($res[0]->getAsArray());
    } else {
        http_response_code(400);
        echo json_encode(['Error' => 'key does not exist']);
    }
    $_SESSION['messages'] = $messages;
    $_SESSION['message_type'] = $message_type;
}

// Handle from requests
if ($_SERVER['REQUEST_METHOD'] === 'POST' and isset($_POST)) {
    switch ($_POST['action']) {
        case 'addAddress':
        {
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
            break;
        }
        case 'updateAddress':
        {
            $result = Helper:: validateAndSanitizeAddress($_POST, $userId);
            if ($result['valid']) {
                $address = new Address($result['data']);
                $address->updateAddress();
                $_SESSION['messages'] = ['Success' => 'Address Updated'];
                $_SESSION['message_type'] = 'success';
            } else {
                $_SESSION['messages'] = $result['errors'];
                $_SESSION['message_type'] = 'error';
                $formData = $_POST;
            }
            break;
        }

    }
}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $action = $_GET['action'];
    switch ($action) {
        case 'something':
            break;
        default:
            $res = $address->getAddress($userId);
    }
}
$res = $address->getAddress($userId);
