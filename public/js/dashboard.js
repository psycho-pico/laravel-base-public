(function($) {
    // "use strict";
    $(document).ready(function() {
        // init
        // tooltip
        $('[data-toggle="tooltip"]').tooltip();

        // horizontal scrolling
        $('.horizontal-scroll').horizontalScrollMousewheel();

        // searchable module
        $('.navbar-search .navbar-search-input').newTypeahead({source: $('.nav-link-searchable').toArrUrl(), formParent: null});

        // fix sidebar menu collapse
        var width = $(document).width();
        if (width >= 768 && !$('.navbar-nav.sidebar').hasClass('toggled')) {
            sidebar_item_collapsed = $('input[name=sidebar_item_collapsed]').val();
            sidebar_item_collapsed_index = $('input[name=sidebar_item_collapsed_index]').val();

            if (!$.isNumeric(sidebar_item_collapsed_index) && $('.nav-item.active').find('.nav-link').attr('data-toggle') == 'collapse') {
                $('.nav-item.active').find('.nav-link').removeClass('collapsed');
                $('.nav-item.active').find('.collapse').addClass('show');
            } else {
                if (($.isNumeric(sidebar_item_collapsed_index) && sidebar_item_collapsed == '0' && $('.nav-item.active').find('.nav-link').attr('data-toggle') == 'collapse')) {
                    sidebar_item_collapsed_index = parseInt(sidebar_item_collapsed_index);
                    $('.nav-link[data-toggle=collapse]').eq(sidebar_item_collapsed_index).removeClass('collapsed');
                    $('.nav-link[data-toggle=collapse]').eq(sidebar_item_collapsed_index).next('.collapse').addClass('show');
                }
            }
        }

        // focus on searchDropdown click
        $('.search-dropdown-mobile-wrapper').on('shown.bs.dropdown', function(e) {
            width = $(document).width();
            if (width < 768) {
                $('.navbar-search-input-mobile').focus()
            }
        });

        // blur page when nav-link clicked
        $('.sidebar-menu-collapse').on('shown.bs.collapse', function(e) {
            width = $(document).width();
            if ($(this).parents('.sidebar').length && (width < 768 || (width >= 768 && $('.sidebar').hasClass('toggled')))) {
                $('.container-fluid').addClass('blur-4');
                $('#wrapper').addClass('disabled');
                $('.sidebar-menus-wrapper').addClass('active');
            }
        });
        $('.sidebar-menu-collapse').on('hide.bs.collapse', function(e) {
            $('.container-fluid').removeClass('blur-4');
            $('#wrapper').removeClass('disabled');
            $('.sidebar-menus-wrapper').removeClass('active');
        });

        // blur page when search dropdown clicked
        $('.blurring-effect-on-popup').on('shown.bs.dropdown', function(e) {
            width = $(document).width();
            if (width < 768) {
                $('.container-fluid').addClass('blur-4');
                $('#wrapper').addClass('disabled');
            }
        });
        $('.blurring-effect-on-popup').on('hide.bs.dropdown', function(e) {
            if ($('.sidebar-menu-collapse.show')[0]) {} else {
                $('.container-fluid').removeClass('blur-4');
                $('#wrapper').removeClass('disabled');
            }
        });

    }); //document ready end


    // confirm before index action
    $('.del-form').confirmOnClick({text: 'Sure want to delete?'});
    $('.burn-btn').confirmOnClick({text: 'Sure want to burn?'});
    $('.restore-btn').confirmOnClick({text: 'Sure want to restore?'});



    // searching
    // clear button on search panel
    $('.clear-search-btn').on('click', function() {
        c = document.location.search.length != 0;
        if (!c) {
            document.getElementById('search-form').reset();
        }
        return c;
    });

    // form search on submit
    $('#search-form').first().on('submit', function(e) {
        e.preventDefault();
        // if not empty form
        $(this).find(":input").filter(function() {
            return !this.value;
        }).attr("disabled", true);
        if ($(this).serialize()) {
            $(this)[0].submit();
        } else {
            $(this).find(":input").filter(function() {
                return !this.value;
            }).attr("disabled", false);
        }
    });

    // sorting in index table
    $('.th-searchable').on('click', function() {
        c = $(this).attr('data-search');
        o = $('input[name=o]').val();
        s = $('input[name=s]').val();

        if (o == c && s == 'asc') {
            $('input[name=s]').val('desc');
        } else {
            $('input[name=s]').val('asc');
        }

        $('input[name=o]').val(c);

        $('#search-form').first().submit();
    });

    // set filtering perpage pagination
    $('.perpage-number').on('click', function(e) {
        e.preventDefault();
        n = parseInt($(this).text());

        if (parseInt($('input[name=perpage]').val()) != n) {
            $('input[name=perpage]').val(n);
            $('#search-form').first().submit();
        }
    });

    // filtering deleted data
    $('.filter-btn').on('click', function(e) {
        e.preventDefault();
        g = $(this).attr('data-filter-group');
        n = $(this).attr('data-filter-name');

        $('input[data-input-grpup=' + g + ']').val('');

        if (!$(this).hasClass('active')) {
            v = 1;
        } else {
            v = 0;
        }
        $('input[name=' + n + ']').val(v);
        $('#search-form').first().submit();
    });



    // save preferences
    // save perpage table pagination onload
    $('input[name=perpage]').savePreference({
        docReady: true,
        data: {
            table_row_per_page: function() {
                var n = $.isNumeric(parseInt($('input[name=perpage]').val())) ? parseInt($('input[name=perpage]').val()) : null;
                return n;
            }
        }
    });

    //save preference sidebar toggled
    $('.sidebar-toggler').savePreference({
        onClick: true,
        data: {
            sidebar_toggled: function() {
                var n = $('.navbar-nav.sidebar').hasClass('toggled') ? 1 : 0;
                return n;
            }
        }
    });

    //save preference sidebar item
    $('.nav-link[data-toggle=collapse]').savePreference({
        onClick: true,
        data: {
            sidebar_item_collapsed: function(ini) {
                var $this = $(ini);
                var n = !$this.hasClass('collapsed') ? 1 : 0;
                return n;
            },
            sidebar_item_collapsed_index: function(ini) {
                var $this = ini;
                var n = $('.nav-link[data-toggle=collapse]').index($this);
                return n;
            }
        }
    });

    //save preference search pannel collapsed
    $('.search-panel-toggler').savePreference({
        onClick: true,
        data: {
            search_panel_collapsed: function(ini) {
                var $this = $(ini);
                var n = !$this.hasClass('collapsed') ? 1 : 0;
                return n;
            }
        }
    });

    //save preference dark mode
    $('.dark-mode-toggler').savePreference({
        onClick: true,
        data: {
            dark_mode: function(ini) {
                var $this = $(ini);
                var n = !$this.hasClass('dark-active') ? 1 : 0;
                return n;
            }
        },
        afterSave: function(ini) {
            var $this = $(ini);
            if ($this.hasClass('dark-active')) {
                $('body').removeClass('dark');
                $this.removeClass('dark-active');
                $this.find('.badge-dark').text('on');
            }
            else {
                $('body').addClass('dark');
                $this.addClass('dark-active');
                $this.find('.badge-dark').text('off');
            }
        }
    });

})(jQuery);
