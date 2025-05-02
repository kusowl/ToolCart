<?php
session_start();
require_once "../../config/file_config.php";
include_once "../../helper/sanitization.php";
include_once "../../helper/validation.php";
require_once "../../config/db_config.php";
require_once $root . "client/helper/fileHelper.php";
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
    $rel_path = 'client/assets/images/';
    $path = $root .$rel_path ;
    switch ($validationResult) {
        case 0:
            $img_name = upload_file($image, $path);
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
    if (in_array('Image Error', $messages)) {
        $message_type = 'error';
    } else {
        $img_path = $rel_path.$img_name;
        $insert_query = "INSERT INTO `product`(`category_id`, `product_title`, `product_desc`, `product_price`, `product_brand`, `product_image`) VALUES ('$category_id','$product_title','$product_desc','$product_price','$product_brand', '$img_path')";

        $result = mysqli_query($conn, $insert_query);
        if ($result) {
            $messages['New Record'] = "product added successfully.";
            $message_type = "success";
        } else {
            $messages['Error'] = "failed  sql query | " . mysqli_error($conn);
            $message_type = "error";
        }
    }
    $_SESSION["messages"] = $messages;
    $_SESSION["message_type"] = $message_type;
    header("Location: ../add_product.php");
}
