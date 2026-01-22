<?php
    include 'assets/header.php';
?>

<!-- ======= Header ======= -->
<header id="header" class="fixed-top d-flex align-items-center header-transparent">
    <?php include 'assets/navbar.php'; ?>
</header><!-- End Header -->

<header>
    <link href="../assets/css/header-button496d.css?v=202601151767855013676" rel="stylesheet">
    <link href="../assets/css/sfp-token496d.css?v=202601151767855013676" rel="stylesheet">
</header>


<main id="main" class="sfp">
    <section id="hero" style="overflow: hidden">
        <div class="container d-flex justify-content-start align-items-center flex-column flex-lg-row hero">
            <div class="position-relative safepay-token" data-aos="fade-right">
                <div class="sub-title">
                    <h3>SFP TOKEN</h3>
                </div>
                <div class="title">
                    <h3>The Growth Engine of the <?= NAME ?> Ecosystem</h3>
                </div>
                <div class="d-none d-lg-block" style="z-index: auto;">
                    <div class="d-flex justify-content-start align-items-center btn-sfp-view">
                        <!-- <a href="https://bscscan.com/token/0xd41fdb03ba84762dd66a0af1a6c8540ff1ba5dfb" target="_blank">
                            <button class="btn-common btn-view transparent-light-green">View SFP On BscScan</button>
                        </a> -->
                        <!-- <a href="https://my.safepal.com/pub/SFP_Whitepaper.pdf" target="_blank">
                            <button class="btn-common btn-view transparent-light-green">SFP Whitepaper</button>
                        </a> -->
                        <a href="https://www.safepal.com/pub/SFP_Whitepaper.pdf" target="_blank">
                            <button class="btn-common btn-view transparent-light-green">SFP Whitepaper</button>
                        </a>
                    </div>
                </div>
                <div class="d-lg-none" style="z-index: auto;margin-bottom: 30px">
                    <div class="d-flex justify-content-center align-items-center btn-sfp-view">
                        <a href="https://www.safepal.com/pub/SFP_Whitepaper.pdf" target="_blank">
                            <button class="btn-common btn-view transparent-light-green">SFP Whitepaper</button>
                        </a>
                    </div>
                </div>
                <div class="position-absolute d-none d-lg-block img-box" data-aos="fade-left">
                    <img src="https://www.safepal.com/assets/img/sfp-token/icon-token-bottom-bg.svg" alt="" srcset="">
                    <img style="top: 13%;left: 73%;z-index:2"
                         class="absolute animate__animated animate__backInDown token-group1"
                         src="https://www.safepal.com/assets/img/sfp-token/icon-token-group-1.svg" alt="" srcset="">
                    <img style="top: -8.3%;left: 84.1%;"
                         class="absolute animate__animated animate__backInDown token-group2"
                         src="https://www.safepal.com/assets/img/sfp-token/icon-token-group-2.svg" alt="" srcset="">
                    <img style="top: -14%;left: 46%;z-index:1;"
                         class="absolute animate__animated animate__backInDown token-group3"
                         src="https://www.safepal.com/assets/img/sfp-token/icon-token-group-3.svg" alt="" srcset="">
                    <img style="top: 25%;left: 26%;"
                         class="absolute animate__animated animate__backInDown token-animation"
                         src="https://www.safepal.com/assets/img/sfp-token/icon-token-1.svg" alt="" srcset="">
                    <img style="bottom: 35.9%;right: -51%;"
                         class="absolute animate__animated animate__backInDown token-animation"
                         src="https://www.safepal.com/assets/img/sfp-token/icon-token-1.svg" alt="" srcset="">
                    <img style="bottom: 7.9%;right: 3%;"
                         class="absolute animate__animated animate__backInDown token-animation"
                         src="https://www.safepal.com/assets/img/sfp-token/icon-token-1.svg" alt="" srcset="">
                    <img style="bottom: 20.9%;right: 42%;"
                         class="absolute animate__animated animate__backInDown token-animation"
                         src="https://www.safepal.com/assets/img/sfp-token/icon-token-1.svg" alt="" srcset="">
                    <img style="bottom: -0.1%; right: -17%;"
                         class="absolute animate__animated animate__backInDown token-animation"
                         src="https://www.safepal.com/assets/img/sfp-token/icon-token-2.svg" alt="" srcset="">
                </div>
            </div>
            <div class="d-lg-none m-img-box d-flex justify-content-center align-items-center" data-aos="fade-up">
                <img class="hero-token-bottom animate__animated animate__backInDown"
                     src="https://www.safepal.com/assets/img/sfp-token/hero-m-sfp-tokens.svg" alt="" srcset="">
            </div>
        </div>
    </section>
    <!-- ----------------- what is sfp ----------------- -->
    <section id="what-is-sfp">
        <div class="container what-is-sfp">
            <div class="position-relative pc-star title" data-aos="fade-up">
                <h3 class="title-top">What is SFP</h3>
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
                    <div class="start2-point"><img class="" src="https://www.safepal.com/assets/img/icon-point.svg" alt="" srcset="">
                    </div>
                    <div class="start">
                        <img class="" src="https://www.safepal.com/assets/img/icon-start-empty.svg" alt="" srcset="">
                    </div>
                </div>
                <!-- pc- star - end -->
            </div>
            <div class="describe">
                <p>SFP is short for <?= NAME ?> Token, a utility token that fuels the entire <?= NAME ?> ecosystem. It is a decentralized digital asset issued on the Binance Smart Chain and Ethereum, with a limited total supply of 500,000,000.</p>
                <!-- <p>SFP is short for <?= NAME ?> Token, a utility token that fuels the entire <?= NAME ?> ecosystem. It is a decentralized digital asset issued on the Binance Smart Chain and Ethereum, with a limited total supply of 500,000,000.</p> -->
            </div>
            <div class="btn-box">
                <a class="a-bscscan" href="https://bscscan.com/token/0xd41fdb03ba84762dd66a0af1a6c8540ff1ba5dfb" target="_blank">
                    <button class="btn-common btn-view transparent-light-green">View SFP On BscScan</button>
                    <!-- <button class="btn-common btn-view transparent-light-green">View SFP On BscScan</button> -->
                </a>
                <a class="a-" href="https://etherscan.io/token/0x12e2b8033420270db2f3b328e32370cb5b2ca134" target="_blank">
                    <!-- <button class="btn-common btn-view transparent-light-green">View SFP On EtherScan</button> -->
                    <button class="btn-common btn-view transparent-light-green">View SFP On EtherScan</button>
                </a>
            </div>
        </div>
    </section>
    <!-- ------------------- use cases --------------------- -->
    <section id="use-cases" class="position-relative">
        <div class="container use-cases">
            <div class="position-relative pc-star title" data-aos="fade-up">
                <h3>SFP Use Cases</h3>
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
                    <div class="start2-point"><img class="" src="https://www.safepal.com/assets/img/icon-point.svg" alt="" srcset="">
                    </div>
                    <div class="start">
                        <img class="" src="https://www.safepal.com/assets/img/icon-start-empty.svg" alt="" srcset="">
                    </div>
                </div>
                <!-- pc- star - end -->
            </div>
            <div class="d-flex justify-content-center align-items-center flex-column content">
                <div class="d-flex justify-content-center align-items-start flex-lg-row flex-column content-item">
                    <div class="d-flex justify-content-center align-items-center flex-column item-box" data-aos="fade-right">
                        <div class="icon">
                            <img src="https://www.safepal.com/assets/img/sfp-token/icon-use-cases-1.svg" alt="" srcset="">
                        </div>
                        <h3 class="item-title">Rewards & Incentives</h3>
                        <p class="describe">SFP token holders have the privilege to enjoy incentives such as token airdrops from ecological partners, staking rewards, or limited <?= NAME ?> NFTs. By staking SFP, users can also unlock additional benefits from the <?= NAME ?> banking gateway.</p>
                    </div>
                    <div class="d-flex justify-content-center align-items-center flex-column item-box" data-aos="fade-left">
                        <div class="icon"><img src="https://www.safepal.com/assets/img/sfp-token/icon-use-cases-2.svg" alt="" srcset="">
                        </div>
                        <h3 class="item-title">Yield Boosting</h3>
                        <p class="describe">SFP holders enjoy higher APY from <?= NAME ?> Earn by staking SFP tokens into the pools.</p>
                    </div>
                </div>
                <div class="d-flex justify-content-center align-items-start flex-lg-row flex-column content-item">
                    <div class="d-flex justify-content-center align-items-center flex-column item-box" data-aos="fade-right">
                        <div class="icon"><img src="https://www.safepal.com/assets/img/sfp-token/icon-use-cases-3.svg" alt="" srcset="">
                        </div>
                        <h3 class="item-title">Gas Station</h3>
                        <p class="describe">Users may use the ‘Gas Station’ DApp within the wallet to exchange for gas fee tokens from different chains using SFP tokens.</p>
                    </div>
                    <div class="d-flex justify-content-center align-items-center flex-column item-box" data-aos="fade-left">
                        <div class="icon"><img src="https://www.safepal.com/assets/img/sfp-token/icon-use-cases-4.svg" alt="" srcset="">
                        </div>
                        <h3 class="item-title">List DApp/Token</h3>
                        <p class="describe">Projects looking to list your token or DApp within the <?= NAME ?> wallet can submit the listing request using SFP token.</p>
                    </div>
                </div>
            </div>
        </div>
        <img class="absolute d-none d-lg-block lattice-line1" data-aos="fade-right" style="top: 8%;left:0;"
             src="https://www.safepal.com/assets/img/sfp-token/lattice_line.svg" alt="" srcset="">
        <img class="absolute d-none d-lg-block lattice-line2" data-aos="fade-left" style="top: 44%;right: 0;"
             src="https://www.safepal.com/assets/img/sfp-token/lattice_line_right.svg" alt="" srcset="">
    </section>
    <!-- ---------------- get-sfp ---------------------- -->
    <section id="get-sfp">
        <div class="container get-sfp">
            <div class="position-relative pc-star title" data-aos="fade-up">
                <h3>How To Get SFP</h3>
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
                    <div class="start2-point"><img class="" src="https://www.safepal.com/assets/img/icon-point.svg" alt="" srcset="">
                    </div>
                    <div class="start">
                        <img class="" src="https://www.safepal.com/assets/img/icon-start-empty.svg" alt="" srcset="">
                    </div>
                </div>
                <!-- pc- star - end -->
            </div>
        </div>
        <div class="container content">
            <div class="enumera" data-aos="fade-up">
                <div class="enumera-top d-flex justify-content-center align-items-lg-stretch align-items-center  flex-lg-row flex-column">
                    <div class="enumera-item d-flex justify-content-between align-items-start flex-column" data-aos="zoom-out-up">
                        <div>
                            <div class="d-flex justify-content-center align-items-center top">
                                <img class="img-fluid enumera-img enumera-1"
                                    src="https://www.safepal.com/assets/img/sfp-token/how_to_get_sfp_1.svg" alt="">
                            </div>
                            <div class="bottom">
                                <div class="item-title">
                                    <h3>View SFP on Marketplaces</h3>
                                </div>
                                <div class="text">
                                    <p>SFP is listed on the most popular exchanges including Binance.</p>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <div class="enumera-item d-flex justify-content-between align-items-start flex-column" data-aos="zoom-out-up">
                        <div>
                            <div class="d-flex justify-content-center align-items-center top">
                                <img class="img-fluid enumera-img enumera-2"
                                    src="https://www.safepal.com/assets/img/sfp-token/how_to_get_sfp_2.svg" alt="">
                            </div>
                            <div class="bottom">
                                <div class="item-title">
                                    <h3>Buy SFP from PancakeSwap</h3>
                                </div>
                                <div class="text">
                                    <p>You can easily get SFP from PancakeSwap, the largest DEX on the Binance Smart Chain.</p>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <div class="enumera-item d-flex justify-content-between align-items-start flex-column" data-aos="zoom-out-up">
                        <div>
                            <div class="d-flex justify-content-center align-items-center top">
                                <img class="img-fluid enumera-img enumera-3"
                                    src="https://www.safepal.com/assets/img/sfp-token/how_to_get_sfp_3.svg" alt="">
                            </div>
                            <div class="bottom">
                                <div class="item-title">
                                    <h3>Win SFP from Community Airdrops</h3>
                                </div>
                                <div class="text">
                                    <p>Use <?= NAME ?> products and join our community to participate in community airdrops and other incentives program.</p>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- stay-safe -->
    <section id="stay-safe" class="d-flex justify-content-center align-items-center">
        <div class="stay-safe-main">
            <div class="container position-relative stay-safe">
                <div class="content-box" data-aos="fade-up">
                    <h3>Stay Safe With SafePal</h3>
                    <div class="btn-box">
                        <a href="downloadbead.html?product=1">
                            <button class="btn btn-common btn-light-green">Download <?= NAME ?> App</button>
                        </a>
                    </div>
                </div>
                <div class="d-lg-none position-relative phone-illo">
                    <!-- <img class="icon-safe-box" data-aos="fade-up"
                        src="/assets/img/sfp-token/icon-phone-illo-m.svg" alt=""> -->
                    <img class="icon-safe-box" data-aos="fade-up"
                            src="https://www.safepal.com/assets/img/sfp-token/icon-phone-illo-m_en.svg" alt="" onerror="handleImageError(this, `/assets/img/sfp-token/icon-phone-illo-m_en.svg`)">  
                    <img class="absolute icon-locked" data-aos="fade-up-left"
                        src="https://www.safepal.com/assets/img/sfp-token/icon-locked.svg" alt="">
                    <img class="absolute icon-clound" data-aos="fade-up-right"
                        src="https://www.safepal.com/assets/img/sfp-token/icon-clound.svg" alt="">
                </div>
                <img class="absolute d-none d-lg-block icon-clound" style="top: 32.6%;left: -4.5%;" data-aos="fade-up-right"
                    src="https://www.safepal.com/assets/img/sfp-token/icon-clound.svg" alt="">
                <img class="absolute d-none d-lg-block icon-locked" style="bottom: 0%;left: 5%;" data-aos="fade-up-right"
                    src="https://www.safepal.com/assets/img/sfp-token/icon-locked.svg" alt="">
                <img class="absolute d-none d-lg-block icon-safe-box" style="bottom: 0%;right: 0.6%;z-index:2;pointer-events: none;" data-aos="fade-left" 
                        src="https://www.safepal.com/assets/img/sfp-token/icon-phone-illo_en.svg" alt="" onerror="handleImageError(this, `/assets/img/sfp-token/icon-phone-illo_en.svg`)">    
                <!-- <img class="absolute d-none d-lg-block icon-safe-box" style="bottom: 0%;right: 0.6%;z-index:2;pointer-events: none;" data-aos="fade-left"
                    src="/assets/img/sfp-token/icon-phone-illo.svg" alt=""> -->
                <img class="absolute d-none d-lg-block icon-safe-box" style="bottom: 0%;right: 0.7%;pointer-events: none;" data-aos="fade-left"
                    src="https://www.safepal.com/assets/img/sfp-token/icon-phone-illo-3.svg" alt="">
                <img class="absolute d-none d-lg-block icon-safe-box" style="bottom: 0%;right: -0.7%;pointer-events: none;" data-aos="fade-left"
                    src="https://www.safepal.com/assets/img/sfp-token/icon-phone-illo-2.svg" alt="">
                <img class="absolute d-none d-lg-block icon-safe-box" style="bottom: 0%;right: -2.4%;pointer-events: none;" data-aos="fade-left"
                    src="https://www.safepal.com/assets/img/sfp-token/icon-phone-illo-1.svg" alt="">
            </div>
        </div>
    </section>
</main>
<div class="start-soar-footer">
    <div class="start-soar-footer-main">
    <!-- ================= ---------start - soar--------- ===================== -->
    <section id="start-soar">
        <div class="start-soar d-flex justify-content-center align-items-center flex-column">
            <div class="sfp-logo d-flex justify-content-center align-items-center">
                <div class="logo-box move-animation-Y">
                    <img src="https://www.safepal.com/assets/img/safePal-extension-icon.svg" alt="">
                </div>
            </div>
            <div class="d-none d-lg-block title animate__animated animate__fadeInDown">
                <h3>Start today. Soar tomorrow.</h3>
            </div>
            <div class="container d-lg-none title animate__animated animate__fadeInDown">
                <h3>Everything you need in one wallet.</h3>
            </div>
            <div class="d-none d-lg-block text animate__animated animate__fadeInDown">
                <p>Industry-leading security. Human-centered design. With <?= NAME ?> Wallet, your path to financial freedom has never been more clear.</p>
            </div>
            <div class="download d-flex justify-content-center align-items-center">
                <div class="btn-out set-off-btn animate__animated animate__pulse">
                    <div class="btn-inner set-off-btn animate__animated animate__pulse">
                        <a href="download.html">
                        <button type="button" class="btn-common downloads-btn animate__animated animate__pulse light-green-effect">Download <?= NAME ?> Wallet</button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ======= Footer ======= -->
<?php include 'assets/footer.php'; ?>