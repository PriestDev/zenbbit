<footer id="footer">
            <style>
                /* Dashboard Theme for Footer */
                #footer {
                    background: #1e1e1e !important;
                    color: #fff !important;
                    border-top: 1px solid #333 !important;
                }

                #footer h3 {
                    color: #fff !important;
                    font-weight: 600 !important;
                }

                #footer a {
                    color: #aaa !important;
                    transition: color 0.3s ease !important;
                }

                #footer a:hover {
                    color: #622faa !important;
                }

                #footer p {
                    color: #aaa !important;
                }

                .footer-top-box {
                    border-bottom: 1px solid #333 !important;
                }

                .footer-top-box .top-item {
                    border-right: 1px solid #333 !important;
                }

                .footer-top-box .top-item:last-child {
                    border-right: none !important;
                }

                .copyright {
                    border-top: 1px solid #333 !important;
                    color: #aaa !important;
                }

                .safepay p {
                    color: #aaa !important;
                }

                .contact a {
                    color: #622faa !important;
                }

                .contact a:hover {
                    color: #8c3fca !important;
                    text-decoration: underline !important;
                }

                .link-item a {
                    display: inline-flex !important;
                    align-items: center !important;
                    justify-content: center !important;
                }

                .link-item a:hover img {
                    opacity: 0.8 !important;
                    filter: brightness(1.2) !important;
                }

                /* Light Mode Support */
                body.light-mode #footer {
                    background: #f8f9fa !important;
                    color: #333 !important;
                    border-top: 1px solid #ddd !important;
                }

                body.light-mode #footer h3 {
                    color: #333 !important;
                }

                body.light-mode #footer a {
                    color: #666 !important;
                }

                body.light-mode #footer a:hover {
                    color: #622faa !important;
                }

                body.light-mode #footer p {
                    color: #666 !important;
                }

                body.light-mode .footer-top-box {
                    border-bottom: 1px solid #ddd !important;
                }

                body.light-mode .footer-top-box .top-item {
                    border-right: 1px solid #ddd !important;
                }

                body.light-mode .copyright {
                    border-top: 1px solid #ddd !important;
                    color: #666 !important;
                }

                body.light-mode .safepay p {
                    color: #666 !important;
                }

                /* Responsive Footer */
                @media (max-width: 768px) {
                    #footer {
                        padding: 20px 0 !important;
                    }

                    .footer-top-box .top-item {
                        margin-bottom: 15px !important;
                        border-right: none !important;
                        border-bottom: 1px solid #333 !important;
                    }

                    body.light-mode .footer-top-box .top-item {
                        border-bottom: 1px solid #ddd !important;
                    }

                    #footer h3 {
                        font-size: 16px !important;
                    }

                    #footer a {
                        font-size: 13px !important;
                    }
                }

                @media (max-width: 480px) {
                    #footer {
                        padding: 15px 0 !important;
                    }

                    .footer-top-box {
                        gap: 10px !important;
                    }

                    #footer h3 {
                        font-size: 14px !important;
                        margin-bottom: 10px !important;
                    }

                    #footer a {
                        font-size: 12px !important;
                    }

                    #footer ul {
                        padding-left: 0 !important;
                    }

                    #footer ul li {
                        margin-bottom: 5px !important;
                    }

                    .link-item {
                        margin: 5px !important;
                    }

                    .link-item a img {
                        max-width: 24px !important;
                    }
                }
            </style>
            <div class="container footer-top">
                <div class="row footer-top-box">

                    <div class="col-lg col-md-6 col-sm-6 col-6 order-lg-2 order-md-3 order-sm-3 footer-support col-xs-6 top-item">
                        <h3>Support</h3>
                        <ul>
                            <li><a href="#">Help Center</a></li>
                            <li><a href="#">Track my order</a></li>
                            <li><a href="#">Technical Issues</a></li>
                            <li><a href="#">Device Authentication</a></li>
                            <li><a href="#">Submit A Request</a></li>
                        </ul>
                    </div>

                    

                    <div class="col-lg col-md-6 col-sm-6 col-6 order-lg-4 order-md-2 order-sm-2 footer-about col-xs-6 top-item">
                        <h3>About</h3>
                        <ul>
                            <li><a href="about.php">The Company</a></li>
                            <!--                    <li><a href="">Careers</a></li>-->
                            <li><a href="sfp.php">ZBT Token</a></li>
                            <li><a href="#">Blog</a></li>
                            <li><a href="#">Brand Resource Center</a></li>
                            <li><a href="#">Site Map</a></li>
                            <li><a href="../dashboard/register.php">Join Us</a></li>
                        </ul>
                    </div>
                    <div class="col-lg col-md-6 col-sm-6 col-6 order-lg-5 order-md-4 order-sm-4 footer-legal col-xs-6 top-item">
                        <h3>Legal</h3>
                        <ul>
                            <li><a href="#">Terms of Service</a></li>
                            <li><a href="#">Privacy Policy</a></li>
                            <li><a href="#">Shipping Policy</a></li>
                            <li><a href="#">Refund Policy</a></li>
                        </ul>
                    </div>

                </div>
            </div>

            <div class="container footer-bottom">
                <div
                    class="copyright d-flex justify-content-between align-items-lg-end align-items-start flex-lg-row flex-column">
                    <div class="safepay d-flex justify-content-start align-items-center">
                        <div class="logo">
                            <img src="../uploads/<?= LOGO ?>" width="auto" height="50px" alt="">
                        </div>
                        <div class="text">
                            <p>© <?= date('Y'). ' ' . NAME; ?></p>
                        </div>
                    </div>
                    <div class="contact d-lg-none">
                        <p style="word-spacing: inherit;word-break: normal;white-space: break-spaces;word-wrap: break-word;">Press release contact: <a href="mailto:<?= EMAIL ?>"><?= EMAIL ?></a></p>
                    </div>
                    <div class="payment-link">
                        <div class="link d-flex align-items-center flex-wrap flex-lg-nowrap">
                            <div class="contact link-item d-none d-lg-block">
                                <p>Press release contact: <a href="mailto:<?= EMAIL ?>"><?= EMAIL ?></a></p>
                            </div>
                            <div class="link-item twitter">
                                <a href="#" target="_blacnk"><img style="padding: 4px;" src="https://www.safepal.com/assets/img/footer/icon-twitter.svg" alt=""></a>

                            </div>
                            <div class="link-item discord">
                                <a href="#" target="_blacnk">
                                    <img src="https://www.safepal.com/assets/img/footer/icon-discord.svg" alt="" srcset="">
                                </a>

                            </div>
                            <div class="link-item youtube">
                                <a href="#" target="_blacnk">
                                    <img src="https://www.safepal.com/assets/img/footer/icon-youtube.svg" alt="">
                                </a>
                            </div>
                            <div class="link-item telegram">
                                <a href="#" target="_blacnk">
                                    <img src="https://www.safepal.com/assets/img/footer/icon-telegram.svg" alt="">
                                </a>

                            </div>
                            <div class="link-item instagram">
                                <a href="#" target="_blacnk">
                                    <img src="https://www.safepal.com/assets/img/footer/icon-instagram.svg" alt="">
                                </a>

                            </div>
                            <div class="link-item linkedin">
                                <a href="#" target="_blacnk">
                                    <img src="https://www.safepal.com/assets/img/footer/icon-linkedin.svg" alt="">
                                </a>

                            </div>
                            <div class="link-item facebook">
                                <a href="#" target="_blacnk">
                                    <img src="https://www.safepal.com/assets/img/footer/icon-facebook.svg" alt="">
                                </a>
                            </div>
                            <div class="link-item tiktok">
                                <a href="#" target="_blacnk">
                                    <svg width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M12.9492 0C19.5766 0 24.9492 5.37258 24.9492 12C24.9492 18.6274 19.5766 24 12.9492 24C6.3218 24 0.949219 18.6274 0.949219 12C0.949219 5.37258 6.3218 0 12.9492 0ZM13.2812 5.33301V14.4531C13.2812 15.5186 12.4141 16.3857 11.3486 16.3857C10.2832 16.3857 9.41607 15.5186 9.41602 14.4531C9.41602 13.3877 10.2832 12.5205 11.3486 12.5205C11.4406 12.5205 11.5232 12.5353 11.6104 12.5449H11.6484C11.7354 12.5594 11.823 12.5833 11.9053 12.6074H11.9248V10.2686C11.736 10.2443 11.5472 10.2295 11.3535 10.2295C9.0288 10.2295 7.13965 12.1186 7.13965 14.4482C7.13966 15.8721 7.85175 17.1362 8.94141 17.9014C9.6243 18.3808 10.4624 18.667 11.3584 18.667C13.6831 18.6669 15.5771 16.7729 15.5771 14.4482V9.79297C16.4722 10.4348 17.5746 10.8154 18.7588 10.8154V8.52539C18.1195 8.52539 17.5281 8.33616 17.0244 8.00684C16.3029 7.53703 15.7896 6.78574 15.625 5.91406C15.5912 5.72532 15.5723 5.53142 15.5723 5.33301H13.2812Z"
                                            fill="#9E9DAD" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </footer><!-- End Footer -->

    </div>

    <a class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>
    <!-- Vendor JS Files -->
    <script src="../assets/js/jquery-3.6.0.min496d.js?v=202601151767855013676"></script>
    <script src="../assets/vendor/ajaxPromise.min496d.js?v=202601151767855013676"></script>
    <script src="../assets/vendor/jquery-cookie496d.js?v=202601151767855013676"></script>
    <script src="../assets/vendor/loading.min496d.js?v=202601151767855013676"></script>
    <script src="../assets/vendor/language.min496d.js?v=202601151767855013676"></script>
    <script src="../assets/vendor/countdown.min496d.js?v=202601151767855013676"></script>
    <!-- <script src="/assets/vendor/language.js?v=202601151767855013676"></script> -->
    <script src="../assets/vendor/aos/aos496d.js?v=202601151767855013676"></script>
    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min496d.js?v=202601151767855013676"></script>
    <script src="../assets/vendor/glightbox/js/glightbox.min496d.js?v=202601151767855013676"></script>
    <script src="../assets/vendor/swiper/swiper-bundle.min496d.js?v=202601151767855013676"></script>
    <script src="../assets/vendor/waypoints/noframework.waypoints496d.js?v=202601151767855013676"></script>
    <!-- Template Main JS File -->
    <script src="../assets/js/common496d.js?v=202601151767855013676"></script>
    <script>
        var url_lang = "en";
    </script>
    <script>
        var select_text = "select";
        var search_text = "Search";
        var search_by_name = "Search by name";
        var $Ok = "Ok";
        var $cancel = "Cancel";
        var $items = "items";
        var $total = "Total";
        var $my_cart = "My Cart";
        var cartEmpty = "Your cart is empty.";
        var $client_country = "NG";

        var $safepal_leather_case = "SafePal Leather Case";
        var $safepal_cypher_seed_board = "SafePal Cypher Seed Board";
        var $safepal_s1_hardware_wallet = "SafePal S1 Hardware Wallet";
        var $checkout = "Checkout";
        var $standard_shipping = "Standard Shipping";
        var $express_delivery = "Express Delivery";
        var $days = "Days";
        var safepal_x1_hardware_wallet = "SafePal X1 Hardware Wallet";
        var safepal_s1pro_hardware_wallet = "SafePal S1 Pro Hardware Wallet";

        var deluxe_bundle = `Essential Bundles`;
        var expert_Bundle = `Expert Bundle`;
        var ultra_deluxe_bundle = `Utlimate Value Bundle`;
        var expert_choice = `Classic Bundle`;
        var backup_package = `Backup bundle`;
        var hardcore_bundle = `Holder's Bundle`;
        var standard_package = `Basic Bundle`;
        var isGaPage = "en";
        var mystery_text = `Celebrate Christmas and usher in the new year with a limited edition SafePal Mystery Box <a target="_blank" href="https://www.safepal.com/en/store/scmb" style="text-decoration: underline;">here</a>. Enjoy 10% off storewide with coupon "XMAS2025". The deal ends in`;
    </script>
    <script src="../assets/js/index496d.js?v=202601151767855013676"></script>
    <script>
        (function() {
            "use strict";
            if (location.pathname.includes('/checkout')) {
                // $('#language').language();
                // $('#language-m').language();
            } else {
                if (!location.pathname.includes('/payment')) {
                    window.sessionStorage.removeItem('fill');
                }
                window.sessionStorage.removeItem('cnHasTurn')
            }
            $('#language').language();
            $('#language-m').language(document.body);

            function getUrlParam(name) {
                name = name.replace(/[\[]/, "\\\[").replace(/[\]]/, "\\\]");
                var regexS = "[\\?&]" + name + "=([^&#]*)";
                var regex = new RegExp(regexS);
                var results = regex.exec(window.location.href);
                if (results == null)
                    return "";
                else
                    return decodeURIComponent(results[1].replace(/\+/g, " "));
            }

            let channel_code = getUrlParam("item");
            if (channel_code) {
                $.cookie('channel_code', channel_code, {
                    expires: 3,
                    path: '/'
                })
            } else {
                $.cookie('channel_code', 'office1', {
                    expires: 365,
                    path: '/'
                })
            }
        })()
    </script>
    <script>
        (function() {
            function c() {
                var b = a.contentDocument || a.contentWindow.document;
                if (b) {
                    var d = b.createElement('script');
                    d.innerHTML = "window.__CF$cv$params={r:'9c015aec6c81ef15',t:'MTc2ODc3MzUyMS4wMDAwMDA='};var a=document.createElement('script');a.nonce='';a.src='../cdn-cgi/challenge-platform/h/b/scripts/jsd/d251aa49a8a3/maind41d.js';document.getElementsByTagName('head')[0].appendChild(a);";
                    b.getElementsByTagName('head')[0].appendChild(d)
                }
            }
            if (document.body) {
                var a = document.createElement('iframe');
                a.height = 1;
                a.width = 1;
                a.style.position = 'absolute';
                a.style.top = 0;
                a.style.left = 0;
                a.style.border = 'none';
                a.style.visibility = 'hidden';
                document.body.appendChild(a);
                if ('loading' !== document.readyState) c();
                else if (window.addEventListener) document.addEventListener('DOMContentLoaded', c);
                else {
                    var e = document.onreadystatechange || function() {};
                    document.onreadystatechange = function(b) {
                        e(b);
                        'loading' !== document.readyState && (document.onreadystatechange = e, c())
                    }
                }
            }
        })();
    </script>
    </body>

    </html>