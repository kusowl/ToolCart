<nav class="antialiased <?php if (str_contains($_SERVER['REQUEST_URI'],'/ToolCart/home')) echo 'bg-grid' ?>">
    <div class="max-w-screen-xl px-4 mx-auto 2xl:px-0 py-6">
        <div class="navbar">

            <div class="flex items-center space-x-8 mr-8">
                <div class="shrink-0">
                    <a href="<?= BASE_URL ?>" title="" class="font-bold text-2xl text-white flex gap-2 items-center">
                        <!-- <img class="block w-auto h-8 dark:hidden" src="https://flowbite.s3.amazonaws.com/blocks/e-commerce/logo-full.svg" alt=""> -->
                        <img class="w-auto h-6 " src="<?= BASE_URL.'assets/images/logo/logo-white.webp' ?>" alt="">
                        <?= SITE_NAME ?? "SiteName" ?>

                    </a>
                </div>


                <form method="GET" action="<?= BASE_URL.'search_result' ?>" class="max-w-md w-sm mx-auto">
                    <input type="hidden" name="action" value="search">
                    <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                            </svg>
                        </div>
                        <input type="search" name="key" id="default-search" class="block w-full p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-100 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search Tools, Parts..." required />
                        <button type="submit" class="hidden"></button>
                    </div>
                </form>


            </div>

            <div class="flex items-center lg:space-x-2">

                <?php include_once ROOT . "partials/nav-cart.php"; ?>
                <div>
                    <button id="userDropdownButton1" data-dropdown-toggle="userDropdown1" type="button"
                            class="navbar-btn">
                        <svg class="w-5 h-5 me-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                             height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-width="2"
                                  d="M7 17v1a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1v-1a3 3 0 0 0-3-3h-4a3 3 0 0 0-3 3Zm8-9a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                        </svg>
                        <?php if (isset($_SESSION["user_name"])) {
                            echo $_SESSION['user_name'];
                        } else {
                            echo 'Account';
                        } ?>
                        <svg class="w-4 h-4 text-gray-900 dark:text-white ms-1" aria-hidden="true"
                             xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="m19 9-7 7-7-7"/>
                        </svg>
                    </button>
                </div>
                <div id="userDropdown1"
                     class="hidden z-10 w-56 divide-y divide-gray-100 overflow-hidden overflow-y-auto rounded-lg bg-white antialiased shadow dark:divide-gray-600 dark:bg-gray-700">
                    <?php if (isset($_SESSION["user_name"])): ?>
                        <ul class="p-2 text-start text-sm font-medium text-gray-900 dark:text-white">
                            <li><a href="profile" title="user profile"
                                   class="inline-flex w-full items-center gap-2 rounded-md px-3 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-600">My
                                    Account </a></li>
                            <li><a href="#" title=""
                                   class="inline-flex w-full items-center gap-2 rounded-md px-3 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-600">
                                    My Orders </a></li>
                            <li><a href="#" title=""
                                   class="inline-flex w-full items-center gap-2 rounded-md px-3 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-600">
                                    Settings </a></li>
                            <li><a href="#" title=""
                                   class="inline-flex w-full items-center gap-2 rounded-md px-3 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-600">
                                    Favourites </a></li>
                            <li><a href="#" title=""
                                   class="inline-flex w-full items-center gap-2 rounded-md px-3 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-600">
                                    Delivery Addresses </a></li>
                            <li><a href="#" title=""
                                   class="inline-flex w-full items-center gap-2 rounded-md px-3 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-600">
                                    Billing Data </a></li>
                        </ul>
                        <div class="p-2 text-sm font-medium text-gray-900 dark:text-white">
                            <a href="<?= BASE_URL . 'logout' ?>" title="Sign out"
                               class="inline-flex w-full items-center gap-2 rounded-md px-3 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-600">
                                Sign Out </a>
                        </div>
                    <?php else: ?>
                        <div class="p-2 text-sm font-medium text-gray-900 dark:text-white">
                            <a href="<?= BASE_URL . 'login' ?>" title="Sign in"
                               class="inline-flex w-full items-center gap-2 rounded-md px-3 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-600">
                                Sign In </a>
                        </div>
                    <?php endif; ?>
                </div>

                <button type="button" data-collapse-toggle="ecommerce-navbar-menu-1"
                        aria-controls="ecommerce-navbar-menu-1" aria-expanded="false"
                        class="flex lg:hidden items-center justify-center hover:bg-gray-100 rounded-md dark:hover:bg-gray-700 p-2 text-gray-900 dark:text-white">

                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                         fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                              d="M5 7h14M5 12h14M5 17h14"/>
                    </svg>
                </button>
            </div>
        </div>

        <div id="ecommerce-navbar-menu-1"
             class="bg-gray-50 dark:bg-gray-700 dark:border-gray-600 border border-gray-200 rounded-lg py-3 hidden px-4 mt-4">
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