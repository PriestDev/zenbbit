(function ($) {
  $.fn.mySelect = function ({
    mark = '',
    id = null,
    require = false,
    currentId = null,
    arr,
    label, //input展示的字段
    callback,
    searchList = [],
    liRow = null,
    inputClass = '',
    showSearch = true,
    selectPlaceHolder = '',
    hidden = {},
    loadEle = () => { return { currentId, load: true } }
  }) {
    let that = this
    if (!(arr.length && isType(arr[0], 'Object'))) {
      return
    }
    if (!(label in arr[0])) {
      return
    }
    if (id === null || !(id in arr[0])) {
      return
    }
    let inputVal = '';
    let reg = /{{(.+?)}}/g;
    let w = 0;
    let flag = false;
    if (isMobile()) {
      if (that.has('.my-select').length) {
        that.find('.my-select').remove()
      }
      if ($(document).has(`.popup.popup-${mark}`).length) { $(`.popup.popup-${mark}`).remove() }
      that.append(`<div class="my-select ${ mark ? `my-select-${mark}` : '' }">
        <input id="input-select-${mark}" data-require="${require}" readonly="true" class="my-input form-input ${inputClass}" placeholder="${selectPlaceHolder || select_text || 'select'}" type="text" />
        <span class="inputImg arrowIcon">
          <svg class="arrow-down" width="14" height="8" viewBox="0 0 14 8" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M13.5635 1L7.56348 7L1.56348 1" stroke="#12151A" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </span>
      </div>`);
      loadEle({currentId, load: true});
      let popup = createE('div', ['popup', mark ? `popup-${mark}` : '']);
      let overlay = createE('div', ['overlay']);
      overlay.setAttribute('style', 'display: none;z-index: 1999;')
      let selectContent = createE('div', ['select-content', 'f-flex', 'justify-content-start', 'flex-column']);
      let topTitle = createE('div', ['top-title', 'f-flex', 'justify-content-between', 'align-items-center']);
      let spanTitle = createE('span', [])
      let spanClose = createE('span', ['icon-close']);
      spanClose.innerHTML = '<svg t="1679649006368" class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="2740" width="24" height="24"><path d="M572.16 512l183.466667-183.04a42.666667 42.666667 0 1 0-60.586667-60.586667L512 451.84l-183.04-183.466667a42.666667 42.666667 0 0 0-60.586667 60.586667l183.466667 183.04-183.466667 183.04a42.666667 42.666667 0 0 0 0 60.586667 42.666667 42.666667 0 0 0 60.586667 0l183.04-183.466667 183.04 183.466667a42.666667 42.666667 0 0 0 60.586667 0 42.666667 42.666667 0 0 0 0-60.586667z" fill="#12151A" p-id="2741"></path></svg>'
      let searchBox = createE('div', ['search-box', mark ? `search-box-${mark}` : '']);
      let inputBox = createE('input', ['search-input', mark ? `search-input-${mark}` : '', 'f-flex', 'justify-content-between', 'align-items-center']);
      inputBox.setAttribute('placeholder', search_by_name || 'Search by name');
      // inputBox.setAttribute('readonly', true);
      let searchBoxInput = createE('div', ['search-box-input', 'f-flex', 'justify-content-between', 'align-items-center']);
      let iconSearch = createE('div', ['icon-search', 'f-flex', 'justify-content-between', 'align-items-center'])
      iconSearch.innerHTML = '<svg t="1679649806160" class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="4168" width="16" height="16"><path d="M950.4 905.6l-236.8-236.8c54.4-64 86.4-147.2 86.4-236.8C800 227.2 636.8 64 432 64 227.2 64 64 227.2 64 432 64 636.8 227.2 800 432 800c89.6 0 172.8-32 236.8-86.4l236.8 236.8c6.4 6.4 16 9.6 22.4 9.6s16-3.2 22.4-9.6C963.2 937.6 963.2 918.4 950.4 905.6zM432 736C265.6 736 128 598.4 128 432 128 265.6 265.6 128 432 128c166.4 0 304 137.6 304 304C736 598.4 598.4 736 432 736z" p-id="4169" fill="#323233"></path></svg>'
      searchBoxInput.appendChild(iconSearch);
      searchBoxInput.appendChild(inputBox);
      searchBox.appendChild(searchBoxInput);
      let selectBox = createE('div', ['select-box', mark ? `select-box-${mark}` : '']);
      selectBox.setAttribute('style', 'overflow-y: scroll;');
      let noDataBox = createE('div', ['no-data-box'], no_data || 'No Date');
      noDataBox.setAttribute('style', 'display: none');

      arr.forEach((row,index) => {
        if (!(hidden.target === row[id] && hidden.condition)) {
          for (let child of liRow) {
            child = child.trim()
            child = child.replace(reg, function () {
              return row[arguments[1].trim()]
            })
            let childDom = beE(child);
            let selectItem = createE('div', ['select-item', mark ? `select-item-${mark}` : '']);
            if (row['id'] === currentId) {
              selectItem.classList.add('selected');
            }
            selectItem.setAttribute('data', row['id']);
            selectItem.setAttribute('index', index);
            selectItem.appendChild(childDom)
            selectBox.appendChild(selectItem)
          }
        }
      })

      let $mySelect = this.find(mark ? `.my-select-${mark}`: '.my-select');
      let $myInput = $mySelect.find('input.my-input');
      let $arrowIcon = $mySelect.find('span.arrowIcon')
      
      $mySelect.on('click', function (e) {
        $myInput.blur();
        $('.overlay').show();
        $('.overlay').on('click', function() {
          close();
        })
        $(mark ? `.popup-${mark}`: '.popup').show();
        $(document.body).addClass('overflow-hidden');
        $arrowIcon.addClass('selected');
        let $searchInput = $(mark ? `.popup-${mark}`: '.popup').find('.search-input');
        $myInput.trigger('input');
        $(inputBox).focus();
        $searchInput&&$searchInput.on('input', function () {
          onInputSearch(this.value)
        });
        e.stopPropagation();
      });
      
      function onInputSearch (val) {
        var count = 0
        let $items = $(mark ? `.select-box-${mark}` : '.select-box').find('.select-item')
        if (val != '') {
          $items.each(function (i, v) {
            var contentValue = $(this).attr('data');
            let flag
            let rowObj = arr[i]
            if (isType(searchList, 'Array') && searchList.length) {
              flag = searchList.some(key => {
                if (key !== 'keyword') {
                  return rowObj[key]
                  ? rowObj[key].toLowerCase().indexOf(val.toLowerCase()) !== -1
                  : false
                } else if (key === 'keyword' && rowObj[key]) {
                  return rowObj[key].some(p => p
                    ? p.toLowerCase().indexOf(val.toLowerCase()) !== -1
                    : false)
                }
              });
            } else {
              flag = contentValue.toLowerCase().indexOf(val.toLowerCase()) !== -1
            }
            if (flag) {
              $(this).show()
              
            } else {
              $(this).hide()
              count++
            }
          })
          if (count === $items.length) {
            $(mark ? `.select-box-${mark}` : '.select-box').hide()
            $(noDataBox).show();
          } else {
            $(mark ? `.select-box-${mark}` : '.select-box').show()
            $(noDataBox).hide()
          }
        } else {
          $items.each(function (i) {
            $(this).show()
          })
          $(mark ? `.select-box-${mark}` : '.select-box').show();
          $(noDataBox).hide();
        }
      };
      function close() {
        $arrowIcon.removeClass('selected');
        $('.overlay').hide();
        $(mark ? `.popup-${mark}`: '.popup').hide();
        $(document.body).removeClass('overflow-hidden');
        if ($('.overlay')) {
          $('.overlay').off('click');
        }
      }
      function init () {
        let obj = arr.find(v => v[id] === currentId)
        if (obj) {
          inputVal = obj[label]
        }
        $myInput.val(inputVal);
        topTitle.appendChild(spanTitle);
        topTitle.appendChild(spanClose);
        selectContent.appendChild(topTitle)
        if (showSearch) {
          selectContent.appendChild(searchBox)
        }
        selectContent.appendChild(selectBox)
        selectContent.appendChild(noDataBox)
        popup.appendChild(selectContent);
        popup.setAttribute('style', 'z-index: 2000;display: none;')
        if (!($(document).has('.overlay')).length) {
          document.body.appendChild(overlay);
        }
        document.body.appendChild(popup);
        
        $(mark ? `.popup-${mark}`: '.popup').find('.icon-close').on('click', function() {
          close();
        });
        $('.overlay').on('click', function() {
          close();
        })

        $(mark ? `.popup-${mark}`: '.popup').find('.select-box').find('.select-item').on('click', function (e) {
          let idx = $(mark ? `.popup-${mark}`: '.popup').find('.select-box').find('.select-item').index(this)
          console.log(idx, 'idx')
          inputVal = arr[idx][label]
          $myInput.val(inputVal);
          if (callback) callback(arr[idx]);
          $(this).addClass('selected');
          $($myInput).removeClass('required_error')
          $(this).siblings().removeClass('selected');
          close();
          e.stopPropagation()
        });
      };
      init();
    } else {
      let cssFlag = false;
      if (that.has('.my-select').length) {
        that.find('.my-select').remove()
      }
      const searchBoxHtml = `<div class="search-box search-box-country">
        <div class="search-box-input f-flex justify-content-between align-items-center">
          <div class="icon-search f-flex justify-content-between align-items-center">
            <svg t="1679649806160" class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="4168" width="16" height="16"><path d="M950.4 905.6l-236.8-236.8c54.4-64 86.4-147.2 86.4-236.8C800 227.2 636.8 64 432 64 227.2 64 64 227.2 64 432 64 636.8 227.2 800 432 800c89.6 0 172.8-32 236.8-86.4l236.8 236.8c6.4 6.4 16 9.6 22.4 9.6s16-3.2 22.4-9.6C963.2 937.6 963.2 918.4 950.4 905.6zM432 736C265.6 736 128 598.4 128 432 128 265.6 265.6 128 432 128c166.4 0 304 137.6 304 304C736 598.4 598.4 736 432 736z" p-id="4169" fill="#323233"></path></svg>
          </div>
          <input class="search-input search-input-country f-flex justify-content-between align-items-center" placeholder="${search_text || 'Search'}">
        </div>
      </div>`;
      that.append(`<div class="my-select ${ mark ? `my-select-${mark}` : '' }">
      <span class="iconfont icon-close-circle inputImg delImg hide"></span>
      <input id="input-select-${mark}" readonly="true" data-require="${require}" class="my-input form-input ${inputClass}" placeholder="${selectPlaceHolder || select_text || 'select'}" type="text" />
      <span class="inputImg arrowIcon">
        <svg class="arrow-down" width="14" height="8" viewBox="0 0 14 8" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M13.5635 1L7.56348 7L1.56348 1" stroke="#12151A" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
      </span>
      <div class="list-box">
        <div style="height: 100%;" class="list-box-content f-flex justify-content-start flex-column">
          ${ showSearch ? searchBoxHtml : '' }
          <ul class="list"></ul>
          <ul class="listT">
            <li> ${no_data || 'No Date'} </li>
          </ul>
        </div>
      </div>
    </div>`);
      loadEle({currentId, load: true});
      let $mySelect = this.find(mark ? `.my-select-${mark}`: '.my-select');
      let $myInput = $mySelect.find('input.my-input');
      $myInput.trigger('input');
      let $listBox = $mySelect.find('div.list-box');
      let $searchBoxInput = $mySelect.find('.search-input-country');
      let $list = $mySelect.find('ul.list');
      let $listT = $mySelect.find('ul.listT')
      let $arrowIcon = $mySelect.find('span.arrowIcon')
      let $delImg = $mySelect.find('span.delImg')
      let options = createE('ul', ['list']);
      arr.forEach(row => {
        if (!(hidden.target === row[id] && hidden.condition)) {
          let liDom =
          row[id] === currentId
            ? createE('li', ['selected'])
            : createE('li', [])

          for (let child of liRow) {
            child = child.trim()
            child = child.replace(reg, function () {
              return row[arguments[1].trim()]
            })
            let childDom = beE(child)
            liDom.appendChild(childDom);
            if (flag === false) w += Number(childDom.style.width.split('p')[0])
          }
          if (!flag) flag = !flag;
          options.appendChild(liDom); 
        }
      })
      $list.replaceWith(options);
      $list = $mySelect.find('ul.list');
      $listBox.css({ top: $myInput.outerHeight() });

      // click my-select 
      $mySelect.on('click', function (e) {
        // $myInput.val('')
        let tar = getEventTarget(e, '.search-input');
        if ($arrowIcon.hasClass('selected') && (!$list.is(':hidden') || !$listT.is(':hidden')) && !tar){
          closeListBox();
          return false
        }
        if (!cssFlag) {
          cssFlag = true
          if ($myInput.outerWidth() > $listBox.outerWidth()) {
            $listBox.css({ minWidth: $myInput.outerWidth() })
          }
        }
        if ($list.is(':hidden') && $listT.is(':hidden')) {
          if ($searchBoxInput&&$searchBoxInput.val()) {
            onInputSearch($searchBoxInput.val());
            $listBox.show();
            $arrowIcon.addClass('selected')
          } else {
            showList()
          }
        }
        // togglePlaceholder()
        e.stopPropagation()
      });
      $list.find('li').on('click', function (e) {
        let idx = $list.find('li').index(this)
        inputVal = arr[idx][label]
        if (callback) callback(arr[idx]);
        $(this).addClass('selected');
        $($myInput).removeClass('required_error')
        $(this)
          .siblings('li')
          .removeClass('selected')
        $myInput.val(inputVal)
        $searchBoxInput.val('')
        arrowIconIsSelected()
        $listBox.hide();
        e.stopPropagation()
      });
      $delImg.on('mouseenter', function (e) {
        if (inputVal !== '') {
          // toggleIcon(true)
          toggleIcon(false)
        }
      })
      $delImg.on('click', function (e) {
        inputVal = ''
        $list.find('li').removeClass('selected')
        arrowIconIsSelected()
        toggleIcon(false)
        togglePlaceholder()
        if (callback) callback('')
        e.stopPropagation()
      });
      $searchBoxInput&&$searchBoxInput.on('mouseenter', function (e) {
        if (inputVal !== '') {
          // toggleIcon(true)
          toggleIcon(false)
        }
      })
      $searchBoxInput&&$searchBoxInput.on('mouseleave', function (e) {
        toggleIcon(false)
      });
      $searchBoxInput&&$searchBoxInput.on('input', function () {
        onInputSearch(this.value)
      });
      $list.find('li').on('mouseenter mouseleave', function (e) {
        $(this).toggleClass('on')
        e.stopPropagation()
      });
      function toggleIcon (isShow = true) {
        if (isShow) {
          $delImg.show()
          $arrowIcon.hide()
        } else {
          $delImg.hide()
          $arrowIcon.show()
        }
      };
      function showList () {
        let $lis = $mySelect.find('ul.list li')
        $lis.each(function (i) {
          $(this).show()
        });
        $listBox.show()
        $list.show()
        $listT.hide()
        $arrowIcon.addClass('selected')
        $searchBoxInput.focus();
      };
      function onInputSearch (val) {
        var count = 0
        let $lis = $mySelect.find('ul.list li')
        if (val != '') {
          $lis.each(function (i, v) {
            var contentValue = $(this).text()
            let flag
            let rowObj = arr[i]
            if (isType(searchList, 'Array') && searchList.length) {
              flag = searchList.some(key => {
                if (key !== 'keyword') {
                  return rowObj[key]
                  ? rowObj[key].toLowerCase().indexOf(val.toLowerCase()) !== -1
                  : false
                } else if (key === 'keyword' && rowObj[key]) {
                  return rowObj[key].some(p => p
                    ? p.toLowerCase().indexOf(val.toLowerCase()) !== -1
                    : false)
                }
              });
            } else {
              flag = contentValue.toLowerCase().indexOf(val.toLowerCase()) !== -1
            }
            if (flag) {
              $(this).show()
            } else {
              $(this).hide()
              count++
            }
          })
          if (count === $lis.length) {
            $list.hide()
            $listT.show()
          } else {
            $list.show()
            $listT.hide()
          }
        } else {
          showList()
        }
      };
      function arrowIconIsSelected () {
        $arrowIcon.removeClass('selected')
      }
      function togglePlaceholder () {
        if (inputVal) {
          $myInput.attr({ placeholder: inputVal })
        } else {
          $myInput.attr({ placeholder: '' })
        }
      }
      function closeListBox() {
        arrowIconIsSelected();
        $myInput.blur();
        $listBox.hide();
      }
      function init () {
        let obj = arr.find(v => v[id] === currentId)
        if (obj) {
          inputVal = obj[label]
        }
        $myInput.val(inputVal);
        document.addEventListener('click', function(e) {
          let tar1 = getEventTarget(e, '.list-box');
          let tar2 = getEventTarget(e, '.my-select');
          if (!tar1 && !tar2) { 
            closeListBox();
          }
        }, true);
      };
      init();
    }
    function isType (target, type) {
      return Object.prototype.toString.call(target).slice(8, -1) === type
    }
    function isMobile() {
      return 'navigator' in window && window.navigator.userAgent.match(/(iPad)|(iPhone)|(iPod)|(Android)|(PlayBook)|(BB10)|(BlackBerry)|(Opera Mini)|(IEMobile)|(webOS)|(MeeGo)/i);
    }
    function createE (tab, cls = null, txt) {
      let t = document.createElement(tab)
      if (cls.length) {
        cls.forEach(v => t.classList.add(v))
      }
      if (txt) t.innerText = txt
      return t
    }
    function beE (template) {
      let tempNode = document.createElement('div')
      tempNode.innerHTML = template
      return tempNode.firstChild
    }
    
  }
})(jQuery);