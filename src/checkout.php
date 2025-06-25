<?php
session_start();
include "config/site_config.php";
$pageTitle = "Checkout : " . SITE_NAME;
include_once ROOT . "partials/header.php";
include_once "handler/CheckoutHandler.php";
include_once "partials/navbar.html.php";
include_once "partials/popup.php";
?>
<section class="bg-white py-8 antialiased dark:bg-gray-900 md:py-16 mt-12">
    <div class="mx-auto max-w-screen-xl px-4 2xl:px-0">
        <!--        breadcrumb-->
        <ol class="items-center flex w-full max-w-2xl text-center text-sm font-medium text-gray-500 dark:text-gray-400 sm:text-base">
            <li class="after:border-1 flex items-center text-primary-700 after:mx-6 after:hidden after:h-1 after:w-full after:border-b after:border-gray-200 dark:text-primary-500 dark:after:border-gray-700 sm:after:inline-block sm:after:content-[''] md:w-full xl:after:mx-10">
        <span class="flex items-center after:mx-2 after:text-gray-200 after:content-['/'] dark:after:text-gray-500 sm:after:hidden">
          <svg class="me-2 h-4 w-4 sm:h-5 sm:w-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
               height="24" fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M8.5 11.5 11 14l4-4m6 2a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
          </svg>
          Cart
        </span>
            </li>

            <li class="after:border-1 flex items-center text-primary-700 after:mx-6 after:hidden after:h-1 after:w-full after:border-b after:border-gray-200 dark:text-primary-500 dark:after:border-gray-700 sm:after:inline-block sm:after:content-[''] md:w-full xl:after:mx-10">
        <span class="flex items-center after:mx-2 after:text-gray-200 after:content-['/'] dark:after:text-gray-500 sm:after:hidden">
          <svg class="me-2 h-4 w-4 sm:h-5 sm:w-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
               height="24" fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M8.5 11.5 11 14l4-4m6 2a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
          </svg>
          Checkout
        </span>
            </li>

            <li class="flex shrink-0 items-center">
                <svg class="me-2 h-4 w-4 sm:h-5 sm:w-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                     height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M8.5 11.5 11 14l4-4m6 2a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                </svg>
                Order summary
            </li>
        </ol>

        <div class="mt-6 sm:mt-8 lg:flex lg:items-start lg:gap-12 xl:gap-16">
            <div class="min-w-0 flex-1 space-y-8">
                <div class="space-y-4">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Delivery Details</h2>
                    <!--                     Add new address form modal-->
                    <div id="address-modal"
                         class="hidden  fixed top-0 right-0 left-0 z-100 justify-center items-center md:inset-0 "
                         tabindex="-1" aria-hidden="true">
                        <div class="relative">
                            <div class="relative bg-white rounded-lg p-7 shadow-sm dark:bg-gray-700">
                                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                        Add New Address
                                    </h3>
                                    <button type="button"
                                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                            data-modal-toggle="address-modal">
                                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                             fill="none" viewBox="0 0 14 14">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                  stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                        </svg>
                                        <span class="sr-only">Close modal</span>
                                    </button>
                                </div>
                                <form action="" method="post" id="address-form" class="mt-6">
                                    <input type="hidden" name="action" value="addAddress" id="action">
                                    <input type="hidden" name="id" id="address_id" value="">
                                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                        <div>
                                            <label for="name"
                                                   class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                                                Your name * </label>
                                            <input type="text" id="name" name="name"
                                                   value="<?= $formData['name'] ?? '' ?>"
                                                   class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500"
                                                   placeholder="Kushal Saha" required/>
                                        </div>

                                        <div>
                                            <label for="your_email"
                                                   class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                                                Your
                                                email * </label>
                                            <input type="email" id="email" name="email"
                                                   value="<?= $formData['email'] ?? '' ?>"
                                                   class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500"
                                                   placeholder="kushal@toolcart.in" required/>
                                        </div>

                                        <div>
                                            <label for="country"
                                                   class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                                                Country
                                                * </label>
                                            <input type="text" id="country" name="country"
                                                   value="<?= $formData['country'] ?? '' ?>"
                                                   class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500"
                                                   placeholder="india" required/>
                                        </div>

                                        <div>
                                            <label for="city"
                                                   class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                                                City * </label>
                                            <input type="text" id="city" name="city"
                                                   value="<?= $formData['city'] ?? '' ?>"
                                                   class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500"
                                                   placeholder="Kolkata" required/>
                                        </div>

                                        <div>
                                            <label for="phone-input"
                                                   class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                                                Phone
                                                Number * </label>
                                            <div class="flex items-center">
                                                <input name="country_code" id="country_code"
                                                       value="<?= $formData['country_code'] ?? '' ?>"
                                                       class="z-10 w-20 inline-flex shrink-0 items-center rounded-s-lg border border-gray-300 bg-gray-100 px-4 py-2.5 text-center text-sm font-medium text-gray-900 hover:bg-gray-200 focus:outline-none focus:ring-4 focus:ring-gray-100 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-700"
                                                       type="number" placeholder="91" required>
                                                <div class="relative w-full">
                                                    <input type="text" id="phone_no" name="phone_no"
                                                           value="<?= $formData['phone_no'] ?? '' ?>"
                                                           class="z-20 block w-full rounded-e-lg border border-s-0 border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:border-s-gray-700  dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400 dark:focus:border-primary-500"
                                                           placeholder="12345-67890" required/>
                                                </div>
                                            </div>
                                        </div>

                                        <div>
                                            <label for="pin"
                                                   class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                                                Pin </label>
                                            <input type="number" id="pin" name="pin"
                                                   value="<?= $formData['pin'] ?? '' ?>"
                                                   class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500"
                                                   placeholder="123456" required/>
                                        </div>

                                        <div class="sm:col-span-2">
                                            <label for="address-line-1"
                                                   class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                                                Address
                                                Line 1 *</label>
                                            <input type="text" id="line-1" name="line_1"
                                                   value="<?= $formData['line_1'] ?? '' ?>"
                                                   class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500"
                                                   required/>
                                        </div>

                                        <div class="sm:col-span-2">
                                            <label for="address-line-2"
                                                   class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                                                Address
                                                Line 2 *</label>
                                            <input type="text" id="line-2" name="line_2"
                                                   value="<?= $formData['line_2'] ?? '' ?>"
                                                   class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500"
                                            />
                                        </div>
                                        <div class="sm:col-span-2">
                                            <label for="instructions"
                                                   class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Instructions,
                                                Notes</label>
                                            <input type="text" id="instructions" name="instructions"
                                                   value="<?= $formData['instructions'] ?? '' ?>"
                                                   class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500"
                                            />
                                        </div>
                                        <button type="submit" id="submitBtn"
                                                class="text-white inline-flex justify-center items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 sm:col-span-2">
                                            <svg class="me-1 -ms-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd"
                                                      d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                                      clip-rule="evenodd"></path>
                                            </svg>
                                            Add new address
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!--                    modal ends-->
                    <!--                    Checkout from starts here-->
                    <form action="" class="space-y-8">
                        <div class="grid grid-cols-1 gap-4 md:grid-cols-3" id="address-grid">

                            <!-- Select address form -->
                            <?php foreach ($res as $addRes): ?>
                                <div class="rounded-lg border border-gray-200 bg-gray-50 p-4 ps-4 dark:border-gray-700 dark:bg-gray-800">
                                    <div class="flex items-start">
                                        <div class="flex h-5 items-center">
                                            <input aria-describedby="address-text" type="radio"
                                                   name="address_id" value="<?= $addRes->getId(); ?>"
                                                   class="h-4 w-4 border-gray-300 bg-white text-primary-600 focus:ring-2 focus:ring-primary-600 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-primary-600"
                                            />
                                        </div>

                                        <div class="ms-4 text-sm">
                                            <label for="address"
                                                   class="font-medium leading-none text-gray-900 dark:text-white"> <?= $addRes->getName() . "&nbsp +" . $addRes->getCountryCode() . $addRes->getPhNo(); ?> </label>
                                            <p id="credit-card-text"
                                               class="mt-1 text-xs font-normal text-gray-500 dark:text-gray-400">
                                                <?php
                                                echo "{$addRes->getLine1()}<br>{$addRes->getLine2()}<br>{$addRes->getCity()}&nbsp{$addRes->getPin()}";
                                                ?>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="mt-4 flex items-center gap-2">
                                        <button onclick="deleteAddress()" id="cartDeleteBtn"
                                                class="text-sm font-medium text-gray-500 hover:text-red-600 dark:text-gray-400 dark:hover:text-white">
                                            Delete
                                        </button>

                                        <div class="h-3 w-px shrink-0 bg-gray-200 dark:bg-gray-700"></div>

                                        <button type="button" onclick="load_address_form(<?= $addRes->getId(); ?>)"
                                                data-modal-target="address-modal" data-modal-toggle="address-modal"
                                                class="text-sm font-medium text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">
                                            Edit
                                        </button>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                            <div class="sm:col-span-3">
                                <button data-modal-target="address-modal" data-modal-toggle="address-modal"
                                        id="add-address-btn"
                                        class="flex w-full items-center justify-center gap-2 rounded-lg border border-gray-200 bg-white px-5 py-2.5 text-sm font-medium text-gray-900 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:outline-none focus:ring-4 focus:ring-gray-100 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white dark:focus:ring-gray-700">
                                    <svg class="h-5 w-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                         width="24"
                                         height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                              stroke-width="2" d="M5 12h14m-7 7V5"/>
                                    </svg>
                                    Add Address
                                </button>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Payment</h3>

                            <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                                <div class="rounded-lg border border-gray-200 bg-gray-50 p-4 ps-4 dark:border-gray-700 dark:bg-gray-800">
                                    <div class="flex items-start">
                                        <div class="flex h-5 items-center">
                                            <input id="pay-on-delivery" aria-describedby="pay-on-delivery-text"
                                                   type="radio"
                                                   name="payment-method" value=""
                                                   class="h-4 w-4 border-gray-300 bg-white text-primary-600 focus:ring-2 focus:ring-primary-600 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-primary-600"/>
                                        </div>

                                        <div class="ms-4 text-sm">
                                            <label for="pay-on-delivery"
                                                   class="font-medium leading-none text-gray-900 dark:text-white">
                                                Payment
                                                on
                                                delivery </label>
                                            <p id="pay-on-delivery-text"
                                               class="mt-1 text-xs font-normal text-gray-500 dark:text-gray-400">+ 10
                                                payment
                                                processing fee</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="rounded-lg border border-gray-200 bg-gray-50 p-4 ps-4 dark:border-gray-700 dark:bg-gray-800">
                                    <div class="flex items-start">
                                        <div class="flex h-5 items-center">
                                            <input id="paypal-2" aria-describedby="paypal-text" type="radio"
                                                   name="payment-method" value=""
                                                   class="h-4 w-4 border-gray-300 bg-white text-primary-600 focus:ring-2 focus:ring-primary-600 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-primary-600"/>
                                        </div>

                                        <div class="ms-4 text-sm">
                                            <label for="paypal-2"
                                                   class="font-medium leading-none text-gray-900 dark:text-white">
                                                Pay via RazorPay</label>
                                            <p id="paypal-text"
                                               class="mt-1 text-xs font-normal text-gray-500 dark:text-gray-400">Pay in next step</p>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!--                        <div class="space-y-4">-->
                        <!--                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Delivery Methods</h3>-->
                        <!---->
                        <!--                            <div class="grid grid-cols-1 gap-4 md:grid-cols-3">-->
                        <!--                                <div class="rounded-lg border border-gray-200 bg-gray-50 p-4 ps-4 dark:border-gray-700 dark:bg-gray-800">-->
                        <!--                                    <div class="flex items-start">-->
                        <!--                                        <div class="flex h-5 items-center">-->
                        <!--                                            <input id="dhl" aria-describedby="dhl-text" type="radio"-->
                        <!--                                                   name="delivery-method"-->
                        <!--                                                   value=""-->
                        <!--                                                   class="h-4 w-4 border-gray-300 bg-white text-primary-600 focus:ring-2 focus:ring-primary-600 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-primary-600"-->
                        <!--                                                   checked/>-->
                        <!--                                        </div>-->
                        <!---->
                        <!--                                        <div class="ms-4 text-sm">-->
                        <!--                                            <label for="dhl"-->
                        <!--                                                   class="font-medium leading-none text-gray-900 dark:text-white">-->
                        <!--                                                $15-->
                        <!--                                                - DHL Fast Delivery </label>-->
                        <!--                                            <p id="dhl-text"-->
                        <!--                                               class="mt-1 text-xs font-normal text-gray-500 dark:text-gray-400">-->
                        <!--                                                Get it by Tommorow</p>-->
                        <!--                                        </div>-->
                        <!--                                    </div>-->
                        <!--                                </div>-->
                        <!---->
                        <!--                                <div class="rounded-lg border border-gray-200 bg-gray-50 p-4 ps-4 dark:border-gray-700 dark:bg-gray-800">-->
                        <!--                                    <div class="flex items-start">-->
                        <!--                                        <div class="flex h-5 items-center">-->
                        <!--                                            <input id="fedex" aria-describedby="fedex-text" type="radio"-->
                        <!--                                                   name="delivery-method"-->
                        <!--                                                   value=""-->
                        <!--                                                   class="h-4 w-4 border-gray-300 bg-white text-primary-600 focus:ring-2 focus:ring-primary-600 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-primary-600"/>-->
                        <!--                                        </div>-->
                        <!---->
                        <!--                                        <div class="ms-4 text-sm">-->
                        <!--                                            <label for="fedex"-->
                        <!--                                                   class="font-medium leading-none text-gray-900 dark:text-white">-->
                        <!--                                                Free Delivery - FedEx </label>-->
                        <!--                                            <p id="fedex-text"-->
                        <!--                                               class="mt-1 text-xs font-normal text-gray-500 dark:text-gray-400">Get it-->
                        <!--                                                by-->
                        <!--                                                Friday, 13 Dec 2023</p>-->
                        <!--                                        </div>-->
                        <!--                                    </div>-->
                        <!--                                </div>-->
                        <!---->
                        <!--                                <div class="rounded-lg border border-gray-200 bg-gray-50 p-4 ps-4 dark:border-gray-700 dark:bg-gray-800">-->
                        <!--                                    <div class="flex items-start">-->
                        <!--                                        <div class="flex h-5 items-center">-->
                        <!--                                            <input id="express" aria-describedby="express-text" type="radio"-->
                        <!--                                                   name="delivery-method" value=""-->
                        <!--                                                   class="h-4 w-4 border-gray-300 bg-white text-primary-600 focus:ring-2 focus:ring-primary-600 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-primary-600"/>-->
                        <!--                                        </div>-->
                        <!---->
                        <!--                                        <div class="ms-4 text-sm">-->
                        <!--                                            <label for="express"-->
                        <!--                                                   class="font-medium leading-none text-gray-900 dark:text-white">-->
                        <!--                                                $49 - Express Delivery </label>-->
                        <!--                                            <p id="express-text"-->
                        <!--                                               class="mt-1 text-xs font-normal text-gray-500 dark:text-gray-400">Get it-->
                        <!--                                                today</p>-->
                        <!--                                        </div>-->
                        <!--                                    </div>-->
                        <!--                                </div>-->
                        <!--                            </div>-->
                        <!--                        </div>-->

                        <!--                        <div>-->
                        <!--                            <label for="voucher" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">-->
                        <!--                                Enter-->
                        <!--                                a-->
                        <!--                                gift card, voucher or promotional code </label>-->
                        <!--                            <div class="flex max-w-md items-center gap-4">-->
                        <!--                                <input type="text" id="voucher"-->
                        <!--                                       class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500"-->
                        <!--                                       placeholder="" required/>-->
                        <!--                                <button type="button"-->
                        <!--                                        class="flex items-center justify-center rounded-lg bg-primary-700 px-5 py-2.5 text-sm font-medium text-white hover:bg-primary-800 focus:outline-none focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">-->
                        <!--                                    Apply-->
                        <!--                                </button>-->
                        <!--                            </div>-->
                        <!--                        </div>-->
                        <div class="sm:col-span-2">
                            <a href="order"
                               class="flex w-full items-center justify-center gap-2 rounded-lg border border-gray-200 bg-primary-600 px-5 py-2.5 text-sm font-medium text-white hover:bg-primary-800 focus:z-10 focus:outline-none focus:ring-4 focus:ring-gray-100 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white dark:focus:ring-gray-700">
                                <svg class="h-5 w-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                     width="24"
                                     height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                          stroke-width="2" d="M5 12h14m-7 7V5"/>
                                </svg>
                                Place Order
                            </a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
include_once ROOT . "partials/footer.php";
?>
