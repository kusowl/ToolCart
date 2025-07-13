<?php
$messages = $_SESSION["messages"];
$message_type = $_SESSION["message_type"];
if(!empty($messages)):
?>
<div id="info-popup" tabindex="-1" class="fixed top-25 right-5 z-999 w-auto max-w-lg">
    <div class="relative p-4 w-full">
        <div class="relative p-4
        <?php
        if ($message_type == 'error')
            echo 'bg-red-100';
        else
            echo 'bg-green-100' ?> rounded-lg shadow dark:bg-gray-800 md:p-4">
            <div class="text-sm font-light text-gray-500 dark:text-gray-400">
                <?php foreach ($messages as $key => $value) : ?>
                    <p class="text-gray-700 dark:text-white my-2">
                        <?php
                        $key = str_replace('_', ' ', $key);
                        $key = ucwords($key);
                        echo "<strong>$key </strong> : ";
                        echo ucfirst($value);
                        ?>
                    </p>
                <?php endforeach; ?>
                <div class="justify-between items-center pt-0 space-y-4 sm:flex sm:space-y-0">
                    <div class="items-center space-y-4 sm:space-x-4 sm:flex sm:space-y-0">
                        <button id="close-modal" type="button" class="py-2.5 px-5 me-2 mb-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-full border border-gray-200 hover:bg-gray-100 hover: bg-gray-200 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700 opacity-80r" onclick="closeButton">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
endif;
unset($_SESSION["messages"]);
unset($_SESSION["message_type"]);
?>