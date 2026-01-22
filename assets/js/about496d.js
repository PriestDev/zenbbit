/**
 * Template Name: bootstrap - v5.1.3
 * Author: bootstrap.com
 * License: https://v5.bootcss.com/
 */
(function () {
    "use strict";
    /**
     * coins --- slider ------------- start
     * 
     */
    const select = (el, all = false) => {
        el = el.trim()
        if (all) {
            return [...document.querySelectorAll(el)]
        } else {
            return document.querySelector(el)
        }
    }
    const on = (type, el, listener, all = false) => {
        let selectEl = select(el, all)
        if (selectEl) {
            if (all) {
                selectEl.forEach(e => e.addEventListener(type, listener))
            } else {
                selectEl.addEventListener(type, listener)
            }
        }
    }

    // --------purpose -swiper----------
    let purposeOp = {
        loop: true,
        autoplay: {
            delay: 5000,
            disableOnInteraction: false
        },
        slidesPerView: 'auto',
    }
    if (isMobile()) {
        Object.assign(purposeOp, {
            speed: 500,
            pagination: {
                el: '.swiper-pagination-purpose',
            }
        })
    } else {
        Object.assign(purposeOp, {
            speed: 5000,
            freeMode: true,
            allowTouchMove: false,
            autoplay: {
                disableOnInteraction: false,
                stopOnLastSlide: false,
                pauseOnMouseEnter: true,
                delay: 0,
            },
            loopFillGroupWithBlank: true,
            normalizeSlideIndex: true,
        });
    }
    const purposeSwiper= new Swiper('.purpose-carousel-box', {
        ...purposeOp,
        breakpoints: {
            320: {
                slidesPerView: 1,
                spaceBetween: 0
            },
            480: {
                slidesPerView: 1,
                spaceBetween: 0
            },
            640: {
                slidesPerView: 1,
                spaceBetween: 0
            },
            720: {
                slidesPerView: 1,
                spaceBetween: 0
            },
            992: {
                slidesPerView: 1,
                spaceBetween: 30
            },
            1200: {
                slidesPerView: 2,
                spaceBetween: 60
            },
            1440: {
                slidesPerView: 3,
                spaceBetween: 160
            },
            1920: {
                slidesPerView: 3,
                spaceBetween: 160
            }
        }
    });
    let purposeNextTransForm = '', // 存放鼠标悬浮时的transform属性
    purposeNextTransPosition = 0, // 轮播图原本应移动到的位置
    purposeNowTransPosition = 0, // 鼠标悬浮时时轮播图位置
    purposeNowTransForm = '', // 存放鼠标悬浮时轮播图的真实transform属性（非行内属性）
    purposeNextTime = 0,
    purposeSildeWidth = 0; //silde width

  if (!isMobile()) {
    purposeSwiper.el.onmouseover = function () {
        let vector = url_lang === 'ar' ? 1 : -1
      purposeNextTransForm = $('#purpose-swiper-wrapper')[0].style.transform;
      purposeNextTransPosition = vector * parseInt(purposeNextTransForm.split('px')[0].split("translate3d(")[1]);
      purposeNowTransForm = window.getComputedStyle($('#purpose-swiper-wrapper')[0], false)["transform"];
      purposeNowTransPosition = vector * parseInt(window.getComputedStyle($('#purpose-swiper-wrapper')[0], false)["transform"].split("1,")[2].split(",")[0]);
      purposeSildeWidth = $('#purpose-swiper-wrapper').find('.swiper-slide')[0].style.width.split('px')[0];;
      // 计算轮播图从暂停位置移动到原本应到的位置所用的时间
      purposeNextTime = 5000 * ((purposeNextTransPosition - purposeNowTransPosition) / purposeSildeWidth);
      // 改变行内transform属性
      $('#purpose-swiper-wrapper')[0].style.transform = purposeNowTransForm;
      $('#purpose-swiper-wrapper')[0].style.transitionDuration = "0ms";
      purposeSwiper.autoplay.stop();
    }
    purposeSwiper.el.onmouseout = function () {
      $('#purpose-swiper-wrapper')[0].style.transform = purposeNextTransForm;
      $('#purpose-swiper-wrapper')[0].style.transitionDuration = `${purposeNextTime}ms`;
      purposeSwiper.autoplay.start();
    }
  }


    let years = [];
    let historyList = [
        {
            year: '2018',
            first: true,
            content: {
                type: 2,
                title: january_text || 'January',
                text: safepal_was_founded || 'SafePal was founded.'
            }
        },
        {
            year: '2018',
            content: {
                type: 2,
                title: october_text || 'October', 
                value: received_strategic_investment_from_binance_Labs || 'Received strategic investment from Binance Labs'
            }
        },
        {
            year: '2019',
            first: true,
            content: {
                type: 2,
                title: may_text || 'May',
                value: official_launch_of_safepal_s1_hardware_wallet || 'Official launch of the SafePal S1 hardware wallet'
            }
        },
        {
            year: '2019',
            content: {
                type: 2, 
                title: june_text || 'June',
                value: supported_binance_mainnet || 'Supported Binance Mainnet and BNB.'
            }
        },
        {
            year: '2019',
            content: {
                type: 2,  
                title: july_text || 'July',
                value: integrated_binance_dex  || 'Integrated Binance DEX and WalletConnect protocol.'
            }
        },
        {
            year: '2019',
            content: {
                type: 2, 
                title: december_text || 'December', 
                value: integrated_with_simplex || 'Integrated with Simplex.'
            }
        },
        {
            year: '2020',
            first: true,
            content: {
                type: 2, 
                title: may_text || 'May',
                value: released_safepal_software_wallet || 'Released SafePal Software wallet'
            }
        },
        {
            year: '2020',
            content: {
                type: 2, 
                title: june_text || 'June',
                value: release_of_safepal_cross_chain_swap || 'Release of SafePal cross-chain swap'
            }
        },
        {
            year: '2020',
            content: {
                type: 2, 
                title: august_text|| 'August',
                value: release_of_safepal_dappstore || '-Release of SafePal Dappstore <br/>-Integration of Binance Dapp'
            }
        },
        {
            year: '2021',
            first: true,
            content: {
                type: 2, 
                title: january_text || 'January',
                value: received_strategic_investment_from_animoca_brands  || 'Received strategic investment from Animoca Brands'
            }
        },
        {
            year: '2021',
            content: {
                type: 2, 
                title: february_text || 'February',
                value: issuing_of_decentralized_utility_token_sfp  || 'Issuing of decentralized utility token $SFP'
            }
        },
        {
            year: '2021',
            content: {
                type: 2, 
                title: february_text || 'February',
                value: safepal_becomes_the_first_binance_launchpad_project  || 'SafePal becomes the first Binance launchpad project'
            }
        },
        {
            year: '2021',
            content: {
                type: 2, 
                title: march_text || 'March',
                value: introduction_of_the_wallet_holder_offering_program || 'Introduction of the wallet holder offering program (WHO)'
            }
        },
        {
            year: '2021',
            content: {
                type: 2, 
                title: october_text || 'October', 
                value: launch_of_safepal_earn_yield_aggregator || 'Launch of SafePal Earn yield aggregator'
            }
        },
        {
            year: '2021',
            content: {
                type: 2, 
                title: december_text || 'December', 
                value: introduction_of_safepal_giftbox_program || 'Introduction of SafePal Giftbox program'
            }
        },
        {
            year: '2022',
            first: true,
            content: {
                type: 2, 
                title: april_text  || 'April', 
                value: achieved_5m_users || 'Achieved 5M+ users'
            }
        },
        {
            year: '2022',
            content: {
                type: 2, 
                title: june_text || 'June',
                value: safepal_becomes_full_wallet_suite_with_official || 'SafePal becomes full wallet suite with official release of browser extension wallet'
            }
        },
        {
            year: '2022',
            content: {
                type: 2, 
                title: july_text || 'July',
                value: integration_of_mexc_mini_program || 'Integration of MEXC mini program'
            }
        },
        {
            year: '2022',
            content: {
                type: 2, 
                title: august_text|| 'August',
                value: launch_of_new_brand_image || 'Launch of new brand image'
            }
        },
        {
            year: '2022',
            content: {
                type: 2, 
                title: october_text || 'October',
                value: safepal_achieves_75m_users || 'SafePal achieves 7.5M users'
            }
        },
        {
            year: '2022',
            content: {
                type: 2, 
                title: december_text || 'December',
                value: received_strategic_investment_from_temasek || 'Received strategic investment from Temasek fund'
            }
        },
        {
            year: '2023',
            first: true,
            content: {
                type: 2, 
                title: january_text || 'January',
                value: integration_of_bitget_mini_program || 'Integration of Bitget mini program'
            }
        },
        {
            year: '2023',
            content: {
                type: 2, 
                title: march_text || 'March',
                value: safepal_achieves_10m_users || '-SafePal achieves 10M+ users<br>-SafePal supports 100+ blockchains with introduction of custom RPC'
            }
        },
        {
            year: '2023',
            content: {
                type: 2, 
                title: july_text || 'July',
                value: expansion_of_sfp_from_bep20_to_erc20 || 'Expansion of $SFP from BEP20 to ERC20'
            }
        },
        {
            year: '2023',
            content: {
                type: 2, 
                title: september_text || 'September',
                value: official_launch_of_the_safepal_s1_pro_hardware_wallet || '-Official launch of the SafePal S1 Pro hardware wallet<br/>-Official launch and open source for the SafePal X1 Bluetooth hardware wallet<br/>-Open source of the SafePal mobile app code for essential functions'
            }
        },
        {
            year: '2023',
            content: {
                type: 2, 
                title: december_text || 'December',
                value: safepal_supports_200_regions_with_official_distribution_channels_and_resellers || 'SafePal supports 200+ regions with official distribution channels and resellers'
            }
        },
        {
            year: '2024',
            first: true,
            content: {
                type: 2, 
                title: march_text || 'March',
                value: safepal_launches_cedefi_banking_gateway_and_visa_card_with_fiat24 || 'SafePal launches CeDeFi banking gateway and Visa card with Fiat24'
            }
        },
        {
            year: '2024',
            content: {
                type: 2, 
                title: august_text|| 'August',
                value: launch_sfplus || 'Launch of SFPlus staking hub'
            }
            
        },
        {
            year: '2024',
            content: {
                type: 2, 
                title: december_text || 'December',
                value: reaches_20m_mastercard || 'SafePal reaches 20M+ users and launches Debit Mastercard'
            }
            
        },
        {
            year: '2025',
            first: true,
            content: {
                type: 2, 
                title: april_text  || 'April', 
                value: 'Upgrading Security Chipset Element for Hardware Wallet line to EAL6'
            }
            
        },
        {
            year: '2025',
            content: {
                type: 2, 
                title: august_text|| 'August',  
                value: 'SafePal reaches 25M+ Users'
            }
            
        },
        {
            year: '2025',
            content: {
                type: 2, 
                title: september_text || 'September', 
                value: 'Integrating Aster Perp DEX and trade tab revamp'
            }
            
        },
        {
            year: '2025',
            content: {
                type: 2, 
                title: october_text || 'October',
                value: 'SafePal Mastercard service coverage expansion'
            }
            
        },
        {
            year: '2025',
            content: {
                type: 2, 
                title: november_text || 'November',
                value: 'Integrating Hyperliquid Perp DEX and HyperEVM'
            }
            
        },
        {
            year: '2026',
            first: true,
            content: {
                type: 2, 
                title: january_text || 'January',
                value: 'SafePal launches limited edition Mastercard designs'
            }
            
        },
    ];
    historyList.map(item => {
        let html = '';
        switch (item.content.type) {
            case 1:
                html = `<div years="${item.year}" class="swiper-slide align-self-start my-carousel-item">
                <div class="my-carousel-item-type-1">
                    <div class="my-carousel-item-box">
                        <img src="${item.content.imageUrl}" alt="" srcset="">
                    </div>
                    <div class="my-carousel-item-text">
                        <p>${item.content.text}</p>
                    </div>
                </div>
            </div>`
                break;
            case 2:
                html = `<div data-content=${item.year} years="${item.year}-${item.content.title}" class="swiper-slide align-self-start my-carousel-item ${item.first ? 'years-first-slide' : ''}">
                <div class="my-carousel-item-type-2">
                    <div class="my-carousel-item-box">
                        <div class="title">${item.content.title}</div>
                        <div class="value">${item.content.value || item.content.text}</div>
                    </div>
                </div>
            </div>`
                break;
            case 3:
                html = `<div years="${item.year}" class="swiper-slide align-self-start my-carousel-item">
                <div class="d-flex justify-content-center align-items-end my-carousel-item-type-3">
                    <div class="my-carousel-item-box">
                        <div class="title image">
                            <img src="${item.content.titleImg}" alt="">
                        </div>
                        <div class="value">${item.content.value || item.content.text}</div>
                    </div>
                </div>
            </div>`
                break;
            case 4:
                break;
        }
        years.push(item.year)
        $(".history-carousel-box .swiper-wrapper").append(html)
    })
    // history - event(历史事件点)
    function historyEvent(event) {
        // let {
        //     year,
        //     value
        // } = event;
        // $(".event-title .event-years").text(year || '')
        // $(".event-title .event-content").text(value || '')
        let {
            year,
            value
        } = event;
        $(".event-title .event-years").text(year || '')
        $(".event-title .event-content").text(value || '')
    }
    
    // history - carousel
    new Swiper('.history-carousel-box', {
        speed: 400,
        loop: true,
        autoHeight: true,
        centeredSlides: false,
        slidesOffsetBefore: 0,
        // autoplay: {
        //     delay: 5000,
        //     disableOnInteraction: false
        // },
        slidesPerView: 'auto',
        // 如果需要分页器
        pagination: {
            el: '.pagination-box',
            // 自定义分页器，必须的type类型
            paginationClickable: true,
            type: 'custom',
            renderCustom: function (swiper, current, total) {
                let text = '<div class="pagination-box-list d-flex justify-content-end align-items-center pagination-box-list-history">'
                const newYears = Array.from(new Set(years))
                for (let i = 1; i <= newYears.length; i++) {
                    text += `<div data-index=${i} class="pagination-box-list-item ${years[current -1]  === newYears[i-1] ? 'active' : ''}">${newYears[i-1]}</div>`
                }
                text += "</div>";
                // if (Object.prototype.hasOwnProperty.call(historyList[current - 1], 'event-title')) {
                //     historyEvent(historyList[current - 1]['event-title'])
                //     $('.event-title').addClass('animate__bounceIn')
                // } else {
                //     historyEvent({})
                //     $('.event-title').removeClass('animate__bounceIn');
                // }
                historyEvent(historyList[current - 1])
                
                return text;
            },
            slidesPerView: 1,
        },
        on: {
            paginationRender: function (swiper, el) {
                if (isMobile()) {
                    const newYears = Array.from(new Set(years))
                    $('.pagination-box-list-history').css("min-width", `${newYears.length * 107.5}px`)
                    if (select('.pagination-box-list-item.active')) { 
                        select('.pagination-box-list-item.active').scrollIntoView({block: 'nearest', inline: "nearest"})}
                }
                on('click', '.pagination-box-list-item', function () {
                    const index = $(this).attr('data-index');
                    const newYears = Array.from(new Set(years))
                    const i = years.findIndex(item => item === newYears[index - 1] )
                    swiper.slideToLoop(i , 500, false)
                }, true);
            },
        },
        // 如果需要前进后退按钮
        navigation: {
            nextEl: '.button-next',
            prevEl: '.button-prev',
        },
        breakpoints: {
            720: {
                slidesPerView: 1,
                spaceBetween: 10
            },
            992: {
                slidesPerView: 3,
                spaceBetween: 30
            },
            1200: {
                slidesPerView: 4,
                spaceBetween: 30
            },
            1440: {
                slidesPerView: 4,
                spaceBetween: 30
            },
            1920: {
                slidesPerView: 4,
                spaceBetween: 30
            }
        }
    });
    // 
    // our core values - carousel
    if (isMobile()) {
        new Swiper('.core-carousel-box', {
            loop: true,
            // 如果需要前进后退按钮
            // navigation: {
            //     nextEl: '.core-button-next',
            //     prevEl: '.core-button-prev',
            // },
            pagination: {
                el: '.carousel-swiper-pagination'
              },
            slidesPerView: 'auto',
            breakpoints: {
                320: {
                    slidesPerView: 1,
                    spaceBetween: 10
                },
                720: {
                    slidesPerView: 1,
                    spaceBetween: 10
                },
                992: {
                    slidesPerView: 'auto',
                    spaceBetween: 87
                },
                1200: {
                    slidesPerView: 'auto',
                    spaceBetween: 87
                },
                1440: {
                    slidesPerView: 'auto',
                    spaceBetween: 87
                },
                1920: {
                    slidesPerView: 'auto',
                    spaceBetween: 87
                }
            }
        });
    }

    /**
     * coins --- silder -------------- end
     * 
     */
})()