<?php
include_once ROOT . "class/User.php";
include_once ROOT . "config/db_config.php";
// Initialize error array
$errors = [];
$user = new User();
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $user = User::getById($_GET['id']);
    $formData['name'] = $user->getName();
    $formData['email'] = $user->getEmail();
    $formData['password'] = $user->getPassword();
    $formData['image'] = $user->getImage();
    $formData['id'] = $user->getUserId();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
    $id = $_POST['id'];
    if($user->getUserId() != $id) {
        $errors['user'] = "User already exists with this email";
    }
    $image = $_FILES['user_image'];
    $fileTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
    // Validate file
    $validationResult = $image['name'] != '' ? Helper::validateFile($image, $fileTypes, MAX_FILE_SIZE) : 98;
    $rel_path = 'assets/images/';
    $path = ROOT . $rel_path;
    switch ($validationResult) {
        case 98: break;
        case -1:
            $img_name = Helper::uploadFile($image, $path);
            break;
        case 0:
            $errors['Image Error'] = "Upload error";
            break;
        case 1:
            $errors['Image Error'] = "File type not allowed";
            break;
        case 2:
            $errors['Image Error'] = "File is is not allowed";
            break;
        default:
            $errors['Image Error'] = "Validation Failed";
    }
    // If no errors, process form data
    if (empty($errors)) {
        // Hash password for security
        $data = [
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'image' => $img_name,
            'id' => $id,
        ];
        if($user->update($data)){
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
}