<?php
session_start();
include_once "../config/db_config.php";
include_once '../config/file_config.php';
include_once '../config/site_config.php';
include_once '../partials/header.php';
include_once '../partials/navbar.php';
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $product_id = $_GET["id"];
}

// Fetch records from DB

$select_query = "SELECT product.product_image, product.product_title, categories.category_title, product.product_desc, product.product_price, product.product_price, product.product_brand FROM product  JOIN categories ON product.category_id = categories.id WHERE product.id = $product_id";

$result = mysqli_query($conn, $select_query);
if (mysqli_num_rows($result) > 0) {
    $product = mysqli_fetch_assoc($result);
    $category = $product['category_title'];
    include_once "product/product_view.php";
}

include_once '../partials/footer.php';
