/**
* 2007-2019 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
* @author    PrestaShop SA <contact@prestashop.com>
* @copyright 2007-2019 PrestaShop SA
* @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
* International Registered Trademark & Property of PrestaShop SA
*/
$(window).ready(function() {
    $('.landscape').hide();

    $(document).on('click', '.modify_icon', function () {
        var id = $(this).data('id');
        $('#show_icon_'+id).removeClass('inactive');
        $('#show_icon_'+id).addClass('active');
    });

    $(document).on('click', '.select-icon', (e) => {
        var id = $(e.target).data('id');
        $('#show_icon_'+id).removeClass('active');
        $('#show_icon_'+id).addClass('inactive');
        $('.show-rea-block.active .psr-picto').attr('data-image', $(e.target)[0]['innerHTML']);
        $('.show-rea-block.active .psr-picto i').html($(e.target)[0]['innerHTML']);
    });

    $(document).on('change', 'input[name="PSR_REDIRECTION_1"]', (e) => {
        if($(e.target).val() == 0) {
            $('.psr-cms').removeClass('active');
            $('.psr-url').removeClass('active');
            $('.psr-cms').addClass('inactive');
            $('.psr-url').addClass('inactive');
        } else if ($(e.target).val() == 1) {
            $('.psr-url').removeClass('active');
            $('.psr-url').addClass('inactive');
            $('.psr-cms').removeClass('inactive');
            $('.psr-cms').addClass('active');
        } else if ($(e.target).val() == 2) {
            $('.psr-cms').removeClass('active');
            $('.psr-cms').addClass('inactive');
            $('.psr-url').removeClass('inactive');
            $('.psr-url').addClass('active');
        }
    });

    $(document).on('change', 'input[name="PSR_REDIRECTION_2"]', (e) => {
        if($(e.target).val() == 0) {
            $('.psr-cms').removeClass('active');
            $('.psr-url').removeClass('active');
            $('.psr-cms').addClass('inactive');
            $('.psr-url').addClass('inactive');
        } else if ($(e.target).val() == 1) {
            $('.psr-url').removeClass('active');
            $('.psr-url').addClass('inactive');
            $('.psr-cms').removeClass('inactive');
            $('.psr-cms').addClass('active');
        } else if ($(e.target).val() == 2) {
            $('.psr-cms').removeClass('active');
            $('.psr-cms').addClass('inactive');
            $('.psr-url').removeClass('inactive');
            $('.psr-url').addClass('active');
        }
    });

    $(document).on('change', 'input[name="PSR_REDIRECTION_3"]', (e) => {
        if($(e.target).val() == 0) {
            $('.psr-cms').removeClass('active');
            $('.psr-url').removeClass('active');
            $('.psr-cms').addClass('inactive');
            $('.psr-url').addClass('inactive');
        } else if ($(e.target).val() == 1) {
            $('.psr-url').removeClass('active');
            $('.psr-url').addClass('inactive');
            $('.psr-cms').removeClass('inactive');
            $('.psr-cms').addClass('active');
        } else if ($(e.target).val() == 2) {
            $('.psr-cms').removeClass('active');
            $('.psr-cms').addClass('inactive');
            $('.psr-url').removeClass('inactive');
            $('.psr-url').addClass('active');
        }
    });

    $(document).on('click', '.psre-edit', function () {
        
        $('#reminder_listing').removeClass('active');
        $('#reminder_listing').addClass('inactive');

        $('#blockDisplay').removeClass('inactive');
        $('#blockDisplay').addClass('active');

        $('.show-rea-block').removeClass('active');
        $('.show-rea-block').addClass('inactive');
        var id = $(this).data('id');
        let landscape = $('.panel-body-'+ id+' .psr-picto').attr('data-img-url');
        let landscape2 = $('.panel-body-'+ id+' .psr-picto').attr('src');
        $('.panel-body-' + id).removeClass('inactive');
        $('.panel-body-' + id).addClass('active');

        $('#saveContentConfiguration').attr('data-id', id);

        $('.limit_text:visible').text($('.show-rea-block.active .content_by_lang:visible input[type="text"]').val().length);
        $('.limit_description:visible').text($('.show-rea-block.active .content_by_lang:visible textarea').val().length);

        if(typeof landscape === 'undefined' && landscape2 === 'undefined') {
            $('.psr-picto:visible').hide();
            $('.svg_chosed_here:visible').hide();
            $('.landscape').show();
        }
    });

    $(document).on('change', 'select[name="psr-language"]', (e) => {
        let lang = $(e.target).val();
        
        $('.content_by_lang').removeClass('active');
        $('.content_by_lang').addClass('inactive');
        $('.content_by_lang.lang-'+lang).addClass('active');
        $('.limit_text:visible').text($('.show-rea-block.active .content_by_lang:visible input[type="text"]').val().length);
        $('.limit_description:visible').text($('.show-rea-block.active .content_by_lang:visible textarea').val().length);
    });

    $(document).on('click', '.refreshPage', function () {
        location.reload();
    });
    
});

/** 
 *  Set block active or inactive
 */

$(document).on('click', '.listing-row .switch-input', (e) => {
    let status = 1;

    let switchIsOn = $(e.target).hasClass('-checked');

    $(e.target).parent().find('.switch_text').hide();

    if (switchIsOn) {
        $('input', e.target).attr('checked', false);
        $(e.target).removeClass('-checked');
        $( e.target).parent().find('.switch-off').show();
    } else {
        $('input', e.target).attr('checked', true);
        $(e.target).addClass('-checked');
        $(e.target).parent().find('.switch-on').show();
    }

    if ($(e.target).hasClass('-checked')) {0
        status = 0;
        $(e.target).removeClass('-checked');
    } else {
        $(e.target).addClass('-checked');
    }

    $.ajax({
        type: 'POST',
        url: psr_controller_block_url,
        dataType: 'html',
        async: false,
        data: {
            controller : psr_controller_block,
            action : 'changeBlockStatus',
            idpsr : $(e.target).parent().attr('data-cart_psreassurance_id'),
            status : status,
            ajax : true,
        },
        success : (data) => {
            $.growl.notice({
                title: "",
                size: "large",
                message: block_updated
            });
        }, 
        error : (data) => {
            $.growl.error({
                title: "",
                size: "large",
                message: active_error
            });
        }
    });

})

/**
 *  Switch management
 */

$(document).on('click', '.switch-input', (e) => {
    let switchIsOn = $(e.target).hasClass('-checked');

    $(e.target).parent().find('.switch_text').hide();

    if (switchIsOn) {
        $('input', e.target).attr('checked', false);
        $(e.target).removeClass('-checked');
        $( e.target).parent().find('.switch-off').show();
    } else {
        $('input', e.target).attr('checked', true);
        $(e.target).addClass('-checked');
        $(e.target).parent().find('.switch-on').show();
    }
})


$(document).on('change', '.show-rea-block.active .slide_image', function (e) {
    let input = this;
    let id = $(this).attr('data-preview');
    
    if (input.files && input.files[0]) {

        var reader = new FileReader();

        reader.onload = function (e) {
            if ($('.'+id).hasClass('hide')) {
                $('.'+id).removeClass('hide');
            }
            $('.'+id).attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
        $(".show-rea-block.active .slide_url").attr('value', input.files[0].name);
        $('.psr-picto').show();
        $('.picto_by_module').hide();
    }
});

$(".show-rea-block.active .slide_url").each(function() {
    var str = $(this).attr('value');
    var delimiter = '/';
    var split = str.split(delimiter);
    var image_name = split[split.length-1];
    $(this).attr('value', image_name);
});

$(document).on('change', '.show-rea-block.active :file', function() {
    var input = $(this),
    numFiles = input.get(0).files ? input.get(0).files.length : 1,
    label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
    input.trigger('fileselect', [numFiles, label]);
});

$('.show-rea-block.active :file').on('fileselect', function(event, numFiles, label) {
    var input = $(this).parents('.input-group').find(':text'),
    log = numFiles > 1 ? numFiles + ' files selected' : label;

    if(input.length) {
        input.val(log);
    } else {
        if(log) alert(log);
    }
});

$(document).on('click', '.show-rea-block.active .select-none', function () {
    $('.show-rea-block.active .psr-picto').attr('data-image', 'landscape');
    $('.show-rea-block.active .psr-picto i').html('landscape');
});


/**
 *  Close popin Reassurance if click outside
*/ 
$(document).on('click', 'body', (e) => {
    let isInside = $(e.target).closest('.modify_icon').length;
    let isPopin = $(e.target).closest('#reassurance_block').length;

    if (!isInside && !isPopin) {
        $("#reassurance_block").fadeOut(300);
    }
});

/**
 *  Show popin Reassurance and move it into the right place
 */
$(document).on('click', '.modify_icon', (e) => {
    let position = $(e.target).offset();
    let offset = $(e.target).width();
    let top = position.top/2;
    let left = position.left/2 - offset;

    $('#reassurance_block').show();
    $('#reassurance_block').css('top', top+'px');
    $('#reassurance_block').css('left', left+'px');
});

 /*
*   Reassurance Block select category
*/
   $(document).on('click', '#reassurance_block .category_select div i', (e) => {
    let category = $(e.target).attr('data-id');

    $('#reassurance_block .category_select div').removeClass('active');
    $(e.target).parent().addClass('active');

    $('#reassurance_block .category_reassurance').removeClass('active');
    $('#reassurance_block .cat_'+category).addClass('active');
});

/*
*   Reassurance Block select picto
*/
$(document).on('click', '#reassurance_block .category_reassurance svg', (e) => {
    let tagName = $(e.target)[0].tagName;
    let svg = $(e.target)[0].outerHTML;
    let imgUrl = $(e.target).attr('data-img-url');

    if (tagName != 'SVG') {
        svg = $(e.target).closest('svg')[0].outerHTML;
    }

    $('.svg_chosed_here svg').attr('data-img-url', imgUrl);

    $('.picto_by_module').show();
    $('#reassurance_block .category_reassurance svg').removeClass('selected');
    $(e.target).addClass('selected');
    // $('.psr-picto:visible').attr('src', icon);
    $('.svg_chosed_here').show();
    $('.landscape').hide();
    $('.svg_chosed_here:visible').html(svg);
    $('#reassurance_block').fadeOut(300);
    $('.psr-picto').hide();
});

/*
*   Reassurance Block select none
*/
$(document).on('click', '.select_none', (e) => {
    $('#reassurance_block .category_reassurance svg').removeClass('selected');
    $('.psr-picto:visible').attr('src', 'undefined');
    $('.psr_picto_showing:visible svg.replaced-svg').attr('data-img-url', 'undefined');
    $('.svg_chosed_here svg').attr('data-img-url', 'undefined');
    $('.psr-picto:visible').hide();
    $('.svg_chosed_here:visible').hide();
    $('.landscape').show();
    $('#reassurance_block').fadeOut(300);
});

/*
* limiteur input text
*/
$(document).on('keydown', '.show-rea-block.active .content_by_lang input[type="text"]', function () {
    maximum = 100;
    var champ = $(this).val();
    var indic = 0;
    if (champ.length > maximum) {
        $(this).val( $(this).val().substring(0, maximum-1));
    } else {
      indic = champ.length;
    }
    $('.limit_text:visible').text(indic);
});

/*
* limiteur textarea text
*/
$(document).on('keydown', '.show-rea-block.active .content_by_lang textarea', function () {
    maximum = 100;
    var champ = $(this).val();
    var indic = 0;
    if (champ.length > maximum) {
        $(this).val( $(this).val().substring(0, maximum-1));
    } else {
      indic = champ.length;
    }
    $('.limit_description:visible').text(indic);
});

/*
* Add an http if it is missing from the URL
*/
$(document).on('keyup', '.block_url:visible', (e) => {
    let url = $(e.target).val();
    let pattern_for_url = /(http(s)?:\/\/.)?(www\.)?[-a-zA-Z0-9@:%._\+~#=]{2,256}\.[a-z]{2,6}\b([-a-zA-Z0-9@:%_\+.~#?&//=]*)/g
    let pattern_for_http = /(http(s)?:\/\/)/g

    // If it is a real URL : 
    if (pattern_for_url.test(url)) {
        $(e.target).css('background', '#fff');
        if (!pattern_for_http.test(url)) {
            $(e.target).val('http://'+url);
        }
    } else {
        $(e.target).css('background', '#ffecec');
    }
});
