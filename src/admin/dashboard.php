<?php 
session_start();
include "../config/site_config.php";
$pageTitle = "Admin Dashboard | ".SITE_NAME;
include ROOT."partials/header.php";
require_once 'admin_partials/admin_header.php';
?>
<!--Put html contents here-->
<?php
include_once "admin_partials/admin_footer.php";
?>
?>