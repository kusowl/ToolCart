<?php
session_start();
require_once "../../config/file_config.php";
include_once "../../helper/sanitization.php";
include_once "../../helper/validation.php";
require_once "../../config/db_config.php";
require_once $root."client/helper/fileHelper.php";
$messages = [];
$message_type = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_title = sanitize($conn, $_POST["name"]);
    $product_brand = sanitize($conn, $_POST["brand"]);
    $product_price = sanitize($conn, $_POST["price"]);
    $category_id = sanitize($conn, $_POST["category_id"]);
    $product_desc = sanitize($conn, $_POST["desc"]);
    $image = $_FILES['product_image'];
    $fileTypes = ['image/jpeg', 'image/jpg', 'image/png'];
    $allowedFileSize = 1024 * 1024 * 1;
    $validationResult = validateFile($image, $fileTypes, $allowedFileSize);
    $path = $root.'client/assets/images/';
    switch ($validationResult) {
        case 0:
            $path = upload_file($image, $path);
            echo $path;
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
    // $insert_query = "INSERT INTO `categories`(`category_title`, `category_desc`) VALUES ('$category_title','$category_desc')";
    // $result = mysqli_query($conn, $insert_query);
    // if ($result) {
    //     $messages['New Record'] = "category added sucessfully.";
    //     $message_type = "Success";
    // } else {
    //     $messages['Error'] = "failed  sql query | " . mysqli_error($conn);
    //     $message_type = "Error";
    // }
    // $_SESSION["messages"] = $messages;
    // $_SESSION["message_type"] = $message_type;
    // header("Location: ../category.php");
}
