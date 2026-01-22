<?php 
    include 'assets/header.php';
?>

<!-- ======= Header ======= -->
<header id="header" class="fixed-top d-flex align-items-center header-transparent">
    <?php include 'assets/navbar.php'; ?>
</header><!-- End Header -->

<link href="../../assets/vendor/bootstarp-select/bootstrap-select.min.css" rel="stylesheet">
<link href="../../assets/vendor/bootstrap-table/bootstrap-table.min.css" rel="stylesheet">
<link href="../../assets/css/assets496d.css?v=202601151767855013676" rel="stylesheet">
<style>
    /* Search Section Responsiveness */
    .search-section {
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
        width: 100%;
    }

    .search-input-wrapper {
        flex: 1;
        min-width: 250px;
    }

    #search-input::placeholder {
        color: #666;
    }

    /* Desktop Search Button Hover */
    #search_coin_button:hover {
        background: linear-gradient(135deg, #7d3ff0 0%, #8a4aff 100%);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(98, 47, 170, 0.3);
    }

    #search_coin_button:active {
        transform: translateY(0);
    }

    /* Mobile Filter Button Styling */
    #filter_toggle_btn {
        flex-shrink: 0;
    }

    #filter_toggle_btn:hover {
        background: #622faa !important;
        color: #fff !important;
    }

    /* Mobile Responsive */
    @media (max-width: 992px) {
        .search-section {
            flex-direction: column;
        }

        .search-input-wrapper {
            width: 100%;
        }

        #filter_toggle_btn {
            width: 100%;
        }
    }

    /* Extra Small Screens */
    @media (max-width: 576px) {
        .search-section {
            margin-bottom: 16px;
        }

        .search-input-wrapper {
            min-width: 100%;
            font-size: 13px;
        }

        #search-input {
            font-size: 13px;
        }

        .pc-filter-section {
            padding: 16px;
        }

        .pc-filter-section .filter-item {
            min-width: 100%;
        }

        .mobile-filter-section {
            font-size: 12px;
        }

        .mobile-filters {
            grid-template-columns: 1fr;
        }
    }

    /* Smooth transitions */
    .search-input-wrapper,
    .selectpicker,
    #search_coin_button,
    #filter_toggle_btn {
        transition: all 0.3s ease;
    }

    /* Filter section styling */
    .pc-filter-section .filter-item select,
    .mobile-filter-section select {
        background-color: #0a0a0a;
        color: #e0e0e0;
        border: 1px solid #333;
        border-radius: 6px;
    }

    /* Selectpicker Bootstrap overrides */
    .selectpicker {
        border-color: #333 !important;
        background-color: #1a1a1a !important;
        color: #e0e0e0 !important;
    }

    .bootstrap-select > .dropdown-toggle {
        background-color: #1a1a1a !important;
        border: 1px solid #333 !important;
        color: #e0e0e0 !important;
    }

    .dropdown-menu {
        background-color: #1a1a1a !important;
        border: 1px solid #333 !important;
    }

    .dropdown-menu > li > a {
        color: #e0e0e0 !important;
    }

    .dropdown-menu > li > a:hover {
        background-color: #2a2a2a !important;
        color: #622faa !important;
    }

    .dropdown-menu > li.selected > a {
        background-color: #622faa !important;
        color: #fff !important;
    }
</style>
<main id="main" class="coin-list">
    <div id="hero-accepts" class="hero-accepts">
        <section id="hero">
            <div class="container d-flex justify-content-lg-start justify-content-center align-items-end flex-lg-row flex-column hero-container">
                <div class="left">
                    <div class="title">
                        <h3>SAFEPAL ASSETS</h3>
                    </div>
                    <div class="describe">
                        <p>Discover All the SafePal Supported Assets</p>
                    </div>
                </div>
                <div class="position-relative right">
                    <img class="img-fluid" src="https://www.safepal.com/assets/img/assets/hero-phone-shawdow.svg" alt="">
                    <img class="absolute img-fluid hero-phone" src="https://www.safepal.com/assets/img/assets/hero-phone_en.svg" alt="" onerror="handleImageError(this, `/assets/img/assets/hero-phone_en.svg`)">  
                    <img class="absolute img-fluid icons-sfp" src="https://www.safepal.com/assets/img/coin-icon/sfp.svg" alt="">
                    <img class="absolute img-fluid icons-btc" src="https://www.safepal.com/assets/img/coin-icon/btc.svg" alt="">
                    <!-- <img class="absolute img-fluid icons-eth" src="/assets/img/coin-icon/eth.svg" alt=""> -->
                    <img class="absolute img-fluid icons-group" src="https://www.safepal.com/assets/img/assets/icon-hero-icons-group.svg" alt="">
                    <img class="absolute d-none d-lg-block img-fluid move-animation-Y icons-xrp" src="https://www.safepal.com/assets/img/assets/icon-hero-xrp-coin.svg" alt="" srcset="">
                </div>
            </div>
        </section><!-- End Hero Section -->

        <!-- Top 50 Crypto Assets Section -->
        <section id="top-assets" class="top-assets-section" style="background: #121212; padding: 50px 0; border-bottom: 1px solid #333;">
            <div class="container">
                <div style="text-align: center; margin-bottom: 30px;">
                    <h3 style="color: #fff; font-size: 28px; margin-bottom: 10px;">Top 50 Cryptocurrency Assets</h3>
                    <p style="color: #e0e0e0; font-size: 14px;">Browse the most popular cryptocurrencies with verified links to official websites</p>
                </div>
                <!-- Search & Filters -->
                <div class="search-section" style="margin-bottom:18px;">
                    <div class="search-input-wrapper" style="display:flex; align-items:center; border:1px solid #333; padding:6px 8px; border-radius:8px; background:#0f0f0f;">
                        <input id="search-input" type="text" placeholder="Search assets (name or symbol)" style="flex:1; border:0; outline:0; background:transparent; color:#e0e0e0; padding:8px 10px;">
                        <button id="search_coin_button" class="btn btn-sm" style="background:#1a1a1a; color:#622faa; border:1px solid #333; padding:6px 10px; border-radius:6px; margin-left:8px;">Search</button>
                    </div>

                    <div class="pc-filter-section" style="display:flex; gap:10px; margin-left:12px; align-items:center;">
                        <select id="typeSelect" class="selectpicker" title="Type" style="min-width:140px; padding:8px;">
                            <option value="">All Types</option>
                            <option value="coin">Coin</option>
                            <option value="token">Token</option>
                        </select>
                        <select id="networkSelectBox" class="selectpicker" title="Network" style="min-width:160px; padding:8px;">
                            <option value="">All Networks</option>
                            <option value="eth">Ethereum</option>
                            <option value="bsc">BNB Chain</option>
                            <option value="sol">Solana</option>
                        </select>
                        <select id="buySelect" class="selectpicker" title="Buy" style="min-width:120px; padding:8px;">
                            <option value="">Buy Options</option>
                            <option value="onramp">On-ramp</option>
                        </select>
                    </div>
                </div>

                <!-- Desktop Table View -->
                <div class="d-none d-lg-block">
                    <table style="width: 100%; border-collapse: collapse; background: #1a1a1a; border-radius: 8px; overflow: hidden;">
                        <thead>
                            <tr style="border-bottom: 2px solid #622faa;">
                                <th style="padding: 15px 20px; text-align: left; color: #fff; font-weight: 600; background: #1e1e1e;">Asset</th>
                                <th style="padding: 15px 20px; text-align: center; color: #fff; font-weight: 600; background: #1e1e1e;">Symbol</th>
                                <th style="padding: 15px 20px; text-align: center; color: #fff; font-weight: 600; background: #1e1e1e;">Official Website</th>
                            </tr>
                        </thead>
                        <tbody id="crypto-table-body">
                            <tr class="crypto-row" data-search="Bitcoin BTC" style="border-bottom: 1px solid #262626; transition: all 0.3s;"><td style="padding: 15px 20px; color: #e0e0e0;"><strong>Bitcoin</strong></td><td style="padding: 15px 20px; text-align: center; color: #aaa;">BTC</td><td style="padding: 15px 20px; text-align: center;"><a href="https://bitcoin.org" target="_blank" style="color: #622faa; text-decoration: none; font-weight: 600;">bitcoin.org</a></td></tr>
                            <tr class="crypto-row" data-search="Ethereum ETH" style="border-bottom: 1px solid #262626; transition: all 0.3s;"><td style="padding: 15px 20px; color: #e0e0e0;"><strong>Ethereum</strong></td><td style="padding: 15px 20px; text-align: center; color: #aaa;">ETH</td><td style="padding: 15px 20px; text-align: center;"><a href="https://ethereum.org" target="_blank" style="color: #622faa; text-decoration: none; font-weight: 600;">ethereum.org</a></td></tr>
                            <tr class="crypto-row" data-search="Solana SOL" style="border-bottom: 1px solid #262626; transition: all 0.3s;"><td style="padding: 15px 20px; color: #e0e0e0;"><strong>Solana</strong></td><td style="padding: 15px 20px; text-align: center; color: #aaa;">SOL</td><td style="padding: 15px 20px; text-align: center;"><a href="https://solana.com" target="_blank" style="color: #622faa; text-decoration: none; font-weight: 600;">solana.com</a></td></tr>
                            <tr class="crypto-row" data-search="BNB BNB" style="border-bottom: 1px solid #262626; transition: all 0.3s;"><td style="padding: 15px 20px; color: #e0e0e0;"><strong>BNB</strong></td><td style="padding: 15px 20px; text-align: center; color: #aaa;">BNB</td><td style="padding: 15px 20px; text-align: center;"><a href="https://www.bnbchain.org" target="_blank" style="color: #622faa; text-decoration: none; font-weight: 600;">bnbchain.org</a></td></tr>
                            <tr class="crypto-row" data-search="XRP XRP" style="border-bottom: 1px solid #262626; transition: all 0.3s;"><td style="padding: 15px 20px; color: #e0e0e0;"><strong>XRP</strong></td><td style="padding: 15px 20px; text-align: center; color: #aaa;">XRP</td><td style="padding: 15px 20px; text-align: center;"><a href="https://xrpl.org" target="_blank" style="color: #622faa; text-decoration: none; font-weight: 600;">xrpl.org</a></td></tr>
                            <tr class="crypto-row" data-search="Cardano ADA" style="border-bottom: 1px solid #262626; transition: all 0.3s;"><td style="padding: 15px 20px; color: #e0e0e0;"><strong>Cardano</strong></td><td style="padding: 15px 20px; text-align: center; color: #aaa;">ADA</td><td style="padding: 15px 20px; text-align: center;"><a href="https://cardano.org" target="_blank" style="color: #622faa; text-decoration: none; font-weight: 600;">cardano.org</a></td></tr>
                            <tr class="crypto-row" data-search="Polkadot DOT" style="border-bottom: 1px solid #262626; transition: all 0.3s;"><td style="padding: 15px 20px; color: #e0e0e0;"><strong>Polkadot</strong></td><td style="padding: 15px 20px; text-align: center; color: #aaa;">DOT</td><td style="padding: 15px 20px; text-align: center;"><a href="https://polkadot.network" target="_blank" style="color: #622faa; text-decoration: none; font-weight: 600;">polkadot.network</a></td></tr>
                            <tr class="crypto-row" data-search="Toncoin TON" style="border-bottom: 1px solid #262626; transition: all 0.3s;"><td style="padding: 15px 20px; color: #e0e0e0;"><strong>Toncoin</strong></td><td style="padding: 15px 20px; text-align: center; color: #aaa;">TON</td><td style="padding: 15px 20px; text-align: center;"><a href="https://ton.org" target="_blank" style="color: #622faa; text-decoration: none; font-weight: 600;">ton.org</a></td></tr>
                            <tr class="crypto-row" data-search="Dogecoin DOGE" style="border-bottom: 1px solid #262626; transition: all 0.3s;"><td style="padding: 15px 20px; color: #e0e0e0;"><strong>Dogecoin</strong></td><td style="padding: 15px 20px; text-align: center; color: #aaa;">DOGE</td><td style="padding: 15px 20px; text-align: center;"><a href="https://dogecoin.com" target="_blank" style="color: #622faa; text-decoration: none; font-weight: 600;">dogecoin.com</a></td></tr>
                            <tr class="crypto-row" data-search="Polygon MATIC" style="border-bottom: 1px solid #262626; transition: all 0.3s;"><td style="padding: 15px 20px; color: #e0e0e0;"><strong>Polygon</strong></td><td style="padding: 15px 20px; text-align: center; color: #aaa;">MATIC</td><td style="padding: 15px 20px; text-align: center;"><a href="https://polygon.technology" target="_blank" style="color: #622faa; text-decoration: none; font-weight: 600;">polygon.technology</a></td></tr>
                            <tr class="crypto-row" data-search="Litecoin LTC" style="border-bottom: 1px solid #262626; transition: all 0.3s;"><td style="padding: 15px 20px; color: #e0e0e0;"><strong>Litecoin</strong></td><td style="padding: 15px 20px; text-align: center; color: #aaa;">LTC</td><td style="padding: 15px 20px; text-align: center;"><a href="https://litecoin.org" target="_blank" style="color: #622faa; text-decoration: none; font-weight: 600;">litecoin.org</a></td></tr>
                            <tr class="crypto-row" data-search="Bitcoin Cash BCH" style="border-bottom: 1px solid #262626; transition: all 0.3s;"><td style="padding: 15px 20px; color: #e0e0e0;"><strong>Bitcoin Cash</strong></td><td style="padding: 15px 20px; text-align: center; color: #aaa;">BCH</td><td style="padding: 15px 20px; text-align: center;"><a href="https://bitcoincash.org" target="_blank" style="color: #622faa; text-decoration: none; font-weight: 600;">bitcoincash.org</a></td></tr>
                            <tr class="crypto-row" data-search="TRON TRX" style="border-bottom: 1px solid #262626; transition: all 0.3s;"><td style="padding: 15px 20px; color: #e0e0e0;"><strong>TRON</strong></td><td style="padding: 15px 20px; text-align: center; color: #aaa;">TRX</td><td style="padding: 15px 20px; text-align: center;"><a href="https://tron.network" target="_blank" style="color: #622faa; text-decoration: none; font-weight: 600;">tron.network</a></td></tr>
                            <tr class="crypto-row" data-search="Avalanche AVAX" style="border-bottom: 1px solid #262626; transition: all 0.3s;"><td style="padding: 15px 20px; color: #e0e0e0;"><strong>Avalanche</strong></td><td style="padding: 15px 20px; text-align: center; color: #aaa;">AVAX</td><td style="padding: 15px 20px; text-align: center;"><a href="https://www.avax.network" target="_blank" style="color: #622faa; text-decoration: none; font-weight: 600;">avax.network</a></td></tr>
                            <tr class="crypto-row" data-search="Chainlink LINK" style="border-bottom: 1px solid #262626; transition: all 0.3s;"><td style="padding: 15px 20px; color: #e0e0e0;"><strong>Chainlink</strong></td><td style="padding: 15px 20px; text-align: center; color: #aaa;">LINK</td><td style="padding: 15px 20px; text-align: center;"><a href="https://chain.link" target="_blank" style="color: #622faa; text-decoration: none; font-weight: 600;">chain.link</a></td></tr>
                            <tr class="crypto-row" data-search="Uniswap UNI" style="border-bottom: 1px solid #262626; transition: all 0.3s;"><td style="padding: 15px 20px; color: #e0e0e0;"><strong>Uniswap</strong></td><td style="padding: 15px 20px; text-align: center; color: #aaa;">UNI</td><td style="padding: 15px 20px; text-align: center;"><a href="https://uniswap.org" target="_blank" style="color: #622faa; text-decoration: none; font-weight: 600;">uniswap.org</a></td></tr>
                            <tr class="crypto-row" data-search="Cosmos ATOM" style="border-bottom: 1px solid #262626; transition: all 0.3s;"><td style="padding: 15px 20px; color: #e0e0e0;"><strong>Cosmos</strong></td><td style="padding: 15px 20px; text-align: center; color: #aaa;">ATOM</td><td style="padding: 15px 20px; text-align: center;"><a href="https://cosmos.network" target="_blank" style="color: #622faa; text-decoration: none; font-weight: 600;">cosmos.network</a></td></tr>
                            <tr class="crypto-row" data-search="Arbitrum ARB" style="border-bottom: 1px solid #262626; transition: all 0.3s;"><td style="padding: 15px 20px; color: #e0e0e0;"><strong>Arbitrum</strong></td><td style="padding: 15px 20px; text-align: center; color: #aaa;">ARB</td><td style="padding: 15px 20px; text-align: center;"><a href="https://arbitrum.io" target="_blank" style="color: #622faa; text-decoration: none; font-weight: 600;">arbitrum.io</a></td></tr>
                            <tr class="crypto-row" data-search="Stellar XLM" style="border-bottom: 1px solid #262626; transition: all 0.3s;"><td style="padding: 15px 20px; color: #e0e0e0;"><strong>Stellar</strong></td><td style="padding: 15px 20px; text-align: center; color: #aaa;">XLM</td><td style="padding: 15px 20px; text-align: center;"><a href="https://stellar.org" target="_blank" style="color: #622faa; text-decoration: none; font-weight: 600;">stellar.org</a></td></tr>
                            <tr class="crypto-row" data-search="Monero XMR" style="border-bottom: 1px solid #262626; transition: all 0.3s;"><td style="padding: 15px 20px; color: #e0e0e0;"><strong>Monero</strong></td><td style="padding: 15px 20px; text-align: center; color: #aaa;">XMR</td><td style="padding: 15px 20px; text-align: center;"><a href="https://www.getmonero.org" target="_blank" style="color: #622faa; text-decoration: none; font-weight: 600;">getmonero.org</a></td></tr>
                            <tr class="crypto-row" data-search="Aave AAVE" style="border-bottom: 1px solid #262626; transition: all 0.3s;"><td style="padding: 15px 20px; color: #e0e0e0;"><strong>Aave</strong></td><td style="padding: 15px 20px; text-align: center; color: #aaa;">AAVE</td><td style="padding: 15px 20px; text-align: center;"><a href="https://aave.com" target="_blank" style="color: #622faa; text-decoration: none; font-weight: 600;">aave.com</a></td></tr>
                            <tr class="crypto-row" data-search="Sushi SUSHI" style="border-bottom: 1px solid #262626; transition: all 0.3s;"><td style="padding: 15px 20px; color: #e0e0e0;"><strong>Sushi</strong></td><td style="padding: 15px 20px; text-align: center; color: #aaa;">SUSHI</td><td style="padding: 15px 20px; text-align: center;"><a href="https://sushi.com" target="_blank" style="color: #622faa; text-decoration: none; font-weight: 600;">sushi.com</a></td></tr>
                            <tr class="crypto-row" data-search="Zcash ZEC" style="border-bottom: 1px solid #262626; transition: all 0.3s;"><td style="padding: 15px 20px; color: #e0e0e0;"><strong>Zcash</strong></td><td style="padding: 15px 20px; text-align: center; color: #aaa;">ZEC</td><td style="padding: 15px 20px; text-align: center;"><a href="https://z.cash" target="_blank" style="color: #622faa; text-decoration: none; font-weight: 600;">z.cash</a></td></tr>
                            <tr class="crypto-row" data-search="NEO NEO" style="border-bottom: 1px solid #262626; transition: all 0.3s;"><td style="padding: 15px 20px; color: #e0e0e0;"><strong>NEO</strong></td><td style="padding: 15px 20px; text-align: center; color: #aaa;">NEO</td><td style="padding: 15px 20px; text-align: center;"><a href="https://neo.org" target="_blank" style="color: #622faa; text-decoration: none; font-weight: 600;">neo.org</a></td></tr>
                            <tr class="crypto-row" data-search="IOTA IOTA" style="border-bottom: 1px solid #262626; transition: all 0.3s;"><td style="padding: 15px 20px; color: #e0e0e0;"><strong>IOTA</strong></td><td style="padding: 15px 20px; text-align: center; color: #aaa;">IOTA</td><td style="padding: 15px 20px; text-align: center;"><a href="https://iota.org" target="_blank" style="color: #622faa; text-decoration: none; font-weight: 600;">iota.org</a></td></tr>
                            <tr class="crypto-row" data-search="Kusama KSM" style="border-bottom: 1px solid #262626; transition: all 0.3s;"><td style="padding: 15px 20px; color: #e0e0e0;"><strong>Kusama</strong></td><td style="padding: 15px 20px; text-align: center; color: #aaa;">KSM</td><td style="padding: 15px 20px; text-align: center;"><a href="https://kusama.network" target="_blank" style="color: #622faa; text-decoration: none; font-weight: 600;">kusama.network</a></td></tr>
                            <tr class="crypto-row" data-search="NEM XEM" style="border-bottom: 1px solid #262626; transition: all 0.3s;"><td style="padding: 15px 20px; color: #e0e0e0;"><strong>NEM</strong></td><td style="padding: 15px 20px; text-align: center; color: #aaa;">XEM</td><td style="padding: 15px 20px; text-align: center;"><a href="https://nem.io" target="_blank" style="color: #622faa; text-decoration: none; font-weight: 600;">nem.io</a></td></tr>
                            <tr class="crypto-row" data-search="Dash DASH" style="border-bottom: 1px solid #262626; transition: all 0.3s;"><td style="padding: 15px 20px; color: #e0e0e0;"><strong>Dash</strong></td><td style="padding: 15px 20px; text-align: center; color: #aaa;">DASH</td><td style="padding: 15px 20px; text-align: center;"><a href="https://www.dash.org" target="_blank" style="color: #622faa; text-decoration: none; font-weight: 600;">dash.org</a></td></tr>
                            <tr class="crypto-row" data-search="0x ZRX" style="border-bottom: 1px solid #262626; transition: all 0.3s;"><td style="padding: 15px 20px; color: #e0e0e0;"><strong>0x</strong></td><td style="padding: 15px 20px; text-align: center; color: #aaa;">ZRX</td><td style="padding: 15px 20px; text-align: center;"><a href="https://0x.org" target="_blank" style="color: #622faa; text-decoration: none; font-weight: 600;">0x.org</a></td></tr>
                            <tr class="crypto-row" data-search="FTX Token FTT" style="border-bottom: 1px solid #262626; transition: all 0.3s;"><td style="padding: 15px 20px; color: #e0e0e0;"><strong>FTX Token</strong></td><td style="padding: 15px 20px; text-align: center; color: #aaa;">FTT</td><td style="padding: 15px 20px; text-align: center;"><a href="https://ftx.com" target="_blank" style="color: #622faa; text-decoration: none; font-weight: 600;">ftx.com</a></td></tr>
                            <tr class="crypto-row" data-search="BUSD BUSD" style="border-bottom: 1px solid #262626; transition: all 0.3s;"><td style="padding: 15px 20px; color: #e0e0e0;"><strong>Binance USD</strong></td><td style="padding: 15px 20px; text-align: center; color: #aaa;">BUSD</td><td style="padding: 15px 20px; text-align: center;"><a href="https://www.binance.com" target="_blank" style="color: #622faa; text-decoration: none; font-weight: 600;">binance.com</a></td></tr>
                            <tr class="crypto-row" data-search="USDC USDC" style="border-bottom: 1px solid #262626; transition: all 0.3s;"><td style="padding: 15px 20px; color: #e0e0e0;"><strong>USD Coin</strong></td><td style="padding: 15px 20px; text-align: center; color: #aaa;">USDC</td><td style="padding: 15px 20px; text-align: center;"><a href="https://www.circle.com/en/usdc" target="_blank" style="color: #622faa; text-decoration: none; font-weight: 600;">circle.com</a></td></tr>
                            <tr class="crypto-row" data-search="Tether USDT" style="border-bottom: 1px solid #262626; transition: all 0.3s;"><td style="padding: 15px 20px; color: #e0e0e0;"><strong>Tether</strong></td><td style="padding: 15px 20px; text-align: center; color: #aaa;">USDT</td><td style="padding: 15px 20px; text-align: center;"><a href="https://tether.to" target="_blank" style="color: #622faa; text-decoration: none; font-weight: 600;">tether.to</a></td></tr>
                            <tr class="crypto-row" data-search="Lido LDO" style="border-bottom: 1px solid #262626; transition: all 0.3s;"><td style="padding: 15px 20px; color: #e0e0e0;"><strong>Lido</strong></td><td style="padding: 15px 20px; text-align: center; color: #aaa;">LDO</td><td style="padding: 15px 20px; text-align: center;"><a href="https://lido.fi" target="_blank" style="color: #622faa; text-decoration: none; font-weight: 600;">lido.fi</a></td></tr>
                            <tr class="crypto-row" data-search="The Graph GRT" style="border-bottom: 1px solid #262626; transition: all 0.3s;"><td style="padding: 15px 20px; color: #e0e0e0;"><strong>The Graph</strong></td><td style="padding: 15px 20px; text-align: center; color: #aaa;">GRT</td><td style="padding: 15px 20px; text-align: center;"><a href="https://thegraph.com" target="_blank" style="color: #622faa; text-decoration: none; font-weight: 600;">thegraph.com</a></td></tr>
                            <tr class="crypto-row" data-search="ApeCoin APE" style="border-bottom: 1px solid #262626; transition: all 0.3s;"><td style="padding: 15px 20px; color: #e0e0e0;"><strong>ApeCoin</strong></td><td style="padding: 15px 20px; text-align: center; color: #aaa;">APE</td><td style="padding: 15px 20px; text-align: center;"><a href="https://apecoin.com" target="_blank" style="color: #622faa; text-decoration: none; font-weight: 600;">apecoin.com</a></td></tr>
                            <tr class="crypto-row" data-search="Sandbox SAND" style="border-bottom: 1px solid #262626; transition: all 0.3s;"><td style="padding: 15px 20px; color: #e0e0e0;"><strong>Sandbox</strong></td><td style="padding: 15px 20px; text-align: center; color: #aaa;">SAND</td><td style="padding: 15px 20px; text-align: center;"><a href="https://www.sandbox.game" target="_blank" style="color: #622faa; text-decoration: none; font-weight: 600;">sandbox.game</a></td></tr>
                            <tr class="crypto-row" data-search="Decentraland MANA" style="border-bottom: 1px solid #262626; transition: all 0.3s;"><td style="padding: 15px 20px; color: #e0e0e0;"><strong>Decentraland</strong></td><td style="padding: 15px 20px; text-align: center; color: #aaa;">MANA</td><td style="padding: 15px 20px; text-align: center;"><a href="https://decentraland.org" target="_blank" style="color: #622faa; text-decoration: none; font-weight: 600;">decentraland.org</a></td></tr>
                            <tr class="crypto-row" data-search="Enjin ENJ" style="border-bottom: 1px solid #262626; transition: all 0.3s;"><td style="padding: 15px 20px; color: #e0e0e0;"><strong>Enjin</strong></td><td style="padding: 15px 20px; text-align: center; color: #aaa;">ENJ</td><td style="padding: 15px 20px; text-align: center;"><a href="https://enjin.io" target="_blank" style="color: #622faa; text-decoration: none; font-weight: 600;">enjin.io</a></td></tr>
                            <tr class="crypto-row" data-search="Celsius CEL" style="border-bottom: 1px solid #262626; transition: all 0.3s;"><td style="padding: 15px 20px; color: #e0e0e0;"><strong>Celsius</strong></td><td style="padding: 15px 20px; text-align: center; color: #aaa;">CEL</td><td style="padding: 15px 20px; text-align: center;"><a href="https://celsius.network" target="_blank" style="color: #622faa; text-decoration: none; font-weight: 600;">celsius.network</a></td></tr>
                            <tr class="crypto-row" data-search="Compound COMP" style="border-bottom: 1px solid #262626; transition: all 0.3s;"><td style="padding: 15px 20px; color: #e0e0e0;"><strong>Compound</strong></td><td style="padding: 15px 20px; text-align: center; color: #aaa;">COMP</td><td style="padding: 15px 20px; text-align: center;"><a href="https://compound.finance" target="_blank" style="color: #622faa; text-decoration: none; font-weight: 600;">compound.finance</a></td></tr>
                            <tr class="crypto-row" data-search="yearn YFI" style="border-bottom: 1px solid #262626; transition: all 0.3s;"><td style="padding: 15px 20px; color: #e0e0e0;"><strong>yearn</strong></td><td style="padding: 15px 20px; text-align: center; color: #aaa;">YFI</td><td style="padding: 15px 20px; text-align: center;"><a href="https://yearn.finance" target="_blank" style="color: #622faa; text-decoration: none; font-weight: 600;">yearn.finance</a></td></tr>
                            <tr class="crypto-row" data-search="OMG OMG" style="border-bottom: 1px solid #262626; transition: all 0.3s;"><td style="padding: 15px 20px; color: #e0e0e0;"><strong>OMG Network</strong></td><td style="padding: 15px 20px; text-align: center; color: #aaa;">OMG</td><td style="padding: 15px 20px; text-align: center;"><a href="https://omg.network" target="_blank" style="color: #622faa; text-decoration: none; font-weight: 600;">omg.network</a></td></tr>
                            <tr class="crypto-row" data-search="Synthetix SNX" style="border-bottom: 1px solid #262626; transition: all 0.3s;"><td style="padding: 15px 20px; color: #e0e0e0;"><strong>Synthetix</strong></td><td style="padding: 15px 20px; text-align: center; color: #aaa;">SNX</td><td style="padding: 15px 20px; text-align: center;"><a href="https://synthetix.io" target="_blank" style="color: #622faa; text-decoration: none; font-weight: 600;">synthetix.io</a></td></tr>
                            <tr class="crypto-row" data-search="Ren REN" style="border-bottom: 1px solid #262626; transition: all 0.3s;"><td style="padding: 15px 20px; color: #e0e0e0;"><strong>Ren</strong></td><td style="padding: 15px 20px; text-align: center; color: #aaa;">REN</td><td style="padding: 15px 20px; text-align: center;"><a href="https://renproject.io" target="_blank" style="color: #622faa; text-decoration: none; font-weight: 600;">renproject.io</a></td></tr>
                            <tr class="crypto-row" data-search="Holo HOT" style="border-bottom: 1px solid #262626; transition: all 0.3s;"><td style="padding: 15px 20px; color: #e0e0e0;"><strong>Holo</strong></td><td style="padding: 15px 20px; text-align: center; color: #aaa;">HOT</td><td style="padding: 15px 20px; text-align: center;"><a href="https://holo.host" target="_blank" style="color: #622faa; text-decoration: none; font-weight: 600;">holo.host</a></td></tr>
                            <tr class="crypto-row" data-search="Chiliz CHZ" style="border-bottom: 1px solid #262626; transition: all 0.3s;"><td style="padding: 15px 20px; color: #e0e0e0;"><strong>Chiliz</strong></td><td style="padding: 15px 20px; text-align: center; color: #aaa;">CHZ</td><td style="padding: 15px 20px; text-align: center;"><a href="https://www.chiliz.com" target="_blank" style="color: #622faa; text-decoration: none; font-weight: 600;">chiliz.com</a></td></tr>
                            <tr class="crypto-row" data-search="BitTorrent BTT" style="border-bottom: 1px solid #262626; transition: all 0.3s;"><td style="padding: 15px 20px; color: #e0e0e0;"><strong>BitTorrent</strong></td><td style="padding: 15px 20px; text-align: center; color: #aaa;">BTT</td><td style="padding: 15px 20px; text-align: center;"><a href="https://www.bittorrent.com" target="_blank" style="color: #622faa; text-decoration: none; font-weight: 600;">bittorrent.com</a></td></tr>
                            <tr class="crypto-row" data-search="Helium HNT" style="border-bottom: 1px solid #262626; transition: all 0.3s;"><td style="padding: 15px 20px; color: #e0e0e0;"><strong>Helium</strong></td><td style="padding: 15px 20px; text-align: center; color: #aaa;">HNT</td><td style="padding: 15px 20px; text-align: center;"><a href="https://www.helium.com" target="_blank" style="color: #622faa; text-decoration: none; font-weight: 600;">helium.com</a></td></tr>
                            <tr class="crypto-row" data-search="Gala GALA" style="border-bottom: 1px solid #262626; transition: all 0.3s;"><td style="padding: 15px 20px; color: #e0e0e0;"><strong>Gala</strong></td><td style="padding: 15px 20px; text-align: center; color: #aaa;">GALA</td><td style="padding: 15px 20px; text-align: center;"><a href="https://gala.games" target="_blank" style="color: #622faa; text-decoration: none; font-weight: 600;">gala.games</a></td></tr>
                        </tbody>
                    </table>
                </div>

                <!-- Mobile Card View -->
                <div class="d-lg-none" id="crypto-cards" style="display: grid; grid-template-columns: 1fr; gap: 12px;">
                    <div class="crypto-card" data-search="Bitcoin BTC" style="background: #1e1e1e; border: 1px solid #333; border-radius: 8px; padding: 15px; transition: all 0.3s;"><div style="display: flex; justify-content: space-between; align-items: center;"><strong style="color: #e0e0e0;">Bitcoin (BTC)</strong><a href="https://bitcoin.org" target="_blank" style="color: #622faa; text-decoration: none; font-size: 12px; font-weight: 600;">Visit</a></div></div>
                    <div class="crypto-card" data-search="Ethereum ETH" style="background: #1e1e1e; border: 1px solid #333; border-radius: 8px; padding: 15px; transition: all 0.3s;"><div style="display: flex; justify-content: space-between; align-items: center;"><strong style="color: #e0e0e0;">Ethereum (ETH)</strong><a href="https://ethereum.org" target="_blank" style="color: #622faa; text-decoration: none; font-size: 12px; font-weight: 600;">Visit</a></div></div>
                    <div class="crypto-card" data-search="Solana SOL" style="background: #1e1e1e; border: 1px solid #333; border-radius: 8px; padding: 15px; transition: all 0.3s;"><div style="display: flex; justify-content: space-between; align-items: center;"><strong style="color: #e0e0e0;">Solana (SOL)</strong><a href="https://solana.com" target="_blank" style="color: #622faa; text-decoration: none; font-size: 12px; font-weight: 600;">Visit</a></div></div>
                    <div class="crypto-card" data-search="BNB BNB" style="background: #1e1e1e; border: 1px solid #333; border-radius: 8px; padding: 15px; transition: all 0.3s;"><div style="display: flex; justify-content: space-between; align-items: center;"><strong style="color: #e0e0e0;">BNB</strong><a href="https://www.bnbchain.org" target="_blank" style="color: #622faa; text-decoration: none; font-size: 12px; font-weight: 600;">Visit</a></div></div>
                    <div class="crypto-card" data-search="XRP XRP" style="background: #1e1e1e; border: 1px solid #333; border-radius: 8px; padding: 15px; transition: all 0.3s;"><div style="display: flex; justify-content: space-between; align-items: center;"><strong style="color: #e0e0e0;">XRP</strong><a href="https://xrpl.org" target="_blank" style="color: #622faa; text-decoration: none; font-size: 12px; font-weight: 600;">Visit</a></div></div>
                    <div class="crypto-card" data-search="Cardano ADA" style="background: #1e1e1e; border: 1px solid #333; border-radius: 8px; padding: 15px; transition: all 0.3s;"><div style="display: flex; justify-content: space-between; align-items: center;"><strong style="color: #e0e0e0;">Cardano (ADA)</strong><a href="https://cardano.org" target="_blank" style="color: #622faa; text-decoration: none; font-size: 12px; font-weight: 600;">Visit</a></div></div>
                    <div class="crypto-card" data-search="Polkadot DOT" style="background: #1e1e1e; border: 1px solid #333; border-radius: 8px; padding: 15px; transition: all 0.3s;"><div style="display: flex; justify-content: space-between; align-items: center;"><strong style="color: #e0e0e0;">Polkadot (DOT)</strong><a href="https://polkadot.network" target="_blank" style="color: #622faa; text-decoration: none; font-size: 12px; font-weight: 600;">Visit</a></div></div>
                    <div class="crypto-card" data-search="Toncoin TON" style="background: #1e1e1e; border: 1px solid #333; border-radius: 8px; padding: 15px; transition: all 0.3s;"><div style="display: flex; justify-content: space-between; align-items: center;"><strong style="color: #e0e0e0;">Toncoin (TON)</strong><a href="https://ton.org" target="_blank" style="color: #622faa; text-decoration: none; font-size: 12px; font-weight: 600;">Visit</a></div></div>
                    <div class="crypto-card" data-search="Dogecoin DOGE" style="background: #1e1e1e; border: 1px solid #333; border-radius: 8px; padding: 15px; transition: all 0.3s;"><div style="display: flex; justify-content: space-between; align-items: center;"><strong style="color: #e0e0e0;">Dogecoin (DOGE)</strong><a href="https://dogecoin.com" target="_blank" style="color: #622faa; text-decoration: none; font-size: 12px; font-weight: 600;">Visit</a></div></div>
                    <div class="crypto-card" data-search="Polygon MATIC" style="background: #1e1e1e; border: 1px solid #333; border-radius: 8px; padding: 15px; transition: all 0.3s;"><div style="display: flex; justify-content: space-between; align-items: center;"><strong style="color: #e0e0e0;">Polygon (MATIC)</strong><a href="https://polygon.technology" target="_blank" style="color: #622faa; text-decoration: none; font-size: 12px; font-weight: 600;">Visit</a></div></div>
                    <div class="crypto-card" data-search="Litecoin LTC" style="background: #1e1e1e; border: 1px solid #333; border-radius: 8px; padding: 15px; transition: all 0.3s;"><div style="display: flex; justify-content: space-between; align-items: center;"><strong style="color: #e0e0e0;">Litecoin (LTC)</strong><a href="https://litecoin.org" target="_blank" style="color: #622faa; text-decoration: none; font-size: 12px; font-weight: 600;">Visit</a></div></div>
                    <div class="crypto-card" data-search="Bitcoin Cash BCH" style="background: #1e1e1e; border: 1px solid #333; border-radius: 8px; padding: 15px; transition: all 0.3s;"><div style="display: flex; justify-content: space-between; align-items: center;"><strong style="color: #e0e0e0;">Bitcoin Cash (BCH)</strong><a href="https://bitcoincash.org" target="_blank" style="color: #622faa; text-decoration: none; font-size: 12px; font-weight: 600;">Visit</a></div></div>
                    <div class="crypto-card" data-search="TRON TRX" style="background: #1e1e1e; border: 1px solid #333; border-radius: 8px; padding: 15px; transition: all 0.3s;"><div style="display: flex; justify-content: space-between; align-items: center;"><strong style="color: #e0e0e0;">TRON (TRX)</strong><a href="https://tron.network" target="_blank" style="color: #622faa; text-decoration: none; font-size: 12px; font-weight: 600;">Visit</a></div></div>
                    <div class="crypto-card" data-search="Avalanche AVAX" style="background: #1e1e1e; border: 1px solid #333; border-radius: 8px; padding: 15px; transition: all 0.3s;"><div style="display: flex; justify-content: space-between; align-items: center;"><strong style="color: #e0e0e0;">Avalanche (AVAX)</strong><a href="https://www.avax.network" target="_blank" style="color: #622faa; text-decoration: none; font-size: 12px; font-weight: 600;">Visit</a></div></div>
                    <div class="crypto-card" data-search="Chainlink LINK" style="background: #1e1e1e; border: 1px solid #333; border-radius: 8px; padding: 15px; transition: all 0.3s;"><div style="display: flex; justify-content: space-between; align-items: center;"><strong style="color: #e0e0e0;">Chainlink (LINK)</strong><a href="https://chain.link" target="_blank" style="color: #622faa; text-decoration: none; font-size: 12px; font-weight: 600;">Visit</a></div></div>
                    <div class="crypto-card" data-search="Uniswap UNI" style="background: #1e1e1e; border: 1px solid #333; border-radius: 8px; padding: 15px; transition: all 0.3s;"><div style="display: flex; justify-content: space-between; align-items: center;"><strong style="color: #e0e0e0;">Uniswap (UNI)</strong><a href="https://uniswap.org" target="_blank" style="color: #622faa; text-decoration: none; font-size: 12px; font-weight: 600;">Visit</a></div></div>
                    <div class="crypto-card" data-search="Cosmos ATOM" style="background: #1e1e1e; border: 1px solid #333; border-radius: 8px; padding: 15px; transition: all 0.3s;"><div style="display: flex; justify-content: space-between; align-items: center;"><strong style="color: #e0e0e0;">Cosmos (ATOM)</strong><a href="https://cosmos.network" target="_blank" style="color: #622faa; text-decoration: none; font-size: 12px; font-weight: 600;">Visit</a></div></div>
                    <div class="crypto-card" data-search="Arbitrum ARB" style="background: #1e1e1e; border: 1px solid #333; border-radius: 8px; padding: 15px; transition: all 0.3s;"><div style="display: flex; justify-content: space-between; align-items: center;"><strong style="color: #e0e0e0;">Arbitrum (ARB)</strong><a href="https://arbitrum.io" target="_blank" style="color: #622faa; text-decoration: none; font-size: 12px; font-weight: 600;">Visit</a></div></div>
                    <div class="crypto-card" data-search="Stellar XLM" style="background: #1e1e1e; border: 1px solid #333; border-radius: 8px; padding: 15px; transition: all 0.3s;"><div style="display: flex; justify-content: space-between; align-items: center;"><strong style="color: #e0e0e0;">Stellar (XLM)</strong><a href="https://stellar.org" target="_blank" style="color: #622faa; text-decoration: none; font-size: 12px; font-weight: 600;">Visit</a></div></div>
                    <div class="crypto-card" data-search="Monero XMR" style="background: #1e1e1e; border: 1px solid #333; border-radius: 8px; padding: 15px; transition: all 0.3s;"><div style="display: flex; justify-content: space-between; align-items: center;"><strong style="color: #e0e0e0;">Monero (XMR)</strong><a href="https://www.getmonero.org" target="_blank" style="color: #622faa; text-decoration: none; font-size: 12px; font-weight: 600;">Visit</a></div></div>
                </div>
            </div>
        </section>
        <!-- End Top 20 Assets Section -->
    </div>
    
</main>

<script>
// Mobile filter toggle functionality
(function(){
    const filterToggleBtn = document.getElementById('filter_toggle_btn');
    const mobileFilterSection = document.getElementById('mobile_filter_section');
    const mobileFilterReset = document.getElementById('mobile_filter_reset');
    const mobileFilterApply = document.getElementById('mobile_filter_apply');
    
    if(filterToggleBtn) {
        filterToggleBtn.addEventListener('click', function() {
            const isHidden = mobileFilterSection.style.display === 'none';
            mobileFilterSection.style.display = isHidden ? 'block' : 'none';
            this.style.background = isHidden ? '#622faa' : '#1a1a1a';
            this.style.color = isHidden ? '#fff' : '#622faa';
        });
    }
    
    if(mobileFilterReset) {
        mobileFilterReset.addEventListener('click', function() {
            document.getElementById('mtypeSelect').value = '';
            document.getElementById('networkSelectBoxm').value = '';
            document.getElementById('mbuySelect').value = '';
            document.getElementById('mswapSelect').value = '';
            document.getElementById('mwalletSelect').value = '';
            // Refresh select pickers if using Bootstrap Select
            if(window.$) {
                $('.selectpicker').selectpicker('refresh');
            }
        });
    }
})();

// Search input styling enhancements
(function(){
    const searchInput = document.getElementById('search-input');
    const searchInputWrapper = document.querySelector('.search-input-wrapper');
    
    if(searchInput && searchInputWrapper) {
        // Focus styling
        searchInput.addEventListener('focus', function() {
            searchInputWrapper.style.borderColor = '#622faa';
            searchInputWrapper.style.boxShadow = '0 0 0 2px rgba(98, 47, 170, 0.2)';
        });
        
        // Blur styling
        searchInput.addEventListener('blur', function() {
            searchInputWrapper.style.borderColor = '#333';
            searchInputWrapper.style.boxShadow = 'none';
        });
    }
})();

// Top 20 Assets search filter
(function(){
    const searchInput = document.getElementById('search-input');
    const searchBtn = document.getElementById('search_coin_button');
    const tableRows = document.querySelectorAll('.crypto-row');
    const cardElements = document.querySelectorAll('.crypto-card');
    
    function filterCryptos(query) {
        const lowerQuery = query.toLowerCase().trim();
        
        tableRows.forEach(row => {
            const searchText = row.dataset.search.toLowerCase();
            const match = searchText.includes(lowerQuery) || lowerQuery === '';
            row.style.display = match ? '' : 'none';
        });
        
        cardElements.forEach(card => {
            const searchText = card.dataset.search.toLowerCase();
            const match = searchText.includes(lowerQuery) || lowerQuery === '';
            card.style.display = match ? '' : 'none';
        });
    }
    
    if(searchInput) {
        searchInput.addEventListener('keyup', (e) => filterCryptos(e.target.value));
    }
    
    if(searchBtn) {
        searchBtn.addEventListener('click', (e) => {
            e.preventDefault();
            filterCryptos(searchInput.value);
        });
    }
})();
</script>


<div class="start-soar-footer">
    <!-- ================= ---------start - soar--------- ===================== -->
    
    <script>
        var $mobile_wallet="Mobile Wallet";
        var $s1_hardware_wallet = "S1 Hardware Wallet";
        var x1_hardware = "X1 Hardware Wallet";
        var $table_name = "Name";
        var $extension_wallet = "Extension Wallet";
        var $name_text = "Name";
        var $type_text = "Type";
        var $network_text = "Network";
        var $buy_text = "Buy";
        var $swap_text = "Swap";
        var $supported_wallet = "Supported Wallet";
        var $crypto_not_supported = "This crypto is not supported yet.";
        var $submit_token = "Submit Token";
        var all = "All";
        var s1_s1_pro = "S1/S1 Pro";
        var s1_tooltip_tips = `This asset is only available on <a style='color: #4A21EF' class='ahref' href='https://www.safepal.com/en/blog/hardware-wallet-upgrade' target='_blank' rel='noopener noreferrer'>S1/S1 Pro upgraded to the EAL6+ chipset.</a> For queries, please <a style='color: #4A21EF' class='ahref' href='https://safepalsupport.zendesk.com/hc/en-us/requests/new?ticket_form_id=360001760732' target='_blank' rel='noopener noreferrer'>contact us.</a>`;
    </script>

    <!-- ======= Footer ======= -->
<?php include 'assets/footer.php' ?>