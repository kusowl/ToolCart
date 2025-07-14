<?php
session_start();
ob_start();
include_once "config/site_config.php";
include_once "config/db_config.php";
$pageTitle = 'Home : ' . SITE_NAME;
include_once "partials/header.php";
include_once "partials/navbar.html.php";
?>
    <section class="hero bg-grid">
        <div class="mx-auto mt-12 flex justify-center content-center">
            <div class="flex flex-col items-center justify-center md:col-span-7 md:text-start">
                <h1 class="mb-4 text-4xl font-extrabold text-[#656C7B] leading-none tracking-tight dark:text-white md:max-w-2xl md:text-5xl xl:text-6xl">
                    Great <span class="text-primary-600">Power</span> needs,</h1>

                <h1 class="mb-4 text-4xl font-extrabold text-[#656C7B] leading-none tracking-tight dark:text-white md:max-w-2xl md:text-5xl xl:text-6xl">
                    Great <span class="text-primary-600">Tools</span></h1>
            </div>
        </div>
        <div class="flex justify-center">
            <div class="brand brand-smooth loaded"
            >
                <ul class="logos">
                    <li>
                        <img src="<?= BASE_URL ?>assets/images/logo/bosch.svg" alt="">
                    </li>
                    <!--                <li>-->
                    <!--                    <img src="-->
                    <?php //= BASE_URL ?><!--assets/images/logo/dormakaba.svg" alt="">-->
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
                    <!--                    <img src="-->
                    <?php //= BASE_URL ?><!--assets/images/logo/StanlyBlack.svg" alt="">-->
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
                    <!--                    <img src="-->
                    <?php //= BASE_URL ?><!--assets/images/logo/dormakaba.svg" alt="">-->
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
                    <!--                    <img src="-->
                    <?php //= BASE_URL ?><!--assets/images/logo/StanlyBlack.svg" alt="">-->
                    <!--                </li>-->
                    <li>
                        <img src="<?= BASE_URL ?>assets/images/logo/makita.svg" alt="">
                    </li>
                </ul>
            </div>
        </div>
    </section>
    <section class="bg-gray-50 py-8 antialiased dark:bg-gray-900 md:py-16">
        <div class="mx-auto max-w-screen-xl px-4 2xl:px-0">
            <div class="mb-4 flex items-center justify-between gap-4 md:mb-8">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white sm:text-2xl">Shop by category</h2>

                <!--                <a href="#" title="" class="flex items-center text-base font-medium text-primary-700 hover:underline dark:text-primary-500">-->
                <!--                    See more categories-->
                <!--                    <svg class="ms-1 h-5 w-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">-->
                <!--                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 12H5m14 0-4 4m4-4-4-4" />-->
                <!--                    </svg>-->
                <!--                </a>-->
            </div>

            <div class="grid gap-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4" id="categories">
                <?php
                include_once ROOT . "class/Category.php";
                $category = new Category();
                $categories = $category->getAllCategory();
                foreach ($categories as $categoryRec) :
                    ?>
                    <a href="search_result?action=category&name=<?=$categoryRec->getTitle()?>&key=<?=$categoryRec->getId()?>"
                       class="flex items-center rounded-lg border border-gray-200 hover:bg-primary-600 text-gray-900 hover:text-gray-100 bg-white px-4 py-2  dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700">

                        <span class="text-sm font-medium  dark:text-white p-7 "><?php echo $categoryRec->getTitle() ?></span>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
<?php
include_once 'class/Product.php';
$productObj = new Product();
$products = $productObj->getAllProduct();
$pageTitle = "Shop Products";
include_once "product_grid.php";
include "partials/footer.php";
//phpinfo();
?>