<?php
// Start session for error messages
session_start();

include "../config/db_config.php";

// Initialize error array
$errors = [];

// Check if form is submitted via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate name
    $name = trim(mysqli_real_escape_string($conn, htmlspecialchars($_POST['name'] ?? '')));
    if (empty($name)) {
        $errors['name'] = "Name is required";
    } elseif (strlen($name) < 2 || strlen($name) > 50) {
        $errors['name'] = "Name must be between 2 and 50 characters";
    }

    // Sanitize and validate email
    $email = trim(filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL));
    if (empty($email)) {
        $errors['email'] = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Invalid email format";
    }

    // Check if email already exists in database
    $result = mysqli_query($conn,"SELECT * FROM `user` WHERE `email` = '$email'");
    
    if(mysqli_num_rows($result) > 0){
        $errors['email_exist'] = "Email already exist. You can login";
    }

    // Validate password
    $password = $_POST['password'] ?? '';
    if (empty($password)) {
        $errors['password'] = "Password is required";
    } /*elseif (strlen($password) < 8) {
        $errors['password'] = "Password must be at least 8 characters";
    } elseif (!preg_match("/[A-Z]/", $password)) {
        $errors['password'] = "Password must contain at least one uppercase letter";
    } elseif (!preg_match("/[a-z]/", $password)) {
        $errors['password'] = "Password must contain at least one lowercase letter";
    } elseif (!preg_match("/[0-9]/", $password)) {
        $errors['password'] = "Password must contain at least one number";
    } elseif (!preg_match("/[^A-Za-z0-9]/", $password)) {
        $errors['password'] = "Password must contain at least one special character";
    }*/

    // Validate confirm password
    $confirm_password = $_POST['confirm_password'] ?? '';
    if (empty($confirm_password)) {
        $errors['confirm_password'] = "Please confirm your password";
    } elseif ($password !== $confirm_password) {
        $errors['confirm_password'] = "Passwords do not match";
    }

    // If no errors, process form data
    if (empty($errors)) {
        // Hash password for security
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $insert_q = "INSERT INTO `user`(`name`, `email`, `password`) VALUES ('$name','$email','$hashed_password')";

        mysqli_query($conn, $insert_q);

        $_SESSION['success'] = "Account created successfully!";
        header("Location: register.php");
        exit();
    } else {
        // Store errors in session
        $_SESSION['errors'] = $errors;
        // Store form data to repopulate form
        $_SESSION['form_data'] = [
            'name' => $name,
            'email' => $email
        ];
    }
}

// Redirect back to form if there were errors
if (!empty($errors)) {
    header("Location: register.php");
    exit();
}
