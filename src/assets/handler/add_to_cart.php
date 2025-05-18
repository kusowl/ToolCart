<?php
session_start();
include_once "../../config/db_config.php";


if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // check if the id is set
    $product_id = $_GET["product_id"] ?? '';
    if (empty($product_id)) {
        // redirect back to the home page
        header('Location:../home.php');
    }
    // Check if the session is set or not
    $user_id = $_SESSION["id"] ?? '';
    if (empty($user_id)) {
        // if user is not logged in the redirect to home page
        header('Location:../home.php');
    }

    $select_query = "SELECT `created_at` FROM `product` WHERE `id` = $product_id";
    $result = mysqli_query($conn, $select_query);
    // if the product does not exist
    if (mysqli_num_rows($result) == 0) {
        // redirect back to the home page
        header('Location:../home.php');
    }

    // Check if the product is already in the cart
    $select_query = "SELECT * FROM `cart` WHERE product_id ='" . $product_id . "'";
    $result = mysqli_query($conn, $select_query);
    if (mysqli_num_rows($result) > 0) {
        // product exists then update quantity
        $update_query = "UPDATE `cart` SET `qty`= `qty` + 1 WHERE `product_id` ='" . $product_id . "'";
        $result = mysqli_query($conn, $update_query);
    } else {
        $insert_query = "INSERT INTO `cart` (`product_id`, `user_id`) VALUES ('$product_id','$user_id')";
        mysqli_query($conn, $insert_query);
    }
    header('Location:../home.php');
}
