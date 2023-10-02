{**
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
 *}

<div class="form-group">
    <div class="col-xs-12 col-sm-12 col-md-5 col-lg-3 first-block">
        <div class="text-right">
            <label class="control-label">
                {l s='Image' d='Modules.Blockreassurance.Admin'}
            </label>
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-7 col-lg-4 first-block">
        <div class="psr_picto_showing input-group col-lg-4">
            <img class="psr-picto picto_by_module svg"
                 src="{if isset($block) && $block['icon']}{$block['icon']}{elseif isset($block) && $block['custom_icon']}{$block['custom_icon']}{/if}"/>
            <div class="svg_chosed_here">
                <img class="image-preview-lang img-thumbnail hide" src="" alt="" width="24px" height="24px"/>
            </div>
            <div>
                <i class="material-icons">landscape</i>
            </div>
            <span class="modify_icon" data-id="{if isset($block)}{$block['id_psreassurance']}{/if}">{l s='Modify icon' d='Modules.Blockreassurance.Admin'}</span>
        </div>
        <div class="input-group upload_file_button">
            <label class="file_label" for="file{if isset($block)}{$block['id_psreassurance']}{/if}" data-label="{l s='or upload file' d='Modules.Blockreassurance.Admin'}">{l s='or upload file' d='Modules.Blockreassurance.Admin'}</label>
            <label class="input-group-btn">
                <span>
                    <i class="icon-file"></i><input id="file{if isset($block)}{$block['id_psreassurance']}{/if}" class="slide_image" data-preview="image-preview-lang" type="file" name="image-lang">
                </span>
            </label>
        </div>
        <div class="help-block">
            {l s='Choose SVG for better customization. Other allowed formats are: .gif, .jpg, .png' d='Modules.Blockreassurance.Admin'}
        </div>
    </div>
    <div class="clearfix"></div>
</div>
