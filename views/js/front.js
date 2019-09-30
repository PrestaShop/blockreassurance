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
  $('.blockreassurance_product img.svg, .blockreassurance img.svg').each(function () {
    var imgObject = $(this);
    var imgID = imgObject.attr('id');
    var imgClass = imgObject.attr('class');
    var imgURL = imgObject.attr('src');

    $.ajax({
      url: imgURL,
      type: 'GET',
      success: function(data){
        if ($.isXMLDoc(data)) {
          // Get the SVG tag, ignore the rest
          var $svg = $(data).find('svg');
          // Add replaced image's ID to the new SVG
          $svg = typeof imgID !== 'undefined' ? $svg.attr('id', imgID) : $svg;
          // Add replaced image's classes to the new SVG
          $svg = typeof imgClass !== 'undefined' ? $svg.attr('class', imgClass + ' replaced-svg') : $svg.attr('class', ' replaced-svg');
          $svg.removeClass('invisible');
          // Add URL in data
          $svg = $svg.attr('data-img-url', imgURL);
          // Remove any invalid XML tags as per http://validator.w3.org
          $svg = $svg.removeAttr('xmlns:a');
          // Set color defined in backoffice
          $svg.find('path[fill]').attr('fill', psr_icon_color);
          $svg.find('path:not([fill])').css('fill', psr_icon_color);
          // Replace image with new SVG
          imgObject.replaceWith($svg);
        }
        imgObject.removeClass('invisible');
      }
    });
  });
});
