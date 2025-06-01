<?php
session_start();
include "config/site_config.php";
$pageTitle = 'Home : '.SITE_NAME;
include_once "partials/header.php";
include_once "partials/navbar.html.php";
?>
    <section class="hero">
        <div class="mx-auto mt-12 grid max-w-screen-xl md:grid-cols-12 lg:gap-12 xl:gap-0">
            <div class="content-center justify-self-start md:col-span-7 md:text-start">
                <h1 class="mb-4 text-4xl font-extrabold leading-none tracking-tight dark:text-white md:max-w-2xl md:text-5xl xl:text-6xl">
                    Limited Time Offer!<br/>Up to 50% OFF!</h1>
                <p class="mb-4 max-w-2xl text-gray-500 dark:text-gray-400 md:mb-12 md:text-lg mb-3 lg:mb-5 lg:text-xl">
                    Don't Wait - Limited Stock at Unbeatable Prices!</p>
                <a href="#"
                   class="inline-block rounded-lg bg-primary-600 px-6 py-3.5 text-center font-medium text-white hover:bg-primary-800 focus:outline-none focus:ring-4 focus:ring-primary-300 dark:bg-primary-700 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Shop
                    Now</a>
            </div>
        </div>
        <div class="flex justify-center">
        <div class="brand"
        >
            <ul class="logos">
                <li>
                    <img src="<?= BASE_URL ?>assets/images/logo/bosch.svg" alt="">
                </li>
<!--                <li>-->
<!--                    <img src="--><?php //= BASE_URL ?><!--assets/images/logo/dormakaba.svg" alt="">-->
<!--                </li>-->
                <li>
                    <img src="<?= BASE_URL ?>assets/images/logo/Dewalt.svg" alt="">
                </li>
                <li>
                    <img src="<?= BASE_URL ?>assets/images/logo/Hikoki.svg" alt="">
                </li>
                <li>
                    <img src="<?= BASE_URL ?>assets/images/logo/Fein.svg" alt="">
                </li>
                <li>
                    <img src="<?= BASE_URL ?>assets/images/logo/KPT.svg" alt="">
                </li>
<!--                <li>-->
<!--                    <img src="--><?php //= BASE_URL ?><!--assets/images/logo/StanlyBlack.svg" alt="">-->
<!--                </li>-->
                <li>
                    <img src="<?= BASE_URL ?>assets/images/logo/makita.svg" alt="">
                </li>
            </ul>
            <ul class="logos">
                <li>
                    <img src="<?= BASE_URL ?>assets/images/logo/bosch.svg" alt="">
                </li>
<!--                <li>-->
<!--                    <img src="--><?php //= BASE_URL ?><!--assets/images/logo/dormakaba.svg" alt="">-->
<!--                </li>-->
                <li>
                    <img src="<?= BASE_URL ?>assets/images/logo/Dewalt.svg" alt="">
                </li>
                <li>
                    <img src="<?= BASE_URL ?>assets/images/logo/Hikoki.svg" alt="">
                </li>
                <li>
                    <img src="<?= BASE_URL ?>assets/images/logo/Fein.svg" alt="">
                </li>
                <li>
                    <img src="<?= BASE_URL ?>assets/images/logo/KPT.svg" alt="">
                </li>
<!--                <li>-->
<!--                    <img src="--><?php //= BASE_URL ?><!--assets/images/logo/StanlyBlack.svg" alt="">-->
<!--                </li>-->
                <li>
                    <img src="<?= BASE_URL ?>assets/images/logo/makita.svg" alt="">
                </li>
            </ul>
        </div>
        </div>
    </section>
<?php
include_once "product_grid.php";
include "partials/footer.php";
//phpinfo();
?>