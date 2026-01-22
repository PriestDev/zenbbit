(async function () {
    const keyWordArr = [
        { id: 'CN', keyword: ['china', 'mainland', 'mainland china', '中国', '中國', '中', 'zg', 'zhong guo', 'zhongguo'] },
        { id: 'HK', keyword: ['china', '中国', '中國', '中', 'zg', 'zhong guo', 'zhongguo', '香', '香港', '港' ,'hong kong', 'hongkong', 'hk', 'xiang', 'xianggang', 'xiang gang'] },
        { id: 'TW', keyword: ['china', '中国', '中國', '中', 'zg', 'zhong guo', 'zhongguo', '台', '台湾','湾', '灣', '台灣', 'taiwan', 'tai'] },
        { id: 'MO', keyword: ['china', '中国', '中國', '中', 'zg', 'zhong guo', 'zhongguo','澳', '澳门', '门', '澳門', '門', 'macau', 'ao men', 'aomen'] },
        { id: 'KR', keyword: ['대한민국'] },
        { id: 'JP', keyword: ['日本', '日'] },
        { id: 'FR', keyword: ['France','france'] },
        { id: 'DE', keyword: ['Deutschland', 'deutschland'] },
        { id: 'IT', keyword: ['Italia', 'italia'] },
        { id: 'ES', keyword: ['España', 'españa', 'Spain', 'spain'] },
        { id: 'TR', keyword: ['türkiye', 'turkey', 'Turkey'] },
        { id: 'RU', keyword: ['Россия', 'Russia', 'russia'] },
        { id: 'TH', keyword: ['ประเทศไทย'] },
        { id: 'VN', keyword: ['Việt Nam'] },
    ]; 
    let token = $.cookie('token');
    let countriesB = window.sessionStorage.getItem('directory-data-j') ? JSON.parse(window.sessionStorage.getItem('directory-data-j')) : [];
    if (Object.prototype.toString.call(countriesB) === '[object Array]') {
        countriesB.map(item => {
            keyWordArr.map(k => {
                if (item.id === k.id) {
                    item['keyword'] = k['keyword'];
                }
            });
        });
    }
    let countryPicker = {};
    let positionPicker = {};
    let uploadFileStatus = false;
    let uploadFile = null;
    let uploadErrFile = null;
    let workRadioValue = '';
    function getAccessToken() {
        return $.ajaxPromise({
            type: "get", // 请求类型
            url: `${base_url}/getAccessToken`, // 请求URL
            dataType: "json", // 数据返回类型
            cache: false, // 是否缓存
            async: true, // 默认为true 异步请求
        });
    };
    if (!token) {
        loading = true;
        await getAccessToken().then(async res => {
            token = res.replace(/\"/g, "");
            $.cookie('token', token, { expires: 1, path: '/' })
        });
    }
    $('.life-safepal').find('.left-item').each((i, k) => {
        $(k).hover(function() {
            $(k).siblings().removeClass('active');
            $(k).addClass('active');
            $('.right.img-box').find('img').each((index,item) => {
                $(item).addClass('d-none');
                if ($(item).data('name') === $(k).data('name')) {
                    $(item).removeClass('d-none')
                }
            })
        });
    });
    $('.profile').on('click', function(e) {
        let tar1 = getEventTarget(e, '.button-apply');
        if (!tar1) {
            $(this).toggleClass('actived');
            $(this).find('.button-details').text($(this).hasClass('actived') ? pack_up || 'Pack up' : details || 'Details')
            $(this).siblings('.details').animate({height:'toggle'},300);

        }
    });
    $('.m-profile').on('click', function(e) {
        let tar1 = getEventTarget(e, '.button-details');
        if (tar1) {
            if (tar1.classList.contains("show")) {
                tar1.classList.remove('show');
                tar1.innerHTML =  details || 'Details';
            } else {
                tar1.classList.add('show');
                tar1.innerHTML = pack_up || 'Pack up';
            }
            $(this).siblings('.details').animate({height:'toggle'},300);
        }
    });
    // life-safepal-m swiper
    new Swiper("#life-safepal-m", {
        speed: 500,
        loop: true,
        autoplay: {
            delay: 3000,
            disableOnInteraction: false
        },
        slidesPerView: 'auto',
        pagination: {
            el: '.swiper-mobile-pagination'
        },
        breakpoints: {
            320: {
            slidesPerView: 1,
            spaceBetween: 30
            },
            480: {
            slidesPerView: 1,
            spaceBetween: 30
            },
            640: {
            slidesPerView: 1,
            spaceBetween: 30
            },
            720: {
            slidesPerView: 1,
            spaceBetween: 30
            },
            992: {
            slidesPerView: 1,
            spaceBetween: 30
            }
        }
    });
    // click apply button show apply dialog
    $('.button-apply[type="button"]').on('click', function() {
        let id = $(this).attr('name');
        console.log(id, "this")
        if ((countriesB&&countriesB.length) === 0) {
            $(document.body).myLoadingStart();
            getCountriesB().finally(() => {
                $(document.body).myLoadingEnd();
            });
        } else {
            countrySelect(countriesB)
        }
        positionSelect(position_list, id)
        $('#apply-dialog').addClass('show');
        $(document.body).addClass('overflow-hidden');
        // click other to hidden apply dialog
        $('#apply-dialog').off('click');
        $('#apply-dialog').on('click', function(e) {
            let tar1 = getEventTarget(e, '.apply-box-close');
            if (tar1) { 
                $('#apply-dialog').removeClass('show');
                $(document.body).removeClass('overflow-hidden');
                resetFn();
            }
        });
    });
    // select position
    function positionSelect(list, currentId) {
        $('#position-select').mySelect({
            mark: 'position',
            require: true,
            // #div为容器
            id: 'id', // 唯一标识
            currentId: currentId || null, // 当前选择的数据
            arr: list, // 数据源
            label: 'title', // input展示数据
            showSearch: false,
            callback: function(val) {
                if (val.id === positionPicker.id) { return false }
                positionPicker = Object.assign({}, val);
                // 
                $('#position-select').find('#input-select-position').removeClass('required_error');
                $('#position-select').siblings('.require-tips').hide();
                
            }, // 回调函数
            liRow: [
                '<div class="li-box f-flex justify-content-between align-items-center"><div class="item-text"><p>{{ title }}</p></div><div class="item-select"><svg width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="12.4395" cy="12" r="12" fill="#4A21EF"/><path fill-rule="evenodd" clip-rule="evenodd" d="M6.51367 12.033L7.43616 11.0165L10.9486 13.6822L17.6363 7.17725L18.3647 7.56332L11.1701 16.8231L6.51367 12.033Z" fill="white"/></div></div>'
            ], // 自定义下拉列表（可以不传）
            searchList: null, // 模糊查询字段列表
            loadEle: function(val) {
                let { currentId, load } = val
                if (load) {
                    
                    $('#input-placeholder-position').hide();
                    let index = list.findIndex(item => item.id === currentId);
                    if (index > -1) {
                        positionPicker = Object.assign({}, list[index]);
                    }
                }
            }
        });
    }
    // get country 
    function getCountriesB() {
        return $.ajaxPromise({
            type: "get", // 请求类型
            url: `${base_url}/getCountries?all=all`, // 请求URL
            beforeSend: function(xhr) {
                xhr.setRequestHeader('Authorization', `Bearer ${token}`);
            },
            dataType: "json", // 数据返回类型
            cache: false, // 是否缓存
            async: true, // 默认为true 异步请求
        }).then(result => {
            try {
                if (Object.prototype.toString.call(result) === '[object String]') {
                    window.sessionStorage.setItem('directory-data-j', result)
                    result = JSON.parse(result);
                } else {
                    window.sessionStorage.setItem('directory-data-j', JSON.stringify(result))
                }
                if (result&&result.length) {
                    result.map(item => {
                        keyWordArr.map(k => {
                            if (item.id === k.id) {
                                item['keyword'] = k['keyword'];
                            }
                        });
                    });
                    countriesB = result;
                    countrySelect(countriesB);
                }
            } catch (error) {
                console.log(error) 
            }
            return result
        });
    }
    // select country
    function countrySelect(list) {
        $('#country-select').mySelect({
            mark: 'country',
            require: true,
            // #div为容器
            id: 'id', // 唯一标识
            currentId: null, // 当前选择的数据
            arr: list.filter(item => item['full_name_locale']), // 数据源
            label: 'full_name_locale', // input展示数据
            callback: function(val) {
                if (val.id === countryPicker.id) { return false }
                countryPicker = Object.assign({}, val);
                // 
                $('#country-select').find('#input-select-country').removeClass('required_error');
                $('#country-select').siblings('.require-tips').hide();
                
            }, // 回调函数
            liRow: [
                '<div class="li-box f-flex justify-content-between align-items-center"><div class="flag-img"><img src={{ img }} onerror="$.flagError()" /></div><div class="item-text"><p>{{ full_name_locale }}</p></div><div class="item-select"><svg width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="12.4395" cy="12" r="12" fill="#4A21EF"/><path fill-rule="evenodd" clip-rule="evenodd" d="M6.51367 12.033L7.43616 11.0165L10.9486 13.6822L17.6363 7.17725L18.3647 7.56332L11.1701 16.8231L6.51367 12.033Z" fill="white"/></div></div>'
            ], // 自定义下拉列表（可以不传）
            searchList: ['full_name_locale', 'full_name_english', 'keyword'], // 模糊查询字段列表
            loadEle: function(val) {
                let { currentId, load } = val
                if (load) {
                    $('#input-placeholder').hide();
                }
            }
        });
    }
    function verifyInput(that) {
        let id = $(that).attr('id');
        let Value = $(that).val();
        if (!Value) { return false }
        switch(id) {
            case 'apply-email':
                let regEmail = new RegExp(/[a-zA-Z0-9]+([-_.][A-Za-zd]+)*@([a-zA-Z0-9]+[-.])+[A-Za-zd]{2,20}$/);
                if(regEmail.test(Value)) {
                    $(that).parent().siblings('.error-tips').hide();
                    $(that).removeClass('required_error');
                } else {
                    $(that).parent().siblings('.error-tips').show();
                    $(that).addClass('required_error');
                }
            break;
            case 'apply-name':
                if ((Value&&Value.length) > 20) {
                    $(that).addClass('required_error')
                    $(that).parent().siblings('.error-tips').show();
                    $(that).parent().siblings('.require-tips').hide();
                } else {
                    $(that).removeClass('required_error')
                    $(that).parent().siblings('.error-tips').hide();
                }
            break;
            case 'apply-linkedin':
                if ((Value&&Value.length) > 70) {
                    $(that).parent().siblings('.error-tips').show();
                } else {
                    $(that).parent().siblings('.error-tips').hide();
                }
            break;
            case 'apply-phone':
                let flag = false;
                let reg = new RegExp(/^[0-9 +-]+$/);
                let regCn = new RegExp(/(^(0[0-9]{2,3}\-)?([2-9][0-9]{6,7})+(\-[0-9]{1,4})?$)|(^((\(\d{3}\))|(\d{3}\-))?(1[35789]\d{9})$)|(^86((\(\d{3}\))|(\d{3}\-))?(1[35789]\d{9})$)|(^\+86((\(\d{3}\))|(\d{3}\-))?(1[35789]\d{9})$)/)
                if (countryPicker.id === 'CN') {
                    flag = !regCn.test(Value) && Value
                } else {
                    flag = !reg.test(Value) && Value;
                }
                if (flag) { 
                    $(that).addClass('required_error');
                    $(that).parent().siblings('.require-tips').hide();
                    $(that).parent().siblings('.error-tips').show();
                } else {
                    $(that).removeClass('required_error');
                    $(that).parent().siblings('.require-tips').hide();
                    $(that).parent().siblings('.error-tips').hide();
                }
            break;
            case 'tell-us-about':
                if ((Value&&getPhpStrLen(Value)) > 512) {
                    $(that).addClass('has_error');
                    $(that).parent().siblings('.error-tips').show();
                } else {
                    $(that).removeClass('has_error');
                    $(that).parent().siblings('.error-tips').hide();
                }
            break;
        }
    }

    function getPhpStrLen(str){
        let realLength = 0, len = str.length, charCode = -1;
        for(let i = 0; i < len; i++){
            charCode = str.charCodeAt(i);
            if(charCode >= 0 && charCode <= 128)
                realLength += 1;
            else
                realLength += 3;
        }
        return realLength;
    }

    $('.form-input').on('input', function() {
        const that = this;
        let id = $(that).attr('id');
        let Value = $(that).val()
        if ($(that).data('require') === true && Value) {
            $(that).removeClass('required_error');
            $(that).parent().siblings('.require-tips').hide();
        } else if ($(that).data('require') === true && !Value) {
            if (!Boolean($(that).attr('readonly'))) {
                $(that).addClass('required_error');
                $(that).parent().siblings('.error-tips').hide();
                $(that).parent().siblings('.require-tips').show();
                $(that).parent().siblings('.error-tips-cn').hide();
            };
            return false
        }
        verifyInput(that);
    });
    $('.form-input').on('blur', function() {
        const that = this;
        const Value = $(that).val();
        let id = $(that).attr('id');
        if (!$(that).val()) {
            return
        }
        let matchArr = Value.match(/<script[^>]*>([^<]|<(?!\/script))*<\/script>/gmi)
        if (matchArr&&matchArr.length) {
            matchArr.map(item => {
                $(that).val(Value.replace(item, ""));
            });
            return false;
        }
        switch(id) {
            case 'email-address':
                let reg = new RegExp(/[a-zA-Z0-9]+([-_.][A-Za-zd]+)*@([a-zA-Z0-9]+[-.])+[A-Za-zd]{2,20}$/)
                if(reg.test(Value)) {
                    $(that).parent().siblings('.error-tips').hide();
                    $(that).removeClass('required_error');
                } else {
                    $(that).parent().siblings('.error-tips').show();
                    $(that).addClass('required_error');
                }
            break;
        }
    });
    $("input[name='longwork'].form-check-input").on('change', function() {
        if ($(this).prop('checked')) {
            $('.require-tips-radio-work').hide();
        }
    });
    function getRadioCheckedValue(target) {
        let result = '';
        if (!target) { return '' }
        target.map((index,item) => {
            if ($(item).prop('checked')) {
                result = $(item).val();
            }
        });
        return result;
    }
    // 文件上传
    const myDropzone = new Dropzone("#my-dropzone", { 
        url: "/joinus/save",
        addRemoveLinks: true,
        dictRemoveLinks: "",
        dictCancelUpload: "",
        dictRemoveFile: remove || "Remove",
        maxFiles: 1,
        maxFilesize: 50,
        acceptedFiles: ".doc,.docx,.pdf",
        previewsContainer: select('.my-dropzone-previews'),
        autoQueue: true,
        autoProcessQueue:false,
        maxFilesize: 5,
        dictFileTooBig: fileTooBigTips || "File is too big ({{filesize}}MiB). Max filesize: {{maxFilesize}}MiB.",
        dictInvalidFileType: fileSupportText || "You can't upload files of this type.",
        init: function() {
            this.on('addedfile', function(file) {
                while (this.files.length > this.options.maxFiles) {
                    this.removeFile(this.files[0]);
                }
                uploadFile = file;
                uploadErrFile = null;
                $('.require-tips-upload').hide();
                $('.my-dropzone-previews').find('.dz-progress').hide()
            });
            this.on('success', function(file, response) {
                console.log(response, 'response')
                console.log(file.status, 'file.status')
                let {code, message, msg} = response;
                $(document.body).myLoadingEnd();
                $('#btn-submit').text(submitText || 'Submit');
                if (code === 0) {
                    $('.require-tips-upload').hide();
                    uploadFile = file;
                    uploadFileStatus = true;
                    resetFn();
                    $('#apply-dialog').removeClass('show');
                    $('#apply-success-dialog').addClass('show');
                    $(document.body).addClass('overflow-hidden');
                } else if(code === 1) {
                    $(document).dialog({
                        type: 'confirm',
                        titleShow: false,
                        bodyNoScroll: true,
                        dialogClass: 'dialog-cart-empty',
                        content: have_received_your_submitted || 'We have received your CV submitted for this position before. Please wait patiently for our reply and do not submit repeatedly. Thank you!',
                        buttons: [ { class: 'cart-empty', name: $Ok in window ? $Ok : 'OK', callback: () => { 
                            resetFn();
                            $('#apply-dialog').removeClass('show'); } } ]
                    });
                    
                } else {
                    $(document).dialog({
                        type: 'confirm',
                        titleShow: false,
                        bodyNoScroll: true,
                        dialogClass: 'dialog-cart-empty',
                        content: message || msg,
                        buttons: [ { class: 'cart-empty', name: $Ok || 'OK', callback: () => {  } } ]
                    });
                }
            });
            this.on('removedfile', function() {
                $('.require-tips-upload').hide();
                uploadFile = null;
                uploadFileStatus = false;
            });
            this.on('error', (file, message, xhr) => {
                $('.require-tips-upload').hide();
                uploadFileStatus = false;
                uploadErrFile = file;
                $(document.body).myLoadingEnd();
                $('#btn-submit').text(submitText || 'Submit')
                if (xhr == null && !file) {
                    this.removeFile(file);
                    $(document).dialog({
                        type: 'confirm',
                        titleShow: false,
                        bodyNoScroll: true,
                        dialogClass: 'dialog-cart-empty',
                        content:  file_support || 'The file should be in doc., docx. or pdf format.',
                        buttons: [ { class: 'cart-empty', name: $Ok in window ? $Ok : 'OK', callback: () => { } } ]
                    });
                }
            });
            this.on("sending", function(file, xhr, formData){
                formData.append("name", $('#apply-name').val());
                formData.append("job_name", positionPicker['title']);
                formData.append("email", $('#apply-email').val().trim());
                formData.append("current", countryPicker['full_name_locale']);
                formData.append("position", positionPicker['id']);
                formData.append("phone", $('#apply-phone').val());
                formData.append("linkedIn", $('#apply-linkedin').val());
                formData.append("worked_in_web3", workRadioValue);
                formData.append("about", $('#tell-us-about').val());
                $('.my-dropzone-previews').find('.dz-progress').show();
                $('#btn-submit').text(submittingText || 'Submitting')
                $(document.body).myLoadingStart();
            });
        }
    });
    function resetFn() {
        uploadFile = null;
        uploadErrFile = null;
        uploadFileStatus = false;
        myDropzone.removeAllFiles();
        let inputList = $('.form-input');
        console.log(inputList, 'inputList')
        inputList.map((index, item) => {
            $(item).val('');
            $(item).removeClass('required_error');
            $(item).parent().siblings('.require-tips').length
                ? $(item).parent().siblings('.require-tips').hide() 
                : $(item).parent().parent().siblings('.require-tips').hide();
            $(item).parent().siblings('.error-tips').length
                ? $(item).parent().siblings('.error-tips').hide() 
                : $(item).parent().parent().siblings('.error-tips').hide();
        });
        $('input[name="longwork"].form-check-input').map((index,item) => {
            $(item).prop('checked', false)
        });
        $('.require-tips-radio-work').hide();
        $('.require-tips-upload').hide();
        countryPicker = {};
        positionPicker = {};
        workRadioValue = '';
        countrySelect(countriesB);
        positionSelect(position_list)
    }
    $('#btn-submit').on('click', async function() {
        let flagObj = {};
        let inputList = $('.form-input:visible');
        inputList.map((index, item) => {
            if (Boolean($(item).data('require'))&& !$(item).val()) {
                $(item).addClass('required_error')
                $(item).parent().siblings('.require-tips').length
                    ? $(item).parent().siblings('.require-tips').show() 
                    : $(item).parent().parent().siblings('.require-tips').show();
                flagObj[$(item).attr('id')] = true;
            }
            if ($(item).hasClass('required_error')) {
                flagObj[$(item).attr('id')] = true;
            }
        });
        workRadioValue = getRadioCheckedValue($('input[name="longwork"].form-check-input'))
        if (!workRadioValue) {
            $('.require-tips-radio-work').show();
            flagObj['radios-work'] = true
        }
        let tellUsAbout = $('#tell-us-about').hasClass('has_error');
        if (tellUsAbout) {
            flagObj['tell-us-about'] = true
            return false;
        }
        if (!uploadFile) {
            $('.require-tips-upload').show();
            flagObj['my-dropzone'] = true
        } else {
            $('.require-tips-upload').hide();
        }
        let flag = function() {
            return Object.values(flagObj).some(item => item === true);
        };
        if (flag()) { 
            select(`#${Object.keys(flagObj)[0]}`).scrollIntoView({
                behavior: 'smooth',
                block: "center", inline: "nearest"
            }); 
            return false; 
        }
        myDropzone.processQueue();

    });
    $('.btn-ok').on('click', function() {
        $('#apply-success-dialog').removeClass('show');
        $(document.body).removeClass('overflow-hidden');
    });
    $('.see-roles-btn').on('click', function() {
        if (isMobile()) {
            $('html, body').animate({
            scrollTop: $('.current-opportunities').offset().top -80 }, 300);
        } else {
            select('.current-opportunities').scrollIntoView({
                behavior: 'smooth',
                block: "center", inline: "nearest"
            });
        }
    });
    function isIos() {
        return /(iPhone|iPad|iPod|iOS)/i.test(navigator.userAgent);
    }
    function getElementTop(parent, sub) {
        const parentClient = parent.getBoundingClientRect();
        const subClient = sub.getBoundingClientRect();
        return parseInt(subClient.top - parentClient.top)
    }
    if (isMobile()) {
        $('.form-input').on('focus', function() {
            const that = this;
            setTimeout(() => {
                $('#form-apply').animate({
                    scrollTop: getElementTop($('.apply-box-content-box')[0], $(that)[0]) - 80 }, 300);
                }, 100)
        });
        if (isIos()) {
            // $('#my-dropzone').on('touchstart', function(event) {
            //     event.preventDefault();
            //     $(".dz-clickable").trigger('click');
            // });
            // $('#my-dropzone').on('click', function(event) {
            //     event.preventDefault();
            //     $(".dz-clickable").trigger('click');
            // });

            // var dz = $(".dz-hidden-input").detach();
            // $(dz).css({
            //     'position':'relative',
            //     'visibility':'visible'
            // });
            // $("#main.joinus").prepend(dz);
        }
    }
})()