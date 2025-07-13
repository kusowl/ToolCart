<?php
ob_start();
session_start();
include_once __DIR__ . "/../../config/site_config.php";
include_once ROOT . "config/db_config.php";
include_once ROOT . "class/Category.php";
$messages = [];
$message_type = "";
$formData = [];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST["action"];
    switch ($action) {
        case "Add":
        {
            $categoryTitle = $_POST["title"];
            $categoryDesc = $_POST["desc"];
            $category = new Category();
            $result = $category->addCategory($categoryTitle, $categoryDesc);
            if ($result) {
                $messages['New Record'] = "category added sucessfully.";
                $message_type = "Success";
            } else {
                $messages['Error'] = "failed  sql query ";
                $message_type = "Error";
            }
            $_SESSION["messages"] = $messages;
            $_SESSION["message_type"] = $message_type;
            break;
        }
        case "Update":
        {
            $data['id'] = $_POST["id"];
            $data['category_title'] = $_POST["title"];
            $data['category_desc'] = $_POST["desc"];
            $category = new Category($data);
            $result = $category->update();
            if ($result) {
                $messages['Success'] = "category updated sucessfully.";
                $message_type = "Success";
            } else {
                $messages['Error'] = "failed  sql query ";
                $message_type = "Error";
            }
            $_SESSION["messages"] = $messages;
            $_SESSION["message_type"] = $message_type;
            header("Location: /ToolCart/admin/category_list");
            break;
        }
        case "Delete":
        {
            $data['id'] = $_POST["id"];
            $category = new Category($data);
            $result = $category->delete();
            if ($result) {
                $messages['Success'] = "category Deleted.";
                $message_type = "Error";
            } else {
                $messages['Error'] = "failed  sql query ";
                $message_type = "Error";
            }
            $_SESSION["messages"] = $messages;
            $_SESSION["message_type"] = $message_type;
            header("Location: /ToolCart/admin/category_list");
        }
    }

}
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $id = $_GET['id'] ?? '';
    if ($id != '') {
        $category = new Category();
        $categoryData = $category->getCategoryById($id);
        $formData['id'] = $id;
        $formData['title'] = $categoryData[0]->getTitle();
        $formData['desc'] = $categoryData[0]->getDescription();
    }

}