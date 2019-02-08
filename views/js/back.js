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
    $(document).on('click', '#modify_icon', function () {
        $('#show_icon').removeClass('inactive');
        $('#show_icon').addClass('active');
    });

    $(document).on('click', '.select-icon', (e) => {
        console.log($(e.target));
        // $('#show_icon').removeClass('active');
        // $('#show_icon').addClass('inactive');
    });

    $(document).on('change', 'input[name="PSR_REDIRECTION"]', (e) => {
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
});

/** 
 *  Set block active or inactive
 */

$(document).on('click', '.listing-row .switch-input', (e) => {
    let status = 1;
    let reassuranceId = $(e.target).parent().attr('data-cart_psreassurance_id');

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
            id : reassuranceId,
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
