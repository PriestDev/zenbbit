!async function(){"use strict";brandoverviewShow(),getTapfiliateClickEventIdByRef(),setTracker("LC");let e=$.cookie("token"),l="";function a(){$.ajaxPromise({type:"get",url:base_url+"/getAccessToken",dataType:"json",cache:!1,async:!0}).then(async t=>{(e=t.replace(/\"/g,""))&&32!==e.length&&(e=""),$.cookie("token",e,{expires:1,path:"/"}),await i(e).then(()=>{$("document").myCart()})})}function c(t,e){$(t).raty({width:110,readOnly:!0,score:e,path:"/assets/img/s1",starOff:"icon_raty_empty_star.svg",starOn:"icon_raty_fill_star.svg",hints:["","","","",""]})}function i(e){return $(document.body).myLoadingStart(),$.ajaxPromise({type:"get",url:base_url+"/products/LC",dataType:"json",contentType:"application/json;charset=utf-8",beforeSend:function(t){t.setRequestHeader("Authorization","Bearer "+e)},cache:!1,async:!0}).then(t=>{var{price:t,custom_attributes:e,media_gallery_entries:a,id:i}=t,n=(l=i,(t,e)=>{let a;return t.map(t=>{if(t.attribute_code===e)return a=t.value,t.value}),a}),n=n(e,"special_price")?(+n(e,"special_price")).toFixed(2):t;$(".hero-right").find(".price-text").text("$"+n);const s=a&&a.map(t=>{t=t.file.split("/"),t=t[t.length-1].split(".");return`https://static.isafepal.com/mshop/dev/${t[0]}_new111.`+t[1]})||[];let r="";s.map(t=>{r+=`<div class="swiper-slide">
                    <img src="${t}" />
                </div>`}),$(".mySwiper2").find(".swiper-wrapper").empty(),$(".mySwiper").find(".swiper-wrapper").empty(),$(".mySwiper2").find(".swiper-wrapper").append(r),$(".mySwiper").find(".swiper-wrapper").append(r);var e=new Swiper(".mySwiper",{loop:!1,spaceBetween:10,slidesPerView:6,freeMode:!0,watchSlidesProgress:!0}),o=new Swiper(".mySwiper2",{loop:!0,autoplay:{delay:3e3,disableOnInteraction:!1},spaceBetween:10,pagination:{el:".mySwiper-mobile-pagination"},navigation:{nextEl:".swiper-button-next",prevEl:".swiper-button-prev"},thumbs:{swiper:e}});o.on("click",function(){$(document.body).fotoramaStart({index:o.activeIndex,list:s})}),$.ajaxPromise({type:"get",url:`https://api.yotpo.com/products/yRPkzI5kR3LmVNbdBaMXTbMfGkcDhjZ5D525b1f9/${i}/bottomline`,dataType:"json",contentType:"application/json;charset=utf-8",cache:!1,async:!0}).then(t=>{var{status:{code:t},response:e}=t;200===t?(c("#icon-evaluation",(t=e&&e.bottomline).average_score),$("#text-evaluation").html(+t.total_reviews+170)):(c("#icon-evaluation",5),$("#text-evaluation").html(271))})}).catch(t=>{t=t.status;401===t&&a()}).finally(()=>{$(document.body).myLoadingEnd()})}(e=e&&decodeURIComponent(e))?await i(e).then(()=>{$("document").myCart()}):a(),$("#qty-input").on("blur",function(){isNaN(parseInt($(this).val()))||""===$(this).val()||"0"===$(this).val()?$(this).val(1):$(this).val(parseInt($(this).val()))}),$(".shg-item").find(".collapse").on("hide.bs.collapse",t=>{t=t&&t.target,t=$(t).siblings(".shg-item-box").find(".icon-arrow");t.removeClass("arrow-up"),t.addClass("arrow-down"),t.attr("src","/assets/img/icon-arrow-down.svg")}),$(".shg-item").find(".collapse").on("show.bs.collapse",t=>{t=t&&t.target,$(".shg-item").map((t,e)=>{var a=$(e).find(".collapse"),a=($(a).removeClass("show"),$(e).find(".icon-arrow"));a.removeClass("arrow-up"),a.addClass("arrow-down"),a.attr("src","/assets/img/icon-arrow-down.svg")}),t=$(t).siblings(".shg-item-box").find(".icon-arrow");t.removeClass("arrow-down"),t.addClass("arrow-up"),t.attr("src","/assets/img/icon-arrow-up.svg")}),$.ajax({type:"get",url:base_url+"/getGroupProductList",dataType:"json",cache:!1,async:!0,success:function(t){let e="",a={"Expert's Choice":expert_choice||"Classic Bundle","Backup Package":backup_package||"Backup bundle","Hardcore Bundle":hardcore_bundle||"Holder's Bundle","Standard Package":standard_package||"Basic Bundle","Deluxe Bundle":deluxe_bundle||"Expert Bundle","Ultra-Deluxe Bundle":ultra_deluxe_bundle||"Utlimate Value Bundle"};t&&t.map(t=>{e+=`<div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 my-col">
                        <div class="wallet-item">
                            <div class="img">
                                <img class="img-fluid" src="https://static.isafepal.com/mshop/dev/${t.sku}V2.png" alt="" srcset="">
                            </div>
                            <div class="item-middle">
                                <div class="title d-flex justify-content-start align-items-center">
                                    <h3>${a[t.title1]||t.title1}</h3>
                                    <span style="${["Expert_choice"].includes(t.sku)?"":"display:none"}" class="more-popular">${most_popular}</span>
                                </div>
                                <div class="price-num d-flex justify-content-start align-items-center">
                                    ${t.zhe_point&&""+t.zhe_point!="0"?`<div class="d-flex justify-content-start align-items-center flex-column price">
                                                <p class="priceZhe"><span class="hasDiscount">$</span><span style="padding-left: 3px;">${t.zhe_price}</span></p>
                                                <p class="d-flex justify-content-start align-items-center zheTitle">
                                                    <span style="font-size: 12px;color:#C3BAE7;text-decoration: line-through;">$${t.price}</span>
                                                    <span class="zheInfo">-${t.zhe||t.zhe_title}</span>
                                                </p>
                                                
                                            </div>`:`<div class="d-flex justify-content-start align-items-center flex-column price">
                                                <p>$${t.price}</p>
                                            </div>`}
                                    <div class="input-num">
                                        <div id="minus">-</div>
                                        <input 
                                            type="text" 
                                            id="num-input-${t.sku}" 
                                            data-min="1"
                                            data-max="1000"
                                            data-default="1" value="1" class="position-relative qty-input" placeholder="">
                                        <div id="plus">+</div>
                                    </div>
                                </div>
                                <div class="free-shipping">
                                    <p>${["S1_Cypher","Expert_choice"].includes(t.sku)?free_shipping:""}</p>
                                </div>
                            </div>
                            <div class="add-cart">
                                <button item_sku="${t.sku}" item_input="num-input-${t.sku}" type="button" class="add-cart-btn-recommended btn-common my-btn my-btn-add btn-light-green">${add_to_cart||"ADD TO CART"}</button>
                            </div>
                        </div>
                    </div>`}),$("#recommended-row").html(e),$(".input-num").each((t,e)=>{var a={selectors:{addButtonSelector:"#plus",subtractButtonSelector:"#minus",inputSelector:"#"+$(e).find("input").attr("id")},settings:{checkValue:!0,isReadOnly:!1}};$(e).inputCounter(a)}),$(".qty-input").on("blur",function(){isNaN(parseInt($(this).val()))||""===$(this).val()||"0"===$(this).val()?$(this).val(1):$(this).val(parseInt($(this).val()))}),$(".add-cart-btn-recommended").on("click",function(){let t=this;var e=$(this).attr("item_input"),e={cartItem:{sku:$(this).attr("item_sku"),qty:$("#"+e).val()}};$(t).btnLoadingStart({text:adding||"Adding"}),$.addItemToCart(e).finally(()=>{$(t).btnLoadingEnd()})})}}),$("#add-cart").on("click",function(){let t=this;var e={cartItem:{sku:"LC",qty:$("#qty-input").val()}};$(t).btnLoadingStart({text:adding||"Adding"}),$.addItemToCart(e).finally(()=>{$(t).btnLoadingEnd()})}),$("#order-now").on("click",async()=>{var t={cartItem:{sku:"LC",qty:$("#qty-input").val()}};$(document.body).myLoadingStart(),$(this).btnLoadingStart({text:"Loading"}),await $.addItemToCart(t),window.sessionStorage.removeItem("bllingRadio"),window.location.href=url_lang?`/${url_lang}/checkout`:"/checkout",$(this).btnLoadingEnd(),$(document.body).myLoadingEnd()}),$("#my-comment").myComment({id:l||"2061"}),$(document.body).freeStart()}();