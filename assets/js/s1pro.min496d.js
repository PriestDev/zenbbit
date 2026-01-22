!async function(){"use strict";brandoverviewShow(),getTapfiliateClickEventIdByRef(),setTracker("S1P");let t=$.cookie("token"),o="";function a(){return $.ajaxPromise({type:"get",url:base_url+"/getAccessToken",dataType:"json",cache:!1,async:!0}).then(async e=>{(t=e.replace(/\"/g,""))&&32!==t.length&&(t=""),$.cookie("token",t,{expires:1,path:"/"}),await s(t).then(()=>{$("document").myCart()})})}function l(){return"navigator"in window&&window.navigator.userAgent.match(/(iPad)|(iPhone)|(iPod)|(Android)|(PlayBook)|(BB10)|(BlackBerry)|(Opera Mini)|(IEMobile)|(webOS)|(MeeGo)/i)}function d(e,t){$(e).raty({width:110,readOnly:!0,score:t,halfShow:!1,path:"/assets/img/s1",starOff:"icon_raty_empty_star.svg",starOn:"icon_raty_fill_star.svg",hints:["","","","",""]})}function s(t){return $(document.body).myLoadingStart(),$.ajaxPromise({type:"get",url:base_url+"/products/S1P",dataType:"json",contentType:"application/json;charset=utf-8",beforeSend:function(e){e.setRequestHeader("Authorization","Bearer "+t)},cache:!1,async:!0}).then(e=>{var{price:e,custom_attributes:t,media_gallery_entries:a,id:s}=e,i=(o=s,(e,t)=>{let a;return e.map(e=>{if(e.attribute_code===t)return a=e.value,e.value}),a}),i=i(t,"special_price")?(+i(t,"special_price")).toFixed(2):e;$(".hero-right").find(".price-text").text("$"+i);const n=a&&a.map(e=>{e=e.file.split("/"),e=e[e.length-1].split(".");return`https://static.isafepal.com/mshop/dev/${e[0]}_new111.`+e[1]})||[];let r="";n.map(e=>{r+=`<div class="swiper-slide">
                    <img src="${e}" />
                </div>`}),$(".mySwiper2").find(".swiper-wrapper").empty(),$(".mySwiper").find(".swiper-wrapper").empty(),$(".mySwiper2").find(".swiper-wrapper").append(r),$(".mySwiper").find(".swiper-wrapper").append(r);var t=new Swiper(".mySwiper",{loop:!1,spaceBetween:10,slidesPerView:6,freeMode:!0,watchSlidesProgress:!0}),l=new Swiper(".mySwiper2",{loop:!0,autoplay:{delay:3e3,disableOnInteraction:!1},spaceBetween:10,pagination:{el:".mySwiper-mobile-pagination"},navigation:{nextEl:".swiper-button-next",prevEl:".swiper-button-prev"},thumbs:{swiper:t}});l.on("click",function(){$(document.body).fotoramaStart({index:l.activeIndex,list:n})}),$.ajaxPromise({type:"get",url:`https://api.yotpo.com/products/yRPkzI5kR3LmVNbdBaMXTbMfGkcDhjZ5D525b1f9/${s}/bottomline`,dataType:"json",contentType:"application/json;charset=utf-8",cache:!1,async:!0}).then(e=>{var{status:{code:e},response:t}=e;200===e?(d("#icon-evaluation",(e=t&&t.bottomline).average_score),$("#text-evaluation").html(+e.total_reviews+80)):(d("#icon-evaluation",5),$("#text-evaluation").html(271))})}).catch(e=>{e=e.status;401===e&&a()}).finally(()=>{$(document.body).myLoadingEnd()})}(t=t&&decodeURIComponent(t))?await s(t).then(()=>{$("document").myCart()}):a(),$(".shg-item").find(".collapse").on("hide.bs.collapse",e=>{e=e&&e.target,e=$(e).siblings(".shg-item-box").find(".icon-arrow");e.removeClass("arrow-up"),e.addClass("arrow-down"),e.attr("src","/assets/img/icon-arrow-down.svg")}),$(".shg-item").find(".collapse").on("show.bs.collapse",e=>{e=e&&e.target,$(".shg-item").map((e,t)=>{var a=$(t).find(".collapse"),a=($(a).removeClass("show"),$(t).find(".icon-arrow"));a.removeClass("arrow-up"),a.addClass("arrow-down"),a.attr("src","/assets/img/icon-arrow-down.svg")}),e=$(e).siblings(".shg-item-box").find(".icon-arrow");e.removeClass("arrow-down"),e.addClass("arrow-up"),e.attr("src","/assets/img/icon-arrow-up.svg")}),$("#qty-input").on("blur",function(){isNaN(parseInt($(this).val()))||""===$(this).val()||"0"===$(this).val()?$(this).val(1):$(this).val(parseInt($(this).val()))}),await!$.ajax({type:"get",url:base_url+"/getGroupProductList?sku=S1P",dataType:"json",cache:!1,async:!0,success:function(e){var e=Array.isArray(e)?[...e]:JSON.parse(e),t=e[0];let a="",s={"Expert's Choice":expert_choice||"Classic Bundle","Backup Package":backup_package||"Backup bundle","Hardcore Bundle":hardcore_bundle||"Holder's Bundle","Standard Package":standard_package||"Basic Bundle","Deluxe Bundle":deluxe_bundle||"Expert Bundle","Ultra-Deluxe Bundle":ultra_deluxe_bundle||"Utlimate Value Bundle"};t=`<div class="col-xxl-3 col-xl-3 col-lg-3 col-md-12 my-col">
                <div class="wallet-item">
                    <div class="img">
                        <img class="img-fluid" src="/assets/img/s1pro-double.png" alt="" srcset="">
                    </div>
                    <div class="item-middle">
                        <div class="title d-flex justify-content-start align-items-center">
                            <h3>${s["Backup Package"]||"Backup Package"}</h3>
                        </div>
                        <div class="price-num d-flex justify-content-start align-items-center">
                            ${t.d_zhe_point_S1P&&""+t.d_zhe_point_S1P!="0"?`<div class="d-flex justify-content-start align-items-center flex-column price">
                                        <p class="priceZhe"><span class="hasDiscount">$</span><span style="padding-left: 3px;">${t.d_zhe_price_S1P}</span></p>
                                        <p class="d-flex justify-content-start align-items-center zheTitle">
                                            <span style="font-size: 12px;color:#C3BAE7;text-decoration: line-through;">$${t.d_price_S1P}</span>
                                            <span class="zheInfo">-${t.d_zhe_S1P}</span>
                                        </p>
                                        
                                    </div>`:`<div class="d-flex justify-content-start align-items-center flex-column price">
                                        <p>$${t.d_price_S1P??"179.98"}</p>
                                    </div>`}
                            <div class="input-num">
                                <div id="minus">-</div>
                                <input 
                                    type="text" 
                                    id="num-input-s1p-double" 
                                    data-min="1"
                                    data-max="1000"
                                    data-default="1" value="1" class="position-relative qty-input" placeholder="">
                                <div id="plus">+</div>
                            </div>
                        </div>
                        <div class="free-shipping">
                            <p>${free_shipping}</p>
                        </div>
                    </div>
                    <div class="add-cart">
                        <button item_sku="s1p-double" item_input="num-input-s1p-double" type="button" class="add-cart-btn-recommended btn-common my-btn my-btn-add btn-light-green">${add_to_cart||"ADD TO CART"}</button>
                    </div>
                </div>
            </div>`;e&&e.map(e=>{a+=`<div class="col-xxl-3 col-xl-3 col-lg-3 col-md-12 my-col">
                        <div class="wallet-item">
                            <div class="img">
                                <img class="img-fluid" src="https://static.isafepal.com/mshop/dev/${e.sku}V2.png" alt="" srcset="">
                            </div>
                            <div class="item-middle">
                                <div class="title d-flex justify-content-start align-items-center">
                                    <h3>${s[e.title1]||e.title1}</h3>
                                    <span style="${["S1P_CY_LC"].includes(e.sku)?"":"display:none"}" class="more-popular">${most_popular}</span>
                                </div>
                                <div class="price-num d-flex justify-content-start align-items-center">
                                    ${e.zhe_point&&""+e.zhe_point!="0"?`<div class="d-flex justify-content-start align-items-center flex-column price">
                                                <p class="priceZhe"><span class="hasDiscount">$</span><span style="padding-left: 3px;">${e.zhe_price}</span></p>
                                                <p class="d-flex justify-content-start align-items-center zheTitle">
                                                    <span style="font-size: 12px;color:#C3BAE7;text-decoration: line-through;">$${e.price}</span>
                                                    <span class="zheInfo">-${e.zhe||e.zhe_title}</span>
                                                </p>
                                                
                                            </div>`:`<div class="d-flex justify-content-start align-items-center flex-column price">
                                                <p>$${e.price}</p>
                                            </div>`}
                                    <div class="input-num">
                                        <div id="minus">-</div>
                                        <input 
                                            type="text" 
                                            id="num-input-${e.sku}" 
                                            data-min="1"
                                            data-max="1000"
                                            data-default="1" value="1" class="position-relative qty-input" placeholder="">
                                        <div id="plus">+</div>
                                    </div>
                                </div>
                                <div class="free-shipping">
                                    <p>${["S1P_CY_LC","S1P_CY"].includes(e.sku)?free_shipping:""}</p>
                                </div>
                            </div>
                            <div class="add-cart">
                                <button item_sku="${e.sku}" item_input="num-input-${e.sku}" type="button" class="add-cart-btn-recommended btn-common my-btn my-btn-add btn-light-green">${add_to_cart||"ADD TO CART"}</button>
                            </div>
                        </div>
                    </div>`}),$("#recommended-row").html(t+a),$(".input-num").each((e,t)=>{var a={selectors:{addButtonSelector:"#plus",subtractButtonSelector:"#minus",inputSelector:"#"+$(t).find("input").attr("id")},settings:{checkValue:!0,isReadOnly:!1}};$(t).inputCounter(a)}),$(".qty-input").on("blur",function(){isNaN(parseInt($(this).val()))||""===$(this).val()||"0"===$(this).val()?$(this).val(1):$(this).val(parseInt($(this).val()))}),$(".add-cart-btn-recommended").on("click",function(){let e=this;var t=$(this).attr("item_input"),a=$(this).attr("item_sku");let s={};s="s1p-double"===a?{cartItem:{sku:"S1P_S1P",qty:""+ +$("#"+t).val()}}:{cartItem:{sku:a,qty:$("#"+t).val()}},$(e).btnLoadingStart({text:adding||"Adding"}),$.addItemToCart(s).finally(()=>{$(e).btnLoadingEnd()})})}}),$("#add-cart").on("click",function(){let e=this;var t={cartItem:{sku:"S1P",qty:$("#qty-input").val()}};$(e).btnLoadingStart({text:adding||"Adding"}),$.addItemToCart(t).finally(()=>{$(e).btnLoadingEnd()})}),$("#order-now").on("click",async()=>{var e={cartItem:{sku:"S1P",qty:$("#qty-input").val()}};$(document.body).myLoadingStart(),$(this).btnLoadingStart({text:"Loading"}),await $.addItemToCart(e),window.sessionStorage.removeItem("bllingRadio"),window.location.href=url_lang?`/${url_lang}/checkout`:"/checkout",$(this).btnLoadingEnd(),$(document.body).myLoadingEnd()});let i=["#7E9AFF","#2BBDB5","#FFD37E","#FF5AB5","#2EBD85"];var e=[{name:"SwissUser",avatar:"/assets/img/s1/trusted-avatar-HeYi.svg?v=1",socre:5,title:the_really_best_defi_hardware_wallet||"The really best, DEFI-Hardware Wallet for PRO's",comment:i_had_all_ledger_trezor_ellipal||"I had all. Ledger, Trezor, Ellipal. Safepal ist like a MetaMask, but more secure. You can add all Coins due Smart-Contract Adress."},{name:"Daniel O",avatar:"/assets/img/s1/trusted-avatar-HeYi.svg?v=1",socre:5,title:nice_one_indeed||"Nice One Indeed",comment:i_really_like_the_performance||"I really like the performance of the safepal haveware wallet very simple and easy to understand and configure the set up, all you need is going through the details and you will be done."},{name:"LEANDRO",avatar:"/assets/img/s1/trusted-avatar-HeYi.svg?v=1",socre:5,title:placa_semente||"Placa semente",comment:comprei_a_placa_pra||"COMPREI A PLACA PRA GUARDA COM MAIS SEGURANÇAS AS MINHAS PALAVRAS. SENDO QUE ALGUMAS TEM MAIS LETRA QUE O PROPRIO ESPAÇO E AGORA"},{name:"John D.",avatar:"/assets/img/s1/trusted-avatar-HeYi.svg?v=1",socre:5,title:best_in_class||"Best in class",comment:it_just_work||"It just work, easy to use and totally offline, your only task here is to save your seeds!"},{name:"komi",avatar:"/assets/img/s1/trusted-avatar-HeYi.svg?v=1",socre:5,title:perfect_trusted||"Perfect",comment:i_wish_you_decide||"I wish you decide to offer debit card service as well ! imagin you can spend and buye every thing with safepal debit card that link to safepal hardware wallet ."},{name:"Igor B",avatar:"/assets/img/s1/trusted-avatar-HeYi.svg?v=1",socre:5,title:add_coins_assets||"Add Coins Assets",comment:great_and_secure_wallet||"Great and secure wallet. But I only come in this way, as I have already filled out the form requesting the insertion of some coins. If you could add all the coins from Polkadot and Kusama networks I would appreciate it. `DON'T HAVE YOUR KEYS, IT'S NOT YOUR COINS`."},{name:"Mujeeb R.",avatar:"/assets/img/s1/trusted-avatar-HeYi.svg?v=1",socre:5,title:like_to_have_an_hardware_smartwatch||"Great...! I would like to have an Hardware Smartwatch",comment:secure_my_crypto_asset||"I love this... It's secure my crypto asset. Right now I am thinking about smartwatch hardware wallets with kind features with it. I hope you will have too..."},{name:"den",avatar:"/assets/img/s1/trusted-avatar-HeYi.svg?v=1",socre:5,title:exelent_wallet||"Exelent wallet!!!!",comment:also_looking_forward||"Also looking forward to the possibility of a mobile application for extension in the browser :)"}];let n=[],r="";$("#trusted-swiper-wrapper").html(""),e.map(e=>{r+=`
        <div class="swiper-slide trusted-item ${l()?"is_mobile":""}">
            <div class="character-info d-flex justify-content-start align-items-center">
                <div class="avatar">
                    <img class="img-fluid rounded-circle" src="${function(e="",t,a="#3F37FF"){let s,i,n,r;return"?"==(s=(s=(s=String(e).trim().toUpperCase()).replace(/\uD83C[\uDF00-\uDFFF]|\uD83D[\uDC00-\uDE4F]/g,""))?s.charAt(0):"?")||s.charCodeAt(0),(i=document.createElement("canvas")).width=t,i.height=t,(n=i.getContext("2d")).fillStyle=a,n.fillRect(0,0,i.width,i.height),n.font=Math.round(i.width/2)+"px 'Microsoft Yahei'",n.textAlign="center",n.fillStyle="#fff",n.fillText(s,t/2,t/1.5),r=i.toDataURL("image/png"),i=null,r}(e.name,60,i[parseInt(Math.random()*i.length)])}" alt="" srcset="">
                </div>
                <div class="info">
                    <h3 class="name">${e.name}</h3>
                    <div class="${e.name.replace(/\s+/g,"-").replace(/./g,"")}-raty"></div>
                </div>
            </div>
            <div class="describe">
                <h3>${e.title}</h3>
                <p>${e.comment}</p>
            </div>
        </div>`,n=[...n,{name:e.name,socre:e.socre}]}),$("#trusted-swiper-wrapper").append(r);e={loop:!0,init:!1,autoplay:{delay:3e3,disableOnInteraction:!1},slidesPerView:"auto"};l()?Object.assign(e,{speed:1e3,pagination:{el:".swiper-pagination-trusted"}}):Object.assign(e,{speed:8e3,freeMode:!0,allowTouchMove:!1,autoplay:{disableOnInteraction:!1,stopOnLastSlide:!1,pauseOnMouseEnter:!0,delay:0},loopFillGroupWithBlank:!0,normalizeSlideIndex:!0});const c=new Swiper(".trusted-slider",{...e,breakpoints:{320:{slidesPerView:1,spaceBetween:20},480:{slidesPerView:1,spaceBetween:20},640:{slidesPerView:1,spaceBetween:20},720:{slidesPerView:2,spaceBetween:20},992:{slidesPerView:2,spaceBetween:40},1200:{slidesPerView:3,spaceBetween:40},1440:{slidesPerView:3,spaceBetween:40},1920:{slidesPerView:4,spaceBetween:40}}});document.addEventListener("aos:in:trusted-swiper",function(){c.init();let t="",a,s,i,n=0,r;l()||(c.el.onmouseover=function(){var e="ar"===url_lang?1:-1;t=$("#trusted-swiper-wrapper")[0].style.transform,a=e*parseInt(t.split("px")[0].split("translate3d(")[1]),i=window.getComputedStyle($("#trusted-swiper-wrapper")[0],!1).transform,s=e*parseInt(window.getComputedStyle($("#trusted-swiper-wrapper")[0],!1).transform.split("1,")[2].split(",")[0]),r=525,n=(a-s)/525*8e3,$("#trusted-swiper-wrapper")[0].style.transform=i,$("#trusted-swiper-wrapper")[0].style.transitionDuration="0ms",c.autoplay.stop()},c.el.onmouseout=function(){$("#trusted-swiper-wrapper")[0].style.transform=t,$("#trusted-swiper-wrapper")[0].style.transitionDuration=n+"ms",c.autoplay.start()})}),n.map(e=>{d("."+e.name.replace(/\s+/g,"-").replace(/./g,"")+"-raty",e.socre)}),on("click",".contrast-click-item",function(e){var t=$(".contrast-click-item").siblings(),a=$(this).attr("class");const s=$(this).attr("data");var i=$(".table-item").find("."+s);let n=[];["nanox","one"].forEach(function(e){e!==s&&(n=[...n,e])}),a.indexOf("active")<0&&(t.map((e,t)=>{$(t).removeClass("active")}),$(this).addClass("active"),i.map((e,t)=>{$(t).removeClass("d-none").removeClass("d-lg-block")}),n.forEach(function(e){$("."+e).map((e,t)=>{$(t).addClass("d-none").addClass("d-lg-block")})}))},!0);{let t=$(".arrow-change").find("svg.arrow-change-svg");t.on("click",e=>{let a=$(e.currentTarget).attr("name");switch($(e.currentTarget).attr("actived")){case"s1pro":if("left"===a)return!1;t.map((e,t)=>{$(t).attr("actived","x1")}),$(".device_s1pro").addClass("d-none").addClass("d-lg-block"),$(".device_x1").removeClass("d-none").removeClass("d-lg-block");break;case"x1":t.map((e,t)=>{$(t).attr("actived","left"===a?"s1pro":"s1")}),("left"===a?($(".device_x1").addClass("d-none").addClass("d-lg-block"),$(".device_s1pro")):($(".device_x1").addClass("d-none").addClass("d-lg-block"),$(".device_s1"))).removeClass("d-none").removeClass("d-lg-block");break;case"s1":if("left"!==a)return!1;t.map((e,t)=>{$(t).attr("actived","x1")}),$(".device_s1").addClass("d-none").addClass("d-lg-block"),$(".device_x1").removeClass("d-none").removeClass("d-lg-block")}})}$(document.body).freeStart(),$("#my-comment").myComment({id:o||"2064",real:!1}),AOS.init({duration:800,easing:"ease-in-out",offset:-180,once:!0,mirror:!1})}();