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
    $path = $path.$imageName;
    if (move_uploaded_file($file['tmp_name'], $path)) {
        return $path;
    }
    return false;

}
?>