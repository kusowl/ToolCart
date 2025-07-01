<?php
session_start();
require_once '../config/site_config.php';
require_once ROOT . 'config/db_config.php';
include ROOT . "partials/header.php";
include_once ROOT . "class/Category.php";
require_once 'admin_partials/admin_header.php';
include_once "handler/ProductHandler.php";
$messages = $_SESSION["messages"] ?? '';
$message_type = $_SESSION["message_type"] ?? '';

if ($messages != '') {
    include ROOT . "/partials/popup.php";
    unset($_SESSION["messages"]);
    unset($_SESSION["message_type"]);
}
$categoryObj = new Category();
$categories = $categoryObj->getAllCategory(99);
?>
    <section class="bg-gray-50 dark:bg-gray-900">
        <form class="space-y-4 md:space-y-6" action="" method="post" enctype="multipart/form-data">
            <div class="flex items-center justify-center px-6 py-8 mx-auto">
                <div class="bg-white rounded-lg shadow dark:border xl:p-0 dark:bg-gray-800 dark:border-gray-700">
                    <h1 class="pl-8 pt-6 text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                        <?= !empty($formData) ? 'Update' : 'Add' ?> Product
                    </h1>
                    <div class="grid md:grid-cols-2 items-baseline">
                        <div class="w-lg p-6 space-y-4 md:space-y-6 sm:p-8">

                            <div class="grid grid-cols-2 space-x-4 space-y-6">
                                <div>
                                    <label for="title"
                                           class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Product
                                        title</label>
                                    <input type="text" name="title" id="title" value="<?= $formData['title'] ?>"
                                           class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                           placeholder="e.g. Cool new product" required>
                                </div>
                                <div>
                                    <label for="title"
                                           class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Product
                                        category</label>
                                    <select id="category" name="category_id"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                        <option selected="">Select category</option>
                                        <?php foreach ($categories as $category): ?>
                                            <option value="<?= $category->getId() ?>" <?= $category->getId() == $formData['category_id'] ? 'selected' : '' ?>><?= $category->getTitle() ?></option>
                                        <?php endforeach; ?>
                                    </select>

                                </div>
                                <div>
                                    <label for="title"
                                           class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Product
                                        Price</label>
                                    <input type="number" name="price" id="price" value="<?= $formData['price'] ?>"
                                           class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                           placeholder="e.g. 100,200" required>
                                </div>
                                <div>
                                    <label for="title"
                                           class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Product
                                        Brand</label>
                                    <input type="text" name="brand" id="brand" value="<?= $formData['brand'] ?>"
                                           class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                           placeholder="e.g. ToolCart" required>
                                </div>
                            </div>

                            <div>
                                <label for="desc" class="block mb-3 text-sm font-medium text-gray-900 dark:text-white">Product
                                    Description</label>
                                <textarea name="desc" id="desc"
                                          class="bg-gray-51 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                          placeholder="type something here..."
                                          required><?= $formData['desc'] ?></textarea>
                            </div>
                        </div>

                        <div class="w-md flex flex-col items-start justify-center w-full">
                            <label for="title" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Product
                                image</label>
                            <label for="dropzone-file"
                                   class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-gray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                         xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                              stroke-width="2"
                                              d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                                    </svg>
                                    <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span
                                                class="font-semibold">Click to upload</span> or drag and drop</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">SVG, PNG, JPG or GIF (MAX.
                                        2MB)</p>
                                </div>
                                <input id="dropzone-file" type="file"
                                       accept="image/png, image/jpg, image/jpeg, image/gif, image/webp"
                                       name="product_image" class="hidden"/>
                            </label>
                        </div>
                        <input type="submit" name="action" value ="<?= !empty($formData) ? 'Update' : 'Add' ?>"
                                class=" col-span-2 m-6 text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">

                    </div>
                </div>
            </div>
        </form>
    </section>
<?php require_once 'admin_partials/admin_footer.php' ?>