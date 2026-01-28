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

        /* Navbar Wrapper - Main Container */
        .navbar-wrapper {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px 20px;
            gap: 20px;
            width: 100%;
        }

        /* Logo Styling */
        .navbar-logo {
            flex-shrink: 0;
            display: flex;
            align-items: center;
        }

        .navbar-logo img {
            height: 40px;
            width: auto;
            transition: transform 0.3s ease;
        }

        .navbar-logo:hover img {
            transform: scale(1.05);
        }

        /* Hamburger Menu Toggle */
        .hamburger-menu {
            display: none;
            flex-direction: column;
            gap: 5px;
            cursor: pointer;
            padding: 8px;
            margin: 0;
            margin-left: auto;
            z-index: 1001;
            flex-shrink: 0;
            background: none;
            border: none;
        }

        .hamburger-menu:active {
            background: rgba(98, 47, 170, 0.1);
            border-radius: 5px;
        }

        .hamburger-menu span {
            width: 24px;
            height: 2.5px;
            background-color: #e0e0e0;
            border-radius: 3px;
            transition: all 0.4s ease;
            display: block;
        }

        .hamburger-menu.active span:nth-child(1) {
            transform: rotate(45deg) translate(10px, 10px);
        }

        .hamburger-menu.active span:nth-child(2) {
            opacity: 0;
        }

        .hamburger-menu.active span:nth-child(3) {
            transform: rotate(-45deg) translate(7px, -7px);
        }

        /* Default Navbar (Desktop) */
        .navbar {
            display: flex;
            flex-direction: row;
            align-items: center;
            gap: 0;
            flex: 1;
        }

        .navbar ul {
            display: flex;
            flex-direction: row;
            list-style: none;
            margin: 0;
            padding: 0;
            gap: 0;
            align-items: center;
            width: 100%;
        }

        .navbar ul li a {
            color: #e0e0e0;
            font-weight: 500;
            padding: 12px 18px;
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-block;
            position: relative;
        }

        .navbar ul li a:hover {
            color: #622faa;
            background: rgba(98, 47, 170, 0.1);
            border-radius: 5px;
        }

        /* Auth Buttons */
        .auth-buttons {
            display: flex;
            gap: 12px;
            align-items: center;
            flex-shrink: 0;
        }

        .auth-buttons a {
            text-decoration: none;
        }

        .btn-login, .btn-register {
            padding: 10px 20px;
            border-radius: 6px;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-block;
            font-size: 14px;
        }

        .btn-register {
            background: #622faa;
            color: white;
            border: 2px solid #622faa;
        }

        .btn-register:hover {
            background: #8c3fca;
            border-color: #8c3fca;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(98, 47, 170, 0.3);
        }

        .btn-login {
            color: #622faa;
            border: 2px solid #622faa;
            background: transparent;
        }

        .btn-login:hover {
            background: #622faa;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(98, 47, 170, 0.3);
        }

        /* Mobile Navbar */
        @media (max-width: 992px) {
            .navbar-wrapper {
                padding: 10px 15px;
                gap: 10px;
            }

            .hamburger-menu {
                display: flex;
            }

            /* Hide auth buttons on mobile */
            .auth-buttons {
                display: none;
            }

            .navbar {
                position: fixed;
                top: 60px;
                left: -100%;
                width: 100%;
                height: calc(100vh - 60px);
                background: linear-gradient(135deg, rgba(20, 20, 20, 0.99) 0%, rgba(30, 30, 30, 0.99) 100%);
                flex-direction: column;
                padding: 20px 0;
                overflow-y: auto;
                transition: left 0.4s cubic-bezier(0.4, 0, 0.2, 1);
                z-index: 1000;
                border-right: 1px solid #333;
                display: flex;
            }

            .navbar.active {
                left: 0;
                box-shadow: 2px 0 15px rgba(0, 0, 0, 0.5);
            }

            .navbar ul {
                flex-direction: column;
                width: 100%;
                gap: 0;
                padding: 0 0 20px 15px;
                margin: 0;
            }

            .navbar ul li {
                width: 100%;
                border-bottom: 1px solid rgba(51, 51, 51, 0.5);
            }

            .navbar ul li:last-child {
                border-bottom: none;
            }

            .navbar ul li a {
                display: block;
                padding: 16px 20px;
                border-bottom: none;
                color: #e0e0e0;
                font-size: 15px;
                font-weight: 500;
            }

            .navbar ul li a:active {
                background: rgba(98, 47, 170, 0.15);
            }

            /* Mobile Auth Divider */
            .mobile-auth-divider {
                border-bottom: 2px solid #333 !important;
                margin: 10px 0 !important;
                padding: 0 !important;
                min-height: 0 !important;
            }

            /* Mobile Auth Items */
            .mobile-auth-item a {
                color: #622faa !important;
                font-weight: 600 !important;
                padding: 14px 20px !important;
                transition: all 0.3s ease !important;
                display: flex !important;
                align-items: center !important;
                gap: 10px !important;
            }

            .mobile-auth-item a i {
                font-size: 16px;
                width: 20px;
                text-align: center;
            }

            .mobile-auth-item a:active {
                background: rgba(98, 47, 170, 0.15) !important;
                transform: translateX(5px);
            }

            .mobile-auth-item a:hover {
                color: #8c3fca !important;
                padding-left: 25px !important;
            }
        }

        /* Tablet Responsive Adjustments */
        @media (max-width: 768px) {
            .navbar-wrapper {
                padding: 8px 12px;
            }

            .navbar {
                width: 85vw;
                max-width: 280px;
            }

            .navbar ul li a {
                padding: 14px 16px;
                font-size: 14px;
            }

            .mobile-auth a {
                padding: 12px 16px;
                font-size: 14px;
            }

            .hamburger-menu {
                padding: 6px;
            }

            .hamburger-menu span {
                width: 22px;
                height: 2px;
            }
        }

        /* Small Mobile Devices */
        @media (max-width: 480px) {
            .navbar-wrapper {
                padding: 10px;
                gap: 8px;
            }

            .navbar-logo img {
                height: 35px;
            }

            .hamburger-menu {
                padding: 6px;
            }

            .hamburger-menu span {
                width: 22px;
                height: 2px;
            }

            .navbar {
                width: 100%;
                max-width: 100%;
                border-right: none;
            }

            .navbar ul li a {
                padding: 12px 16px;
                font-size: 13px;
            }

            .mobile-auth a {
                padding: 10px 16px;
                font-size: 13px;
            }

            .auth-buttons {
                gap: 8px;
            }

            .btn-login, .btn-register {
                padding: 8px 14px;
                font-size: 12px;
            }
        }
    </style>
    <div class="navbar-wrapper">
        <!-- Logo -->
        <a href="./" class="navbar-logo">
            <img src="../uploads/<?= LOGO ?>" alt="Logo">
        </a>

        <!-- Main Navigation -->
        <nav id="navbar" class="navbar">
            <ul>
                <li><a href="bank.php">Banking</a></li>
                <li><a href="lists.php">Assets</a></li>
                <li><a href="sfp.php">SFP</a></li>
                <li><a href="about.php">About</a></li>
                <!-- Mobile Auth Section -->
                <li class="mobile-auth-divider"></li>
                <li class="mobile-auth-item"><a href="../dashboard/register.php"><i class="fas fa-user-plus"></i> Register</a></li>
                <li class="mobile-auth-item"><a href="../dashboard/"><i class="fas fa-sign-in-alt"></i> Login</a></li>
            </ul>
        </nav>

        <!-- Hamburger Menu Toggle -->
        <button class="hamburger-menu" id="hamburger" aria-label="Toggle navigation menu">
            <span></span>
            <span></span>
            <span></span>
        </button>

        <!-- Desktop Auth Buttons -->
        <div class="auth-buttons">
            <a href="../dashboard/" class="btn-login">Login</a>
            <a href="../dashboard/register.php" class="btn-register">Register</a>
        </div>
    </div>

    <!-- Mobile Navbar Toggle Script -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const hamburger = document.getElementById('hamburger');
        const navbar = document.getElementById('navbar');

        // Toggle mobile menu and hamburger animation
        hamburger.addEventListener('click', function(e) {
            e.stopPropagation();
            navbar.classList.toggle('active');
            hamburger.classList.toggle('active');
        });

        // Close menu when clicking on a link
        const navLinks = navbar.querySelectorAll('a');
        navLinks.forEach(link => {
            link.addEventListener('click', function() {
                navbar.classList.remove('active');
                hamburger.classList.remove('active');
            });
        });

        // Close menu when clicking outside
        document.addEventListener('click', function(e) {
            const isClickInsideNavbar = e.target.closest('.navbar');
            const isClickOnHamburger = e.target.closest('.hamburger-menu');
            
            if (!isClickInsideNavbar && !isClickOnHamburger) {
                navbar.classList.remove('active');
                hamburger.classList.remove('active');
            }
        });

        // Close menu on resize if going to desktop
        window.addEventListener('resize', function() {
            if (window.innerWidth > 992) {
                navbar.classList.remove('active');
                hamburger.classList.remove('active');
            }
        });
    });
    </script>