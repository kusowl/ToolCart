<?php

session_start();
require_once __DIR__ . "../../config/site_config.php";

require_once __DIR__."../../config/razorpay_config.php";
require __DIR__.'../../razorpay/Razorpay.php' ;
use Razorpay\Api\Api;

require_once ROOT . "config/db_config.php";
require_once ROOT . "config/razorpay_config.php";
require_once ROOT . "class/Address.php";
require_once ROOT . "class/Helper.php";
require_once ROOT . "class/Orders.php";
require_once ROOT . "class/Cart.php";
//require_once ROOT . "pay.php";

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

    switch ($data['action']) {
        case 'deleteAddress' :
        {
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
            break;
        }
        case 'getAddressData':
        {

            $res = $address->getAddress($userId, $data['id'], 1);
            echo json_encode($res[0]->getAsArray());
        }
        case 'placeOrder':
        {
            $payMethod = $data['payment_method'][0];
            $addressId = $data['address_id'][0];
            $amount = $_SESSION['original_price'] - ($_SESSION['savings'] ?? 0);
            $amount = 100;
            $coupon = $_SESSION['coupon_code'] ?? null;
            // get products from cart
            $cart = new Cart($userId);
            $products = $cart->getAllItem();

            $orderData = [
                'user_id' => $userId,
                'address_id' => (int) $addressId,
                'coupon_id' => $coupon,
                'coupon_amount' => $amount,
                'payment_type' => $payMethod,
                'date' => date('Y-m-d H:i:s'),
                'products' => $products
            ];

            $response = [];

            $order = [];
            if ($payMethod == 'razorpay') {
                $api = new Api(KEYID, KEYSECRATE);
                $razor = $api->order->create(['receipt' => $orders->getId(), 'amount' => $amount, 'currency' => CURRENCY]);
                $order['id'] = $razor['id'];
                $order['amount'] = $amount;
                $order['currency'] = CURRENCY;
                $order['razorpay_key'] = KEYID;
            }
            $response['order']  = $order;

            $orders = new Orders();
            if ($orders->addOrder($orderData)) {
                unset($_SESSION['cart']);
                unset($_SESSION['cart_total']);
                unset($_SESSION['coupon_id']);
                $response['success'] = true;
            }

            echo json_encode($response);
            http_response_code(200);
            break;
        }
        default:
        {
            http_response_code(400);
            echo json_encode(['Error' => 'key does not exist']);
        }
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
function createRazorpayOrder($amount, $receipt) {
    $url = 'https://api.razorpay.com/v1/orders';

    $data = [
        'amount' => $amount,
        'currency' => 'INR',
        'receipt' => $receipt,
        'payment_capture' => 1
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Authorization: Basic ' . base64_encode(RAZORPAY_KEY_ID . ':' . RAZORPAY_KEY_SECRET)
    ]);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode !== 200) {
        throw new Exception('Failed to create Razorpay order');
    }

    return json_decode($response, true);
}

$res = $address->getAddress($userId);
