(function () {
    "use strict";
    $.fn.selectpicker.Constructor.BootstrapVersion = '5';
    let liIndex = -1
    let oldVal = ''
    let loading = false
    let page = 1
    let total = 0
    let isMore = true
    let baseUrl = 'https://www.safepal.com';
    let timer = null;
    let $table = $('.accepts-table');
    // 搜索框内容
    $('.dowBox').on('click', '.liItem', (e) => {
        $("#search-input").val(e.target.innerHTML)
        setTimeout(() => {
            getList()
        }, 300);
    })
    $("#search-input").on('keypress', function (e) {
        if (event.keyCode === 13) {
            if ($("#search-input").val().trim('') === '') { return }
            $('.dowBox').hide()
            $("#search-input").blur()
            getList()
        }
    })
    // 
    $('#fromInput').on('submit', function(e){
        e.preventDefault();
    });
    let cpLock = true;
    $('#search-input').on('compositionstart', function () {
        cpLock = false;
    });
    $('#search-input').on('compositionend', function () {
        cpLock = true;
    });
    $('#search-input').on('blur', function () {
        setTimeout(() => {
            $('.dowBox').hide()
        }, 200);
    });
    $('#search-input').on('focus', function () {
        if($("#search-input").val().trim('') && $('#dowBox > li').length) {
            $('.dowBox').show()
        }
    });
    $("#search-input").on('input', throttle(searchInput, 500, 800));
    function searchInput(e) {
        e.preventDefault();
        clearTimeout(timer)
        timer = setTimeout(function () {
            if (cpLock) {
                let searchValue = $("#search-input").val().trim('');
                if (!searchValue) {
                    $('.dowBox').hide()
                    $('.dowBox').html('')
                    getList()
                } else {
                    oldVal = searchValue
                    let liItem = ''
                    // 
                    $.post(`/coin/simple_search/?prefix=${searchValue}`, (res) => {
                        res.data.forEach((v,index) => {
                            liItem += `<li id="liItem${index}" class="liItem">${v}</li>`
                        });
                        $('.dowBox').html(liItem)
                        liIndex = -1;
                        if (res.data && res.data.length) {
                            $('.dowBox').show()
                        } else {
                            $('.dowBox').hide();
                        }
                    }, "json")
                }
            }
        }, 0)
    }
    $("#search_coin_button").on("click", function () {
        getList()
    });
    $("#typeSelect").on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
        getList()
    }); 
    $("#networkSelectBox").on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
        getList()
    }); 
    $("#buySelect").on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
        getList()
    }); 
    $("#swapSelect").on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
        getList()
    }); 
    $("#walletSelect").on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
        getList()
    }); 
    // m端触发
    $("#mtypeSelect").on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
        getList()
    }); 
    $("#networkSelectBoxm").on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
        getList()
    }); 
    async function getList(isLoadMore) {
        // 如果不是加载其他搜索直接清空表格
        if (!isLoadMore) {
            $('.tdBox').remove();
            $('.m-list-item').remove();
            $table.bootstrapTable('destroy');
            page = 1
        } else {
            page++;
        }
        let reqData = {
            page,
            coin_name: $("#search-input").val().trim(''),
            type:  isMobile() ? $("#networkSelectBoxm").val() : $("#networkSelectBox").val(),
            s_swap: isMobile() ? $('input[name="swapRadio"]:checked').val() : $("#swapSelect").val(),
            s_coin: isMobile() ? $("#mtypeSelect").val() : $("#typeSelect").val(),
            s_simplex: isMobile() ? $('input[name="buyRadio"]:checked').val() : $("#buySelect").val(),
            supported: isMobile() ? $('input[name="walletRadio"]:checked').val() : $('#walletSelect').val()
        }
        if (!loading) {
            loading = true
            $(document.body).myLoadingStart();
            let resData = await $.ajax({ url: `/coin/lists_json`, 
                type: 'POST', 
                data: reqData, 
                contentType: "application/x-www-form-urlencoded",
                async: false, 
                dataType: 'json',
                error: function() {
                    $(document.body).myLoadingEnd();
                    loading = false;
                },

            });
            $(document.body).myLoadingEnd();  
            initTable(resData.data)
            loading = false
        }
    }
    // --------- table ----------
    
    function initTable(datas) {
        const { list, total, totalPage } = datas;
        // mobile
        $('.m-list-box').html('')
        let mList = '';
        list.map(item => {
            mList += `<div class="m-list-item">
                <div class="name-type-network d-flex justify-content-between align-items-center">
                    <div class="name d-flex justify-content-start align-items-center">
                        <div class="coin-log">
                        <img class="table-icon" onerror="var img = event.srcElement;
                        img.src = "/new_v2/icon_svg/err.jpg";
                        img.οnerrοr = null;" src="${item.coin_img_url}" />
                        </div>
                        <div><a href="${item.explorer_url}" target="_blank" rel="noopener noreferrer">${item.name}(${item.symbol})</a></div>
                    </div>
                    <div class="type">${item.s_coin? 'Coin' : 'Token'}</div>
                    <div class="network">${item.type_name}</div>
                </div>
                <div class="filter d-flex justify-content-satart align-items-center">
                    <div class="filter-item buy">
                        <span>${$buy_text || 'Buy' }</span>
                        <span><img src="${item.s_simplex ? '/assets/img/assets/table-swap-checked.svg' : '/assets/img/assets/table-swap-not-checked.svg'}" alt=""></span>
                    </div>
                    <div class="filter-item swap">
                        <span>${$swap_text || 'Swap'}</span>
                        <span><img src="${ item.s_swap ? '/assets/img/assets/table-swap-checked.svg': '/assets/img/assets/table-swap-not-checked.svg'}" /></span>
                    </div>
                    <div class="filter-item wallet">
                        <p class="text">${$supported_wallet || 'Supported Wallet'}</p>
                        <div>${supportedHtml(item.supported, item.type)}</div>
                    </div>
                </div>
            </div>`
        })
        $('.m-list-box').append(mList);
        // pc
        // 先销毁再创建
        $table.bootstrapTable({
            // data: list, // table - data
            locale: 'en',// language
            classes: 'table table-no-border table-hover', // 样式，table-striped 隔行变色
            rowStyle: function() {
                return { classes: 'tdBox' } 
            },
            onPostBody: function() {
                // 表格渲染完成后绑定 Tooltip
                $('.supportedIcon[data-toggle="tooltip"]').tooltip({
                  delay: {
                    show: 100,  // 显示延迟
                    hide: 100   // 隐藏延迟
                  },
                  trigger: 'hover', // 触发方式
                });
                $('.tipsIcon[data-toggle="tooltip"]').tooltip({
                    trigger: 'click', // 触发方式
                    html: true,
                    sanitize: false,
                    placement: 'top'
                });
                document.addEventListener('click', function(e) {
                    let tar1 = getEventTarget(e, '.s1Tooltip');
                    let tar2 = getEventTarget(e, '.tipsIcon');
                    if (!tar1 && !tar2) { 
                        $('.tipsIcon[data-toggle="tooltip"]').tooltip('hide');
                    }
                });
                $('.tipsIcon').on('show.bs.tooltip', function () {
                    const $this = $(this)
                    $('.tipsIcon').not($this).tooltip('hide');
                })                  
              },
            columns: [ // 列详情
                {
                    title: `${$name_text || 'Name'}`,
                    field: 'name',
                    align: 'left',
                    formatter: function (value, row, index) { // 处理该行数据
                        return `<div class="d-flex justify-content-start align-items-center">
                            <span style="margin-right:10px;">
                                <img class="table-icon" onerror="var img = event.srcElement;
                                img.src = "/new_v2/icon_svg/err.jpg";
                                img.οnerrοr = null;" src="${row.coin_img_url}" />
                            </span>
                            <span class="table-text">
                                <a href="${row.explorer_url}" target="_blank" rel="noopener noreferrer">${value}(${row.symbol})</a>
                            </span>
                        </div>`
                    }
                }, 
                {
                    title: `${ $type_text || Type }`,// 表头字段名
                    field: 's_coin',// 数据 key
                    align: 'center',// 居中
                    formatter: function(value) {
                        return value ? 'Coin' : 'Token'
                    }
                }, 
                {
                    title: `${$network_text || 'Network'}`,
                    field: 'type_name',
                    align: 'center'
                }, 
                // {
                //     title: `${$buy_text || 'Buy'}`,
                //     field: 'fiat',
                //     align: 'center',
                //     formatter: function(value) {
                //         let html = '';
                //         value.map(item => {
                //             html+= `<span data-toggle="tooltip" data-placement="top" title="${item === 'bifinity' ? 'Binance Connect' : 'Simplex'}" style="display: inline-block;">
                //             <img style="width: 20px;height:20px;" src="/assets/img/assets/icon-${item}.svg" alt="">
                //             </span>`
                //         })
                //         return html
                //     }
                // }, 
                {
                    title: `${$buy_text || 'Buy'}`,
                    field: 's_simplex',
                    align: 'center',
                    formatter: function(value) {
                        return `<span>
                            <img src="${ value ? '/assets/img/assets/table-swap-checked.svg': '/assets/img/assets/table-swap-not-checked.svg'}" />
                        </span>`
                    }
                }, 
                {
                    title: `${$swap_text || 'Swap'}`,
                    field: 's_swap',
                    align: 'center',
                    formatter: function(value, row, index) {
                        return `<span>
                            <img src="${ value ? '/assets/img/assets/table-swap-checked.svg': '/assets/img/assets/table-swap-not-checked.svg'}" />
                        </span>`
                    }
                }, 
                {
                    title: `${$supported_wallet || 'Supported Wallet'}`,
                    field: 'supported',
                    align: 'center',
                    formatter: function (value, row, index) { // 处理该行数据
                        const { type } = row;
                        let html = '';
                        let tipsIcon = `<span data-bs-custom-class="my-tooltip-special" data-trigger="click" data-toggle="tooltip" data-placement="top" 
                            title="<div style='font-size:12px;padding: 20px;' class='s1Tooltip'>${s1_tooltip_tips}</div>" class="tipsIcon"><svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M4.8335 1.04541C7.04264 1.04541 8.8335 2.83627 8.8335 5.04541C8.8335 7.25455 7.04264 9.04541 4.8335 9.04541C2.62436 9.04541 0.833496 7.25455 0.833496 5.04541C0.833496 2.83627 2.62436 1.04541 4.8335 1.04541Z" stroke="#9E9CB1" stroke-width="0.857143" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M4.8335 6.64526V5.04526" stroke="#9E9CB1" stroke-width="0.857143" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M4.8335 3.44531H4.8375" stroke="#9E9CB1" stroke-width="0.857143" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg></span>`
                        value.map((item,index) => {
                            let item_str = '';
                            if(item==='X1'){
                                item_str=x1_hardware || 'X1 Hardware'
                            }else if(item==='S1'){
                                item_str = s1_s1_pro || "S1/S1 Pro"
                            }else if (item==='App'){
                                item_str=$mobile_wallet || 'Mobile Wallet'
                            }else if(item==='Extension'){
                                item_str= $extension_wallet || 'Extension Wallet'
                            }

                            html+= `<div class="supported">
                                ${ [27,142].includes(type) && item==='S1' ? tipsIcon : '' }
                                <span class="supportedIcon" data-trigger="hover" data-toggle="tooltip" data-placement="top" title="${item_str}">
                                    <img class="iconBox" src="/assets/img/assets/${item}.svg?t=1" alt="">
                            </span></div>`
                        })
                        return `<div class="supportedBox">${html}</div>`;
                    }
                }
            ],
            formatNoMatches:function(){
                return `<div class="noData d-flex justify-content-center align-items-center flex-column">
                    <span>${$crypto_not_supported || 'This crypto is not supported yet.'}</span>
                    <a class="btn" href="https://docs.google.com/forms/d/e/1FAIpQLSf6z2mZEY0nDmjwVJSjsbBSlCH3g-f_1Xv4a5yhGi8SjGIwXg/viewform">${$submit_token || 'Submit Token'}</a>
                </div>`;
            }
        }).bootstrapTable('append', list);
        // $('[data-toggle="tooltip"]').tooltip()
        // if (isMobile()) {
            
        // } else {
            
        // }
        
        if ( !isMobile() && $('.tdBox').length < total || isMobile() && $('.m-list-item').length < total) {
            isMore = true
            isMobile() ? $('.m-load-more').show() : $('.load-more').show()
        } else {
            isMobile() ? $('.m-load-more').hide() : $('.load-more').hide()
            isMore = false
        }
        if ( isMobile() && !$('.m-list-item').length) {
            $('.m-list-box').html('');
            $('.m-list-box').append(`<div style="60px auto" class="noData d-flex justify-content-center align-items-center flex-column">
            <span>${$crypto_not_supported || 'This crypto is not supported yet.'}</span>
            <a class="btn" href="https://docs.google.com/forms/d/e/1FAIpQLSf6z2mZEY0nDmjwVJSjsbBSlCH3g-f_1Xv4a5yhGi8SjGIwXg/viewform">${$submit_token || 'Submit Token'}</a>
        </div>`)
        }
        
    }
    function supportedHtml(list, type) {
        if (!list) { return false; }
        let tipsIcon = `<span data-bs-custom-class="my-tooltip-special tooltipM" data-trigger="click" data-toggle="tooltip" data-placement="auto left" 
            title="<div style='font-size:12px;padding: 10px;' class='s1Tooltip'>${s1_tooltip_tips}</div>" class="tipsIcon"><svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M4.8335 1.04541C7.04264 1.04541 8.8335 2.83627 8.8335 5.04541C8.8335 7.25455 7.04264 9.04541 4.8335 9.04541C2.62436 9.04541 0.833496 7.25455 0.833496 5.04541C0.833496 2.83627 2.62436 1.04541 4.8335 1.04541Z" stroke="#9E9CB1" stroke-width="0.857143" stroke-linecap="round" stroke-linejoin="round"/>
        <path d="M4.8335 6.64526V5.04526" stroke="#9E9CB1" stroke-width="0.857143" stroke-linecap="round" stroke-linejoin="round"/>
        <path d="M4.8335 3.44531H4.8375" stroke="#9E9CB1" stroke-width="0.857143" stroke-linecap="round" stroke-linejoin="round"/>
        </svg></span>`
        let html = '';
        list.map((item,index) => {
            html+=`<div class="supported">
            ${ [27,142].includes(type) && item==='S1' ? tipsIcon : '' }
            <span class="supportedIcon">
            <img class="iconBox" src="/assets/img/assets/${item}.svg?t=1" alt="">
        </span></div>`
        })
        return `<div class="supportedBox">${html}</div>`;
    }
    function loadMore() {
        if (isMore) {
            if (isMobile()) {
                if ($('.m-load-more').offset().top < parseInt($(document).scrollTop() + 900)) {
                    getList(true)
                }
            } else {
                if ($('.load-more').offset().top < parseInt($(document).scrollTop() + 800)) {
                    getList(true)
                }
            }
            
        }
    }
    on('click', '.loadMore', function() {
        getList(true);
    }, true)
    // 找到子元素在父元素中的相对位置
    function getElementTop(element){
        var el = (typeof element == "string") ? document.getElementById(element) : element;
        if (el && el.parentNode === null || el && el.style.display == 'none') {
        return false;
        }
        return el && (el.offsetTop - el.parentNode.offsetTop) || null;
    }
    on('click', '.m-filter-menu', function(e) {
        select('.m-filter-menu-dialog').classList.toggle('dialog-fixed')
        select('body').classList.toggle('overflow-hidden')
    });
    // m端buy-swap 筛选选中
    on('click', '#buySwapBtnOk', function(e) {
        getList();
        select('.m-filter-menu-dialog').classList.remove('dialog-fixed')
        select('body').classList.remove('overflow-hidden')
    });
    on('click', '#buySwapBtnReset', function(e) {
        $("input:radio[name=buyRadio]").eq(0).click();
        $("input:radio[name=swapRadio]").eq(0).click();
        $("input:radio[name=walletRadio]").eq(0).click();
        getList();
        select('.m-filter-menu-dialog').classList.remove('dialog-fixed')
        select('body').classList.remove('overflow-hidden')
    });
    document.onkeydown = function(e) {
        e = e || window.event;
        console.log(e.keyCode,liIndex)
        switch(e.keyCode){
            case 38:
                liIndex = (liIndex === -1) ? -1 : liIndex-1
                if (liIndex<0) {
                    $("#search-input").val(oldVal)
                }else{
                    $("#search-input").val($(`#liItem${liIndex}`).text())
                }
            break;
            case 40:
                liIndex = (liIndex === $('.liItem').length - 1 )  ? liIndex : liIndex+1
                 $("#search-input").val($(`#liItem${liIndex}`).text())

            break;
        }
        if ($('.dowBox').html()) {
            const currentLi = $(`#liItem${liIndex}`)
            if (liIndex === -1) {
                $(`#liItem0`).removeClass('actice')
            }
            currentLi.addClass('actice').siblings().removeClass('actice')
            document.getElementById('dowBox').scrollTop = getElementTop(`liItem${liIndex}`)
        }
    };
    $(document).ready(function () {
        // window.addEventListener('scroll', throttle(loadMore, 500, 500));
        getList()
    });
    if (isMobile()) {
        document.addEventListener('click', function(e) {
            let tar1 = getEventTarget(e, '.m-filter-menu-dialog .content');
            let tar2 = getEventTarget(e, '.m-filter-menu');
            if (!tar1 && !tar2) { 
                select('.m-filter-menu-dialog').classList.remove('dialog-fixed')
                select('body').classList.remove('overflow-hidden')
            }
        });
    }
    
})()