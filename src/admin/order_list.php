<?php
ob_start();
session_start();
include_once "../config/site_config.php";
include_once "admin_partials/check_permission.php";
include_once ROOT . "class/User.php";
include ROOT . "partials/header.php";
include_once "admin_partials/admin_header.php";
include_once "handler/OrderHandler.php";


include "admin_partials/table.php";
include_once "admin_partials/admin_footer.php";
?>
<?php
