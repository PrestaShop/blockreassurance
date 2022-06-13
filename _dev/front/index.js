/**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License version 3.0
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * @author    PrestaShop SA and Contributors <contact@prestashop.com>
 * @copyright Since 2007 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License version 3.0
 */

import './front.scss';

$(window).ready(() => {
  /**
   * @param {String} imgSrc
   */
  function styleSVG(imgSrc) {
    const imgTarget = $(`.blockreassurance_product img.svg.invisible[src="${imgSrc}"], .blockreassurance img.svg.invisible[src="${imgSrc}"]`);

    if (imgTarget.length === 0) {
      return;
    }

    // Fetch the image
    $.ajax({
      url: imgSrc,
      type: 'GET',
      success(data) {
        if ($.isXMLDoc(data)) {
          // Get the SVG tag, ignore the rest
          let $svg = $(data).find('svg');
          // Add URL in data
          $svg = $svg.attr('data-img-url', imgSrc);
          // Remove any invalid XML tags as per http://validator.w3.org
          $svg = $svg.removeAttr('xmlns:a');
          // Set color defined in backoffice
          $svg.find('path[fill]').attr('fill', window.psr_icon_color);
          $svg.find('path:not([fill])').css('fill', window.psr_icon_color);
          // For each element, replace the svg with specific ID & CSS class
          imgTarget.each(function renderSVG() {
            const imgID = $(this).attr('id');
            const imgClass = $(this).attr('class');
            let $imgSvg = $svg.clone();
            // Add replaced image's ID to the new SVG
            $imgSvg = typeof imgID !== 'undefined' ? $imgSvg.attr('id', imgID) : $imgSvg;
            // Add replaced image's classes to the new SVG
            $imgSvg = typeof imgClass !== 'undefined' ? $imgSvg.attr('class', `${imgClass} replaced-svg`) : $imgSvg.attr('class', ' replaced-svg');
            $imgSvg.removeClass('invisible');
            $(this).replaceWith($imgSvg);
          });
        }
      },
    });
  }

  const imgSrcSvg = $('.blockreassurance_product img.svg, .blockreassurance img.svg').map(function getSrcAttr() {
    return $(this).attr('src');
  }).toArray();
  imgSrcSvg
    .filter((el, pos) => imgSrcSvg.indexOf(el) === pos)
    .forEach(styleSVG);
});
