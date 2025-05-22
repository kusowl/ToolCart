<?php
session_start();
include_once ROOT."config/db_config.php";
include_once ROOT."class/Cart.php";
// Add product to cart
if (isset($_POST['add_to_cart'])){
    if (!isset($_SESSION['user_id'])){
        header(ROOT.'login.php');
    }
    $product_id = $_POST['product_id'];
    $cartObj = new Cart($_SESSION['user_id']);
    Cart::setDb($con);
    $cartObj->addItem($product_id);

}
