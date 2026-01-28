<?php
include 'assets/header.php';
?>

<!-- ======= Header ======= -->
<header id="header" class="fixed-top d-flex align-items-center header-transparent">
    <?php include 'assets/navbar.php'; ?>
</header><!-- End Header -->

<!-- <div class="bg-big">
  <div class="set-background"></div>
</div> -->
<!-- ======= hero Section ======= -->
<header>
    <link href="../assets/css/style496d.css?v=202601151767855013676" rel="stylesheet">
    <style>
        /* Dashboard Theme Colors */
        :root {
            --primary-color: #622faa;
            --dark-bg: #121212;
            --dark-card: #1e1e1e;
            --light-bg: #fff;
            --light-card: #f8f9fa;
            --text-light: #fff;
            --text-dark: #333;
            --accent-green: #00c985;
            --border-color: #333;
        }

        /* Default Dark Mode */
        body {
            background: var(--dark-bg);
            color: var(--text-light);
        }

        /* Primary Button Colors */
        .transparent-light-green,
        .btn-light-green,
        .set-off-btn .downloads-btn {
            background: var(--primary-color) !important;
            color: #fff !important;
            border-color: var(--primary-color) !important;
        }

        .transparent-light-green:hover,
        .btn-light-green:hover,
        .set-off-btn .downloads-btn:hover {
            background: #8c3fca !important;
            border-color: #8c3fca !important;
        }

        /* Cards and Sections */
        .wallet-item,
        .enumera-item,
        .trusted-item {
            background: var(--dark-card) !important;
            border-color: var(--border-color) !important;
            color: var(--text-light) !important;
        }

        /* Header Styling */
        #header {
            background: rgba(18, 18, 18, 0.95) !important;
            border-bottom: 1px solid var(--border-color) !important;
        }

        /* Text Colors */
        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            color: var(--text-light) !important;
        }

        p {
            color: #aaa !important;
        }

        /* Section Backgrounds */
        #choose-your-wallet,
        #crypto,
        #beyond-crypto,
        #stand-out {
            background: var(--dark-bg) !important;
        }

        /* Light Mode Support */
        body.light-mode {
            background: var(--light-bg);
            color: var(--text-dark);
        }

        body.light-mode h1,
        body.light-mode h2,
        body.light-mode h3,
        body.light-mode h4,
        body.light-mode h5,
        body.light-mode h6 {
            color: var(--text-dark) !important;
        }

        body.light-mode p {
            color: #666 !important;
        }

        body.light-mode #header {
            background: rgba(255, 255, 255, 0.98) !important;
            border-bottom: 1px solid #ddd !important;
        }

        body.light-mode .wallet-item,
        body.light-mode .enumera-item,
        body.light-mode .trusted-item {
            background: var(--light-card) !important;
            border-color: #ddd !important;
            color: var(--text-dark) !important;
        }

        body.light-mode #choose-your-wallet,
        body.light-mode #crypto,
        body.light-mode #beyond-crypto,
        body.light-mode #stand-out {
            background: var(--light-bg) !important;
        }

        /* Responsive Design */
        @media (max-width: 1200px) {
            body {
                font-size: 15px;
            }
        }

        @media (max-width: 768px) {
            body {
                font-size: 14px;
            }

            h1 {
                font-size: 28px !important;
            }

            h2 {
                font-size: 24px !important;
            }

            h3 {
                font-size: 20px !important;
            }

            .wallet-item,
            .enumera-item,
            .trusted-item {
                padding: 15px !important;
            }
        }

        @media (max-width: 480px) {
            body {
                font-size: 13px;
            }

            h1 {
                font-size: 22px !important;
            }

            h2 {
                font-size: 18px !important;
            }

            h3 {
                font-size: 16px !important;
            }

            .container {
                padding: 10px !important;
            }

            .wallet-item,
            .enumera-item,
            .trusted-item {
                padding: 12px !important;
                margin-bottom: 10px !important;
            }

            .transparent-light-green,
            .btn-light-green,
            .set-off-btn .downloads-btn {
                padding: 10px 20px !important;
                font-size: 13px !important;
            }
        }

        /* SafePal Logo Styling */
        .sfp-logo {
            margin-bottom: 2rem;
        }

        .logo-box {
            max-width: 120px;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .logo-box img {
            max-width: 100%;
            height: auto;
            display: block;
        }

        @media (max-width: 768px) {
            .logo-box {
                max-width: 100px;
            }
        }

        @media (max-width: 480px) {
            .logo-box {
                max-width: 80px;
            }
        }
    </style>
</header>
<main id="main" class="home">
    <!--<div id="brandoverview" class="brandoverview-swiper swiper d-none d-lg-block">-->
    <!--    <div class="swiper-wrapper align-items-center">-->
    <!--        <div class="swiper-slide"><?= NAME ?> has launched the first crypto friendly banking gateway and Mastercard! Learn more <a href="bank.php" style="margin-left:6px;text-decoration: underline;color: #79EFBD;">here</a>.</div>-->
    <!--        <div class="swiper-slide">Security is indispensable. Learn how we make crypto safer for users <a href="https://www.safepal.com/secure" style="margin-left:6px;text-decoration: underline;color: #79EFBD;">here</a>.</div>-->
    <!--    </div>-->
    <!--</div>-->
    <div class="position-relative hero-choose-your-wallet">
        <section id="hero" class="position-relative">
            <!--<div id="brandoverview" class="brandoverview-swiper-m swiper d-lg-none">-->
            <!--    <div class="swiper-wrapper align-items-center">-->
            <!--        <div class="swiper-slide"><?= NAME ?> has launched the first crypto friendly banking gateway and Mastercard! Learn more <a href="bank.php" style="margin-left:6px;text-decoration: underline;color: #79EFBD;">here</a>.</div>-->
            <!--        <div class="swiper-slide">Security is indispensable. Learn how we make crypto safer for users <a href="https://www.safepal.com/secure" style="margin-left:6px;text-decoration: underline;color: #79EFBD;">here</a>.</div>-->
            <!--    </div>-->
            <!--</div>-->
            <div class="container position-relative hero-container d-flex align-items-center justify-content-center flex-column">
                <div class="title" data-aos="fade-down">
                    <h3>Own Your</h3>
                    <h3 class="crypto-adventure">Crypto Adventure</h3>
                </div>
                <div class="position-relative text-center imgae-box">
                    <img class="absolute img-fluid move-animation-Y hero-ntf" data-aos="fade-down" src="https://www.safepal.com/assets/img/hero-ntf.svg" alt="">
                    <img class="absolute img-fluid move-animation-Y hero-hardware-x1" data-aos="fade-right" src="../assets/img/hero-hardware-x1.png" alt="">
                    <img class="absolute img-fluid move-animation-Y hero-hardware" data-aos="fade-right" src="https://www.safepal.com/assets/img/hero-hardware-wallet.svg" alt="">
                    <img class="absolute img-fluid move-animation-Y hero-extension" data-aos="fade-left" src="https://www.safepal.com/assets/img/hero-extension.svg" alt="">
                    <img class="absolute img-fluid move-animation-Y hero-safe-extension" data-aos="fade-left" src="https://www.safepal.com/assets/img/safePal-uni-icon.svg" alt="">
                    <img class="absolute img-fluid move-animation-Y hero-eth" data-aos="fade-left" src="https://www.safepal.com/assets/img/coin-icon/eth.svg" alt="">
                    <img class="img-fluid hero-mobile move-animation-Y" data-aos="fade-down" src="https://www.safepal.com/assets/img/home/hero-mobile_en.svg" alt="" onerror="handleImageError(this, `/assets/img/home/hero-mobile_en.svg`)">
                </div>
                <img class="position-absolute d-none d-lg-block hero-moon" src="https://www.safepal.com/assets/img/hero-moon.svg" alt="" srcset="">
                <img class="position-absolute d-none d-lg-block hero-stripe1" src="https://www.safepal.com/assets/img/stripe-1.svg" alt="" srcset="">
            </div>

            <img class="absolute img-fluid hero-stripe2" src="https://www.safepal.com/assets/img/stripe-2.svg" alt="">
            <img class="absolute img-fluid hero-stripe3" src="https://www.safepal.com/assets/img/stripe-3.svg" alt="">
        </section><!-- End Hero Section -->
        <!-- ======= Featured Services Section Section ======= -->
        <section id="choose-your-wallet">
            <div class="container title pc-star" data-aos="fade-up">
                <!-- mobile - star -1 -->
                <div class="d-lg-none m-star m-star-1">
                    <div class="position-relative star-1 star-move">
                        <div class="star1-point">
                            <img class="img-fluid" src="https://www.safepal.com/assets/img/icon-point.svg" alt="" srcset="">
                        </div>
                        <div class="star">
                            <img class="img-fluid" src="https://www.safepal.com/assets/img/icon-start-fill.svg" alt="" srcset="">
                        </div>
                    </div>
                </div>
                <div class="title-top">
                    <p>OWN YOUR CRYPTO.</p>
                </div>
                <div class="title-middle">
                    <p>Choose your <?= NAME ?> wallet.</p>
                </div>
                <div class="title-bottom">
                    <p>Protect & manage Bitcoin, Ethereum and thousands of other digital assets with your pick from our collection of mobile, hardware and extension wallets.</p>
                </div>
                <!-- pc- star - start -->
                <div class="absolute d-none d-lg-block start-1">
                    <div class="start1-point">
                        <img class="" src="https://www.safepal.com/assets/img/icon-point.svg" alt="" srcset="">
                    </div>
                    <div class="start">
                        <img class="" src="https://www.safepal.com/assets/img/icon-start-fill.svg" alt="" srcset="">
                    </div>
                </div>
                <div class="absolute d-none d-lg-block start-2">
                    <div class="start2-point"><img class="" src="https://www.safepal.com/assets/img/icon-point.svg" alt="" srcset=""></div>
                    <div class="start">
                        <img class="" src="https://www.safepal.com/assets/img/icon-start-empty.svg" alt="" srcset="">
                    </div>
                </div>
                <!-- pc- star - end -->
                <!-- mobile - star -2 -->
                <div class="d-lg-none m-star m-star-2">
                    <div class="position-relative star-2">
                        <div class="star2-point"><img class="img-fluid" src="https://www.safepal.com/assets/img/icon-point.svg" alt="" srcset=""></div>
                        <div class="star">
                            <img class="img-fluid" src="https://www.safepal.com/assets/img/icon-start-empty.svg" alt="" srcset="">
                        </div>
                    </div>
                </div>
            </div>
            <div class="wallet-box container overflow-hidden">
                <div class="row">
                    <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 my-col">
                        <div class="wallet-item">
                            <a href="#">
                                <div class="img" data-aos="fade-up">
                                    <img class="img-fluid" src="../assets/img/home/icon-wallet-app_en.svg" alt="" onerror="handleImageError(this, `/assets/img/home/icon-wallet-app_en.svg`)">
                                </div>
                            </a>
                            <div class="item-middle d-flex align-items-start justify-content-start flex-column download">
                                <div class="middle-left download-left">
                                    <h3>App</h3>
                                </div>

                            </div>
                            <div class="describe">
                                <p><?= NAME ?> Wallet is the best crypto wallet for beginners and experts alike. Buy, sell and trade crypto – securely and on the go.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 my-col">
                        <div class="wallet-item">
                            <a href="#">
                                <div class="img" data-aos="fade-up">
                                    <img src="../assets/img/home/icon-wallet-extension_en.png" alt="" onerror="handleImageError(this, `/assets/img/home/icon-wallet-extension_en.png`)">
                                </div>
                            </a>
                            <div class="item-middle d-flex align-items-start justify-content-start flex-column download">
                                <div class="middle-left">
                                    <h3>Extension</h3>
                                </div>

                            </div>
                            <div class="describe">
                                <p>Turn your Chrome browser into a crypto wallet with radical multi-chain capability.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 my-col">
                        <div class="wallet-item">
                            <a href="javascript:void(0)">
                                <div class="img img-bg" data-aos="fade-up">
                                    <img class="wallet-hardware" src="../assets/img/icon-wallet-hardware.png" alt="" srcset="">
                                </div>
                            </a>
                            <div class="item-middle d-flex align-items-start justify-content-start flex-column buy-now">
                                <div class="middle-left">
                                    <h3>Hardware</h3>
                                </div>

                            </div>
                            <div class="describe">
                                <p>Take control of your assets with secure cold storage options; the fully air-gapped and 100% offline <?= NAME ?> S1 line, or the new open-source Bluetooth X1</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div style="height:5px; width: 100vw; background: #4a21ef;"></div>
        </section><!-- End Featured Services Section -->
        <img class="position-absolute d-none d-lg-block epaulet-left" src="https://www.safepal.com/assets/img/epaulet-left.svg" alt="" srcset="">
        <img class="position-absolute d-none d-lg-block epaulet-right" src="https://www.safepal.com/assets/img/epaulet-right.svg" alt="" srcset="">
    </div>
    <!-- =============== backed by ================= -->
    <section id="backed">
        <div class="backed-content" data-aos="zoom-in">
            <header class="title">PARTNER WITH THE BEST</header>
            <div class="backed-list backed-slider swiper">
                <div id="backed-swiper-wrapper" class="swiper-wrapper align-items-center">
                    <div class="swiper-slide"><a href="#" target="_blank" style="display: block; z-index: 1;"><img src="https://www.safepal.com/assets/img/partner/injective.svg" /></a></div>
                    <div class="swiper-slide"><a href="#" target="_blank" style="display: block; z-index: 1;"><img src="https://www.safepal.com/assets/img/partner/Harmony.svg" /></a></div>
                    <div class="swiper-slide"><a href="#" target="_blank" style="display: block; z-index: 1;"><img src="https://www.safepal.com/assets/img/partner/Binance.svg" /></a></div>
                    <div class="swiper-slide"><a href="#" target="_blank" style="display: block; z-index: 1;"><img src="https://www.safepal.com/assets/img/partner/Binance_labs.svg" /></a></div>
                    <div class="swiper-slide"><a href="#" target="_blank" style="display: block; z-index: 1;"><img src="https://www.safepal.com/assets/img/partner/AnimocaBrands.svg" /></a></div>
                    <div class="swiper-slide"><a href="#" target="_blank" style="display: block; z-index: 1;"><img src="https://www.safepal.com/assets/img/partner/Nervos.svg" /></a></div>
                    <div class="swiper-slide"><a href="#" target="_blank" style="display: block; z-index: 1;"><img src="https://www.safepal.com/assets/img/partner/Simplex.svg" /></a></div>
                    <div class="swiper-slide"><a href="#" target="_blank" style="display: block; z-index: 1;"><img src="https://www.safepal.com/assets/img/partner/1inch.svg" /></a></div>
                    <div class="swiper-slide"><a href="#" target="_blank" style="display: block; z-index: 1;"><img src="https://www.safepal.com/assets/img/partner/Pancakeswap.svg" /></a></div>
                    <div class="swiper-slide"><a href="#" target="_blank" style="display: block; z-index: 1;"><img src="https://www.safepal.com/assets/img/partner/Apollox.svg" /></a></div>
                    <div class="swiper-slide"><a href="#" target="_blank" style="display: block; z-index: 1;"><img src="https://www.safepal.com/assets/img/partner/Perpetual_Protocol.svg" /></a></div>
                    <div class="swiper-slide"><a href="#" target="_blank" style="display: block; z-index: 1;"><img src="https://www.safepal.com/assets/img/partner/Uniswap.svg" /></a></div>
                    <div class="swiper-slide"><a href="#" target="_blank" style="display: block; z-index: 1;"><img src="https://www.safepal.com/assets/img/partner/Compound.svg" /></a></div>
                    <div class="swiper-slide"><a href="#" target="_blank" style="display: block; z-index: 1;"><img src="https://www.safepal.com/assets/img/partner/Avalanche.svg" /></a></div>

                    <!-- <div class="swiper-slide"><a href="https://polkadot.network/" target="_blank" style="display: block; z-index: 1;"><img src="/assets/img/partner/polkadot_logo.svg" /></a></div>
                    <div class="swiper-slide"><a href="https://www.stellar.org/" target="_blank" style="display: block; z-index: 1;"><img src="/assets/img/partner/stellar_logo.svg" /></a></div>
                    <div class="swiper-slide"><a href="https://kusama.network/" target="_blank" style="display: block; z-index: 1;"><img src="/assets/img/partner/kusama_logo.svg" /></a></div>
                    <div class="swiper-slide"><a href="https://www.coinpayments.net/" target="_blank" style="display: block; z-index: 1;"><img src="/assets/img/partner/coinpayments_logo.svg" /></a></div>
                    <div class="swiper-slide"><a href="https://pancakeswap.finance/" target="_blank" style="display: block; z-index: 1;"><img src="/assets/img/partner/pancakeswap_logo.svg" /></a></div>
                    <div class="swiper-slide"><a href="https://1inch.exchange/" target="_blank" style="display: block; z-index: 1;"><img src="/assets/img/partner/1inch_logo.svg" /></a></div>
                    <div class="swiper-slide"><a href="https://uniswap.org/" target="_blank" style="display: block; z-index: 1;"><img src="/assets/img/partner/uniswap_logo.svg" /></a></div>
                    <div class="swiper-slide"><a href="https://compound.finance/" target="_blank" style="display: block; z-index: 1;"><img src="/assets/img/partner/compound_logo.svg" /></a></div>
                    <div class="swiper-slide"><a href="https://aave.com/" target="_blank" style="display: block; z-index: 1;"><img src="/assets/img/partner/aave_logo.svg" /></a></div>
                    <div class="swiper-slide"><a href="https://gat.network/" target="_blank" style="display: block; z-index: 1;"><img src="/assets/img/partner/gat_logo.svg" /></a></div> -->


                </div>
                <!-- <div class="swiper-pagination"></div> -->
            </div>
        </div>
    </section>
    <section class="" id="crypto">
        <div class="crypto-main">
            <div class="crypto-box container">
                <div class="container position-relative crypto-content d-flex justify-content-center align-items-center flex-column">
                    <div class="crypto-top">
                        <div class="title pc-star" data-aos="fade-up">
                            <div class="d-lg-none m-star m-star-1">
                                <div class="position-relative star-1 star-move">
                                    <div class="star1-point">
                                        <img class="img-fluid" src="https://www.safepal.com/assets/img/icon-point.svg" alt="" srcset="">
                                    </div>
                                    <div class="star">
                                        <img class="img-fluid" src="https://www.safepal.com/assets/img/icon-start-fill.svg" alt="" srcset="">
                                    </div>
                                </div>
                            </div>
                            <div class="title-top">
                                <p>GROW YOUR CRYPTO.</p>
                            </div>
                            <div class="title-middle">
                                <p>Get more from your wallet.</p>
                            </div>
                            <div class="title-bottom">
                                <p>Our wallets don't just safeguard your crypto, they also create unique possibilities to grow your wealth. Leverage your assets with a range of diverse opportunities to earn and exchange, all adaptable to your knowledge, daily habits and tolerance for HODLing.</p>
                            </div>
                            <div class="absolute d-none d-lg-block start-1">
                                <div class="start1-point">
                                    <img class="" src="https://www.safepal.com/assets/img/icon-point.svg" alt="" srcset="">
                                </div>
                                <div class="start">
                                    <img class="" src="https://www.safepal.com/assets/img/icon-start-fill.svg" alt="" srcset="">
                                </div>
                            </div>
                            <div class="absolute d-none d-lg-block start-2">
                                <div class="start2-point"><img class="" src="https://www.safepal.com/assets/img/icon-point.svg" alt="" srcset=""></div>
                                <div class="start">
                                    <img class="" src="https://www.safepal.com/assets/img/icon-start-empty.svg" alt="" srcset="">
                                </div>
                            </div>
                            <div class="d-lg-none m-star m-star-2">
                                <div class="position-relative star-2">
                                    <div class="star2-point"><img class="img-fluid" src="https://www.safepal.com/assets/img/icon-point.svg" alt="" srcset="">
                                    </div>
                                    <div class="star">
                                        <img class="img-fluid" src="https://www.safepal.com/assets/img/icon-start-empty.svg" alt="" srcset="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="crypto-bottom d-flex justify-content-center align-items-start flex-lg-row flex-column">
                        <div class="crypto-bottom-item earn-now " data-aos="fade-up">
                            <div class="top">
                                <img class="img-fluid earn-now" src="https://www.safepal.com/assets/img/crypto/icon-earn-now.svg" alt="" srcset="">
                                <img class="absolute img-fluid move-backInDown btc-earn" data-aos="fade-down" data-aos-duration="1500"
                                    src="https://www.safepal.com/assets/img/crypto/icon-btc-earn.svg" alt="" srcset="">
                                <img class="absolute img-fluid move-backInDown x-earn" data-aos="fade-down" data-aos-duration="1500"
                                    src="https://www.safepal.com/assets/img/crypto/icon-other-x-earn.svg" alt=""
                                    srcset="">
                                <img class="absolute img-fluid move-backInDown sfp-earn1" data-aos="fade-down" data-aos-duration="1500"
                                    src="https://www.safepal.com/assets/img/crypto/icon-sfp-earn.svg" alt="" srcset="">
                                <img class="absolute img-fluid move-backInDown sfp-earn2" data-aos="fade-down" data-aos-duration="1500"
                                    src="https://www.safepal.com/assets/img/crypto/icon-sfp-earn.svg" alt="" srcset="">
                                <img class="absolute img-fluid move-backInDown eth-group-earn" data-aos="fade-down" data-aos-duration="1000"
                                    src="https://www.safepal.com/assets/img/crypto/icon-eth-group-earn.svg" alt=""
                                    srcset="">
                                <img class="absolute img-fluid move-backInDown other-group-earn" data-aos="fade-down" data-aos-duration="1200"
                                    src="https://www.safepal.com/assets/img/crypto/icon-other-group-earn.svg" alt="" srcset="">
                                <img class="absolute img-fluid move-backInDown btc-group-earn" data-aos="fade-down" data-aos-duration="1100"
                                    src="https://www.safepal.com/assets/img/crypto/icon-btc-group-earn.svg" alt=""
                                    srcset="">
                                <img class="absolute img-fluid move-backInDown T-earn" data-aos="fade-down" data-aos-duration="1500"
                                    src="https://www.safepal.com/assets/img/crypto/icon-T-earn.svg" alt="" srcset="">
                            </div>
                            <div class="middle">
                                <h3>Earn crypto every day.</h3>
                            </div>
                            <div class="bottom">
                                <p>Increase your passive income with unique programs designed to help you earn rewards and accelerate your APY.</p>
                                <div class="bottom-btn">
                                </div>
                            </div>
                        </div>
                        <div class="crypto-bottom-item trade-now " data-aos="fade-up">
                            <div class="top">
                                <img class="trade-img img-fluid" src="https://www.safepal.com/assets/img/crypto/icon-trade-now.svg" alt="" srcset="">
                                <img class="absolute img-fluid d-none d-lg-block crypto-phone"
                                    src="https://www.safepal.com/assets/img/home/icon-trade-phone_en.svg" alt="" onerror="handleImageError(this, `/assets/img/crypto/icon-trade-phone.svg`)">
                                <img class="absolute img-fluid d-lg-none crypto-phone"
                                    src="https://www.safepal.com/assets/img/home/icon-trade-phone_en.svg" alt="" onerror="handleImageError(this, `/assets/img/crypto/icon-trade-phone.svg`)">
                                <img class="absolute img-fluid d-none d-lg-block crypto-sfp move-animation-Y" style="top:13.6%;left:49.7%;animation-duration: 7s;"
                                    src="https://www.safepal.com/assets/img/coin-icon/sfp.svg" alt="" srcset="">
                                <img class="absolute img-fluid crypto-eth move-animation-Y" style="top:37.6%;left:29.7%;animation-duration: 8s;"
                                    src="https://www.safepal.com/assets/img/coin-icon/eth.svg" alt="" srcset="">
                                <img class="absolute img-fluid crypto-eth-b" style="top:68.5%;left:31.2%;"
                                    src="https://www.safepal.com/assets/img/crypto/icon-rectangle-trade.svg" alt="" srcset="">
                                <img class="absolute img-fluid crypto-btc move-animation-Y" style="top:28.8%;left:79.6%;"
                                    src="https://www.safepal.com/assets/img/coin-icon/btc.svg" alt="" srcset="">
                                <img class="absolute img-fluid" style="top:79.6%;right:0.8%;"
                                    src="https://www.safepal.com/assets/img/crypto/icon-decorate-trade.svg" alt="" srcset="">
                            </div>
                            <div class="middle">
                                <h3>Effortless trading.</h3>
                            </div>
                            <div class="bottom">
                                <p>React to market changes and swap between hundreds of assets instantly using our in-app integration with trading mini-programs.</p>
                                <div class="bottom-btn">

                                </div>
                            </div>
                        </div>
                    </div>
                    <img class="position-absolute crypto-moon" src="https://www.safepal.com/assets/img/crypto-moon.svg" alt="" srcset="">
                    <img class="position-absolute crypto-stripe1" src="https://www.safepal.com/assets/img/crypto-stripe1.svg" alt="" srcset="">
                    <img class="position-absolute crypto-stripe2" src="https://www.safepal.com/assets/img/crypto-stripe1.svg" alt="" srcset="">
                </div>
            </div>
        </div>
    </section>
    <!-- ======== beyond crypto ========== -->
    <section id="beyond-crypto">
        <div class="container beyond-crypto">
            <div class="web3-fingertips d-flex justify-content-center flex-column flex-lg-row">
                <div class="d-lg-none top-image" data-aos="fade-up">
                    <img class="img-fluid" src="https://www.safepal.com/assets/img/beyond-crypto-top.svg" alt="" srcset="">
                </div>
                <div class="fingertips" data-aos="flip-left" data-aos-easing="ease-out-cubic" data-aos-duration="2000">
                    <h3 class="title">GO BEYOND CRYPTO.</h3>
                    <div class="text">
                        <p>We're bringing Web3 to your fingertips.</p>
                    </div>
                    <div class="text-describe">
                        <p><?= NAME ?> is your gateway to the rapidly expanding galaxy of decentralized applications. Our broad asset support and cross-chain compatibility make it easy to do everything from buying and selling NFTs to blockchain gaming to liquidity mining, all from the safety of your crypto wallet.</p>
                    </div>
                    <!--                    <div class="get-started">-->
                    <!--                        <a href="#"> <button class="get-started-btn">Get Started</button></a>-->
                    <!--                    </div>-->
                </div>
                <div class="position-relative d-none d-lg-block image">
                    <img class="absolute animate__animated animate__backInDown bottom-shadow" style="bottom: 0;"
                        src="https://www.safepal.com/assets/img/beyond-crypto/icon-bottom-shadow.svg" alt="" srcset="">
                    <img class="absolute animate__animated animate__backInDown lower-half" style="bottom: 18%;left:8%;z-index:3"
                        src="https://www.safepal.com/assets/img/beyond-crypto/icon-lower-half.svg" alt="" srcset="">
                    <img class="absolute animate__animated animate__backInDown lower-half"
                        style="bottom: 42.4%;left: 39.3%;z-index: 2;max-width: 104px;" src="https://www.safepal.com/assets/img/beyond-crypto/icon-bitcoin-coin.svg" alt=""
                        srcset="">
                    <img class="absolute animate__animated animate__backInDown lower-half"
                        style="bottom: 48%;left:6%;z-index: 2;" src="https://www.safepal.com/assets/img/beyond-crypto/icon-upper-half.svg" alt=""
                        srcset="">
                    <img class="absolute animate__animated animate__backInDown lower-half" style="bottom: 48.1%;left:21%;"
                        src="https://www.safepal.com/assets/img/beyond-crypto/icon-upper-half-decorate.svg" alt="" srcset="">
                    <img class="absolute animate__animated animate__backInDown lower-half"
                        style="left:34.9%;top: -12.2%;z-index: 3;" src="https://www.safepal.com/assets/img/beyond-crypto/icon-lower-half-decorate.svg"
                        alt="" srcset="">
                    <img class="absolute animate__animated animate__backInDown lower-half"
                        style="left: 23.2%;top: 35%;z-index: 1;"
                        src="https://www.safepal.com/assets/img/beyond-crypto/icon-lower-half-decorate-inner.svg" alt="" srcset="">
                    <img class="absolute animate__animated animate__backInDown token-animation"
                        style="left:73%;top: -12%;z-index:2;" src="https://www.safepal.com/assets/img/beyond-crypto/icon-xrp-coin.svg" alt="" srcset="">
                    <img class="absolute animate__animated animate__backInDown token-animation"
                        style="right: -4.7%;top: 41%;z-index: 3;max-width: 79.3px;" src="https://www.safepal.com/assets/img/beyond-crypto/icon-bnb-coin.svg" alt=""
                        srcset="">
                    <img class="absolute animate__animated animate__backInDown token-animation"
                        style="top:60%;left:24%;z-index:3;max-width: 78.7px;" src="https://www.safepal.com/assets/img/beyond-crypto/icon-sfp-token.svg" alt="" srcset="">
                    <img class="absolute animate__animated animate__backInDown token-animation" style="top:31%;left:-2%;max-width: 65px;"
                        src="https://www.safepal.com/assets/img/beyond-crypto/icon-eth-coin.svg" alt="" srcset="">
                    <img class="absolute animate__animated animate__backInDown clound-animation" style="bottom:10%;right:-28%;"
                        src="https://www.safepal.com/assets/img/beyond-crypto/icon-clound.svg" alt="" srcset="">
                    <img class="absolute animate__animated animate__backInDown clound-animation"
                        style="bottom:10.4%;right:83.1%;" src="https://www.safepal.com/assets/img/beyond-crypto/icon-clound-2.svg" alt="" srcset="">
                    <img class="absolute animate__animated animate__backInDown clound-animation" style="top:-9%;left:13%;"
                        src="https://www.safepal.com/assets/img/beyond-crypto/icon-clound-3.svg" alt="" srcset="">
                </div>
            </div>
            <div class="feature">
                <div class="row feature-box d-flex justify-content-center align-items-center" data-aos="fade-up">
                    <div class="feature-item col-lg-4 col-md-12 col-sm-12">
                        <div class="top">
                            <img class="img-fluid" src="https://www.safepal.com/assets/img/beyond-crypto/icon-feature-1.svg" alt="">
                        </div>
                        <div class="text">
                            <p>Discover & seamlessly interact with hundreds of DApp.</p>
                        </div>
                    </div>
                    <div class="feature-item col-lg-4 col-md-12 col-sm-12">
                        <div class="top">
                            <img class="img-fluid" src="https://www.safepal.com/assets/img/beyond-crypto/icon-feature-2.svg" alt="">
                        </div>
                        <div class="text">
                            <p>Buy, collect and sell NFTs across marketplaces & on any device.</p>
                        </div>
                    </div>
                    <div class="feature-item col-lg-4 col-md-12 col-sm-12">
                        <div class="top">
                            <img class="img-fluid" src="https://www.safepal.com/assets/img/beyond-crypto/icon-feature-3.svg" alt="">
                        </div>
                        <div class="text">
                            <p>Try uncharted DeFi projects with ease & peace of mind.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section id="stand-out">
        <div class="d-flex justify-content-start align-items-center flex-column stand-out">
            <div class="position-relative container title pc-star">
                <!-- mobile - star -1 -->
                <div class="d-lg-none m-star m-star-1">
                    <div class="position-relative star-1 star-move">
                        <div class="star1-point">
                            <img class="img-fluid" src="https://www.safepal.com/assets/img/icon-point.svg" alt="" srcset="">
                        </div>
                        <div class="star">
                            <img class="img-fluid" src="https://www.safepal.com/assets/img/icon-start-fill.svg" alt="" srcset="">
                        </div>
                    </div>
                </div>
                <h3 class="title-top">Explore what makes <?= NAME ?> stand out.</h3>
                <!-- pc- star - start -->
                <div class="absolute d-none d-lg-block start-1">
                    <div class="start1-point">
                        <img class="" src="https://www.safepal.com/assets/img/icon-point.svg" alt="" srcset="">
                    </div>
                    <div class="start">
                        <img class="" src="https://www.safepal.com/assets/img/icon-start-fill.svg" alt="" srcset="">
                    </div>
                </div>
                <div class="absolute d-none d-lg-block start-2">
                    <div class="start2-point"><img class="" src="https://www.safepal.com/assets/img/icon-point.svg" alt="" srcset=""></div>
                    <div class="start">
                        <img class="" src="https://www.safepal.com/assets/img/icon-start-empty.svg" alt="" srcset="">
                    </div>
                </div>
                <!-- pc- star - end -->
                <!-- mobile - star -2 -->
                <div class="d-lg-none m-star m-star-2">
                    <div class="position-relative star-2">
                        <div class="star2-point"><img class="img-fluid" src="https://www.safepal.com/assets/img/icon-point.svg" alt="" srcset=""></div>
                        <div class="star">
                            <img class="img-fluid" src="https://www.safepal.com/assets/img/icon-start-empty.svg" alt="" srcset="">
                        </div>
                    </div>
                </div>
            </div>
            <div class="container enumera enumera-mobile">
                <div class="enumera-mobile-list swiper">
                    <div class="swiper-wrapper align-items-center">
                        <div class="swiper-slide enumera-item">
                            <div class="d-flex justify-content-center align-items-center top">
                                <img class="img-fluid" src="https://www.safepal.com/assets/img/enumera/icon-enumera-1.svg" alt="">
                            </div>
                            <div class="bottom">
                                <div class="title">
                                    <h3>User-friendly</h3>
                                </div>
                                <div class="text">
                                    <p>We're leading the change for better crypto UX. Our wallets are fast, intuitive to use, and all managed from one easy app.</p>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide enumera-item">
                            <div class="d-flex justify-content-center align-items-center top">
                                <img class="img-fluid" src="https://www.safepal.com/assets/img/enumera/icon-enumera-2.svg" alt="">
                            </div>
                            <div class="bottom">
                                <div class="title">
                                    <h3>Your keys, your crypto</h3>
                                </div>
                                <div class="text">
                                    <p>Safety is our top concern. Your private keys never leave your non-custodial wallet so no one else has access to them, ever. That includes us.</p>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide enumera-item">
                            <div class="d-flex justify-content-center align-items-center top">
                                <img class="img-fluid" src="https://www.safepal.com/assets/img/enumera/icon-enumera-3.svg" alt="">
                            </div>
                            <div class="bottom">
                                <div class="title">
                                    <h3>Cross-platform</h3>
                                </div>
                                <div class="text">
                                    <p><?= NAME ?> Wallet is available as a software mobile wallet on iOS, Google Play and Android, and most recently as an extension for Chrome, Firefox, and Microsoft Edge.</p>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide enumera-item">
                            <div class="d-flex justify-content-center align-items-center top">
                                <img class="img-fluid" src="https://www.safepal.com/assets/img/enumera/icon-enumera-4.svg" alt="">
                            </div>
                            <div class="bottom">
                                <div class="title">
                                    <h3>Community-powered</h3>
                                </div>
                                <div class="text">
                                    <p>We turn feedback into tangible improvement, working tirelessly to build updates and products that serve our users' needs.</p>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide enumera-item">
                            <div class="d-flex justify-content-center align-items-center top">
                                <img class="img-fluid" src="https://www.safepal.com/assets/img/enumera/icon-enumera-5.svg" alt="">
                            </div>
                            <div class="bottom">
                                <div class="title">
                                    <h3>DeFi, demystified</h3>
                                </div>
                                <div class="text">
                                    <p>We're taking the decentralized world mainstream with innovative wallet solutions that simplify crypto onboarding – and even make it fun.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="enumera-mobile-pagination"></div>
                </div>
                <!-- <div class="d-flex justify-content-between align-items-center navigation-box">
                    <button class="button-prev">&lt;</button>
                    <button class="button-next">&gt;</button>
                </div> -->

            </div>
            <div class="container enumera enumera-pc" data-aos="fade-up">
                <div class="enumera-top d-flex justify-content-center align-items-start">
                    <div class="enumera-item" data-aos="zoom-out-up">
                        <div class="d-flex justify-content-center align-items-end top">
                            <img class="img-fluid enumera-img enumera-1"
                                src="https://www.safepal.com/assets/img/enumera/icon-enumera-1.svg" alt="">
                        </div>
                        <div class="bottom">
                            <div class="title">
                                <h3>User-friendly</h3>
                            </div>
                            <div class="text">
                                <p>We're leading the change for better crypto UX. Our wallets are fast, intuitive to use, and all managed from one easy app.</p>
                            </div>
                        </div>
                    </div>
                    <div class="enumera-item" data-aos="zoom-out-up">
                        <div class="d-flex justify-content-center align-items-end top">
                            <img class="img-fluid enumera-img enumera-2"
                                src="https://www.safepal.com/assets/img/enumera/icon-enumera-2.svg" alt="">
                        </div>
                        <div class="bottom">
                            <div class="title">
                                <h3>Your keys, your crypto</h3>
                            </div>
                            <div class="text">
                                <p>Safety is our top concern. Your private keys never leave your non-custodial wallet so no one else has access to them, ever. That includes us.</p>
                            </div>
                        </div>
                    </div>
                    <div class="enumera-item" data-aos="zoom-out-up">
                        <div class="d-flex justify-content-center align-items-end top">
                            <img class="img-fluid enumera-img enumera-3"
                                src="https://www.safepal.com/assets/img/enumera/icon-enumera-3.svg" alt="">
                        </div>
                        <div class="bottom">
                            <div class="title">
                                <h3>Cross-platform</h3>
                            </div>
                            <div class="text">
                                <p><?= NAME ?> Wallet is available as a software mobile wallet on iOS, Google Play and Android, and most recently as an extension for Chrome, Firefox, and Microsoft Edge.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="enumera-bottom d-flex justify-content-center align-items-start">
                    <div class="enumera-item" data-aos="zoom-out-up">
                        <div class="d-flex justify-content-center align-items-end top">
                            <img class="img-fluid enumera-img enumera-4"
                                src="https://www.safepal.com/assets/img/enumera/icon-enumera-4.svg" alt="">
                        </div>
                        <div class="bottom">
                            <div class="title">
                                <h3>Community-powered</h3>
                            </div>
                            <div class="text">
                                <p>We turn feedback into tangible improvement, working tirelessly to build updates and products that serve our users' needs.</p>
                            </div>
                        </div>
                    </div>
                    <div class="enumera-item" data-aos="zoom-out-up">
                        <div class="d-flex justify-content-center align-items-end top">
                            <img class="img-fluid enumera-img enumera-5"
                                src="https://www.safepal.com/assets/img/enumera/icon-enumera-5.svg" alt="">
                        </div>
                        <div class="bottom">
                            <div class="title">
                                <h3>DeFi, demystified</h3>
                            </div>
                            <div class="text">
                                <p>We're taking the decentralized world mainstream with innovative wallet solutions that simplify crypto onboarding – and even make it fun.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="download-safepay-image-box">


                <div class="container download-safepay d-flex justify-content-center align-items-center flex-column"
                    data-aos="fade-up">

                    <div class="top" style="margin:0;">
                        <a href="store.html" rel="noopener noreferrer"><button class="top-btn transparent-light-green">Buy <?= NAME ?> Products</button></a>
                    </div>
                    <!-- <div class="bottom">
                        <a class="d-inline-block link-a" href="https://www.safepal.com/en/store/s1" target="_blank" rel="noopener noreferrer">Learn About <?= NAME ?> S1</a>
                    </div> -->
                </div>
                <div class="position-relative d-flex justify-content-center align-items-center image-box">
                    <div class="container text-center image">
                        <img class="img-fluid standout-img-center" src="https://www.safepal.com/assets/img/stand-out-img-center.svg" alt="" srcset="">
                        <img class="absolute img-fluid move-animation-Y" style="left: 50%;top: 22px;margin-left: -720px;"
                            src="https://www.safepal.com/assets/img/stand-out-img-locked.svg" alt="" srcset="">
                        <img class="absolute img-fluid" style="bottom: 270px;left: 50%;margin-left: -627px;"
                            src="https://www.safepal.com/assets/img/stand-out-img-icon-group.svg" alt="">
                        <img class="absolute img-fluid move-animation-Y" style="top: 123px;left: 50%;margin-left: -427px; animation-duration: 7s;"
                            src="https://www.safepal.com/assets/img/stand-out-img-eth.svg" alt="">
                        <img class="absolute img-fluid move-animation-Y" style="top: 22px;right: 50%;margin-right: -720px; animation-duration: 5s;"
                            src="https://www.safepal.com/assets/img/stand-out-img-clound.svg" alt="">
                        <img class="absolute img-fluid" style="top: 360px;right: 50%;margin-right: -860px;"
                            src="https://www.safepal.com/assets/img/stand-out-img-eth-group.svg" alt="">
                        <img class="absolute img-fluid move-animation-Y" style="bottom: 180px;right: 50%;margin-right: -630px; animation-duration: 8s;"
                            src="https://www.safepal.com/assets/img/stand-out-img-btc.svg" alt="">
                    </div>
                </div>
            </div>
            <div class="container education d-flex justify-content-center align-items-center flex-column"
                data-aos="zoom-in-up">
                <div class="title education-item">
                    <h3>Nothing keeps you safer than a solid crypto education.</h3>
                </div>
                <div class="describe education-item">
                    <p>We're here to help, not gatekeep. Our beginners' guides will fast-track you through the basics so that you can approach trading and investing with confidence and skill.</p>
                </div>
                <div class="learn-more">
                    <a href="blog/academy.html"><button class="learn-more-btn btn-light-green">Learn More</button></a>
                </div>
            </div>
        </div>
    </section>
</main><!-- End #main -->
<div class="one-wallet-footer home-footer">
    <div class="one-wallet-footer-main">
        <!-- ======== trusted ========= -->
        <section id="trusted">
            <div class="trusted-content">
                <div class="position-relative pc-star title" data-aos="zoom-in">
                    <!-- mobile - star -1 -->
                    <div class="d-lg-none m-star m-star-1">
                        <div class="position-relative star-1 star-move">
                            <div class="star1-point">
                                <img class="img-fluid" src="https://www.safepal.com/assets/img/icon-point.svg" alt="" srcset="">
                            </div>
                            <div class="star">
                                <img class="img-fluid" src="https://www.safepal.com/assets/img/icon-start-fill.svg" alt="" srcset="">
                            </div>
                        </div>
                    </div>
                    <h3 class="top-title">Trusted by millions.</h3>
                    <!-- pc- star - start -->
                    <div class="absolute d-none d-lg-block start-1">
                        <div class="start1-point">
                            <img class="" src="https://www.safepal.com/assets/img/icon-point.svg" alt="" srcset="">
                        </div>
                        <div class="start">
                            <img class="" src="https://www.safepal.com/assets/img/icon-start-fill.svg" alt="" srcset="">
                        </div>
                    </div>
                    <div class="absolute d-none d-lg-block start-2">
                        <div class="start2-point"><img class="" src="https://www.safepal.com/assets/img/icon-point.svg" alt="" srcset=""></div>
                        <div class="start">
                            <img class="" src="https://www.safepal.com/assets/img/icon-start-empty.svg" alt="" srcset="">
                        </div>
                    </div>
                    <!-- pc- star - end -->
                    <!-- mobile - star -2 -->
                    <div class="d-lg-none m-star m-star-2">
                        <div class="position-relative star-2">
                            <div class="star2-point"><img class="img-fluid" src="https://www.safepal.com/assets/img/icon-point.svg" alt="" srcset="">
                            </div>
                            <div class="star">
                                <img class="img-fluid" src="https://www.safepal.com/assets/img/icon-start-fill.svg" alt="" srcset="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content-box" data-aos="zoom-in" data-aos-id="trusted-swiper" data-aos-once="true">
                    <div class="trusted-list trusted-slider swiper">
                        <div id="trusted-swiper-wrapper" class="swiper-wrapper align-items-stretch">
                            <div class="swiper-slide trusted-item">
                                <div class="describe">
                                    <p><?= NAME ?> is a successful company incubated from the first Binance Labs Incubation Program. The team has strong cumulation in both technology and products and shows tenacity when the market is in the downturn. Veronica is a female CEO that has successfully built a mass-scale web3 product. I'm very impressed by her and the whole team.</p>
                                </div>
                                <div class="character-info d-flex justify-content-start align-items-center">
                                    <div class="avatar">
                                        <img class="img-fluid" src="../assets/img/trusted-avatar-HeYi3860.png?v=1" alt="" srcset="">
                                    </div>
                                    <div class="info">
                                        <h3 class="name">He Yi</h3>
                                        <div class="work">Binance Co-founder & CMO</div>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide trusted-item">
                                <div class="describe">
                                    <p>Notably, <?= NAME ?> allows for buying and swapping within the <?= NAME ?> App, hooks into CEX like Binance, and provides powerful DApp support for DeFi with Uniswap and Compound. Perfect for DeFi traders.</p>
                                </div>
                                <div class="character-info d-flex justify-content-start align-items-center">
                                    <div class="avatar">
                                        <img class="img-fluid" src="../assets/img/trusted-avatar-Forbes3860.png?v=1" alt="" srcset="">
                                    </div>
                                    <div class="info">
                                        <h3 class="name">Forbes</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide trusted-item">
                                <div class="describe">
                                    <p>It's rare to see a company like <?= NAME ?> that provides such comprehensive products and service offerings in one place. It is truly the only wallet you need.</p>
                                </div>
                                <div class="character-info d-flex justify-content-start align-items-center">
                                    <div class="avatar">
                                        <img class="img-fluid" src="../assets/img/trusted-avatar-EricChen3860.png?v=1" alt="" srcset="">
                                    </div>
                                    <div class="info">
                                        <h3 class="name">Eric Chen</h3>
                                        <div class="work">Founder of Injective Protocol</div>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide trusted-item">
                                <div class="describe">
                                    <p>I'm a <?= NAME ?> user myself and I'm often impressed by the rapid product iterations the <?= NAME ?> team has been delivering and the well-thought UX design that is built into every product details. It is one of the best crypto wallets and you should definitely consider getting one.</p>
                                </div>
                                <div class="character-info d-flex justify-content-start align-items-center">
                                    <div class="avatar">
                                        <img class="img-fluid" src="../assets/img/Terry.png" alt="" srcset="">
                                    </div>
                                    <div class="info">
                                        <h3 class="name">Terry Tai</h3>
                                        <div class="work">Co-founder of Nervos</div>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide trusted-item">
                                <div class="describe">
                                    <p><?= NAME ?> has built a wallet that combines advanced security and seamless user experience together. It has truly lowered the hurdle of users onboarding to DeFi, NFT and the whole Web3 ecosystem.</p>
                                </div>
                                <div class="character-info d-flex justify-content-start align-items-center">
                                    <div class="avatar">
                                        <img class="img-fluid" src="../assets/img/trusted-avatar-Yenwen3860.png?v=1" alt="" srcset="">
                                    </div>
                                    <div class="info">
                                        <h3 class="name">Yenwen</h3>
                                        <div class="work">Founder of Perpetual Protocol</div>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide trusted-item">
                                <div class="describe">
                                    <p>Your keys are safe on the device, because there is no bluetooth, no WiFi, and no NFC. There is no connection really happening.</p>
                                </div>
                                <div class="character-info d-flex justify-content-start align-items-center">
                                    <div class="avatar">
                                        <img class="img-fluid" src="../assets/img/trusted-avatar-Hashoshi3860.png?v=1" alt="" srcset="">
                                    </div>
                                    <div class="info">
                                        <h3 class="name">Hashoshi</h3>
                                        <div class="work">Crypto Expert</div>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide trusted-item">
                                <div class="describe">
                                    <p>You are good to go with a <?= NAME ?> S1 Hardware Wallet anywhere at anytime.</p>
                                </div>
                                <div class="character-info d-flex justify-content-start align-items-center">
                                    <div class="avatar">
                                        <img class="img-fluid" src="../assets/img/trusted-avatar-CryptoFiend3860.png?v=1" alt="" srcset="">
                                    </div>
                                    <div class="info">
                                        <h3 class="name">Crypto Fiend</h3>
                                        <div class="work">Crypto Expert</div>
                                    </div>
                                </div>
                            </div>

                            <div class="swiper-slide trusted-item">
                                <div class="describe">
                                    <p>This wallet is just the best one, you can access all DApp , trade on binance spot trading and manage a lot of differents blockchains, all tokens erc20 , Bep, TRC xlm and neo tokens are availables. So good, i think its the most secure hardware wallet with the qrcode scanning option to broadcast transactions. The private key still offline and no connection required ! Thanks this is an amazing product !</p>
                                </div>
                                <div class="character-info d-flex justify-content-start align-items-center">
                                    <div class="avatar">
                                        <img class="img-fluid" src="../assets/img/trusted-avatar-Mat3860.png?v=1" alt="" srcset="">
                                    </div>
                                    <div class="info">
                                        <h3 class="name">Mat</h3>
                                        <div class="work"><?= NAME ?> User</div>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide trusted-item">
                                <div class="describe">
                                    <p>The box came in sealed, the unit was shipped directly from <?= NAME ?> and I know that from the shipping label.This is an amazing value for the money easy to use, before you send your crypto into it making sure it use it and reset it a few time to make sure that the 12 phrases you wrote down were correct and your passcodes are all working as it should.The mobile app is amazing and it really gives you the power of decentralization and privacy and security.</p>
                                </div>
                                <div class="character-info d-flex justify-content-start align-items-center">
                                    <div class="avatar">
                                        <img class="img-fluid" src="../assets/img/trusted-avatar-NourHalawani3860.png?v=1" alt="" srcset="">
                                    </div>
                                    <div class="info">
                                        <h3 class="name">Nour Halawani</h3>
                                        <div class="work"><?= NAME ?> User</div>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide trusted-item">
                                <div class="describe">
                                    <p><?= NAME ?> S1 is exactly the wallet that every crypto owner should have!It's slim, have a clean design, good brightness to the front screen with good resolution, good camera at the back and without forgetting the safety of the system! I'll recommend it to everyone!</p>
                                </div>
                                <div class="character-info d-flex justify-content-start align-items-center">
                                    <div class="avatar">
                                        <img class="img-fluid" src="../assets/img/trusted-avatar-OlivierL3860.png?v=1" alt="" srcset="">
                                    </div>
                                    <div class="info">
                                        <h3 class="name">Olivier.L</h3>
                                        <div class="work"><?= NAME ?> User</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-lg-none swiper-pagination-trusted"></div>
                    </div>
                </div>
            </div>
        </section>
        <!-- ================= ---------one - wallet--------- ===================== -->
        <section id="one-wallet">
            <div class="one-wallet d-flex justify-content-center align-items-center flex-column">
                <div class="sfp-logo d-flex justify-content-center align-items-center">
                    <div class="logo-box move-animation-Y">
                        <img class="img-fluid" src="../assets/img/safePal-extension-icon.png" alt="">
                    </div>
                </div>
                <div class="title animate__animated animate__fadeInDown">
                    <h3>Everything you need in one wallet.</h3>
                </div>
                <div class="download">
                    <div class="btn-out set-off-btn animate__animated animate__pulse">
                        <div class="btn-inner set-off-btn animate__animated animate__pulse">
                            <a href="../dashboard/register.php"><button type="button" class="downloads-btn animate__animated animate__pulse light-green-effect">Register</button></a>
                        </div>
                    </div>

                </div>
            </div>
        </section>
        <!-- ==== Footer ======= -->
        <?php include 'assets/footer.php'; ?>