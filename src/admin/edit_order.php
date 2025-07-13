<?php
ob_start();
session_start();
require_once '../config/site_config.php';
require_once ROOT . 'config/db_config.php';
include_once "admin_partials/check_permission.php";
include ROOT . "partials/header.php";
require_once 'admin_partials/admin_header.php';
include_once "handler/OrderHandler.php";
$messages = $_SESSION["messages"] ?? '';
$message_type = $_SESSION["message_type"] ?? '';

if ($messages != '') {
    include ROOT . "/partials/popup.php";
    unset($_SESSION["messages"]);
    unset($_SESSION["message_type"]);
}
?>
<section class="bg-gray-50 dark:bg-gray-900">
    <div class="flex flex-col items-center justify-center px-6 py-8">
        <div class="w-lg bg-white rounded-lg shadow dark:border xl:p-0 dark:bg-gray-800 dark:border-gray-700">
            <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                    Edit Order
                </h1>
                <form class="space-y-4 md:space-y-6" action="" method="post">
                    <div>
                        <label for="title" class="block mb-2 text-md font-medium text-gray-900 dark:text-white">
                            Delivery Status</label>
                        <div class="flex gap-2">
                            <div class="flex items-center me-4">
                                <input <?= $formData['delivery_status'] == 'pending' ? 'checked' : ''  ?> id="inline-radio" type="radio" value="pending" name="delivery_status"
                                       class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="inline-radio"
                                       class="ms-2 text-sm font-medium text-gray-600 dark:text-gray-300">Pending</label>
                            </div>
                            <div class="flex items-center me-4">
                                <input <?= $formData['delivery_status'] == 'in-transit' ? 'checked' : ''  ?> id="inline-2-radio" type="radio" value="in-transit" name="delivery_status"
                                       class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="inline-2-radio"
                                       class="ms-2 text-sm font-medium text-gray-700 dark:text-gray-300">In-transit</label>
                            </div>
                            <div class="flex items-center me-4">
                                <input <?= $formData['delivery_status'] == 'shipped' ? 'checked' : '' ?> id="inline-2-radio" type="radio" value="shipped" name="delivery_status"
                                       class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="inline-2-radio"
                                       class="ms-2 text-sm font-medium text-gray-700 dark:text-gray-300">Shipped</label>
                            </div>
                            <div class="flex items-center me-4">
                                <input  <?= $formData['delivery_status'] == 'delivered' ? 'checked' : '' ?> id="inline-checked-radio" type="radio" value="delivered"
                                       name="delivery_status"
                                       class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="inline-checked-radio"
                                       class="ms-2 text-sm font-medium text-gray-700 dark:text-gray-300">Delivered</label>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label for="type"
                               class="block mb-2 text-md font-medium text-gray-900 dark:text-white">Payment
                            Status</label>
                        <div class="flex gap-2">
                            <div class="flex items-center me-4">
                                <input <?= $formData['payment_status'] == 'success' ? 'checked' : '' ?>  id="inline-checked-radio" type="radio" value="success" name="payment_status"
                                       class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="inline-checked-radio"
                                       class="ms-2 text-sm font-medium text-gray-600 dark:text-gray-300">Success</label>
                            </div>
                            <div class="flex items-center me-4">
                                <input  <?= $formData['payment_status'] == 'refund_pending' ? 'checked' : '' ?> id="inline-radio" type="radio" value="refund_pending" name="payment_status"
                                       class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="inline-radio"
                                       class="ms-2 text-sm font-medium text-gray-600 dark:text-gray-300">Refund Pending</label>
                            </div>
                            <div class="flex items-center me-4">
                                <input <?= $formData['payment_status'] == 'refund' ? 'checked' : '' ?> id="inline-2-radio" type="radio" value="refund" name="payment_status"
                                       class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="inline-2-radio"
                                       class="ms-2 text-sm font-medium text-gray-600 dark:text-gray-300">Refund</label>
                            </div>

                            <div class="flex items-center me-4">
                                <input <?= $formData['payment_status'] == 'failed' ? 'checked' : '' ?> id="inline-checked-radio" type="radio" value="failed" name="payment_status"
                                       class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="inline-checked-radio"
                                       class="ms-2 text-sm font-medium text-gray-600 dark:text-gray-300">Failed</label>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label for="title" class="block mb-2 text-md font-medium text-gray-900 dark:text-white">Order
                            Status</label>

                        <div class="flex gap-2">
                            <div class="flex items-center me-4">
                                <input <?= $formData['order_status'] == 'success' ? 'checked' : '' ?> id="inline-radio" type="radio" value="success" name="order_status"
                                       class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="inline-radio"
                                       class="ms-2 text-sm font-medium text-gray-600 dark:text-gray-300">Success</label>
                            </div>
                            <div class="flex items-center me-4">
                                <input <?= $formData['order_status'] == 'onhold' ? 'checked' : '' ?> id="inline-2-radio" type="radio" value="onhold" name="order_status"
                                       class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="inline-2-radio"
                                       class="ms-2 text-sm font-medium text-gray-600 dark:text-gray-300">Hold</label>
                            </div>
                            <div class="flex items-center me-4">
                                <input <?= $formData['order_status'] == 'cancelled' ? 'checked' : '' ?> id="inline-checked-radio" type="radio" value="cancelled" name="order_status"
                                       class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="inline-checked-radio"
                                       class="ms-2 text-sm font-medium text-gray-600 dark:text-gray-300">Cancel</label>
                            </div>
                        </div>
                        <input type="hidden" name="action" value="Update">
                        <input type="hidden" name="order_id" value="<?= $formData['order_id'] ?? '' ?>">
                        <button type="submit"
                                class="w-full mt-6 text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                            Update
                        </button>

                </form>
            </div>
        </div>
    </div>
</section>
<?php require_once 'admin_partials/admin_footer.php' ?>
