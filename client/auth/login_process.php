<?php
// Start session for error messages
session_start();

include "../config/db_config.php";
include "../config/site_config.php";

// Initialize error array
$errors = [];

// Check if form is submitted via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate email
    $email = trim(filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL));
    if (empty($email)) {
        $errors['email'] = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Invalid email format";
    }

    // Check if email already exists in database
    $result = mysqli_query($conn,"SELECT * FROM `user` WHERE `email` = '$email'");
    
    if(mysqli_num_rows($result) == 0){
        $errors['email_exist'] = "Email not found. Register Now";
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


    // If no errors, process form data
    if (empty($errors)) {

        $result = mysqli_fetch_assoc($result);
        
        // verify password 
        $verify_password = password_verify($password, $result['password']);
        if ($verify_password) {
            $_SESSION["name"] = $result['name'];
            $_SESSION["email"] = $result['email'];
            $_SESSION["id"] = $result['id'];

            // Set redirect url based on user type
            switch ($result['user_type']) {
                case 'customer':
                    $location = $baseUrl."client/pages/home.php";
                    break;
                case 'admin':
                    $location = $baseUrl."client/admin/dashboard.php";
                    break;
                default:
                    # code...
                    break;
            }
            
            header("location:$location");
            exit;
        } else {
            $_SESSION["error"][]      = "Login Failed ! Password does not matched.";
            $_SESSION['form_data'] = [
                'email' => $email
            ];
            header("location:login.php");
            exit;
        }
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
