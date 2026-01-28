<?php
    require '../details.php';
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <!-- <meta HTTP-EQUIV="Content-Type" content="text/html; charset=SHIFT_JIS"> -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0"/>
    <meta name="description" content="<?= NAME ?> securely stores your crypto assets in the most simple and easy way. Truly mobile-friendly, supporting major cryptocurrencies like Bitcoin, BNB, Ethereum and all ERC20 tokens in one wallet. Start your worry-free crypto life with <?= NAME ?> everywhere, everyday.">
    <meta name="keywords" content="<?= NAME ?> official Bitcoin Ethereum ERC20 secure mobile offline cryptocurrency wallet private key crypto asset manager EOS">
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no"> -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <title><?= NAME ?> Crypto Hardware Wallet (Official) | The best wallet to protect your assets</title>
    <!-- Favicons -->
    <link href="../uploads/<?= FAV ?>" rel="icon">
    <!-- ios apple-touch-icon -->
    <link rel="apple-touch-icon" sizes="48x48" href="../uploads/<?= FAV ?>"/>

    <!-- Google Fonts -->
    <!-- <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,700,700i|Montserrat:300,400,500,700" rel="stylesheet"> -->

    <!-- Vendor CSS Files -->
    <link href="../assets/vendor/animate.css/animate.min496d.css?v=202601151767855013676" rel="stylesheet">
    <link href="../assets/vendor/aos/aos496d.css?v=202601151767855013676" rel="stylesheet">
    <link href="../assets/vendor/bootstrap/css/bootstrap.min496d.css?v=202601151767855013676" rel="stylesheet">
    <link href="../assets/vendor/bootstrap-icons/bootstrap-icons496d.css?v=202601151767855013676" rel="stylesheet">
    <link href="../assets/vendor/glightbox/css/glightbox.min496d.css?v=202601151767855013676" rel="stylesheet">
    <link href="../assets/vendor/swiper/swiper-bundle.min496d.css?v=202601151767855013676" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link rel="stylesheet" href="../assets/css/common496d.css?v=202601151767855013676">
    <link rel="stylesheet" href="../assets/css/header496d.css?v=202601151767855013676">
    <link rel="stylesheet" href="../assets/css/footer496d.css?v=202601151767855013676">

    <!-- <link href="/assets/css/style.css?v=202601151767855013676" rel="stylesheet"> -->
    <!-- Jivosite tracking script removed to prevent tracking prevention errors -->

    <script>
        var email_can_not_be_empty = "Email can not be empty!";
        var email_format_is_not_correct = "Email format is not correct!";
        var thank_you_for_subscribing = "Thank you for subscribing!";
        var please_input_correct_email = "Please input correct email";
        var please_input_your_first_name = "Please input your first name";
        var please_input_your_last_name = "Please input your last name";
        var please_input_your_job_title = "Please input your job title";
        var please_input_correct_website = "Please input correct website";
        var please_input_zipcode = "Please input zipcode";
        var please_input_country_or_region = "Please input Country or region";
        var current_lang = "en";

        function handleImageError(img, defaultImageUrl) {
            img.src = defaultImageUrl;
            if (img.dataset.fallback === "1") {
                img.onerror = null;
                img.src = "";
                return;
            }
            img.onerror = null;
            img.dataset.fallback = "1";
        }
    </script>

    <!-- Google Analytics removed to prevent tracking prevention errors -->
    <!-- Twitter conversion tracking removed to prevent tracking prevention errors -->
</head>

<body>
