<?php

class Helper
{
    public static function upload_file($file, string $path): mixed {
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
}