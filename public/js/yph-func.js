(function($) {
    "use strict";
    // confirm on click
    $.fn.confirmOnClick = function(param) {
        var text = param.text;
        this.on('click', function() {
            return confirm(text);
        });
    };

    // horizontal scrolling
    $.fn.horizontalScrollMousewheel = function() {
        if (this[0]) {
            this.mousewheel(function(event, delta) {
                var elem = document.querySelectorAll('.horizontal-scroll');
                var eq = $('.horizontal-scroll').index(this);
                if (elem[eq].scrollWidth > elem[eq].clientWidth) {
                    event.preventDefault();
                    this.scrollLeft -= (delta * 60);
                    if (this.scrollLeft < (elem[eq].scrollWidth - elem[eq].clientWidth)) {
                        if (this.scrollLeft > 0) {
                            // event.preventDefault();
                            // console.log(this.scrollLeft);
                        }
                    }
                }
            });
        }
    };

    // set element to array search
    $.fn.toArrUrl = function() {
        var navLinksArr = [];
        this.each(function() {
            var name = $(this).find('span').text();
            var href = $(this).attr('href');
            var navLink = {
                'name': name,
                'url': href
            };
            navLinksArr.push(navLink);
        });
        navLinksArr.sort(function(a, b) {
            return (a.name > b.name) ? 1 : -1;
        });
        return navLinksArr;
    };

    // customized typeahead
    $.fn.newTypeahead = function(param) {
        var navLinksArr = param.source;
        var formParent;
        if (!param.formParent) {
            formParent = this.parents('form').first();
        }
        else {
            formParent = $('.' + formParent);

        }
        this.typeahead({
            source: navLinksArr,
            valueKey: 'name',
            items: 8,
            menu: '<ul class="typeahead dropdown-menu dropdown-menu-search-result" role="listbox"></ul>',
            item: '<a class="dropdown-item dropdown-item-search-result" href="#" role="option">anu <div>ini</div></a>',
            updater: function (navLinksArr) {
                $(formParent).attr('action', navLinksArr.url);
                return navLinksArr.name;
            },
            minLength: 0,
            showHintOnFocus: true,
            selectOnBlur: false,
            scrollHeight: 0,
            autoSelect: false,
            fitToElement: true,
            afterSelect: function (navLinksArr) {
                // $(formParent).attr('action', navLinksArr.url);
                // return navLinksArr.name;
            },
            afterEmptySelect: $.noop,
            addItem: false,
            delay: 0
        }).on('keyup', this, function (event) {
            if (event.keyCode == 13) {
                if ($(formParent).attr('action') != '') {
                    $(formParent).submit();
                }
            }
        });
        $(document).on('click', '.dropdown-item-search-result', function() {
            if ($(formParent).attr('action') != '') {
                $(formParent).submit();
            }
        });
        $(document).on('mouseout', '.dropdown-menu-search-result', function() {
            $('.dropdown-item-search-result').removeClass('active');
        });
        $(formParent).on('submit', function(e) {
            e.preventDefault();
            if ($(this).attr('action') != '') {
                window.location = $(this).attr('action');
            }
        });
    };

    // save preference ajax
    $.fn.savePreference = function(param) {
        var selElem = this;
        var preferenceUrl = $('.preference-url').attr('href') + '/post'
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var ajaxRequest =  function(param, dataNew) {
            $.ajax({
                type: 'POST',
                context: this,
                url: preferenceUrl,
                data: dataNew ? dataNew : param.data,
                success: function(data) {
                    console.log('pref ' + data['stat'] + ': ' + (jQuery.isEmptyObject(data['msg']) ? 'no changes' : JSON.stringify(data['msg'])));
                }
            });
        }

        ////////////

        // if docReady true
        if (param.docReady) {
            $(document).ready(function() {
                if (selElem[0]) {
                    ajaxRequest(param);
                    if (param.afterSave) {
                        param.afterSave();
                    }
                    if (param.reloadAfterSave) {
                        location.reload(true);
                    }
                }
            });
        }
        else {
            // if onClick true
            if (param.onClick) {
                this.on('click', function(event) {
                    event.preventDefault();
                    var $this = $(this);
                    var dataNew = {};
                    var data = param.data;
                    $.each(data, function(index, value) {
                        var indexNew = index;
                        var valueNew = value($this);
                        dataNew[indexNew] = valueNew;
                    });
                    ajaxRequest(param, dataNew);
                    if (param.afterSave) {
                        param.afterSave($this);
                    }
                    if (param.reloadAfterSave) {
                        location.reload(true);
                    }
                })
            }
        }
    }

})(jQuery);
