(function () {
    "use strict";
    const is_mobile = navigator.userAgent.toLowerCase().match(/(ipod|ipad|iphone|android|coolpad|mmp|smartphone|midp|wap|xoom|symbian|j2me|  blackberry|wince)/i) != null;
  
    let list = [{
        "channel": "Altcoin Daily",
        "subscriber": "1.23M",
        "video_views": "27K",
        "publish_time": "May 31, 2019",
        "video_url": "https://www.youtube.com/embed/qIs-x9aNhUE",
        "avatar": "/assets/img/kol/2.jpeg",
        "video_name": "Best Cold Storage Wallet? Ledger Nano VS SafePal! Unboxing Video! SafePal Review"
    },
    {
        "channel": "Davincij15",
        "subscriber": "352K",
        "video_views": "31K",
        "publish_time": "Jun 27, 2021",
        "video_url": "https://www.youtube.com/embed/JpapI-eD4uI",
        "avatar": "/assets/img/kol/3.jpeg",
        "video_name": "SafePal - Hardware Crypto Wallet Product Review"
    },
    {
        "channel": "Voepa Bitcoin",
        "subscriber": "179K",
        "video_views": "23K",
        "publish_time": "Jun 5, 2021",
        "video_url": "https://www.youtube.com/embed/f8gsSkPxSck",
        "avatar": "/assets/img/kol/4.jpeg",
        "video_name": "CARTEIRA SAFEPAL FÍSICA CONFIGURAÇÃO - CURSO BITCOIN DO ZERO"
    },
    {
        "channel": "Hashoshi",
        "subscriber": "170K",
        "video_views": "23K",
        "publish_time": "Jul 16, 2019",
        "video_url": "https://www.youtube.com/embed/LlUVoqxVAi0",
        "avatar": "/assets/img/kol/5.jpeg",
        "video_name": "Safepal Review: Binance Hardware Wallet"
    },
    {
        "channel": "TechLead",
        "subscriber": "1.37M",
        "video_views": "348K",
        "publish_time": "Dec 22, 2021",
        "video_url": "https://www.youtube.com/embed/CMpjg1-PEwM",
        "avatar": "/assets/img/kol/6.jpeg",
        "video_name": "THE BEST CRYPTO WALLET for 2022  "
    },
    {
        "channel": "Coinvestasi",
        "subscriber": "142K",
        "video_views": "22K",
        "publish_time": "Apr 28, 2021",
        "video_url": "https://www.youtube.com/embed/ofACHlhhAX0",
        "avatar": "/assets/img/kol/7.jpeg",
        "video_name": "Tokennya Naik 5000% Wallet ini Apa Bagusnya? - Review project crypto Safepal"
    },
    {
        "channel": "Success TechZ",
        "subscriber": "117K",
        "video_views": "8.5K",
        "publish_time": "Apr 10, 2022",
        "video_url": "https://www.youtube.com/embed/krT4AO30P6c",
        "avatar": "/assets/img/kol/8.jpeg",
        "video_name": "Safepal S1, Crypto Hardware Wallet आपकी क्रिप्टो को रखेगा 100% Safe Secure | Safepal Wallet"
    },
    {
        "channel": "Journal du Coin",
        "subscriber": "114K",
        "video_views": "17K",
        "publish_time": "Jun 6, 2020",
        "video_url": "https://www.youtube.com/embed/uVi0gfzioWE",
        "avatar": "/assets/img/kol/9.jpeg",
        "video_name": "SAFEPAL S1 le WALLET ultra COMPLET soutenu par BINANCE"
    },
    {
        "channel": "Crypto Fiend",
        "subscriber": "101K",
        "video_views": "38K",
        "publish_time": "Aug 27, 2019",
        "video_url": "https://www.youtube.com/embed/M0eMu9ySf7I",
        "avatar": "/assets/img/kol/10.jpeg",
        "video_name": "How to setup use a SafePal S1 Wallet | Beginners Guide 2019"
    },
    {
        "channel": "旁白君",
        "subscriber": "87K",
        "video_views": "8K",
        "publish_time": "Oct 15, 2021",
        "video_url": "https://www.youtube.com/embed/2l81TBDV45E",
        "avatar": "/assets/img/kol/11.jpeg",
        "video_name": "safepal钱包使用"
    },
    {
        "channel": "CryptoLeo",
        "subscriber": "82K",
        "video_views": "17K",
        "publish_time": "Jul 24, 2021",
        "video_url": "https://www.youtube.com/embed/DVH0BCsZCgk",
        "avatar": "/assets/img/kol/12.jpeg",
        "video_name": "Холодный кошелек Safepal S1"
    },
    {
        "channel": "Mike Satoshi",
        "subscriber": "66.5K",
        "video_views": "4.5K",
        "publish_time": "Jan 19, 2021",
        "video_url": "https://www.youtube.com/embed/0mY71Mwtoq4",
        "avatar": "/assets/img/kol/13.jpeg",
        "video_name": "SafePal S1 - instalacja, aktywacja i test portfela sprzętowego wspieranego przez Binance"
    },
    {
        "channel": "Crypto Investor",
        "subscriber": "66K",
        "video_views": "7.7K",
        "publish_time": "Jul 13, 2022",
        "video_url": "https://www.youtube.com/embed/Q5p8TvBYuTU",
        "avatar": "/assets/img/kol/14.jpeg",
        "video_name": "Safepal S1 | Safepal S1 Review | Hardware Wallet Bitcoin"
    },
    {
        "channel": "Дневник хомяка",
        "subscriber": "57K",
        "video_views": "2.4K",
        "publish_time": "Jun 30, 2022",
        "video_url": "https://www.youtube.com/embed/O5gsKl1U7mk",
        "avatar": "/assets/img/kol/15.jpeg",
        "video_name": "Обзор и полная инструкция криптокошелька SAFEPAL. Аппаратные кошельки - технология будущего?"
    },
    {
        "channel": "CryptoVel - The Cryptopreneur",
        "subscriber": "46K",
        "video_views": "16K",
        "publish_time": "Apr 9, 2021",
        "video_url": "https://www.youtube.com/embed/So1lY9Kdwjk",
        "avatar": "/assets/img/kol/16.jpeg",
        "video_name": "Safepal S1 Hardware wallet unboxing full step by step setup process, Install 10,000+ crypto."
    },
    {
        "channel": "John Patrick Acquaviva",
        "subscriber": "45K",
        "video_views": "35K",
        "publish_time": "Dec 21, 2020",
        "video_url": "https://www.youtube.com/embed/_uxe9WHJUic",
        "avatar": "/assets/img/kol/17.jpeg",
        "video_name": "Safepal es impresionante, aca les digo por que"
    },
    {
        "channel": "Anton ProfiT CRYPTO",
        "subscriber": "36K",
        "video_views": "75K",
        "publish_time": "Mar 27, 2020",
        "video_url": "https://www.youtube.com/embed/I9TyMroG_RM",
        "avatar": "/assets/img/kol/18.jpeg",
        "video_name": "Safepal S1 hard wallet | Safepal s1 reveiw and setting"
    },
    {
        "channel": "Kelas Kripto Cepod",
        "subscriber": "36K",
        "video_views": "10K",
        "publish_time": "Jun 23, 2021",
        "video_url": "https://www.youtube.com/embed/Fxa2Km1Pd6s",
        "avatar": "/assets/img/kol/19.jpeg",
        "video_name": "Review Hardware Safepal Wallet (bahasa Indonesia)"
    },
    {
        "channel": "xBitcoin Thailand",
        "subscriber": "34K",
        "video_views": "26K",
        "publish_time": "Jun 12, 2021",
        "video_url": "https://www.youtube.com/embed/LIKUGGf_W_8",
        "avatar": "/assets/img/kol/20.jpeg",
        "video_name": "[ Hardware Wallet EP.01 ] Unbox รีวิว Safepal รุ่น S1 วัสดุ,การใช้งาน,ทำธุรกรรม"
    },
    {
        "channel": "cryptonist",
        "subscriber": "33K",
        "video_views": "28K",
        "publish_time": "Oct 12, 2021",
        "video_url": "https://www.youtube.com/embed/cNd9PmwdTA4",
        "avatar": "/assets/img/kol/21.jpeg",
        "video_name": "Обзор кошелька SafePal S1 - #01 Первое включение, создание кошелька и проверка подлинности"
    },
    {
        "channel": "KriptoVadász",
        "subscriber": "17K",
        "video_views": "13K",
        "publish_time": "Oct 23, 2021",
        "video_url": "https://www.youtube.com/embed/jMn1j4dS_AY",
        "avatar": "/assets/img/kol/22.jpeg",
        "video_name": "Ledger vagy SafePal? - Összehasonlító teszt!"
    },
    {
        "channel": "satoshiat",
        "subscriber": "1.5K",
        "video_views": "5.5K",
        "publish_time": "Oct 6, 2021",
        "video_url": "https://www.youtube.com/embed/HFZ-XndgciI",
        "avatar": "/assets/img/kol/23.jpeg",
        "video_name": "حل مشكلة منصة binance بينانس في الدول المحظورة عن طريق محفظة safepal"
    },
    {
        "channel": "李奧",
        "subscriber": "12K",
        "video_views": "7.6K",
        "publish_time": "Jun 25, 2021",
        "video_url": "https://www.youtube.com/embed/Ocr5qxFC9lg",
        "avatar": "/assets/img/kol/24.jpeg",
        "video_name": "😫 Bitcoin 繼續反覆 大家做好準備 / 🔒 SafePal - Binance 認證的Cold Wallet 比Trezor/Ledger 更安全?！(中文字幕）"
    },
    {
        "channel": "Didi Random",
        "subscriber": "8K",
        "video_views": "4.7K",
        "publish_time": "Jan 22, 2022",
        "video_url": "https://www.youtube.com/embed/Q6vLaOVUjMw",
        "avatar": "/assets/img/kol/25.jpeg",
        "video_name": "Sichere deine Kryptowährungen gegen Hacks! SAFEPAL"
    },
    {
        "channel": "Ryohu",
        "subscriber": "7K",
        "video_views": "2.6K",
        "publish_time": "Jan 13, 2022",
        "video_url": "https://www.youtube.com/embed/-RVPYU3jmgI",
        "avatar": "/assets/img/kol/26.jpeg",
        "video_name": "仮想通貨おすすめウォレット「Safepal Wallet」！メタマスクよりもめちゃくちゃ扱いやすい！初心者は絶対使うべき。"
    },
    {
        "channel": "P.I.G. - Passive Income Group",
        "subscriber": "6K",
        "video_views": "25k",
        "publish_time": "Sep 9, 2021",
        "video_url": "https://www.youtube.com/embed/0nR902G9w0o",
        "avatar": "/assets/img/kol/27.jpeg",
        "video_name": "Store, Send, Swap on SafePal Wallet"
    },
    {
        "channel": "Kryptoda Tanoda, Tudástár, Kripto Kurzus, Bitcoin!",
        "subscriber": "6K",
        "video_views": "4.2K",
        "publish_time": "May 5, 2021",
        "video_url": "https://www.youtube.com/embed/NcKQtaTmp5Q",
        "avatar": "/assets/img/kol/28.jpeg",
        "video_name": "Egy hete a SafePal S1-gyel - Dappok használata - ki és beutalás - 1Inch Defi"
    },
    {
        "channel": "Kuka Invest",
        "subscriber": "2K",
        "video_views": "1.4K",
        "publish_time": "Jan 20, 2022",
        "video_url": "https://www.youtube.com/embed/ZLnuO_7Kp8A",
        "avatar": "/assets/img/kol/29.jpeg",
        "video_name": "Como configurar SAFEPAL s1 ,Tutorial completo como utilizar sua HARDWALLET #safepal #bitcoin #cripto"
    }];

    // <video id="my-video" class="video-js" controls preload="auto" width="100%" height="280"
    //     data-setup="{}">
    //     <source src="${item.video_url}" type="video/mp4" />
    //     <p class="vjs-no-js">
    //         To view this video please enable JavaScript, and consider upgrading to a
    //         web browser that
    //     </p>
    // </video>
    list.sort(function(a,b) {
        return new Date(b.publish_time).getTime() - new Date(a.publish_time).getTime()
    })
    $('.pagination-box').pagination({
        dataSource: list,
        totalNumber: 12,
        pageSize: 5,
        showGoInput: true,
        showGoButton: true,
        prevText: '&lt',
        nextText: '&gt',
        className: 'my-paginationjs-theme',
        formatGoInput: '<form action="" id="paginationjsInput"><%= input %></form>',
        pageLink: 'javascript:void(0);', //分页链接内容（部分手机会出现刷新页面）
        callback: function (data, pagination) {
            // template method of yourself
            let list = data;
            let html = '';
            $('.content-box').addClass('loading')
            $('.content-box').html('');
            list.map((item, index) => {
                html += `
                <div class="row box-item" data-aos="fade-up">
                    <div class="col-lg-6 col-md-12 col-sm-12 img order-${is_mobile ? 0 : (index+1)%2}">
                        <div class="video-box">
                            <iframe class="pic" src="${item.video_url}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-start flex-column col-lg-6 col-md-12 col-sm-12 info">
                        <div>
                            <div class="d-flex justify-content-start align-items-center personal">
                                <div class="avatar"><img src="${item.avatar}" alt="" srcset=""></div>
                                <div class="personal-info">
                                    <h3 class="name">${item.channel}</h3>
                                    <p>${item.subscriber} subscribers</p>
                                </div>
                            </div>
                            <div class="title">
                                <h3>${item.video_name}</h3>
                            </div>
                            <div class="views">
                                <p>${item.video_views} views.${item.publish_time}</p>
                            </div>
                        </div>
                    </div>
                </div>`
            });
            $('.content-box').append(html);
            $('.content-box').removeClass('loading')
        },
        afterGoButtonOnClick() {
            $('#paginationjsInput > input').blur();
            setTimeout(function() {
                select('#experts-reviews').scrollIntoView({behavior: "smooth"})
            }, 200)
        }, 
        afterPreviousOnClick() {
            select('#experts-reviews').scrollIntoView({behavior: "smooth"})
        },
        afterNextOnClick() {
            select('#experts-reviews').scrollIntoView({behavior: "smooth"})
        },
        afterPageOnClick() {
            select('#experts-reviews').scrollIntoView({behavior: "smooth"})
        },
        afterGoInputOnEnter() {
            $('#paginationjsInput > input').blur();
            setTimeout(function() {
                select('#experts-reviews').scrollIntoView({behavior: "smooth"})
            }, 200)
        }
    });
    $('.pagination-box').addHook('afterRender', function() {
        $('#paginationjsInput').bind('submit', function(e){
            e.preventDefault();
        });
    });
    $('.pagination-box').addHook('beforeRender', function() {
        $('#paginationjsInput').unbind('submit');
    });
    $('#paginationjsInput').bind('submit', function(e){
        e.preventDefault();
    });
    // 某些手机不稳定
    $('#paginationjsInput').bind('submit', function(e){
        e.preventDefault();
    });
    // ----------------- say about raty ----------------------
    function showRaty(el, socre) {
        $(el).raty({
            width: 110,
            readOnly: true, 
            score: socre,
            halfShow: false,
            path: '/assets/img/kol',
            starOff: 'icon_raty_empty_star.svg',
            starOn : 'icon_raty_fill_star.svg',
            hints: ['', '', '', '', '']
        });
    }
    let sayAboutList = [
        {name:"Crypro Angel",socre:5,submitTime:"December 09, 2020",comment:"Je ne regrette pas mon achat, tout est bien, l'application, la sécurité, le prix et l'équipe qui est formidable et un support client qui répond très vite si on a des questions 👌💯🙏🏼 Le top ! J'ai acheté 3 safepal, pour ma soeur, ma femme et moi 😁 Merci l'equipe !!"},
        {name:"Hema Choudhary",socre:5,submitTime:"December 01, 2020",comment:"All necessary functions for crypto are available and also most secure wallet . Congratulations to the team with appreciation for this idea of making the wallet."},
        {name:"Jack k",socre:5,submitTime:"November 30, 2020",comment:"Le meilleur des Hardware wallets !! Un support ultra reactif, une interface utilisateur super intuitive, evolue avec des nouvelles mises a jours, le prix est TRES raisonnable ! J'ai essayé une dizaine de marque de hardware wallets et Safepal est la meilleure !! Merci a toute l'equipe pour ce magnifique produit !!"},
        {name:"Dick",socre:5,submitTime:"November 15, 2020",comment:"How to save mnemonic phrase? Cypher meets all your requirements"},
        {name:"Roland",socre:5,submitTime:"November 08, 2020",comment:"What a great idea! the letters are definitely enough! Guys, go and get your Cypher, definitely worth it."},
        {name:"Justin",socre:5,submitTime:"October 28, 2020",comment:"Super cool!I love Cypher! I no longer have to worry about saving my mnemonic phrase"},
        {name:"Allen",socre:5,submitTime:"October 21, 2020",comment:"Recommend Cypher to everyone, best solution for cold storage backup in my opinion."},
        {name:"Kevin",socre:5,submitTime:"October 16, 2020",comment:"Great! Looking forward to more features."},
        {name:"Evanoff",socre:5,submitTime:"October 11, 2020",comment:"Although the delivery time is a bit long, I have to say that this product is really good, worth the wait!"},
        {name:"Celia",socre:5,submitTime:"September 14, 2020",comment:"J'aime sa forme et c'est très pratique à utiliser."},
        {name:"Masashi",socre:5,submitTime:"September 09, 2020",comment:"Trezorよりも使いやすく、完全にオフラインで使用する方が安全なようです"},
        {name:"Fujima",socre:5,submitTime:"August 07, 2019",comment:"After using it for a week, I decided to switch from Nano S to Safepal S1, it is amazing, I look forward to S2 :D"},
        {name:"Adan",socre:5,submitTime:"August 05, 2020",comment:"Best value for money!"},
        {name:"Liam",socre:5,submitTime:"July 25, 2020",comment:"Best value for Set up very simple, highly recommend!"},
        {name:"Ollie",socre:5,submitTime:"July 07, 2020",comment:"it's the best buy"},
        {name:"Hilary",socre:5,submitTime:"June 27, 2020",comment:"Excellent!"},
        {name:"Noah",socre:5,submitTime:"June 18, 2020",comment:"Just what I need!"},
        {name:"Grace",socre:5,submitTime:"June 05, 2020",comment:"Efficient customer support, easy operation, as advertised!"},
        {name:"CHLOE",socre:5,submitTime:"May 25, 2020",comment:"Arrived in good package, works as decribed!"},
        {name:"Robert",socre:5,submitTime:"May 06, 2020",comment:"It has all that I need about safety! It would be perfect if the screen was bigger!"},
        {name:"Robby",socre:5,submitTime:"May 01, 2020",comment:"Great price!"},
        {name:"LUNA",socre:5,submitTime:"April 24, 2020",comment:"Best hardware wallet ever!"},
        {name:"LEO",socre:5,submitTime:"March 11, 2020",comment:"Product is great and keeps updating new features!"},
        {name:"WYATT",socre:5,submitTime:"March 04, 2020",comment:"PGood price and very secure."},
        {name:"ARIA",socre:5,submitTime:"February 29, 2020",comment:"Professional for the hardware wallet, easier and more secure than any other wallets!"},
        {name:"EMMA",socre:5,submitTime:"February 23, 2020",comment:"Easier than thought in operating, like it!"},
        {name:"Sami",socre:5,submitTime:"February 18, 2020",comment:"Product is just superb compared to other hardware wallets. I truly can't recommend more if you want most security for your assets. Customer service was surprisingly fast and adept. Looking forward to see how they implement app, vote, rex etc. compatibility for EOS users. Keep up the amazing work!"},
        {name:"James",socre:5,submitTime:"January 24, 2020",comment:"Portable and reliable, Looking forward to the metal version of S2."},
        {name:"William",socre:5,submitTime:"January 23, 2020",comment:"I laso have other brand wallets, but this one is the best! You have to try something new, until you find the right one!"},
        {name:"Ella",socre:5,submitTime:"January 12, 2020",comment:"Truly offline wallet, makes me feel safe."},
        {name:"Steph",socre:5,submitTime:"July 07, 2019",comment:"Not that big, I can take it with me easily. Happy with it."},
        {name:"Blair",socre:5,submitTime:"July 15, 2019",comment:"It's really good that there is no more need to consider the limit of device memory! I have 100 coins, then it helps me to store them all! That fantastic!"},
        {name:"Izzy",socre:5,submitTime:"August 19, 2020",comment:"Yes, I agree. This is the easiest wallet on the market to use, lol"},
        {name:"Phil",socre:5,submitTime:"September 09, 2019",comment:"I'm a newbie, I got a lot of questions, and they answered them all! Thank you so much SafePal!"},
        {name:"Maxine",socre:5,submitTime:"September 25, 2019",comment:"Works beyond expectation."},
        {name:"Ricky",socre:5,submitTime:"September 28, 2019",comment:"Totally off-line is the reason I bought it. Now I would like to recommend it to anyone."},
        {name:"Zaan",socre:5,submitTime:"October 14, 2019",comment:"Works smooth, and easy to use."},
        {name:"Salcedo",socre:5,submitTime:"October 30, 2019",comment:"Everything's great"},
        {name:"Sofiane",socre:5,submitTime:"November 16, 2019",comment:"Good product and good customer support!:D"},
        {name:"Victor",socre:5,submitTime:"November 20, 2019",comment:"Works flawlessly, easy to set up and ues, like the offline feature the most."},
        {name:"Adney",socre:5,submitTime:"December 03, 2019",comment:"Could be the best one among other wallets I have!"},
        {name:"Chin",socre:5,submitTime:"December 12, 2019",comment:"The 100% offline feature is just what I need."},
        {name:"Charles",socre:5,submitTime:"December 15, 2019",comment:"Lo consiglierei ad altri"},
        {name:"Ella",socre:5,submitTime:"December 24, 2019",comment:"Truly offline wallet, makes me feel safe."},
    ];
    let raytArr = [];
    _.chunk(sayAboutList, is_mobile ? 3 : 4).map(item => {
        let html = `<div class="swiper-slide ${is_mobile ? 'is_mobile' : 'row'} ">`;
        item.map(k => {
            if (!is_mobile) {
                html += `<div class="col-6">`
            }
            html+=`<div class="swiper-item">
                <div class="d-flex justify-content-start align-items-end title">
                    <div class="avatar">
                        <img class="rounded-circle" src="${firstTextToImg(k.name)}" />
                    </div>
                    <div class="name">
                        <div class="name-text">${k.name}</div>
                        <div class="${k.name.replace(/\s+/g, '-')}-raty"></div>
                    </div>
                    <div class="submit-time align-self-end">${k.submitTime}</div>
                </div>
                <div class="comment">${k.comment}</div>
            </div>`;
            if (!is_mobile) {
                html += '</div>'
            }
            raytArr = [...raytArr, { name: k.name, socre: k.socre }]
        })
        html += '</div>'
        $(".say-about-carousel .swiper-wrapper").append(html)
    });
    let sayAboutCarouselOp = {
        loop: true,
        slidesPerView: 1,
        spaceBetween: 0,
        autoHeight: true,
        
    };
    if (!is_mobile) {
        Object.assign(sayAboutCarouselOp, {
            // 如果需要前进后退按钮
            navigation: {
                nextEl: '.button-next',
                prevEl: '.button-prev',
            },
        })
    } else {
        Object.assign(sayAboutCarouselOp, {
            pagination: {
                el: '.swiper-pagination-carousel',
            }
        })
    }
    new Swiper('.say-about-carousel', sayAboutCarouselOp);
    function firstTextToImg(text = '', size = 60, color = '#3F37FF') {
        let initials, charIndex, canvas, context, dataURI;
        initials = String(text).trim().toUpperCase();
        initials = initials.replace(/\uD83C[\uDF00-\uDFFF]|\uD83D[\uDC00-\uDE4F]/g, "");    // 去除 emoji
        initials = initials? initials.charAt(0): '?';
    
        charIndex = (initials == '?' ? 72 : initials.charCodeAt(0)) - 64;
        canvas = document.createElement('canvas');
        canvas.width = size;
        canvas.height = size;
        context = canvas.getContext("2d");

        context.fillStyle = color;
        context.fillRect(0, 0, canvas.width, canvas.height);
        context.font = Math.round(canvas.width / 2) + "px 'Microsoft Yahei'";
        context.textAlign = "center";
        context.fillStyle = "#fff";
        context.fillText(initials, size / 2, size / 1.5);
        dataURI = canvas.toDataURL("image/png");
        canvas = null;
        return dataURI;
    }
    // 渲染raty
    raytArr.map(item => {
        showRaty('.'+item.name.replace(/\s+/g, '-') + '-raty', item.socre)
    });
})()