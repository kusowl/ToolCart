<?php
session_start();
include "config/site_config.php";
$pageTitle = "Checkout : " . SITE_NAME;
include_once ROOT . "partials/header.php";
include_once "partials/navbar.html.php";
include_once "handler/CartHandler.php";


?>
    <section class="bg-white py-8 mt-12 antialiased dark:bg-gray-900 md:py-16">
        <div class="mx-auto max-w-screen-xl px-4 2xl:px-0">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white sm:text-2xl">Shopping Cart</h2>

            <div class="mt-6 sm:mt-8 md:gap-6 lg:flex lg:items-start xl:gap-8">
                <div class="mx-auto w-full flex-none lg:max-w-2xl xl:max-w-4xl">
                    <?php
                    $totalPrice ??= 0;
                    $originalPrice ??= 0;
                    $savings ??= 0;
                    $pickup ??= 0;
                    $tax ??= 0;
                    if (!empty($cartRecords)):
                        ?>
                        <div class="space-y-6">
                            <?php
                            foreach ($cartRecords as $record):
                                ?>
                                <div id="productId<?= $record['product_id'] ?>"
                                     class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-800 md:p-6">
                                    <div class="space-y-4 md:flex md:items-center md:justify-between md:gap-6 md:space-y-0">
                                        <a href="#" class="shrink-0 md:order-1">
                                            <img class="h-20 w-20 dark:hidden"
                                                 src="<?= BASE_URL . $record['product_image'] ?>"
                                                 alt="imac image"/>
                                            <!--                                            <img class="hidden h-20 w-20 dark:block"-->
                                            <!--                                                 src="https://flowbite.s3.amazonaws.com/blocks/e-commerce/imac-front-dark.svg"-->
                                            <!--                                                 alt="imac image"/>-->
                                        </a>

                                        <label for="counter-input" class="sr-only">Choose quantity:</label>
                                        <div class="flex items-center justify-between md:order-3 md:justify-end">
                                            <div class="flex items-center">
                                                <button type="button" data-product-id="<?= $record['product_id'] ?>"
                                                        class="decrementCartPageBtn inline-flex h-5 w-5 shrink-0 items-center justify-center rounded-md border border-gray-300 bg-gray-100 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-100 dark:border-gray-600 dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-gray-700">
                                                    <svg class="h-2.5 w-2.5 text-gray-900 dark:text-white"
                                                         aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                         fill="none" viewBox="0 0 18 2">
                                                        <path stroke="currentColor" stroke-linecap="round"
                                                              stroke-linejoin="round" stroke-width="2" d="M1 1h16"/>
                                                    </svg>
                                                </button>
                                                <input type="text" data-item-qty="<?= $record['qty'] ?>"
                                                       class="cartQty w-10 shrink-0 border-0 bg-transparent text-center text-sm font-medium text-gray-900 focus:outline-none focus:ring-0 dark:text-white"
                                                       placeholder="" value="<?= $record['qty'] ?>" required/>
                                                <button
                                                        data-product-id="<?= $record['product_id'] ?>"
                                                        class="incrementCartPageBtn inline-flex h-5 w-5 shrink-0 items-center justify-center rounded-md border border-gray-300 bg-gray-100 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-100 dark:border-gray-600 dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-gray-700">
                                                    <svg class="h-2.5 w-2.5 text-gray-900 dark:text-white"
                                                         aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                         fill="none" viewBox="0 0 18 18">
                                                        <path stroke="currentColor" stroke-linecap="round"
                                                              stroke-linejoin="round" stroke-width="2"
                                                              d="M9 1v16M1 9h16"/>
                                                    </svg>
                                                </button>
                                            </div>
                                            <div class="text-end md:order-4 md:w-32">
                                                <p class="text-base font-bold text-gray-900 dark:text-white">
                                                    ₹<?= $record['product_price'] ?></p>
                                            </div>
                                        </div>

                                        <div class="w-full min-w-0 flex-1 space-y-4 md:order-2 md:max-w-md">
                                            <a href="#"
                                               class="text-base font-medium text-gray-900 hover:underline dark:text-white"><?= $record['product_title'] ?></a>

                                            <div class="flex items-center gap-4">
                                                <button type="button"
                                                        class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-gray-900 hover:underline dark:text-gray-400 dark:hover:text-white">
                                                    <svg class="me-1.5 h-5 w-5" aria-hidden="true"
                                                         xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                         fill="none" viewBox="0 0 24 24">
                                                        <path stroke="currentColor" stroke-linecap="round"
                                                              stroke-linejoin="round" stroke-width="2"
                                                              d="M12.01 6.001C6.5 1 1 8 5.782 13.001L12.011 20l6.23-7C23 8 17.5 1 12.01 6.002Z"/>
                                                    </svg>
                                                    Add to Favorites
                                                </button>

                                                <button type="button"
                                                        class="removeCartItemPageBtn inline-flex items-center text-sm font-medium text-red-600 hover:underline dark:text-red-500"
                                                        data-product-id="<?= $record['product_id'] ?>">
                                                    <svg class="me-1.5 h-5 w-5" aria-hidden="true"
                                                         xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                         fill="none" viewBox="0 0 24 24">
                                                        <path stroke="currentColor" stroke-linecap="round"
                                                              stroke-linejoin="round" stroke-width="2"
                                                              d="M6 18 17.94 6M18 18 6.06 6"/>
                                                    </svg>
                                                    Remove
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <?php
                        // Calculate totaL PRICE
                        $totalPrice = $originalPrice - $savings + $pickup + $tax;
                    endif; ?>

                </div>

                <div class="mx-auto mt-6 max-w-4xl flex-1 space-y-6 lg:mt-0 lg:w-full">
                    <div class="space-y-4 rounded-lg border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-800 sm:p-6">
                        <p class="text-xl font-semibold text-gray-900 dark:text-white">Order summary</p>

                        <div class="space-y-4">
                            <div class="space-y-2">
                                <dl class="flex items-center justify-between gap-4">
                                    <dt class="text-base font-normal text-gray-500 dark:text-gray-400">Original price
                                    </dt>
                                    <dd class="text-base font-medium text-gray-900 dark:text-white">₹
                                        <?= $originalPrice ?></dd>
                                </dl>
                                <?php if ($savings > 0): ?>
                                    <dl class="flex items-center justify-between gap-4">
                                        <dt class="text-base font-normal text-green-600 dark:text-gray-400">Savings</dt>
                                        <dd class="text-base font-medium text-green-600">-₹ <?= $savings ?></dd>
                                    </dl>
                                <?php endif; ?>

                                <dl class="flex items-center justify-between gap-4">
                                    <dt class="text-base font-normal text-gray-500 dark:text-gray-400">Store Pickup</dt>
                                    <dd class="text-base font-medium text-gray-900 dark:text-white">
                                        ₹ <?= $pickup ?></dd>
                                </dl>

                                <dl class="flex items-center justify-between gap-4">
                                    <dt class="text-base font-normal text-gray-500 dark:text-gray-400">Tax</dt>
                                    <dd class="text-base font-medium text-gray-900 dark:text-white">₹ <?= $tax ?></dd>
                                </dl>
                            </div>

                            <dl class="flex items-center justify-between gap-4 border-t border-gray-200 pt-2 dark:border-gray-700">
                                <dt class="text-base font-bold text-gray-900 dark:text-white">Total</dt>
                                <dd class="text-base font-bold text-gray-900 dark:text-white">₹ <?= $totalPrice ?></dd>
                            </dl>
                        </div>
                        <?php if ($savings > 0): ?>
                            <div class="flex items-center justify-between gap-4 p-4 rounded-lg bg-green-100 border border-dashed border-green-300">
                                <dt class="text-base font-normal text-green-600 dark:text-gray-400">Coupon Applied</dt>
                                <div class="flex items-center gap-1">
                                    <dd class="text-base font-medium text-green-600"><?= $_SESSION['coupon_code'] ?></dd>
                                    <form action="" method="post">
                                        <input type="hidden" name="action" value="removeCoupon">
                                        <button type="submit"
                                                class="text-green-600 bg-transparent hover:text-red-500 rounded-lg text-xs w-6 h-6 ms-auto flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                                data-modal-hide="revenue-modal">
                                            <svg class="w-2 h-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                 fill="none" viewBox="0 0 14 14">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                      stroke-linejoin="round"
                                                      stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        <?php endif; ?>
                        <a href="checkout"
                           class="flex w-full items-center justify-center rounded-lg bg-primary-700 px-5 py-2.5 text-sm font-medium text-white hover:bg-primary-800 focus:outline-none focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Checkout</a>

                        <div class="flex items-center justify-center gap-2">
                            <span class="text-sm font-normal text-gray-500 dark:text-gray-400"> or </span>
                            <a href="home#categories" title=""
                               class="inline-flex items-center gap-2 text-sm font-medium text-primary-700 underline hover:no-underline dark:text-primary-500">
                                Continue Shopping
                                <svg class="h-5 w-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                     viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                          stroke-width="2" d="M19 12H5m14 0-4 4m4-4-4-4"/>
                                </svg>
                            </a>
                        </div>
                    </div>

                    <div class="space-y-4 rounded-lg border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-800 sm:p-6">
                        <form class="space-y-4" method="post">
                            <div>
                                <label for="coupon"
                                       class="mb-2 block text-sm font-medium text-gray-900 dark:text-white"> Do you have
                                    a coupon ? </label>
                                <input type="text" id="coupon" name="code"
                                       class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500"
                                       placeholder="" required/>
                            </div>
                            <input type="hidden" name="action" value="coupon">
                            <button type="submit"
                                    class="flex w-full items-center justify-center rounded-lg bg-primary-700 px-5 py-2.5 text-sm font-medium text-white hover:bg-primary-800 focus:outline-none focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                                Apply Code
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php
include ROOT . "partials/footer.php";
?>