/**
* Template Name: bootstrap - v5.1.3
* Author: bootstrap.com
* License: https://v5.bootcss.com/
*/
(function() {
    "use strict";
    /**
     * 
     * 
     */
    if (isMobile()) {
      new Swiper('.unlimited-assets-swiper', {
        speed: 400,
        loop: true,
        autoplay: {
          delay: 5000,
          disableOnInteraction: false
        },
        slidesPerView: 'auto',
        pagination: {
          el: '.unlimited-swiper-pagination'
        }
        // navigation: {
        //   nextEl: '.button-next',
        //   prevEl: '.button-prev',
        // },
      })
    }
    
    /**
     * coins --- slider ------------- start
     * 
    */
    const coinsTopSwiper = new Swiper('.coins-top-slider', {
      speed: 6000,
      loop: true,
      freeMode: true,
      allowTouchMove: false,
      autoplay: {
        delay: 0,
        disableOnInteraction: false,
        stopOnLastSlide: false,
        pauseOnMouseEnter: true,
      },
      slidesPerView: 'auto',
      loopFillGroupWithBlank: true,
      normalizeSlideIndex: true,
      breakpoints: {
        720: {
          slidesPerView: 4,
          spaceBetween: 90
        },
        992: {
          slidesPerView: 4,
          spaceBetween: 120
        },
        1200: {
          slidesPerView: 5,
          spaceBetween: 120
        },
        1440: {
          slidesPerView: 6,
          spaceBetween: 155
        },
        1920: {
          slidesPerView: 8,
          spaceBetween: 155
        }
      }
    });
    
    let nextTransForm = '', // 存放鼠标悬浮时的transform属性
    nextTransPosition = 0, // 轮播图原本应移动到的位置
    nowTransPosition = 0, // 鼠标悬浮时时轮播图位置
    nowTransForm = '', // 存放鼠标悬浮时轮播图的真实transform属性（非行内属性）
    nextTime = 0,
    sildeWidth = 0; //silde width
    coinsTopSwiper.el.onmouseover = function () {
      let vector = url_lang === 'ar' ? 1 : -1
      nextTransForm = $('#list-top-swiper-wrapper')[0].style.transform;
      nextTransPosition = vector * parseInt(nextTransForm.split('px')[0].split("translate3d(")[1]);
      nowTransForm = window.getComputedStyle($('#list-top-swiper-wrapper')[0], false)["transform"];
      nowTransPosition = vector * parseInt(window.getComputedStyle($('#list-top-swiper-wrapper')[0], false)["transform"].split("1,")[2].split(",")[0]);
      sildeWidth = $('#list-top-swiper-wrapper').find('.swiper-slide')[0].style.width.split('px')[0];
      // 计算轮播图从暂停位置移动到原本应到的位置所用的时间
      nextTime = 6000 * ((nextTransPosition - nowTransPosition) / sildeWidth);
      // 改变行内transform属性
      $('#list-top-swiper-wrapper')[0].style.transform = nowTransForm;
      $('#list-top-swiper-wrapper')[0].style.transitionDuration = "0ms";
      coinsTopSwiper.autoplay.stop();
    }
    coinsTopSwiper.el.onmouseout = function () {
      $('#list-top-swiper-wrapper')[0].style.transform = nextTransForm;
      $('#list-top-swiper-wrapper')[0].style.transitionDuration = `${nextTime}ms`;
      coinsTopSwiper.autoplay.start();
    }
    // bottom
    const coinsBottomSwiper = new Swiper('.coins-bottom-slider', {
      speed: 6000,
      loop: true,
      freeMode: true,
      allowTouchMove: false,
      autoplay: {
        delay: 0,
        disableOnInteraction: false,
        stopOnLastSlide: false,
        pauseOnMouseEnter: true,
        reverseDirection: false
      },
      slidesPerView: 'auto',
      loopFillGroupWithBlank: true,
      normalizeSlideIndex: true,
      breakpoints: {
        720: {
          slidesPerView: 4,
          spaceBetween: 90
        },
        992: {
          slidesPerView: 4,
          spaceBetween: 120
        },
        1200: {
          slidesPerView: 5,
          spaceBetween: 120
        },
        1440: {
          slidesPerView: 5,
          spaceBetween: 155
        },
        1920: {
          slidesPerView: 5,
          spaceBetween: 155
        }
      }
    });
    let nextTransFormB = '', // 存放鼠标悬浮时的transform属性
    nextTransPositionB = 0, // 轮播图原本应移动到的位置
    nowTransPositionB = 0, // 鼠标悬浮时时轮播图位置
    nowTransFormB = '', // 存放鼠标悬浮时轮播图的真实transform属性（非行内属性）
    nextTimeB = 0,
    sildeWidthB = 0; //silde width
    coinsBottomSwiper.el.onmouseover = function () {
      nextTransFormB = $('#list-bottom-swiper-wrapper')[0].style.transform;
      nextTransPositionB = -1 * parseInt(nextTransFormB.split('px')[0].split("translate3d(")[1]);
      nowTransFormB = window.getComputedStyle($('#list-bottom-swiper-wrapper')[0], false)["transform"];
      nowTransPositionB = -1 * parseInt(window.getComputedStyle($('#list-bottom-swiper-wrapper')[0], false)["transform"].split("1,")[2].split(",")[0]);
      sildeWidthB = $('#list-bottom-swiper-wrapper').find('.swiper-slide')[0].style.width.split('px')[0];
      // 计算轮播图从暂停位置移动到原本应到的位置所用的时间
      nextTimeB = Math.abs(6000 * ((nextTransPositionB - nowTransPositionB) / sildeWidthB));
      // 改变行内transform属性
      $('#list-bottom-swiper-wrapper')[0].style.transform = nowTransFormB;
      $('#list-bottom-swiper-wrapper')[0].style.transitionDuration = "0ms";
      coinsBottomSwiper.autoplay.stop();
    }
    coinsBottomSwiper.el.onmouseout = function () {
      $('#list-bottom-swiper-wrapper')[0].style.transform = nextTransFormB;
      $('#list-bottom-swiper-wrapper')[0].style.transitionDuration = `${nextTimeB}ms`;
      coinsBottomSwiper.autoplay.start();
    }
    /**
     * coins --- silder -------------- end
     * 
    */
  })()