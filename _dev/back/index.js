/**
 * 2007-2019 PrestaShop.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License 3.0 (AFL-3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
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
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License 3.0 (AFL-3.0)
 * International Registered Trademark & Property of PrestaShop SA
 */
import Pickr from '@simonwep/pickr';
import Vue from 'vue/dist/vue.min';

import 'material-design-icons/iconfont/material-icons.css';
import '@simonwep/pickr/dist/themes/classic.min.css';
import './back.scss';

window.Vue = Vue;

$(window).ready(() => {
  // Tab Content
  let imgSelected;
  // Tab Content : Change position
  $('.listing-body').sortable({
    update() {
      const blocks = [];
      $('.listing-general-rol').each(() => {
        blocks.push($(this).attr('data-block'));
      });

      $.ajax({
        type: 'POST',
        dataType: 'JSON',
        url: window.psr_controller_block_url,
        data: {
          ajax: true,
          action: 'UpdatePosition',
          blocks,
        },
        success(data) {
          if (data === 'success') {
            window.showSuccessMessage(window.successPosition);
          } else {
            window.showErrorMessage(window.errorPosition);
          }
        },
      });
    },
  });

  // Tab Content : Set active/inactive
  $(document).on('click', '.listing-row .switch-input', (e) => {
    const switchIsOn = $(e.target).hasClass('-checked');
    const status = switchIsOn ? 1 : 0;

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
      url: window.psr_controller_block_url,
      type: 'POST',
      dataType: 'JSON',
      async: false,
      data: {
        controller: window.psr_controller_block,
        action: 'changeBlockStatus',
        idpsr: $(e.target).parent().attr('data-cart_psreassurance_id'),
        status,
        ajax: true,
      },
      success: (data) => {
        if (data === 'success') {
          window.showNoticeMessage(window.block_updated);
        } else {
          window.showErrorMessage(window.active_error);
        }
      },
    });
  });

  // Tab Content : Add
  $(document).on('click', '.psre-add', () => {
    $('.landscape').show();

    $('#reminder_listing').removeClass('active').addClass('inactive');
    $('#blockDisplay').removeClass('inactive').addClass('active');
    $('.show-rea-block').removeClass('active').addClass('inactive');

    $('.panel-body-0').removeClass('inactive').addClass('active');
    $('#saveContentConfiguration').attr('data-id', '');

    $('.limit_text:visible').text($('.show-rea-block.active .content_by_lang:visible input[type="text"]').val().length);
    $('.limit_description:visible').text($('.show-rea-block.active .content_by_lang:visible textarea').val().length);

    const landscape = $('.panel-body-0 .psr-picto').attr('src');

    if (typeof landscape === 'undefined') {
      $('.psr-picto:visible').hide();
      $('.svg_chosed_here:visible').hide();
      $('.landscape').show();
    }
  });

  // Tab Content : Delete
  $(document).on('click', '.psre-delete', function deleteTabContent() {
    const idBlock = $(this).data('id');

    if (!window.confirm(window.txtConfirmRemoveBlock)) {
      return;
    }
    $.ajax({
      type: 'POST',
      dataType: 'JSON',
      url: window.psr_controller_block_url,
      data: {
        ajax: true,
        action: 'DeleteBlock',
        idBlock,
      },
      success(data) {
        if (data === 'success') {
          // Remove line
          $(`div[data-block="${idBlock}"]`).remove();
        } else {
          window.showErrorMessage(window.errorRemove);
        }
      },
      error(err) {
        console.log(err);
      },
    });
  });

  // Tab Content : Edit
  $(document).on('click', '.psre-edit', function editTabContent() {
    $('.landscape').hide();

    $('#reminder_listing').removeClass('active').addClass('inactive');
    $('#blockDisplay').removeClass('inactive').addClass('active');
    $('.show-rea-block').removeClass('active').addClass('inactive');

    const id = $(this).data('id');
    $(`.panel-body-${id}`).removeClass('inactive').addClass('active');
    $('#saveContentConfiguration').attr('data-id', id);

    $('.limit_text:visible').text($('.show-rea-block.active .content_by_lang:visible input[type="text"]').val().length);
    $('.limit_description:visible').text($('.show-rea-block.active .content_by_lang:visible textarea').val().length);

    const landscape = $(`.panel-body-${id} .psr-picto`).attr('src');

    if (typeof landscape === 'undefined') {
      $('.psr-picto:visible').hide();
      $('.svg_chosed_here:visible').hide();
      $('.landscape').show();
    }
  });

  // Tab Content : Edit : Language
  $(document).on('change', 'select[name="psr-language"]', (e) => {
    const lang = $(e.target).val();

    $('.content_by_lang').removeClass('active').addClass('inactive');
    $(`.content_by_lang.lang-${lang}`).addClass('active');
    $('.limit_text:visible').text($('.show-rea-block.active .content_by_lang:visible input[type="text"]').val().length);
    $('.limit_description:visible').text($('.show-rea-block.active .content_by_lang:visible textarea').val().length);
  });

  // Tab Content : Edit : Modify icon
  $(document).on('click', '.modify_icon', (e) => {
    const position = $(e.target).offset();
    const offset = $(e.target).width();
    const top = position.top / 2;
    const left = position.left / 2 - offset;

    $('#reassurance_block')
      .show().css('top', `${top}px`).css('left', `${left}px`);
  });

  // Tab Content : Edit : Modify icon : Click outside
  $(document).on('click', 'body', (e) => {
    const isInside = $(e.target).closest('.modify_icon').length;
    const isPopin = $(e.target).closest('#reassurance_block').length;

    if (!isInside && !isPopin) {
      $('#reassurance_block').fadeOut(300);
    }
  });

  // Tab Content : Edit : Modify icon : Tabs
  $(document).on('click', '#reassurance_block .category_select div img', (e) => {
    const category = $(e.target).attr('data-id');
    // Change the tab
    $('#reassurance_block .category_select div').removeClass('active');
    $(e.target).parent().addClass('active');
    // Change the tab content
    $('#reassurance_block .category_reassurance').removeClass('active');
    $(`#reassurance_block .cat_${category}`).addClass('active');
  });

  // Tab Content : Edit : Select icon
  $(document).on('click', '#reassurance_block .category_reassurance .svg', (e) => {
    const svg = $(e.target)[0].outerHTML;

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
  $(document).on('click', '#reassurance_block .select_none', () => {
    const psrPicto = $('.psr-picto:visible');
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
  $(document).on('change', '.show-rea-block.active input[type="file"]', function editTabContentCustomIcon() {
    const {files} = $(this)[0];
    // Change the label
    const jqLabel = $(this).parents('.input-group').find('label.file_label');
    let label = jqLabel.attr('data-label');

    if (files.length === 1) {
      label = `${files.length} file selected`;
    }
    jqLabel.html(label);

    // Preview the image
    const idPreview = $(this).attr('data-preview');

    if (files && files[0]) {
      const reader = new FileReader();
      reader.onload = (e) => {
        const jqPreview = $(`.${idPreview}`);

        if (jqPreview.hasClass('hide')) {
          jqPreview.removeClass('hide');
        }
        jqPreview.attr('src', e.target.result);
      };
      reader.readAsDataURL(files[0]);

      [imgSelected] = files;

      // Hide the initial icon
      $('.landscape').hide();
      $('.psr-picto').hide();
      $('.picto_by_module').hide();
      // Show the image
      $('.svg_chosed_here').show();
    }
  });

  // Tab Content : Edit : MaxLength
  $(document).on('keyup keydown', '.show-rea-block.active .content_by_lang input[type="text"], .show-rea-block.active .content_by_lang textarea', function editTabContentMaxLength() {
    const maxLength = 100;
    const val = $(this).val();
    let valLength = val.length;

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
  $(document).on('click', '#blockDisplay .refreshPage', () => {
    window.location.reload();
  });

  // Tab Content : Edit : Redirect
  $(document).on('change', 'input[name^="PSR_REDIRECTION_"]', (e) => {
    function setEnabledPSR(psr, state) {
      if (state) {
        $(`.psr-${psr}`).removeClass('inactive').addClass('active');
      } else {
        $(`.psr-${psr}`).removeClass('active').addClass('inactive');
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
      default:
        break;
    }
  });

  // Tab Content : Edit : Redirect : URL
  $(document).on('keyup', '.block_url:visible', (e) => {
    const url = $(e.target).val();
    const patternForUrl = /(http(s)?:\/\/.)?(www\.)?[-a-zA-Z0-9@:%._+~#=]{2,256}\.[a-z]{2,6}\b([-a-zA-Z0-9@:%_+.~#?&//=]*)/g;
    const patternForHttp = /(http(s)?:\/\/)/g;

    // If it is a real URL :
    if (patternForUrl.test(url)) {
      $(e.target).css('background', '#fff');
      if (!patternForHttp.test(url)) {
        $(e.target).val(`http://${url}`);
      }
    } else {
      $(e.target).css('background', '#ffecec');
    }
  });

  // Tab Content : Edit : Save
  $(document).on('click', '#saveContentConfiguration', function editTabContentSave() {
    const dataToSave = {};
    const blockId = $(this).attr('data-id');
    const imgIcon = $('.psr_picto_showing:visible img.psr-picto');
    let iconSrc = imgIcon.attr('src');
    const iconReplaced = $('.svg_chosed_here img.svg').attr('src');

    if (typeof iconReplaced !== 'undefined') {
      iconSrc = iconReplaced;
    }

    let minimalData = false;
    $('.show-rea-block.active .content_by_lang').each((index, elem) => {
      const lang = parseInt($(elem).attr('data-lang'), 10);
      const dataType = $(elem).attr('data-type');

      if (!Object.prototype.hasOwnProperty.call(dataToSave, lang)) {
        dataToSave[lang] = {};
      }
      if (!Object.prototype.hasOwnProperty.call(dataToSave[lang], dataType)) {
        dataToSave[lang][dataType] = '';
      }
      if (dataType === 'description') {
        dataToSave[lang][dataType] = $('textarea', elem).val();
      } else if (typeof ($('input', elem).val()) !== 'undefined') {
        dataToSave[lang][dataType] = $('input', elem).val();
      }

      if (!minimalData && lang === window.psr_lang && dataType === 'title' && dataToSave[lang][dataType].length > 0) {
        minimalData = true;
      }
    });

    if (!minimalData) {
      window.showErrorMessage(window.min_field_error);
      return;
    }

    const formData = new FormData();
    formData.append('ajax', true);
    formData.append('action', 'SaveBlockContent');
    formData.append('file', imgSelected);
    formData.append('id_block', blockId);
    formData.append('lang_values', JSON.stringify(dataToSave));
    formData.append('picto', iconSrc);
    formData.append('typelink', $(`input[name="PSR_REDIRECTION_${blockId}"]:checked`).val());
    formData.append('id_cms', $(`select[name="ID_CMS_${blockId}"]`).val());

    $.ajax({
      type: 'POST',
      dataType: 'JSON',
      url: window.psr_controller_block_url,
      contentType: false,
      processData: false,
      data: formData,
      success() {
        window.showSuccessMessage(window.psre_success);
        setTimeout(window.location.reload(), 1800);
      },
    });
  });

  // Tab Display
  new Vue({
    el: '#menu',
    data: {
      selectedTabName: window.currentPage,
    },
    methods: {
      makeActive(item) {
        this.selectedTabName = item;
        window.history.pushState({}, '', `${window.moduleAdminLink.replace(/amp;/g, '')}&page=${item}`);
      },
      isActive(item) {
        if (this.selectedTabName !== item) {
          return false;
        }
        $('.psr_menu').addClass('addons-hide');
        $(`.psr_menu#${item}`).removeClass('addons-hide');

        return true;
      },
    },
  });

  // Tab Display : Save Position
  $(document).on(
    'change',
    'input[name="PSR_HOOK_CHECKOUT"],input[name="PSR_HOOK_HEADER"],input[name="PSR_HOOK_FOOTER"],input[name="PSR_HOOK_PRODUCT"]',
    function updatePosition() {
      let selector;

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
        default:
          selector = '';
      }

      $(`.psr-${selector}-grey`).addClass('active');
      $(`.psr-${selector}-color`).removeClass('active');

      $(this).nextAll(`.psr-${selector}-grey`).removeClass('active');
      $(this).nextAll(`.psr-${selector}-color`).addClass('active');
      savePositionByHook($(this).attr('name'), $(this).val());
    },
  );
  function savePositionByHook(hook, value) {
    $.ajax({
      type: 'POST',
      dataType: 'JSON',
      url: window.psr_controller_block_url,
      data: {
        ajax: true,
        action: 'SavePositionByHook',
        hook,
        value,
      },
      success(data) {
        if (data === 'success') {
          window.showSuccessMessage(window.successPosition);
        } else {
          window.showErrorMessage(window.errorPosition);
        }
      },
    });
  }

  // Tab Appearance
  const pickrComponents = {
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
      save: true,
    },
  };
  const pickr1 = Pickr.create({
    el: '.ps_colorpicker1',
    default: window.psr_icon_color,
    defaultRepresentation: 'HEX',
    closeWithKey: 'Escape',
    adjustableNumbers: true,
    components: pickrComponents,
  });
  pickr1.on('change', () => {
    const pickrColor = pickr1.getColor();
    const hexaColor = pickrColor.toHEXA().toString();
    $('.psr_icon_color').val(hexaColor);
  });

  const pickr2 = Pickr.create({
    el: '.ps_colorpicker2',
    default: window.psr_text_color,
    defaultRepresentation: 'HEX',
    closeWithKey: 'Escape',
    adjustableNumbers: true,
    components: pickrComponents,
  });
  pickr2.on('change', () => {
    const pickrColor = pickr2.getColor();
    const hexaColor = pickrColor.toHEXA().toString();
    $('.psr_text_color').val(hexaColor);
  });

  // Tab Appearance : Save Color
  $(document).on('click', '#saveConfiguration', () => {
    const color1 = $('#color_1').val();
    const color2 = $('#color_2').val();
    $.ajax({
      type: 'POST',
      dataType: 'JSON',
      url: window.psr_controller_block_url,
      data: {
        ajax: true,
        action: 'SaveColor',
        color1,
        color2,
      },
      success(data) {
        if (data === 'success') {
          window.showSuccessMessage(window.psre_success);
        } else {
          window.showErrorMessage(window.active_error);
        }
      },
    });
  });
});
