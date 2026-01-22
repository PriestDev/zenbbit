(function () {
    "use strict";
    $("#go_back_not_query").on("click", function() {
        onclickGoBack();
    });
    $("#m_go_back_not_query").on("click", function() {
        mOnclickGoBack();
    });
    function onclickGoBack() {
        $("#query_result_box").hide();
        $('.firmware-tips').hide();
        $("#search_sn_input").show();
        $("#go-back").hide();
    }
    function mOnclickGoBack() {
        $("#m-query_result_box").hide();
        $('.firmware-tips').hide();
        $("#m-search_sn_input").show();
        $("#m-go-back").hide();
        select('#hero').scrollIntoView({behavior: "smooth"})
    }
    $(".search-btn").on("click", function() {
        const that = this;
        $(that).btnLoadingStart({ text: 'Loading' })
        searchFn().finally(() => {
            $(that).btnLoadingEnd();
        });
    });
    // pc 监听enter事件
    if (!isMobile()) {
        $('.search-input').on('keydown', function(e) {
            if (event.keyCode == "13") {
                $(".search-btn").btnLoadingStart({ text: 'Loading' })
                searchFn().finally(() => {
                    $(".search-btn").btnLoadingEnd();
                });
            }
        });
        $('#formInput').on('submit', function(e){
            e.preventDefault();
        });
    }
    // 移动端from提交事件
    $('#mFormInput').on('submit', function(e) {
        e.preventDefault();
        searchFn();
    });
    function searchFn() {
        let sn = isMobile() ? $(".m-search-input").val() : $(".search-input").val();
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
                        $('#btn_goback').show();
                        $('.firmware-tips').show();
                        if (isMobile()) {
                            $('#m-go-back').addClass('d-flex');
                        } else {
                            $('#go-back').addClass('d-flex');
                            $("#go-back").show();
                        }
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
                        $('#m-go-back').hide();
                    }
                    if (isMobile()) {
                        $(".m-query_result_box_content").html('');
                        $('#btn_goback').show();
                        $(".m-query_result_box_content").append(html);
                        $("#m-search_sn_input").hide();
                        $("#m-query_result_box").show();
                        $('#btn_goback').on('click', function() {
                            mOnclickGoBack()
                        })

                    } else {
                        $(".query_result_box_content").html('');
                        $('#btn_goback').show();
                        $(".query_result_box_content").append(html);
                        $("#search_sn_input").hide();
                        $("#query_result_box").show();
                        $('#btn_goback').on('click', function() {
                            onclickGoBack()
                        })
                    }
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
        })
    }
    function languageList(list) {
        let result = '';
        list.map(item => {
            result += `<span class="language-item">${item}</span>`
        });
        return result;
    }
})()