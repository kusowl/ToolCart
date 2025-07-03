<?php
session_start();
require_once 'config/site_config.php';
require_once ROOT . 'config/db_config.php';
include_once "handler/ProfileHandler.php";
include_once "partials/header.php";
include_once "partials/navbar.html.php";
$messages = $_SESSION["messages"] ?? '';
$message_type = $_SESSION["message_type"] ?? '';

if ($messages != '') {
    include ROOT . "/partials/popup.php";
    unset($_SESSION["messages"]);
    unset($_SESSION["message_type"]);
}
?>
    <section class="mt-20">
<?php include_once "partials/user-profile.php"; ?>
    </section>
<?php
include_once "partials/footer.php";
?>