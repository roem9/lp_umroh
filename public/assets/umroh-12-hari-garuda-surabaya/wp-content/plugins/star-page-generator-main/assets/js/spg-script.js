(function ($) {
    $(document).ready(function () {
        //sejowoo
        $('.affiliate-default-link').each(function (index) {
            var affLink = $(this);
            var affLinkValue = affLink.val();
            if (index > 0) {
                var lpElement = $('<button>').text('Generate Landing Page').addClass('ui button spg-lp-toggle')
                    .attr('data-title', 'Generate Landing Page')
                    .attr('data-link', affLinkValue)
                    .attr('data-toggle', 'modal')
                    .attr('data-target', 'spg-lp-toggle')
                affLink.parent('.InputAddOn').find('.affiliate-default-link').after(lpElement);
            }
            var shortlinkElement = $('<button>').text('Generate Shortlink ').addClass('ui button spg-shortlink-toggle')
                .attr('data-title', 'Generate Shortlink')
                .attr('data-link', affLinkValue)
                .attr('data-toggle', 'modal')
                .attr('data-target', '.spg-shortlink-toggle')
            affLink.parent().after(shortlinkElement);
        });
        toggleFormAndDiv('affiliate-link-holder');
    });
    $(document).on("click", '#affiliate-link-generator-button', function (e) {
        $('.spg-sejoli-toggle').remove();
        var checkExist = setInterval(function () {
            var affLink = $('#aff-link-0');
            if (affLink.length) {
                // Hentikan pengecekan dan tambahkan elemen baru
                clearInterval(checkExist);

                $('[id^="aff-link-"]').each(function () {
                    // Temukan elemen dengan ID saat ini
                    var affLink = $(this);
                    var id = affLink.attr('id');
                    var num = id.split('-').pop();
                    if (!isNaN(num)) {
                        // <input id="aff-link-0" name="aff-link-0" type="text" value="http://wordpress.test/aff/2/139/" readonly="">
                        //get value from input aff-link
                        var affLinkValue = affLink.val();
                        var product_id = $('#product_id').val();
                        var newElement = $('<button>').text('Generate Shortlink ').addClass('ui blue button spg-shortcut-toggle')
                            .attr('data-title', 'Generate Shortlink')
                            .attr('data-link', affLinkValue)
                            .attr('data-id', product_id)
                            .attr('data-html-id', id);
                        affLink.after(newElement);
                    }
                });
            }
        }, 100); // Cek setiap 100 milidetik
        $('#aff-link-parameter').show().promise().done(function () {
            var product_id = $('#product_id').val();

            $('<button>').text('Generate Sales Page by SPG').addClass('ui primary button spg-sejoli-toggle')
                .attr('data-title', 'Star Page Generator')
                .attr('data-id', product_id)
                .insertAfter('#affiliate-link-holder');

        });
    });
    $(document).on("click", '.spg-edit-trigger', function (e) {
        e.preventDefault();

        // $("#spg-edit-modal").modal("show");

        var spg_id = $(this).data('id');

        // var product_title = $(this).data('title');
        $('#spg_id').val(spg_id);
        if (spg_id !== '') {
            $.post(SPG.ajaxurl, {
                'spg_id': spg_id,
                'action': 'spg_subdomain_form',
            }).done(function (res) {
                var datatable = $('#spg-subdomain-datatable');
                datatable.hide();
                datatable.after(res);
            });

        }
    });
    $(document).on("click", '.spg-delete-trigger', function (e) {
        e.preventDefault();
        var spg_id = $(this).data('id');
        $('#spg_id').val(spg_id);
        if (spg_id !== '') {
            $.post(SPG.ajaxurl, {
                'post': spg_id,
                'action': 'spg_subdomain_delete'
            }).done(function (res) {
                location.reload();
            });

        }
    });
    $(document).on("click", '.spg-status-trigger', function (e) {
        e.preventDefault();
        var spg_id = $(this).data('id');
        $('#spg_id').val(spg_id);
        if (spg_id !== '') {
            $.post(SPG.ajaxurl, {
                'post': spg_id,
                'action': 'spg_subdomain_status'
            }).done(function (res) {
                location.reload();
            });

        }
    });
    $(document).on("click", '.spg-homepage-trigger', function (e) {
        e.preventDefault();
        var spg_id = $(this).data('id');
        $('#spg_id').val(spg_id);
        if (spg_id !== '') {
            $.post(SPG.ajaxurl, {
                'post': spg_id,
                'action': 'spg_subdomain_homepage'
            }).done(function (res) {
                location.reload();
            });

        }
    });
    $(document).on('click', '.spg-sejoli-toggle', function (e) {

        $('#spg-sejoli').trigger('reset');
        $('.alert-holder').html('');

        e.preventDefault();

        $("#spg-form-modal").modal("show");

        var product_id = $(this).data('id');
        var product_title = $(this).data('title');
        $('#product_id').val(product_id);
        $('#product_title').html(product_title);
        if (product_id !== '') {
            $.post(SPG.ajaxurl, {
                'product_id': product_id,
                'action': 'spg_get_form',
            }).done(function (res) {
                console.log(res);
                $('#spg-form-generator').html(res);
                $('<input>').attr('type', 'hidden').attr('name', 'spg_sejoli_product_id').val(product_id).insertAfter('#spg-form-generator input[name="action"]');

            });

        }
    });
    $(document).on('click', '.spg-shortcut-toggle', function (e) {
        $('#spg-sejoli').trigger('reset');
        $('.alert-holder').html('');

        e.preventDefault();

        $("#spg-shortcut-modal").modal("show");

        var html_id = $(this).data('html-id');
        var id = $(this).data('id');
        var title = $(this).data('title');
        var link = $('#' + html_id).val();
        $('#shortcut_id').val(id);
        $('#shortcut_title').html(title + ': ' + link);
        $.post(SPG.ajaxurl, {
            'spg_link': link,
            'product_id': id,
            'action': 'spg_get_shortcut_form',
        }).done(function (res) {
            $('#spg-shortcut-generator').html(res);
            $('<input>').attr('type', 'hidden').attr('name', 'spg_sejoli_product_id').val(product_id).insertAfter('#spg-form-generator input[name="action"]');

        });
    });
    $(document).on('click', '.spg-shortlink-toggle', function (e) {
        $('#spg-sejoli').trigger('reset');
        $('.alert-holder').html('');
        $('#spg-form').remove();

        e.preventDefault();
        var title = $(this).data('title');
        var link = $(this).data('link');
        console.log('modal shortcut link ' + link)
        $('#shortcut_title').html(title + ': ' + link);
        $.post(SPG.ajaxurl, {
            'spg_link': link,
            'action': 'spg_get_shortlink_form',
        }).done(function (res) {
            console.log(res);
            var affiliateLink = $('button.ui.button.spg-shortlink-toggle[data-link="' + link + '"]');

            if (affiliateLink.length > 0) {
                affiliateLink.after(res)
            } else {
                console.log('Elemen tidak ditemukan');
            }
        });
    });
    $(document).on('click', '.spg-lp-toggle', function (e) {
        $('#spg-sejoli').trigger('reset');
        $('.alert-holder').html('');
        $('#spg-form').remove();

        e.preventDefault();
        var title = $(this).data('title');
        var link = $(this).data('link');
        console.log('modal lp by link ' + link)
        $('#shortcut_title').html(title + ': ' + link);
        $.post(SPG.ajaxurl, {
            'spg_link': link,
            'action': 'spg_get_lp_link_form',
        }).done(function (res) {
            console.log(res);
            var affiliateLink = $('button[data-link="' + link + '"]');

            if (affiliateLink.length > 0) {
                affiliateLink.last().parent().after(res)
            } else {
                console.log('Elemen tidak ditemukan');
            }
        });
    });
    subdomainCheck = (subdomain) => {
        let check = ('' == subdomain.toString().replace(/[a-zA-Z-]/g, ''));
        if (false === check) {
            $('#spg-subdomain').removeClass('spg-border-success');
            $('#spg-subdomain').addClass('spg-border-danger');
            $('#spg-notif').html('Hanya huruf dan tanda - yang diperbolehkan.')
            return false;
        }
        return true;
    }
    $(document).on('focus blur', '#spg-subdomain', function () {
        subdomainCheck($(this).val());
    })
    $(document).on('keyup', '#spg-subdomain', function () {
        let sub = $(this);
        let url = SPG.ajaxurl;
        let subdomain = sub.val()
        if (subdomainCheck(subdomain)) {
            var spg_form = $('#spg-form');
            let data = "spg-subdomain=" + subdomain + "&action=spg_check_subdomain&spg_fg=" + $('#spg_fg').val() + "&spg_num=" + spg_form.attr('form_id');
            data += "&spg-shortcut=" + spg_form.attr('spg-shortcut');
            $.post(url, data).done(function (res) {
                if (subdomain.length > 0 && res.status == 'valid') {
                    if (subdomainCheck(sub.val())) {
                        $(sub).addClass('spg-border-success');
                        $(sub).removeClass('spg-border-danger');
                        $('#spg-notif').html(res.message);
                    }
                } else {
                    $(sub).removeClass('spg-border-success');
                    $(sub).addClass('spg-border-danger');
                    $('#spg-notif').html(res.message);
                }
                $('#spg_fg').val(res.token);
            });
        }
    })
    $(document).on('submit', '#spg-form', function (e) {
        e.preventDefault();
        if (!subdomainCheck($(this).find('#spg-subdomain').val())) return false;
        let url = SPG.ajaxurl;
        let form = $(this);
        var data = new FormData();
        //Form data
        var form_data = form.serializeArray();
        $.each(form_data, function (key, input) {
            data.append(input.name, input.value);
        });
        data.append('spg_num', form.attr('form_id'));
        //File data
        var file_data = form.find('input[type="file"]');
        $.each(file_data, function (key, input) {
            var files = $(input).prop('files');
            $.each(files, function (key, file) {
                data.append(input.name, file);
            });
        });

        let btn = form.find('#spg-button');
        btn.remove();
        form.find('.spg-loading').show();
        $.ajax({
            url: url,
            method: "post",
            processData: false,
            contentType: false,
            data: data,
            success: function (res) {
                form.html(res.message);

            },
            error: function (res) {
                form.html(res.message);
            }
        });
    })

    function toggleFormAndDiv(elementId) {
        var element = $('#' + elementId);
        var formElement = $('#affiliate-link-holder');
        var divElement = $('<div>').attr('id', formElement.attr('id')).addClass(formElement.attr('class')).html(formElement.html());
        formElement.replaceWith(divElement);
    }
}(jQuery));

(function ($) {

    // Ripple-effect animation
    $(".ripple-effect").click(function (e) {
        var rippler = $(this);

        rippler.append("<span class='ink'></span>");

        var ink = rippler.find(".ink:last-child");
        // prevent quick double clicks
        ink.removeClass("animate");

        // set .ink diametr
        if (!ink.height() && !ink.width()) {
            var d = Math.max(rippler.outerWidth(), rippler.outerHeight());
            ink.css({
                height: d,
                width: d
            });
        }

        // get click coordinates
        var x = e.pageX - rippler.offset().left - ink.width() / 2;
        var y = e.pageY - rippler.offset().top - ink.height() / 2;

        // set .ink position and add class .animate
        ink.css({
            top: y + 'px',
            left: x + 'px'
        }).addClass("animate");

        // remove ink after 1second from parent container
        setTimeout(function () {
            ink.remove();
        }, 1000)
    })


// Ripple-effect-All animation
    function fullRipper(color, time) {
        setTimeout(function () {
            var rippler = $(".ripple-effect-All");
            if (rippler.find(".ink-All").length == 0) {
                rippler.append("<span class='ink-All'></span>");


                var ink = rippler.find(".ink-All");
                // prevent quick double clicks
                //ink.removeClass("animate");

                // set .ink diametr
                if (!ink.height() && !ink.width()) {
                    var d = Math.max(rippler.outerWidth(), rippler.outerHeight());
                    ink.css({
                        height: d,
                        width: d
                    });
                }

                // get click coordinates
                var x = 0;
                var y = rippler.offset().top - ink.height() / 1.5;

                // set .ink position and add class .animate
                ink.css({
                    top: y + 'px',
                    left: x + 'px',
                    background: color
                }).addClass("animate");

                rippler.css('z-index', 2);

                setTimeout(function () {
                    ink.css({
                        '-webkit-transform': 'scale(2.5)',
                        '-moz-transform': 'scale(2.5)',
                        '-ms-transform': 'scale(2.5)',
                        '-o-transform': 'scale(2.5)',
                        'transform': 'scale(2.5)'
                    })
                    rippler.css('z-index', 0);
                }, 1500);
            }
        }, time)

    }

    // Form control border-bottom line
    $('.blmd-line .form-control').bind('focus', function () {
        $(this).parent('.blmd-line').addClass('blmd-toggled').removeClass("hf");
    }).bind('blur', function () {
        var val = $(this).val();
        if (val) {
            $(this).parent('.blmd-line').addClass("hf");
        } else {
            $(this).parent('.blmd-line').removeClass('blmd-toggled');
        }
    })

    // Change forms
    $(".blmd-switch-button").click(function () {
        var _this = $(this);
        if (_this.hasClass('active')) {
            setTimeout(function () {
                _this.removeClass('active');
                $(".ripple-effect-All").find(".ink-All").remove();
                $(".ripple-effect-All").css('z-index', 0);
            }, 1300);
            $(".ripple-effect-All").find(".ink-All").css({
                '-webkit-transform': 'scale(0)',
                '-moz-transform': 'scale(0)',
                '-ms-transform': 'scale(0)',
                '-o-transform': 'scale(0)',
                'transform': 'scale(0)',
                'transition': 'all 1.5s'
            })
            $(".ripple-effect-All").css('z-index', 2);
            $('#Register-form').addClass('form-hidden')
                .removeClass('animate');
            $('#login-form').removeClass('form-hidden');
        } else {
            fullRipper("#26a69a", 750);
            _this.addClass('active');
            setTimeout(function () {
                $('#Register-form').removeClass('form-hidden')
                    .addClass('animate');
                $('#login-form').addClass('form-hidden');
            }, 2000)

        }
    })
})(jQuery);