<?php 
session_start();
$messages = $_SESSION["messages"];
$message_type = $_SESSION["message_type"];

if (isset($messages)) {
    include "../partials/popup.php";
    unset($_SESSION["messages"]);
    unset($_SESSION["message_type"]);
}

ob_start();
include "pages/add_category.html.php";
$output = ob_get_clean();

include "pages/dashboard.html.php"
?>