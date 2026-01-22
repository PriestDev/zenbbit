<?php
include 'assets/header.php';
?>

<!-- ======= Header ======= -->
<header id="header" class="fixed-top d-flex align-items-center header-transparent">
    <?php include 'assets/navbar.php'; ?>
</header><!-- End Header -->

<!-- Template Main CSS File -->
<link href="../assets/css/bank496d.css?v=202601151767855013676" rel="stylesheet">

<!-- Dashboard Theme Colors -->
<style>
    :root {
        --primary-color: #622faa;
        --dark-bg: #121212;
        --dark-card: #1e1e1e;
        --light-bg: #fff;
        --light-card: #f8f9fa;
        --accent-green: #00c985;
        --text-dark: #fff;
        --text-light: #333;
        --text-secondary: #e0e0e0;
        --border-dark: #333;
        --border-light: #ddd;
    }

    body {
        background: var(--dark-bg) !important;
        color: var(--text-dark) !important;
    }

    body.light-mode {
        background: var(--light-bg) !important;
        color: var(--text-light) !important;
    }

    /* Main Content Styling */
    .bank {
        background: var(--dark-bg);
    }

    body.light-mode .bank {
        background: var(--light-bg);
        color: var(--text-light);
    }

    /* Sections */
    .hero, .multiple-item-bg, .accordion-box, #source {
        background: var(--dark-bg);
    }

    body.light-mode .hero,
    body.light-mode .multiple-item-bg,
    body.light-mode .accordion-box,
    body.light-mode #source {
        background: var(--light-bg);
    }

    /* Text Colors */
    .hero h3, .hero .title,
    .multiple-item-bg .title,
    .accordion-box .title h3 {
        color: var(--text-dark) !important;
    }

    body.light-mode .hero h3,
    body.light-mode .hero .title,
    body.light-mode .multiple-item-bg .title,
    body.light-mode .accordion-box .title h3 {
        color: var(--text-light) !important;
    }

    .hero p, .item-text p,
    .describe-item-text,
    .accordion-body {
        color: var(--text-secondary) !important;
    }

    body.light-mode .hero p,
    body.light-mode .item-text p,
    body.light-mode .describe-item-text,
    body.light-mode .accordion-body {
        color: #666 !important;
    }

    /* Links and Buttons */
    .downloads-btn, .btn-common,
    .accordion-button {
        background: var(--primary-color) !important;
        color: #fff !important;
        border: 1px solid var(--primary-color) !important;
        transition: all 0.3s ease !important;
    }

    .downloads-btn:hover, .btn-common:hover,
    .accordion-button:not(.collapsed) {
        background: #8c3fca !important;
        border-color: #8c3fca !important;
    }

    a.a-tag {
        color: var(--primary-color) !important;
        text-decoration: underline !important;
    }

    a.a-tag:hover {
        color: #8c3fca !important;
    }

    /* Dividers and Borders */
    .brandoverview-swiper, .accordion-item {
        border-color: var(--border-dark) !important;
    }

    body.light-mode .brandoverview-swiper,
    body.light-mode .accordion-item {
        border-color: var(--border-light) !important;
    }

    .accordion-item {
        background: transparent;
        border: 1px solid var(--border-dark) !important;
    }

    body.light-mode .accordion-item {
        background: transparent;
        border: 1px solid var(--border-light) !important;
    }

    .accordion-button {
        color: var(--text-dark) !important;
        background: transparent !important;
        border: none !important;
    }

    .accordion-button:focus {
        box-shadow: none !important;
        background: transparent !important;
    }

    body.light-mode .accordion-button {
        color: var(--text-light) !important;
    }

    /* SVG Icons - Primary Color */
    svg path, svg circle {
        stroke: var(--primary-color) !important;
    }

    /* Card Backgrounds */
    .item-box {
        background: transparent;
    }

    .item-text {
        background: var(--dark-card);
        border-radius: 8px;
        padding: 20px;
    }

    body.light-mode .item-text {
        background: var(--light-card);
        border: 1px solid var(--border-light);
    }

    /* Limited Offer Section */
    #limited-offer {
        background: var(--dark-card) !important;
    }

    body.light-mode #limited-offer {
        background: var(--light-card) !important;
    }

    #limited-offer .title, #limited-offer .title-text {
        color: var(--text-dark) !important;
    }

    body.light-mode #limited-offer .title,
    body.light-mode #limited-offer .title-text {
        color: var(--text-light) !important;
    }

    #limited-offer .describe-item-text {
        color: var(--text-secondary) !important;
    }

    body.light-mode #limited-offer .describe-item-text {
        color: #666 !important;
    }

    /* FAQ Section */
    .accordion-box {
        background: var(--dark-bg);
    }

    body.light-mode .accordion-box {
        background: var(--light-bg);
    }

    /* Source/Footer Text */
    #source p {
        color: var(--text-secondary) !important;
    }

    body.light-mode #source p {
        color: #666 !important;
    }

    #source a.a-tag {
        color: var(--primary-color) !important;
    }

    /* One Wallet Section */
    .one-wallet {
        background: var(--dark-bg);
    }

    body.light-mode .one-wallet {
        background: var(--light-bg);
    }

    .one-wallet .title h3 {
        color: var(--text-dark) !important;
    }

    body.light-mode .one-wallet .title h3 {
        color: var(--text-light) !important;
    }
</style>

<main id="main" class="bank">
    <div id="brandoverview" class="brandoverview-swiper swiper d-none d-lg-block">
        <div class="swiper-wrapper align-items-center">
            <!-- <div class="swiper-slide">Enjoy Zero Fees: Users who open a <?= NAME ?> Banking Gateway account will now enjoy zero deposit and on-ramp fees. <a target="_blank" href="https://www.safepal.com/en/blog/safepal-launches-zero-fee-banking-campaign" style="margin-left:6px;text-decoration: underline;color: #79EFBD;">Learn more</a></div> -->
            <div class="swiper-slide">Users who open a <?= NAME ?> Banking Gateway account will now enjoy zero deposit and on-ramp fees. <a target="_blank" href="blog/safepal-launches-zero-fee-banking-campaign.html" style="margin-left:6px;text-decoration: underline;color: #ffffff;">Learn more</a></div>
        </div>
    </div>
    <section id="hero" class="position-relative">
        <div class="hero">
            <div id="brandoverview" class="brandoverview-swiper-m swiper d-lg-none">
                <div class="swiper-wrapper align-items-center">
                    <div class="swiper-slide">Users who open a <?= NAME ?> Banking Gateway account will now enjoy zero deposit and on-ramp fees. <a target="_blank" href="blog/safepal-launches-zero-fee-banking-campaign.html" style="margin-left:6px;text-decoration: underline;color: #ffffff;">Learn more</a></div>
                </div>
            </div>
            <div class="hero-bg">
                <div class="container position-relative hero-container d-flex flex-column flex-lg-row">
                    <div class="left" data-aos="fade-up">
                        <p class="sub-title"><?= NAME ?> Banking Gateway</p>
                        <h3 class="title">Own Your First Crypto-friendly Swiss IBAN Account Today</h3>
                        <p class="text d-none d-lg-block">Open an account in the <?= NAME ?> App</p>
                        <p class="text d-lg-none">Download <?= NAME ?> App to open an account:</p>
                        <div class="download d-none d-lg-block">
                            <div class="btn-out set-off-btn animate__animated animate__pulse">
                                <div class="btn-inner set-off-btn animate__animated animate__pulse">
                                    <a href="../dashboard/">
                                        <button
                                            type="button"
                                            class="downloads-btn animate__animated animate__pulse light-green-effect">
                                            Register </button></a>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <div class="right" data-aos="fade-up">
                        <!-- <img class="img-fluid" src="/assets/img/bank/banking_gateway.png" alt="" srcset=""> -->
                        <!-- <img class="img-fluid d-none d-lg-block" src="/assets/img/bank/banking_gateway.png" alt="" srcset=""> -->
                        <!-- <img class="img-fluid d-lg-none" src="/assets/img/bank/banking_gateway_m.png" alt="" srcset=""> -->
                        <img class="img-fluid d-none d-lg-block" src="../assets/img/bank/banking_gateway_en.png" alt="" onerror="handleImageError(this, `/assets/img/bank/banking_gateway_en.png`)"> <img class="img-fluid d-lg-none" src="../assets/img/bank/banking_gateway_m_en.png" alt="" onerror="handleImageError(this, `/assets/img/bank/banking_gateway_m_en.png`)">
                    </div>

                    <img class="position-absolute hero-vector1 d-none d-lg-block"
                        src="https://www.safepal.com/assets/img/bank/hero-vector1.svg" alt="" srcset="">
                    <img class="position-absolute hero-vector2 d-none d-lg-block"
                        src="https://www.safepal.com/assets/img/bank/hero-vector2.svg" alt="" srcset="">
                    <img class="position-absolute hero-ellipse d-none d-lg-block"
                        src="https://www.safepal.com/assets/img/bank/hero-ellipse.svg" alt="" srcset="">
                    <img class="position-absolute hero-card d-none d-lg-block"
                        src="https://www.safepal.com/assets/img/bank/hero-card.svg" alt="" srcset="">

                    <img class="position-absolute hero-vector1 d-lg-none"
                        src="https://www.safepal.com/assets/img/bank/hero-vector1-m.svg" alt="" srcset="">
                    <img class="position-absolute hero-vector2 d-lg-none"
                        src="https://www.safepal.com/assets/img/bank/hero-vector2-m.svg" alt="" srcset="">
                    <img class="position-absolute hero-card d-lg-none"
                        src="https://www.safepal.com/assets/img/bank/hero-card-m.svg" alt="" srcset="">
                </div>
            </div>
        </div>
    </section>
    <section id="limited-offer">
        <div class="limited-offer-bg">
            <div class="position-relative max-width-1920">
                <div class="container limited-offer-contnet">
                    <div class="d-flex item-box" data-aos="fade-up">
                        <div class="order-lg-1 order-md-0 order-sm-0 item-text item-text-2">
                            <div class="title d-flex">
                                <div class="d-lg-none title-icon">
                                    <img class="img-fluid" src="../assets/img/bank/limited-offer-1.png" alt="">
                                </div>
                                <div class="title-text">Enjoy Zero Fees!</div>
                            </div>
                            <div class="describe">
                                <div class="describe-item d-flex">
                                    <p class="describe-item-text">
                                        Users who open a <?= NAME ?> Banking Gateway account will now enjoy zero deposit and on-ramp fees. <a target="_blank" href="blog/safepal-launches-zero-fee-banking-campaign.html" style="margin-left:6px;text-decoration: underline;color: #ffffff;">Learn more</a> </p>
                                   
                                </div>
                            </div>
                        </div>
                        <div class="item-img">
                            <img class="img-fluid d-none d-lg-block" src="../assets/img/bank/limited-offer-1.png" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section id="multiple-item" class="multiple-item">
        <div class="multiple-item-bg">
            <div class="position-relative max-width-1920">
                <div class="container multiple-item-contnet">
                    <div class="d-flex item-box" data-aos="fade-up">
                        <div class="item-text item-text-1">
                            <div class="title d-flex">
                                <div class="title-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="41" height="41" viewBox="0 0 41 41" fill="none">
                                        <path d="M5.84681 23.6078C1.73498 19.2391 1.73498 12.1559 5.84681 7.78718C9.95863 3.41843 16.6252 3.41843 20.7371 7.78718C24.8489 3.41843 31.5155 3.41843 35.6273 7.78718C39.7391 12.1559 39.7391 19.2391 35.6273 23.6078L35.603 23.6335L22.9216 37.1073C21.7371 38.3659 19.737 38.3659 18.5524 37.1073L5.86733 23.6296C5.86048 23.6223 5.85364 23.6151 5.84681 23.6078Z" stroke="#4A21EF" stroke-width="3" stroke-linejoin="round" />
                                        <path d="M27.2554 15.4243L19.0923 23.5873L15.3818 19.8768" stroke="#4A21EF" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </div>
                                <div class="title-text">Onboard with peace of mind</div>
                            </div>
                            <div class="describe">
                                <div class="describe-item d-flex">
                                    <p class="describe-item-point">•</p>
                                    <p class="describe-item-text">Fully compliant Swiss IBAN account<sup>1</sup></p>
                                </div>
                                <div class="describe-item d-flex">
                                    <p class="describe-item-point">•</p>
                                    <p class="describe-item-text">Enjoy seamless and swift transfers between global bank accounts</p>
                                </div>
                                <div class="describe-item d-flex">
                                    <p class="describe-item-point">•</p>
                                    <p class="describe-item-text">Customize your spending limit for advanced security<sup>2</sup></p>
                                </div>
                            </div>
                        </div>
                        <div class="item-img item-img-1">
                            <img class="img-fluid" src="../assets/img/bank/multiple-item-1.png" alt="">
                        </div>
                    </div>
                    <div class="d-flex item-box" data-aos="fade-up">
                        <div class="order-lg-1 order-md-0 order-sm-0 item-text item-text-2">
                            <div class="title d-flex">
                                <div class="title-icon">
                                    <svg width="41" height="41" viewBox="0 0 41 41" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <g clip-path="url(#clip0_6008_30998)">
                                            <path d="M21.4394 4.71375C21.9896 4.1636 22.7645 3.90095 23.5358 4.0032L33.5251 5.32758C34.6451 5.47607 35.5263 6.3573 35.6748 7.47732L36.9992 17.4667C37.1015 18.2379 36.8388 19.0128 36.2887 19.563L18.7279 37.1238C17.7516 38.1001 16.1686 38.1001 15.1923 37.1238L3.87862 25.8101C2.90231 24.8338 2.90231 23.2509 3.87862 22.2746L21.4394 4.71375Z" stroke="#4A21EF" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M23.7337 23.0629L21.5327 19.5239C20.7723 18.3012 19.0122 17.7316 17.687 18.2794V18.2794C16.466 18.7842 16.063 20.0588 16.7687 21.1836L19.0247 24.7792" stroke="#4A21EF" stroke-width="3" stroke-linecap="round" />
                                            <path d="M18.7496 24.3567L19.5234 25.5463C20.2686 26.6918 19.8369 28.0131 18.5591 28.4977V28.4977C17.2581 28.991 15.5875 28.426 14.8624 27.2474L12.9316 24.1089" stroke="#4A21EF" stroke-width="3" stroke-linecap="round" />
                                            <line x1="13.5323" y1="28.182" x2="23.0831" y2="18.6313" stroke="#4A21EF" stroke-width="3" stroke-linecap="round" />
                                            <circle cx="28.8228" cy="12.1798" r="2.12137" transform="rotate(45 28.8228 12.1798)" fill="#4A21EF" />
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_6008_30998">
                                                <rect width="40" height="40" fill="white" transform="translate(0.616943 0.385498)" />
                                            </clipPath>
                                        </defs>
                                    </svg>
                                </div>
                                <div class="title-text">Lowest fees</div>
                            </div>
                            <div class="describe">
                                <div class="describe-item d-flex">
                                    <p class="describe-item-point">•</p>
                                    <p class="describe-item-text">Zero fees for account setup and management, as well as bank transfers<sup>3</sup></p>
                                </div>
                                <div class="describe-item d-flex">
                                    <p class="describe-item-point">•</p>
                                    <p class="describe-item-text">The most competitive crypto top-up fees, with rates as low as 0.4%<sup>4</sup></p>
                                </div>
                                <div class="describe-item d-flex">
                                    <p class="describe-item-point">•</p>
                                    <p class="describe-item-text">Transactions are made on the Arbitrum network, which has affordable gas fees<sup>5</sup></p>
                                </div>
                            </div>
                        </div>
                        <div class="item-img item-img-2">
                            <img class="img-fluid d-none d-lg-block" src="../assets/img/bank/multiple-item-2_en.png" alt="" onerror="handleImageError(this, `/assets/img/bank/multiple-item-2_en.png`)"> <img class="img-fluid d-lg-none" src="../assets/img/bank/multiple-item-2-m_en.png" alt="" onerror="handleImageError(this, `/assets/img/upgrade/assets/img/bank/multiple-item-2-m_en.png`)">
                        </div>
                    </div>
                    <div class="d-flex item-box" data-aos="fade-up">
                        <div class="item-text item-text-3">
                            <div class="title d-flex">
                                <div class="title-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="41" height="41" viewBox="0 0 41 41" fill="none">
                                        <path d="M23.7576 2.73486L25.2464 2.5522C25.1541 1.80005 24.5153 1.23486 23.7576 1.23486V2.73486ZM17.7165 2.73486V1.23486C16.9587 1.23486 16.3199 1.80005 16.2276 2.5522L17.7165 2.73486ZM24.2943 7.10984L22.8055 7.2925C22.8797 7.89717 23.3122 8.39692 23.9 8.55708L24.2943 7.10984ZM27.4304 8.40996L26.6855 9.71193C27.2145 10.0145 27.8739 9.9671 28.354 9.59189L27.4304 8.40996ZM30.9045 5.69521L31.9651 4.63455C31.4293 4.09871 30.578 4.04668 29.9809 4.51328L30.9045 5.69521ZM35.1762 9.96689L36.3581 10.8905C36.8247 10.2934 36.7726 9.44207 36.2368 8.90623L35.1762 9.96689ZM32.4614 13.4409L31.2795 12.5173C30.9043 12.9975 30.8568 13.6569 31.1594 14.1858L32.4614 13.4409ZM33.7615 16.5771L32.3143 16.9714C32.4745 17.5592 32.9742 17.9917 33.5789 18.0659L33.7615 16.5771ZM38.1365 17.1138H39.6365C39.6365 16.356 39.0713 15.7173 38.3192 15.625L38.1365 17.1138ZM38.1365 23.1549L38.3192 24.6437C39.0713 24.5514 39.6365 23.9127 39.6365 23.1549H38.1365ZM33.7616 23.6916L33.5789 22.2028C32.9742 22.277 32.4745 22.7095 32.3143 23.2973L33.7616 23.6916ZM32.4614 26.8278L31.1594 26.0829C30.8568 26.6118 30.9043 27.2712 31.2795 27.7514L32.4614 26.8278ZM35.1762 30.3018L36.2368 31.3625C36.7727 30.8266 36.8247 29.9753 36.3581 29.3782L35.1762 30.3018ZM30.9045 34.5735L29.9809 35.7554C30.578 36.222 31.4293 36.17 31.9651 35.6342L30.9045 34.5735ZM27.4304 31.8587L28.354 30.6768C27.8739 30.3016 27.2145 30.2542 26.6855 30.5568L27.4304 31.8587ZM24.2943 33.1589L23.9 31.7116C23.3122 31.8718 22.8797 32.3715 22.8055 32.9762L24.2943 33.1589ZM23.7576 37.5338V39.0338C24.5153 39.0338 25.1541 38.4687 25.2464 37.7165L23.7576 37.5338ZM17.7165 37.5338L16.2276 37.7165C16.3199 38.4687 16.9587 39.0338 17.7165 39.0338V37.5338ZM17.1797 33.1588L18.6686 32.9762C18.5944 32.3715 18.1618 31.8718 17.5741 31.7116L17.1797 33.1588ZM14.0436 31.8587L14.7885 30.5568C14.2596 30.2541 13.6002 30.3016 13.12 30.6768L14.0436 31.8587ZM10.5696 34.5735L9.5089 35.6341C10.0447 36.17 10.8961 36.222 11.4932 35.7554L10.5696 34.5735ZM6.29788 30.3018L5.11595 29.3782C4.64935 29.9753 4.70138 30.8266 5.23722 31.3625L6.29788 30.3018ZM9.01265 26.8277L10.1946 27.7513C10.5698 27.2712 10.6172 26.6118 10.3146 26.0828L9.01265 26.8277ZM7.71255 23.6916L9.15978 23.2973C8.99962 22.7095 8.49988 22.277 7.89521 22.2028L7.71255 23.6916ZM3.33752 23.1549H1.83752C1.83752 23.9127 2.40272 24.5514 3.15486 24.6437L3.33752 23.1549ZM3.33752 17.1138L3.15486 15.625C2.40272 15.7173 1.83752 16.356 1.83752 17.1138H3.33752ZM7.71255 16.5771L7.89521 18.0659C8.49988 17.9917 8.99962 17.5592 9.15978 16.9714L7.71255 16.5771ZM9.01265 13.441L10.3146 14.1859C10.6172 13.6569 10.5698 12.9975 10.1946 12.5174L9.01265 13.441ZM6.29788 9.9669L5.23722 8.90624C4.70138 9.44207 4.64935 10.2934 5.11595 10.8905L6.29788 9.9669ZM10.5696 5.69522L11.4932 4.51329C10.8961 4.04669 10.0447 4.09872 9.5089 4.63456L10.5696 5.69522ZM14.0436 8.40998L13.12 9.59191C13.6002 9.96712 14.2596 10.0146 14.7885 9.71195L14.0436 8.40998ZM17.1797 7.10986L17.5741 8.55709C18.1618 8.39693 18.5944 7.89719 18.6686 7.29252L17.1797 7.10986ZM23.7576 1.23486H17.7165V4.23486H23.7576V1.23486ZM25.7831 6.92718L25.2464 2.5522L22.2687 2.91752L22.8055 7.2925L25.7831 6.92718ZM23.9 8.55708C24.8843 8.8253 25.8186 9.21594 26.6855 9.71193L28.1753 7.10799C27.0912 6.48772 25.9217 5.99858 24.6887 5.66261L23.9 8.55708ZM29.9809 4.51328L26.5068 7.22803L28.354 9.59189L31.8281 6.87714L29.9809 4.51328ZM36.2368 8.90623L31.9651 4.63455L29.8438 6.75587L34.1155 11.0275L36.2368 8.90623ZM33.6433 14.3645L36.3581 10.8905L33.9942 9.04328L31.2795 12.5173L33.6433 14.3645ZM31.1594 14.1858C31.6554 15.0528 32.0461 15.987 32.3143 16.9714L35.2088 16.1827C34.8728 14.9497 34.3837 13.7802 33.7634 12.696L31.1594 14.1858ZM38.3192 15.625L33.9442 15.0882L33.5789 18.0659L37.9538 18.6027L38.3192 15.625ZM39.6365 23.1549V17.1138H36.6365V23.1549H39.6365ZM33.9442 25.1805L38.3192 24.6437L37.9538 21.666L33.5789 22.2028L33.9442 25.1805ZM32.3143 23.2973C32.0461 24.2817 31.6554 25.216 31.1594 26.0829L33.7634 27.5727C34.3837 26.4885 34.8728 25.319 35.2088 24.086L32.3143 23.2973ZM36.3581 29.3782L33.6433 25.9042L31.2795 27.7514L33.9942 31.2254L36.3581 29.3782ZM31.9651 35.6342L36.2368 31.3625L34.1155 29.2412L29.8438 33.5128L31.9651 35.6342ZM26.5068 33.0407L29.9809 35.7554L31.8281 33.3916L28.354 30.6768L26.5068 33.0407ZM26.6855 30.5568C25.8186 31.0528 24.8843 31.4434 23.9 31.7116L24.6887 34.6061C25.9217 34.2701 27.0912 33.781 28.1753 33.1607L26.6855 30.5568ZM25.2464 37.7165L25.7831 33.3415L22.8055 32.9762L22.2687 37.3512L25.2464 37.7165ZM17.7165 39.0338H23.7576V36.0338H17.7165V39.0338ZM15.6909 33.3415L16.2276 37.7165L19.2053 37.3512L18.6686 32.9762L15.6909 33.3415ZM17.5741 31.7116C16.5897 31.4434 15.6554 31.0527 14.7885 30.5568L13.2987 33.1607C14.3829 33.781 15.5524 34.2701 16.7854 34.6061L17.5741 31.7116ZM11.4932 35.7554L14.9672 33.0407L13.12 30.6768L9.64595 33.3916L11.4932 35.7554ZM5.23722 31.3625L9.5089 35.6341L11.6302 33.5128L7.35854 29.2411L5.23722 31.3625ZM7.83072 25.9041L5.11595 29.3782L7.4798 31.2254L10.1946 27.7513L7.83072 25.9041ZM10.3146 26.0828C9.81863 25.2159 9.42801 24.2817 9.15978 23.2973L6.26531 24.086C6.60129 25.319 7.09042 26.4885 7.71068 27.5726L10.3146 26.0828ZM3.15486 24.6437L7.52988 25.1805L7.89521 22.2028L3.52019 21.6661L3.15486 24.6437ZM1.83752 17.1138V23.1549H4.83752V17.1138H1.83752ZM7.52989 15.0882L3.15486 15.625L3.52019 18.6027L7.89521 18.0659L7.52989 15.0882ZM9.15978 16.9714C9.42801 15.987 9.81864 15.0528 10.3146 14.1859L7.71068 12.6961C7.09042 13.7802 6.60129 14.9497 6.26531 16.1827L9.15978 16.9714ZM5.11595 10.8905L7.83073 14.3646L10.1946 12.5174L7.47981 9.04329L5.11595 10.8905ZM9.5089 4.63456L5.23722 8.90624L7.35854 11.0276L11.6302 6.75588L9.5089 4.63456ZM14.9672 7.22806L11.4932 4.51329L9.64596 6.87714L13.12 9.59191L14.9672 7.22806ZM14.7885 9.71195C15.6554 9.21596 16.5897 8.82532 17.5741 8.55709L16.7854 5.66263C15.5524 5.99861 14.3829 6.48774 13.2987 7.10801L14.7885 9.71195ZM16.2276 2.5522L15.6909 6.9272L18.6686 7.29252L19.2053 2.91752L16.2276 2.5522Z" fill="#4A21EF" />
                                        <path d="M23.8748 17.9771L19.5604 22.2915L17.5992 20.3304" stroke="#4A21EF" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                                        <circle cx="20.7371" cy="20.1343" r="8.22769" stroke="#4A21EF" stroke-width="3" stroke-linejoin="round" />
                                    </svg>
                                </div>
                                <div class="title-text">Easy setup processes</div>
                            </div>
                            <div class="describe">
                                <div class="describe-item d-flex">
                                    <p class="describe-item-point">•</p>
                                    <p class="describe-item-text">No credit checks or mandatory staking of assets for account eligibility<sup>6</sup></p>
                                </div>
                                <div class="describe-item d-flex">
                                    <p class="describe-item-point">•</p>
                                    <p class="describe-item-text">Use your account and card instantly upon approval</p>
                                </div>
                                <div class="describe-item d-flex">
                                    <p class="describe-item-point">•</p>
                                    <p class="describe-item-text">Responsive and dedicated email support<sup>7</sup></p>
                                </div>
                            </div>
                        </div>
                        <div class="item-img item-img-3">
                            <img class="img-fluid" src="../assets/img/bank/multiple-item-3.png" alt="">
                        </div>
                    </div>
                    <div class="d-flex item-box" data-aos="fade-up">
                        <div class="order-lg-1 order-md-0 order-sm-0 item-text item-text-4">
                            <div class="title d-flex">
                                <div class="title-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="38" height="38" viewBox="0 0 38 38" fill="none">
                                        <circle cx="18.8952" cy="19.3833" r="17.0448" stroke="#4A21EF" stroke-width="3" />
                                        <path d="M11.8961 12.0845H22.2221C24.2498 12.0845 25.8937 13.7283 25.8937 15.7561V15.7561C25.8937 17.7838 24.2498 19.4277 22.2221 19.4277H14.6778" stroke="#4A21EF" stroke-width="3" />
                                        <path d="M14.6778 19.4276H22.2221C24.2498 19.4276 25.8937 21.0714 25.8937 23.0992V23.0992C25.8937 25.127 24.2498 26.7708 22.2221 26.7708H11.8961" stroke="#4A21EF" stroke-width="3" />
                                        <path d="M14.4323 11.3859L14.5192 27.3812" stroke="#4A21EF" stroke-width="3" />
                                        <path d="M21.6327 8.55432V12.1412M21.6327 30.2122V26.6253" stroke="#4A21EF" stroke-width="3" />
                                        <path d="M16.0649 8.55432V12.1412M16.0649 30.2122V26.6253" stroke="#4A21EF" stroke-width="3" />
                                    </svg>
                                </div>
                                <div class="title-text">Spend crypto conveniently</div>
                            </div>
                            <div class="describe">
                                <div class="describe-item d-flex">
                                    <p class="describe-item-point">•</p>
                                    <p class="describe-item-text">Link your account with virtual Master debit cards which are accepted at 40M+ merchants, including all Master debit card supported platforms</p>
                                </div>
                                <div class="describe-item d-flex">
                                    <p class="describe-item-point">•</p>
                                    <p class="describe-item-text">Top up your account with crypto across 40+ blockchains into USDC and Fiat for convenient usage<sup>8</sup></p>
                                </div>
                                <div class="describe-item d-flex">
                                    <p class="describe-item-point">•</p>
                                    <p class="describe-item-text">Spend crypto via popular and established payment platforms like Paypal, Apple Pay, Google Pay, Samsung Pay, and more</p>
                                </div>
                            </div>
                        </div>
                        <div class="item-img item-img-4">
                            <img class="img-fluid" src="../assets/img/bank/multiple-item-4.png" alt="">
                        </div>
                    </div>
                    <div class="d-flex item-box" data-aos="fade-up">
                        <div class="item-text item-text-5">
                            <div class="title d-flex">
                                <div class="title-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="41" height="41" viewBox="0 0 41 41" fill="none">
                                        <path d="M20.7371 12.9253L21.634 11.723C21.1019 11.3261 20.3723 11.3261 19.8402 11.723L20.7371 12.9253ZM30.2181 19.9976V21.4976C30.8644 21.4976 31.4381 21.0836 31.6417 20.4701C31.8453 19.8566 31.633 19.1818 31.1149 18.7953L30.2181 19.9976ZM11.2561 19.9976L10.3592 18.7953C9.84113 19.1818 9.62886 19.8566 9.83246 20.4701C10.0361 21.0836 10.6097 21.4976 11.2561 21.4976V19.9976ZM15.7393 19.9976H17.2393C17.2393 19.1692 16.5677 18.4976 15.7393 18.4976V19.9976ZM15.7393 28.2009H14.2393C14.2393 29.0293 14.9109 29.7009 15.7393 29.7009V28.2009ZM25.7348 28.2009V29.7009C26.5633 29.7009 27.2348 29.0293 27.2348 28.2009H25.7348ZM25.7348 19.9976V18.4976C24.9064 18.4976 24.2348 19.1692 24.2348 19.9976H25.7348ZM19.8402 14.1276L29.3212 21.1999L31.1149 18.7953L21.634 11.723L19.8402 14.1276ZM12.153 21.1999L21.634 14.1276L19.8402 11.723L10.3592 18.7953L12.153 21.1999ZM15.7393 18.4976H11.2561V21.4976H15.7393V18.4976ZM17.2393 28.2009V19.9976H14.2393V28.2009H17.2393ZM25.7348 26.7009H15.7393V29.7009H25.7348V26.7009ZM24.2348 19.9976V28.2009H27.2348V19.9976H24.2348ZM30.2181 18.4976H25.7348V21.4976H30.2181V18.4976Z" fill="#4A21EF" />
                                        <circle cx="20.737" cy="20.5631" r="17.3558" stroke="#4A21EF" stroke-width="3" stroke-linejoin="round" />
                                    </svg>
                                </div>
                                <div class="title-text">Unlock higher tiers and benefits effectively</div>
                            </div>
                            <div class="describe">
                                <div class="describe-item d-flex">
                                    <p class="describe-item-point">•</p>
                                    <p class="describe-item-text">Enjoy up to 40% referral commissions indefinitely on all top-up fees from referred accounts<sup>9</sup></p>
                                </div>
                                <div class="describe-item d-flex">
                                    <p class="describe-item-point">•</p>
                                    <p class="describe-item-text">Unlock exclusive privileges by making deposits, referring accounts, and staking SFP<sup>10</sup></p>
                                </div>
                            </div>
                        </div>
                        <div class="item-img item-img-5">
                            <img class="img-fluid" src="../assets/img/bank/multiple-item-5.png" alt="">
                        </div>
                    </div>
                </div>
            </div>
            <div id="crypto-bank" class="crypto-bank max-width-1920">
                <div class="crypto-bank-box">
                    <div class="container crypto-bank-container">
                        <div class="position-relative d-flex container-box" data-aos="fade-up" aos-duration="500">
                            <div class="left" data-aos="fade-up">
                                <div class="logo">
                                    <img class="img-fluid d-none d-lg-block" src="https://www.safepal.com/assets/img/bank/safepal-logo-light.svg" alt="">
                                    <svg class="d-lg-none" xmlns="http://www.w3.org/2000/svg" width="125" height="29" viewBox="0 0 125 29" fill="none">
                                        <path d="M45.3846 24.1553C43.1791 24.1553 40.7479 23.4084 38.091 21.9147V18.6842C40.5916 20.3689 43.0315 21.2113 45.4106 21.2113C46.5047 21.2113 47.373 21.0116 48.0155 20.6121C48.6754 20.1952 49.0054 19.6221 49.0054 18.8926C49.0054 18.2326 48.7015 17.7115 48.0937 17.3294C47.4859 16.9299 46.5481 16.5739 45.2804 16.2612C43.0055 15.6707 41.4599 15.167 40.6437 14.7501C38.8377 13.8296 37.9347 12.4488 37.9347 10.6077C37.9347 9.02716 38.6032 7.77662 39.9404 6.85608C41.2776 5.93554 42.9273 5.47527 44.8897 5.47527C47.2862 5.47527 49.4482 6.17001 51.3758 7.55951V10.7901C49.1703 9.19217 47.0083 8.39321 44.8897 8.39321C43.7783 8.39321 42.8579 8.60163 42.1285 9.01848C41.3991 9.43533 41.0345 10.0172 41.0345 10.764C41.0345 11.2156 41.2428 11.6064 41.6596 11.9364C42.0764 12.2491 42.5279 12.4922 43.0142 12.6659C43.5178 12.8222 44.2645 13.022 45.2544 13.2651C46.2963 13.5257 47.1559 13.7775 47.8332 14.0207C48.5278 14.2638 49.2311 14.6025 49.9431 15.0367C50.6551 15.4536 51.1848 15.9833 51.5321 16.626C51.8968 17.2686 52.0791 18.0328 52.0791 18.9186C52.0791 20.5687 51.4453 21.8539 50.1776 22.7745C48.9272 23.695 47.3296 24.1553 45.3846 24.1553Z" fill="#F7F6FF" />
                                        <path d="M58.3508 24.1553C57.743 24.1553 57.1525 24.0858 56.5794 23.9469C56.0237 23.8079 55.4854 23.5908 54.9644 23.2955C54.4434 22.9829 54.018 22.54 53.688 21.9668C53.3581 21.3763 53.1931 20.6902 53.1931 19.9086C53.1757 18.5018 53.662 17.4336 54.6518 16.7041C55.6417 15.9573 57.057 15.5838 58.8978 15.5838H63.0916V14.7501C63.0916 13.9859 62.779 13.4128 62.1539 13.0306C61.5287 12.6312 60.7212 12.4314 59.7313 12.4314C57.8385 12.4314 56.7357 13.0567 56.4232 14.3072L53.5578 14.3594C53.5925 12.9872 54.1916 11.9017 55.3552 11.1027C56.536 10.3038 57.9774 9.90428 59.6792 9.90428C61.3985 9.90428 62.8659 10.3211 64.0815 11.1548C65.3144 11.9885 65.9309 13.0654 65.9309 14.3854V23.9469H63.0916V21.8626C62.6922 22.4184 62.0844 22.9395 61.2682 23.4258C60.4694 23.9121 59.4969 24.1553 58.3508 24.1553ZM58.5852 21.6803C59.7313 21.6803 60.7646 21.2895 61.685 20.5079C62.6227 19.7263 63.0916 18.8057 63.0916 17.7462H59.4188C58.29 17.7462 57.4477 17.9634 56.892 18.3976C56.3537 18.8144 56.1192 19.3442 56.1887 19.9868C56.2408 20.5773 56.5013 21.0116 56.9702 21.2895C57.4391 21.55 57.9774 21.6803 58.5852 21.6803Z" fill="#F7F6FF" />
                                        <path d="M68.2224 23.9469L68.1703 12.718V9.6698C68.1703 8.01978 68.8476 6.77792 70.2021 5.94422C71.5566 5.11052 73.3453 4.97158 75.5681 5.52737L75.5421 7.82004C74.1007 7.43793 73.0067 7.43793 72.2599 7.82004C71.5306 8.18478 71.1659 8.81005 71.1659 9.69586V10.1388H75.4379V12.718H71.1659L71.1919 23.9469H68.2224Z" fill="#F7F6FF" />
                                        <path d="M83.3136 24.1553C81.3339 24.1553 79.6581 23.4605 78.2862 22.071C76.9143 20.6642 76.2284 18.9794 76.2284 17.0168C76.2284 15.0367 76.923 13.3607 78.3123 11.9885C79.7015 10.599 81.3686 9.90428 83.3136 9.90428C85.0328 9.90428 86.5437 10.4688 87.8461 11.5977C89.1659 12.7093 89.9734 14.1075 90.2686 15.7923C90.4423 16.6086 90.451 17.3902 90.2947 18.137H79.1979C79.3716 19.1618 79.8405 19.9781 80.6046 20.586C81.3686 21.1766 82.2717 21.4718 83.3136 21.4718C84.9113 21.4718 86.1877 20.9073 87.1428 19.7784H89.8302C89.8302 19.7784 89.5194 21.6038 87.1428 23.1653C85.9272 23.8253 84.6508 24.1553 83.3136 24.1553ZM79.1979 15.8183H87.3512C87.1775 14.8978 86.7173 14.1249 85.9706 13.4996C85.2412 12.8743 84.3469 12.5617 83.2876 12.5617C82.2283 12.5617 81.3252 12.883 80.5785 13.5257C79.8318 14.1509 79.3716 14.9151 79.1979 15.8183Z" fill="#F7F6FF" />
                                        <path d="M112.048 24.1553C111.44 24.1553 110.849 24.0858 110.276 23.9469C109.72 23.8079 109.182 23.5908 108.661 23.2955C108.14 22.9829 107.715 22.54 107.385 21.9668C107.055 21.3763 106.89 20.6902 106.89 19.9086C106.873 18.5018 107.359 17.4336 108.349 16.7041C109.338 15.9573 110.754 15.5838 112.595 15.5838H116.788V14.7501C116.788 13.9859 116.476 13.4128 115.851 13.0306C115.225 12.6312 114.418 12.4314 113.428 12.4314C111.535 12.4314 110.432 13.0567 110.12 14.3072L107.255 14.3594C107.289 12.9872 107.888 11.9017 109.052 11.1027C110.233 10.3038 111.674 9.90428 113.376 9.90428C115.095 9.90428 116.563 10.3211 117.778 11.1548C119.011 11.9885 119.628 13.0654 119.628 14.3854V23.9469H116.788V21.8626C116.389 22.4184 115.781 22.9395 114.965 23.4258C114.166 23.9121 113.194 24.1553 112.048 24.1553ZM112.282 21.6803C113.428 21.6803 114.461 21.2895 115.382 20.5079C116.319 19.7263 116.788 18.8057 116.788 17.7462H113.116C111.987 17.7462 111.144 17.9634 110.589 18.3976C110.05 18.8144 109.816 19.3442 109.885 19.9868C109.938 20.5773 110.198 21.0116 110.667 21.2895C111.136 21.55 111.674 21.6803 112.282 21.6803Z" fill="#F7F6FF" />
                                        <path d="M121.803 23.9469V5.94422H124.798V23.9469H121.803Z" fill="#F7F6FF" />
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M92.0356 5.94422H99.9544C101.708 5.94422 103.167 6.54344 104.331 7.74188C105.494 8.92295 106.076 10.3559 106.076 12.0406C106.076 13.7428 105.494 15.1757 104.331 16.3394C103.184 17.4857 101.726 18.0676 99.9544 18.0849L95.1354 18.111V23.9469H92.0356V5.94422ZM99.746 15.2973L95.1354 15.3233V8.75795L99.746 8.73189C100.771 8.73189 101.578 9.03585 102.169 9.64375C102.776 10.2517 103.08 11.0159 103.08 11.9364C103.08 12.8743 102.776 13.6733 102.169 14.3333C101.561 14.9759 100.753 15.2973 99.746 15.2973Z" fill="#F7F6FF" />
                                        <path d="M12.4 0.837891C11.5577 0.837891 10.75 1.17247 10.1545 1.76803L0.799547 11.1231C0.445222 11.4774 0.268064 11.9419 0.268066 12.4063C0.268069 12.8707 0.445234 13.3351 0.799557 13.6894L6.93012 19.82V8.96663C6.93012 8.15666 7.58158 7.50005 8.39154 7.50005C11.8135 7.50005 20.143 7.50005 21.2792 7.50005L27.9412 0.837985L12.4 0.837891Z" fill="#F7F6FF" />
                                        <path d="M6.93041 21.8491H19.8129C20.6228 21.8491 21.2794 21.1925 21.2794 20.3825V9.52916L27.41 15.6598C27.7643 16.0141 27.9415 16.4785 27.9415 16.9429C27.9415 17.4073 27.7643 17.8717 27.41 18.2261L18.0551 27.5811C17.4596 28.1767 16.6518 28.5113 15.8096 28.5113L0.268357 28.5112L6.93041 21.8491Z" fill="#F7F6FF" />
                                    </svg>
                                </div>
                                <div class="title">
                                    <p>Manage your crypto IBAN account in the <?= NAME ?> App</p>
                                </div>
                                
                            </div>
                            <div class="right" data-aos="fade-up">
                                <div class="right-img">
                                    <!-- <img class="img-fluid" src="/assets/img/bank/crypto-bank-mockup.png" alt=""> -->
                                    <!-- <img class="img-fluid d-none d-lg-block" src="/assets/img/bank/crypto-bank-mockup.png" alt=""> -->
                                    <!-- <img class="img-fluid d-lg-none" src="/assets/img/bank/crypto-bank-mockup-m.png" alt=""> -->
                                    <img class="img-fluid d-none d-lg-block" src="../assets/img/bank/crypto-bank-mockup_en.png" alt="" onerror="handleImageError(this, `/assets/img/bank/crypto-bank-mockup_en.png`)"> <img class="img-fluid d-lg-none" src="../assets/img/bank/crypto-bank-mockup-m_en.png" alt="" onerror="handleImageError(this, `/assets/img/bank/crypto-bank-mockup-m_en.png`)">
                                </div>
                            </div>
                            <img class="position-absolute crypto-bank-star d-none d-lg-block"
                                src="https://www.safepal.com/assets/img/bank/crypto-bank-star.svg" alt="" srcset="">
                            <img class="position-absolute crypto-bank-vector1 d-none d-lg-block"
                                src="https://www.safepal.com/assets/img/bank/crypto-bank-vector1.svg" alt="" srcset="">
                            <img class="position-absolute crypto-bank-vector2 d-none d-lg-block"
                                src="https://www.safepal.com/assets/img/bank/crypto-bank-vector2.svg" alt="" srcset="">

                            <img class="position-absolute crypto-bank-star d-lg-none"
                                src="https://www.safepal.com/assets/img/bank/crypto-bank-star-m.svg" alt="" srcset="">
                            <img class="position-absolute crypto-bank-vector1 d-lg-none"
                                src="https://www.safepal.com/assets/img/bank/crypto-bank-vector1-m.svg" alt="" srcset="">
                            <img class="position-absolute crypto-bank-vector2 d-lg-none"
                                src="https://www.safepal.com/assets/img/bank/crypto-bank-vector2-m.svg" alt="" srcset="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section id="accordion" class="accordion-box">
        <div class="container container-accordion">
            <div class="title" data-aos="fade-up">
                <h3>Frequently Asked Questions</h3>
            </div>
            <div class="accordion " id="accordionQuestions" data-aos="fade-up">
                <div class="accordion-item">
                    <h3 class="accordion-header" id="questionsOne">
                        <button class="accordion-button collapsed accordion-header-title" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                            Am I eligible for the <?= NAME ?> banking gateway and Mastercard? </button>
                    </h3>
                    <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="questionsOne">
                        <div class="accordion-body">
                            If you are a citizen in any of the supported regions and reside in supported areas, you will be able to open an account. To check the list of supported regions, please refer to the link <a class="a-tag" href="bank/regions.html" rel="noopener noreferrer">here</a>. </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h3 class="accordion-header" id="questionsTwo">
                        <button class="accordion-button collapsed accordion-header-title" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            How can I apply for a IBAN account and Mastercard? </button>
                    </h3>
                    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="questionsTwo">
                        <div class="accordion-body">
                            Eligible users can download the <?= NAME ?> App and apply to open a IBAN account under the Bank tab on the homepage. After completing the IBAN account registration, you will also receive a <?= NAME ?> Mastercard. Learn more about getting started <a class="a-tag" href="https://safepalsupport.zendesk.com/hc/en-us/articles/22558184801691-How-to-Register-Your-Fiat24-Bank-Account" target="_blank" rel="noopener noreferrer">here</a>. </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h3 class="accordion-header" id="questionsThree">
                        <button class="accordion-button collapsed accordion-header-title" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                            Are there any fees? 
                        </button>
                    </h3>
                    <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="questionsThree">
                        <div class="accordion-body">
                            There are no account creation or management fees. The banking gateway and Mastercard also offer the most competitive rates, with fiat transfer and deposit fees being as low as 0.6%. For more information, please visit our <a class="a-tag" href="https://safepalsupport.zendesk.com/hc/en-us/articles/22647224575643/" target="_blank" rel="noopener noreferrer">Pricing and Fee disclosures</a>. </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h3 class="accordion-header" id="questionsFour">
                        <button class="accordion-button collapsed accordion-header-title" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                            What are the transfer and spending limits? </button>
                    </h3>
                    <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="questionsFour">
                        <div class="accordion-body">
                            <p></p>
                            <p>For Mastercards, the limit for contactless payments is 1,600 EUR per day and 5,000 EUR per day for other payment methods. The monthly consumption limit is the same as the transaction limit.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="more-faqs">
                <p>For more FAQs and user guidelines, visit our <a class="a-tag" href="https://safepalsupport.zendesk.com/hc/en-us/sections/22558161836827-SafePal-Banking-Gateway" target="_blank" rel="noopener noreferrer">Help Center</a></p>
            </div>
        </div>
    </section>
    <section id="source">
        <div class="container">
            <div class="container-box" data-aos="fade-up">
                <p id="source1">1. The Swiss IBAN account and banking gateway service is offered in collaboration with Fiat24, which solely handles the compliance and licensing aspect. Learn more on the official Fiat24 website <a href="https://www.fiat24.com/" target="_blank" rel="noopener noreferrer">here</a>.</p>
                <p id="source2">2. The spending limit refers to the total accumulated amount that can be spent by users for their Mastercards. Please refer to the guide <a href="https://safepalsupport.zendesk.com/hc/en-us/articles/22558278048027/" target="_blank" rel="noopener noreferrer">here</a> on how to adjust them.</p>
                <p id="source3">3. All fees are disclosed transparently while using the service. Crypto swap fees, account top-up or deposit fees, and fiat exchange fees may apply. While <?= NAME ?> and Fiat24 do not charge bank transfer fees, there may be charges by other banks when making transfers from or to those bank accounts. A spread also applies when swapping cryptocurrencies. For more information, please visit our <a href="https://safepalsupport.zendesk.com/hc/en-us/articles/22647224575643/" target="_blank" rel="noopener noreferrer">Pricing and Fee disclosures</a>.</p>
                <p id="source4">4. Top up rates and referral commissions differ between account tiers. The competitive rates highlighted are based on the highest account tier. For more information on account tiers, please refer to the guide <a href="https://safepalsupport.zendesk.com/hc/en-us/articles/22646881975195/" target="_blank" rel="noopener noreferrer">here</a>.</p>
                <p id="source5">5. Gas fees are subject to network usage and are not controlled by SafePal. They may be higher during peak network usage or congestion. Learn more about gas fees in the guide <a href="https://safepalsupport.zendesk.com/hc/en-us/articles/10313492507419" target="_blank" rel="noopener noreferrer">here</a>.</p>
                <p id="source6">6. As required by banking license and compliance requirements by regulators, there are KYC and onboarding processes for eligible users. Learn more about the requirements under the FAQ section <a href="https://safepalsupport.zendesk.com/hc/en-us/articles/22646856800027/" target="_blank" rel="noopener noreferrer">here</a>.</p>
                <p id="source7">7. Users can reach out for support and queries via the dedicated channel <a href="https://safepalsupport.zendesk.com/hc/en-us/requests/new?ticket_form_id=360001760732" target="_blank" rel="noopener noreferrer">here</a>. This system is to protect the privacy and security of users and minimize the likelihood of impersonators and scammers.</p>
                <p id="source8">8. $USDC is the default top-up cryptocurrency to safeguard users from market volatility, and the execution or transactions on-chain may be affected by network congestion or usage. Learn more in the guide <a href="https://safepalsupport.zendesk.com/hc/en-us/articles/23046238625563" target="_blank" rel="noopener noreferrer">here</a>.</p>
                <p id="source9">9. All imagery is for illustrative purposes only, benefits and rewards may vary and be adjusted at the discretion of <?= NAME ?> and Fiat24.</p>
                <p id="source10">10. For a breakdown of the account tiers and privileges, users can refer to the guide <a href="https://safepalsupport.zendesk.com/hc/en-us/articles/22646881975195/" target="_blank" rel="noopener noreferrer">here</a>.</p>
            </div>
        </div>
    </section>
</main>
<div class="one-wallet-footer">
    <div class="one-wallet-footer-main">
        <!-- ================= ---------one - wallet--------- ===================== -->
        <section id="one-wallet">
            <div class="one-wallet d-flex justify-content-center align-items-center flex-column">
                <div class="sfp-logo d-flex justify-content-center align-items-center">
                    <div class="logo-box move-animation-Y">
                        <img class="img-fluid" src="https://www.safepal.com/assets/img/safePal-extension-icon.svg" alt="">
                    </div>
                </div>
                <div class="title animate__animated animate__fadeInDown">
                    <h3>
                        Everything you need in one wallet. </h3>
                </div>
            </div>
        </section>

        <!-- ======= Footer ======= -->
        <?php include 'assets/footer.php'; ?>