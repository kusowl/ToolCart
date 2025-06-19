<?php
session_start();
require_once __DIR__ . "/../../config/site_config.php";
require_once ROOT . "config/db_config.php";
require_once ROOT . "class/Helper.php";
require_once ROOT . "class/Product.php";
$messages = [];
$message_type = "";
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $action = $_POST['action'];
    switch ($action) {
        case 'add_product':
        {
            $image = $_FILES['product_image'];
            $fileTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
            // Validate file
            $validationResult = Helper::validateFile($image, $fileTypes, MAX_FILE_SIZE);
            $rel_path = 'assets/images/';
            $path = ROOT . $rel_path;
            switch ($validationResult) {
                case 0:
                    $img_name = Helper::uploadFile($image, $path);
                    break;
                case 1:
                    $messages['Image Error'] = "Upload error";
                    break;
                case 2:
                    $messages['Image Error'] = "File type not allowed";
                    break;
                case 3:
                    $messages['Image Error'] = "File is is not allowed";
                    break;
                default:
                    $messages['Image Error'] = "Validation Failed";
            }
            if (!empty($messages)) {
                $message_type = 'error';
            } else {
                $product = new Product();
                $imgPath = $rel_path . $img_name;
                $result = $product->addProduct($_POST['title'], $_POST['desc'], $_POST['price'], $_POST['brand'], $imgPath, $_POST['category_id']);
                if ($result) {
                    $messages['New Record'] = "product added successfully.";
                    $message_type = "success";
                } else {
                    $messages['Error'] = "failed  adding product";
                    $message_type = "error";
                }
            }
            $_SESSION["messages"] = $messages;
            $_SESSION["message_type"] = $message_type;
            header("Location: ../add_product.php");
        }
    }
}