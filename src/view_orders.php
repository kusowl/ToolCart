<?php
session_start();
include "config/site_config.php";
$pageTitle = "Checkout : " . SITE_NAME;
include_once ROOT . "partials/header.php";
include_once "partials/navbar.html.php";
include_once "handler/OrderHandler.php";
?>
    <section class="bg-white py-8 mt-12 antialiased dark:bg-gray-900 md:py-16">
        <div class="mx-auto max-w-screen-xl  w-screen px-4 2xl:px-0">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white sm:text-2xl">Orders</h2>

            <div class="mt-6 sm:mt-8 md:gap-6 lg:flex lg:items-start xl:gap-8">
                <div class="w-screen">
                    <?php
                    if (!empty($ordersRecord)):
                        ?>
                        <div class="space-y-6">
                            <?php
                            foreach ($ordersRecord as $record):
                                ?>
                                <div id="orderId<?= $record['order_id'] ?>"
                                     class="rounded-lg border border-gray-200 bg-white shadow-sm px-6 py-2 dark:border-gray-700 dark:bg-gray-800 ">
                                    <div class="space-y-4 md:flex-row md:items-center md:justify-between md:gap-6 md:space-y-0">
                                        <div class="cto-section flex space-x-10 items-center p-3 border-b border-b-gray-200 text-gray-400 text-sm">
                                            <div class="order-id px-5 py-2 bg-gray-200 rounded-full font-medium text-black text-md">
                                                Order
                                                <a href="" class="text-blue-500">
                                                    #<?= $record['order_id'] ?>
                                                </a>
                                            </div>
                                            <div class="order-date">
                                                Order Placed: <?= date('D M Y', strtotime($record['date'])) ?>
                                            </div>
                                            <div class="order-status">
                                                Delivery Status: <?= strtoupper($record['delivery_status']) ?>
                                            </div>
                                        </div>
                                        <div class="products flex-col space-y-4">
                                            <?php foreach ($record['product_details'] as $productDetail): ?>
                                                <div class="product-section grid grid-cols-4 bg-gray-100 rounded-lg my-4 p-4 items-center space-x-10">
                                                    <a href="product_view?id=<?= $productDetail['product_id'] ?>"
                                                       class="product-image h-24 w-24 content-center rounded-lg bg-white p-3">
                                                        <img src="<?= $productDetail['product_image'] ?>"
                                                             alt="image of the product" class="h-auto">
                                                    </a>
                                                    <div class="product-name flex flex-col space-y-1">
                                                        <a href="product_view?id=<?= $productDetail['product_id'] ?>"
                                                           class="text-md font-bold text-gray-700 hover:text-blue-600"><?= $productDetail['product_name'] ?></a>
                                                        <a href="search_result?action=search&key=<?= $productDetail['product_brand'] ?>"
                                                           class="text-gray-400 text-sm hover:text-blue-600">By: <?= $productDetail['product_brand'] ?></a>
                                                    </div>
                                                    <div class="product-qty p-3">
                                                        <p class="text-gray-400 text-sm">
                                                            QTY: <?= $productDetail['quantity'] ?></p>
                                                    </div>
                                                    <div class="product-price p-3">
                                                        <p class="text-gray-400 text-sm">Price: <span
                                                                    class="font-bold text-gray-500">Rs. <?= $productDetail['price'] ?></span>
                                                        </p>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                        <div class="order-cto-section flex space-x-10 items-center p-3  border-t border-t-gray-200">
                                            <!-- If the order status is 'Cancelled' then notify that, otherwise show the actions-->
                                            <?php if ($record['order_status'] == 'cancelled'): ?>
                                                <div class="order-status px-5 py-2 bg-red-200 rounded-full font-medium text-red-800 text-sm">
                                                    Order Cancelled
                                                </div>
                                            <?php else: ?>
                                                <!-- cancel order -->
                                                <form method="post">
                                                    <input type="hidden" name="action" value="cancelOrder">
                                                    <input type="hidden" name="order_id"
                                                           value="<?= $record['order_id'] ?>">
                                                    <button type="submit"
                                                            class="order-cancel  text-gray-700 font-medium pe-10 hover:text-red-500 border-r-2 border-r-gray-200 ">
                                                        <span class="text-lg">×</span> <span
                                                                class="text-sm">CANCEL ORDER</span></button>
                                                </form>

                                                <button class="download-receipt  text-gray-700 font-medium pe-10 hover:text-blue-500 border-r-2 border-r-gray-200 ">
                                                    <span class="text-xs font-bold">🡣</span> <span
                                                            class="text-sm">RECEIPT</span></button>
                                            <?php endif; ?>
                                            <div class="order-payment text-gray-400 text-sm">Payment
                                                Method: <?= strtoupper($record['payment_method']) ?></div>
                                            <div class="order-payment text-gray-400 text-sm">Payment
                                                Status: <?= $record['payment_status'] ?></div>
                                            <div class="order-amount text-gray-400 text-sm">Amount: <span
                                                        class="font-bold text-gray-500">Rs. <?= $record['amount'] ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php
                    else:?>
                        <p>No Orders found</p>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </section>
<?php
include ROOT . "partials/footer.php";
?>