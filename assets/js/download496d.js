(function () {
    "use strict";
    // 获取url
    function getQuery(name) {
        let reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i");
        let r = window.location.search.substr(1).match(reg);
        return r != null ? decodeURI(r[2]) : null;
    }
    let product = getQuery('product');
    if(product) {
        $('#myTab li').find('button').removeClass('active');
        $('#myTab li').find('button').attr('aria-selected', false);
        $('#myTabContent').find('.tab-pane').removeClass('active');
        $('#myTabContent').find('.tab-pane').removeClass('show');
        if (isNaN(product)) {
            let index = 0;
            $('#myTab li').find('button').map((i, item) => {
                if ($(item).attr('target') === product) {
                    index = i
                }
            });
            if (index > -1) {
                $($('#myTabContent').find('.tab-pane')[index]).addClass('active');
                $($('#myTabContent').find('.tab-pane')[index]).addClass('show');
                $($('#myTab li')[index]).find('button').addClass('active');
                $($('#myTab li')[index]).find('button').attr('aria-selected', true);
            }
        } else {
            $($('#myTabContent').find('.tab-pane')[product - 1]).addClass('active');
            $($('#myTabContent').find('.tab-pane')[product - 1]).addClass('show');
            $($('#myTab li')[product - 1]).find('button').addClass('active');
            $($('#myTab li')[product - 1]).find('button').attr('aria-selected', true);
        }
        
    }
    $("#btn_goback").on("click", function() {
        onClickGoBack()   
    });
    function onClickGoBack() {
        $('.firmware-tips').hide();
        $("#query_result_box").hide();
        $("#search_sn_input").show();
        $("#how_to_check_device").show();
        $("#btn_goback").hide();
        if (isMobile()) {
            select('#myTabContent').scrollIntoView({behavior: "smooth"});
        }
    }
    // 搜索框按钮点击事件
    $(".search-btn").on("click", function() {
        const that = this;
        $(that).btnLoadingStart({ text: 'Loading' })
        searchFn().finally(() => {
            $(that).btnLoadingEnd();
        });
    });
    // pc 监听enter事件
    if (!isMobile()) {
        $('#snInput').on('keydown', function(e) {
            if (event.keyCode == "13") {
                $(".search-btn").btnLoadingStart({ text: 'Loading' })
                searchFn().finally(() => {
                    $(".search-btn").btnLoadingEnd();
                });
            }
        })
    }
    // 移动端from提交事件
    $('#form-input').on('submit', function(e) {
        e.preventDefault();
        searchFn();
    })
    function searchFn() {
        let sn = $(".search-input").val();
        if (sn.trim() === '') { return new Promise((reject) => {
            reject()
        }) }
        return $.ajaxPromise({
            type: "post", // 请求类型
            url: "/upgrade/getfirmware", // 请求URL
            data: {
                "sn": sn.trim()
            }, // 请求参数 即是 在Servlet中 request.getParement();可以得到的字符串
            dataType: "json", // 数据返回类型
        }).then(result => {
            if (result.code === 0) {
                let { info } = result.data[0];
                try {
                    let html = '';
                    if (info&&info.length > 1) {
                        info.map((item, index) => {
                            html += `<div class="query-item d-flex justify-content-between align-items-start flex-column">
                                <div>
                                    <h3 class="title">${firmware_text || 'Firmware'} ${info&&info.length > 1 ? ['A', 'B', 'C', 'D'][index] : ''}</h3>
                                    <div class="supported-language" style="${item.language&&item.language.length ? '' : 'display:none'}">
                                        <p class="title">${supported_languages || 'Supported Languages'}:</p>
                                        <div class="language-box d-flex justify-content-start align-items-center flex-wrap">
                                            ${languageList(item.language)}
                                        </div>
                                    </div>
                                    <div class="sha256">
                                        <p>SHA256:</p>
                                        <p style="word-break: break-all;text-align: lefet;">${item.sha256}</p>
                                    </div>
                                </div>
                                <div class="download">
                                    <button class="btn_download btn-light-green">
                                        <a href="${item.path}">${downloadText}</a>
                                    </button>
                                </div>
                            </div>`; 
                        });
                        $("#btn_goback[data-button=two]").show();
                        $('.firmware-tips').show();
                    } else {
                        info.map(item => {
                            html+=`<div>
                            <div class="sha256">
                            <p style="word-break: break-all;text-align: center;">SHA256:${item.sha256}</p>
                        </div>
                        <div class="btn_wrap">
                            <button style="margin-right: 10px;" class="btn_white btn_normal transparent-light-green" id="btn_goback">${GOBACK}</button>
                            <a class="a_download" style="margin-left: 10px;" href="${item.path}">
                                <button class="btn_normal download btn-light-green">${downloadText}</button>
                            </a>
                        </div>
                            </div>`
                        })
                    }
                    $(".query_result_box_content").html('');
                    $(".query_result_box_content").append(html);
                    $("#query_result_box").show();
                    $("#search_sn_input").hide();
                    $("#btn_goback").on("click", function() {
                        onClickGoBack()
                    });
                } catch (error) {
                    $(document).dialog({
                        titleShow: false,
                        content: 'error',
                    });
                }
                
            } else {
                let {code, msg} = result;
                $(document).dialog({
                    titleShow: false,
                    content: code === -1 ? $please_enter_correct_sn || msg : msg,
                });
            }
        });
    };
    function languageList(list) {
        let result = '';
        list.map(item => {
            result += `<span class="language-item">${item}</span>`
        });
        return result;
    }
})();