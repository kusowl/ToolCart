<?php
session_start();
?>
<nav class="bg-gray-200 dark:bg-gray-800 antialiased">
    <div class="max-w-screen-xl px-4 mx-auto 2xl:px-0 py-6">
        <div class="navbar">

            <div class="flex items-center space-x-8">
                <div class="shrink-0">
                    <a href="<?= BASE_URL ?>" title="" class="font-bold text-2xl">
                        <!-- <img class="block w-auto h-8 dark:hidden" src="https://flowbite.s3.amazonaws.com/blocks/e-commerce/logo-full.svg" alt="">
                        <img class="hidden w-auto h-8 dark:block" src="https://flowbite.s3.amazonaws.com/blocks/e-commerce/logo-full-dark.svg" alt=""> -->
                        <?= SITE_NAME ?? "SiteName" ?>

                    </a>
                </div>

                <ul class="hidden text-white dark:text-gray-900 lg:flex items-center justify-start gap-6 md:gap-8 py-3 sm:justify-center">
                    <li>
                        <a href="#" title="" class="navbar-link">
                            Home
                        </a>
                    </li>
                    <li class="shrink-0">
                        <a href="#" title="" class="navbar-link">
                            Best Sellers
                        </a>
                    </li>
                    <li class="shrink-0">
                        <a href="#" title="" class="navbar-link">
                            Gift Ideas
                        </a>
                    </li>
                    <li class="shrink-0">
                        <a href="#" title="" class="navbar-link">
                            Today's Deals
                        </a>
                    </li>

                </ul>
            </div>

            <div class="flex items-center lg:space-x-2">

                <button id="myCartDropdownButton1" data-dropdown-toggle="myCartDropdown1" type="button" class="navbar-btn">
                    <div class="cart_icon flex justify-center relative">
                        <span class="absolute bottom-3.5 text-[0.625rem] text-primary-800"><?= $cart_item_count ?? '0' ?></span>
                        <svg class="w-5 h-5 lg:me-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 4h1.5L9 16m0 0h8m-8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm-8.5-3h9.25L19 7H7.312" />
                        </svg>
                    </div>
                    <span class="hidden sm:flex">My Cart</span>
                    <svg class="hidden sm:flex w-4 h-4 text-gray-900 dark:text-white ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 9-7 7-7-7" />
                    </svg>
                </button>

                <div id="myCartDropdown1" class="hidden z-10 mx-auto max-w-sm space-y-4 overflow-hidden rounded-lg bg-white p-4 antialiased shadow-lg dark:bg-gray-800">
                    <div class="grid grid-cols-2 gap-y-2">
                        <?php foreach ($cartrecords as $record): ?>
                            <div class="bg-neutral-100 px-2 py-1 rounded-l-lg">
                                <a href="#" class=" text-sm font-semibold leading-none text-gray-900 dark:text-white hover:underline"><?= $record['product_title'] ?></a>
                                <p class="mt-0.5 truncate text-sm font-normal text-gray-500 dark:text-gray-400">₹ <?= $record['product_price'] ?></p>
                            </div>

                            <div class="flex items-center justify-end gap-6 bg-neutral-100 px-2 py-1 rounded-r-lg">
                                <div class="flex space-x-1 items-center">
                                    <p class="text-sm font-normal leading-none text-gray-500 dark:text-gray-400">Qty</p>

                                    <button class="text-gray-900 hover:text-primary-800 bg-neutral-300 hover:bg-neutral-400 rounded-full p-0.5" type="button" onclick="decrementQty()">-</button>
                                    <p class="text-sm font-normal leading-none text-gray-500 dark:text-gray-400" name="quantity" id="qty"><?= $record['qty'] ?></p>

                                    <button class=" text-gray-900 hover:text-primary-800 bg-neutral-300 hover:bg-neutral-400 rounded-full p-0.5" type="button" onclick="incrementQty()">+</button>

                                </div>
                                <button data-tooltip-target="tooltipRemoveItem1a" type="button" class="text-red-600 hover:text-red-700 dark:text-red-500 dark:hover:text-red-600">
                                    <span class="sr-only"> Remove </span>
                                    <svg class="h-4 w-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                        <path fill-rule="evenodd" d="M2 12a10 10 0 1 1 20 0 10 10 0 0 1-20 0Zm7.7-3.7a1 1 0 0 0-1.4 1.4l2.3 2.3-2.3 2.3a1 1 0 1 0 1.4 1.4l2.3-2.3 2.3 2.3a1 1 0 0 0 1.4-1.4L13.4 12l2.3-2.3a1 1 0 0 0-1.4-1.4L12 10.6 9.7 8.3Z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                                <div id="tooltipRemoveItem1a" role="tooltip" class="tooltip invisible absolute z-10 inline-block rounded-lg bg-gray-900 px-3 py-2 text-sm font-medium text-white opacity-0 shadow-sm transition-opacity duration-300 dark:bg-gray-700">
                                    Remove item
                                    <div class="tooltip-arrow" data-popper-arrow></div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <a href="#" title="" class="mb-2 me-2 inline-flex w-full items-center justify-center rounded-lg bg-primary-700 px-5 py-2.5 text-sm font-medium text-white hover:bg-primary-800 focus:outline-none focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800" role="button"> Proceed to Checkout </a>
                </div>

                <button id="userDropdownButton1" data-dropdown-toggle="userDropdown1" type="button" class="navbar-btn">
                    <svg class="w-5 h-5 me-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-width="2" d="M7 17v1a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1v-1a3 3 0 0 0-3-3h-4a3 3 0 0 0-3 3Zm8-9a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    </svg>
                    <?php if (isset($_SESSION["name"])) {
                        echo $_SESSION['name'];
                    } else {
                        echo 'Account';
                    } ?>
                    <svg class="w-4 h-4 text-gray-900 dark:text-white ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 9-7 7-7-7" />
                    </svg>
                </button>

                <div id="userDropdown1" class="hidden z-10 w-56 divide-y divide-gray-100 overflow-hidden overflow-y-auto rounded-lg bg-white antialiased shadow dark:divide-gray-600 dark:bg-gray-700">
                    <?php if (isset($_SESSION["name"])): ?>
                        <ul class="p-2 text-start text-sm font-medium text-gray-900 dark:text-white">
                            <li><a href="#" title="" class="inline-flex w-full items-center gap-2 rounded-md px-3 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-600">My Account </a></li>
                            <li><a href="#" title="" class="inline-flex w-full items-center gap-2 rounded-md px-3 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-600"> My Orders </a></li>
                            <li><a href="#" title="" class="inline-flex w-full items-center gap-2 rounded-md px-3 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-600"> Settings </a></li>
                            <li><a href="#" title="" class="inline-flex w-full items-center gap-2 rounded-md px-3 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-600"> Favourites </a></li>
                            <li><a href="#" title="" class="inline-flex w-full items-center gap-2 rounded-md px-3 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-600"> Delivery Addresses </a></li>
                            <li><a href="#" title="" class="inline-flex w-full items-center gap-2 rounded-md px-3 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-600"> Billing Data </a></li>
                        </ul>
                        <div class="p-2 text-sm font-medium text-gray-900 dark:text-white">
                            <a href="<?= $baseUrl . 'src/pages/auth/logout.php' ?>" title="Sign33 out" class="inline-flex w-full items-center gap-2 rounded-md px-3 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-600"> Sign Out </a>
                        </div>
                    <?php else: ?>
                        <div class="p-2 text-sm font-medium text-gray-900 dark:text-white">
                            <a href="<?= $baseUrl . 'src/pages/auth/login.php' ?>" title="Sign33 out" class="inline-flex w-full items-center gap-2 rounded-md px-3 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-600"> Sign In </a>
                        </div>
                    <?php endif; ?>
                </div>

                <button type="button" data-collapse-toggle="ecommerce-navbar-menu-1" aria-controls="ecommerce-navbar-menu-1" aria-expanded="false" class="flex lg:hidden items-center justify-center hover:bg-gray-100 rounded-md dark:hover:bg-gray-700 p-2 text-gray-900 dark:text-white">

                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M5 7h14M5 12h14M5 17h14" />
                    </svg>
                </button>
            </div>
        </div>

        <div id="ecommerce-navbar-menu-1" class="bg-gray-50 dark:bg-gray-700 dark:border-gray-600 border border-gray-200 rounded-lg py-3 hidden px-4 mt-4">
            <ul class="text-gray-900 dark:text-white text-sm font-medium dark:text-white space-y-3">
                <li>
                    <a href="#" class="hover:text-primary-700 dark:hover:text-primary-500">Home</a>
                </li>
                <li>
                    <a href="#" class="hover:text-primary-700 dark:hover:text-primary-500">Best Sellers</a>
                </li>
                <li>
                    <a href="#" class="hover:text-primary-700 dark:hover:text-primary-500">Gift Ideas</a>
                </li>
                <li>
                    <a href="#" class="hover:text-primary-700 dark:hover:text-primary-500">Games</a>
                </li>
                <li>
                    <a href="#" class="hover:text-primary-700 dark:hover:text-primary-500">Electronics</a>
                </li>
                <li>
                    <a href="#" class="hover:text-primary-700 dark:hover:text-primary-500">Home & Garden</a>
                </li>
            </ul>
        </div>
    </div>
</nav>