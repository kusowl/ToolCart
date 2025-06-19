<?php
session_start();
include "config/site_config.php";
include_once "config/db_config.php";
include_once "partials/header.php";
include_once "partials/navbar.html.php";
include_once "handler/ProductHandler.php";
$pageTitle = "Search Result";
?>
    <section class="mt-12">
        <?php
        include_once "product_grid.php";
        ?>
    </section>

<?php
include_once "partials/footer.php";
?>