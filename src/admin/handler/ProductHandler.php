<?php
session_start();
require_once __DIR__ . "/../../config/site_config.php";
require_once ROOT . "config/db_config.php";
require_once ROOT . "class/Helper.php";
require_once ROOT . "class/Product.php";
$messages = [];
$message_type = "";
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $action = $_POST['action'];
    switch ($action) {
        case 'Add':
        {
            $image = $_FILES['product_image'];
            $fileTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
            // Validate file
            $validationResult = Helper::validateFile($image, $fileTypes, MAX_FILE_SIZE);
            $rel_path = 'assets/images/';
            $path = ROOT . $rel_path;
            switch ($validationResult) {
                case 0:
                    $img_name = Helper::uploadFile($image, $path);
                    break;
                case 1:
                    $messages['Image Error'] = "Upload error";
                    break;
                case 2:
                    $messages['Image Error'] = "File type not allowed";
                    break;
                case 3:
                    $messages['Image Error'] = "File is is not allowed";
                    break;
                default:
                    $messages['Image Error'] = "Validation Failed";
            }
            if (!empty($messages)) {
                $message_type = 'error';
            } else {
                $product = new Product();
                $imgPath = $rel_path . $img_name;
                $result = $product->addProduct($_POST['title'], $_POST['desc'], $_POST['price'], $_POST['brand'], $imgPath, $_POST['category_id']);
                if ($result) {
                    $messages['New Record'] = "product added successfully.";
                    $message_type = "success";
                } else {
                    $messages['Error'] = "failed  adding product";
                    $message_type = "error";
                }
            }
            $_SESSION["messages"] = $messages;
            $_SESSION["message_type"] = $message_type;
            header("Location: /ToolCart/admin/product_list");
            exit;
        }
        case "Update":{
            $image = $_FILES['product_image'];
            $fileTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
            // Validate file
            $validationResult = $image['name'] != '' ? Helper::validateFile($image, $fileTypes, MAX_FILE_SIZE) : 99;
            $rel_path = 'assets/images/';
            $path = ROOT . $rel_path;
            switch ($validationResult) {
                case 99: break;
                case 0:
                    $img_name = Helper::uploadFile($image, $path);
                    break;
                case 1:
                    $messages['Image Error'] = "Upload error";
                    break;
                case 2:
                    $messages['Image Error'] = "File type not allowed";
                    break;
                case 3:
                    $messages['Image Error'] = "File is is not allowed";
                    break;
                default:
                    $messages['Image Error'] = "Validation Failed";
            }
            if (!empty($messages)) {
                $message_type = 'error';
            } else {
                $data=[
                    'id' => $_GET['id'],
                    'category_id' => $_POST['category_id'],
                    'product_title' => $_POST['title'],
                    'product_desc' => $_POST['desc'],
                    'product_price' => $_POST['price'],
                    'product_brand' => $_POST['brand'],
                    'product_image' => isset($img_name) ? $rel_path.$img_name : ''
                ];
                $product = new Product();
                if($product->update($data)){
                    $messages['Update Record'] = "product updated successfully.";
                    $message_type = "success";
                }else{
                    $messages['Error'] = "failed  updating product";
                    $message_type = "error";
                }
            }
            $_SESSION["messages"] = $messages;
            $_SESSION["message_type"] = $message_type;
            header("Location: /ToolCart/admin/product_list");
            exit;
            break;
        }
        case "Delete":{
            $id = $_POST['id'];
            $product = new Product(['id' => $id]);
            $result  = $product->delete();
            if ($result) {
                $messages['Success'] = "Product Deleted.";
                $message_type = "error";
            } else {
                $messages['Error'] = "Failed deleting product";
                $message_type = "error";
            }
            $_SESSION["messages"] = $messages;
            $_SESSION["message_type"] = $message_type;
            header("Location: /ToolCart/admin/product_list");
            exit;
        }
    }
}
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $id = $_GET['id'] ?? '';
    if ($id != '') {
        $productData = Product ::findById($id);
        $formData['id'] = $id;
        $formData['title'] = $productData->getTitle();
        $formData['desc'] = $productData->getDescription();
        $formData['price'] = $productData->getPrice();
        $formData['brand'] = $productData->getBrand();
        $formData['category_id'] = $productData->getCategoryId();
        $formData['product_image'] = $productData->getImage();
    }

}
