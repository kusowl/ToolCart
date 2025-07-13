<?php
ob_start();
session_start();
require_once '../config/site_config.php';
include_once "admin_partials/check_permission.php";
include ROOT . "partials/header.php";
require_once 'admin_partials/admin_header.php';
include_once "handler/CouponHandler.php";
$messages = $_SESSION["messages"] ?? '';
$message_type = $_SESSION["message_type"] ?? '';

if ($messages != '') {
    include "../partials/popup.php";
    unset($_SESSION["messages"]);
    unset($_SESSION["message_type"]);
}
?>
    <section class="bg-gray-50 dark:bg-gray-900">
        <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto">
            <div class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
                <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                    <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                        <?= empty($formData) ? 'Add' : 'Edit' ?> Coupon
                    </h1>
                    <form class="space-y-4 md:space-y-6" action="" method="post">
                        <div>
                            <label for="title" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Coupon
                                Code</label>
                            <input type="text" name="code" id="code" value="<?= $formData['code'] ?? '' ?>"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                   placeholder="e.g. SAVE50, BIG10" required>
                        </div>

                        <div class="">
                            <label for="type"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Type</label>
                            <ul class="items-center w-full text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg sm:flex dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                <li class="w-full  border-gray-200 border-r dark:border-gray-600">
                                    <div class="flex items-center ps-3">
                                        <input id="horizontal-list-radio-license" type="radio"
                                               value="amount" <?= $formData['type'] == 'amount' ? 'checked' : '' ?>
                                               name="type"
                                               class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                        <label for="horizontal-list-radio-license"
                                               class="w-full py-3 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Amount</label>
                                    </div>
                                </li>

                                <li class="w-full dark:border-gray-600">
                                    <div class="flex items-center ps-3">
                                        <input id="horizontal-list-radio-passport" type="radio"
                                               value="percentage" <?= $formData['type'] == 'percentage' ? 'checked' : '' ?>
                                               name="type"
                                               class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                        <label for="horizontal-list-radio-passport"
                                               class="w-full py-3 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Percentage</label>
                                    </div>
                                </li>
                            </ul>
                        </div>

                        <div>
                            <label for="title" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Coupon
                                Value</label>
                            <input type="text" name="value" id="value" value="<?= $formData['value'] ?? '' ?>"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                   placeholder="e.g. 10, 200" required>
                        </div>
                        <div>
                            <label for="title" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Expiry Date</label>
                            <input type="datetime-local" name="expiry_date" id="expiry_date" value="<?= $formData['expiry_date'] ?? '' ?>"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                   placeholder="e.g. 10, 200" required>
                        </div>
                        <div>
                            <label for="desc" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Coupon
                                Description</label>
                            <textarea name="desc" id="desc"
                                      class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                      placeholder="type something here..."><?= $formData['desc'] ?? '' ?></textarea>
                        </div>
                        <input type="hidden" name="action" value="<?= empty($formData) ? 'Add' : 'Update' ?>">
                        <button type="submit"
                                class="w-full text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                            <?= empty($formData) ? 'Add' : 'Update' ?>
                        </button>

                    </form>
                </div>
            </div>
        </div>
    </section>
<?php require_once 'admin_partials/admin_footer.php' ?>