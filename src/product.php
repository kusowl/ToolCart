<?php
session_start();
include "config/site_config.php";
include_once 'handler/ProductHandler.php';
include_once "partials/header.php";
include_once "partials/navbar.html.php";
?>
<section class="bg-gray-50 py-8 antialiased dark:bg-gray-900 md:py-12">
<?php include_once "product_grid.php";?>
</section>

<?php
include ROOT . "partials/footer.php";
?>
