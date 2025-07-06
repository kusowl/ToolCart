<?php

session_start();
require_once __DIR__ . "../../config/site_config.php";
require_once __DIR__ . "../../config/razorpay_config.php";
require __DIR__ . '../../razorpay/Razorpay.php';

use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;

require_once ROOT . "config/db_config.php";
require_once ROOT . 'class/Checkout.php';
require_once ROOT . "class/Address.php";
require_once ROOT . "class/Helper.php";
require_once ROOT . "class/Coupon.php";
//require_once ROOT . "pay.php";
$checkout = new Checkout();
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
            break;
        }
        case 'placeOrder':
        {
            $_SESSION['pay_method'] = $payMethod = $data['payment_method'][0];
            $_SESSION['address_id'] = $data['address_id'][0];
            $amount = (int)($_SESSION['original_price'] - ($_SESSION['savings'] ?? 0)) ?? 1;
            $response = [];
            $order = [];
            $order['amount'] = $amount;
            $order['pay_method'] = $payMethod;
            if ($payMethod == 'razorpay') {
                $api = new Api(KEYID, KEYSECRATE);
                $razor = $api->order->create(['receipt' => rand(1000, 9999999), 'amount' => $amount * 100, 'currency' => CURRENCY]);
                $order['id'] = $razor['id'];
                $order['currency'] = CURRENCY;
                $order['razorpay_key'] = KEYID;
                $response['success'] = true;
            } elseif ($payMethod == 'pod') { // Pay on Delivery
                $res = $checkout->createOrder($userId, $payMethod);
                $response['success'] = $res['success'];
                $response['order_id'] = $res['order_id'];
            }
            $response['order'] = $order;

            echo json_encode($response);
            http_response_code(200);
            break;
        }
        case 'verifyOrder':
        {
            $success = 'success';

            $error = "Payment Failed";

            if (empty($data['razorpay_payment_id']) === false) {
                $api = new Api(KEYID, KEYSECRATE);

                try {
                    // Please note that the razorpay order ID must
                    // come from a trusted source
                    $attributes = array(
                        'razorpay_order_id' => $data['razorpay_order_id'],
                        'razorpay_payment_id' => $data['razorpay_payment_id'],
                        'razorpay_signature' => $data['razorpay_signature']
                    );

                    $api->utility->verifyPaymentSignature($attributes);
                } catch (SignatureVerificationError $e) {
                    $success = 'failed';
                    $error = 'Razorpay Error : ' . $e->getMessage();
                } finally {
                    $checkout = new Checkout();
                    $res = $checkout->createOrder($userId, $data['payment_method'], $data['razorpay_payment_id'], $success);
                    http_response_code(200);
                    echo json_encode([
                        'success' => $res['success'],
                        'order_id' => $res['order_id']
                    ]);
                }
            }
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

$res = $address->getAddress($userId);
