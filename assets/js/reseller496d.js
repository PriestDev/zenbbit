(function(){
    const url = "/reseller/search";

    // 提交join in 
    let submiting = 0;
    function submitJoin() {
        if (submiting) {
            return;
        }
        var email = $("#cemail");
        var firstname = $("#firstname");
        var lastname = $("#lastname");
        var jobtitle = $("#jobtitle");
        var company = $("#company");
        var website = $("#website");
        var region = $("#region");
        var zipcode = $("#zipcode");

        var reg = /^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/;
        function doError(tips, target) {
            $(document).dialog({
                titleShow: false,
                content: tips,
            });
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: "center", inline: "nearest"
                });
            }
        }
        if (email.val() == "" || !reg.test(email.val())) {
            $(email).focus();
            doError(please_input_correct_email, email[0])
            return;
        }
        if (firstname.val() === "") {
            $(firstname).focus();
            doError(please_input_your_first_name, firstname[0])
            return;
        }
        if (lastname.val() === "") {
            $(lastname).focus();
            doError(please_input_your_last_name, lastname[0])
            return;
        }
        if (jobtitle.val() === "") {
            $(jobtitle).focus();
            doError(please_input_your_job_title, jobtitle[0])
            return;
        }
        if (company.val() === "") {
            $(company).focus();
            doError(`${input_your_company_name || 'Please input your Company Name'}`, company[0])
            return;
        }
        var strReg = /^(http:\/\/www\.|https:\/\/www\.|http:\/\/|https:\/\/|www\.)[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/;
        /*
        if (website.val() == "" || !strReg.test(website.val())) {
            //alert("Please input correct website");
            $(document).dialog({
                titleShow: false,
                content: please_input_correct_website,
            });
            $(website).focus();
            return;
        }
        */
        if (website.val() !== "" && !strReg.test(website.val())) {
            $(website).focus();
            doError(please_input_correct_website, website[0])
            return;
        }

        if (zipcode.val() === "") {
            $(zipcode).focus();
            doError(please_input_zipcode, zipcode[0])
            return;
        }
        if (region.val() === "") {
            $(region).focus();
            doError(please_input_country_or_region, region[0])
            return;
        }

        submiting = 1;
        $.ajax({
            type: "post",    // 请求类型
            url: "/reseller/save",    // 请求URL
            data: $("#resellerForm").serialize(),    // 请求参数 即是 在Servlet中 request.getParement();可以得到的字符串
            dataType: "json",    // 数据返回类型
            cache: false, // 是否缓存
            async: true,    // 默认为true 异步请求
            success: function (result) {    // 成功返回的结果(响应)
                submiting = 0;
                if (result.code == 0) {
                    $(document).dialog({
                        titleShow: false,
                        content:  reseller_ok_tips || result.msg,
                    });
                } else {
                    var show_msg = result.msg;
                    let obj = {
                        '-5021': system_error,
                        '-502': system_error,
                        '-504': system_error,
                        '1': email_exist
                    };
                    if (result.code < 0) {
                        show_msg = obj[`${result.code}`] || show_msg;
                        show_msg += " code(" + result.code + ")";
                    }
                    $(document).dialog({
                        titleShow: false,
                        content: obj[`${result.code}`] || show_msg,
                    });
                }
            },
            error: function () {
                submiting = 0;
            }
        });
    }
    $("#join-submit").on("click", function () {
        submitJoin()
    });
    $('#resellerForm').on('submit', function(e) {
        e.preventDefault();
    });
    
    // ------- 请求 -------
    on('input', "#retailer", function(e) {
        let query = $("#retailer").val();
        if (!query) {
            $("#search_result_box").hide();
        }
    })
    $("#retailer-search-btn").click(function() {
        searchFn()
    });
    function searchFn() {
        let query = $("#retailer").val();
        if (query.trim() === "") { return }
        $.ajax({
            type: "post", // 请求类型
            url: url, // 请求URL
            data: {
                "query": query
            }, // 请求参数 即是 在Servlet中 request.getParement();可以得到的字符串
            dataType: "json", // 数据返回类型
            cache: false, // 是否缓存
            async: true, // 默认为true 异步请求
            success: function(result) { // 成功返回的结果(响应)
                if (result.code == 0) {
                    $("#search_result_box").html(result.data.str);
                    $("#search_result_box").show();
                } else {
                    let { msg, code } = result;
                    $(document).dialog({
                        titleShow: false,
                        content:  code === -11 ? (not_found || msg) : msg,
                    });
                }
            }
        });
    }
    $("#go_to_join_us").click(function() {
        document.getElementById("join-us-now").scrollIntoView();
    })
    // pc 监听enter事件
    if (!isMobile()) {
        $('#retailer').on('keydown', function(e) {
            if (event.keyCode == "13") {
                searchFn();
            }
        })
    }
    // 移动端from提交事件
    $('#input-form').on('submit', function(e) {
        e.preventDefault();
        searchFn();
    });
})()