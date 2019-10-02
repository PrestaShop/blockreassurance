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
$(window).ready(function () {
    // Tab Content
    var imgSelected;
    // Tab Content : Change position
    $('.listing-body').sortable({
        update: function () {
            var blocks = [];
            $('.listing-general-rol').each(function () {
                blocks.push($(this).attr('data-block'));
            });

            $.ajax({
                type: 'POST',
                dataType: 'JSON',
                url: psr_controller_block_url,
                data: {
                    ajax: true,
                    action: 'UpdatePosition',
                    blocks: blocks,
                },
                success: function (data) {
                    if (data == 'success') {
                        showSuccessMessage(successPosition);
                    }  else {
                        showErrorMessage(errorPosition);
                    }
                }
            });
        }
    });

    // Tab Content : Set active/inactive
    $(document).on('click', '.listing-row .switch-input', (e) => {
        var switchIsOn = $(e.target).hasClass('-checked');
        var status = switchIsOn ? 1 : 0;

        $(e.target).parent().find('.switch_text').hide();
        if (switchIsOn) {
            $('input', e.target).attr('checked', false);
            $(e.target).removeClass('-checked');
            $(e.target).parent().find('.switch-off').show();
        } else {
            $('input', e.target).attr('checked', true);
            $(e.target).addClass('-checked');
            $(e.target).parent().find('.switch-on').show();
        }

        $.ajax({
            url: psr_controller_block_url,
            type: 'POST',
            dataType: 'JSON',
            async: false,
            data: {
                controller: psr_controller_block,
                action: 'changeBlockStatus',
                idpsr: $(e.target).parent().attr('data-cart_psreassurance_id'),
                status: status,
                ajax: true,
            },
            success: (data) => {
                if (data === 'success') {
                    showNoticeMessage(block_updated);
                } else {
                    showErrorMessage(active_error);
                }
            }
        });
    });

    // Tab Content : Add
    $(document).on('click', '.psre-add', function () {
      $('.landscape').show();

      $('#reminder_listing').removeClass('active').addClass('inactive');
      $('#blockDisplay').removeClass('inactive').addClass('active');
      $('.show-rea-block').removeClass('active').addClass('inactive');

      $('.panel-body-0').removeClass('inactive').addClass('active');
      $('#saveContentConfiguration').attr('data-id', '');

      $('.limit_text:visible').text($('.show-rea-block.active .content_by_lang:visible input[type="text"]').val().length);
      $('.limit_description:visible').text($('.show-rea-block.active .content_by_lang:visible textarea').val().length);

      var landscape = $('.panel-body-0 .psr-picto').attr('src');
      if (typeof landscape === 'undefined') {
        $('.psr-picto:visible').hide();
        $('.svg_chosed_here:visible').hide();
        $('.landscape').show();
      }
    });

    // Tab Content : Edit
    $(document).on('click', '.psre-edit', function () {
        $('.landscape').hide();

        $('#reminder_listing').removeClass('active').addClass('inactive');
        $('#blockDisplay').removeClass('inactive').addClass('active');
        $('.show-rea-block').removeClass('active').addClass('inactive');

        var id = $(this).data('id');
        $('.panel-body-' + id).removeClass('inactive').addClass('active');
        $('#saveContentConfiguration').attr('data-id', id);

        $('.limit_text:visible').text($('.show-rea-block.active .content_by_lang:visible input[type="text"]').val().length);
        $('.limit_description:visible').text($('.show-rea-block.active .content_by_lang:visible textarea').val().length);

        var landscape = $('.panel-body-' + id + ' .psr-picto').attr('src');
        if (typeof landscape === 'undefined') {
            $('.psr-picto:visible').hide();
            $('.svg_chosed_here:visible').hide();
            $('.landscape').show();
        }
    });

    // Tab Content : Edit : Language
    $(document).on('change', 'select[name="psr-language"]', (e) => {
        var lang = $(e.target).val();

        $('.content_by_lang').removeClass('active').addClass('inactive');
        $('.content_by_lang.lang-' + lang).addClass('active');
        $('.limit_text:visible').text($('.show-rea-block.active .content_by_lang:visible input[type="text"]').val().length);
        $('.limit_description:visible').text($('.show-rea-block.active .content_by_lang:visible textarea').val().length);
    });

    // Tab Content : Edit : Modify icon
    $(document).on('click', '.modify_icon', (e) => {
        let position = $(e.target).offset();
        let offset = $(e.target).width();
        let top = position.top / 2;
        let left = position.left / 2 - offset;

        $('#reassurance_block')
            .show().css('top', top + 'px').css('left', left + 'px');
    });

    // Tab Content : Edit : Modify icon : Click outside
    $(document).on('click', 'body', (e) => {
        let isInside = $(e.target).closest('.modify_icon').length;
        let isPopin = $(e.target).closest('#reassurance_block').length;

        if (!isInside && !isPopin) {
            $("#reassurance_block").fadeOut(300);
        }
    });

    // Tab Content : Edit : Modify icon : Tabs
    $(document).on('click', '#reassurance_block .category_select div img', (e) => {
        var category = $(e.target).attr('data-id');
        // Change the tab
        $('#reassurance_block .category_select div').removeClass('active');
        $(e.target).parent().addClass('active');
        // Change the tab content
        $('#reassurance_block .category_reassurance').removeClass('active');
        $('#reassurance_block .cat_' + category).addClass('active');
    });

    // Tab Content : Edit : Select icon
    $(document).on('click', '#reassurance_block .category_reassurance .svg', (e) => {
        var svg = $(e.target)[0].outerHTML;

        // Popin : select the icon
        $('#reassurance_block .category_reassurance img.svg.selected').removeClass('selected');
        $(e.target).addClass('selected');
        // Hide the initial icon
        $('.landscape').hide();
        $('.psr-picto').hide();
        // Show the image
        $('.svg_chosed_here').show();
        $('.svg_chosed_here:visible').html(svg);
        // Popin : hide it
        $('#reassurance_block').fadeOut(300);
    });

    // Tab Content : Edit : Select none
    $(document).on('click', '#reassurance_block .select_none', (e) => {
        var psrPicto = $('.psr-picto:visible');
        psrPicto.attr('src', 'undefined').hide();

        // Un-select icon in the popin
        $('#reassurance_block .category_reassurance img.svg').removeClass('selected');
        // Hide the icon seected
        $('.svg_chosed_here:visible').hide();
        // Display the landscape icon
        $('.landscape').show();
        // Hide the popin
        $('#reassurance_block').fadeOut(300);
    });

    // Tab Content : Edit : Custom Icon
    $(document).on('change', '.show-rea-block.active input[type="file"]', function (e) {
        var files = $(this)[0].files;
        // Change the label
        var jqLabel = $(this).parents('.input-group').find('label.file_label');
        var label = jqLabel.attr('data-label');
        if (files.length === 1) {
            label = files.length + ' file selected'
        }
        jqLabel.html(label);

        // Preview the image
        var idPreview = $(this).attr('data-preview');
        if (files && files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                var jqPreview = $('.' + idPreview);
                if (jqPreview.hasClass('hide')) {
                    jqPreview.removeClass('hide');
                }
                jqPreview.attr('src', e.target.result);
                console.log(e.target.result)
            };
            reader.readAsDataURL(files[0]);

            imgSelected = files[0];

            // Hide the initial icon
            $('.landscape').hide();
            $('.psr-picto').hide();
            $('.picto_by_module').hide();
            // Show the image
            $('.svg_chosed_here').show();
        }
    });

    // Tab Content : Edit : MaxLength
    $(document).on('keyup keydown', '.show-rea-block.active .content_by_lang input[type="text"], .show-rea-block.active .content_by_lang textarea', function () {
        var maxLength = 100;
        var val = $(this).val();
        var valLength = val.length;
        if (val.length > maxLength) {
            $(this).val(val.substring(0, maxLength - 1));
            valLength = $(this).val().length;
        }
        if ($(this).is('input:text')) {
            $('.limit_text:visible').text(valLength);
        } else {
            $('.limit_description:visible').text(valLength);
        }
    });

    // Tab Content : Edit : Return
    $(document).on('click', '#blockDisplay .refreshPage', function () {
        location.reload();
    });

    // Tab Content : Edit : Redirect
    $(document).on('change', 'input[name^="PSR_REDIRECTION_"]', (e) => {
        function setEnabledPSR(psr, state) {
            if (state) {
                $('.psr-' + psr).removeClass('inactive').addClass('active');
            } else {
                $('.psr-' + psr).removeClass('active').addClass('inactive');
            }
        }

        switch ($(e.target).val()) {
            case '0':
                setEnabledPSR('cms', false);
                setEnabledPSR('url', false);
                break;
            case '1':
                setEnabledPSR('cms', true);
                setEnabledPSR('url', false);
                break;
            case '2':
                setEnabledPSR('cms', false);
                setEnabledPSR('url', true);
                break;
        }
    });

    // Tab Content : Edit : Redirect : URL
    $(document).on('keyup', '.block_url:visible', (e) => {
        var url = $(e.target).val();
        var pattern_for_url = /(http(s)?:\/\/.)?(www\.)?[-a-zA-Z0-9@:%._\+~#=]{2,256}\.[a-z]{2,6}\b([-a-zA-Z0-9@:%_\+.~#?&//=]*)/g;
        var pattern_for_http = /(http(s)?:\/\/)/g;

        // If it is a real URL :
        if (pattern_for_url.test(url)) {
            $(e.target).css('background', '#fff');
            if (!pattern_for_http.test(url)) {
                $(e.target).val('http://' + url);
            }
        } else {
            $(e.target).css('background', '#ffecec');
        }
    });

    // Tab Content : Edit : Save
    $(document).on('click', '#saveContentConfiguration', function () {
        var dataToSave = {};
        var blockId = $(this).attr('data-id');
        var imgIcon = $('.psr_picto_showing:visible img.psr-picto');
        var iconSrc = imgIcon.attr('src');
        var iconReplaced = $('.svg_chosed_here img.svg').attr('src');
        if (typeof iconReplaced !== 'undefined') {
            iconSrc = iconReplaced;
        }

        var minimalData = false;
        $('.show-rea-block.active .content_by_lang').each(function (index, elem) {
            var lang = $(elem).attr('data-lang');
            var type = $(elem).attr('data-type');
            if (!dataToSave.hasOwnProperty(lang)) {
                dataToSave[lang] = {};
            }
            if (!dataToSave[lang].hasOwnProperty(type)) {
                dataToSave[lang][type] = '';
            }
            if (type === 'description') {
                dataToSave[lang][type] = $('textarea', elem).val();
            } else if (typeof($('input', elem).val()) != 'undefined') {
                dataToSave[lang][type] = $('input', elem).val();
            }
            if (!minimalData && lang == psr_lang && type == 'title' && dataToSave[lang][type].length > 0) {
                minimalData = true;
            }
        });
        if (!minimalData) {
            showErrorMessage(min_field_error);
            return;
        }

        var formData = new FormData();
        formData.append('ajax', true);
        formData.append('action', 'SaveBlockContent');
        formData.append('file', imgSelected);
        formData.append('id_block', blockId);
        formData.append('lang_values', JSON.stringify(dataToSave));
        formData.append('picto', iconSrc);
        formData.append('typelink', $('input[name="PSR_REDIRECTION_' + blockId + '"]:checked').val());
        formData.append('id_cms', $('select[name="ID_CMS_' + blockId + '"]').val());

        $.ajax({
            type: 'POST',
            dataType: 'JSON',
            url: psr_controller_block_url,
            contentType: false,
            processData: false,
            data: formData,
            success: function (data) {
                showSuccessMessage(psre_success);
                setTimeout(location.reload(), 1800);
            }
        });
    });

    // Tab Display
    var vMenu = new Vue({
        el: '#menu',
        data: {
            selectedTabName: currentPage,
        },
        methods: {
            makeActive: function (item) {
                this.selectedTabName = item;
                window.history.pushState({}, '', moduleAdminLink.replace(/\amp;/g, '') + '&page=' + item);
            },
            isActive: function (item) {
                if (this.selectedTabName !== item) {
                    return false;
                }
                $('.psr_menu').addClass('addons-hide');
                $('.psr_menu#' + item).removeClass('addons-hide');

                return true;
            }
        }
    });

    // Tab Display : Save Position
    $(document).on('change', 'input[name="PSR_HOOK_CHECKOUT"],input[name="PSR_HOOK_HEADER"],input[name="PSR_HOOK_FOOTER"],input[name="PSR_HOOK_PRODUCT"]', function () {
        var selector = '';
        switch ($(this).attr('name')) {
            case 'PSR_HOOK_CHECKOUT':
                selector = 'checkout';
                break;
            case 'PSR_HOOK_HEADER':
                selector = 'header';
                break;
            case 'PSR_HOOK_FOOTER':
                selector = 'footer';
                break;
            case 'PSR_HOOK_PRODUCT':
                selector = 'product';
                break;
        }

        $('.psr-' + selector + '-grey').addClass('active');
        $('.psr-' + selector + '-color').removeClass('active');

        $(this).nextAll('.psr-' + selector + '-grey').removeClass('active');
        $(this).nextAll('.psr-' + selector + '-color').addClass('active');
        savePositionByHook($(this).attr('name'), $(this).val());
    });
    function savePositionByHook(hook, value) {
        $.ajax({
            type: 'POST',
            dataType: 'JSON',
            url: psr_controller_block_url,
            data: {
                ajax: true,
                action: 'SavePositionByHook',
                hook: hook,
                value: value,
            },
            success: function (data) {
                if (data === 'success') {
                    showSuccessMessage(successPosition);
                } else {
                    showErrorMessage(errorPosition);
                }
            }
        });
    }

    // Tab Appearance
    var pickrComponents = {
        // Main components
        preview: true,
        opacity: false,
        hue: true,

        // Input / output Options
        interaction: {
            hex: false,
            rgba: false,
            hsla: false,
            hsva: false,
            cmyk: false,
            input: true,
            clear: false,
            save: true
        }
    };
    var pickr1 = Pickr.create({
        el: '.ps_colorpicker1',
        default: psr_icon_color,
        defaultRepresentation: 'HEX',
        closeWithKey: 'Escape',
        adjustableNumbers: true,
        components: pickrComponents
    });
    pickr1.on('change', (...args) => {
        let pickrColor = pickr1.getColor();
        let hexaColor = pickrColor.toHEX().toString();
        $('.psr_icon_color').val(hexaColor);
    });

    var pickr2 = Pickr.create({
        el: '.ps_colorpicker2',
        default: psr_text_color,
        defaultRepresentation: 'HEX',
        closeWithKey: 'Escape',
        adjustableNumbers: true,
        components: pickrComponents
    });
    pickr2.on('change', (...args) => {
        let pickrColor = pickr2.getColor();
        let hexaColor = pickrColor.toHEX().toString();
        $('.psr_text_color').val(hexaColor);
    });

    // Tab Appearance : Save Color
    $(document).on('click', '#saveConfiguration', function () {
        var color1 = $('#color_1').val();
        var color2 = $('#color_2').val()
        $.ajax({
            type: 'POST',
            dataType: 'JSON',
            url: psr_controller_block_url,
            data: {
                ajax: true,
                action: 'SaveColor',
                color1: color1,
                color2: color2,
            },
            success: function (data) {
                if (data === 'success') {
                    showSuccessMessage(psre_success);
                } else {
                    showErrorMessage(active_error);
                }
            }
        });
    });
});
