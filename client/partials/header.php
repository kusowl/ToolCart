<?php
$rootDir  = dirname(__DIR__).'/';
require_once $rootDir."config/site_config.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?? $siteName ?></title>
    <link rel="stylesheet" href="<?=$baseUrl?>client/style.css">
</head>
<body>