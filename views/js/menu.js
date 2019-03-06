/*
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
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2019 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/
$(window).ready(function() {
    moduleAdminLink = moduleAdminLink.replace(/\amp;/g,'');

    var vMenu = new Vue({
        el: '#menu',
        data: {
            selectedTabName : currentPage,
        },
        methods: {
            makeActive: function(item){
                this.selectedTabName = item;
                window.history.pushState({} , '', moduleAdminLink+'&page='+item );
            },
            isActive : function(item){
                if (this.selectedTabName == item) {
                    $('.psr_menu').addClass('addons-hide');
                    $('#'+item).removeClass('addons-hide');
                    return true;
                }
            }
        }
    });

    $(document).on('change', 'input[name="PSR_HOOK_FOOTER"]', function () {
        $('.psr-footer-grey').addClass('active');
        $('.psr-footer-color').removeClass('active');

        $(this).nextAll('.psr-footer-grey').removeClass('active')
        $(this).nextAll('.psr-footer-color').addClass('active');
        savePositionByHook('PSR_HOOK_FOOTER', $(this).val());
    });

    $(document).on('change', 'input[name="PSR_HOOK_HEADER"]', function () {
        $('.psr-header-grey').addClass('active');
        $('.psr-header-color').removeClass('active');

        $(this).nextAll('.psr-header-grey').removeClass('active')
        $(this).nextAll('.psr-header-color').addClass('active');
        savePositionByHook('PSR_HOOK_HEADER', $(this).val());
    });

    $(document).on('change', 'input[name="PSR_HOOK_PRODUCT"]', function () {
        $('.psr-product-grey').addClass('active');
        $('.psr-product-color').removeClass('active');

        $(this).nextAll('.psr-product-grey').removeClass('active')
        $(this).nextAll('.psr-product-color').addClass('active');
        savePositionByHook('PSR_HOOK_PRODUCT', $(this).val());
    });

    $(document).on('change', 'input[name="PSR_HOOK_CHECKOUT"]', function () {
        $('.psr-checkout-grey').addClass('active');
        $('.psr-checkout-color').removeClass('active');

        $(this).nextAll('.psr-checkout-grey').removeClass('active')
        $(this).nextAll('.psr-checkout-color').addClass('active');
        savePositionByHook('PSR_HOOK_CHECKOUT', $(this).val());
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
            success: function(data) {
                showSuccessMessage(psre_success);
            },
            error: function(err) {
                console.log(err);
            }
        });
    }

    $(document).on('click', '#saveConfiguration', function () {
        $.ajax({
            type: 'POST',
            dataType: 'JSON',
            url: psr_controller_block_url,
            data: {
                ajax: true,
                action: 'SaveColor',
                color1: $('#color_1').val(),
                color2: $('#color_2').val(),
            },
            success: function(data) {
                showSuccessMessage(psre_success);
            },
            error: function(err) {
                console.log(err);
            }
        });
    });

    var image_psre;
    $(document).on('change', '.slide_image', function (e) {
        image_psre = e.target.files[0];
    });

    $(document).on('click', '#saveContentConfiguration', function () {
        
        var block = $('#saveContentConfiguration').attr('data-id');
        let dataToSave = {};

        // $('#reminder_listing').removeClass('inactive');
        // $('#reminder_listing').addClass('active');

        // $('#blockDisplay').removeClass('active');
        // $('#blockDisplay').addClass('inactive');


        $('.show-rea-block.active select[name="psr-language"] option').each( function( index, elem ) {
            let lang = $(elem).val();
            dataToSave[lang] = {};
        });

        $('.show-rea-block.active .content_by_lang').each( function( index, elem ) {
            let lang = $(elem).attr('data-lang');
            let type = $(elem).attr('data-type');

            dataToSave[lang][type] = $('input',elem).val();
        });

        formData = new FormData();
        formData.append('ajax', true);
        formData.append('action', 'SaveBlockContent');
        formData.append('file', image_psre);
        formData.append('id_block', $('#saveContentConfiguration').attr('data-id'));
        formData.append('lang_values', JSON.stringify(dataToSave));
        formData.append('picto', $('.show-rea-block.active .psr-picto').attr('data-image'));
        formData.append('typelink', $('input[name="PSR_REDIRECTION_'+block+'"]:checked').val());
        formData.append('id_cms', $('select[name="ID_CMS_'+block+'"]').val());


        $.ajax({
            type: 'POST',
            dataType: 'JSON',
            url: psr_controller_block_url,
            contentType: false,
            processData: false,
            data: formData,
            // data: {
            //     ajax: true,
            //     action: 'SaveBlockContent',
            //     id_block: $('#saveContentConfiguration').attr('data-id'),
            //     lang_values: JSON.stringify(dataToSave),
            //     picto: $('.show-rea-block.active .psr-picto').attr('data-image'),
            //     typelink: $('input[name="PSR_REDIRECTION_'+block+'"]:checked').val(),
            //     id_cms: $('select[name="ID_CMS_'+block+'"]').val(),
            //     psre_file: bite,
            // },
            success: function(data) {
                showSuccessMessage(psre_success);
            },
            error: function(err) {
                // console.log(err);
            }
        });
    });
});
