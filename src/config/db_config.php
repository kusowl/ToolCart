<?php 

    // Database credentials and connection var
    $host = "localhost";
    $dbName  = "toolcart";
    $userName = "root";
    $password = "";
    $dsn = "mysql:host={$host};dbname={$dbName}";
    try {
        $con = new PDO($dsn, $userName, $password);
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo "Database Connection Failed: ".$e->getMessage();
    }

?>