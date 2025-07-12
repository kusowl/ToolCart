<?php
ob_start();
session_start();
include_once "../config/site_config.php";
include_once "admin_partials/check_permission.php";
include_once ROOT . "class/User.php";
include ROOT . "partials/header.php";
include_once "admin_partials/admin_header.php";
include_once "handler/OrderHandler.php";

$messages = $_SESSION["messages"] ?? '';
$message_type = $_SESSION["message_type"] ?? '';
if ($messages != '') {
    include_once "../partials/popup.php";
    unset($_SESSION["messages"]);
    unset($_SESSION["message_type"]);
}
include "admin_partials/table.php";
include_once "admin_partials/admin_footer.php";
?>
<?php
