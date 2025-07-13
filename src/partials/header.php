
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?? SITE_NAME ?></title>
    <link rel="icon" type="image/x-icon" href="<?= BASE_URL.'assets/images/logo/logo.ico' ?>">
    <link rel="stylesheet" href="<?=BASE_URL?>style.css">
    <script src="<?=BASE_URL.'src/assets/js/jquery-3.7.1.min.js'?>"></script>


</head>
<body>
<?php
$messages = $_SESSION["messages"] ?? '';
$message_type = $_SESSION["message_type"] ?? '';
if ($messages != '') {
    include_once ROOT . "partials/popup.php";
    unset($_SESSION["messages"]);
    unset($_SESSION["message_type"]);
}
?>