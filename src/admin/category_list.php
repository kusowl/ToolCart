<?php
session_start();
include_once "../config/site_config.php";
include_once ROOT . "config/db_config.php";
include_once ROOT . "class/Category.php";
include ROOT . "partials/header.php";
include_once "admin_partials/admin_header.php";
$messages = $_SESSION["messages"] ?? '';
$message_type = $_SESSION["message_type"] ?? '';


$category = new Category();
$table_heads = ['Category ID', 'Category', 'Description'];
$categories = $category->getAllCategory(99);
$table_records = [];
$records = [];
foreach ($categories as $categoryRec) {
    $records['id'] = $categoryRec->getId();
    $records['title'] = trim($categoryRec->getTitle());
    $records['desc'] = trim($categoryRec->getDescription());
    $table_records[] = $records;
}
$primaryAction = 'Category';
$primaryActionLink = BASE_URL . "admin/add_category.php";
$deleteLink = 'handler/CategoryHandler.php';
if ($messages != '') {
    include_once "../partials/popup.php";
    unset($_SESSION["messages"]);
    unset($_SESSION["message_type"]);
}
include "admin_partials/table.php";
include_once "admin_partials/admin_footer.php";