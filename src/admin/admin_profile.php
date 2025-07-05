<?php
ob_start();
session_start();
require_once '../config/site_config.php';
include_once "admin_partials/check_permission.php";
include ROOT . "partials/header.php";
require_once 'admin_partials/admin_header.php';
include_once ROOT."handler/ProfileHandler.php";
$messages = $_SESSION["messages"] ?? '';
$message_type = $_SESSION["message_type"] ?? '';

if ($messages != '') {
    include "../partials/popup.php";
    unset($_SESSION["messages"]);
    unset($_SESSION["message_type"]);
}

if(!empty($_SESSION['form_data'])){
    $formData = $_SESSION['form_data'];
}
?>
<section class="mt-4">
  <?php include_once ROOT."partials/user-profile.php"; ?>
</section>
<?php require_once 'admin_partials/admin_footer.php' ?>