<?php
session_start();
include_once __DIR__."/../../config/site_config.php";
include_once ROOT . "config/db_config.php";
include_once ROOT . "class/Category.php";
$messages = [];
$message_type = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $categoryTitle = $_POST["title"];
    $categoryDesc = $_POST["desc"];
    $category = new Category();
    $result = $category->addCategory($categoryTitle, $categoryDesc);
    if ($result) {
        $messages['New Record'] = "category added sucessfully.";
        $message_type = "Success";
    } else {
        $messages['Error'] = "failed  sql query " ;
        $message_type = "Error";
    }
    $_SESSION["messages"] = $messages;
    $_SESSION["message_type"] = $message_type;
    header("Location: admin/category_list.php");
}
