<?php
session_start();
require_once "../config/db_config.php";
require_once "../config/site_config.php";

$table_heads = ['Image','Category', 'Product', 'Description', 'Price', 'Brand'];
$select_query = "SELECT product.product_image, product.product_title, categories.category_title, product.product_desc, product.product_price, product.product_price, product.product_brand FROM product JOIN categories ON product.category_id = categories.id";
// get all the record
$results = mysqli_query($conn, $select_query);
while ($rows = mysqli_fetch_assoc($results)) {
    $table_records[] = $rows;
}

// get the table view
ob_start();
include "admin_partials/table.php";
$output = ob_get_clean();

include "pages/dashboard.html.php";