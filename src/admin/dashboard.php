<?php
session_start();
include "../config/site_config.php";
include_once "admin_partials/check_permission.php";
$pageTitle = "Admin Dashboard | " . SITE_NAME;
include ROOT . "partials/header.php";
require_once 'admin_partials/admin_header.php';
include_once "handler/OrderHandler.php";
?>
<!--Put html contents here-->

<!--Cards of Total Revenue, Orders, Products and Users-->
<section class="cards grid grid-cols-4 grid-rows-8">
    <div class="revenue card bg-blue-500">
        <div class="svg bg-blue-300">
            <svg class="w-6 h-6 text-blue-50 group-hover:text-gray-500 dark:text-gray-400 dark:group-hover:text-gray-400"
                 aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 19">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M1.75 15.363a4.954 4.954 0 0 0 2.638 1.574c2.345.572 4.653-.434 5.155-2.247.502-1.813-1.313-3.79-3.657-4.364-2.344-.574-4.16-2.551-3.658-4.364.502-1.813 2.81-2.818 5.155-2.246A4.97 4.97 0 0 1 10 5.264M6 17.097v1.82m0-17.5v2.138"/>
            </svg>
        </div>
        <p class="text-sm text-gray-50 font-medium mt-2">Revenue</p>
        <p class="text-4xl text-gray-50 font-bold"><?= $totalRevenue ?? 0 ?></p>
    </div>
    <div class="orders card bg-green-500 ">
        <div class="svg bg-green-300">
            <svg class="w-6 h-6 text-green-50 group-hover:text-gray-500 dark:text-gray-400 dark:group-hover:text-gray-400"
                 aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 19">
                <path d="M17 5.923A1 1 0 0 0 16 5h-3V4a4 4 0 1 0-8 0v1H2a1 1 0 0 0-1 .923L.086 17.846A2 2 0 0 0 2.08 20h13.84a2 2 0 0 0 1.994-2.153L17 5.923ZM7 9a1 1 0 0 1-2 0V7h2v2Zm0-5a2 2 0 1 1 4 0v1H7V4Zm6 5a1 1 0 1 1-2 0V7h2v2Z"/>
            </svg>
        </div>
        <p class="text-sm text-gray-50 font-medium mt-2">Orders</p>
        <p class="text-4xl text-gray-50 font-bold"><?= $totalOrders ?? 0 ?></p>
    </div>
    <div class="products card bg-yellow-500">
        <div class="svg bg-yellow-300">
            <svg class="w-6 h-6 text-yellow-50 group-hover:text-gray-500 dark:text-gray-400 dark:group-hover:text-gray-400"
                 aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 19">
                <path d="M19 0H1a1 1 0 0 0-1 1v2a1 1 0 0 0 1 1h18a1 1 0 0 0 1-1V1a1 1 0 0 0-1-1ZM2 6v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V6H2Zm11 3a1 1 0 0 1-1 1H8a1 1 0 0 1-1-1V8a1 1 0 0 1 2 0h2a1 1 0 0 1 2 0v1Z"/>
            </svg>
        </div>
        <p class="text-sm text-gray-50 font-medium mt-2">Products</p>
        <p class="text-4xl text-gray-50 font-bold"><?= $totalProducts ?? 0 ?></p>
    </div>
    <div class="users card bg-purple-500">
        <div class="svg bg-purple-300">
            <svg class="w-6 h-6 text-purple-50 group-hover:text-gray-500 dark:text-gray-400 dark:group-hover:text-gray-400"
                 aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 19">
                <path d="M14.5 0A3.987 3.987 0 0 0 11 2.1a4.977 4.977 0 0 1 3.9 5.858A3.989 3.989 0 0 0 14.5 0ZM9 13h2a4 4 0 0 1 4 4v2H5v-2a4 4 0 0 1 4-4Z"/>
                <path d="M5 19h10v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2ZM5 7a5.008 5.008 0 0 1 4-4.9 3.988 3.988 0 1 0-3.9 5.859A4.974 4.974 0 0 1 5 7Zm5 3a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm5-1h-.424a5.016 5.016 0 0 1-1.942 2.232A6.007 6.007 0 0 1 17 17h2a1 1 0 0 0 1-1v-2a5.006 5.006 0 0 0-5-5ZM5.424 9H5a5.006 5.006 0 0 0-5 5v2a1 1 0 0 0 1 1h2a6.007 6.007 0 0 1 4.366-5.768A5.016 5.016 0 0 1 5.424 9Z"/>
            </svg>
        </div>
        <p class="text-sm text-gray-50 font-medium mt-2">Customers</p>
        <p class="text-4xl text-gray-50 font-bold"><?= $totalCustomers ?? 0 ?></p>
    </div>
    <div class="recent-orders col-span-4 row-span-2 border border-gray-200 rounded-lg mx-4 p-6">
        <p class="text-lg font-medium mb-2 pb-4 border-b border-b-gray-200">Recent Orders</p>
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 ">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <?php foreach ($table_heads as $thead): ?>
                    <th scope="col" class=" py-3"><?= $thead ?></th>
                <?php endforeach; ?>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($table_records as $record): ?>
                <tr class="border-b border-b-gray-200">
                    <?php foreach ($record as $key => $item): ?>
                        <?php if ($key === 'product_image'): ?>
                            <td class=" py-3"><img class="w-8" src=<?= BASE_URL . $item ?>></td>
                        <?php else: ?>
                            <td class=" py-3">
                                <?php if (strtolower($item) == 'success'): ?>
                                    <span class="bg-green-200 rounded-full px-2 py-1 text-green-700 "><?= $item ?></span>
                                <?php elseif (strtolower($item) == 'pending'): ?>
                                    <span class="bg-yellow-200 rounded-full px-2 py-1 text-yellow-600"><?= $item ?></span>
                                <?php elseif (strtolower($item) == 'failed' || strtolower($item) == 'cancelled'): ?>
                                    <span class="bg-red-200 rounded-full px-2 py-1  text-red-600"><?= $item ?></span>
                                <?php else: ?>
                                    <?= $item ?>
                                <?php endif; ?>
                            </td>
                        <?php endif; ?>
                    <?php endforeach; ?>

                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</section>
<?php
include_once "admin_partials/admin_footer.php";
?>
?>