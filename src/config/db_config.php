<?php 
    require_once __DIR__.'/../class/Model.php';
    // Database credentials and connection var
    $host = "localhost";
    $dbName  = "toolcart";
    $userName = "root";
    $password = "";
    $dsn = "mysql:host={$host};dbname={$dbName}";
    try {
        $con = new PDO($dsn, $userName, $password);
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        Model::setDb($con);
    } catch (PDOException $e) {
        echo "Database Connection Failed: ".$e->getMessage();
    }
    // Defining constrains
    define('QUERY_LIMIT', 10);
    define('MAX_FILE_SIZE', 1024 * 1024 * 2);

?>