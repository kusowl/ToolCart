<?php
session_start();
include_once ROOT."config/db_config.php";
include_once ROOT.'class/Product.php';
include_once ROOT."class/Category.php";
$productObj = new Product();

$productRecords = [];
$productItemCount = 0;
if($_SERVER['REQUEST_METHOD'] == "GET"){
    if($_GET['action'] == 'search'){
        $key = $_GET['key'];
        $products = $productObj->search($key);
        $productItemCount = count($products);
        $pageTitle = "Search Result";
    }
    elseif ($_GET['action'] == 'category'){
        $key = $_GET['key'];
        $products = $productObj->getProductByCategory($key);
        $productItemCount = count($products);
        $pageTitle = $_GET['name'];
    }
    elseif (isset($_GET['id'])){
        $productId = $_GET['id'];
        $product = $productObj->findById($productId);
    }
    else{
        $products = $productObj->getAllProduct();
    }
}

