<?php 
session_start();
require_once "../config/db_config.php";

$messages = $_SESSION["messages"];
$message_type = $_SESSION["message_type"];

if (isset($messages)) {
    include "../partials/popup.php";
    unset($_SESSION["messages"]);
    unset($_SESSION["message_type"]);
}
// get categories from db
$results = mysqli_query($conn, "SELECT `id`, `category_title` FROM `categories`");
$categories = [];
while($row = mysqli_fetch_assoc($results)){
    $categories[] = $row;
}
ob_start();
include "pages/add_product.html.php";
$output = ob_get_clean();

include "pages/dashboard.html.php"
?>