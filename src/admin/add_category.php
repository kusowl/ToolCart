<?php
ob_start();
session_start();
require_once '../config/site_config.php';
include ROOT . "partials/header.php";
require_once 'admin_partials/admin_header.php';
include_once "handler/CategoryHandler.php";
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
                        <?= empty($formData) ? 'Add' : 'Edit' ?> Category
                    </h1>
                    <form class="space-y-4 md:space-y-6"  method="post">
                        <div>
                            <label for="title" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Category
                                title</label>
                            <input type="text" name="title" id="title"  value="<?= htmlspecialchars($formData['title']) ?>"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                   placeholder="e.g. Ranch, Power Tools" required>
                        </div>
                        <div>
                            <label for="desc" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" >Category
                                Description</label>
                            <textarea name="desc" id="desc"
                                      class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                      placeholder="type something here..." required> <?= htmlspecialchars($formData['desc'] ?? '') ?></textarea>
                        </div>
                        <input type="hidden" name="action" value="<?= empty($formData) ? 'Add' : 'Update' ?>">
                        <input type="hidden" name="id" value="<?= $formData['id'] ?>">
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