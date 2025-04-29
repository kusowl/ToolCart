<?php 
session_start();
ob_start();
include "admin_partials/table.php";
$output = ob_get_clean();
include "pages/dashboard.html.php"
?>