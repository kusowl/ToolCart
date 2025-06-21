<?php

class Helper
{
    public static function uploadFile($file, string $path): mixed {
        $tmp_path = $file['tmp_name'];
        $imageName = $file['name'];
        $imageName = time() . $imageName;


        if (!is_dir($path)) {
            if (mkdir($path, 0755, true)) {
                echo "Created pathectory $path\n";
            } else {
                $_SESSION['messages'] = "path $path cannot be created\n";
                return false;
            }
        }
        $server_path = $path.$imageName;
        if (move_uploaded_file($tmp_path, $server_path)) {
            return $imageName;
        }
        return false;

    }

    public static function validateFile($file, Array $fileTypes, int $fileSize)
    {
        if ($file['error'] != UPLOAD_ERR_OK)
            return 1;
        // Check file type
        if (!in_array($file['type'], $fileTypes))
            return 2;

        if ($file['size'] > $fileSize)
            return 3;

        return 0;
    }

    public static function validateAndSanitizeAddress($postData, $userId): array
    {
        $errors = [];
        $data = [];

        // Required fields validation
        $requiredFields = ['name', 'email', 'city', 'country', 'country_code', 'phone_no', 'pin', 'line_1'];
        foreach ($requiredFields as $field) {
            if (empty($postData[$field])) {
                $errors[$field] = ucfirst(str_replace('_', ' ', $field)) . ' is required';
            }
        }

        // Email validation
        if (!empty($postData['email']) && !filter_var($postData['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Invalid email format';
        }

        // Phone number validation
        if (!empty($postData['ph_no']) && !preg_match('/^[\+]?[\d\-\(\)\s]{7,20}$/', $postData['ph_no'])) {
            $errors['ph_no'] = 'Invalid phone number format';
        }


        // Sanitize all fields if no errors
        if (empty($errors)) {
            $data = [
                'user_id' => (int)$userId,
                'name' => htmlspecialchars(trim($postData['name']), ENT_QUOTES, 'UTF-8'),
                'email' => filter_var(trim($postData['email']), FILTER_SANITIZE_EMAIL),
                'city' => htmlspecialchars(trim($postData['city']), ENT_QUOTES, 'UTF-8'),
                'country' => htmlspecialchars(trim($postData['country']), ENT_QUOTES, 'UTF-8'),
                'country_code' => strtoupper(trim($postData['country_code'])),
                'ph_no' => preg_replace('/[^\d\+\-\(\)\s]/', '', trim($postData['ph_no'])),
                'pin' => htmlspecialchars(trim($postData['pin']), ENT_QUOTES, 'UTF-8'),
                'line_1' => htmlspecialchars(trim($postData['line_1']), ENT_QUOTES, 'UTF-8'),
                'line_2' => htmlspecialchars(trim($postData['line_2'] ?? ''), ENT_QUOTES, 'UTF-8'),
                'instructions' => htmlspecialchars(trim($postData['instructions'] ?? ''), ENT_QUOTES, 'UTF-8')
            ];
        }

        return ['valid' => empty($errors), 'errors' => $errors, 'data' => $data];
    }
}