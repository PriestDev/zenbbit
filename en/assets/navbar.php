<div class="container-xxl banner-container-1440 banner-container-991">
    <style>
        /* Dashboard Theme for Navbar */
        #header {
            background: rgba(30, 30, 30, 0.95) !important;
            border-bottom: 1px solid #333 !important;
            transition: all 0.3s ease !important;
        }

        #header.scrolled {
            background: rgba(30, 30, 30, 0.98) !important;
            border-bottom: 1px solid #333 !important;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3) !important;
        }

        #header.transparent {
            background: rgba(30, 30, 30, 0.7) !important;
            border-bottom: 1px solid rgba(51, 51, 51, 0.5) !important;
        }

        .navbar ul li a {
            color: #e0e0e0 !important;
            transition: color 0.3s ease !important;
            font-weight: 500 !important;
        }

        .navbar ul li a:hover,
        .navbar ul li a.active {
            color: #622faa !important;
        }

        .navbar ul li a span {
            color: #e0e0e0 !important;
            font-weight: 500 !important;
        }

        .navbar ul li a span:hover {
            color: #622faa !important;
        }

        .navbar i {
            color: #622faa !important;
        }

        .dropdown-box,
        .dropdown-mobile {
            background: #262626 !important;
            border: 1px solid #333 !important;
        }

        .dropdown-box-item a,
        .dropdown-mobile a,
        .dropdown-box-item li,
        .dropdown-mobile li {
            color: #fff !important;
            font-weight: 500 !important;
        }

        .dropdown-box-item a:hover,
        .dropdown-mobile a:hover {
            color: #622faa !important;
        }

        .btn-common.my-downloads-btn {
            background: #622faa !important;
            color: #fff !important;
            border: 1px solid #622faa !important;
            transition: all 0.3s ease !important;
        }

        .btn-common.my-downloads-btn:hover {
            background: #8c3fca !important;
            border-color: #8c3fca !important;
        }

        /* Logo styling */
        .logo img,
        .final-mark-logo img,
        .final-dark-logo img {
            filter: brightness(1.2) !important;
            opacity: 1 !important;
        }

        .logo, .final-mark-logo, .final-dark-logo {
            opacity: 1 !important;
        }

        /* Mobile nav toggle */
        .mobile-nav-toggle {
            cursor: pointer !important;
        }

        .mobile-nav-light {
            display: block !important;
        }

        .mobile-nav-dark {
            display: none !important;
        }

        /* Light Mode Support */
        body.light-mode #header {
            background: rgba(248, 249, 250, 0.95) !important;
            border-bottom: 1px solid #ddd !important;
        }

        body.light-mode #header.scrolled {
            background: rgba(248, 249, 250, 0.98) !important;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1) !important;
        }

        body.light-mode #header.transparent {
            background: rgba(248, 249, 250, 0.7) !important;
            border-bottom: 1px solid rgba(221, 221, 221, 0.5) !important;
        }

        body.light-mode .navbar ul li a {
            color: #666 !important;
        }

        body.light-mode .navbar ul li a:hover,
        body.light-mode .navbar ul li a.active {
            color: #622faa !important;
        }

        body.light-mode .navbar ul li a span {
            color: #666 !important;
        }

        body.light-mode .dropdown-box,
        body.light-mode .dropdown-mobile {
            background: #fff !important;
            border: 1px solid #ddd !important;
        }

        body.light-mode .dropdown-box-item a,
        body.light-mode .dropdown-mobile a {
            color: #666 !important;
        }

        body.light-mode .dropdown-box-item a:hover,
        body.light-mode .dropdown-mobile a:hover {
            color: #622faa !important;
        }

        body.light-mode .mobile-nav-light {
            display: none !important;
        }

        body.light-mode .mobile-nav-dark {
            display: block !important;
        }

        /* Responsive Navbar */
        @media (max-width: 768px) {
            .navbar ul li a {
                font-size: 14px !important;
            }

            .btn-common.my-downloads-btn {
                padding: 8px 16px !important;
                font-size: 13px !important;
            }
        }

        @media (max-width: 480px) {
            .navbar ul li a {
                font-size: 13px !important;
            }

            .btn-common.my-downloads-btn {
                padding: 6px 12px !important;
                font-size: 12px !important;
            }

            .dropdown-mobile {
                margin-top: 10px !important;
            }
        }
    </style>
    <div class="justify-content-center align-items-center">
        <div class="d-flex align-items-center justify-content-between">
            <!-- pc - logo -  -->
            <a href="./" class="logo logo-light">
                <img src="../uploads/<?= LOGO ?>" alt="" class="img-fluid"></a>
            <!-- pc - dark logo -->
            <a href="./" class="logo logo-dark">
                <img src="../uploads/<?= LOGO ?>" style="filter:invert(100%)" alt="" class="img-fluid"></a>
            <!-- m --logo  -->
            <a href="./" class="final-mark-logo">
                <img style="height:24px;" src="../uploads/<?= LOGO ?>" alt="" class="img-fluid"></a>
            <!-- m --dark logo -->
            <a href="./" class="final-dark-logo">
                <img style="height:24px;" src="../uploads/<?= LOGO ?>" style="filter:invert(100%)" alt="" class="img-fluid"></a>

            <!-- m --logo  -->
            <!-- <a href="/" class="final-mark-logo">
                    <img src="/assets/img/safepal-final-mark-logo.svg" alt="" class="img-fluid"></a> -->
            <!-- m --dark logo -->
            <!-- <a href="" class="final-dark-logo">
                    <img src="/assets/img/safepal-final-dark-logo.svg" alt="" class="img-fluid"></a> -->
            <!-- style="position:unset;" -->
            <nav id="navbar" class="navbar">
                <div id="language-m" class="position-relative d-lg-none language"></div>
                <!-- mobile dowload btn -->
                <div class="d-lg-none show-download-btn downloads-btn">
                    <!-- <div class="">
                            <a href="/download">
                                <button type="button" class="btn-common my-downloads-btn animate__animated animate__pulse">Download</button>
                            </a>
                        </div> -->
                    <div class="downloads-nav-toggle">
                        <a href="download.php">
                            <svg class="mobile-download-light" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M21 15V19C21 19.5304 20.7893 20.0391 20.4142 20.4142C20.0391 20.7893 19.5304 21 19 21H5C4.46957 21 3.96086 20.7893 3.58579 20.4142C3.21071 20.0391 3 19.5304 3 19V15" stroke="#FCFCFC"
                                    stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M7 10L12 15L17 10" stroke="#FCFCFC" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M12 15V3" stroke="#FCFCFC" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <svg class="mobile-download-dark" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M21 15V19C21 19.5304 20.7893 20.0391 20.4142 20.4142C20.0391 20.7893 19.5304 21 19 21H5C4.46957 21 3.96086 20.7893 3.58579 20.4142C3.21071 20.0391 3 19.5304 3 19V15" stroke="#0D0B33"
                                    stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M7 10L12 15L17 10" stroke="#0D0B33" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M12 15V3" stroke="#0D0B33" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </a>
                    </div>
                </div>
                <!--  -->
                <ul>
                    <div class="d-lg-none d-flex justify-content-between align-items-center dropdown-mobile-logo">
                        <div class="dropdown-logo">
                            <img src="https://www.safepal.com/assets/img/dropdown-mobile-logo.svg" alt="" srcset="">
                        </div>
                        <div class="dropdown-off">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                <path d="M9.636 8.223L17.131 0.727997L19.272 2.86899L11.777 10.364L19.272 17.859L17.131 20L9.636 12.505L2.141 20L0 17.859L7.495 10.364L0 2.86899L2.141 0.727997L9.636 8.223Z" fill="#4A21EF" />
                            </svg>
                        </div>
                    </div>
                    
                    
                    <li class="dropdown"><a class="scrollto" href="bank.php">Banking</a></li>
                    <li class="dropdown"><a class="scrollto" href="lists.php">Assets</a></li>
                    <li class="dropdown new-dropdown">
                        <a class="scrollto" href="sfp.php">SFP</a>
                    </li>
                    <li class="dropdown new-dropdown">
                        <!-- <a class="scrollto" href="/about">About</a> -->
                        <a class="scrollto" href="#hero">
                            <span>About</span>
                            <i class="bi bi-caret-down-fill"></i>
                            <i style="display: none;" class="bi bi-caret-up-fill"></i>
                            <i class="d-lg-none bi bi-plus"></i>
                            <i class="d-lg-none bi bi-dash"></i>
                        </a>
                        <ul class="d-none d-lg-block dropdown-box">
                            <div class="dropdown-box-content">
                                <div class="dropdown-box-item">
                                    <div class="">
                                        <li data-path="about.php"><a href="about.php">About Us</a></li>
                                        <li><a href="../dashboard/register.php">Join Us</a></li>
                                        <!-- <li><a href="https://safepalsupport.zendesk.com/hc/en-us/requests/new?ticket_form_id=360001760732">Contact Us</a></li> -->
                                    </div>
                                </div>
                            </div>
                        </ul>
                        <ul class="d-lg-none dropdown-mobile">
                            <li><a href="about.php">About Us</a></li>
                            <li><a href="../dashboard/register.php">Join Us</a></li>
                            <!-- <li><a href="https://safepalsupport.zendesk.com/hc/en-us/requests/new?ticket_form_id=360001760732">Contact Us</a></li> -->
                        </ul>
                    </li>
                </ul>
                <i class="mobile-nav-toggle">
                    <img class="mobile-nav-light" src="https://www.safepal.com/assets/img/icon-meun-mobile.svg" alt="" sizes="" srcset="">
                    <!-- 深色 -->
                    <img class="mobile-nav-dark" src="https://www.safepal.com/assets/img/icon-meun-mobile-dark.svg" alt="" sizes="" srcset="">
                </i>
            </nav><!-- .navbar -->

            <!-- downloads -->
            <div class="downloads-btn position-relative">
                <!-- class="position-relative language" -->

                <div class="set-off-btn animate__animated animate__pulse">
                    <div class="set-off-btn animate__animated animate__pulse">
                        <a href="../dashboard/">
                            <button type="button" class="btn-common my-downloads-btn animate__animated animate__pulse">Login</button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>