!function(m){let v=m.cookie("token");v=v&&decodeURIComponent(v),m.fn.myComment=async function({id:n="",real:o=!1}){let l=!0,d={},i=["#7E9AFF","#2BBDB5","#FFD37E","#FF5AB5","#2EBD85"],a=()=>parseInt(Math.random()*i.length);function c(e){let t="";return e&&e.map(e=>{t+=`
                <div class="comment-item">
                        <div class="avater-name-like">
                            <div class="avater-name">
                                <div class="avater"><img class="img-fluid rounded-circle" src="${function(e="",t,i="#3F37FF"){let a,s,r,n;return"?"==(a=(a=(a=String(e).trim().toUpperCase()).replace(/\uD83C[\uDF00-\uDFFF]|\uD83D[\uDC00-\uDE4F]/g,""))?a.charAt(0):"?")||a.charCodeAt(0),(s=document.createElement("canvas")).width=t,s.height=t,(r=s.getContext("2d")).fillStyle=i,r.fillRect(0,0,s.width,s.height),r.font=Math.round(s.width/2)+"px 'Microsoft Yahei'",r.textAlign="center",r.fillStyle="#fff",r.fillText(a,t/2,t/1.5),n=s.toDataURL("image/png"),s=null,n}(e.user.display_name,48,i[a()])}" alt="" srcset=""></div>
                                <div class="name">
                                    <h3>${e.user.display_name}</h3>
                                    <div class="star-comment-${e.id}"></div>
                                </div>
                            </div>
                            <div class="like like-votes" data-review-id=${e.id}>
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="19" viewBox="0 0 18 19" fill="none">
                                    <path d="M5.25 9.04736L8.25 2.29736C8.84674 2.29736 9.41903 2.53442 9.84099 2.95637C10.2629 3.37833 10.5 3.95063 10.5 4.54736V7.54736H14.745C14.9624 7.5449 15.1778 7.58974 15.3762 7.67878C15.5746 7.76781 15.7512 7.89891 15.8939 8.063C16.0366 8.22708 16.1419 8.42023 16.2025 8.62905C16.2631 8.83787 16.2776 9.05738 16.245 9.27236L15.21 16.0224C15.1558 16.38 14.9741 16.7061 14.6984 16.9404C14.4228 17.1747 14.0717 17.3015 13.71 17.2974H5.25M5.25 9.04736V17.2974M5.25 9.04736H3C2.60218 9.04736 2.22064 9.2054 1.93934 9.4867C1.65804 9.76801 1.5 10.1495 1.5 10.5474V15.7974C1.5 16.1952 1.65804 16.5767 1.93934 16.858C2.22064 17.1393 2.60218 17.2974 3 17.2974H5.25" stroke="black" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                <span class="value">${e.votes_up}</span>
                            </div>
                        </div>
                        <div class="title-reviews">
                            <div>
                                <div class="title">${e.title}</div>
                                <div class="reviews">${e.content}</div>
                                <p class="update-time">${s(e.created_at)}</p>
                            </div>
                            ${e.comment?`<div class="comment-item comment-comment">
                                        <div class="avater-name-like">
                                            <div class="avater-name">
                                                <div class="avater">
                                                    <svg width="50" height="50" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <rect x="0.115723" y="0.797363" width="48" height="48" rx="24" fill="#4A21EF"/>
                                                        <path d="M22.2997 11.1973C21.4816 11.1973 20.697 11.5223 20.1186 12.1007L11.0319 21.1876C10.6877 21.5318 10.5156 21.9829 10.5156 22.434C10.5156 22.8851 10.6877 23.3362 11.0319 23.6803L16.9867 29.6352V19.093C16.9867 18.3062 17.6194 17.6684 18.4062 17.6684C21.73 17.6684 29.8207 17.6684 30.9243 17.6684L37.3953 11.1974L22.2997 11.1973Z" fill="white"/>
                                                        <path d="M16.987 31.6061H29.5001C30.2868 31.6061 30.9246 30.9683 30.9246 30.1816V19.6393L36.8794 25.5942C37.2235 25.9384 37.3956 26.3895 37.3956 26.8405C37.3956 27.2916 37.2236 27.7427 36.8794 28.0869L27.7927 37.1738C27.2142 37.7523 26.4296 38.0773 25.6115 38.0773L10.5159 38.0772L16.987 31.6061Z" fill="white"/>
                                                        <path d="M41.1157 30.7974L43.2572 33.2065L46.4058 32.5162L46.7222 35.724L49.6752 37.0162L48.0457 39.7974L49.6752 42.5785L46.7222 43.8707L46.4058 47.0785L43.2572 46.3882L41.1157 48.7974L38.9742 46.3882L35.8257 47.0785L35.5092 43.8707L32.5562 42.5785L34.1857 39.7974L32.5562 37.0162L35.5092 35.724L35.8257 32.5162L38.9742 33.2065L41.1157 30.7974Z" fill="#F4C63E"/>
                                                        <path d="M43.7598 38.0393L40.0296 41.7592L38.334 40.0684" stroke="white" stroke-width="1.63636" stroke-linecap="square"/>
                                                    </svg>
                                                </div>
                                                <div class="name report">
                                                    <h3>SafePal Sales Team</h3>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="title-reviews report-reviews">
                                            <div>
                                                <div class="reviews">${e.comment.content}</div>
                                                <p class="update-time">${s(e.comment.created_at)}</p>
                                            </div>
                                        </div>
                                    </div>`:""}
                        </div>
                    </div>
                    <div class="dividing-line" style="margin: 0px;"></div>
                    `}),t}var e=function(e,t,i){let a=document.createElement(e);return t.length&&t.forEach(e=>a.classList.add(e)),i&&(a.innerText=i),a}("div",["my-comment","container","opacity0"]);function p(e,t){m(e).raty({width:120,readOnly:!0,score:t,halfShow:!1,path:"/assets/img/s1",starOff:"raty_comment_empty_star.svg",starOn:"raty_comment_fill_star.svg",hints:["","","","",""]})}function s(e){var t,i;return e&&(t=""+(e=new Date(e)).getFullYear(),`${10<=(i=e.getMonth()+1)?i:"0"+i}/${10<=(i=e.getDate())?i:"0"+i}/`+t.substr(2))}m(e).html(`
            <div class="write-review">
                <div class="top-box">
                    <div class="top-left">
                        <div id="rating-star" class="rating-star"></div>
                        <div class="reviews"><span id="total-review"></span> Reviews</div>
                    </div>
                    <div class="top-right">
                        <button id="write-review" class="btn-write">
                            <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g id="24/edit">
                                <path id="Vector" d="M13.6802 6.43555L16.6632 9.50655" stroke="#333333" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round"/>
                                <path id="Vector_2" fill-rule="evenodd" clip-rule="evenodd" d="M18.795 7.96093L9.37797 17.2357L4.77344 18.3243L5.80529 13.6361L15.1375 4.27888C15.5275 3.88783 16.1598 3.86541 16.5508 4.25541L18.8029 6.54381C19.1921 6.93569 19.1899 7.56885 18.798 7.95801L18.795 7.96093Z" stroke="#333333" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round"/>
                                <path id="Vector_3" d="M4.47705 21.5685H19.5101" stroke="#333333" stroke-width="1.25" stroke-linecap="round"/>
                                </g>
                            </svg>
                            <span class="text">WRITE A REVIEW</span>
                        </button>
                    </div>
                </div>
                <div class="write-input">
                    <div class="dividing-line" style="margin: 0px;"></div>
                    <div class="title">
                        <h3 class="text">Write A Review</h3>
                        <p class="tips">(<span style="color:#F00">*</span>Indicates a required field)</p>
                    </div>
                    <form action="" id="write-reviews">
                        <div class="score">
                            <div class="score-box">
                                <p class="label"><span style="color:#F00">*</span>Score:</p>
                                <div id="fill-star" class="fill-star"></div>
                            </div>
                            <p class="require-tips">Please enter a star rating for this review</p>
                        </div>
                        <div class="fill-title fill-input">
                            <p class="label"><span style="color:#F00">*</span>Title:</p>
                            <div class="input-item">
                                <input id="comment-title" data-require="true" type="text" class="form-input" >
                            </div>
                            <p class="require-tips">Review's title can't be empty</p>
                            <p class="error-tips">Please enter less or equal than 200 symbols.</p>
                        </div>
                        <div class="fill-review fill-input area-text">
                            <p class="label"><span style="color:#F00">*</span>Review:</p>
                            <div class="input-item">
                                <textarea id="comment-review" data-require="true" rows="4" class="form-input" placeholder="" ></textarea>
                            </div>
                            <p class="require-tips">Review's body can't be empty</p>
                            <p class="error-tips">Please enter less or equal than 1000 symbols.</p>
                        </div>
                        <div class="item-row">
                            <div class="fill-name fill-input">
                                <p class="label"><span style="color:#F00">*</span>Use your name:</p>
                                <div class="input-item">
                                    <input id="comment-name" data-require="true" type="text" class="form-input" placeholder="" >
                                </div>
                                <p class="require-tips">Name field cannot be empty</p>
                                <p class="error-tips">Please enter less or equal than 200 symbols.</p>
                            </div>
                            <div class="fill-email fill-input">
                                <p class="label"><span style="color:#F00">*</span>Email:</p>
                                <div class="input-item">
                                    <input id="comment-email" data-require="true" type="text" class="form-input" placeholder="" >
                                </div>
                                <p class="require-tips">Email field cannot be empty</p>
                                <p class="error-tips">Invalid email</p>
                            </div>
                        </div>
                        <div class="post">
                            <button id="post-comment" type="button" class="btn-common btn-post">POST</button>
                        </div>
                    </form>
                </div>
                <div class="dividing-line" style="margin: 0px;"></div>
            </div>
        <div class="comment-show"></div><div id="comment-pagination" class="comment-pagination"></div>`),m(this).html(e),m(document).ready(function(){let r;m("#comment-pagination").pagination({dataSource:base_url+`/getReviewList/${n}?sort=date&direction=desc`,alias:{pageNumber:"page",pageSize:"per_page"},pageSize:5,locator:"response.reviews",totalNumberLocator:function(e){var{total:e}=e["response"]["pagination"];return e},ajax:{dataType:"json",contentType:"application/json;charset=utf-8",beforeSend:function(e){e.setRequestHeader("Authorization","Bearer "+v),m(document.body).myLoadingStart()},error:function(e){return m(document.body).myLoadingEnd(),e}},showGoInput:!1,showGoButton:!1,prevText:"&lt",nextText:"&gt",className:"my-paginationjs-theme",pageLink:"javascript:void(0);",onError:function(){m(document.body).myLoadingEnd()},callback:function(e,t){const{bottomline:i,reviews:a,products:s}=t.originalResponse.response;r=s,m(".comment-show").html(c(e)),m(".my-comment").removeClass("opacity0"),p("#rating-star",i.average_score||5);t=""+n=="2059"?2e3:""+n=="2060"?200:""+n=="2065"?95:""+n=="2064"?80:170;m("#total-review").html(o?+i.total_review:+i.total_review+t),a&&a.map(e=>{p(".star-comment-"+e.id,e.score)}),m(document.body).myLoadingEnd(),m(".like-votes").off("click"),m(".like-votes").on("click",function(){let t=m(this).data("review-id");m(document.body).myLoadingStart(),m.ajaxPromise({type:"post",url:d[t]?`${base_url}/unVoteReview/${t}/up`:`${base_url}/voteReview/${t}/up`,dataType:"json",contentType:"application/json;charset=utf-8",beforeSend:function(e){e.setRequestHeader("Authorization","Bearer "+v)},cache:!1,async:!0}).then(e=>{var e=JSON.parse(e)["status"];200===e.code&&(e=m(this).find(".value").text(),m(this).find(".value").html(d[t]?0!=+e?+e-1:e:+e+1),d[t]=!d[t])}).finally(()=>{m(document.body).myLoadingEnd()})}),m("#post-comment").off("click"),m("#post-comment").on("click",function(){let i={};m("#fill-star").raty("score")||(m("#write-reviews").find(".score").find(".require-tips").show(300),i.star=!0);m(".form-input:visible").map((e,t)=>{Boolean(m(t).data("require"))&&!m(t).val()&&(m(t).addClass("required_error"),(m(t).parent().siblings(".require-tips").length?m(t):m(t).parent()).parent().siblings(".require-tips").show(300),i[m(t).attr("id")]=!0),m(t).hasClass("required_error")&&(i[m(t).attr("id")]=!0)});if(Object.values(i).some(e=>!0===e))return!1;let t={sku:n,review_score:m("#fill-star").raty("score"),review_title:m("#comment-title").val(),review_content:m("#comment-review").val(),display_name:m("#comment-name").val(),email:m("#comment-email").val()};s&&s.map(e=>{e.domain_key===""+n&&(t.product_title=e.name,t.product_url=e.product_link)}),m(document.body).myLoadingStart(),m.ajaxPromise({type:"post",url:base_url+"/createReview",dataType:"json",contentType:"application/json;charset=utf-8",beforeSend:function(e){e.setRequestHeader("Authorization","Bearer "+v)},data:JSON.stringify(t),cache:!1,async:!0}).then(e=>{m(".write-input").toggle(500),m("#fill-star").raty("cancel",!0),m("#comment-title").val(""),m("#comment-review").val(""),m("#comment-name").val(""),m("#comment-email").val(""),m(document).dialog({type:"confirm",titleShow:!1,bodyNoScroll:!0,dialogClass:"dialog-cart-empty",content:"You have successfully submitted your review. Thank you!",buttons:[{class:"cart-empty",name:$Ok||"OK",callback:()=>{}}]})}).finally(()=>{m(document.body).myLoadingEnd()})}),l||m("html, body").animate({scrollTop:"navigator"in window&&window.navigator.userAgent.match(/(iPad)|(iPhone)|(iPod)|(Android)|(PlayBook)|(BB10)|(BlackBerry)|(Opera Mini)|(IEMobile)|(webOS)|(MeeGo)/i)?m(".comment-show").offset().top-200:m(".comment-show").offset().top-230},300),l=!1}}),m("#fill-star").raty({width:180,size:30,halfShow:!1,path:"/assets/img/s1",starOff:"icon_raty_comment_empty_star.svg",starOn:"icon_raty_comment_fill_star.svg",hints:["","","","",""],click:function(e){e&&m("#write-reviews").find(".score").find(".require-tips").hide(300)}}),m("#write-review").on("click",function(){m(".write-input").toggle(500)}),m(".form-input").on("input",function(){const t=this;var e=m(t).attr("id");let i=m(t).val().trim();if(i||m(t).val(""),Boolean(m(t).data("require"))&&i)m(t).parent().siblings(".require-tips").hide(300),m(t).removeClass("required_error");else if(Boolean(m(t).data("require"))&&!i)return m(t).parent().siblings(".error-tips").hide(300),m(t).parent().siblings(".require-tips").show(300),m(t).addClass("required_error"),!1;var a=i.match(/<script[^>]*>([^<]|<(?!\/script))*<\/script>/gim);if(a&&a.length)return a.map(e=>{m(t).val(i.replace(e,""))}),!1;switch(e){case"comment-email":new RegExp(/[a-zA-Z0-9]+([-_.][A-Za-zd]+)*@([a-zA-Z0-9]+[-.])+[A-Za-zd]{2,20}$/).test(i)?(m(t).parent().siblings(".error-tips").hide(300),m(t).removeClass("required_error")):(m(t).parent().siblings(".error-tips").show(300),m(t).addClass("required_error"));break;case"comment-title":case"comment-name":i&&200<i.length?(m(t).parent().siblings(".error-tips").show(300),m(t).addClass("required_error")):(m(t).parent().siblings(".error-tips").hide(300),m(t).removeClass("required_error"));break;case"comment-review":i&&1e3<i.length?(m(t).parent().siblings(".error-tips").show(300),m(t).addClass("required_error")):(m(t).parent().siblings(".error-tips").hide(300),m(t).removeClass("required_error"))}}),m(".form-input").on("blur",function(){var e=this,t=m(e).val(),i=m(e).attr("id");m(e).val()&&"comment-email"===i&&(new RegExp(/[a-zA-Z0-9]+([-_.][A-Za-zd]+)*@([a-zA-Z0-9]+[-.])+[A-Za-zd]{2,20}$/).test(t)?(m(e).parent().siblings(".error-tips").hide(),m(e).removeClass("required_error")):(m(e).parent().siblings(".error-tips").show(),m(e).addClass("required_error")))}),window.addEventListener("resize",()=>{["INPUT","TEXTAREA"].includes(document.activeElement.tagName)&&window.setTimeout(()=>{document.activeElement.scrollIntoViewIfNeeded()},100)})})}}(jQuery);