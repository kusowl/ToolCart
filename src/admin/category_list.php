<?php
session_start();
include_once "../config/site_config.php";
include_once ROOT . "config/db_config.php";
include_once ROOT . "class/Category.php";
include ROOT . "partials/header.php";
include_once "admin_partials/admin_header.php";
$category = new Category();
$table_heads = ['Category ID', 'Category', 'Description'];
$categories = $category->getAllCategory(99);
$table_records = [];
$records = [];
foreach ($categories as $categoryRec) {
    $records['id'] = $categoryRec->getId();
    $records['title'] = $categoryRec->getTitle();
    $records['desc'] = $categoryRec->getDescription();
    $table_records[] = $records;
}
include "admin_partials/table.php";
include_once "admin_partials/admin_footer.php";
?>