<?php
include_once ROOT . "class/User.php";
include_once ROOT . "config/db_config.php";
include_once ROOT . "class/Helper.php";
// Initialize error array
$errors = [];
$user = new User();
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if(empty($_SESSION['user_id'])) {
        header('Location: login');
        exit;
    }else{
        $userId = $_SESSION['user_id'];
    }
    $user = User::getById($userId);
    $formData['name'] = $user->getName();
    $formData['email'] = $user->getEmail();
    $_SESSION['image'] = $formData['image'] = $user->getImage();
    $formData['id'] = $userId;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['action'] == 'Save') {
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
        $password = $_POST['old_password'] ?? '';
        if ($password != '') {
            // Check if the old password is correct
            if ($user->login($_SESSION['user_email'], $password)['success']) {
                $password = $_POST['new_password'] ?? '';
                if (strlen($password) < 4) {
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
            } else {
                $errors['password'] = "Old password is incorrect";
            }
        }
        else{
            if ($_POST['new_password'] != '') {
                $errors['new_password'] = "Old password is required";
            }
        }
        // Check if the user have modified the email in the form
        if($_SESSION['user_email'] != $email) {
            $user = User::getUser($email);
            $id = $_POST['id'];
            if ($user->getUserId() != $id) {
                $errors['user'] = "User already exists with this email";
            }
        }

        $image = $_FILES['user_image'];
        $fileTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
        // Validate file
        $validationResult = $image['name'] != '' ? Helper::validateFile($image, $fileTypes, MAX_FILE_SIZE) : 98;
        $rel_path = 'assets/images/';
        $path = ROOT . $rel_path;
        $img_name  = '';
        switch ($validationResult) {
            case 98:
                break;
            case 0:
                $img_name = Helper::uploadFile($image, $path);
                break;
            case 1:
                $errors['Image Error'] = "Upload error";
                break;
            case 2:
                $errors['Image Error'] = "File type not allowed";
                break;
            case 3:
                $errors['Image Error'] = "File is size should be less than ".MAX_FILE_SIZE." bytes";
                break;
            default:
                $errors['Image Error'] = "Validation Failed";
        }

        // If no errors, process form data
        if (empty($errors)) {
            $data['id'] = $_SESSION['user_id'];
            if ($name != '') $data['name'] = $name;
            if ($email != '') $data['email'] = $email;
            if ($password != '') $data['password'] = $password;
            if ($image['name'] != '') $data['image'] = $rel_path . $img_name;
            if ($user->update($data)) {
                $_SESSION['messages']['Account'] = "Updated successfully!";
                $_SESSION["message_type"] = 'success';
                if($img_name != '') $_SESSION['image'] = $rel_path . $img_name;
            } else {
                $_SESSION['messages']['Account'] = "Error occured while updating account!";
                $_SESSION["message_type"] = 'error';
            }

        } else {
            // Store errors in session
            $_SESSION['messages'] = $errors;
            $_SESSION['message_type'] = 'error';


        }
        // Store form data to repopulate form
        $_SESSION['form_data'] = [
            'name' => $name,
            'email' => $email,
            'image' => $_SESSION['image']
        ];
        if(User::getById($_SESSION['user_id'])->getType() == 'admin'){
            header('Location: admin_profile');
            exit;
        }else{
            header('Location: profile');
            exit;
        }
    }
}