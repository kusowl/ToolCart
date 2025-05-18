<?php 
function upload_file($file, $path): mixed {
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
?>