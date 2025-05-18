<?php 
session_start();
require_once "../config/db_config.php";

$table_heads = ['Category ID','Category', 'Description'];

// get all the record
$results = mysqli_query($conn,"SELECT `id`, `category_title`, `category_desc` FROM `categories`");
while($rows = mysqli_fetch_row($results)){
    $table_records [] = $rows;
}


// get the table view
ob_start();
include "admin_partials/table.php";
$output = ob_get_clean();

include "pages/dashboard.html.php"
?>