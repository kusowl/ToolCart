<?php
session_start();
include_once ROOT . "class/User.php";
include_once ROOT . "config/db_config.php";
// Initialize error array
$errors = [];

if (isset($_POST['login'])) {
    // Sanitize and validate email
    $email = trim(filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL));
    $password = $_POST['password'] ?? '';

    if (empty($email)) {
        $errors['email'] = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Invalid email format";
    } elseif (empty($password)) {
        $errors['password'] = 'Password is required';
    }

    // If no errors occured then go with login
    if (empty($errors)) {
        $userObj = new User();
        User::setDb($con);
        $response = $userObj->login($email, $password);

        if ($response['success']) {
            // If login successful then redirect based on user type.
            $user = $response['user'];
            $_SESSION['user_name'] = $user->getName();
            $_SESSION['user_id'] = $user->getUserId();

            switch ($user->getType()) {
                case 'admin':
                    $location = "admin/dashboard";
                    break;
                default:
                    # code...
                    break;
            }
            $location = match ($user->getType()) {
                // Routes based on user type
                'admin' => 'admin/dashboard',
                'customer' => 'home'
            };

            header("location:$location");
            exit;
        }else{
            $_SESSION['form_data'] = [
                'email' => $email
            ];
            header("location:login");
            exit;
        }

    } else {
        $_SESSION["messages"]['login_failed'] = "Password does not matched.";
        $_SESSION['message_type'] = 'error';
        $_SESSION['form_data'] = [
            'email' => $email
        ];
        header("location:login");
        exit;
    }
}