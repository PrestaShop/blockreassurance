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

$((e) => {
    const pickr1 = Pickr.create({
        el: '.ps_colorpicker1',
        default: psr_icon_color,
        defaultRepresentation: 'HEX',
        closeWithKey: 'Escape',
        adjustableNumbers: true,
        components: {

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
        }
    });

    const pickr2 = Pickr.create({
        el: '.ps_colorpicker2',
        default: psr_text_color,
        defaultRepresentation: 'HEX',
        closeWithKey: 'Escape',
        adjustableNumbers: true,
        components: {

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
        }
    });

    pickr1.on('change', (...args) => {
        let pickrColor = pickr1.getColor();
        let hexaColor = pickrColor.toHEX().toString();
        $('.psr_icon_color').val(hexaColor);
    });
    
    pickr2.on('change', (...args) => {
        let pickrColor = pickr2.getColor();
        let hexaColor = pickrColor.toHEX().toString();
        $('.psr_text_color').val(hexaColor);
    });
});

