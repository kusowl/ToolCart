<?php
session_start();
include_once "../config/site_config.php";
include_once ROOT . "config/db_config.php";
include_once ROOT . "class/Product.php";
include_once ROOT . "class/Category.php";
include ROOT . "partials/header.php";
include_once "admin_partials/admin_header.php";
$product = new Product();
$category = new Category();
$table_heads = ['Product ID', 'Product', 'Category', 'Price', 'Brand', 'Description'];
$products = $product->getAllProduct();
$table_records = [];
$records = [];
foreach ($products as $productRec) {
    $records['id'] = $productRec->getId();
    $records['title'] = $productRec->getTitle();
    $records['category'] = $category->getCategoryById($productRec->getCategoryId())[0]->getTitle();
    $records['price'] = $productRec->getPrice();
    $records['Brand'] = $productRec->getBrand();
    $records['desc'] = $productRec->getDescription();
    $table_records[] = $records;
}
include "admin_partials/table.php";
include_once "admin_partials/admin_footer.php";
?>