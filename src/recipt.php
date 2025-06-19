<?php
session_start();
include "config/site_config.php";
$pageTitle = "Recipt : " . SITE_NAME;
include_once ROOT . "partials/header.php";
include_once "handler/CartHandler.php";
include_once "handler/CheckoutHandler.php";
$res = $address->getAddress($userId);
$addRes = $res[0];
?>
<section class="bg-white py-8 antialiased dark:bg-gray-900 md:py-16 mt-12">
    <div class="mx-auto max-w-2xl px-4 2xl:px-0">
        <h2 class="text-4xl font-bold text-primary-600 dark:text-white mb-2">ToolCart</h2>
        <p class="text-gray-500 dark:text-gray-400 mb-6 md:mb-8">Order No. #7564804</p>
        <p class="text-xl font-semibold text-gray-900 dark:text-white sm:text-2xl">Products</p>
        <div class="mt-2 md:gap-6 lg:flex lg:items-start xl:gap-8">
            <div class="mx-auto w-full flex-none lg:max-w-2xl xl:max-w-4xl ">
                <?php
                $totalPrice = 0;
                $originalPrice = 0;
                $savings = 0;
                $pickup = 0;
                $tax = 0;
                if (!empty($cartRecords)):
                    ?>
                    <div class="relative rounded-lg  bg-gray-50 border border-gray-100">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 ">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    Product name
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Brand
                                </th>

                                <th scope="col" class="px-6 py-3">
                                    Price
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Qty
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Total
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            foreach ($cartRecords as $record):
                                // calculate the price, price * qty
                                $price = (int)$record['qty'] * (int)$record['product_price'];
                                $originalPrice += $price;
                                ?>
                                <tr class="bg-white border-t dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                                    <th scope="row"
                                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        <?= $record['product_title'] ?>
                                    </th>
                                    <td class="px-6 py-4">
                                        <?= $record['product_brand'] ?>
                                    </td>

                                    <td class="px-6 py-4">
                                        <?= $record['product_price'] ?>
                                    </td>
                                    <td class="px-6 py-4">
                                        <?= $record['qty'] ?>
                                    </td>
                                    <td class="px-6 py-4">
                                        <?= $price ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <?php
                    // Calculate totaL PRICE
                    $totalPrice = $originalPrice - $savings + $pickup + $tax;
                endif; ?>
                <div class="flex justify-between py-2 px-6 my-4  rounded-lg  bg-gray-50 border border-gray-100 text-sm font-medium">
                <p>Total Price : </p>
                <p><?= $totalPrice ?></p>
                </div>
            </div>
        </div>

        <p class="text-xl font-semibold text-gray-900 dark:text-white sm:text-2xl mb-2">Address</p>

        <div class="space-y-4 sm:space-y-2 rounded-lg border border-gray-100 bg-gray-50 p-6 dark:border-gray-700 dark:bg-gray-800 mb-6 md:mb-8">
            <dl class="sm:flex items-center justify-between gap-4">
                <dt class="font-normal mb-1 sm:mb-0 text-gray-500 dark:text-gray-400">Date</dt>
                <dd class="font-medium text-gray-900 dark:text-white sm:text-end"><?= date('d M Y') ?></dd>
            </dl>
            <dl class="sm:flex items-center justify-between gap-4">
                <dt class="font-normal mb-1 sm:mb-0 text-gray-500 dark:text-gray-400">Payment Method</dt>
                <dd class="font-medium text-gray-900 dark:text-white sm:text-end">Fast Delivery</dd>
            </dl>
            <dl class="sm:flex items-center justify-between gap-4">
                <dt class="font-normal mb-1 sm:mb-0 text-gray-500 dark:text-gray-400">Name</dt>
                <dd class="font-medium text-gray-900 dark:text-white sm:text-end"><?= $addRes->getName() ?></dd>
            </dl>
            <dl class="sm:flex items-center justify-between gap-4">
                <dt class="font-normal mb-1 sm:mb-0 text-gray-500 dark:text-gray-400">Address</dt>
                <dd class="font-medium text-gray-900 dark:text-white sm:text-end"><?php
                    echo "{$addRes->getLine1()}<br>{$addRes->getLine2()}<br>{$addRes->getCity()}&nbsp{$addRes->getPin()}";
                    ?>
                </dd>
            </dl>
            <dl class="sm:flex items-center justify-between gap-4">
                <dt class="font-normal mb-1 sm:mb-0 text-gray-500 dark:text-gray-400">Phone</dt>
                <dd class="font-medium text-gray-900 dark:text-white sm:text-end">
                    +<?= $addRes->getCountryCode() . ' ' . $addRes->getPhNo() ?></dd>
            </dl>
        </div>

</section>

<script>
    window.onload = function() {
        window.print();
    };
</script>
</body>