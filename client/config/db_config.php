<?php 

    // Database credentials and connection var
    $host = "localhost";
    $user = "root";
    $pass = "";
    $db  = "toolcart";

    try {
        $conn = mysqli_connect($host, $user, $pass, $db);
            // Database credentials
        if(!$conn){
            echo "Cannot connect to Database | ".mysqli_error($conn);
        }
    } catch (\Throwable $e) {
        echo $e;
    }

?>