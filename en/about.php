<?php 
    include 'assets/header.php';
?>

<!-- ======= Header ======= -->
<header id="header" class="fixed-top d-flex align-items-center header-transparent">
    <?php include 'assets/navbar.php'; ?>
</header><!-- End Header -->

<header>
    <link href="../assets/css/header-button496d.css?v=202601151767855013676" rel="stylesheet">
    <link href="../assets/css/about496d.css?v=202601151767855013676" rel="stylesheet">
</header>

<section id="hero" class="about-hero" class="position-relative">
    <div class="container hero-container">
        <div class="title-box position-relative">
            <div class="text" data-aos="zoom-in">
                <h3 class="title">ABOUT US</h3>
                <div class="sub-title">Our mission is to empower everyone to own their crypto future.</div>
            </div>
            <div class="d-flex justify-content-around align-items-center img">
                <div class="position-relative img-item left" data-aos="flip-left"
                     data-aos-easing="ease-out-cubic"
                     data-aos-duration="1000">
                    <img class="img-fluid hero-left" src="../assets/img/about/hero-left.png" alt="">
                    <img class="absolute hero-eth" src="https://www.safepal.com/assets/img/about/icon-hero-eth-coin.svg" alt="" srcset="">
                </div>
                <div class="position-relative img-item middle" data-aos="flip-left"
                     data-aos-easing="ease-out-cubic"
                     data-aos-duration="q000">
                    <img class="img-fluid hero-middle" src="../assets/img/about/hero-middle.png" alt="" srcset="">
                    <img class="absolute hero-locked" src="https://www.safepal.com/assets/img/about/icon-hero-locked.svg" alt="">
                </div>
                <div class="position-relative img-item right" data-aos="flip-left"
                     data-aos-easing="ease-out-cubic"
                     data-aos-duration="q000">
                    <img class="img-fluid hero-right" src="../assets/img/about/herro-right.png" alt="" srcset="">
                    <img class="absolute hero-bnb" src="https://www.safepal.com/assets/img/about/icon-hero-bnb-coin.svg" alt="">
                </div>
            </div>
            <img class="absolute hero-clound animate__animated animate__fadeInLeft animate__fast" src="https://www.safepal.com/assets/img/beyond-crypto/icon-clound.svg" alt="">
            <img class="absolute hero-btc animate__animated animate__fadeInRight animate__fast" src="https://www.safepal.com/assets/img/beyond-crypto/icon-bitcoin-coin.svg" alt="">
        </div>
    </div>
    
</section>
<!-- End Hero Section -->
<main id="main" class="about">
    <div class="purpose-story">
        <section id="purpose">
            <div class="purpose">
            <div class="container position-relative pc-star title" data-aos="flip-up">
            <!-- mobile - star -1 -->
            <div class="d-lg-none m-star m-star-1">
                <div class="position-relative star-1 star-move">
                    <div class="star1-point">
                        <img src="https://www.safepal.com/assets/img/about/icon-future-point.svg" alt="" srcset="">
                    </div>
                    <div class="star">
                        <img src="https://www.safepal.com/assets/img/about/icon-future-satart.svg" alt="" srcset="">
                    </div>
                </div>
            </div>
            <h3>Our purpose.</h3>
            <!-- pc- star - start -->
            <div class="start-1 d-none d-lg-block absolute">
                <div class="absolute start1-point">
                    <img src="https://www.safepal.com/assets/img/about/icon-future-point.svg" alt="" srcset="">
                </div>
                <div class="absolute start">
                    <img src="https://www.safepal.com/assets/img/about/icon-future-satart.svg" alt="" srcset="">
                </div>
            </div>
            <div class="absolute d-none d-lg-block start-2">
                <div class="absolute start2-point"><img src="https://www.safepal.com/assets/img/about/icon-future-point.svg"
                                                        alt="" srcset=""></div>
                <div class="absolute start">
                    <img src="https://www.safepal.com/assets/img/about/icon-future-satart.svg" alt="" srcset="">
                </div>
            </div>
            <!-- pc- star - end -->
            <div class="describe">
                <p><?= NAME ?> is a fast-growing team of developers, designers and security engineers striving to eliminate the hurdles for crypto beginners. We help people unlock their crypto potential and grow their wealth with confidence and ease.</p>
            </div>
            <!-- mobile - star -2 -->
            <div class="d-lg-none m-star m-star-2">
                <div class="position-relative star-2">
                    <div class="star2-point"><img src="https://www.safepal.com/assets/img/about/icon-future-point.svg" alt="" srcset=""></div>
                    <div class="star">
                        <img src="https://www.safepal.com/assets/img/about/icon-future-satart.svg" alt="" srcset="">
                    </div>
                </div>
            </div>
        </div>
                <div class=" content-box">
                    <div class="purpose-carousel-box swiper">
                        <div id="purpose-swiper-wrapper" class="swiper-wrapper">
                            <div class="swiper-slide swiper-wrapper-item">
                                <img class="purpose-swiper1" src="https://www.safepal.com/assets/img/about/purpose-swiper-1.svg" alt="" srcset="">
                            </div>
                            <div class="swiper-slide swiper-wrapper-item">
                                <img class="purpose-swiper2" src="https://www.safepal.com/assets/img/about/purpose-swiper-2.svg" alt="" srcset="">
                            </div>
                            <div class="swiper-slide swiper-wrapper-item">
                                <img class="purpose-swiper3" src="https://www.safepal.com/assets/img/about/purpose-swiper-3.svg" alt="" srcset="">
                            </div>
                        </div>
                        <div class="d-lg-none swiper-pagination-purpose"></div>
                    </div>
                </div>
            </div>
        </section>
        <section id="story">
            <div class="container story">
                <div class="title" data-aos="fade-up">
                    <h3>Our story.</h3>
                </div>
                <div class="content">
                    <p data-aos="fade-up">Although blockchain promises to cut out the middleman and boost security,crypto still has its gatekeepers: Long learning curves and clunky, expensive tools. Throw in the risk of getting hacked, and it's no wonder most people stick to fiat.</p>
                    <p data-aos="fade-up">In 2018, Veronica Wong, a veteran in the tech industry, founded <?= NAME ?> with two co-founders who shared her mission. Initially a hardware wallet, <?= NAME ?> has since evolved to a complete suite of smart, secure crypto management solutions accessible for tech pros and non-geeks alike.</p>
                    <p data-aos="fade-up">In only a handful of years, we've garnered the support of industry giants like Binance and risen from a humble (but ambitious) startup to a global enterprise bringing the freedom and power of crypto to millions – and we're just getting started.</p>
                </div>
            </div>
        </section>
    </div>
    <div class="history-core-values">
        <!-- ==============================Our core values.==================================== -->
        <section id="core-values">
            <div class="container core-values">
                <div class="position-relative pc-star title">
                    <!-- mobile - star -1 -->
                    <div class="d-lg-none m-star m-star-1">
                        <div class="position-relative star-1 star-move">
                            <div class="star1-point">
                                <img src="https://www.safepal.com/assets/img/about/icon-core-value-point.svg" alt="" srcset="">
                            </div>
                            <div class="star">
                                <img src="https://www.safepal.com/assets/img/about/icon-core-value-start.svg" alt="" srcset="">
                            </div>
                        </div>
                    </div>
                    <h3>Our core values.</h3>
                    <!-- pc- star - start -->
                    <div class="start-1 d-none d-lg-block absolute">
                        <div class="absolute start1-point">
                            <img src="https://www.safepal.com/assets/img/about/icon-core-value-point.svg" alt="" srcset="">
                        </div>
                        <div class="absolute start">
                            <img src="https://www.safepal.com/assets/img/about/icon-core-value-start.svg" alt="" srcset="">
                        </div>
                    </div>
                    <div class="absolute d-none d-lg-block start-2">
                        <div class="absolute start2-point"><img src="https://www.safepal.com/assets/img/about/icon-core-value-point.svg"
                                                                alt="" srcset=""></div>
                        <div class="absolute start">
                            <img src="https://www.safepal.com/assets/img/about/icon-core-value-start-empty.svg" alt="" srcset="">
                        </div>
                    </div>
                    <!-- pc- star - end -->
                    <div class="describe" data-aos="fade-up">
                        <p>At SafePal, our values aren’t lofty ideas. They’re a part of our daily lives.</p>
                    </div>
                    <!-- mobile - star -2 -->
                    <div class="d-lg-none m-star m-star-2">
                        <div class="position-relative star-2">
                            <div class="star2-point"><img src="https://www.safepal.com/assets/img/about/icon-core-value-point.svg" alt="" srcset=""></div>
                            <div class="star">
                                <img src="https://www.safepal.com/assets/img/about/icon-core-value-start-empty.svg" alt="" srcset="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="core-carousel">
                    <div class="core-carousel-box swiper" data-aos="fade-up">
                        <div class="swiper-wrapper justify-content-between">
                            <div class="swiper-slide swiper-slide-item">
                                <div class="top">
                                    <img class="img-fluid" src="https://www.safepal.com/assets/img/about/our-core-values-proactive.svg" alt="">
                                </div>
                                <div class="bottom">
                                    <h3>Safety is proactive.</h3>
                                    <p>Security is built into our products, but safety depends on what we do. From identifying potential cyberattacks to refining our systems, we work every day to protect our users and their assets.</p>
                                </div>
                            </div>
                            <div class="swiper-slide swiper-slide-item">
                                <div class="top">
                                    <img class="img-fluid" src="https://www.safepal.com/assets/img/about/our-core-values-power.svg" alt="">
                                </div>
                                <div class="bottom">
                                    <h3>Power belongs to our users.</h3>
                                    <p>We are deeply community-driven. User demands always come first, helping us shape our roadmap and create products and upgrades responsive to real-world needs.</p>
                                </div>
                            </div>
                            <div class="swiper-slide swiper-slide-item">
                                <div class="top">
                                    <img class="img-fluid" src="https://www.safepal.com/assets/img/about/our-core-values-heart.svg" alt="">
                                </div>
                                <div class="bottom">
                                    <h3>Radical change is human-centered.</h3>
                                    <p>Whether it’s easy-to-use wallets or comprehensive crypto education, at the heart of everything we create is the desire to help guide our customers through their crypto journey.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-swiper-pagination"></div>
                    <!-- <div class="navigation-box d-lg-none">
                        <button class="core-button-prev">&lt;</button>
                        <button class="core-button-next">></button>
                    </div> -->
                </div>
            </div>
        </section>
    </div>
  
    <!-- =====================  our-team ============================ -->
    <section id="our-team">
        <div class="container our-team">
            <div class="d-flex justify-content-center align-items-center flex-lg-row flex-column top">
                <div class="left d-flex justify-content-around align-items-center flex-row flex-lg-column" data-aos="fade-right">
                    <div class="top-image position-relative">
                        <img class="img-fluid left-top-img" src="../assets/img/about/our-team-left-top.png" alt="">
                        <div class="start-1 absolute">
                            <div class="absolute start1-point">
                                <img src="https://www.safepal.com/assets/img/about/icon-point-bule.svg" alt="" srcset="">
                            </div>
                            <div class="absolute start">
                                <img src="https://www.safepal.com/assets/img/about/icon-start-blue.svg" alt="">
                            </div>
                        </div>
                        <div class="absolute start-2">
                            <div class="absolute start2-point"><img src="https://www.safepal.com/assets/img/about/icon-point-bule.svg"
                                                                    alt="" srcset=""></div>
                            <div class="absolute start">
                                <img src="https://www.safepal.com/assets/img/about/icon-start-blue.svg" alt="" srcset="">
                            </div>
                        </div>
                    </div>
                    <div class="bottom-image">
                        <img class="img-fluid left-bottom-img" src="../assets/img/about/our-team-left-bottom.png" alt="">
                    </div>
                </div>
                <div class="middle" data-aos="fade-up">
                    <img class="img-fluid" src="../assets/img/about/our-team-middle.png" alt="">
                </div>
                <div class="right d-flex justify-content-around align-items-start flex-row flex-lg-column" data-aos="fade-left">
                    <div class="top-image position-relative">
                        <img class="img-fluid right-top-img" src="../assets/img/about/our-team-right-top.png" alt="">
                        <div class="start-1 absolute">
                            <div class="absolute start1-point">
                                <img src="https://www.safepal.com/assets/img/about/icon-point-bule.svg" alt="" srcset="">
                            </div>
                            <div class="absolute start">
                                <img src="https://www.safepal.com/assets/img/about/icon-start-blue.svg" alt="">
                            </div>
                        </div>
                        <div class="absolute start-2">
                            <div class="absolute start2-point"><img src="https://www.safepal.com/assets/img/about/icon-point-bule.svg"
                                                                    alt="" srcset=""></div>
                            <div class="absolute start">
                                <img src="https://www.safepal.com/assets/img/about/icon-start-empty-bule.svg" alt="" srcset="">
                            </div>
                        </div>
                    </div>
                    <div class="bottom-image">
                        <img class="img-fluid right-bottom-img" src="../assets/img/about/our-team-right-bottom.png" alt="">
                    </div>
                </div>
            </div>
            <div class="bottom">
                <h3 data-aos="fade-up">Our team.</h3>
                <div class="text" data-aos="fade-up">
                    <p><?= NAME ?> is powered by a dedicated team of bold changemakers. Blending technical expertise with creative problem solving and a healthy dose of determination, we deliver solutions that challenge the status quo and transform people's lives.</p>
                    <p>As a remote-first company with team members across four continents, we value diversity and believe our different backgrounds, perspectives and experiences make us stronger and more adaptable to a tech landscape that is constantly shifting.</p>
                    <p>We know our company's future depends on how we treat each other today, and we're playing the long game. We carry each other through difficult times, pause to celebrate our achievements,and improve ourselves side-by-side. At SafePal, passion is essential, and the moon is the limit.</p>
                </div>
            </div>
        </div>
    </section>

</main>
    <!-- ================= ---------join us--------- ===================== -->

<div class="join-us-footer">
    <div class="join-us-footer-main">
       
        <script>
            let supported_binance_mainnet = "Supported Binance Mainnet and BNB.";
            let integrated_binance_dex = "Integrated Binance DEX and WalletConnect protocol.";
            let integrated_with_simplex = "Integrated with Simplex.";

            let january_text = "January";
            let october_text = "October";
            let may_text = "May";
            let june_text = "June";
            let july_text = "July";
            let december_text = "December";
            let august_text= "August";
            let september_text = "September";
            let march_text = "March";
            let november_text = "November";
            let february_text = "February";
            let april_text = "April";
            let safepal_was_founded = "<?= NAME ?> was founded";
            let received_strategic_investment_from_binance_Labs = "Received strategic investment from Binance Labs";
            let official_launch_of_safepal_s1_hardware_wallet = "Official launch of the <?= NAME ?> S1 hardware wallet";
            let release_of_safepal_cross_chain_swap = "Release of <?= NAME ?> cross-chain swap";
            let release_of_safepal_dappstore = "- Release of <?= NAME ?> Dappstore<br/>- Integration of Binance Dapp";
            let received_strategic_investment_from_animoca_brands = "Received strategic investment from Animoca Brands";
            let issuing_of_decentralized_utility_token_sfp = "Issuing of decentralized utility token $SFP";
            let safepal_becomes_the_first_binance_launchpad_project = "<?= NAME ?> becomes the first Binance launchpad project";
            let introduction_of_the_wallet_holder_offering_program = "Introduction of the wallet holder offering program (WHO)";
            let launch_of_safepal_earn_yield_aggregator = "Launch of <?= NAME ?> Earn yield aggregator";
            let introduction_of_safepal_giftbox_program = "Introduction of <?= NAME ?> Giftbox program";
            let achieved_5m_users = "Achieved 5M+ users";
            let safepal_becomes_full_wallet_suite_with_official = "<?= NAME ?> becomes full wallet suite with official release of browser extension wallet";
            let integration_of_mexc_mini_program = "Integration of MEXC mini program";
            let launch_of_new_brand_image = "Launch of new brand image";
            let safepal_achieves_75m_users = `<?= NAME ?> achieves 7.5M users`;
            let integration_of_bitget_mini_program = "Integration of Bitget mini program";
            let safepal_achieves_10m_users = "- <?= NAME ?> achieves 10M+ users<br/>- <?= NAME ?> supports 100+ blockchains with introduction of custom RPC";
            let expansion_of_sfp_from_bep20_to_erc20 = `Expansion of $SFP from BEP20 to ERC20`;
            let official_launch_of_the_safepal_s1_pro_hardware_wallet = "-Official launch of the <?= NAME ?> S1 Pro hardware wallet<br/>-Official launch and open source for the <?= NAME ?> X1 Bluetooth hardware wallet<br/>-Open source of the <?= NAME ?> mobile app code for essential functions";
            let safepal_supports_200_regions_with_official_distribution_channels_and_resellers = "<?= NAME ?> supports 200+ regions with official distribution channels and resellers";
            let safepal_launches_cedefi_banking_gateway_and_visa_card_with_fiat24 = "<?= NAME ?> launches CeDeFi banking gateway and Mastercard with Fiat24";
            let released_safepal_software_wallet = "Released <?= NAME ?> Software wallet";

            let received_strategic_investment_from_temasek = "Received strategic investment from Temasek fund";
            let launch_sfplus = "Launch of SFPlus staking hub";
            let reaches_20m_mastercard = "<?= NAME ?> reaches 20M+ users and launches Debit Mastercard";
        </script>
<!-- ======= Footer ======= -->
<?php include 'assets/footer.php' ?>