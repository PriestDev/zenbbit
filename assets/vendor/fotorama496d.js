(function ($) {
    let oldValue = '';
    let fotorama = createE('div', ['fotorama']);
    fotorama.setAttribute('style', 'display: none');
    let fotoramaBox = createE('div', ['fotorama-box']);
    let mySwiperBig = createE('div', ['swiper', 'mySwiperBig']);
    mySwiperBig.setAttribute('style', '--swiper-navigation-color: #fff; --swiper-pagination-color: #fff');
    let swiperWrapperB = createE('div', ['swiper-wrapper']);
    let swiperWrapperL = createE('div', ['swiper-wrapper']);
    let buttonNext = createE('div', ['swiper-button-next']);
    let buttonPrev = createE('div', ['swiper-button-prev']);
    let mySwiperL = createE('div', ['swiper', 'mySwiperL', 'd-none', 'd-lg-block']);
    let pagination = createE('div', ['fotor-mobile-pagination', 'd-lg-none']);
    let close = createE('span', ['fotorama-close']);
    
    function createE (tab, cls = null, txt) {
        let t = document.createElement(tab)
        if (cls.length) {
          cls.forEach(v => t.classList.add(v))
        }
        if (txt) t.innerText = txt
        return t
    }
    $.fn.fotoramaStart = function({
        index = 0,
        list = [],
      }) {
        let that = this;
        var swiper2;
        if (list.length === 0) {
            return false;
        }
        let slide = '';
        list.map(item => {
            slide += `<div class="swiper-slide"><img src="${item.src || item}" onerror="handleImageError(this, '${item.err || item}')" /></div>`
        });
        // debugger
        
        if ($(that).is('body')) {
            $(fotorama).addClass('is-fullscreen')
        }
        if (!$(that).find('.fotorama').length) {

            $(swiperWrapperB).append(slide);
            $(swiperWrapperL).append(slide);
            mySwiperBig.appendChild(swiperWrapperB);
            mySwiperBig.appendChild(buttonNext);
            mySwiperBig.appendChild(buttonPrev);
            mySwiperL.appendChild(swiperWrapperL);

            fotoramaBox.appendChild(close);
            fotoramaBox.appendChild(mySwiperBig);
            fotoramaBox.appendChild(mySwiperL);
            fotoramaBox.appendChild(pagination);
            fotorama.appendChild(fotoramaBox);
            $(that).append($(fotorama));
            swiper2 = new Swiper('.mySwiperBig', {
                loop: false,
                autoplay: false,
                spaceBetween: 10,
                pagination: {
                    el: '.fotor-mobile-pagination'
                },
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
                thumbs: {
                    swiper: {
                        el: '.mySwiperL',
                        loop: false,
                        spaceBetween: 10,
                        slidesPerView: 6,
                        freeMode: true,
                        watchSlidesProgress: true,
                        watchSlidesVisibility: true,
                    }
                },
            });
            window.fotorSwiper = swiper2
        } else {
            $(that).find('.fotorama').attr('style', '')
        }
        
        $(close).on('click', function() {
            $(document.body).removeClass('overflow-hidden');
            $(fotorama).hide();
        });
        $(document.body).addClass('overflow-hidden');
        window.fotorSwiper.slideTo(index -1, 500, false)
        $(fotorama).show();
    }
})(jQuery)