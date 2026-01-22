(function () {
    "use strict";
    
    function getCountryMap() {
        let myChart = echarts.init($('.map-main')[0]);
        $(document.body).myLoadingStart();
        $.getJSON('/assets/vendor/echarts/world.json', async function(data) {
            echarts.registerMap('world', data);
            let listHtml = '';
            let noIssuanceMastercardListHtml = ''
            let mapData = [];
            let targetResMasterCountriesDataArr = [];
            myChartSetOption();

            let resMasterCountriesData = await $.ajax({ url: `https://ep.isafepal.com/bank/v1/account/getMasterCountries`, 
                type: "get", // 请求类型
                dataType: "json", // 数据返回类型
                cache: false, // 是否缓存
                async: true, // 默认为true 异步请求
                contentType: "application/x-www-form-urlencoded",
                error: function() {
                    $(document.body).myLoadingEnd();
                },
            });
            if(resMasterCountriesData && resMasterCountriesData.data) {
                let resMasterCountriesDataArr = [...resMasterCountriesData.data]
                const filterResMasterCountriesDataArr1 = resMasterCountriesDataArr.filter(item => !(/^[a-zA-Z]/.test(item.Name)));
                const filterResMasterCountriesDataArr2 = resMasterCountriesDataArr.filter(item => (/^[a-zA-Z]/.test(item.Name)));
                filterResMasterCountriesDataArr2.sort(function(a,b) {
                    return (a.Name + '').localeCompare(b.Name + '')
                })
                targetResMasterCountriesDataArr = [...filterResMasterCountriesDataArr2, ...filterResMasterCountriesDataArr1]
                targetResMasterCountriesDataArr.map(item => {
                    noIssuanceMastercardListHtml += `<div class="list-item">${item.Name}(${item.Id})</div>`;
                    mapData.push({name: item.Name, value: 1})
                })
            }
            myChartSetOption()
            $('#issuanceMastercardList').html(noIssuanceMastercardListHtml)

            let resAllData = await $.ajax({ url: `https://ep.isafepal.com/bank/v1/account/getCountry`, 
                type: "get", // 请求类型
                dataType: "json", // 数据返回类型
                cache: false, // 是否缓存
                async: true, // 默认为true 异步请求
                contentType: "application/x-www-form-urlencoded",
                error: function() {
                    $(document.body).myLoadingEnd();
                },
            });
            if (resAllData&&resAllData.data) {
                // let arr = [...resData.data];
                let arr = [...resAllData.data];
                let noIssuanceMastercardList = arr.filter(item => !targetResMasterCountriesDataArr.some(v => v.Id === item.Id ))
                const filteredData1 = noIssuanceMastercardList.filter(item => !(/^[a-zA-Z]/.test(item.Name)));
                const filteredData2 = noIssuanceMastercardList.filter(item => (/^[a-zA-Z]/.test(item.Name)));
                filteredData2.sort(function(a,b) {
                    return (a.Name + '').localeCompare(b.Name + '')
                })
                let targetArr = [...filteredData2, ...filteredData1]
                targetArr.map(item => {
                    item['type'] = 2
                    listHtml += `<div class="list-item">${item.Name}(${item.Id})</div>`;
                    mapData.push({name: item.Name, value: 2})
                })
            }
            myChartSetOption()
            $('#noIssuanceMastercardList').html(listHtml)
            

            $(document.body).myLoadingEnd();
            
            function myChartSetOption() {
                let option = {
                    title: {
                        text: '', // title text，支持使用 \n 换行
                        top: 20, // 定位 值: 'top', 'middle', 'bottom' 也可以是具体的值或者百分比
                        left: 'center', // 值: 'left', 'center', 'right' 同上
                        textStyle: { // 文本样式
                            fontSize: 24,
                            fontWeight: 600,
                            color: '#fff'
                        }
                    },
                    tooltip: {
                        trigger: 'item',
                        formatter: function (params) {
                            if (params.name&&params.data) {
                                return params.name;
                            }
                        }
                    },
                    visualMap: {
                        show: false,
                        pieces: [
                            { min: 1, max: 1, color: '#4A21EF' },
                            { min: 2, max: 2, color: '#9D88F7' },
                        ],
                        inRange: {
                            color: ['#4A21EF', '#9D88F7'] // 定义颜色范围
                        }
                    },
                    series: [
                        {
                            name: 'World Population',
                            type: 'map',
                            mapType: 'world',
                            // layoutCenter: ['50%', '50%'],//位置
                            // layoutSize: '180%',//大小
                            // aspectScale: 0.85, //宽高比
                            zoom: 1.24,
                            roam: false,
                            selectedMode: false,
                            itemStyle: {
                                areaColor: '#B7C4DD',
                                borderWidth: 1, // 描边线宽 为 0 时无描边
                                borderColor: '#fff', 
                                borderType: 'solid',
                                emphasis: {
                                    areaColor: '#4A21EF',
                                    label: {show: false}
                                },
                            },
                            label: {
                                show: false // 是否显示对应地名
                            },
                            data: mapData
                        }
                    ]
                };
                myChart.setOption(option);
                myChart.on('mouseover', function (param){
                    if(!param.data) {
                        option.series[0].itemStyle.emphasis = {};
                        myChart.setOption(option);
                    } else {
                        option.series[0].itemStyle.emphasis = {
                            areaColor: '#4A21EF',
                            label: {show: false}
                        };
                        myChart.setOption(option);
                    }
                });
                window.addEventListener("resize", () => {
                    myChart.resize();
                })
            }
            
        });
    }
    /**
     * brandoverview slider
     */
    function brandoverviewSwiper() {
        let brandoverviewSider = $('.brandoverview-swiper').find('.swiper-slide');
        let brandoverviewSiderM = $('.brandoverview-swiper-m').find('.swiper-slide');
        if (brandoverviewSider&&brandoverviewSider.length) {
            let autoplayOp = brandoverviewSider.length > 1 ? {
                delay: 500,
                disableOnInteraction: false
            } : false;
            const brandoverviewSwiper = new Swiper('.brandoverview-swiper', {
            speed: 6000,
            loop: true,
            autoplay: autoplayOp,
            // autoplay: {
            //   delay: 500,
            //   disableOnInteraction: false
            // },
            direction: 'vertical',
            slidesPerView: 'auto',
            });
        }
        if (brandoverviewSiderM&&brandoverviewSiderM.length) {
            let autoplayMop = brandoverviewSiderM.length > 1 ? {
            delay: 500,
            disableOnInteraction: false
            } : false;
            const brandoverviewSwiperMobile = new Swiper('.brandoverview-swiper-m', {
            speed: 6000,
            loop: true,
            autoplay: autoplayMop,
            // autoplay: {
            //   delay: 500,
            //   disableOnInteraction: false
            // },
            slidesPerView: 'auto',
            });
        }
    }
    function init() {
        brandoverviewSwiper();
        getCountryMap();
    }
    init();
})()