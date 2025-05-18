<?php
session_start();
include_once "../../helper/sanitization.php";
include_once "../../helper/validation.php";
require_once "../../config/db_config.php";
$messages = [];
$message_type = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $category_title = sanitize($conn, $_POST["title"]);
    $category_desc = sanitize($conn, $_POST["desc"]);

    $insert_query = "INSERT INTO `categories`(`category_title`, `category_desc`) VALUES ('$category_title','$category_desc')";
    $result = mysqli_query($conn, $insert_query);
    if ($result) {
        $messages['New Record'] = "category added sucessfully.";
        $message_type = "Success";
    } else {
        $messages['Error'] = "failed  sql query | " . mysqli_error($conn);
        $message_type = "Error";
    }
    $_SESSION["messages"] = $messages;
    $_SESSION["message_type"] = $message_type;
    header("Location: ../category.php");
}
