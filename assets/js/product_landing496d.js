(async function () {
    brandoverviewShow();
    // 
    // gopage =========
    $('#goHardwareWallets').click(() => {
        goPage('#HardwareWallets', 1)
    })
    $('#goAccessories').click(() => {
        goPage('#Accessories', 1)
    })
    $('#goRecommendedBundles').click(() => {
        goPage('#RecommendedBundles', 1)
    })
    $('#goCo-Branded').click(() => {
        goPage('#Co-Branded', 1)
    })
    $('.s1Box button').click(() => {
        goPage(isGaPage === 'ga' ? '/store/s1_a' : '/store/s1')
    })
    $('.x1Box button').click(() => {
        goPage(isGaPage === 'ga' ? '/store/x1_a' : '/store/x1')
    })
    $('.s1proBox button').click(() => {
        goPage(isGaPage === 'ga' ? '/store/s1pro_a' : '/store/s1pro')
    })
    $('.cyBox button').click(() => {
        goPage('/store/cypher')
    })
    $('.lcBox button').click(() => {
        goPage('/store/leathercase')
    })
    var mySwiper = new Swiper('.imgSwiper', {
        speed: 4000,
        loop: true,
        autoplay: {
            delay: 0,
            disableOnInteraction: false
        },
        slidesPerView: 'auto',
    });

    let keyWordArr = [
        { id: 'CN', keyword: ['china', 'mainland', 'mainland china', '中国', '中國', '中', 'zg', 'zhong guo', 'zhongguo'] },
        { id: 'HK', keyword: ['china', '中国', '中國', '中', 'zg', 'zhong guo', 'zhongguo', '香', '香港', '港', 'hong kong', 'hongkong', 'hk', 'xiang', 'xianggang', 'xiang gang'] },
        { id: 'TW', keyword: ['china', '中国', '中國', '中', 'zg', 'zhong guo', 'zhongguo', '台', '台湾', '湾', '灣', '台灣', 'taiwan', 'tai'] },
        { id: 'MO', keyword: ['china', '中国', '中國', '中', 'zg', 'zhong guo', 'zhongguo', '澳', '澳门', '门', '澳門', '門', 'macau', 'ao men', 'aomen'] },
        { id: 'KR', keyword: ['대한민국'] },
        { id: 'JP', keyword: ['日本', '日'] },
        { id: 'FR', keyword: ['France', 'france'] },
        { id: 'DE', keyword: ['Deutschland', 'deutschland'] },
        { id: 'IT', keyword: ['Italia', 'italia'] },
        { id: 'ES', keyword: ['España', 'españa', 'Spain', 'spain'] },
        { id: 'TR', keyword: ['türkiye', 'turkey', 'Turkey'] },
        { id: 'RU', keyword: ['Россия'] },
        { id: 'TH', keyword: ['ประเทศไทย'] },
        { id: 'VN', keyword: ['Việt Nam'] },
    ];
    // Scroll ===================
    let lastKnownScrollPosition = 0;
    let ticking = false;

    function doSomething(scrollPos) {
        setFiexd(scrollPos)
    }

    document.addEventListener("scroll", (event) => {
        lastKnownScrollPosition = window.scrollY;

        if (!ticking) {
            window.requestAnimationFrame(() => {
                doSomething(lastKnownScrollPosition);
                ticking = false;
            });

            ticking = true;
        }
    });

    $("#formBox").find(".inputNumber").on("blur", function() {
        const that = this;
        let Value = $(that).val();
        if ((Value - 0) < 100) {
            $(this).val(100)
        }
    })
    function setFiexd(scrollPos) {
        const btnOffseTop = $('#HardwareWallets .btnBox').eq(0).offset().top
        const headerHight = $('#header').outerHeight()
        const marginTop = headerHight < 100 ? 10 : 24
        const PowerfulOffseTop = $('#Powerful').offset().top
        if (scrollPos >= (btnOffseTop - headerHight - marginTop)) {
            $('#fiexdBtn').show()
        }

        if (scrollPos < (btnOffseTop - headerHight - marginTop) || scrollPos > PowerfulOffseTop - headerHight - 150) {
            $('#fiexdBtn').hide()
        }
    }
    // init ===================
    init()
    function init(params) {
        let textCover = {
            'Most Popular': most_popular || 'Most Popular',
            'Free shipping': free_shipping || 'Free shipping',
           'SafePal Cypher Seed Board' : safepal_cypher_seed_board || 'SafePal Cypher Seed Board',
           'SafePal Leather Case' : safepal_leather_case || 'SafePal Leather Case',
           'SafePal S1 Hardware Wallet' : safepal_s1_hardware_wallet || 'SafePal S1 Hardware Wallet',
           'SafePal X1 Hardware Wallet': safepal_x1_hardware_wallet || 'SafePal X1 Hardware Wallet',
           'SafePal S1 Pro Hardware Wallet': safepal_s1pro_hardware_wallet || 'SafePal S1 Pro Hardware Wallet',
           'Deluxe Bundle': deluxe_bundle || 'Deluxe Bundle',
           'Unrivalled security and protection for your assets and devices': unrivalled_security_protection || 'The most popular combination to safeguard crypto assets for experienced users',
           'Supercharge your security with a backup device': supercharge_security || 'Manage crypto assets with peace of mind, with a main hardware wallet and the other device kept securely as a backup',
           'Protect and secure your seed phrase and crypto assets': protect_secure_seed_crypto || 'Enhance long term security for managing crypto assets, by pairing usage with a SafePal hardware wallet and Cypher seed board',
           'A standard package to protect your wallet from wear and tear': standard_package_protect || 'Affordable package with the essentials to start managing crypto conviently and securely',
           'Experience unrivalled security with the SafePal hardware wallet line': experience_unrivalled_security || 'Experience unrivalled security and peace of mind with storage for crypto assets, with the entire SafePal hardware wallet line',
           'Experience unrivalled security and protection with the SafePal hardware wallet line and accessories': experience_unrivalled_security_accessories || 'Experience unrivalled security and the best Web3 and crypto asset management, with the full SafePal product line',
           "Expert's Choice": expert_choice || "Classic Bundle",
           "Backup Package": backup_package || "Backup bundle",
           "Hardcore Bundle": hardcore_bundle || "Holder's Bundle",
           "Standard Package": standard_package || "Basic Bundle",
           "Expert Bundle": expert_Bundle || "Expert Bundle",
           "Ultra-Deluxe Bundle": ultra_deluxe_bundle ||  "Utlimate Value Bundle"
        };
        $.ajax({
            url: `${base_url}/getAllProductListForNewPage`,
            dataType: 'json',
            success: function (result) {
                let list = result.data.list
                $('.s1Box .price').html(`$${list.find(item => item.sku === 'S1').price}`)
                $('.x1Box .price').html(`$${list.find(item => item.sku === 'X1').price}`)
                $('.s1proBox .price').html(`$${list.find(item => item.sku === 'S1P').price}`)
                $('.cyBox .price').html(`$${list.find(item => item.sku === 'CY').price}`)
                $('.lcBox .price').html(`$${list.find(item => item.sku === 'LC').price}`)
                list.forEach(v => {
                    v.full_name_locale = textCover[v.name] || v.name

                })
                list = list.filter(item=> item.sku !== 'LC')
                countrySelect('#product_customize-select', list, null, 'name');
            }
        });
        $.ajax({
            url: `${base_url}/getAllGroupProductListForNewPage`,
            dataType: 'json',
            success: function (result) {
                let dom = ``

                const list = result?.data?.list || []
                list.forEach(item => {
                    dom += `<h4>${ (textCover[item.top_title] || item.top_title) }</h4>`
                    dom += `<div class="productBox">`
                    item.items.forEach(v => {
                        let pListDom = ``
                        v.plist.forEach(v2 => {
                            pListDom += `
                                    <div class="has">
                                        <span class="hasNum">${v2.num} x</span>
                                        <div class="hasBox">
                                            <img src="${v2.img}" alt="">
                                            <span>${textCover[v2.name] || v2.name}</span>
                                        </div>
                                    </div>
                                    `
                        })
                        dom += `
                                        <div class="itemBox">
                                            <div class="left">
                                                ${v.pop_text ? ` <div class="popular">
                                                    <span>${textCover[v.pop_text] || v.pop_text}</span>
                                                </div>` : ''}
                                            
                                                <div class="imgBox">
                                                    <img src="${v.img}" alt="">
                                                </div>
                                                <div class="tipBox">
                                                    <span class="tip1">${ v.title1 === 'Deluxe Bundle' ? (expert_Bundle || "Expert Bundle") : (textCover[v.title1] || v.title1)}</span>
                                                    ${v.free_shipping ? `<span class="tip2">${textCover[v.free_shipping] || v.free_shipping}</span>` : ''}
                                                </div>
                                                <div class="desBox">
                                                    <div class="des">
                                                        ${textCover[v.title2] || v.title2}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="right">
                                                <div class="hasContent">
                                                    <div class='hasItemBox'>${pListDom}</div>
                                                  
                                                </div>
                                                <div class="priceBox">
                                                    ${ v.zhe_price 
                                                        ? `<div class="d-none d-sm-block">
                                                                <div class="zhePriceBox">
                                                                    <span class="price2">$${v.price}</span>
                                                                    <span class="price1">$${v.zhe_price}</span>
                                                                    <span class="zheInfo">-${v.zhe || v.zhe_title}</span>
                                                                </div>
                                                            </div>
                                                            <div class="d-sm-none">
                                                                <div class="zhePriceBoxm">
                                                                    <div class="d-flex align-items-center justify-content-center">
                                                                        <span class="price1">$${v.zhe_price}</span>
                                                                        <span class="zheInfo">-${v.zhe || v.zhe_title}</span>
                                                                    </div>
                                                                    <p class="price2">$${v.price}</p>
                                                                </div>
                                                                
                                                            </div>` 
                                                        : `<div class="regularPriceBox">
                                                                <span class="price1">$${v.price}</span>
                                                                ${v.old_price ? `<span class="price2">$${v.old_price}</span>` : ''}  
                                                            </div>` 
                                                    }
                                                </div>
                                                <div class="addBox">
                                                    <div class="inputBox"><div class='reduceIcon'>-</div>  <input value='1' class='inputNumber'> <div class='addIcon'>+</div></div>
                                                    <div class="btnBox"> <button class='addToCartBtn' sku='${v.sku}'>${add_to_cart ? add_to_cart : 'ADD TO CART' }</button> </div>
                                                </div>
                                            </div>
                                        </div>
                                   `
                    })
                    dom += ` </div>`
                });
                $('#productContent').html(dom)

            }
        });
        $.ajax({
            url: `${base_url}/getAllBottomlineForNewPage`,
            dataType: 'json',
            success: function (result) {
                $('#s1ReviewsNum').html(result.data.list.S1.total_reviews + 2000)
                $('#x1ReviewsNum').html(result.data.list.X1.total_reviews + 95)
                $('#s1proReviewsNum').html(result.data.list.S1P.total_reviews + 80)
                $('#s1cyReviewsNum').html(result.data.list.CY.total_reviews + 200)
                $('#s1lcReviewsNum').html(result.data.list.LC.total_reviews + 170)
            }
        });

        let token = $.cookie('token');
        $.ajax({
            url: `${base_url}/getCountries`,
            dataType: 'json',
            beforeSend: function (xhr) {
                xhr.setRequestHeader('Authorization', `Bearer ${token}`);
            },
            success: function (result) {
                if (result && result.length) {
                    result.map(item => {
                        keyWordArr.map(k => {
                            if (item.id === k.id) {
                                item['keyword'] = k['keyword'];
                            }
                        });
                        if (item.id === "CN") {
                            item.available_regions && item.available_regions.map(j => {
                                switch (j['id']) {
                                    case '689':
                                        j['keyword'] = ['香', '香港', '港', 'hong kong', 'hongkong', 'hk', 'xiang', 'xianggang', 'xiang gang']
                                        break;
                                    case '696':
                                        j['keyword'] = ['澳', '澳门', '门', '澳門', '門', 'macau', 'ao men', 'aomen']
                                        break;
                                    case '705':
                                        j['keyword'] = ['台', '台湾', '湾', '灣', '台灣', 'taiwan', 'tai']
                                        break;
                                }
                            })
                        }
                    })
                    countries = result;
                    countrySelect('#country-select', countries);
                }
            }
        });
    }
    // gopage===================
    function goPage(url, isDom) {
        if (isDom) {
            $('#fiexdBtn').css('visibility', 'hidden')
            setTimeout(() => {
                $('#fiexdBtn').css('visibility', 'unset')
            }, 1000);
            const domOffseTop = $(url).offset().top
            const headerHight = $('#header').outerHeight()
            const ortherNum = url === '#Accessories' ? 30 : 0
            $('html, body').animate({ scrollTop: domOffseTop - headerHight - ortherNum }, 100);
        } else {
            location.href = url
        }
    }
    //addToCart ===================
    $('#productContent').on('blur', '.inputNumber', function (e) {
        if (!Number(e.target.value)) {
            $(this).val(1)
        }
    })
    $('#productContent').on('input', '.inputNumber', function (e) {
        $(this).val(e.target.value.replace(/\D/g, ''))
    })
    $('#ContactModel').on('input', '.inputNumber', function (e) {
        $(this).val(e.target.value.replace(/\D/g, ''))
    })
    $('#productContent').on('click', '.reduceIcon', function (e) {
        const input = $(this).siblings('input')
        if (Number(input.val()) <= 1) {
            return
        }
        input.val(Number(input.val()) - 1)
    })
    $('#productContent').on('click', '.addIcon', function (e) {
        const input = $(this).siblings('input')
        input.val(Number(input.val()) + 1)
    })
    $('#productContent').on('click', '.addToCartBtn', function (e) {
        const input = $(this).parents('.itemBox').find('input')
        const cartItem = {
            qty: input.val(),
            sku: $(this).attr('sku')
        }
        let that = this;
        let param = { cartItem }
        $(that).btnLoadingStart({ text: 'Adding' })
        $.addItemToCart(param).finally(() => {
            $(that).btnLoadingEnd();
        });
    })



    // form ===================
    function countrySelect(dom, list, currentId, label) {
        $(dom).mySelect({
            mark: dom.replace('#','') || 'country',
            require: true,
            // #div为容器
            id: 'id', // 唯一标识
            currentId: currentId || null, // 当前选择的数据
            arr: list, // 数据源
            label: 'full_name_locale', // input展示数据
            selectPlaceHolder: '-',
            callback: function (val) {
                $(`${dom} .hide`).val(val.id)

            }, // 回调函数
            liRow: [
                `<div class="li-box f-flex justify-content-between align-items-center"><div class="flag-img ${dom  ? '{{ sku }}' : '' }"><img src={{ img }} onerror="$.flagError()" /></div><div class="item-text"><p>{{ full_name_locale }}</p></div><div class="item-select"><svg width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="12.4395" cy="12" r="12" fill="#4A21EF"/><path fill-rule="evenodd" clip-rule="evenodd" d="M6.51367 12.033L7.43616 11.0165L10.9486 13.6822L17.6363 7.17725L18.3647 7.56332L11.1701 16.8231L6.51367 12.033Z" fill="white"/></div></div>`
            ], // 自定义下拉列表（可以不传）
            searchList: ['full_name_locale', 'full_name_english', 'keyword'], // 模糊查询字段列表

        });
    }
    // model 
    $('#showContactModelBtn').click(function () {
        $('#subBox').show();
        $('#subEndBox').hide();
        $('body').css('overflow', 'hidden')
        $('#ContactModel').show()
    })
    $('#hideContactModelBtn').click(function () {
        $('body').css('overflow', 'auto')
        $('#ContactModel').hide()
    })

    $('#formSubBtn').click(function () {
        let that = this
        $(that).btnLoadingStart({ text: 'Loading...' })
        // const data = $('#formBox').serialize();
        let data = {};
        let value = $('#formBox').serializeArray();
        let err = ''
        $.each(value, function (index, item) {
            data[item.name] = item.value;
            // if (!item.value) {
            //     err =  `Please input ${item.name}`
            // }
        });
        if (!data['name']) {
            err = err || please_input_name || `Please input name`
        }
        if (!data['country']) {
            err =  err || please_input_delivery_country || `Please input Delivery country`
        }
        const reg = new RegExp("^[a-z0-9A-Z]+[- | a-z0-9A-Z . _]+@([a-z0-9A-Z]+(-[a-z0-9A-Z]+)?\\.)+[a-z]{2,}$")
        if (!reg.test(data['email'])) {
            err = err || input_valid_email ||  `Please input a valid email`
        }
        if (data['telegram']) {
            if (data['telegram'].charAt() !== '@') {
                err = err || input_telegram_handle ||  `Please input Telegram handle`
            } else if (!(data['telegram'].substring(1).match(/^[\w]+$/))) {
                err = err || input_telegram_handle ||  `Please input Telegram handle`
            }
        }
        if (!data['product_customize']) {
            err =  err || input_products_customize || `Please input Products you want to customize`
        }
        if (!data['order_quantity']) {
            err =  err || input_order_quantity || `Please input order quantity`
        }
        if (!data['expected_delivery_time']) {
            err =  err || input_expected_delivery_date || `Please input Expected delivery date`
        }
        if (!data['comments']) {
            err =  err || input_comments || `Please input comments`
        }
        if (err) {
            showDialog(err)
            $(that).btnLoadingEnd()
            return
        }
        $.ajax({
            url: `${base_url}/postContactUsForNewPage`,
            type: 'post',
            contentType: "application/json;charset=utf-8",
            dataType:'json',
            data: JSON.stringify(data),
            success: function (result) {
                $(that).btnLoadingEnd()
                if (result.code < 0) {
                    showDialog(result.msg)
                } else {
                    $('#subBox').hide();
                    $('#subEndBox').show();
                }
            },
        });
    })
    function showDialog(text) {
        $(document).dialog({
            type: 'confirm',
            titleShow: true,
            titleText: '',
            closeBtnShow: true,
            bodyNoScroll: true,
            dialogClass: 'dialog-cart-empty',
            content: text || 'error',
            buttons: [{ class: 'cart-empty', name: 'OK', callback: () => { } }]
        });
    }   
    $('document').myCart();
    setTimeout(() => {
        $("#inputDate").datepicker({
            autoclose: true,
            clearBtn: true,
            format: "yyyy-mm-dd",
            startDate: '0d'
        });
    }, 200);
  
})()
