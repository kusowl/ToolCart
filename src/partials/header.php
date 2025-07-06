
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?? SITE_NAME ?></title>
    <link rel="icon" type="image/x-icon" href="<?= BASE_URL.'assets/images/logo/logo.ico' ?>">
    <link rel="stylesheet" href="<?=BASE_URL?>style.css">
    <script src="<?=BASE_URL.'src/assets/js/jquery-3.7.1.min.js'?>"></script>
    <script src="<?=BASE_URL.'src/assets/ajax/payment.js'?>"></script>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>

</head>
<body>