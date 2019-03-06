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

    $(document).on('change', 'input[name="PSR_REDIRECTION_0"]', (e) => {
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

    $(document).on('click', '.psre-edit', function () {
        
        $('#reminder_listing').removeClass('active');
        $('#reminder_listing').addClass('inactive');

        $('#blockDisplay').removeClass('inactive');
        $('#blockDisplay').addClass('active');

        $('.show-rea-block').removeClass('active');
        $('.show-rea-block').addClass('inactive');
        var id = $(this).data('id');
        $('.panel-body-' + id).removeClass('inactive');
        $('.panel-body-' + id).addClass('active');

        $('#saveContentConfiguration').attr('data-id', id);
    });

    $(document).on('change', 'select[name="psr-language"]', (e) => {
        let lang = $(e.target).val();
        
        $('.content_by_lang').removeClass('active');
        $('.content_by_lang').addClass('inactive');
        $('.content_by_lang.lang-'+lang).addClass('active');
    });

    $(function(){
        jQuery('img.svg').each(function(){
            var $img = jQuery(this);
            var imgID = $img.attr('id');
            var imgClass = $img.attr('class');
            var imgURL = $img.attr('src');
        
            jQuery.get(imgURL, function(data) {
                // Get the SVG tag, ignore the rest
                var $svg = jQuery(data).find('svg');
        
                // Add replaced image's ID to the new SVG
                if(typeof imgID !== 'undefined') {
                    $svg = $svg.attr('id', imgID);
                }
                // Add replaced image's classes to the new SVG
                if(typeof imgClass !== 'undefined') {
                    $svg = $svg.attr('class', imgClass+' replaced-svg');
                }
        
                // Remove any invalid XML tags as per http://validator.w3.org
                $svg = $svg.removeAttr('xmlns:a');
                
                // Check if the viewport is set, else we gonna set it if we can.
                if(!$svg.attr('viewBox') && $svg.attr('height') && $svg.attr('width')) {
                    $svg.attr('viewBox', '0 0 ' + $svg.attr('height') + ' ' + $svg.attr('width'))
                }
        
                // Replace image with new SVG
                $img.replaceWith($svg);
        
            }, 'xml');
        
        });
    });

    $(document).on('click', '.refreshPage', function () {
        console.log('nice');
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

    readURL(this, $(this).attr('data-preview'));
});
function readURL(input, id) {
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
    }
}

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

