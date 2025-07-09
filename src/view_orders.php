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
                                     class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-800 md:p-6">
                                    <div class="space-y-4 md:flex-row md:items-center md:justify-between md:gap-6 md:space-y-0">
                                        <div class="cto-section flex justify-between p-3 border-b border-b-gray-200">
                                            <div class="order-id">
                                                Order
                                                <a href="">
                                                    #<?= $record['order_id'] ?>
                                                </a>
                                            </div>
                                            <div class="order-date">
                                                Order Placed <?= date('D M Y', strtotime($record['date'])) ?>
                                            </div>
                                            <div class="order-status">
                                                Delivery Status <?= $record['delivery_status'] ?>
                                            </div>
                                        </div>
                                        <div class="products flex-col">
                                            <?php foreach ($record['product_details'] as $productDetail): ?>
                                                <div class="product-section flex justify-between">
                                                    <div class="product-image w-24 h-24">
                                                        <img src="<?= $productDetail['product_image'] ?>"
                                                             alt="image of the product">
                                                    </div>
                                                    <div class="product-name ">
                                                        <p><?= $productDetail['product_name'] ?></p>
                                                        <p><?= $productDetail['product_brand'] ?></p>
                                                    </div>
                                                    <div class="product-qty p-3 ">
                                                        <p> QTY :<?= $productDetail['quantity'] ?></p>
                                                        <p>Price :<?= $productDetail['price'] ?></p>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                        <div class="order-cto-section flex justify-between p-3  border-t border-t-gray-200">
                                            <div class="order-cancel">Cancel</div>
                                            <div class="order-payment">Payment
                                                Method <?= strtoupper($record['payment_method']) ?></div>
                                            <div class="order-payment">Payment
                                                Status <?= $record['payment_status'] ?></div>
                                            <div class="order-amount">Amount <?= $record['amount'] ?></div>
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