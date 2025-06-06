<?php
// Start session for error messages
session_start();
include_once ROOT."class/User.php";
include_once ROOT."config/db_config.php";
// Initialize error array
$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate name
    $name = $_POST['name'];
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

    // Validate password
    $password = $_POST['password'] ?? '';
    if (empty($password)) {
        $errors['password'] = "Password is required";
    } elseif (strlen($password) < 4) {
        $errors['password'] = "Password must be at least 4 characters";
    } elseif (!preg_match("/[A-Z]/", $password)) {
        $errors['password'] = "Password must contain at least one uppercase letter";
    } elseif (!preg_match("/[a-z]/", $password)) {
        $errors['password'] = "Password must contain at least one lowercase letter";
    } elseif (!preg_match("/[0-9]/", $password)) {
        $errors['password'] = "Password must contain at least one number";
    } elseif (!preg_match("/[^A-Za-z0-9]/", $password)) {
        $errors['password'] = "Password must contain at least one special character";
    }

    // Validate confirm password
    $confirm_password = $_POST['confirm_password'] ?? '';
    if (empty($confirm_password)) {
        $errors['confirm_password'] = "Please confirm your password";
    } elseif ($password !== $confirm_password) {
        $errors['confirm_password'] = "Passwords do not match";
    }
    $user = User::getUser($email);
    if($user->getUserId() != null){
        $errors['user'] = "User already exists with this email";
    }
    // If no errors, process form data
    if (empty($errors)) {
        // Hash password for security
        $user = new User([
            'name' => $name,
            'email' => $email,
            'password' => $password
        ]);
        if($user->createUser()){
            $_SESSION['messages']['login_now'] = "Account created successfully!";
            $_SESSION["message_type"] = 'success';
        }else{
            $_SESSION['messages']['account'] = "Error occured while creating account!";
            $_SESSION["message_type"] = 'error';
        }

    } else {
        // Store errors in session
        $_SESSION['messages'] = $errors;
        // Store form data to repopulate form
        $_SESSION['form_data'] = [
            'name' => $name,
            'email' => $email
        ];
    }
    header("Location: register.php");
}

// Redirect back to form if there were errors
if (!empty($errors)) {
    $_SESSION["message_type"] = 'error';
    header("Location: register.php");
    exit();
}
