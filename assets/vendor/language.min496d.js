!function(c){function n(a,e=null,t){let i=document.createElement(a);return e.length&&e.forEach(a=>i.classList.add(a)),t&&(i.innerText=t),i}c.fn.language=function(a){let e=this,t=n("div",["icon-language"]),o=n("span",["lang-show","d-none","d-lg-block"],"English");var i=n("i",["bi","bi-caret-down-fill","d-none","d-lg-block"]);c(t).html(`<svg class="icon" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle class="icon-path" cx="12" cy="12" r="10" stroke="#F7F6FF" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round"/>
            <path class="icon-path" d="M2 12H22" stroke="#F7F6FF" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round"/>
            <path class="icon-path" d="M12 2C14.5013 4.73835 15.9228 8.29203 16 12C15.9228 15.708 14.5013 19.2616 12 22C9.49872 19.2616 8.07725 15.708 8 12C8.07725 8.29203 9.49872 4.73835 12 2Z" stroke="#F7F6FF" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        `),c(t).append(o),c(t).append(i),c(e).append(c(t));{c(e).height();let s=["ar","en","zh-cn","zh-tc","kr","fr","de","jp","it","es","tr","pt","ru","th","id","vn"],d={ar:"عربي",en:"English","zh-cn":"简体中文","zh-tc":"繁體中文",kr:"한국어",fr:"Français",de:"Deutsch",jp:"日本語",it:"Italiano",es:"Español",tr:"Türkçe",pt:"Português",ru:"Русский",th:"ภาษาไทย",id:"Bahasa Indonesia",vn:"Tiếng Việt"},l=(c(o).html(d[url_lang||current_lang]),n("div",["language-box-header"]));l.setAttribute("style","ar"===(url_lang||current_lang)?"left: 0px;":"left:-300px;"),i=n("div",["main-content"]),c(i).html(`
                <div class="content-item">
                    <div data-name="en" class="item">English</div>
                    <div data-name="de" class="item">Deutsch</div>
                    <div data-name="es" class="item">Español</div>
                    <div data-name="fr" class="item">Français</div>
                    <div data-name="id" class="item">Bahasa Indonesia</div>
                    <div data-name="it" class="item">Italiano</div>
                    <div data-name="jp" class="item">日本語</div>
                    <div data-name="pt" class="item">Português</div>
                    <div data-name="ru" class="item">Русский</div>
                    <div data-name="th" class="item">ภาษาไทย</div>
                    <div data-name="tr" class="item">Türkçe</div>
                    <div data-name="vn" class="item">Tiếng Việt</div>
                    <div data-name="zh-cn" class="item">简体中文</div>
                    <div data-name="zh-tc" class="item">繁體中文</div>
                    <div data-name="ar" class="item">عربي</div>
                </div>
            `),l.appendChild(i),(a?(l.setAttribute("style",""),l.classList.add("append-body-m"),c(a)):c(e)).append(c(l)),c(t).on("click",a=>{c(l).toggleClass("show")}),c(i).find(".item").map((a,e)=>{c(e).on("click",()=>{c(l).removeClass("show");let t=!1,i=c(e).data("name");let n=window.location.pathname.split("/");n.map((a,e)=>{s.includes(a)&&(n[e]=i,t=!0)}),c(o).html(d[i]),c.cookie("lang",i,{expires:365,path:"/",secure:!0}),t?window.location.href=""+n.join("/"):window.location.href="/"+i+n.join("/")}),current_lang===c(e).data("name")&&c(e).addClass("actived")}),document.addEventListener("click",function(a){var e=getEventTarget(a,".language-box-header.show"),a=getEventTarget(a,".icon-language");e||a||c(l).removeClass("show")})}}}(jQuery);